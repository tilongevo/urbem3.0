<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Urbem\CoreBundle\Controller\BaseController;

class ConsultaController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::DividaAtiva/Consulta/home.html.twig');
    }
}
