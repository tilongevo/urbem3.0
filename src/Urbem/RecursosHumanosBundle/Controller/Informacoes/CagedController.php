<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class CagedController extends BaseController
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

        return $this->render(
            'RecursosHumanosBundle::Informacoes/Caged/index.html.twig',
            array('form' => $form->createView())
        );
    }

    public function gerarArquivoAction(Request $request)
    {
        return 'Arquivo Gerado';
    }

    private function generateForm($data)
    {

        $form = $this->createFormBuilder($data)
            ->add(
                'stTipoEmissao',
                ChoiceType::class,
                array (
                    'choices' => array('Movimento Mensal' => 1, 'Acerto (meses anteriores)' => 2),
                    "label" => "label.caged.tipoEmissao",
                    'multiple' => false,
                    'expanded' => true,
                    'required' => true,
                    'data' => 1
                )
            )
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
                'codMes',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'Janeiro' => 1,
                        'Fevereiro' => 2
                    ),
                    "label" => "label.mes",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'boAtualizarDados',
                CheckboxType::class,
                [
                    "label" => "label.caged.atualizaDados",
                    "error_bubbling" => false,
                ]
            )
            // ->add(
            //     'gerar',
            //     SubmitType::class,
            //     array(
            //         'attr' => array('class' => 'save'),
            //     )
            // )
            ->setAction($this->generateUrl('informacoes_caged_gerar_arquivo'))
            ->getForm();

        return $form;
    }
}
