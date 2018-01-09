<?php

namespace Urbem\ConfiguracaoBundle\Controller;

use Urbem\CoreBundle\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        return $this->render('ConfiguracaoBundle::Home/index.html.twig', [
            /* src/Urbem/ConfiguracaoBundle/DependencyInjection/ConfiguracaoExtension.php */
            'configurations' => $this->container->get('configuration.list')
        ]);
    }
}

