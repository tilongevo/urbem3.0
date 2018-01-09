<?php

namespace Urbem\PatrimonialBundle\Controller\Frota;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;

/**
 * Pessoal\Servidor controller.
 *
 */
class ControleEscolarController extends ControllerCore\BaseController
{
    /**
     * Home Controle Escolar
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Frota/ControleEscolar/home.html.twig');
    }
}
