<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Configuracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf;

/**
 * Ima\ConfiguracaoDirf controller.
 *
 */
class DirfController extends BaseController
{
    /**
     * Lists all Ima\ConfiguracaoDirf entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $configuracoes = $em->getRepository('CoreBundle:Ima\ConfiguracaoDirf')->findAll();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Dirf/index.html.twig', array(
            'configuracoes' => $configuracoes,
        ));
    }

    public function homeAction()
    {
        $this->setBreadCrumb();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Dirf/home.html.twig');
    }

    /**
     * Creates a new Ima\ConfiguracaoDirf entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $configuracao = new ConfiguracaoDirf();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoDirfType', $configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_dirf_show', array('id' => $configuracao->getExercicio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Dirf/new.html.twig', array(
            'configuracao' => $configuracao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ima\ConfiguracaoDirf entity.
     *
     */
    public function showAction(ConfiguracaoDirf $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getExercicio()]);

        $deleteForm = $this->createDeleteForm($configuracao);

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Dirf/show.html.twig', array(
            'configuracao' => $configuracao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ima\ConfiguracaoDirf entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoDirf $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getExercicio()]);

        $deleteForm = $this->createDeleteForm($configuracao);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoDirfType', $configuracao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_dirf_edit', array('id' => $configuracao->getExercicio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Dirf/edit.html.twig', array(
            'configuracao' => $configuracao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ima\ConfiguracaoDirf entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoDirf $configuracao)
    {
        $form = $this->createDeleteForm($configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuracao);
            $em->flush();
        }

        return $this->redirectToRoute('informacoes_configuracao_dirf_index');
    }

    /**
     * Creates a form to delete a Ima\ConfiguracaoDirf entity.
     *
     * @param ConfiguracaoDirf $configuracao The Ima\ConfiguracaoDirf entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoDirf $configuracao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('informacoes_configuracao_dirf_delete', array('id' => $configuracao->getExercicio())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
