<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Pessoal\SubDivisaoModel;

class SubdivisaoController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function consultarSubdivisaoByCodRegimeAction(Request $request)
    {
        $codRegime = $request->attributes->get('id');

        $subdivisoes = $this->getDoctrine()
            ->getRepository('CoreBundle:Pessoal\SubDivisao')
            ->findByCodRegime($codRegime, array('descricao' => 'ASC'));

        $listSubdivisoes = array();
        foreach ($subdivisoes as $chave => $subdivisao) {
            $listSubdivisoes[$subdivisao->getCodSubDivisao()] = $subdivisao->getDescricao();
        }

        $response = new Response();
        $response->setContent(json_encode($listSubdivisoes));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function carregaSubDivisaoAction(Request $request)
    {
        $descricao = $request->get('q');

        $searchSql = is_numeric($descricao) ?
            sprintf("cod_regime = %s", $descricao) :
            sprintf("(lower(descricao) LIKE '%%%s%%')", $request->get('q'));

        $params = [$searchSql];
        $subDivisao = new SubDivisaoModel($this->db);
        $result = $subDivisao->getSubDivisoesDisponiveisJson($params);
        $subDivisaoData = [];

        foreach($result as $credor) {
            array_push($subDivisaoData, ['id' => $credor->cod_sub_divisao, 'label' => $credor->cod_sub_divisao . " - " . $credor->descricao]);
        }
        $items = [
            'items' => $subDivisaoData
        ];
        return new JsonResponse($items);

    }
}
