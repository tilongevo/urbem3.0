<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 24/05/16
 * Time: 17:09
 */

namespace Urbem\RecursosHumanosBundle\Controller\Estagio;

use Urbem\CoreBundle\Controller as ControllerCore;

class ConfiguracaoController extends ControllerCore\BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->setBreadCrumb();

        return $this->render('RecursosHumanosBundle::Estagio/Configuracao/index.html.twig');
    }
}
