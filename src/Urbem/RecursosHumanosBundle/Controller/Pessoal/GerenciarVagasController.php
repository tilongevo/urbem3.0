<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao;

/**
 * Pessoal\CargoSubDivisao controller.
 *
 */
class GerenciarVagasController extends BaseController
{
    /**
     * Lists all Pessoal\CargoSubDivisao entities.
     *
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $vagas = $em->getRepository('CoreBundle:Pessoal\CargoSubDivisao')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($vagas, $request->query->get('page', 1), $this->itensPerPage);

        return $this->render('RecursosHumanosBundle::Pessoal/GerenciarVagas/index.html.twig', array(
            'vagas' => $pagination,
        ));
    }

    /**
     * Creates a new Pessoal\CargoSubDivisao entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $vaga = new CargoSubDivisao();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Pessoal\CargoSubDivisaoType', $vaga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vaga);
            $em->flush();

            return $this->redirectToRoute('pessoal_gerenciar_vagas_show', array('id' => $vaga->getId()));
        }

        return $this->render('RecursosHumanosBundle::Pessoal/GerenciarVagas/new.html.twig', array(
            'vaga' => $vaga,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pessoal\CargoSubDivisao entity.
     *
     */
    public function showAction(CargoSubDivisao $vaga)
    {
        $this->setBreadCrumb(['id' => $vaga->getId()]);

        $deleteForm = $this->createDeleteForm($vaga);

        return $this->render('RecursosHumanosBundle::Pessoal/GerenciarVagas/show.html.twig', array(
            'vaga' => $vaga,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pessoal\CargoSubDivisao entity.
     *
     */
    public function editAction(Request $request, CargoSubDivisao $vaga)
    {
        $this->setBreadCrumb(['id' => $vaga->getId()]);

        $deleteForm = $this->createDeleteForm($vaga);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Pessoal\CargoSubDivisaoType', $vaga);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vaga);
            $em->flush();

            return $this->redirectToRoute('pessoal_gerenciar_vagas_edit', array('id' => $vaga->getId()));
        }

        return $this->render('RecursosHumanosBundle::Pessoal/GerenciarVagas/edit.html.twig', array(
            'vaga' => $vaga,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pessoal\CargoSubDivisao entity.
     *
     */
    public function deleteAction(Request $request, CargoSubDivisao $vaga)
    {
        $form = $this->createDeleteForm($vaga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vaga);
            $em->flush();
        }

        return $this->redirectToRoute('pessoal_gerenciar_vagas_index');
    }

    /**
     * Creates a form to delete a Pessoal\CargoSubDivisao entity.
     *
     * @param CargoSubDivisao $vaga The Pessoal\CargoSubDivisao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CargoSubDivisao $vaga)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pessoal_gerenciar_vagas_delete', array('id' => $vaga->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
