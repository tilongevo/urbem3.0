<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Configuracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoPasep;

/**
 * Ima\ConfiguracaoPasep controller.
 *
 */
class PasepController extends BaseController
{
    /**
     * Lists all Ima\ConfiguracaoPasep entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $configuracoes = $em->getRepository('CoreBundle:Ima\ConfiguracaoPasep')->findAll();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Pasep/index.html.twig', array(
            'configuracoes' => $configuracoes,
        ));
    }

    /**
     * Creates a new Ima\ConfiguracaoPasep entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $configuracao = new ConfiguracaoPasep();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoPasepType', $configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_pasep_show', array('id' => $configuracao->getCodConvenio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Pasep/new.html.twig', array(
            'configuracao' => $configuracao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ima\ConfiguracaoPasep entity.
     *
     */
    public function showAction(ConfiguracaoPasep $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodConvenio()]);

        $deleteForm = $this->createDeleteForm($configuracao);

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Pasep/show.html.twig', array(
            'configuracao' => $configuracao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ima\ConfiguracaoPasep entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoPasep $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodConvenio()]);

        $deleteForm = $this->createDeleteForm($configuracao);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoPasepType', $configuracao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_pasep_edit', array('id' => $configuracao->getCodConvenio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Pasep/edit.html.twig', array(
            'configuracao' => $configuracao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ima\ConfiguracaoPasep entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoPasep $configuracao)
    {
        $form = $this->createDeleteForm($configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuracao);
            $em->flush();
        }

        return $this->redirectToRoute('informacoes_configuracao_pasep_index');
    }

    /**
     * Creates a form to delete a Ima\ConfiguracaoPasep entity.
     *
     * @param ConfiguracaoPasep $configuracao The Ima\ConfiguracaoPasep entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoPasep $configuracao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('informacoes_configuracao_pasep_delete', array('id' => $configuracao->getCodConvenio())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
