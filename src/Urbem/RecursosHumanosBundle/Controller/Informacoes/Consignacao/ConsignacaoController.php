<?php

namespace Urbem\RecursosHumanosBundle\Controller\Informacoes\Consignacao;

use Urbem\CoreBundle\Controller\BaseController;

class ConsignacaoController extends BaseController
{
    /**
     * Home Consignacao
     *
     */
    public function homeAction()
    {
        $this->setBreadCrumb();

        return $this->render('RecursosHumanosBundle::Informacoes/Consignacao/home.html.twig');
    }
}
