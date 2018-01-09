<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ponto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras;
use Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoBancoHorasType;

/**
 * Ponto\ConfiguracaoBancoHoras controller.
 *
 */
class ConfiguracaoBancoHorasController extends Controller
{
    /**
     * Lists all Ponto\ConfiguracaoBancoHoras entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pontos = $em->getRepository('RecursosHumanosBundle:Ponto\ConfiguracaoBancoHoras')->findAll();

        return $this->render('RecursosHumanosBundle::Ponto/configuracaobancohoras/index.html.twig', array(
            'pontos' => $pontos,
        ));
    }

    /**
     * Creates a new Ponto\ConfiguracaoBancoHoras entity.
     *
     */
    public function newAction(Request $request)
    {
        $ponto = new ConfiguracaoBancoHoras();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\ConfiguracaoBancoHorasType', $ponto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponto);
            $em->flush();

            return $this->redirectToRoute('ponto_configuracao_banco_horas_show', array('id' => $ponto->getId()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/configuracaobancohoras/new.html.twig', array(
            'ponto' => $ponto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ponto\ConfiguracaoBancoHoras entity.
     *
     */
    public function showAction(ConfiguracaoBancoHoras $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);

        return $this->render('RecursosHumanosBundle::Ponto/configuracaobancohoras/show.html.twig', array(
            'ponto' => $ponto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ponto\ConfiguracaoBancoHoras entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoBancoHoras $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\ConfiguracaoBancoHorasType', $ponto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponto);
            $em->flush();

            return $this->redirectToRoute('ponto_configuracao_banco_horas_edit', array('id' => $ponto->getId()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/configuracaobancohoras/edit.html.twig', array(
            'ponto' => $ponto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ponto\ConfiguracaoBancoHoras entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoBancoHoras $ponto)
    {
        $form = $this->createDeleteForm($ponto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ponto);
            $em->flush();
        }

        return $this->redirectToRoute('ponto_configuracao_banco_horas_index');
    }

    /**
     * Creates a form to delete a Ponto\ConfiguracaoBancoHoras entity.
     *
     * @param ConfiguracaoBancoHoras $ponto The Ponto\ConfiguracaoBancoHoras entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoBancoHoras $ponto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ponto_configuracao_banco_horas_delete', array('id' => $ponto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
