<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Class FeriasController
 * @package Urbem\RecursosHumanosBundle\Controller\Pessoal
 */
class FeriasController extends ControllerCore\BaseController
{
    /**
     * Home Ferias
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render(
            'RecursosHumanosBundle::Pessoal/Ferias/home.html.twig',
            []
        );
    }
}
