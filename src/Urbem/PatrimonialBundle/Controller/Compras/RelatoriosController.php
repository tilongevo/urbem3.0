<?php

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class RelatoriosController
 *
 * @package Urbem\PatrimonialBundle\Controller\Compras
 */
class RelatoriosController extends BaseController
{
    /**
     * @return Response
     */
    public function homeAction()
    {
        $this->setBreadCrumb();

        return $this->render('PatrimonialBundle:Compras/Relatorios:home.html.twig');
    }
}
