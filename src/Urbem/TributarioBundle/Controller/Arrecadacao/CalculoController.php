<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class CalculoController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class CalculoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/Calculo/home.html.twig');
    }
}
