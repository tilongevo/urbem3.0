<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class ModalidadeLancamentoController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class ModalidadeLancamentoController extends BaseController
{
    const VINCULO_ATIVIDADE = 'atividade';
    const VINCULO_CADASTRO_ECONOMICO = 'cadastro_economico';
    const VINCULOS = [
        'Atividade' => self::VINCULO_ATIVIDADE,
        'Inscrição Econômica' => self::VINCULO_CADASTRO_ECONOMICO,
    ];

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !in_array($form->get('vinculo')->getData(), $this::VINCULOS)) {
            return $this->render(
                'TributarioBundle::Economico/ModalidadeLancamento/home.html.twig',
                [
                    'form' => $form->createView(),
                ]
            );
        }

        $path = sprintf('urbem_tributario_economico_modalidade_lancamento_%s_list', $form->get('vinculo')->getData());

        return $this->redirect($this->generateUrl($path));
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function generateForm()
    {
        $form = $this->createFormBuilder([])
            ->add(
                'vinculo',
                'choice',
                [
                    'choices' => $this::VINCULOS,
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'label' => 'label.economicoModalidadeLancamento.vinculo'
                ]
            )
            ->setAction($this->generateUrl('tributario_economico_modalidade_lancamento_home'))
            ->getForm();

        return $form;
    }
}
