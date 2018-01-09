<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Doctrine\DBAL\Exception\DriverException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ldo\ConfiguracaoDivida;
use Urbem\CoreBundle\Entity\Ldo\Ldo;
use Urbem\CoreBundle\Entity\Ldo\TipoDivida;
use Urbem\CoreBundle\Entity\Ppa\Ppa;
use Urbem\CoreBundle\Model\Ldo\ConfiguracaoDividaModel;
use Urbem\CoreBundle\Model\Ldo\TipoDividaModel;

class EvolucaoDividaController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
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

                $ppa = $em->getRepository(Ppa::class)
                    ->findOneBy(['codPpa' => $ppa]);
                $anos = array();

                $i = 1;
                for ($year = $ppa->getAnoInicio(); $year <= $ppa->getAnoFinal(); $year++) {
                    $anos[$year] = $i;
                    $i++;
                }

                $configuracaoDividaModel = new ConfiguracaoDividaModel($em);

                $codTipoDivida = $em->getRepository(TipoDivida::class)
                    ->findOneBy(['descricao' => TipoDividaModel::PASSIVOS_RECONHECIDOS_TYPE ]);

                // ano 1

                $configuracaoDivida1 = $em->getRepository(ConfiguracaoDivida::class)
                    ->findOneBy([
                        'codPpa' => $ppa,
                        'ano' => $anos[$ano],
                        'codTipo' => $codTipoDivida,
                        'exercicio' => $ano
                    ]);

                $ldo = $em->getRepository(Ldo::class)
                    ->findOneBy(['codPpa' => $ppa, 'ano' => $anos[$ano]]);

                $tipoDivida = $em->getRepository(TipoDivida::class)
                    ->findOneBy(['descricao' => TipoDividaModel::PASSIVOS_RECONHECIDOS_TYPE]);

                if (!$configuracaoDivida1) {
                    $configuracaoDivida1 = new ConfiguracaoDivida();
                    $configuracaoDivida1->setFkLdoLdo($ldo);
                    $configuracaoDivida1->setFkLdoTipoDivida($tipoDivida);
                    $configuracaoDivida1->setExercicio($ano);
                }

                $configuracaoDivida1->setValor($valor_4);
                $configuracaoDividaModel->save($configuracaoDivida1);

                // ano 2
                $configuracaoDivida2 = $em->getRepository(ConfiguracaoDivida::class)
                    ->findOneBy([
                        'codPpa' => $ppa,
                        'ano' => $anos[$ano],
                        'codTipo' => $codTipoDivida,
                        'exercicio' => $ano + 1
                    ]);

                if (!$configuracaoDivida2) {
                    $configuracaoDivida2 = new ConfiguracaoDivida();
                    $configuracaoDivida2->setFkLdoLdo($ldo);
                    $configuracaoDivida2->setFkLdoTipoDivida($tipoDivida);
                    $configuracaoDivida2->setExercicio($ano + 1);
                }

                $configuracaoDivida2->setValor($valor_5);
                $configuracaoDividaModel->save($configuracaoDivida2);

                // ano 3
                $configuracaoDivida3 = $em->getRepository(ConfiguracaoDivida::class)
                    ->findOneBy([
                        'codPpa' => $ppa,
                        'ano' => $anos[$ano],
                        'codTipo' => $codTipoDivida,
                        'exercicio' => $ano + 2
                    ]);

                if (!$configuracaoDivida3) {
                    $configuracaoDivida3 = new ConfiguracaoDivida();
                    $configuracaoDivida3->setFkLdoLdo($ldo);
                    $configuracaoDivida3->setFkLdoTipoDivida($tipoDivida);
                    $configuracaoDivida3->setExercicio($ano + 2);
                }

                $configuracaoDivida3->setValor($valor_6);
                $configuracaoDividaModel->save($configuracaoDivida3);

                $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.configuracaoEvolucaoDivida.successMessage'));

                return $this->redirectToRoute('ldo_configuracao_evolucao_divida');
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.configuracaoEvolucaoDivida.errorMessage'));
                throw $e;
            }
        }

        return $this->render(
            'FinanceiroBundle::Ldo/Configuracao/EvolucaoDivida/index.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @param $data
     * @return \Symfony\Component\Form\FormInterface
     */
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
            ->add(
                'indicador',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Ldo\TipoIndicadores',
                    'choice_label' => 'descricao',
                    'label' => 'label.configuracaoEvolucaoDivida.indicador',
                    'placeholder' => 'label.selecione',
                    'required' => true,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
            )
            ->setAction($this->generateUrl('ldo_configuracao_evolucao_divida_grid'))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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

        $configuracoes = $em->getRepository('CoreBundle:Ldo\\Indicadores')
            ->findBy(['codTipoIndicador' => $indicador], ['exercicio' => 'ASC']);

        $valida = $configuracaoDividaModel->valida($ppa, $configuracoes);

        if (count($valida)) {
            $mensagem = $this->get('translator')->trans('label.configuracaoEvolucaoDivida.errorSelic', array('%anos' => implode(', ', $valida)));
            $this->container->get('session')->getFlashBag()->add('error', $mensagem);
            return $this->redirectToRoute('ldo_configuracao_evolucao_divida');
        }

        try {
            $listDividasLDO = $result = $ldoRepository->listDividasLDO($ppa, $ano);
            $listServicosLDO = $ldoRepository->listServicosLDO($ppa, $ano, $indicador);
            $result = array_shift($result);
            $exerciciosArr = array();

            // Necessário ter o for pois a função não retorna ordenado os anos
            for ($i = 1; $i <= 6; $i++) {
                array_push($exerciciosArr, $result['exercicio_' . $i]);
            }

            asort($exerciciosArr);
        } catch (DriverException $e) {
            $listServicosLDO = null;
            $listDividasLDO = null;
        }

        return $this->render(
            'FinanceiroBundle::Ldo/Configuracao/EvolucaoDivida/grid.html.twig',
            array(
                'ppa' => $ppa,
                'ano' => $ano,
                'indicador' => $indicador,
                'listDividasLDO' => $listDividasLDO,
                'listServicosLDO' => $listServicosLDO,
                'exercicioInicial' => current($exerciciosArr)
            )
        );
    }
}
