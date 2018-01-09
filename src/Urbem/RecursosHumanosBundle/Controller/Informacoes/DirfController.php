<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class DirfController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();

        $form = $this->generateForm($data);

        $form->handleRequest($request);

        return $this->render('RecursosHumanosBundle::Informacoes/Dirf/index.html.twig', array('form' => $form->createView()));
    }

    public function gerarArquivoAction(Request $request)
    {
        return 'Arquivo Gerado';
    }

    private function generateForm($data)
    {

        $form = $this->createFormBuilder($data)
            ->add(
                'stTipoFiltro',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'Geral' => 'geral',
                        'Matrícula' => 'matricula',
                        'CGM/Matrícula' => 'cgm_contrato',
                        'Lotação' => 'lotacao',
                        'Local' => 'local',
                        'Atributo Dinâmico Servidor' => 'atributo_servidor',
                    ),
                    "label" => "label.tipoFiltro",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'ano',
                ChoiceType::class,
                array (
                    'choices' => array(
                        '2015' => 2015,
                        '2016' => 2016
                    ),
                    "label" => "label.dirf.anoCalendiario",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'stIndicador',
                ChoiceType::class,
                array (
                    'choices' => array('Normal' => 1, 'Retificadora' => 2),
                    "label" => "label.rais.indicadorRecolhimento",
                    'multiple' => false,
                    'expanded' => true,
                    'required' => true,
                    'data' => 1
                )
            )
            ->add(
                'boPrestadoresServico',
                CheckboxType::class,
                [
                    "label" => "label.dirf.adicionaPrestadorServico",
                    "error_bubbling" => false,
                ]
            )
            ->add(
                'boPrestadoresServicoTodos',
                CheckboxType::class,
                [
                    "label" => "label.dirf.informarTodos",
                    "error_bubbling" => false,
                ]
            )
            ->setAction($this->generateUrl('informacoes_dirf_gerar_arquivo'))
            ->getForm();

        return $form;
    }
}
