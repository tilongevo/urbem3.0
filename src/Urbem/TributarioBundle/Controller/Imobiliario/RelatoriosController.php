<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Urbem\CoreBundle\Controller\BaseController;

class RelatoriosController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Imobiliario/Relatorios/home.html.twig');
    }
}
