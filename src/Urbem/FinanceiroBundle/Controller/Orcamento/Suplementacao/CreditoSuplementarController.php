<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento\Suplementacao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class CreditoSuplementarController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Orcamento/CreditoSuplementar/home.html.twig');
    }
}
