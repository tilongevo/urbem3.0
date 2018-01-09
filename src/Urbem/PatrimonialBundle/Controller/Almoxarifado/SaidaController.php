<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Class SaidaController
 */
class SaidaController extends ControllerCore\BaseController
{
    /**
     * Renderiza a home de Saida dentro de Almoxarifado.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render(
            'PatrimonialBundle:Almoxarifado/Saida:home.html.twig'
        );
    }
}
