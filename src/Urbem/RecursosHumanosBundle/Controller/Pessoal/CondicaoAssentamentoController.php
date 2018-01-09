<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento;

/**
 * Pessoal\CondicaoAssentamento controller.
 *
 */
class CondicaoAssentamentoController extends BaseController
{
    /**
     * Lists all Pessoal\CondicaoAssentamento entities.
     *
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $condicaoAssentamentos = $em->getRepository('CoreBundle:Pessoal\CondicaoAssentamento')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($condicaoAssentamentos, $request->query->get('page', 1), $this->itensPerPage);

        return $this->render('RecursosHumanosBundle::Pessoal/Condicaoassentamento/index.html.twig', array(
            'condicaoAssentamentos' => $pagination,
        ));
    }

    /**
     * Creates a new Pessoal\CondicaoAssentamento entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $this->setBreadCrumb();

        $condicaoAssentamento = new CondicaoAssentamento();
        $form = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\Pessoal\CondicaoAssentamentoType',
            $condicaoAssentamento
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $condicaoAssentamento->setTimestamp(new \DateTime());
            $em->persist($condicaoAssentamento);
            $em->flush();

            return $this->redirectToRoute(
                'pessoal_condicao_assentamento_show',
                array('id' => $condicaoAssentamento->getCodCondicao())
            );
        }

        return $this->render('RecursosHumanosBundle::Pessoal/Condicaoassentamento/new.html.twig', array(
            'condicaoAssentamento' => $condicaoAssentamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pessoal\CondicaoAssentamento entity.
     * @param CondicaoAssentamento $condicaoAssentamento
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(CondicaoAssentamento $condicaoAssentamento)
    {
        $this->setBreadCrumb(['id' => $condicaoAssentamento->getCodCondicao()]);

        $deleteForm = $this->createDeleteForm($condicaoAssentamento);

        return $this->render('RecursosHumanosBundle::Pessoal/Condicaoassentamento/show.html.twig', array(
            'condicaoAssentamento' => $condicaoAssentamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pessoal\CondicaoAssentamento entity.
     * @param Request $request
     * @param CondicaoAssentamento $condicaoAssentamento
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, CondicaoAssentamento $condicaoAssentamento)
    {
        $this->setBreadCrumb(['id' => $condicaoAssentamento->getCodCondicao()]);

        $deleteForm = $this->createDeleteForm($condicaoAssentamento);
        $editForm = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\Pessoal\CondicaoAssentamentoType',
            $condicaoAssentamento
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($condicaoAssentamento);
            $em->flush();

            return $this->redirectToRoute(
                'pessoal_condicao_assentamento_edit',
                array('id' => $condicaoAssentamento->getCodCondicao())
            );
        }

        return $this->render('RecursosHumanosBundle::Pessoal/Condicaoassentamento/edit.html.twig', array(
            'condicaoAssentamento' => $condicaoAssentamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pessoal\CondicaoAssentamento entity.
     * @param Request $request
     * @param CondicaoAssentamento $condicaoAssentamento
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, CondicaoAssentamento $condicaoAssentamento)
    {
        $form = $this->createDeleteForm($condicaoAssentamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($condicaoAssentamento);
            $em->flush();
        }

        return $this->redirectToRoute('pessoal_condicao_assentamento_index');
    }

    /**
     * Creates a form to delete a Pessoal\CondicaoAssentamento entity.
     *
     * @param CondicaoAssentamento $condicaoAssentamento The Pessoal\CondicaoAssentamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CondicaoAssentamento $condicaoAssentamento)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'pessoal_condicao_assentamento_delete',
                    array('id' => $condicaoAssentamento->getCodCondicao())
                )
            )
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
