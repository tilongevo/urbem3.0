<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ponto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2;
use Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoHorasExtras2Type;

/**
 * Ponto\ConfiguracaoHorasExtras2 controller.
 *
 */
class ConfiguracaoHorasExtras2Controller extends Controller
{
    /**
     * Lists all Ponto\ConfiguracaoHorasExtras2 entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pontos = $em->getRepository('CoreBundle:Ponto\ConfiguracaoHorasExtras2')->findAll();

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoHorasExtras2/index.html.twig', array(
            'pontos' => $pontos,
        ));
    }

    /**
     * Creates a new Ponto\ConfiguracaoHorasExtras2 entity.
     *
     */
    public function newAction(Request $request)
    {
        $ponto = new ConfiguracaoHorasExtras2();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoHorasExtras2Type', $ponto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponto);
            $em->flush();

            return $this->redirectToRoute('ponto_configuracao_horas_extras_2_show', array('id' => $ponto->getId()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoHorasExtras2/new.html.twig', array(
            'ponto' => $ponto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ponto\ConfiguracaoHorasExtras2 entity.
     *
     */
    public function showAction(ConfiguracaoHorasExtras2 $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoHorasExtras2/show.html.twig', array(
            'ponto' => $ponto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ponto\ConfiguracaoHorasExtras2 entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoHorasExtras2 $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoHorasExtras2Type', $ponto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponto);
            $em->flush();

            return $this->redirectToRoute('ponto_configuracao_horas_extras_2_edit', array('id' => $ponto->getId()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoHorasExtras2/edit.html.twig', array(
            'ponto' => $ponto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ponto\ConfiguracaoHorasExtras2 entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoHorasExtras2 $ponto)
    {
        $form = $this->createDeleteForm($ponto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ponto);
            $em->flush();
        }

        return $this->redirectToRoute('ponto_configuracao_horas_extras_2_index');
    }

    /**
     * Creates a form to delete a Ponto\ConfiguracaoHorasExtras2 entity.
     *
     * @param ConfiguracaoHorasExtras2 $ponto The Ponto\ConfiguracaoHorasExtras2 entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoHorasExtras2 $ponto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ponto_configuracao_horas_extras_2_delete', array('id' => $ponto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
