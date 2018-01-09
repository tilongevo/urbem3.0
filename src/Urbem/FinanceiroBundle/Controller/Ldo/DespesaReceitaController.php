<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Ldo\ConfiguracaoDividaModel;
use Urbem\CoreBundle\Model\Ldo\LdoModel;
use Urbem\CoreBundle\Model\Ldo\ConfiguracaoReceitaDespesaModel;

class DespesaReceitaController extends BaseController
{
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();
        $form = $this->generateForm($data);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $container = $this->container;

            try {
                $em = $this->getDoctrine()->getManager();

                $ppa = $request->request->get('ppa');
                $ano = $request->request->get('ano');
                $valor_4 = $request->request->get('valor_4');
                $valor_5 = $request->request->get('valor_5');
                $valor_6 = $request->request->get('valor_6');

                $configuracaoDividaModel = new ConfiguracaoDividaModel($em);

                // ano 1
                $configuracaoDivida1 = $em->getRepository('CoreBundle:Ldo\ConfiguracaoDivida')
                    ->findOneBy(['codPpa' => $ppa, 'exercicio' => $ano]);
                if ($configuracaoDivida1) {
                    $configuracaoDivida1->setValor($valor_4);
                    $configuracaoDividaModel->save($configuracaoDivida1);
                }

                // ano 2
                $configuracaoDivida2 = $em->getRepository('CoreBundle:Ldo\ConfiguracaoDivida')
                    ->findOneBy(['codPpa' => $ppa, 'exercicio' => $ano + 1]);
                if ($configuracaoDivida2) {
                    $configuracaoDivida2->setValor($valor_5);
                    $configuracaoDividaModel->save($configuracaoDivida2);
                }

                // ano 3
                $configuracaoDivida3 = $em->getRepository('CoreBundle:Ldo\ConfiguracaoDivida')
                    ->findOneBy(['codPpa' => $ppa, 'exercicio' => $ano + 2]);
                if ($configuracaoDivida3) {
                    $configuracaoDivida3->setValor($valor_6);
                    $configuracaoDividaModel->save($configuracaoDivida3);
                }

                $container->get('session')->getFlashBag()->add('success', 'Despesa/Receita configurada com sucesso.');

                return $this->redirectToRoute('ldo_configuracao_gestao');
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', 'Erro ao configurar Despesa/Receita.');
                throw $e;
            }
        }

        return $this->render(
            'FinanceiroBundle::Ldo/Configuracao/DespesaReceita/index.html.twig',
            array('form' => $form->createView())
        );
    }

    private function generateForm($data)
    {
        $form = $this->createFormBuilder($data)
            ->add(
                'ppa',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Ppa\Ppa',
                    'label' => 'label.ppa.ppa',
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters ',
                    ),
                    'choice_label' => function ($value) {
                        return $value->getAnoInicio() . " - " . $value->getAnoFinal();
                    },
                )
            )
            ->add(
                'ano',
                ChoiceType::class,
                array (
                    'choices' => array(
                    ),
                    'required' => true,
                    'label' => 'label.exercicioLdo',
                    'placeholder' => 'label.selecione',
                )
            )
            ->setAction($this->generateUrl('ldo_configuracao_despesa_receita_grid'))
            ->getForm();

        return $form;
    }

    public function gridAction(Request $request)
    {
        $container = $this->container;

        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $formData = $request->request->get('form');
        $ppa = (integer) $formData['ppa'];
        $ano = (string) $formData['ano'];

        $ldoRepository = $em->getRepository("CoreBundle:Ldo\\Ldo");

        /**
         * Busca os indicadores cadastrados para o ppa
         * As funções só serão chamadas se estiver cadastrados todos os indicadores
         */
        $ldoModel = new LdoModel($em);
        $ppa = $em->getRepository('CoreBundle:Ppa\Ppa')->findOneBy(['codPpa' => $ppa]);

        try {
            $indiceTotalizador = 0;
            $receitaConfiguracao = $ldoRepository->getReceitaConfiguracao($ppa->getCodPpa(), $ano);
            foreach ($receitaConfiguracao as $index => $value) {
                if ($value['nivel'] == 0) {
                    $indiceTotalizador++;
                }
                $receitaConfiguracao[$index]['indiceTotalizador'] = $indiceTotalizador;
            }
            $despesaConfiguracao = $ldoRepository->getDespesaConfiguracao($ppa->getCodPpa(), $ano);
            foreach ($despesaConfiguracao as $index => $value) {
                if ($value['nivel'] == 0) {
                    $indiceTotalizador++;
                }
                $despesaConfiguracao[$index]['indiceTotalizador'] = $indiceTotalizador;
            }
            $receitaPrevistaConfiguracao = $ldoRepository->getReceitaPrevistaConfiguracao($ppa->getCodPpa(), $ano);
            foreach ($receitaPrevistaConfiguracao as $index => $value) {
                if ($value['nivel'] == 0) {
                    $indiceTotalizador++;
                }
                $receitaPrevistaConfiguracao[$index]['indiceTotalizador'] = $indiceTotalizador;
            }
            $despesaFixadaConfiguracao = $ldoRepository->getDespesaFixadaConfiguracao($ppa->getCodPpa(), $ano);
            foreach ($despesaFixadaConfiguracao as $index => $value) {
                if ($value['nivel'] == 0) {
                    $indiceTotalizador++;
                }
                $despesaFixadaConfiguracao[$index]['indiceTotalizador'] = $indiceTotalizador;
            }
            $receitaProjetadaConfiguracao = $ldoRepository->getReceitaProjetadaConfiguracao($ppa->getCodPpa(), $ano);
            foreach ($receitaProjetadaConfiguracao as $index => $value) {
                if ($value['nivel'] == 0) {
                    $indiceTotalizador++;
                }
                $receitaProjetadaConfiguracao[$index]['indiceTotalizador'] = $indiceTotalizador;
            }

            $despesaProjetadaConfiguracao = $ldoRepository->getDespesaProjetadaConfiguracao($ppa->getCodPpa(), $ano);
            foreach ($despesaProjetadaConfiguracao as $index => $value) {
                if ($value['nivel'] == 0) {
                    $indiceTotalizador++;
                }
                $despesaProjetadaConfiguracao[$index]['indiceTotalizador'] = $indiceTotalizador;
            }

            return $this->render(
                'FinanceiroBundle::Ldo/Configuracao/DespesaReceita/grid.html.twig',
                array(
                    'ppa' => $ppa,
                    'ano' => $ano,
                    'receitaConfiguracao' => $receitaConfiguracao,
                    'despesaConfiguracao' => $despesaConfiguracao,
                    'receitaPrevistaConfiguracao' => $receitaPrevistaConfiguracao,
                    'despesaFixadaConfiguracao' => $despesaFixadaConfiguracao,
                    'receitaProjetadaConfiguracao' => $receitaProjetadaConfiguracao,
                    'despesaProjetadaConfiguracao' => $despesaProjetadaConfiguracao
                )
            );
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao configurar Despesa/Receita. Periodo selecionado não possui dados de configuração.');
        }

        return $this->redirectToRoute('ldo_configuracao_despesa_receita');
    }

    public function gravarAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        try {
            $dataForm = $request->request->all();
            $configuracaoReceitaDespesaModel = new ConfiguracaoReceitaDespesaModel($em);

            for ($i = ($dataForm['ano']); $i <= ($dataForm['ano'] + 2); $i++) {
                // Para Receita
                foreach ($dataForm['receitaProjetada'] as $codTipo => $value) {
                    $receitaDespesa = $configuracaoReceitaDespesaModel->populaValoresConfiguracaoReceitaDespesa(
                        $dataForm,
                        $i,
                        $codTipo,
                        strtoupper(substr($configuracaoReceitaDespesaModel::TIPO_RECEITA, 0, 1)),
                        $configuracaoReceitaDespesaModel::TIPO_RECEITA
                    );
                    $configuracaoReceitaDespesaModel->save($receitaDespesa);
                }
                // Para Despesa
                foreach ($dataForm['despesaProjetada'] as $codTipo => $value) {
                    $receitaDespesa = $configuracaoReceitaDespesaModel->populaValoresConfiguracaoReceitaDespesa(
                        $dataForm,
                        $i,
                        $codTipo,
                        strtoupper(substr($configuracaoReceitaDespesaModel::TIPO_DESPESA, 0, 1)),
                        $configuracaoReceitaDespesaModel::TIPO_DESPESA
                    );
                    $configuracaoReceitaDespesaModel->save($receitaDespesa);
                }
            }

            $container->get('session')->getFlashBag()->add('success', 'Despesa/Receita configurada com sucesso.');
            return $this->redirectToRoute('ldo_configuracao_despesa_receita');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao configurar Despesa/Receita.');
            throw $e;
        }

        return $this->redirectToRoute('ldo_configuracao_home');
    }
}
