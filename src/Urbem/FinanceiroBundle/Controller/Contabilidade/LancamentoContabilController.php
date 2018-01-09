<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class LancamentoContabilController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Contabilidade/LancamentoContabil/home.html.twig');
    }
}
