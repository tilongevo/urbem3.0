<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;

class ElaboracaoOrcamentoController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render('FinanceiroBundle::Orcamento/ElaboracaoOrcamento/home.html.twig');
    }
}
