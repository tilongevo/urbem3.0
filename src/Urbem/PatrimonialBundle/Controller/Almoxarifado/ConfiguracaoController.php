<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Compras\Contrato controller.
 *
 */
class ConfiguracaoController extends ControllerCore\BaseController
{
    /**
     * Home Contrato
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Almoxarifado/Configuracao/home.html.twig');
    }
}
