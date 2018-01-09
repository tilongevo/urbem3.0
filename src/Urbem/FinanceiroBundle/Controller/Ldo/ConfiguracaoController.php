<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class ConfiguracaoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Ldo/Configuracao/home.html.twig');
    }
}
