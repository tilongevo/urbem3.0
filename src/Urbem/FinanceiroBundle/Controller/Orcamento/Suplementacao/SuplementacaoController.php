<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento\Suplementacao;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia;
use Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Suplementacao;
use Urbem\CoreBundle\Model\Orcamento\SuplementacaoReducaoModel;
use Urbem\CoreBundle\Entity\Orcamento\SuplementacaoReducao;
use Urbem\CoreBundle\Model\Orcamento\SuplementacaoSuplementadaModel;
use Urbem\CoreBundle\Entity\Orcamento\SuplementacaoSuplementada;
use Urbem\CoreBundle\Entity\Orcamento\SuplementacaoAnulada;
use Urbem\CoreBundle\Services\Orcamento\Suplementacao\Lancamento;
use Urbem\CoreBundle\Services\Orcamento\Suplementacao\LancamentoFactory;

class SuplementacaoController extends BaseController
{
    public function anularAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();
            list($exercicio, $codSuplementacao) = explode('~', $dataForm['id_suplementacao']);

            $suplementacaoAnular = $em->getRepository('CoreBundle:Orcamento\Suplementacao')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'codSuplementacao' => $codSuplementacao
                ]);

            $tipoTransferencia = $em->getRepository('CoreBundle:Contabilidade\\TipoTransferencia')
                ->findOneBy(['codTipo' => $suplementacaoAnular->getCodTipo(), 'exercicio' => $this->getExercicio()]);

            $suplementacao_model = (new \Urbem\CoreBundle\Model\Orcamento\SuplementacaoModel($em));
            $codSuplementacao = $em->getRepository('CoreBundle:Orcamento\\Suplementacao')
                ->getNewCodSuplementacao($suplementacaoAnular->getExercicio());

            $suplementacao = new Suplementacao();
            $suplementacao->setCodSuplementacao($codSuplementacao);
            $suplementacao->setExercicio($suplementacaoAnular->getExercicio());
            $suplementacao->setCodTipo($suplementacaoAnular->getCodTipo());
            $suplementacao->setMotivo($dataForm['suplementacao']['motivo']);
            $suplementacao->setDtSuplementacao($suplementacaoAnular->getDtSuplementacao());
            $suplementacao->setCodNorma($suplementacaoAnular->getCodNorma());
            $suplementacao->setFkContabilidadeTipoTransferencia($tipoTransferencia);

            $suplementacao_model->save($suplementacao);

            $suplementacao_reducao_model = new SuplementacaoReducaoModel($em);
            $suplementacao_suplementada_model = new SuplementacaoSuplementadaModel($em);
            $suplementacaoSuplementadaAnulada = $em->getRepository('CoreBundle:Orcamento\SuplementacaoSuplementada')
                ->findBy([
                    'exercicio' => $suplementacaoAnular->getExercicio(),
                    'codSuplementacao' => $suplementacaoAnular->getCodSuplementacao()
                ]);

            foreach($suplementacaoSuplementadaAnulada as $suplementada) {
                $suplementacaoReducao = new SuplementacaoReducao();

                $suplementacaoReducao->setFkOrcamentoSuplementacao($suplementacao);
                $suplementacaoReducao->setFkOrcamentoDespesa($suplementada->getFkOrcamentoDespesa());
                $suplementacaoReducao->setValor($suplementada->getValor());

                $suplementacao_reducao_model->save($suplementacaoReducao);

                $suplementacaoSuplementada = new SuplementacaoSuplementada();
                $suplementacaoSuplementada->setFkOrcamentoSuplementacao($suplementacao);
                $suplementacaoSuplementada->setFkOrcamentoDespesa($suplementada->getFkOrcamentoDespesa());
                $suplementacaoSuplementada->setValor($suplementada->getValor());

                $suplementacao_suplementada_model->save($suplementacaoSuplementada);
            }

            $suplementacao_anulada_model = (new \Urbem\CoreBundle\Model\Orcamento\SuplementacaoAnuladaModel($em));

            $suplementacaoAnulada = new SuplementacaoAnulada();
            $suplementacaoAnulada->setFkOrcamentoSuplementacao1($suplementacao);
            $suplementacaoAnulada->setFkOrcamentoSuplementacao($suplementacaoAnular);

            $suplementacao_anulada_model->save($suplementacaoAnulada);

            # Realiza Lançamento

            $transferenciaDespesaRepository = $em->getRepository('CoreBundle:Contabilidade\TransferenciaDespesa')
                ->findOneBy([
                    'codSuplementacao' => $suplementacaoAnular->getCodSuplementacao(),
                    'exercicio' => $suplementacaoAnular->getExercicio(),
                    'codTipo' => $suplementacaoAnular->getCodTipo()
                ]);

            if (is_null($transferenciaDespesaRepository)) {
                $container->get('session')->getFlashBag()->add('error', 'Suplementação não possui transferencia despesa');
                (new RedirectResponse("/financeiro/orcamento/suplementacao/list"))->send();
                exit;
            }

            $entidade = $transferenciaDespesaRepository->getCodEntidade();

            $codNorma = $em->getRepository('CoreBundle:Normas\\Norma')
                ->findOneByCodNorma($suplementacao->getCodNorma());

            $lancamento = new Lancamento(new LancamentoFactory(), $em, $container->get('session'));
            $lancamento->setSubType($suplementacaoAnular->getCodTipo());
            $lancamento->setExercicio($this->getExercicio());
            $lancamento->setEntidade($entidade);
            $lancamento->setDescricaoDecreto($codNorma);

            // Realiza o lancamento
            $lancamento->execute();

            if (is_null($lancamento->getCodLote()) || is_null($lancamento->getSequencia())) {
                $container->get('session')->getFlashBag()->add('error', 'Erro ao gerar o lote e a sequencia.');
                return false;
            }

            $lancamentoObj = $em->getRepository('CoreBundle:Contabilidade\\Lancamento')
                ->findOneBy([
                    'sequencia' => $lancamento->getSequencia(),
                    'codLote' => $lancamento->getCodLote(),
                    'tipo' => 'S',
                    'exercicio' => $this->getExercicio()
                ]);

            # Realiza transferência
            $lancamentoTransferencia = new LancamentoTransferencia();
            $lancamentoTransferencia->setFkContabilidadeLancamento($lancamentoObj);
            $lancamentoTransferencia->setFkContabilidadeTipoTransferencia($tipoTransferencia);

            $em->persist($lancamentoTransferencia);

            $transferenciaDespesa = new TransferenciaDespesa();
            $transferenciaDespesa->setFkOrcamentoSuplementacao($suplementacao);
            $transferenciaDespesa->setFkContabilidadeLancamentoTransferencia($lancamentoTransferencia);

            $em->persist($transferenciaDespesa);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', 'Anulação de suplementação realizada com sucesso.');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao anular suplementação.');
            throw $e;
        }

        (new RedirectResponse("/financeiro/orcamento/suplementacao/list"))->send();
        exit;
    }
}
