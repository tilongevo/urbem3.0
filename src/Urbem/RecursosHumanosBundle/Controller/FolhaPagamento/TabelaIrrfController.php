<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Folhapagamento\TabelaIrrf controller.
 *
 */
class TabelaIrrfController extends ControllerCore\BaseController
{
    const VIEW_PATH = "RecursosHumanosBundle::FolhaPagamento/IRRF/TabelaIRRF";

    /**
     * Lists all Folhapagamento\TabelaIrrf entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadcrumb();

        $em = $this->getDoctrine()->getManager();

        $tabelasIrrf = $em->getRepository('CoreBundle:Folhapagamento\TabelaIrrf')->findAll();

        return $this->render(
            self::VIEW_PATH . '/index.html.twig',
            array(
                'tabelasIrrf' => $tabelasIrrf,
            )
        );
    }

    /**
     * Creates a new Folhapagamento\TabelaIrrf entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $tabelaIrrf = new TabelaIrrf();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\FolhaPagamento\TabelaIrrfType', $tabelaIrrf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tabelaIrrf);
            $em->flush();

            return $this->redirectToRoute('folha_pagamento_irrf_tabela_show', array('id' => $tabelaIrrf->getId()));
        }

        return $this->render(
            self::VIEW_PATH . '/new.html.twig',
            array(
                'tabelaIrrf' => $tabelaIrrf,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Folhapagamento\TabelaIrrf entity.
     *
     */
    public function showAction(TabelaIrrf $tabelaIrrf)
    {
        $this->setBreadCrumb(array('id' => $tabelaIrrf->getId()));

        $deleteForm = $this->createDeleteForm($tabelaIrrf);

        return $this->render(
            self::VIEW_PATH . '/show.html.twig',
            array(
                'tabelaIrrf' => $tabelaIrrf,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Folhapagamento\TabelaIrrf entity.
     *
     */
    public function editAction(Request $request, TabelaIrrf $tabelaIrrf)
    {
        $this->setBreadCrumb(array('id' => $tabelaIrrf->getId()));

        $deleteForm = $this->createDeleteForm($tabelaIrrf);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\FolhaPagamento\TabelaIrrfType', $tabelaIrrf);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tabelaIrrf);
            $em->flush();

            return $this->redirectToRoute('folha_pagamento_irrf_tabela_edit', array('id' => $tabelaIrrf->getId()));
        }

        return $this->render(
            self::VIEW_PATH . '/edit.html.twig',
            array(
                'tabelaIrrf' => $tabelaIrrf,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Folhapagamento\TabelaIrrf entity.
     *
     */
    public function deleteAction(Request $request, TabelaIrrf $tabelaIrrf)
    {
        $form = $this->createDeleteForm($tabelaIrrf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tabelaIrrf);
            $em->flush();
        }

        return $this->redirectToRoute('folha_pagamento_irrf_tabela_index');
    }

    /**
     * Creates a form to delete a Folhapagamento\TabelaIrrf entity.
     *
     * @param TabelaIrrf $tabelaIrrf The Folhapagamento\TabelaIrrf entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TabelaIrrf $tabelaIrrf)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('folha_pagamento_irrf_tabela_delete', array('id' => $tabelaIrrf->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
