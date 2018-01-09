<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Folhapagamento\Bases;
use Urbem\CoreBundle\Form\Folhapagamento\BasesType;

/**
 * Folhapagamento\Bases controller.
 *
 */
class BasesController extends ControllerCore\BaseController
{
    /**
     * Lists all Folhapagamento\Bases entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $this->setBreadCrumb();

        $bases = $em->getRepository('CoreBundle:Folhapagamento\Bases')->findAll();
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($bases, $request->query
        ->get('page', 1), $this->itensPerPage);

        return $this->render('RecursosHumanosBundle:FolhaPagamento/Bases/index.html.twig', array(
            'bases' => $pagination,
        ));
    }

    /**
     * Creates a new Folhapagamento\Bases entity.
     *
     */
    public function newAction(Request $request)
    {
        $bases = new Bases();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\FolhaPagamento\BasesType', $bases);
        $form->handleRequest($request);

        $this->setBreadCrumb();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bases);
            $em->flush();

            return $this->redirectToRoute('folha_pagamento_bases_show', array('id' => $bases->getCodBase()));
        }

        return $this->render('RecursosHumanosBundle:FolhaPagamento/Bases/new.html.twig', array(
            'bases' => $bases,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Folhapagamento\Bases entity.
     *
     */
    public function showAction(Bases $bases)
    {
        $deleteForm = $this->createDeleteForm($bases);
        
        $this->setBreadCrumb(array('id' => $bases->getCodBase()));

        return $this->render('RecursosHumanosBundle:FolhaPagamento/Bases/show.html.twig', array(
            'bases' => $bases,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Folhapagamento\Bases entity.
     *
     */
    public function editAction(Request $request, Bases $bases)
    {
        $deleteForm = $this->createDeleteForm($bases);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\FolhaPagamento\BasesType', $bases);
        $editForm->handleRequest($request);
        
        $this->setBreadCrumb(array('id' => $bases->getCodBase()));
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bases);
            $em->flush();

            return $this->redirectToRoute('folha_pagamento_bases_edit', array('id' => $bases->getCodBase()));
        }

        return $this->render('RecursosHumanosBundle:FolhaPagamento/Bases/edit.html.twig', array(
            'bases' => $bases,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Folhapagamento\Bases entity.
     *
     */
    public function deleteAction(Request $request, Bases $bases)
    {
        $form = $this->createDeleteForm($bases);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bases);
            $em->flush();
        }

        return $this->redirectToRoute('folha_pagamento_bases_index');
    }

    /**
     * Creates a form to delete a Folhapagamento\Bases entity.
     *
     * @param Bases $bases The Folhapagamento\Bases entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bases $bases)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('folha_pagamento_bases_delete', array('id' => $bases->getCodBase())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
