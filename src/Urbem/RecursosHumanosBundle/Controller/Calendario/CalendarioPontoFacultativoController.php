<?php

namespace Urbem\RecursosHumanosBundle\Controller\Calendario;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo;
use Urbem\RecursosHumanosBundle\Form\Calendario\CalendarioPontoFacultativoType;

/**
 * Calendario\CalendarioPontoFacultativo controller.
 *
 */
class CalendarioPontoFacultativoController extends ControllerCore\BaseController
{
    /**
     * Lists all Calendario\CalendarioPontoFacultativo entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $this->setBreadCrumb();

        $calendarios = $em->getRepository('CoreBundle:Calendario\CalendarioPontoFacultativo')->findAll();
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($calendarios, $request->query
        ->get('page', 1), $this->itensPerPage);


        return $this->render('RecursosHumanosBundle::Calendario/CalendarioPontoFacultativo/index.html.twig', array(
            'calendarios' => $pagination,
        ));
    }

    /**
     * Creates a new Calendario\CalendarioPontoFacultativo entity.
     *
     */
    public function newAction(Request $request)
    {
        $calendario = new CalendarioPontoFacultativo();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Calendario\CalendarioPontoFacultativoType', $calendario);
        $form->handleRequest($request);
        
        $this->setBreadCrumb();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendario);
            $em->flush();

            return $this->redirectToRoute('calendario_calendario_ponto_facultativo_show', array('id' => $calendario->getId()));
        }

        return $this->render('RecursosHumanosBundle::Calendario/CalendarioPontoFacultativo/new.html.twig', array(
            'calendario' => $calendario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Calendario\CalendarioPontoFacultativo entity.
     *
     */
    public function showAction(CalendarioPontoFacultativo $calendario)
    {
        $deleteForm = $this->createDeleteForm($calendario);
        
        $this->setBreadCrumb(['id'=>$calendario->getId()]);

        return $this->render('RecursosHumanosBundle::Calendario/CalendarioPontoFacultativo/show.html.twig', array(
            'calendario' => $calendario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Calendario\CalendarioPontoFacultativo entity.
     *
     */
    public function editAction(Request $request, CalendarioPontoFacultativo $calendario)
    {
        $deleteForm = $this->createDeleteForm($calendario);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Calendario\CalendarioPontoFacultativoType', $calendario);
        $editForm->handleRequest($request);
        
        $this->setBreadCrumb(['id'=>$calendario->getId()]);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendario);
            $em->flush();

            return $this->redirectToRoute('calendario_calendario_ponto_facultativo_edit', array('id' => $calendario->getId()));
        }

        return $this->render('RecursosHumanosBundle::Calendario/CalendarioPontoFacultativo/edit.html.twig', array(
            'calendario' => $calendario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Calendario\CalendarioPontoFacultativo entity.
     *
     */
    public function deleteAction(Request $request, CalendarioPontoFacultativo $calendario)
    {
        $form = $this->createDeleteForm($calendario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calendario);
            $em->flush();
        }

        return $this->redirectToRoute('calendario_calendario_ponto_facultativo_index');
    }

    /**
     * Creates a form to delete a Calendario\CalendarioPontoFacultativo entity.
     *
     * @param CalendarioPontoFacultativo $calendario The Calendario\CalendarioPontoFacultativo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CalendarioPontoFacultativo $calendario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calendario_calendario_ponto_facultativo_delete', array('id' => $calendario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
