<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade\LancamentoContabil;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Contabilidade\ContaCredito;
use Urbem\CoreBundle\Entity\Contabilidade\ContaDebito;
use Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento;
use Urbem\CoreBundle\Model\Contabilidade\LoteModel;

class AberturaOrcamentoAnualController extends BaseController
{
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();
        $form = $this->generateForm($data);

        $form->handleRequest($request);

        return $this->render(
            'FinanceiroBundle::Contabilidade/LancamentoContabil/AberturaOrcamentoAnual/index.html.twig',
            array('form' => $form->createView())
        );
    }

    private function generateForm($data)
    {
        $exercicio = $this->getExercicio();

        $form = $this->createFormBuilder($data)
            ->add(
                'codEntidade',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'label' => 'label.implantacaoSaldo.codEntidade',
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters ',
                    ),
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        $qb->orderBy('o.codEntidade', 'ASC');
                        return $qb;
                    }
                )
            )
            ->setAction($this->generateUrl('contabilidade_lancamento_contabil_abertura_orcamento_anual_grid'))
            ->getForm();

        return $form;
    }

    public function gridAction(Request $request)
    {
        $container = $this->container;

        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();
        $exercicio = $this->getExercicio();

        $formData = $request->request->get('form');

        $codEntidade = (integer) $formData['codEntidade'];
        $entidade = $em->getRepository('CoreBundle:Orcamento\Entidade')
            ->findOneBy([
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade
            ]);

        $dtLancamento = mktime(0, 0, 0, 1, 2, $exercicio);
        $dtLancamento = date('d/m/Y', $dtLancamento);

        $saldosIniciais = $em->getRepository('CoreBundle:Contabilidade\PlanoConta')
            ->recuperaSaldoInicialContas($exercicio, $codEntidade);

        $receitaBrutaOrcadaExercicio = 0.00;
        $fundeb = 0.00;
        $renuncia = 0.00;
        $outrasDeducoes = 0.00;
        $despesaPrevistaExercicio = 0.00;

        foreach ($saldosIniciais as $saldosInicial) {
            $vlLancamento = (float) $saldosInicial['vl_lancamento'];
            if ($vlLancamento < 0) {
                $vlLancamento = $vlLancamento * -1;
            }
            $vlLancamento = number_format($vlLancamento, 2, '.', ',');
            $codEstrutural = $saldosInicial['cod_estrutural'];
            if (($codEstrutural == '5.2.1.1.1.00.00.00.00.00') || ($codEstrutural == '5.2.1.1.1.00.00.00.00.00')) {
                $receitaBrutaOrcadaExercicio = $vlLancamento;
            } elseif ($codEstrutural == '5.2.1.1.2.01.01.00.00.00') {
                $fundeb = $vlLancamento;
            } elseif ($codEstrutural == '5.2.1.1.2.02.00.00.00.00') {
                $renuncia = $vlLancamento;
            } elseif ($codEstrutural == '5.2.1.1.2.99.00.00.00.00') {
                $outrasDeducoes = $vlLancamento;
            } elseif (($codEstrutural == '5.2.2.1.1.01.00.00.00.00') || ($codEstrutural == '6.2.2.1.1.00.00.00.00.00')) {
                $despesaPrevistaExercicio = $vlLancamento;
            }
        }

        $campos = array();

        $campos[] = array(
            'name' => 'receitaBrutaOrcadaExercicio',
            'title' => 'Receita Bruta Orçada para o Exercício',
            'data' => $receitaBrutaOrcadaExercicio
        );

        $campos[] = array(
            'name' => null,
            'title' => 'Receita Dedutora Bruta Orçada para o Exercício',
            'data' => null
        );

        $campos[] = array(
            'name' => 'fundeb',
            'title' => 'Fundeb',
            'data' => $fundeb
        );

        $campos[] = array(
            'name' => 'renuncia',
            'title' => 'Renúncia',
            'data' => $renuncia
        );

        $campos[] = array(
            'name' => 'outrasDeducoes',
            'title' => 'Outras Deduções',
            'data' => $outrasDeducoes
        );

        $campos[] = array(
            'name' => 'despesaPrevistaExercicio',
            'title' => 'Despesa Prevista para o Exercício',
            'data' => $despesaPrevistaExercicio
        );

        try {
            return $this->render(
                'FinanceiroBundle::Contabilidade/LancamentoContabil/AberturaOrcamentoAnual/grid.html.twig',
                array(
                    'entidade' => $entidade,
                    'dtLancamento' => $dtLancamento,
                    'campos' => $campos
                )
            );
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
        }

        return $this->redirectToRoute('contabilidade_lancamento_contabil_abertura_orcamento_anual');
    }

    public function gravarAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();

            $exercicio = $dataForm['exercicio'];
            $codEntidade = (int) $dataForm['codEntidade'];

            $contas = array(
                'receitaBrutaOrcadaExercicio' => array (
                    'contaDebito' => '5.2.1.1.1.00.00.00.00.00',
                    'contaCredito' => '6.2.1.1.0.00.00.00.00.00',
                    'codHistorico' => '220',
                    'nomLote' => 'Abertura Orçamento Receita Bruta'
                ),
                'fundeb' => array (
                    'contaDebito' => '6.2.1.1.0.00.00.00.00.00',
                    'contaCredito' => '5.2.1.1.2.01.01.00.00.00',
                    'codHistorico' => '222',
                    'nomLote' => 'Abertura Orçamento Receita Dedutora'
                ),
                'renuncia' => array (
                    'contaDebito' => '6.2.1.1.0.00.00.00.00.00',
                    'contaCredito' => '5.2.1.1.2.02.00.00.00.00',
                    'codHistorico' => '222',
                    'nomLote' => 'Abertura Orçamento Receita Dedutora'
                ),
                'outrasDeducoes' => array (
                    'contaDebito' => '6.2.1.1.0.00.00.00.00.00',
                    'contaCredito' => '5.2.1.1.2.99.00.00.00.00',
                    'codHistorico' => '222',
                    'nomLote' => 'Abertura Orçamento Receita Dedutora'
                ),
                'despesaPrevistaExercicio' => array (
                    'contaDebito' => '5.2.2.1.1.01.00.00.00.00',
                    'contaCredito' => '6.2.2.1.1.00.00.00.00.00',
                    'codHistorico' => '221',
                    'nomLote' => 'Abertura Orçamento Despesa'
                )
            );

            $repository = $em->getRepository('CoreBundle:Contabilidade\PlanoConta');

            $modelLote = new LoteModel($em);
            $dtLote = new \DateTime($exercicio . '-1-2');

            foreach ($contas as $key => $value) {
                $nomLote = $value['nomLote'];
                $lote = $modelLote->getOrCreateLote($exercicio, $dtLote, 'M', $codEntidade, $nomLote);

                $modelLote->removeLancamento($exercicio, $codEntidade, $lote->getCodLote(), 'M');
            }

            foreach ($contas as $key => $value) {
                $nomLote = $value['nomLote'];
                $lote = $modelLote->getOrCreateLote($exercicio, $dtLote, 'M', $codEntidade, $nomLote);

                $contaDebito = $repository->getContaByCodEstrutural($exercicio, $codEntidade, $value['contaDebito']);
                $contaCredito = $repository->getContaByCodEstrutural($exercicio, $codEntidade, $value['contaCredito']);
                $valor = (float) $dataForm[$key];
                $codHistorico = $value['codHistorico'];

                if (($dataForm[$key] != "") && ($dataForm[$key] != 0)) {
                    $modelLote->insereLancamento(
                        $exercicio,
                        $contaDebito,
                        $contaCredito,
                        $valor,
                        $lote->getCodLote(),
                        $codEntidade,
                        $codHistorico,
                        'M',
                        ''
                    );
                }
            }

            $contaRecurso = array(
                'contaDebito' => '7.2.1.1.1',
                'contaCredito' => '8.2.1.1.1',
                'codHistorico' => '223',
                'nomLote' => 'Abertura Recursos/Fontes Orçamento'
            );

            $nomLote = $contaRecurso['nomLote'];
            $lote = $modelLote->getOrCreateLote($exercicio, $dtLote, 'M', $codEntidade, $nomLote);
            $modelLote->removeLancamento($exercicio, $codEntidade, $lote->getCodLote(), 'M');

            $recursosSaldo = $repository->recuperaSaldoInicialRecurso($exercicio);
 
            foreach ($recursosSaldo as $recursoSaldo) {
                $valor = (float) $recursoSaldo['saldo'];
                $codRecurso = $recursoSaldo['cod_recurso'];
                $codHistorico = $contaRecurso['codHistorico'];

                $contaDebito = $repository->getContaByRecurso($exercicio, $codEntidade, $lote->getCodLote(), $codRecurso, $contaRecurso['contaDebito']);
                $contaCredito = $repository->getContaByRecurso($exercicio, $codEntidade, $lote->getCodLote(), $codRecurso, $contaRecurso['contaCredito']);

                if (($contaDebito != null) && ($contaCredito != null)) {
                    $modelLote->insereLancamento(
                        $exercicio,
                        $contaDebito,
                        $contaCredito,
                        $valor,
                        $lote->getCodLote(),
                        $codEntidade,
                        $codHistorico,
                        'M',
                        ''
                    );
                }
            }

            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.aberturaOrcamentoAnual.msgSucesso'));

            return $this->redirectToRoute('contabilidade_lancamento_contabil_abertura_orcamento_anual');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
            throw $e;
        }

        (new RedirectResponse("/financeiro/contabilidade/lancamento-contabil/abertura-orcamento-anual"))->send();
    }
}
