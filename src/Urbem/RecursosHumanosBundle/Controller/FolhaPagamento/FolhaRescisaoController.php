<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

class FolhaRescisaoController extends ControllerCore\BaseController
{
    const VIEW_PATH = "RecursosHumanosBundle::FolhaPagamento/FolhaRescisao/";

    public function indexAction()
    {
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'index.html.twig');
    }

    public function registrarEventoIndexAction()
    {
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'RegistrarEvento/index.html.twig');
    }

    public function consultarRegistrosIndexAction()
    {
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'ConsultarRegistros/index.html.twig');
    }

    public function calcularRescisaoIndexAction()
    {
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'CalcularRescisao/index.html.twig');
    }

    public function consultarFichaFinanceiraIndexAction()
    {
        $this->setBreadCrumb();

        return $this->render('RecursosHumanosBundle:FolhaPagamento/FolhaSalario/ConsultarFichaFinanceira/index.html.twig');
    }
}
