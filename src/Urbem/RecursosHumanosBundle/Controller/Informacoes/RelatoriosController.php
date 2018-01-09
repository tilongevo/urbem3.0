<?php
namespace Urbem\RecursosHumanosBundle\Controller\Informacoes;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Controller\BaseController;

class RelatoriosController extends ControllerCore\BaseController
{
    public function indexAction()
    {
        $this->setBreadCrumb();
        return $this->render('RecursosHumanosBundle::Informacoes/Relatorios/index.html.twig');
    }
}
