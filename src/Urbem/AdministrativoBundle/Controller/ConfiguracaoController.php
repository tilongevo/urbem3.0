<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Administracao\Configuracao controller.
 *
 */
class ConfiguracaoController extends ControllerCore\BaseController
{
    /**
     * Lists all Administracao\Configuracao entities.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $configuracoes = $em->getRepository('CoreBundle:Administracao\Configuracao')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($configuracoes, $request->query->get('page', 1), $this->itensPerPage);

        return $this->render('AdministrativoBundle::Configuracao/index.html.twig', array(
            'configuracoes' => $pagination,
        ));
    }

    /**
     * Creates a new Administracao\Configuracao entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $configuracao = new Configuracao();
        $form = $this->createForm('Urbem\AdministrativoBundle\Form\Configuracao\ConfiguracaoType', $configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('administracao_configuracao_show', array('id' => $configuracao->getId()));
        }

        return $this->render('AdministrativoBundle::Configuracao/new.html.twig', array(
            'configuracao' => $configuracao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Administracao\Configuracao entity.
     * @param Configuracao $configuracao
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Configuracao $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getId()]);

        $deleteForm = $this->createDeleteForm($configuracao);

        return $this->render('AdministrativoBundle::Configuracao/show.html.twig', array(
            'configuracao' => $configuracao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Administracao\Configuracao entity.
     * @param Request $request
     * @param Configuracao $configuracao
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Configuracao $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getId()]);

        $deleteForm = $this->createDeleteForm($configuracao);
        $editForm = $this->createForm('Urbem\AdministrativoBundle\Form\Configuracao\ConfiguracaoType', $configuracao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('administracao_configuracao_edit', array('id' => $configuracao->getId()));
        }

        return $this->render('AdministrativoBundle::Configuracao/edit.html.twig', array(
            'configuracao' => $configuracao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Administracao\Configuracao entity.
     * @param Request $request
     * @param Configuracao $configuracao
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Configuracao $configuracao)
    {
        $this->setBreadCrumb();

        $form = $this->createDeleteForm($configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuracao);
            $em->flush();
        }

        return $this->redirectToRoute('administracao_configuracao_index');
    }

    /**
     * Creates a form to delete a Administracao\Configuracao entity.
     *
     * @param Configuracao $configuracao The Administracao\Configuracao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Configuracao $configuracao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('administracao_configuracao_delete', array('id' => $configuracao->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
