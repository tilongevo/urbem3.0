<?php

namespace Urbem\ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ReportBundle:Default:index.html.twig');
    }
}
