<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

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
        return $this->render('FinanceiroBundle::Empenho/Configuracao/home.html.twig');
    }
}
