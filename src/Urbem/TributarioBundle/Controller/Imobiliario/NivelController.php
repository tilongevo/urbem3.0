<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;

/**
 * Class UnidadeController
 * @package Urbem\FinanceiroBundle\Controller\Orcamento
 */
class NivelController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $retorno = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            return $this->redirect($this->generateUrl('urbem_tributario_imobiliario_nivel_list', array('codVigencia' => $request['fkImobiliarioVigencia'])));
        } else {
            return $this->render(
                'TributarioBundle::Imobiliario/Nivel/filtro.html.twig',
                $retorno
            );
        }
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function generateForm()
    {
        $form = $this->createFormBuilder([])
            ->add(
                'fkImobiliarioVigencia',
                EntityType::class,
                array(
                    'class' => Vigencia::class,
                    'label' => false,
                    'required' => true,
                    'choice_value' => 'codVigencia',
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                )
            )
            ->setAction($this->generateUrl('urbem_tributario_imobiliario_nivel_filtro'))
            ->getForm();

        return $form;
    }
}
