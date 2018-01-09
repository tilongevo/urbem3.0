<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Urbem\CoreBundle\Controller\BaseController;

class InscricaoController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $this->setBreadCrumb();

        return $this->render('TributarioBundle::DividaAtiva/Inscricao/home.html.twig');
    }
}
