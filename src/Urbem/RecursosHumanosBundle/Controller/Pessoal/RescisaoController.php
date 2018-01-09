<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Pessoal\Assentamento;

/**
 * Pessoal\Assentamento controller.
 *
 */
class RescisaoController extends ControllerCore\BaseController
{
    /**
     * Home Rescisao
     *
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('RecursosHumanosBundle::Pessoal/Rescisao/home.html.twig');
    }
}
