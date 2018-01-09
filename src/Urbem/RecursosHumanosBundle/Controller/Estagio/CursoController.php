<?php

namespace Urbem\RecursosHumanosBundle\Controller\Estagio;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

use Urbem\CoreBundle\Entity\Estagio\Curso;

/**
 * Estagio\Curso controller.
 *
 */
class CursoController extends ControllerCore\BaseController
{
    const VIEW_PATH = "RecursosHumanosBundle::Estagio/Configuracao/Curso";

    /**
     * Lists all Estagio\Curso entities.
     *
     */
    public function indexAction(Request $request)
    {
        $this->setBreadcrumb();

        $search = $request->get("curso", null);
        $em = $this->getDoctrine()->getManager();

        if (!empty($search)) {
            $cursos = $em->getRepository('CoreBundle:Estagio\Curso')->findByNomCurso($search);
        } else {
            $cursos = $em->getRepository('CoreBundle:Estagio\Curso')->findAll();
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $cursos,
            $request->query->get('page', 1),
            $this->itensPerPage
        );

        return $this->render(
            self::VIEW_PATH . '/index.html.twig',
            array(
                'cursos' => $pagination,
            )
        );
    }

    /**
     * Creates a new Estagio\Curso entity.
     *
     */
    public function newAction(Request $request)
    {
        $this->setBreadcrumb();

        $curso = new Curso();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Estagio\CursoType', $curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($curso);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Salvo com sucesso!");
            return $this->redirectToRoute('estagio_configuracao_curso_index', array('id' => $curso->getId()));
        }

        return $this->render(
            self::VIEW_PATH . '/new.html.twig',
            array(
                'curso' => $curso,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Estagio\Curso entity.
     *
     */
    public function showAction(Curso $curso)
    {
        $this->setBreadcrumb(array('id' => $curso->getId()));

        $deleteForm = $this->createDeleteForm($curso);

        return $this->render(
            self::VIEW_PATH . '/show.html.twig',
            array(
                'curso' => $curso,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Estagio\Curso entity.
     *
     */
    public function editAction(Request $request, Curso $curso)
    {
        $this->setBreadcrumb(array('id' => $curso->getId()));

        $deleteForm = $this->createDeleteForm($curso);
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Estagio\CursoType', $curso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($curso);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', "Salvo com sucesso!");
            return $this->redirectToRoute('estagio_configuracao_curso_index', array('id' => $curso->getId()));
        }

        return $this->render(
            self::VIEW_PATH . '/edit.html.twig',
            array(
                'curso' => $curso,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Estagio\Curso entity.
     *
     */
    public function deleteAction(Request $request, Curso $curso)
    {
        $form = $this->createDeleteForm($curso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($curso);
            $em->flush();
        }

        return $this->redirectToRoute('estagio_configuracao_curso_index');
    }

    /**
     * Creates a form to delete a Estagio\Curso entity.
     *
     * @param Curso $curso The Estagio\Curso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Curso $curso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estagio_configuracao_curso_delete', array('id' => $curso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
