<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil;
use Urbem\CoreBundle\Entity\Contabilidade\Lancamento;
use Urbem\CoreBundle\Entity\Tesouraria\Autenticacao;
use Urbem\CoreBundle\Entity\Tesouraria\Boletim;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;
use Urbem\CoreBundle\Entity\Tesouraria\TransferenciaEstornada;
use Urbem\CoreBundle\Entity\Tesouraria\VwTransferenciaView;
use Urbem\CoreBundle\Model\Tesouraria\TipoAutenticacaoModel;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Class VwTransferenciaViewModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class VwTransferenciaViewModel extends AbstractModel
{
    /**
     * VwTransferenciaViewModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\VwTransferenciaView');
    }

    /**
     * @param $exercicio
     * @param $codBoletim
     * @param $dtBoletim
     * @param $codReciboExtra
     * @return mixed
     */
    public function getInformacoesTransferencia($exercicio, $codBoletim, $dtBoletim, $codReciboExtra)
    {
        return $this->repository->getPagamentobyCodRecibo($exercicio, $codBoletim, $dtBoletim, $codReciboExtra);
    }

    /**
     * @param $transferencia
     * @param $form
     * @param $exercicio
     */
    public function setTransferenciaEstorno($transferencia, $form, $exercicio)
    {
        try {
            $boletim = $this->entityManager->getRepository(Boletim::class)
                ->findOneBy(['codBoletim' => $form->boletim,'exercicio' => $exercicio,'codEntidade' => $form->entidade]);

            $historico = $this->entityManager->getRepository(HistoricoContabil::class)
                ->findOneBy(['codHistorico' => $form->codHistorico,'exercicio' => $exercicio]);

            $dtBoletim = $boletim->getDtBoletim();
            $repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\Arrecadacao');
            $codAutenticadao = $repository->getCodAutenticacao($dtBoletim->format('d/m/Y'));

            $autenticacao = new Autenticacao();
            $autenticacao->setCodAutenticacao($codAutenticadao);
            $autenticacao->setDtAutenticacao(new DateTimeMicrosecondPK());
            $tp = new TipoAutenticacaoModel($this->entityManager);
            $tipo = $this->entityManager->getRepository('CoreBundle:Tesouraria\TipoAutenticacao')
                ->findOneBy(['codTipoAutenticacao' => $tp::ESTORNO_TRANSFERENCIA]);
            $autenticacao->setFkTesourariaTipoAutenticacao($tipo);
            $this->entityManager->persist($autenticacao);

            $transferenciaEstorno = new TransferenciaEstornada();
            $transferenciaEstorno->setTipo($tp::ESTORNO_TRANSFERENCIA);
            $transferenciaEstorno->setFkContabilidadeHistoricoContabil($historico);
            $transferenciaEstorno->setFkTesourariaBoletim($boletim);
            $transferenciaEstorno->setFkTesourariaUsuarioTerminal($boletim->getFkTesourariaUsuarioTerminal());
            $transferenciaEstorno->setFkTesourariaAutenticacao($autenticacao);
            $transferenciaEstorno->setValor($form->valorEstorno);
            $transferenciaEstorno->setObservacao($form->observacao);

            $transferenciaRepository = $this->entityManager->getRepository(Transferencia::class);
            $transferencia = array_shift($transferencia);

            $nomLote = sprintf(
                'Transferência - CD: %s | CC: %s',
                $transferencia->cod_plano_credito,
                $transferencia->cod_plano_debito
            );

            $codLote = $transferenciaRepository
                ->gerarLote(
                    $exercicio,
                    $form->entidade,
                    $nomLote,
                    $dtBoletim->format('d/m/Y')
                );

            $lancamentoRepository = $this->entityManager->getRepository(Lancamento::class);

            $sequencia = $lancamentoRepository
                ->insereLancamento(
                    $exercicio,
                    $transferencia->cod_plano_debito,
                    $transferencia->cod_plano_credito,
                    $form->valorEstorno,
                    $codLote,
                    $form->entidade,
                    $form->codHistorico,
                    'T',
                    ''
                );

            $lote = $this->entityManager->getRepository('CoreBundle:Contabilidade\Lote')
                ->findOneBy(['codLote' => $codLote,'exercicio' => $exercicio,'tipo' => $tp::TRANSFERENCIA,'codEntidade' => $form->entidade]);

            $transferenciaEstorno->setFkContabilidadeLote($lote);
            $transferenciaEstorno->setCodLote($codLote);

            $transf = $this->entityManager->getRepository(Transferencia::class)
                ->findOneBy(['codLote' => $transferencia->cod_lote]);
            $transferenciaEstorno->setFkTesourariaTransferencia($transf);

            $this->entityManager->persist($transferenciaEstorno);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect(
                "/financeiro/tesouraria/extra-estorno/create"
            );
        }
    }
}
