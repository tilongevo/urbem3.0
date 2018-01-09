<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class ConsultaController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class ConsultaController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/Consulta/home.html.twig');
    }
}
