<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;

class CobrancaAdministrativaController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::DividaAtiva/CobrancaAdministrativa/home.html.twig');
    }
}
