<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Urbem\CoreBundle\Controller\BaseController;

class HierarquiaAtividadeController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $this->setBreadCrumb();

        return $this->render('TributarioBundle::Economico/HierarquiaAtividade/home.html.twig');
    }
}
