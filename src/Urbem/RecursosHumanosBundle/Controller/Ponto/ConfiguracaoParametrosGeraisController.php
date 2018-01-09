<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ponto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais;
use Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoParametrosGeraisType;

/**
 * Ponto\ConfiguracaoParametrosGerais controller.
 *
 */
class ConfiguracaoParametrosGeraisController extends Controller
{
    /**
     * Lists all Ponto\ConfiguracaoParametrosGerais entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ponto = $em->getRepository('CoreBundle:Ponto\ConfiguracaoParametrosGerais')->findAll();

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoParametrosGerais/index.html.twig', array(
            'pontos' => $ponto,
        ));
    }

    /**
     * Creates a new Ponto\ConfiguracaoParametrosGerais entity.
     *
     */
    public function newAction(Request $request)
    {
        $ponto = new ConfiguracaoParametrosGerais();
        $form = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoParametrosGeraisType',
            $ponto
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponto);
            $em->flush();

            return $this->redirectToRoute('ponto_configuracao_parametros_gerais_show', array('id' => $ponto->getId()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoParametrosGerais/new.html.twig', array(
            'ponto' => $ponto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ponto\ConfiguracaoParametrosGerais entity.
     *
     */
    public function showAction(ConfiguracaoParametrosGerais $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoParametrosGerais/show.html.twig', array(
            'ponto' => $ponto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ponto\ConfiguracaoParametrosGerais entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoParametrosGerais $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);
        $editForm =
        $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoParametrosGeraisType',
            $ponto
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ponto);
            $em->flush();

            return $this->redirectToRoute('ponto_configuracao_parametros_gerais_edit', array('id' => $ponto->getId()));
        }

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoParametrosGerais/edit.html.twig', array(
            'ponto' => $ponto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ponto\ConfiguracaoParametrosGerais entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoParametrosGerais $ponto)
    {
        $form = $this->createDeleteForm($ponto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ponto);
            $em->flush();
        }

        return $this->redirectToRoute('ponto_configuracao_parametros_gerais_index');
    }

    /**
     * Creates a form to delete a Ponto\ConfiguracaoParametrosGerais entity.
     *
     * @param ConfiguracaoParametrosGerais $ponto The Ponto\ConfiguracaoParametrosGerais entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoParametrosGerais $ponto)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'ponto_configuracao_parametros_gerais_delete',
                    array('id' => $ponto->getId())
                )
            )
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
