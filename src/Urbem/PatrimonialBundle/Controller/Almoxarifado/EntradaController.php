<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 26/09/16
 * Time: 15:17
 */

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

class EntradaController extends ControllerCore\BaseController
{
    /**
     * Renderiza a home de Entrada dentro de Almoxarifado.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render(
            'PatrimonialBundle::Almoxarifado/Entrada/home.html.twig'
        );
    }
}
