<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\CargoPadrao;
use Urbem\CoreBundle\Entity\Pessoal\Cbo;
use Urbem\CoreBundle\Entity\Pessoal\CboCargo;
use Urbem\CoreBundle\Entity\Pessoal\Requisito;
use Urbem\CoreBundle\Entity\Folhapagamento\Padrao;
use Urbem\CoreBundle\Model;

/**
 * Pessoal\Cargo controller.
 */
class CargoController extends ControllerCore\BaseController
{
    /**
     * Lists all Pessoal\Cargo entities.
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cargos = $em->getRepository('CoreBundle:Pessoal\Cargo')->findAll();

        $this->setBreadCrumb();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($cargos, $request->query->get('page', 1), $this->itensPerPage);

        return $this->render('RecursosHumanosBundle::Pessoal/Cargo/index.html.twig', array(
            'cargos' => $pagination,
        ));
    }

    /**
     * Creates a new Pessoal\Cargo entity.
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $cargo = new Cargo();

        $form = $this
            ->createForm(
                'Urbem\RecursosHumanosBundle\Form\Pessoal\CargoType',
                $cargo
            );
        $form->handleRequest($request);
        $formData = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $datetime = new \DateTime();

            $cargo->setCodEscolaridade($formData['cargo']['codEscolaridade']);
            $em->persist($cargo);
            $em->flush();

            $cbo = (new Model\Pessoal\CboModel($em))
                ->getCboById($formData['cargo']['cbo']);

            $cboCargo = new CboCargo();
            $cboCargo->setTimestamp($datetime);
            $cboCargo->setCodCargo($cargo);
            $cboCargo->setCodCbo($cbo);
            $em->persist($cboCargo);
            $em->flush();

            $padrao = (new Model\Folhapagamento\PadraoModel($em))
                ->getPadraoByCodPadrao($formData['cargo']['padrao']);

            $cargoPadrao = new CargoPadrao();
            $cargoPadrao->setTimestamp($datetime);
            $cargoPadrao->setCodCargo($cargo);
            $cargoPadrao->setCodPadrao($padrao);
            $em->persist($cargoPadrao);
            $em->flush();

            return $this->redirectToRoute('pessoal_cargo_show', array('id' => $cargo->getCodCargo()));
        }

        return $this->render('RecursosHumanosBundle::Pessoal/Cargo/new.html.twig', array(
            'cargo' => $cargo,
            'form' => $form->createView(),
            'errors' => $form->getErrors()
        ));
    }

    /**
     * Finds and displays a Pessoal\Cargo entity.
     */
    public function showAction(Cargo $cargo)
    {
        $this->setBreadCrumb(['id' => $cargo->getCodCargo()]);

        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($cargo);


        $cboCargo = (new Model\Pessoal\CboCargoModel($em))
            ->getCboCargoByCodCargo($cargo->getCodCargo());

        $cargoPadrao = (new Model\Pessoal\CargoPadraoModel($em))
            ->getCargoPadraoByCodCargo($cargo->getCodCargo());

        return $this->render('RecursosHumanosBundle::Pessoal/Cargo/show.html.twig', array(
            'cargo' => $cargo,
            'delete_form' => $deleteForm->createView(),
            'cbo' => $cboCargo,
            'padrao' => $cargoPadrao
        ));
    }

    /**
     * Displays a form to edit an existing Pessoal\Cargo entity.
     */
    public function editAction(Request $request, Cargo $cargo)
    {
        $this->setBreadCrumb(['id' => $cargo->getCodCargo()]);

        $deleteForm = $this->createDeleteForm($cargo);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Pessoal\CargoType', $cargo);
        $editForm->handleRequest($request);
        $formData = $request->request->all();

        $em = $this->getDoctrine()->getManager();

        /**
         * Verify that the Cbo linked to Cargo exists
         */
        $cboCargoExists = (new Model\Pessoal\CboCargoModel($em))
            ->getCboCargoByCodCargo($cargo->getCodCargo());

        /**
         * In case the CboCargo exists, then get the codCbo
         */
        $cbo = false;
        if ($cboCargoExists != null) {
            $cbo = $cboCargoExists->getCodCbo()->getCodCbo();
        }

        /**
         * Verify that the Padrao linked to Cargo exists
         */
        $cargoPadraoExists = (new Model\Pessoal\CargoPadraoModel($em))
            ->getCargoPadraoByCodCargo($cargo->getCodCargo());

        /**
         * In case the CboCargo exists, then get the codCbo
         */
        $padrao = false;
        if ($cargoPadraoExists != null) {
            $padrao = $cargoPadraoExists->getCodPadrao()->getCodPadrao();
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $datetime = new \DateTime();


            $cargo->setCodEscolaridade($formData['cargo']['codEscolaridade']);
            $em->persist($cargo);
            $em->flush();

            $cboExists = (new Model\Pessoal\CboModel($em))
                ->getCboById($formData['cargo']['cbo']);

            if ($cbo) {
                $cboCargo = (new Model\Pessoal\CboCargoModel($em))
                    ->getCboCargoByCodCargoCodCbo($cargo->getCodCargo(), $cbo);
            } else {
                $cboCargo = new CboCargo();
            }

            $cboCargo->setTimestamp($datetime);
            $cboCargo->setCodCargo($cargo);
            $cboCargo->setCodCbo($cboExists);
            $em->persist($cboCargo);
            $em->flush();

            $padraoExists = (new Model\Folhapagamento\PadraoModel($em))
                ->getPadraoByCodPadrao($formData['cargo']['padrao']);

            if ($padrao) {
                $cargoPadrao = (new Model\Pessoal\CargoPadraoModel($em))
                    ->getCargoPadraoByCodCargoCodPadrao($cargo->getCodCargo(), $padrao);
            } else {
                $cargoPadrao = new CargoPadrao();
            }
            $cargoPadrao->setTimestamp($datetime);
            $cargoPadrao->setCodCargo($cargo);
            $cargoPadrao->setCodPadrao($padraoExists);
            $em->persist($cargoPadrao);
            $em->flush();

            return $this->redirectToRoute('pessoal_cargo_edit', array('id' => $cargo->getCodCargo()));
        }

        return $this->render('RecursosHumanosBundle::Pessoal/Cargo/edit.html.twig', array(
            'cargo' => $cargo,
            'edit_form' => $editForm->createView(),
            'errors' => $editForm->getErrors(),
            'delete_form' => $deleteForm->createView(),
            'cbo' => $cbo,
            'padrao' => $padrao,
        ));
    }

    /**
     * Deletes a Pessoal\Cargo entity.
     */
    public function deleteAction(Request $request, Cargo $cargo)
    {
        $form = $this->createDeleteForm($cargo);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $cboCargo = (new Model\Pessoal\CboCargoModel($em))
            ->getCboCargoByCodCargo($cargo->getCodCargo());

        $cargoPadrao = (new Model\Pessoal\CargoPadraoModel($em))
            ->getCargoPadraoByCodCargo($cargo->getCodCargo());

        if ($request->getMethod() == "GET") {
            $em->getConnection()->beginTransaction();
            try {
                $em->remove($cboCargo);
                $em->remove($cargoPadrao);
                $em->remove($cargo);
                $em->flush();
                $em->getConnection()->commit();
                return $this->redirectToRoute('pessoal_cargo_index');
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage(), 1);
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em->getConnection()->beginTransaction();
            try {
                $em->remove($cboCargo);
                $em->remove($cargoPadrao);
                $em->remove($cargo);
                $em->flush();
                $em->getConnection()->commit();
                return $this->redirectToRoute('pessoal_cargo_index');
            } catch (\Exception $e) {
                throw new Exception($e->getMessage(), 1);
            }
        }
    }

    /**
     * Creates a form to delete a Pessoal\Cargo entity.
     *
     * @param Cargo $cargo The Pessoal\Cargo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cargo $cargo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pessoal_cargo_delete', array('id' => $cargo->getCodCargo())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
