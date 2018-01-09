<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Urbem\CoreBundle\Controller\BaseController;

class LicencasController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Imobiliario/Licencas/home.html.twig');
    }
}
