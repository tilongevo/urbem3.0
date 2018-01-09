<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class RelatoriosController extends BaseController
{
    /**
     * Home Relatorios
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('AdministrativoBundle::Administracao/Relatorios/home.html.twig');
    }
}
