<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Tesouraria\OrcamentariaPagamentosModel;

class OrcamentariaPagamentosAdminController extends CRUDController
{
    public function saldoContaAction(Request $request)
    {
        list($codPlano, $exercicio) = explode('~', $request->request->get('id'));

        $response = new Response();
        $response->setContent(
            json_encode(
                (new OrcamentariaPagamentosModel($this->getDoctrine()->getEntityManager()))
                    ->verificaSaldoConta(
                        $exercicio,
                        $codPlano
                    )
            )
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
