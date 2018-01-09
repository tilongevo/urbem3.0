<?php
namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;

class RelatoriosController extends ControllerCore\BaseController
{
    public function indexAction()
    {
        $this->setBreadCrumb();
        return $this->render('RecursosHumanosBundle::FolhaPagamento/Relatorios/index.html.twig');
    }
}
