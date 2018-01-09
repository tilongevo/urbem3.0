<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Urbem\CoreBundle\Controller\BaseController;

class MovimentacoesController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Arrecadacao/Movimentacoes/home.html.twig');
    }
}
