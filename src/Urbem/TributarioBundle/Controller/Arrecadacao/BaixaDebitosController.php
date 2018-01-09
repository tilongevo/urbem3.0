<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class BaixaDebitosController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class BaixaDebitosController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/BaixaDebitos/home.html.twig');
    }
}
