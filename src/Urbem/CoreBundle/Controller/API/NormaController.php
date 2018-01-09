<?php

namespace Urbem\CoreBundle\Controller\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Normas\NormaModel;

class NormaController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findByNomeAndCodigoAction(Request $request)
    {
        $search = $request->get('q');

        $searchSql = is_numeric($search) ?
            sprintf("num_norma = '%s'", $search) :
            sprintf("(lower(nom_norma) LIKE '%%%s%%')", $request->get('q'));

        $exercicioSql = sprintf("exercicio = '%s'", $this->getExercicio());

        $params = [$searchSql, $exercicioSql];
        $normaModel = new NormaModel($this->db);
        $result = $normaModel->getNormasJson($params);
        $response = [];

        foreach ($result as $value) {
            array_push($response, ['id' => $value->cod_norma, 'label' => str_pad($value->num_norma, 6, '0', STR_PAD_LEFT) . '/' . $value->exercicio . ' - ' . $value->nom_norma]);
        }
        $items = [
            'items' => $response
        ];
        return new JsonResponse($items);
    }
}
