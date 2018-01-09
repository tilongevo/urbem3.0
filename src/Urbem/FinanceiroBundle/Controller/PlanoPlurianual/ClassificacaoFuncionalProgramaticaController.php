<?php

namespace Urbem\FinanceiroBundle\Controller\PlanoPlurianual;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class ClassificacaoFuncionalProgramaticaController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::PlanoPlurianual/ClassificacaoFuncionalProgramatica/home.html.twig');
    }
}
