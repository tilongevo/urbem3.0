<?php

namespace Urbem\RedeSimplesBundle\Controller;

use Urbem\CoreBundle\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        $urlRedeSimples = $this->getParameter("url_rede_simples");
        if (!empty($urlRedeSimples)) {
            return $this->redirect($urlRedeSimples);
        }

        return $this->render('RedeSimplesBundle::Home/index.html.twig');
    }
}

