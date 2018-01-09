<?php
namespace Urbem\RecursosHumanosBundle\Controller\Beneficio;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Controller\BaseController;

class RelatoriosController extends ControllerCore\BaseController
{
    public function indexAction()
    {
        $this->setBreadCrumb();
        return $this->render('RecursosHumanosBundle::Beneficio/Relatorios/index.html.twig');
    }
}
