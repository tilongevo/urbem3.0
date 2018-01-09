<?php

namespace Urbem\FinanceiroBundle\Controller\PlanoPlurianual;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class DestinacaoRecursosController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::PlanoPlurianual/DestinacaoRecursos/home.html.twig');
    }
}
