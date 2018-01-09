<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class AutorizacaoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Empenho/Empenho/Autorizacao/home.html.twig');
    }
}
