<?php

namespace Urbem\PatrimonialBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render('PatrimonialBundle::Home/index.html.twig');
    }

    public function configuracaoAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Patrimonial/Configuracao/home.html.twig');
    }

    public function compraAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Compras/Configuracao/home.html.twig');
    }
}
