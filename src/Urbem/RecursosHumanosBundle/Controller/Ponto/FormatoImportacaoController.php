<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ponto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbem\CoreBundle\Entity\Ponto\FormatoImportacao;
use Urbem\RecursosHumanosBundle\Form\Ponto\FormatoImportacaoType;

/**
 * Ponto\FormatoImportacao controller.
 *
 */
class FormatoImportacaoController extends Controller
{
    /**
     * Lists all Ponto\FormatoImportacao entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ponto = $em->getRepository('CoreBundle:Ponto\FormatoImportacao')->findAll();

        return $this->render('RecursosHumanosBundle::Ponto/FormatoImportacao/index.html.twig', array(
            'pontos' => $ponto,
        ));
    }

    /**
     * Creates a new Ponto\FormatoImportacao entity.
     *
     */
    public function newAction(Request $request)
    {
        $ponto = new FormatoImportacao();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Ponto\FormatoImportacaoType', $ponto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponto);
            $em->flush();

            return $this->redirectToRoute('ponto_formato_importacao_show', array('id' => $ponto->getCodFormato()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/FormatoImportacao/new.html.twig', array(
            'ponto' => $ponto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ponto\FormatoImportacao entity.
     *
     */
    public function showAction(FormatoImportacao $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);

        return $this->render('RecursosHumanosBundle::Ponto/FormatoImportacao/show.html.twig', array(
            'ponto' => $ponto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ponto\FormatoImportacao entity.
     *
     */
    public function editAction(Request $request, FormatoImportacao $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Ponto\FormatoImportacaoType', $ponto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponto);
            $em->flush();

            return $this->redirectToRoute('ponto_formato_importacao_edit', array('id' => $ponto->getCodFormato()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/FormatoImportacao/edit.html.twig', array(
            'ponto' => $ponto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ponto\FormatoImportacao entity.
     *
     */
    public function deleteAction(Request $request, FormatoImportacao $ponto)
    {
        $form = $this->createDeleteForm($ponto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ponto);
            $em->flush();
        }

        return $this->redirectToRoute('ponto_formato_importacao_index');
    }

    /**
     * Creates a form to delete a Ponto\FormatoImportacao entity.
     *
     * @param FormatoImportacao $ponto The Ponto\FormatoImportacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FormatoImportacao $ponto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ponto_formato_importacao_delete', array('id' => $ponto->getCodFormato())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
