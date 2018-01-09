<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 23/05/16
 * Time: 11:13
 */

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

class FolhaFeriasController extends ControllerCore\BaseController
{
    const VIEW_PATH = "RecursosHumanosBundle:FolhaPagamento/FolhaFerias/";

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

    public function calcularFeriasIndexAction()
    {
        $this->setBreadCrumb();

        return $this->render(self::VIEW_PATH . 'CalcularFerias/index.html.twig');
    }

    public function consultarFichaFinanceiraIndexAction()
    {
        $this->setBreadCrumb();

        return $this->render('RecursosHumanosBundle:FolhaPagamento/FolhaSalario/ConsultarFichaFinanceira/index.html.twig');
    }
}
