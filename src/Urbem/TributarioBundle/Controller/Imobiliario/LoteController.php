<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Urbem\CoreBundle\Controller\BaseController;

class LoteController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Imobiliario/Lote/home.html.twig');
    }
}
