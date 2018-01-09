<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Urbem\CoreBundle\Controller\BaseController;

class RelatoriosController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Economico/Relatorios/home.html.twig');
    }
}
