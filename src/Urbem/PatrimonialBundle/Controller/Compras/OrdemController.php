<?php

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class OrdemController
 * @package Urbem\PatrimonialBundle\Controller\Compras
 */
class OrdemController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaComprasOrdemAction(Request $request)
    {
        $filtro = $request->get('q');
        $em = $this->getDoctrine()->getManager();


        $searchSql =
            sprintf(
                "(ordem.cod_ordem || '/' || ordem.exercicio) LIKE '%%%s%%'",
                strtolower($filtro)
            );
        $params = [$searchSql];
        $ordemModel = new Model\Patrimonial\Compras\OrdemModel($em);
        $result = $ordemModel->carregaComprasOrdem($params);
        $ordens = [];

        foreach($result as $ordem) {
            array_push(
                $ordens,
                [
                    'id' => $ordem->exercicio.'~'.$ordem->cod_entidade.'~'.$ordem->cod_ordem.'~'.$ordem->tipo,
                    'label' => $ordem->cod_ordem . "/" . $ordem->exercicio
                ]
            );
        }
        $items = [
            'items' => $ordens
        ];
        return new JsonResponse($items);
    }
}
