<?php

namespace Urbem\ComprasGovernamentaisBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Urbem\CoreBundle\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     * @Route("/")
     */
    public function homeAction()
    {
        $this->setBreadCrumb();

        return $this->render('ComprasGovernamentaisBundle:Home:home.html.twig');
    }
}
