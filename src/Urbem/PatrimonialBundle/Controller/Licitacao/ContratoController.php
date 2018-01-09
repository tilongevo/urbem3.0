<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Licitacao\Comntrato controller.
 *
 */
class ContratoController extends ControllerCore\BaseController
{
    /**
     * Home Contrato
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Licitacao/Contrato/home.html.twig');
    }
}
