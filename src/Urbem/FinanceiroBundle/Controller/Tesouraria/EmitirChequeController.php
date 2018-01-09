<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class EmitirChequeController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Tesouraria/Cheque/home.html.twig');
    }
}
