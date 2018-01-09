<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ponto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbem\CoreBundle\Entity\Ponto\Justificativa;
use Urbem\RecursosHumanosBundle\Form\Ponto\JustificativaType;

/**
 * Ponto\Justificativa controller.
 *
 */
class JustificativaController extends Controller
{
    /**
     * Lists all Ponto\Justificativa entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $justificativas = $em->getRepository('CoreBundle:Ponto\Justificativa')->findAll();

        return $this->render('RecursosHumanosBundle::Ponto/Justificativa/index.html.twig', array(
            'justificativas' => $justificativas,
        ));
    }

    /**
     * Creates a new Ponto\Justificativa entity.
     *
     */
    public function newAction(Request $request)
    {
        $justificativa = new Justificativa();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Ponto\JustificativaType', $justificativa);
         $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($justificativa);
            $em->flush();

            return $this->redirectToRoute('ponto_justificativa_show', array('id' => $justificativa->getCodJustificativa()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/Justificativa/new.html.twig', array(
            'Justificativa' => $justificativa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ponto\Justificativa entity.
     *
     */
    public function showAction(Justificativa $justificativa)
    {
        $deleteForm = $this->createDeleteForm($justificativa);

        return $this->render('RecursosHumanosBundle::Ponto/Justificativa/show.html.twig', array(
            'justificativa' => $justificativa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ponto\Justificativa entity.
     *
     */
    public function editAction(Request $request, Justificativa $justificativa)
    {
        $deleteForm = $this->createDeleteForm($justificativa);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Ponto\JustificativaType', $justificativa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($justificativa);
            $em->flush();

            return $this->redirectToRoute('ponto_justificativa_edit', array('id' => $justificativa->getCodJustificativa()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/Justificativa/edit.html.twig', array(
            'ponto\Justificativa' => $justificativa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ponto\Justificativa entity.
     *
     */
    public function deleteAction(Request $request, Justificativa $justificativa)
    {
        $form = $this->createDeleteForm($justificativa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($justificativa);
            $em->flush();
        }

        return $this->redirectToRoute('ponto_justificativa_index');
    }

    /**
     * Creates a form to delete a Ponto\Justificativa entity.
     *
     * @param Justificativa $ponto\Justificativa The Ponto\Justificativa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Justificativa $justificativa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ponto_justificativa_delete', array('id' => $justificativa->getCodJustificativa())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
