<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Urbem\CoreBundle\Controller\BaseController;

class GrupoCreditoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/GrupoCredito/home.html.twig');
    }
}
