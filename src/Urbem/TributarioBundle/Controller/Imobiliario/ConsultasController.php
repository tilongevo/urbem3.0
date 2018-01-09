<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Urbem\CoreBundle\Controller\BaseController;

class ConsultasController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Imobiliario/Consulta/home.html.twig');
    }
}
