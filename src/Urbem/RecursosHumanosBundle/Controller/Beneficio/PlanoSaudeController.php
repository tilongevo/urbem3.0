<?php

namespace Urbem\RecursosHumanosBundle\Controller\Beneficio;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class PlanoSaudeController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $this->setBreadCrumb();
        
        return $this->render('RecursosHumanosBundle::Beneficio/PlanoSaude/home.html.twig');
    }
}
