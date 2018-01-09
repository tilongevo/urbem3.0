<?php

namespace Urbem\RecursosHumanosBundle\Controller\Calendario;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado;
use Urbem\RecursosHumanosBundle\Form\Calendario\CalendarioDiaCompensadoType;

/**
 * Calendario\CalendarioDiaCompensado controller.
 *
 */
class CalendarioDiaCompensadoController extends ControllerCore\BaseController
{
    /**
     * Lists all Calendario\CalendarioDiaCompensado entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $this->setBreadCrumb();

        $calendarios = $em->getRepository('CoreBundle:Calendario\CalendarioDiaCompensado')->findAll();
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($calendarios, $request->query
        ->get('page', 1), $this->itensPerPage);

        return $this->render('RecursosHumanosBundle::Calendario/CalendarioDiaCompensado/index.html.twig', array(
            'calendarios' => $pagination,
        ));
    }

    /**
     * Creates a new Calendario\CalendarioDiaCompensado entity.
     *
     */
    public function newAction(Request $request)
    {
        $calendario = new CalendarioDiaCompensado();
        $form = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\Calendario\CalendarioDiaCompensadoType',
            $calendario
        );
        $form->handleRequest($request);
        
        $this->setBreadCrumb();

        if ($form->isSubmitted() && $form->isValid()) {
            // $Calendario
            // var_dump($calendario);
            // die();
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendario);
            $em->flush();

            return $this->redirectToRoute(
                'calendario_calendario_dia_compensado_show',
                array('id' => $calendario->getId())
            );
        }

        return $this->render('RecursosHumanosBundle::Calendario/CalendarioDiaCompensado/new.html.twig', array(
            'calendario' => $calendario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Calendario\CalendarioDiaCompensado entity.
     *
     */
    public function showAction(CalendarioDiaCompensado $calendario)
    {
        $deleteForm = $this->createDeleteForm($calendario);

        $this->setBreadCrumb(['id'=>$calendario->getId()]);
        
        return $this->render('RecursosHumanosBundle::Calendario/CalendarioDiaCompensado/show.html.twig', array(
            'calendario' => $calendario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Calendario\CalendarioDiaCompensado entity.
     *
     */
    public function editAction(Request $request, CalendarioDiaCompensado $calendario)
    {
        $deleteForm = $this->createDeleteForm($calendario);
        $editForm = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\Calendario\CalendarioDiaCompensadoType',
            $calendario
        );
        $editForm->handleRequest($request);
        
        $this->setBreadCrumb(['id'=>$calendario->getId()]);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendario);
            $em->flush();

            return $this->redirectToRoute(
                'calendario_calendario_dia_compensado_edit',
                array('id' => $calendario->getId())
            );
        }

        return $this->render('RecursosHumanosBundle::Calendario/CalendarioDiaCompensado/edit.html.twig', array(
            'calendario' => $calendario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Calendario\CalendarioDiaCompensado entity.
     *
     */
    public function deleteAction(Request $request, CalendarioDiaCompensado $calendario)
    {
        $form = $this->createDeleteForm($calendario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calendario);
            $em->flush();
        }

        return $this->redirectToRoute('calendario_calendario_dia_compensado_index');
    }

    /**
     * Creates a form to delete a Calendario\CalendarioDiaCompensado entity.
     *
     * @param CalendarioDiaCompensado $calendario The Calendario\CalendarioDiaCompensado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CalendarioDiaCompensado $calendario)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'calendario_calendario_dia_compensado_delete',
                    array('id' => $calendario->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
