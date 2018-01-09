<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ponto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto;
use Urbem\CoreBundle\Model;
use Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoRelogioPontoType;

/**
 * Ponto\ConfiguracaoRelogioPonto controller.
 *
 */
class ConfiguracaoRelogioPontoController extends Controller
{
    /**
     * Lists all Ponto\ConfiguracaoRelogioPonto entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pontos = $em->getRepository('CoreBundle:Ponto\ConfiguracaoRelogioPonto')->findAll();

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoRelogioPonto/index.html.twig', array(
            'pontos' => $pontos,
        ));
    }

    /**
     * Creates a new Ponto\ConfiguracaoRelogioPonto entity.
     *
     */
    public function newAction(Request $request)
    {
        $ponto = new ConfiguracaoRelogioPonto();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoRelogioPontoType', $ponto);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $pontoEntity = (new Model\Ponto\ConfiguracaoRelogioPontoModel($em))
            ->save($ponto);

            return $this->redirectToRoute(
                'ponto_configuracao_relogio_ponto_show',
                array('id' => $pontoEntity->getCodConfiguracao())
            );
        }

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoRelogioPonto/new.html.twig', array(
            'ponto' => $ponto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ponto\ConfiguracaoRelogioPonto entity.
     *
     */
    public function showAction(ConfiguracaoRelogioPonto $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoRelogioPonto/show.html.twig', array(
            'ponto' => $ponto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ponto\ConfiguracaoRelogioPonto entity.
     *
     */
    public function editAction(Request $request, ConfiguracaoRelogioPonto $ponto)
    {
        $deleteForm = $this->createDeleteForm($ponto);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Ponto\ConfiguracaoRelogioPontoType', $ponto);
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $configuracaoParametrosGerais = (new Model\Ponto\ConfiguracaoRelogioPontoModel($em))
        ->getConfiguracaoParametrosGeraisByCodConfiguracao($ponto->getCodConfiguracao());
        $configuracaoHorasExtras2 = (new Model\Ponto\ConfiguracaoRelogioPontoModel($em))
        ->getConfiguracaoHorasExtras2ByCodConfiguracao($ponto->getCodConfiguracao());
        $configuracaoBancoHoras = (new Model\Ponto\ConfiguracaoRelogioPontoModel($em))
        ->getConfiguracaoBancoHorasByCodConfiguracao($ponto->getCodConfiguracao());

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $pontoEntity = (new Model\Ponto\ConfiguracaoRelogioPontoModel($em))
            ->update($ponto);
            
            return $this->redirectToRoute(
                'ponto_configuracao_relogio_ponto_edit',
                array('id' => $ponto->getCodConfiguracao())
            );
        }

        return $this->render('RecursosHumanosBundle::Ponto/ConfiguracaoRelogioPonto/edit.html.twig', array(
            'ponto' => $ponto,
            'edit_form' => $editForm->createView(),
            'configuracaoParametrosGerais' => $configuracaoParametrosGerais,
            'configuracaoHorasExtras2' => $configuracaoHorasExtras2,
            'configuracaoBancoHoras' => $configuracaoBancoHoras,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Ponto\ConfiguracaoRelogioPonto entity.
     *
     */
    public function deleteAction(Request $request, ConfiguracaoRelogioPonto $ponto)
    {
        $form = $this->createDeleteForm($ponto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ponto);
            $em->flush();
        }

        return $this->redirectToRoute('ponto_configuracao_relogio_ponto_index');
    }

    /**
     * Creates a form to delete a Ponto\ConfiguracaoRelogioPonto entity.
     *
     * @param ConfiguracaoRelogioPonto $ponto The Ponto\ConfiguracaoRelogioPonto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfiguracaoRelogioPonto $ponto)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'ponto_configuracao_relogio_ponto_delete',
                    array('id' => $ponto->getCodConfiguracao())
                )
            )
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
