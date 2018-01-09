<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Urbem\CoreBundle\Controller\BaseController;

class ConfiguracaoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Economico/Configuracao/home.html.twig');
    }
}
