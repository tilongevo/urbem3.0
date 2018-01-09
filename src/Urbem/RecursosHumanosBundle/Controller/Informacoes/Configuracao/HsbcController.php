<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Configuracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta;

/**
 * Ima\ConfiguracaoHsbcConta controller.
 *
 */
class HsbcController extends BaseController
{
    /**
     * Lists all Ima\ConfiguracaoHsbcConta entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $configuracoes = $em->getRepository('CoreBundle:Ima\ConfiguracaoHsbcConta')->findAll();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Hsbc/index.html.twig', array(
            'configuracoes' => $configuracoes,
        ));
    }

    /**
     * Creates a new Ima\ConfiguracaoHsbcConta entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $configuracao = new ConfiguracaoHsbcConta();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoHsbcType', $configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $configuracao->setTimestamp(new \DateTime());
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_hsbc_show', array('id' => $configuracao->getCodContaCorrente()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Hsbc/new.html.twig', array(
            'configuracao' => $configuracao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ima\ConfiguracaoHsbcConta entity.
     *
     */
    public function showAction(ConfiguracaoHsbcConta $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodContaCorrente()]);

        $deleteForm = $this->createDeleteForm($configuracao);

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Hsbc/show.html.twig', array(
            'configuracao' => $configuracao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ima\ConfiguracaoHsbcConta entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoHsbcConta $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodContaCorrente()]);

        $deleteForm = $this->createDeleteForm($configuracao);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoHsbcType', $configuracao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_hsbc_edit', array('id' => $configuracao->getCodContaCorrente()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Hsbc/edit.html.twig', array(
            'configuracao' => $configuracao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ima\ConfiguracaoHsbcConta entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoHsbcConta $configuracao)
    {
        $form = $this->createDeleteForm($configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuracao);
            $em->flush();
        }

        return $this->redirectToRoute('informacoes_configuracao_hsbc_index');
    }

    /**
     * Creates a form to delete a Ima\ConfiguracaoHsbcConta entity.
     *
     * @param ConfiguracaoHsbcConta $configuracao The Ima\ConfiguracaoHsbcConta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoHsbcConta $configuracao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('informacoes_configuracao_hsbc_delete', array('id' => $configuracao->getCodContaCorrente())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
