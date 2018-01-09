<?php

namespace Urbem\CoreBundle\Controller\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Arrecadacao\TabelaConversaoModel;

/**
 * Class TabelaConversaoController
 * @package Urbem\CoreBundle\Controller\API
 */
class TabelaConversaoController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTabelaConversaoAction(Request $request)
    {
        $search = $request->get('exercicioOrigem');

        $searchSql = sprintf("exercicio = '%s'", $search);

        $params = [$searchSql];
        $tabelaConversaoModel = new TabelaConversaoModel($this->db);
        $result = $tabelaConversaoModel->getTabelaConversaoJson($params);

        $response = [];
        foreach ($result as $value) {
            $response[$value->cod_tabela] =  $value->nome_tabela;
        }

        return new JsonResponse($response);
    }
}
