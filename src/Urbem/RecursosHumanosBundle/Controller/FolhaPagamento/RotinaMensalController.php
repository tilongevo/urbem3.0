<?php
namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;

class RotinaMensalController extends ControllerCore\BaseController
{
    public function indexAction()
    {
        $this->setBreadCrumb();
        return $this->render('RecursosHumanosBundle::FolhaPagamento/RotinaMensal/index.html.twig');
    }

    /**
     * Lists all Folhapagamento\PeriodoMovimentacao entities.
     *
     */
    public function periodoMovimentacaoIndexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $this->setBreadCrumb();

        $folhapagamentos = $em->getRepository('CoreBundle:Folhapagamento\PeriodoMovimentacao')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($folhapagamentos, $request->query
            ->get('page', 1), $this->itensPerPage);

        return $this->render(
            'RecursosHumanosBundle::FolhaPagamento/RotinaMensal/periodo_movimentacao_index.html.twig',
            array(
                'folhapagamentos' => $pagination,
            )
        );
    }

    /**
     * Creates a new Folhapagamento\PeriodoMovimentacao entity.
     *
     */
    public function periodoMovimentacaoNewAction(Request $request)
    {
        $this->setBreadCrumb();

        $folhapagamento = new PeriodoMovimentacao();
        $form = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\FolhaPagamento\PeriodoMovimentacaoType',
            $folhapagamento
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($folhapagamento);
            $em->flush();

            return $this->redirectToRoute(
                'folha_pagamento_rotina_mensal_periodo_movimentacao_show',
                array('id' => $folhapagamento->getCodPeriodoMovimentacao())
            );
        }

        return $this->render(
            'RecursosHumanosBundle::FolhaPagamento/RotinaMensal/periodo_movimentacao_new.html.twig',
            array(
                'folhapagamento' => $folhapagamento,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Folhapagamento\PeriodoMovimentacao entity.
     *
     */
    public function periodoMovimentacaoShowAction(PeriodoMovimentacao $folhapagamento)
    {
        $this->setBreadCrumb(['id' => $folhapagamento->getCodPeriodoMovimentacao()]);

        $deleteForm = $this->periodoMovimentacaoCreateDeleteForm($folhapagamento);

        return $this->render(
            'RecursosHumanosBundle::FolhaPagamento/RotinaMensal/periodo_movimentacao_show.html.twig',
            array(
                'folhapagamento' => $folhapagamento,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Folhapagamento\PeriodoMovimentacao entity.
     *
     */
    public function periodoMovimentacaoEditAction(Request $request, PeriodoMovimentacao $folhapagamento)
    {
        $this->setBreadCrumb(['id' => $folhapagamento->getCodPeriodoMovimentacao()]);

        $deleteForm = $this->periodoMovimentacaoCreateDeleteForm($folhapagamento);
        $editForm = $this->createForm(
            'Urbem\RecursosHumanosBundle\Form\FolhaPagamento\PeriodoMovimentacaoType',
            $folhapagamento
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($folhapagamento);
            $em->flush();

            return $this->redirectToRoute(
                'folha_pagamento_rotina_mensal_periodo_movimentacao_edit',
                array('id' => $folhapagamento->getCodPeriodoMovimentacao())
            );
        }

        return $this->render(
            'RecursosHumanosBundle::FolhaPagamento/RotinaMensal/periodo_movimentacao_edit.html.twig',
            array(
                'folhapagamento' => $folhapagamento,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Folhapagamento\PeriodoMovimentacao entity.
     *
     */
    public function periodoMovimentacaoDeleteAction(Request $request, PeriodoMovimentacao $folhapagamento)
    {
        $form = $this->createDeleteForm($folhapagamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($folhapagamento);
            $em->flush();
        }

        return $this->redirectToRoute('folha_pagamento_rotina_mensal_periodo_movimentacao_index');
    }

    /**
     * Creates a form to delete a Folhapagamento\PeriodoMovimentacao entity.
     *
     * @param PeriodoMovimentacao $folhapagamento The Folhapagamento\PeriodoMovimentacao entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function periodoMovimentacaoCreateDeleteForm(PeriodoMovimentacao $folhapagamento)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'folha_pagamento_rotina_mensal_periodo_movimentacao_delete',
                    array('id' => $folhapagamento->getCodPeriodoMovimentacao())
                )
            )
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function autorizacaoEmpenhoAction()
    {
        $this->setBreadCrumb();

        $meses = $this->db->getRepository('CoreBundle:Administracao\Mes')->findAll();
        $tiposcalculo = $this->db->getRepository('CoreBundle:Folhapagamento\ConfiguracaoEvento')->findAll();

        return $this->render(
            'RecursosHumanosBundle::FolhaPagamento/RotinaMensal/autorizacao_empenho.html.twig',
            array (
                'meses' => $meses,
                'tiposcalculo' => $tiposcalculo,
            )
        );
    }

    public function reajustesSalariaisAction()
    {
        $this->setBreadCrumb();

        $padroes = $this->db->getRepository('CoreBundle:Folhapagamento\Padrao')->findAll();
        $normas = $this->db->getRepository('CoreBundle:Normas\Norma')->findAll();

        return $this->render(
            'RecursosHumanosBundle::FolhaPagamento/RotinaMensal/reajustes_salariais.html.twig',
            array (
                'padroes' => $padroes,
                'normas' => $normas,
            )
        );
    }
}
