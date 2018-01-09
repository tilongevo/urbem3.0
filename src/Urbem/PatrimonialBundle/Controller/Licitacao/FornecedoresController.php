<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Licitacao\Fornecedores controller.
 *
 */
class FornecedoresController extends ControllerCore\BaseController
{
    /**
     * Home Fornecedores
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Licitacao/Fornecedores/home.html.twig');
    }
}
