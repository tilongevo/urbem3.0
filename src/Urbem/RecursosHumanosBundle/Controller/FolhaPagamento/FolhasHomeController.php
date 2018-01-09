<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class FolhasHomeController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render('RecursosHumanosBundle::FolhaPagamento/Folhas/home.html.twig');
    }
}
