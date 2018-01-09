<?php

namespace Urbem\PatrimonialBundle\Controller\Patrimonio;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Urbem\CoreBundle\Entity\Organograma\Local;

/**
 * Class InventarioController
 * @package Urbem\PatrimonialBundle\Controller\Patrimonio
 */
class InventarioController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Patrimonial/Inventario/home.html.twig');
    }
}
