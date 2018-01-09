<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Consignacao;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class EmprestimoController extends BaseController
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

        return $this->render('RecursosHumanosBundle::Informacoes/Consignacao/Emprestimo/index.html.twig', array('form' => $form->createView()));
    }

    public function gerarArquivoAction(Request $request)
    {
        return 'Arquivo Gerado';
    }

    private function generateForm($data)
    {

        $form = $this->createFormBuilder($data)
            ->add(
                'stAcaoEmprestimo',
                ChoiceType::class,
                array (
                    'choices' => array('Importar Arquivo Banco' => 1, 'Retornar ao Banco' => 2),
                    "label" => "label.acao",
                    'multiple' => false,
                    'expanded' => true,
                    'required' => true,
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
                'stTipoFiltro',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'Geral' => 'geral',
                        'Matrícula' => 'matricula',
                        'Lotação' => 'lotacao',
                    ),
                    "label" => "label.tipoFiltro",
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'attachment',
                FileType::class,
                [
                    "label" => "label.caged.atualizaDados",
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
            ->setAction($this->generateUrl('informacoes_consignacao_emprestimo_gerar_arquivo'))
            ->getForm();

        return $form;
    }
}
