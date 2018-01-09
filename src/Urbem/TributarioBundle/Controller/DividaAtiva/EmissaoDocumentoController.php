<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

/**
 * Class EmissaoDocumentoController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class EmissaoDocumentoController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render('TributarioBundle::DividaAtiva/EmissaoDocumento/home.html.twig');
    }
}
