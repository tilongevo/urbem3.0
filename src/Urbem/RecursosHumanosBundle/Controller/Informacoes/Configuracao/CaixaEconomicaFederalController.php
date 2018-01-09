<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Configuracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Ima\ConfiguracaoConvenioCaixaEconomicaFederal;

/**
 * Ima\ConfiguracaoConvenioCaixaEconomicaFederal controller.
 *
 */
class CaixaEconomicaFederalController extends BaseController
{
    /**
     * Lists all Ima\ConfiguracaoConvenioCaixaEconomicaFederal entities.
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $configuracoes = $em->getRepository('CoreBundle:Ima\ConfiguracaoConvenioCaixaEconomicaFederal')->findAll();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/CaixaEconomicaFederal/index.html.twig', array(
            'configuracoes' => $configuracoes,
        ));
    }

    /**
     * Creates a new Ima\ConfiguracaoConvenioCaixaEconomicaFederal entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $configuracao = new ConfiguracaoConvenioCaixaEconomicaFederal();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoCaixaEconomicaFederalType', $configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_caixa_economica_show', array('id' => $configuracao->getCodConvenio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/CaixaEconomicaFederal/new.html.twig', array(
            'configuracao' => $configuracao,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ima\ConfiguracaoConvenioCaixaEconomicaFederal entity.
     *
     */
    public function showAction(ConfiguracaoConvenioCaixaEconomicaFederal $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodConvenio()]);

        $deleteForm = $this->createDeleteForm($configuracao);

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/CaixaEconomicaFederal/show.html.twig', array(
            'configuracao' => $configuracao,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ima\ConfiguracaoConvenioCaixaEconomicaFederal entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoConvenioCaixaEconomicaFederal $configuracao)
    {
        $this->setBreadCrumb(['id' => $configuracao->getCodConvenio()]);

        $deleteForm = $this->createDeleteForm($configuracao);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Informacoes\ConfiguracaoCaixaEconomicaFederalType', $configuracao);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuracao);
            $em->flush();

            return $this->redirectToRoute('informacoes_configuracao_caixa_economica_edit', array('id' => $configuracao->getCodConvenio()));
        }

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/CaixaEconomicaFederal/edit.html.twig', array(
            'configuracao' => $configuracao,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ima\ConfiguracaoConvenioCaixaEconomicaFederal entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoConvenioCaixaEconomicaFederal $configuracao)
    {
        $form = $this->createDeleteForm($configuracao);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuracao);
            $em->flush();
        }

        return $this->redirectToRoute('informacoes_configuracao_caixa_economica_index');
    }

    /**
     * Creates a form to delete a Ima\ConfiguracaoConvenioCaixaEconomicaFederal entity.
     *
     * @param ConfiguracaoConvenioCaixaEconomicaFederal $configuracao The Ima\ConfiguracaoConvenioCaixaEconomicaFederal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoConvenioCaixaEconomicaFederal $configuracao)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('informacoes_configuracao_caixa_economica_delete', array('id' => $configuracao->getCodConvenio())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
