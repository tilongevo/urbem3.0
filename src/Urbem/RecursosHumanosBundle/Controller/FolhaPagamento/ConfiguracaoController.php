<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Urbem\CoreBundle\Controller as ControllerCore;

class ConfiguracaoController extends ControllerCore\BaseController
{
    /**
     * Home Configuracao
     *
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('RecursosHumanosBundle::FolhaPagamento/Configuracao/home.html.twig');
    }
}
