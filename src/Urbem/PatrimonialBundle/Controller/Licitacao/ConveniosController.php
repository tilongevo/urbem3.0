<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Licitacao\Convenios controller.
 *
 */
class ConveniosController extends ControllerCore\BaseController
{
    /**
     * Home Convenios
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Licitacao/Convenios/home.html.twig');
    }
}
