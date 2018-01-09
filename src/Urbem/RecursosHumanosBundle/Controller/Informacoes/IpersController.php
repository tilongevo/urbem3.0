<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class IpersController extends BaseController
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

        return $this->render('RecursosHumanosBundle::Informacoes/Ipers/index.html.twig', array('form' => $form->createView()));
    }

    public function gerarArquivoAction(Request $request)
    {
        return 'Arquivo Gerado';
    }

    private function generateForm($data)
    {

        $form = $this->createFormBuilder($data)
            ->add(
                'inCodTipoEmissao',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'Manutenção' => 1,
                        'Acerto de Manutenção' => 2,
                        'Inclusão' => 3,
                        'Acerto de Inclusão' => 4,
                    ),
                    "label" => "label.caged.tipoEmissao",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'stSituacao',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'Ativos' => 1,
                        'Aposentados' => 2,
                        'Pensionistas' => 3,
                        'Todos' => 4,
                    ),
                    "label" => "label.cadastro",
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
                'stJuntarCalculo',
                ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.ipers.juntarCalculo",
                    'multiple' => false,
                    'expanded' => true,
                    'required' => true,
                    'data' => 1,
                )
            )
            ->add(
                'inCodConfiguracao',
                TextType::class,
                [
                    "label" => "label.ipers.tipoCalculo",
                    "error_bubbling" => false,
                ]
            )
            ->add(
                'stConfiguracao',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'Complementar' => 'complementar',
                        'Salário' => 'salario',
                        'Férias' => 'ferias',
                        '13o Salário' => 'decsalario',
                        'Rescisão' => 'rescisao',
                    ),
                    "label" => "label.ipers.tipoCalculo",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'gerar',
                SubmitType::class,
                array(
                    'attr' => array('class' => 'save'),
                )
            )
            ->setAction($this->generateUrl('informacoes_ipers_gerar_arquivo'))
            ->getForm();

        return $form;
    }
}
