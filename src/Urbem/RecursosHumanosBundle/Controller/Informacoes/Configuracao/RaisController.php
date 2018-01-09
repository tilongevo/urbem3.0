<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Configuracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais;

/**
 * Ima\ConfiguracaoRais controller.
 *
 */
class RaisController extends BaseController
{
    /**
     * Lists all Ima\ConfiguracaoRais entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $configuracoes = $em->getRepository('CoreBundle:Ima\ConfiguracaoRais')->findAll();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Rais/index.html.twig', array(
            'configuracoes' => $configuracoes,
        ));
    }

    /**
     * Creates a new Ima\ConfiguracaoRais entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $configuracao = new ConfiguracaoRais();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoRaisType', $configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_rais_show', array('id' => $configuracao->getExercicio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Rais/new.html.twig', array(
            'configuracao' => $configuracao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ima\ConfiguracaoRais entity.
     *
     */
    public function showAction(ConfiguracaoRais $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getExercicio()]);

        $deleteForm = $this->createDeleteForm($configuracao);

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Rais/show.html.twig', array(
            'configuracao' => $configuracao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ima\ConfiguracaoRais entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoRais $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getExercicio()]);

        $deleteForm = $this->createDeleteForm($configuracao);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoRaisType', $configuracao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_rais_edit', array('id' => $configuracao->getExercicio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Rais/edit.html.twig', array(
            'configuracao' => $configuracao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ima\ConfiguracaoRais entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoRais $configuracao)
    {
        $form = $this->createDeleteForm($configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuracao);
            $em->flush();
        }

        return $this->redirectToRoute('informacoes_configuracao_rais_index');
    }

    /**
     * Creates a form to delete a Ima\ConfiguracaoRais entity.
     *
     * @param ConfiguracaoRais $configuracao The Ima\ConfiguracaoRais entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoRais $configuracao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('informacoes_configuracao_rais_delete', array('id' => $configuracao->getExercicio())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
