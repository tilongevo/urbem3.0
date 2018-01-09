<?php

namespace Urbem\PatrimonialBundle\Controller\Patrimonio;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Patrimonio\Relatorios.
 *
 */
class RelatoriosController extends ControllerCore\BaseController
{
    /**
     * Home Patrimonio Relatorios
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Patrimonial/Relatorios/home.html.twig');
    }
}
