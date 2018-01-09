<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Urbem\CoreBundle\Controller\BaseController;

class ConfiguracaoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/Configuracao/home.html.twig');
    }
}
