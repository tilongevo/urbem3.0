<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class SefipController extends BaseController
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

        return $this->render('RecursosHumanosBundle::Informacoes/Sefip/index.html.twig', array('form' => $form->createView()));
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
                'competencia',
                TextType::class,
                [
                    "label" => "label.competencia",
                    "error_bubbling" => false,
                ]
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
                'inTipoRemessa',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'GFIP' => 1,
                        'DERF' => 2,
                    ),
                    'label' => 'label.sefip.tipoRemessa',
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codConfiguracao',
                TextType::class,
                [
                    "error_bubbling" => false,
                    "label" => "label.sefip.codRecolhimento",
                ]
            )
            ->add(
                'inCodRecolhimento',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'label 1' => 1,
                        'label 2' => 2
                    ),
                    "label" => "label.sefip.codRecolhimento",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'inCodIndicadorRecolhimentoTxt',
                TextType::class,
                [
                    "error_bubbling" => false,
                    "label" => "label.sefip.indicadorRecolhimento",
                ]
            )
            ->add(
                'inCodRecolhimento2',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'GRF no prazo' => 1,
                        'GRF em atraso' => 2
                    ),
                    "label" => "label.sefip.indicadorRecolhimento",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'cnaeFiscal',
                TextType::class,
                [
                    "error_bubbling" => false,
                    "label" => "label.sefip.cnaeFiscal",
                ]
            )
            ->add(
                'codCenetralizacao',
                TextType::class,
                [
                    "error_bubbling" => false,
                    "label" => "label.sefip.codCenetralizacao",
                ]
            )
            ->add(
                'fpas',
                TextType::class,
                [
                    "error_bubbling" => false,
                    "label" => "label.sefip.fpas",
                ]
            )
            ->add(
                'codPagamentoGPS',
                TextType::class,
                [
                    "error_bubbling" => false,
                    "label" => "label.sefip.codPagamentoGPS",
                ]
            )
            ->add(
                'sefipRetificadora',
                CheckboxType::class,
                [
                    "label" => "label.sefip.sefipRetificadora",
                    "error_bubbling" => false,
                ]
            )
            ->add(
                'gerar',
                SubmitType::class,
                array(
                    'attr' => array('class' => 'save'),
                )
            )
            ->setAction($this->generateUrl('informacoes_sefip_gerar_arquivo'))
            ->getForm();

        return $form;
    }
}
