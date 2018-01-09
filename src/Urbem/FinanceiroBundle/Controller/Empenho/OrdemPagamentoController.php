<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Model\Empenho\OrdemPagamentoModel;
use Urbem\CoreBundle\Entity\Empenho;

/**
 * Class OrdemPagamentoController
 * @package Urbem\FinanceiroBundle\Controller\Empenho
 */
class OrdemPagamentoController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function buscaOrdemPagamentoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();

        $codEntidade = $request->get('cod_entidade');

        $ordemPagamentoModel = new OrdemPagamentoModel($entityManager);

        $ordensPagamento = $ordemPagamentoModel->recuperaOrdensPorEntidade($codEntidade);

        $jsonResponse = [];

        if (!is_null($ordensPagamento)) {
            /** @var Empenho\OrdemPagamento $ordemPagamento */
            foreach ($ordensPagamento as $ordemPagamento) {
                $jsonResponse = [
                    'value' => $ordemPagamento->getCodOrdem(),
                    'label' => (string)$ordemPagamento
                ];
            }
        }

        $ordensPagamento = json_encode($jsonResponse);

        $response = new Response();
        $response->setContent($ordensPagamento);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
