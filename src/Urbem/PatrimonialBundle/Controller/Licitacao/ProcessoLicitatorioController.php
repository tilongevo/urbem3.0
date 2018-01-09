<?php

namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;

/**
 * Licitacao\processo_licitatorio controller.
 *
 */
class ProcessoLicitatorioController extends ControllerCore\BaseController
{
    /**
     * Home processo_licitatorio
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('PatrimonialBundle::Licitacao/ProcessoLicitatorio/home.html.twig');
    }
}
