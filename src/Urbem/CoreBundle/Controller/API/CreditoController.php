<?php

namespace Urbem\CoreBundle\Controller\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Monetario\CreditoModel;

class CreditoController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findByDescricaoAndCodigoAction(Request $request)
    {
        $search = $request->get('q');

        $searchSql = is_numeric($search) ?
            sprintf("cod_credito = '%s'", $search) :
            sprintf("(lower(descricao_credito) LIKE '%%%s%%')", $request->get('q'));

        $params = [$searchSql];
        $creditoModel = new CreditoModel($this->db);
        $result = $creditoModel->getCreditosJson($params);
        $response = [];

        foreach ($result as $value) {
            // cod_credito.cod_genero.cod_especie.cod_natureza
            $codigo = sprintf('%d.%d.%d.%d', $value->cod_credito, $value->cod_genero, $value->cod_especie, $value->cod_natureza);
            array_push($response, ['id' => sprintf('%s - %s', $codigo, $value->descricao_credito)
                , 'label' => sprintf('%s - %s', $codigo, $value->descricao_credito)]);
        }

        $items = [
            'items' => $response
        ];
        return new JsonResponse($items);
    }
}
