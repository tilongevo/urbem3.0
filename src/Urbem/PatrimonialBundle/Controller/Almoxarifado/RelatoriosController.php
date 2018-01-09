<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class RelatoriosController
 *
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class RelatoriosController extends BaseController
{
    /**
     * @return Response
     */
    public function homeAction()
    {
        $this->setBreadCrumb();

        return $this->render('PatrimonialBundle:Almoxarifado/Relatorios:home.html.twig');
    }
}
