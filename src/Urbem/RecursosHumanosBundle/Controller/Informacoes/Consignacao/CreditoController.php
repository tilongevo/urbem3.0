<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Consignacao;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class CreditoController extends BaseController
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

        return $this->render('RecursosHumanosBundle::Informacoes/Consignacao/Credito/index.html.twig', array('form' => $form->createView()));
    }

    public function gerarArquivoAction(Request $request)
    {
        return 'Arquivo Gerado';
    }

    private function generateForm($data)
    {

        $form = $this->createFormBuilder($data)
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
                'gerar',
                SubmitType::class,
                array(
                    'attr' => array('class' => 'save'),
                )
            )
            ->setAction($this->generateUrl('informacoes_consignacao_credito_gerar_arquivo'))
            ->getForm();

        return $form;
    }
}
