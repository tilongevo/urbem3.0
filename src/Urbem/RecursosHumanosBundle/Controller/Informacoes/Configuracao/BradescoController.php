<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Configuracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioBradesco;

/**
 * Ima\ConfiguracaoConvenioBradesco controller.
 *
 */
class BradescoController extends BaseController
{
    /**
     * Lists all Ima\ConfiguracaoConvenioBradesco entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $configuracoes = $em->getRepository('CoreBundle:Ima\ConfiguracaoConvenioBradesco')->findAll();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Bradesco/index.html.twig', array(
            'configuracoes' => $configuracoes,
        ));
    }

    /**
     * Creates a new Ima\ConfiguracaoConvenioBradesco entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $configuracao = new ConfiguracaoConvenioBradesco();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoBradescoType', $configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_bradesco_show', array('id' => $configuracao->getCodConvenio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/Bradesco/new.html.twig', array(
            'configuracao' => $configuracao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ima\ConfiguracaoConvenioBradesco entity.
     *
     */
    public function showAction(ConfiguracaoConvenioBradesco $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodConvenio()]);

        $deleteForm = $this->createDeleteForm($configuracao);

        return $this->render('RecursosHumanosBundle:Informacoes/Configuracao/Bradesco/show.html.twig', array(
            'configuracao' => $configuracao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ima\ConfiguracaoConvenioBradesco entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoConvenioBradesco $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodConvenio()]);

        $deleteForm = $this->createDeleteForm($configuracao);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoBradescoType', $configuracao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_bradesco_edit', array('id' => $configuracao->getCodConvenio()));
        }

        return $this->render('RecursosHumanosBundle:Informacoes/Configuracao/Bradesco/edit.html.twig', array(
            'configuracao' => $configuracao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ima\ConfiguracaoConvenioBradesco entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoConvenioBradesco $configuracao)
    {
        $form = $this->createDeleteForm($configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuracao);
            $em->flush();
        }

        return $this->redirectToRoute('informacoes_configuracao_bradesco_index');
    }

    /**
     * Creates a form to delete a Ima\ConfiguracaoConvenioBradesco entity.
     *
     * @param ConfiguracaoConvenioBradesco $configuracao The Ima\ConfiguracaoConvenioBradesco entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoConvenioBradesco $configuracao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('informacoes_configuracao_bradesco_delete', array('id' => $configuracao->getCodConvenio())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
