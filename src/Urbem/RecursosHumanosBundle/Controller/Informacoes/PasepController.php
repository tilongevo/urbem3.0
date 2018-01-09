<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class PasepController extends BaseController
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

        return $this->render('RecursosHumanosBundle::Informacoes/Pasep/index.html.twig', array('form' => $form->createView()));
    }

    public function gerarArquivoAction(Request $request)
    {
        return 'Arquivo Gerado';
    }

    private function generateForm($data)
    {

        $form = $this->createFormBuilder($data)
            ->add(
                'inEtapaProcessamento',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'Lista de Participantes a Pagar (Exportar FPS900)' => 1,
                        'Rejeitados do FPS900 (Importar FPS909)' => 2,
                        'Retorno do FPS900 - Valores a Lançar na Folha (Importar FPS910)' => 3,
                        'Lista de Participantes não Pagos na Folha (Exportar FPS950)' => 4,
                        'Rejeitados do FPS900 (Importar FPS959)' => 5,
                        'Retorno Definitivo do FPS950 (Importar FPS952)' => 6,
                    ),
                    "label" => "label.etapaProcessamento",
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
                'dtGeracaoArquivo',
                DateType::class,
                [
                    "label" => "label.dtGeracaoArquivo",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add(
                'dtCredito',
                DateType::class,
                [
                    "label" => "label.dtCredito",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            // ->add(
            //     'gerar',
            //     SubmitType::class,
            //     array(
            //         'attr' => array('class' => 'save'),
            //     )
            // )
            ->setAction($this->generateUrl('informacoes_pasep_gerar_arquivo'))
            ->getForm();

        return $form;
    }
}
