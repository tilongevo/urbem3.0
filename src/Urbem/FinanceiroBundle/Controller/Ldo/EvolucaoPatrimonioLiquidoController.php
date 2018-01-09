<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Ldo\ConfiguracaoDividaModel;

class EvolucaoPatrimonioLiquidoController extends BaseController
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

                $container->get('session')->getFlashBag()->add('success', 'Evolução da dívida salva com sucesso.');

                return $this->redirectToRoute('ldo_configuracao_evolucao_divida');
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', 'Erro ao salvar evoluçao da divida.');
                throw $e;
            }
        }

        return $this->render(
            'FinanceiroBundle::Ldo/Configuracao/EvolucaoPatrimonioLiquido/index.html.twig',
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
                    'label' => 'label.ppa',
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
            ->setAction($this->generateUrl('ldo_configuracao_evolucao_patrimonio_liquido_grid'))
            ->getForm();

        return $form;
    }

    public function gridAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $formData = $request->request->get('form');
        $ppa = (integer) $formData['ppa'];
        $ano = (string) $formData['ano'];
        $indicador = (integer) $formData['indicador'];

        $ldoRepository = $em->getRepository("CoreBundle:Ldo\\Ldo");

        /**
         * Busca os indicadores cadastrados para o ppa
         * As funções só serão chamadas se estiver cadastrados todos os indicadores
         */
        $configuracaoDividaModel = new ConfiguracaoDividaModel($em);
        $ppa = $em->getRepository('CoreBundle:Ppa\Ppa')
            ->findOneBy(['codPpa' => $ppa]);

        $configuracoes = $em->getRepository('CoreBundle:Ldo\ConfiguracaoDivida')
            ->findBy(['codPpa' => $ppa], ['exercicio' => 'ASC']);

        $valida = $configuracaoDividaModel->valida($ppa, $configuracoes);

        if (count($valida)) {
            $mensagem = sprintf('Não existe Selic cadastrado para o(s) exercício(s) %s', implode(', ', $valida));
            $this->container->get('session')->getFlashBag()->add('error', $mensagem);
            return $this->redirectToRoute('ldo_configuracao_evolucao_divida');
        }

        try {
            $evolucaoPatrimonioLiquido = $ldoRepository->getEvolucaoPatrimonioLiquido($ppa, $ano, false);
            $evolucaoPatrimonioLiquidoRPPS = $ldoRepository->getEvolucaoPatrimonioLiquido($ppa, $ano, true);

            $totalPatrimonio = $this->parseDadosPatrimonio($evolucaoPatrimonioLiquido);
            $totalPatrimonioRPPS = $this->parseDadosPatrimonio($evolucaoPatrimonioLiquidoRPPS);
        } catch (DriverException $e) {
            $evolucaoPatrimonioLiquido = null;
            $evolucaoPatrimonioLiquidoRPPS = null;
            $totalPatrimonio = null;
            $totalPatrimonioRPPS = null;
        }

        return $this->render(
            'FinanceiroBundle::Ldo/Configuracao/EvolucaoPatrimonioLiquido/grid.html.twig',
            array(
                'ppa' => $ppa,
                'ano' => $ano,
                'evolucaoPatrimonioLiquido' => $evolucaoPatrimonioLiquido,
                'evolucaoPatrimonioLiquidoRPPS' => $evolucaoPatrimonioLiquidoRPPS,
                'totalPatrimonio' => $totalPatrimonio,
                'totalPatrimonioRPPS' => $totalPatrimonioRPPS,
            )
        );
    }

    protected function parseDadosPatrimonio($info)
    {
        $totalValor_1 = 0;
        $totalValor_2 = 0;
        $totalValor_3 = 0;
        $totalPorcentagem_1 = 0;
        $totalPorcentagem_2 = 0;
        $totalPorcentagem_3 = 0;

        foreach ($info as $data)
        {
            $totalValor_1 += $data['valor_1'];
            $totalValor_2 += $data['valor_2'];
            $totalValor_3 += $data['valor_3'];
            $totalPorcentagem_1 += $data['porcentagem_1'];
            $totalPorcentagem_2 += $data['porcentagem_2'];
            $totalPorcentagem_3 += $data['porcentagem_3'];
        }

        return [
            'totalValor_1' => $totalValor_1,
            'totalValor_2' => $totalValor_2,
            'totalValor_3' => $totalValor_3,
            'totalPorcentagem_1' => $totalPorcentagem_1,
            'totalPorcentagem_2' => $totalPorcentagem_2,
            'totalPorcentagem_3' => $totalPorcentagem_3,
        ];
    }
}
