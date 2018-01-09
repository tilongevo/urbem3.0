<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class CorretagemController
 * @package Urbem\TributarioBundle\Controller\Imobiliario
 */
class CorretagemController extends BaseController
{
    const CORRETAGEM_IMOBILIARIA = 'Imobiliária';
    const CORRETAGEM_CORRETOR = 'Corretor';
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $result = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            $tipo = $request['corretagem'];
            if ($tipo == strtolower(self::CORRETAGEM_IMOBILIARIA)) {
                return $this->redirect($this->generateUrl('urbem_tributario_imobiliario_imobiliaria_list'));
            } elseif ($tipo == strtolower(self::CORRETAGEM_CORRETOR)) {
                return $this->redirect($this->generateUrl('urbem_tributario_imobiliario_corretor_list'));
            }
        } else {
            return $this->render(
                'TributarioBundle::Imobiliario/Corretagem/filtro.html.twig',
                $result
            );
        }
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function generateForm()
    {
        $tipos =  [
            strtolower(self::CORRETAGEM_CORRETOR) => self::CORRETAGEM_CORRETOR,
            strtolower(self::CORRETAGEM_IMOBILIARIA) => self::CORRETAGEM_IMOBILIARIA
        ];
        $tipos = array_flip($tipos);
        $form = $this->createFormBuilder([])
            ->add(
                'corretagem',
                ChoiceType::class,
                [
                    'label' => 'label.imobiliarioCorretagem.filtroTipo',
                    'placeholder' => 'label.selecione',
                    'choices' => $tipos,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->setAction($this->generateUrl('tributario_imobiliario_corretagem_filtro'))
            ->getForm();

        return $form;
    }
}
