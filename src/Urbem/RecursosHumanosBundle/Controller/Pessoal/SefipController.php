<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbem\CoreBundle\Entity\Pessoal\Sefip;

/**
 * Pessoal\Sefip controller.
 *
 */
class SefipController extends Controller
{
    /**
     * Lists all Pessoal\Sefip entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sefips = $em->getRepository('CoreBundle:Pessoal\Sefip')->findAll();

        return $this->render('RecursosHumanosBundle::Pessoal/Sefip/index.html.twig', array(
            'sefips' => $sefips,
        ));
    }

    /**
     * Creates a new Pessoal\Sefip entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $sefip = new Sefip();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Pessoal\SefipType', $sefip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sefip);
            $em->flush();

            return $this->redirectToRoute('pessoal_sefip_show', array('id' => $sefip->getCodSefip()));
        }

        return $this->render('RecursosHumanosBundle::Pessoal/Sefip/new.html.twig', array(
            'sefip' => $sefip,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pessoal\Sefip entity.
     * @param Sefip $sefip
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Sefip $sefip)
    {
        $deleteForm = $this->createDeleteForm($sefip);

        return $this->render('RecursosHumanosBundle::Pessoal/Sefip/show.html.twig', array(
            'sefip' => $sefip,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pessoal\Sefip entity.
     * @param Request $request
     * @param Sefip $sefip
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Sefip $sefip)
    {
        $deleteForm = $this->createDeleteForm($sefip);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Pessoal\SefipType', $sefip);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sefip);
            $em->flush();

            return $this->redirectToRoute('pessoal_sefip_edit', array('id' => $sefip->getCodSefip()));
        }

        return $this->render('RecursosHumanosBundle::Pessoal/Sefip/edit.html.twig', array(
            'sefip' => $sefip,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pessoal\Sefip entity.
     * @param Request $request
     * @param Sefip $sefip
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Sefip $sefip)
    {
        $form = $this->createDeleteForm($sefip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sefip);
            $em->flush();
        }

        return $this->redirectToRoute('pessoal_sefip_index');
    }

    /**
     * Creates a form to delete a Pessoal\Sefip entity.
     *
     * @param Sefip $sefip The Pessoal\Sefip entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sefip $sefip)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pessoal_sefip_delete', array('id' => $sefip->getCodSefip())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
