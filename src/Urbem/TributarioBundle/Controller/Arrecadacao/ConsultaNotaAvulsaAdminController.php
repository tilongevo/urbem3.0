<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Arrecadacao\Lote;

/**
 * Class ConsultaNotaAvulsaAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class ConsultaNotaAvulsaAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function consultarAction(Request $request)
    {
        return $this->showAction();
    }
}
