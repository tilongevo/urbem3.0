<?php

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;

/**
 * Pessoal\Servidor controller.
 *
 */
class ComprasController extends ControllerCore\BaseController
{
    /**
     * Home Controle Escolar
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Compras/Configuracao/home.html.twig');
    }

    public function contratoAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Compras/Contrato/home.html.twig');
    }
}
