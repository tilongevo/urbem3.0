<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade\LancamentoContabil;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Contabilidade\LoteModel;
use Urbem\CoreBundle\Model\Orcamento\ReceitaModel;

class GerarLancamentosCreditoReceberController extends BaseController
{
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();

        $form->handleRequest($request);

        return $this->render(
            'FinanceiroBundle::Contabilidade/LancamentoContabil/GerarLancamentoCreditoReceber/index.html.twig',
            array('form' => $form->createView())
        );
    }

    private function generateForm()
    {
        $form = $this->createFormBuilder()
            ->add(
                'codEntidade',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'label' => 'label.implantacaoSaldo.codEntidade',
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters ',
                    ),
                    'choice_label' => function ($entidade) {
                        $label = $entidade->getCodEntidade();
                        $label .= " - " . $entidade->getFkSwCgm()->getNomCgm();
                        return $label;
                    },
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $this->getExercicio());
                        $qb->orderBy('o.codEntidade', 'ASC');
                        return $qb;
                    },
                    'choice_value' => 'codEntidade',
                )
            )
            ->setAction($this->generateUrl('contabilidade_lancamento_contabil_gerar_lancamento_credito_receber_grid'))
            ->getForm();

        return $form;
    }

    public function gridAction(Request $request)
    {
        $this->setBreadCrumb();

        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();

            $dataForm = $request->request->all();

            $entidade = $dataForm['form']['codEntidade'];

            $params = [
                'codEntidade' => $entidade,
                'exercicio' => $this->getExercicio()
            ];

            $receitaModel = new ReceitaModel($em);
            $contas = $receitaModel->getLancamentosCreditosReceber($params);

            return $this->render(
                'FinanceiroBundle::Contabilidade/LancamentoContabil/GerarLancamentoCreditoReceber/grid.html.twig',
                array(
                    'entidade' => $entidade,
                    'exercicio' => $this->getExercicio(),
                    'contas' => $contas
                )
            );
        }

        return $this->redirectToRoute('contabilidade_lancamento_contabil_gerar_lancamento_credito_receber');
    }

    public function gravarAction(Request $request)
    {
        $container = $this->container;

        try {
            $em = $this->getDoctrine()->getManager();

            $dataForm = $request->request->all();

            $entidade = $dataForm['entidade'];

            $exercicio = $this->getExercicio();
            $params = [
                'codEntidade' => $entidade,
                'exercicio' => $exercicio,
                'dtLote' => $exercicio . '-01-02',
                'nomLote' => 'Previsão de crédito tributário a receber'
            ];

            $params['tipo'] = 'M';
            if ($this->getExercicio() == '2015') {
                // Limpa registros 2015 Tipo 'I'
                $params['tipo'] = 'I';
            }

            $loteModel = new LoteModel($em);
            $lotes = $loteModel->getLotes($params);

            // Exclui lançamentos
            $loteModel->excluiLancamentosAberturaAnteriores($lotes, $exercicio, $params['tipo']);

            // Insere lançamentos
            $params = [
                'codEntidade' => $entidade,
                'exercicio' => $exercicio
            ];

            $receitaModel = new ReceitaModel($em);
            $contas = $receitaModel->getLancamentosCreditosReceber($params);

            $loteModel->insereLancamentosCreditoAReceber($contas, $exercicio);

            $container->get('session')->getFlashBag()->add('success', 'Lançamento de crédito a receber gerado com sucesso.');

            return $this->redirectToRoute('contabilidade_lancamento_contabil_gerar_lancamento_credito_receber');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao gerar lançamento de crédito a receber');
            throw $e;
        }
    }
}
