<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class RelatoriosController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Empenho/Relatorios/home.html.twig');
    }
}
