<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Urbem\CoreBundle\Controller\BaseController;

class HierarquiaController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Imobiliario/Hierarquia/home.html.twig');
    }
}
