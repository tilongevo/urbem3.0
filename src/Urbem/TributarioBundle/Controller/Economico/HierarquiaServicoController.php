<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Urbem\CoreBundle\Controller\BaseController;

class HierarquiaServicoController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Economico/HierarquiaServico/home.html.twig');
    }
}
