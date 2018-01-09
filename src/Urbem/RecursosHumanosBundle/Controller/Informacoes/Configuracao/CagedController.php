<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Configuracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged;

/**
 * Ima\ConfiguracaoCaged controller.
 *
 */
class CagedController extends BaseController
{
    /**
     * Lists all Ima\ConfiguracaoCaged entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $configuracoes = $em->getRepository('CoreBundle:Ima\ConfiguracaoCaged')->findAll();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Caged/index.html.twig', array(
            'configuracoes' => $configuracoes,
        ));
    }

    /**
     * Creates a new Ima\ConfiguracaoCaged entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $configuracao = new ConfiguracaoCaged();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoCagedType', $configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_caged_show', array('id' => $configuracao->getCodConfiguracao()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Caged/new.html.twig', array(
            'configuracao' => $configuracao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ima\ConfiguracaoCaged entity.
     *
     */
    public function showAction(ConfiguracaoCaged $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodConfiguracao()]);

        $deleteForm = $this->createDeleteForm($configuracao);

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Caged/show.html.twig', array(
            'configuracao' => $configuracao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ima\ConfiguracaoCaged entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoCaged $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodConfiguracao()]);

        $deleteForm = $this->createDeleteForm($configuracao);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoCagedType', $configuracao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_caged_edit', array('id' => $configuracao->getCodConfiguracao()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Caged/edit.html.twig', array(
            'configuracao' => $configuracao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ima\ConfiguracaoCaged entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoCaged $configuracao)
    {
        $form = $this->createDeleteForm($configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuracao);
            $em->flush();
        }

        return $this->redirectToRoute('informacoes_configuracao_caged_index');
    }

    /**
     * Creates a form to delete a Ima\ConfiguracaoCaged entity.
     *
     * @param ConfiguracaoCaged $configuracao The Ima\ConfiguracaoCaged entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoCaged $configuracao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('informacoes_configuracao_caged_delete', array('id' => $configuracao->getCodConfiguracao())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
