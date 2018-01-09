<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 24/05/16
 * Time: 17:09
 */

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Urbem\CoreBundle\Controller as ControllerCore;

class IRRFController extends ControllerCore\BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        return $this->render('RecursosHumanosBundle::FolhaPagamento/IRRF/index.html.twig');
    }
}
