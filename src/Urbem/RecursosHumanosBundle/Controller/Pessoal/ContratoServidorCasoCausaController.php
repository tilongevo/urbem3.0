<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa;

/**
 * Pessoal\ContratoServidorCasoCausa controller.
 *
 */
class ContratoServidorCasoCausaController extends BaseController
{
    /**
     * Lists all Pessoal\ContratoServidorCasoCausa entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $this->setBreadCrumb();

        $rescisao = $em->getRepository('CoreBundle:Pessoal\ContratoServidorCasoCausa')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($rescisao, $request->query->get('page', 1), $this->itensPerPage);

        return $this->render('RecursosHumanosBundle::Pessoal/Contratoservidorcasocausa/index.html.twig', array(
            'contratoServidorCasoCausas' => $pagination,
        ));
    }

    /**
     * Creates a new Pessoal\ContratoServidorCasoCausa entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $contratoServidorCasoCausa = new ContratoServidorCasoCausa();
        $form = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\Pessoal\ContratoServidorCasoCausaType',
            $contratoServidorCasoCausa
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contratoServidorCasoCausa);
            $em->flush();

            return $this->redirectToRoute(
                'pessoal_rescisao_contrato_show',
                array('id' => $contratoServidorCasoCausa->getCodCasoCausa())
            );
        }

        return $this->render('RecursosHumanosBundle::Pessoal/Contratoservidorcasocausa/new.html.twig', array(
            'contratoServidorCasoCausa' => $contratoServidorCasoCausa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pessoal\ContratoServidorCasoCausa entity.
     * @param ContratoServidorCasoCausa $contratoServidorCasoCausa
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(ContratoServidorCasoCausa $contratoServidorCasoCausa)
    {

        $this->setBreadCrumb(['id' => $contratoServidorCasoCausa->getCodContrato()->getCodContrato()->getCodContrato()]);

        $deleteForm = $this->createDeleteForm($contratoServidorCasoCausa);

        return $this->render('RecursosHumanosBundle::Pessoal/Contratoservidorcasocausa/show.html.twig', array(
            'contratoServidorCasoCausa' => $contratoServidorCasoCausa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pessoal\ContratoServidorCasoCausa entity.
     * @param Request $request
     * @param ContratoServidorCasoCausa $contratoServidorCasoCausa
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, ContratoServidorCasoCausa $contratoServidorCasoCausa)
    {
        $this->setBreadCrumb(['id' => $contratoServidorCasoCausa->getCodContrato()->getCodContrato()->getCodContrato()]);

        $deleteForm = $this->createDeleteForm($contratoServidorCasoCausa);

        $editForm = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\Pessoal\ContratoServidorCasoCausaType',
            $contratoServidorCasoCausa
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contratoServidorCasoCausa);
            $em->flush();

            return $this->redirectToRoute(
                'pessoal_rescisao_contrato_edit',
                array('id' => $contratoServidorCasoCausa->getCodContrato()->getCodContrato()->getCodContrato())
            );
        }

        return $this->render('RecursosHumanosBundle::Pessoal/Contratoservidorcasocausa/edit.html.twig', array(
            'contratoServidorCasoCausa' => $contratoServidorCasoCausa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pessoal\ContratoServidorCasoCausa entity.
     * @param Request $request
     * @param ContratoServidorCasoCausa $contratoServidorCasoCausa
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, ContratoServidorCasoCausa $contratoServidorCasoCausa)
    {

        $form = $this->createDeleteForm($contratoServidorCasoCausa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contratoServidorCasoCausa);
            $em->flush();
        }

        return $this->redirectToRoute('pessoal_rescisao_contrato_index');
    }

    /**
     * Creates a form to delete a Pessoal\ContratoServidorCasoCausa entity.
     *
     * @param ContratoServidorCasoCausa $contratoServidorCasoCausa The Pessoal\ContratoServidorCasoCausa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ContratoServidorCasoCausa $contratoServidorCasoCausa)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'pessoal_rescisao_contrato_delete',
                    array('id' => $contratoServidorCasoCausa->getCodContrato()->getCodContrato()->getCodContrato())
                )
            )
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
