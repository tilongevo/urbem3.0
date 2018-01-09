<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Configuracao;

use Urbem\CoreBundle\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     * Home Consignacao
     *
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        return $this->render('RecursosHumanosBundle::Informacoes/Configuracao/home.html.twig');
    }

    public function indexRelatorioAction()
    {
        $this->setBreadcrumb();

        return $this->render('RecursosHumanosBundle::Informacoes/relatorio.html.twig');
    }
}
