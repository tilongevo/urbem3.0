<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

class FolhaSalarioController extends ControllerCore\BaseController
{
    const VIEW_PATH = "RecursosHumanosBundle::FolhaPagamento/FolhaSalario/";

    public function indexAction()
    {
        $this->setBreadCrumb();
        return $this->render(self::VIEW_PATH . 'index.html.twig');
    }

    public function folhaSalarioIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $this->setBreadCrumb();

        $movimentacoes = $em->getRepository('CoreBundle:Folhapagamento\PeriodoMovimentacao')
            ->findBy(
                array(),
                array('dtFinal' => 'DESC')
            );

        $ultimaMovimentacao = $movimentacoes[0];

        $situacoes = $em->getRepository('CoreBundle:Folhapagamento\FolhaSituacao')
            ->findBy(
                array('codPeriodoMovimentacao' => $ultimaMovimentacao->getCodPeriodoMovimentacao()),
                array('timestamp' => 'DESC')
            );

        $ultimaSituacao = !count($situacoes) ? null : $situacoes[0];

        return $this->render(
            self::VIEW_PATH . 'ReabrirFechar/index.html.twig',
            array(
                'movimentacao' => $ultimaMovimentacao,
                'situacao' => $ultimaSituacao
            )
        );
    }

    public function registrarEventoContratoIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'RegistrarEventoContrato/index.html.twig');
    }

    public function calcularSalarioIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'CalcularSalario/index.html.twig');
    }

    public function consultarFichaFinanceiraIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'ConsultarFichaFinanceira/index.html.twig');
    }

    public function consultarRegistroEventosIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'ConsultarRegistroEventos/index.html.twig');
    }

    public function registrarImportarLoteIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'RegistrarImportarLote/index.html.twig');
    }
}
