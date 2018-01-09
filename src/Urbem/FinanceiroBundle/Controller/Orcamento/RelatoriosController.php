<?php
namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class RelatoriosController
 * @package Urbem\FinanceiroBundle\Controller\Orcamento
 */
class RelatoriosController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render('FinanceiroBundle::Orcamento/Relatorios/home.html.twig');
    }
}
