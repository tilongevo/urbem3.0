<?php

namespace Urbem\RecursosHumanosBundle\Controller\Calendario;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro;
use Urbem\CoreBundle\Model\Calendario\CalendarioModel;

/**
 * Calendario\CalendarioCadastro controller.
 *
 */
class CalendarioCadastroController extends ControllerCore\BaseController
{
    const VIEW_PATH = 'RecursosHumanosBundle::Calendario/CalendarioCadastro';

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexCalendarioAction(Request $request)
    {
        $this->setBreadCrumb();
        $viewCalendario = $this->arrayFeriadosCalendario();
        return $this->render(
            self::VIEW_PATH . '/index.html.twig',
            array(
                'calendarios' => $viewCalendario
            )
        );
    }

    /**
     * Lists all Calendario\CalendarioCadastro entities.
     *
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();
        $calendarioCadastros = $em->getRepository('CoreBundle:Calendario\CalendarioCadastro')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $calendarioCadastros,
            $request->query->get('page', 1),
            $this->itensPerPage
        );

        return $this->render(
            self::VIEW_PATH . '/list.html.twig',
            array(
                'calendariosCadastrados' => $pagination
            )
        );
    }

    /**
     * Creates a new Calendario\CalendarioCadastro entity.
     *
     */
    public function newAction(Request $request)
    {
        $calendarioCadastro = new CalendarioCadastro();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\Calendario\CalendarioCadastroType', $calendarioCadastro);
        $form->handleRequest($request);

        $this->setBreadCrumb();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendarioCadastro);
            $em->flush();

            return $this->redirectToRoute('calendario_calendario_cadastro_show', array('id' => $calendarioCadastro->getCodCalendar()));
        }

        return $this->render(
            self::VIEW_PATH . '/new.html.twig',
            array(
                'calendarioCadastro' => $calendarioCadastro,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Calendario\CalendarioCadastro entity.
     *
     */
    public function showAction(CalendarioCadastro $calendarioCadastro)
    {
        $this->setBreadCrumb(['id'=>$calendarioCadastro->getCodCalendar()]);

        return $this->redirectToRoute('calendario_calendario_cadastro_index');
    }

    /**
     * Displays a form to edit an existing Calendario\CalendarioCadastro entity.
     *
     */
    public function editAction(Request $request, CalendarioCadastro $calendarioCadastro)
    {
        $editForm = $this->createForm('Urbem\RecursosHumanosBundle\Form\Calendario\CalendarioCadastroType', $calendarioCadastro);
        $editForm->handleRequest($request);

        $this->setBreadCrumb(['id'=>$calendarioCadastro->getCodCalendar()]);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendarioCadastro);
            $em->flush();

            return $this->redirectToRoute('calendario_calendario_cadastro_edit', array('id' => $calendarioCadastro->getCodCalendar()));
        }

        return $this->render(
            self::VIEW_PATH . '/edit.html.twig',
            array(
                'calendarioCadastro' => $calendarioCadastro,
                'edit_form' => $editForm->createView()
            )
        );
    }

    /**
     * Deletes a calendarioCadastro entity.
     *
     */
    public function deleteAction(Request $request, CalendarioCadastro $calendarioCadastro)
    {

        $form = $this->createDeleteForm($calendarioCadastro);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        try {
            $em->remove($calendarioCadastro);
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', $this->admin->trans('flash_delete_cadastro_success', [], 'flashes'));
        } catch (Exception $e) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', $this->admin->trans('flash_delete_error', [], 'flashes'));
            throw $e;
        }

        return $this->redirectToRoute('calendario_calendario_cadastro_list');
    }

    private function createDeleteForm(CalendarioCadastro $calendarioCadastro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calendario_calendario_cadastro_delete', array('id' => $calendarioCadastro->getCodCalendar())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Monta o array para exibir os eventos/feriados no calendario
     * O parse é feito com um helper no twig
     * @return array
     */
    protected function arrayFeriadosCalendario()
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $calendarioCadastros = $em->getRepository('CoreBundle:Calendario\Feriado')->findAll();

            $feriadoModel = new CalendarioModel($this->db, $this->get('translator'));
            $cores = $feriadoModel->getCorByTipoFeriado();

            $viewCalendario = [];
            if (!empty($calendarioCadastros)) {
                $aux = 0;
                foreach ($calendarioCadastros as $calendario) {
                    switch ($calendario->getTipoferiado()) {
                        case 'F':
                            $feriadoInfo =    $calendario->getFkCalendarioFeriadoVariavel();
                            break;

                        case 'P':
                            $feriadoInfo =    $calendario->getFkCalendarioPontoFacultativo();
                            break;

                        case 'D':
                            $feriadoInfo =    $calendario->getFkCalendarioDiaCompensado();
                            break;

                        case 'V':
                            $feriadoInfo =    $calendario->getFkCalendarioFeriadoVariavel();
                            break;
                    }

                    if ($feriadoInfo !== null) {
                        $viewCalendario[$aux]['title'] = $feriadoInfo->getFkCalendarioFeriado()->getDescricao();
                        $viewCalendario[$aux]['titleTwo'] = $calendario->getDescricao();
                        $viewCalendario[$aux]['start'] = $feriadoInfo->getFkCalendarioFeriado()->getDtFeriado()->format('Y-m-d');
                        $viewCalendario[$aux]['url'] = $this->generateUrl('urbem_recursos_humanos_calendario_feriado_show', ['id' => $feriadoInfo->getFkCalendarioFeriado()->getCodFeriado()]);
                        $viewCalendario[$aux]['color'] = $cores[$feriadoInfo->getFkCalendarioFeriado()->getTipoFeriado()];
                        $aux++;
                    }
                }
            }
            return $viewCalendario;
        } catch (\Exception $e) {
            $this->getLogger()->error($e->getMessage());
        }
    }
}
