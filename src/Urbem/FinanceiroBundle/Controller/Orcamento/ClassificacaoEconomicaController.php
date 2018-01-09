<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class ClassificacaoEconomicaController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Orcamento/ClassificacaoEconomica/home.html.twig');
    }
}
