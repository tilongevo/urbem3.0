<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Economico\VigenciaAtividade;

/**
 * Class NivelAtividadeController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class NivelAtividadeController extends BaseController
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
            return $this->redirect($this->generateUrl('urbem_tributario_economico_nivel_atividade_list', array('codVigencia' => $request['vigenciaAtividade'])));
        } else {
            return $this->render(
                'TributarioBundle::Economico/NivelAtividade/filtro.html.twig',
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
                'vigenciaAtividade',
                EntityType::class,
                array(
                    'class' => VigenciaAtividade::class,
                    'label' => false,
                    'required' => true,
                    'choice_value' => 'codVigencia',
                    'placeholder' => 'label.selecione',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->orderBy('o.dtInicio', 'ASC');

                        return $qb;
                    },
                    'choice_label' => function ($vigenciaAtividade) {
                        return sprintf('%d - %s', $vigenciaAtividade->getCodVigencia(), $vigenciaAtividade->getDtInicio()->format('d/m/Y'));
                    },
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                )
            )
            ->setAction($this->generateUrl('tributario_economico_hierarquia_atividade_nivel_filtro'))
            ->getForm();

        return $form;
    }
}
