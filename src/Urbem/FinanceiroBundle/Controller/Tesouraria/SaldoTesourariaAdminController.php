<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Helper\ArrayHelper;

class SaldoTesourariaAdminController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
    public function contasPorEntidadeAction(Request $request)
    {
        $entidade = (int)$request->request->get('entidade');
        $exercicio = $request->request->get('exercicio');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\SaldoTesouraria');
        $retornoContas = $repository->findAllContasPorEntidade($entidade, $exercicio);
        $contas = ArrayHelper::parseArrayToChoice($retornoContas, 'cod_plano', 'nom_conta');
        $contasVl = ArrayHelper::parseArrayToChoice($retornoContas, 'cod_plano', 'vl_saldo');

        $response = new Response();
        $response->setContent(json_encode(['contas' => $contas, 'contasVl' => $contasVl]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
