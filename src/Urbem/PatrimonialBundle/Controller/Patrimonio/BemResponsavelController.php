<?php

namespace Urbem\PatrimonialBundle\Controller\Patrimonio;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;

class BemResponsavelController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaBemResponsavelAnteriorAction(Request $request)
    {

        $numcgm = $request->get('q');

        $searchSql = is_numeric($numcgm) ?
            sprintf("cod_bem = %s", $numcgm) :
            sprintf("(lower(nom_cgm) LIKE '%%%s%%')", $request->get('q'));

        $params = [$searchSql];
        $bemModel = new BemModel($this->db);
        $result = $bemModel->carregaBemResponsavelAnterior($params);
        $bens = [];

        foreach ($result as $cgm) {
            array_push($bens, ['id' => $cgm->numcgm, 'label' => $cgm->numcgm . " - " . $cgm->nom_cgm]);
        }

        $items = [
            'items' => $bens
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaBemResponsavelAction(Request $request)
    {

        $numcgm = $request->get('q');

        $searchSql = is_numeric($numcgm) ?
            sprintf("cod_bem = %s", $numcgm) :
            sprintf("(lower(nom_cgm) LIKE '%%%s%%')", $request->get('q'));

        $params = [$searchSql];
        $bemModel = new BemModel($this->db);
        $result = $bemModel->carregaBemResponsavel($params);
        $bens = [];

        foreach ($result as $cgm) {
            array_push($bens, ['id' => $cgm->numcgm, 'label' => $cgm->numcgm . " - " . $cgm->nom_cgm]);
        }
        $items = [
            'items' => $bens
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaDtInicioResponsavelAction(Request $request)
    {

        $numcgm = $request->get('id');
        $bemModel = new BemModel($this->db);
        $result = $bemModel->carregaDtInicioResponsavel($numcgm);

        if (empty($result)) {
            $result = 'Não há data de inicio cadastrada';
        } else {
            $data = explode('-', $result->dt_inicio);
            $result = $data[2]."/".$data[1]."/".$data[0];
        }

        return new JsonResponse($result);
    }
}
