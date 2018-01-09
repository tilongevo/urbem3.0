<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class NotaTransferenciaItemController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class NotaTransferenciaItemController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaCatalogoItensAction(Request $request)
    {
        $filtro = $request->get('q');
        $codTransferencia = $request->get('codTransferencia');

        $em = $this->getDoctrine()->getManager();
        $searchSql = is_numeric($filtro) ?
            sprintf("AND aci.cod_item = %s", $filtro) :
            sprintf(
                "AND lower(aci.descricao) LIKE '%%%s%%'",
                strtolower($filtro)
            );
        $params = $searchSql;
        $pedidoTransferenciaItemModel = new Model\Patrimonial\Almoxarifado\PedidoTransferenciaItemModel($em);
        $result = $pedidoTransferenciaItemModel->getItemByCodTransferencia($codTransferencia, $params);
        $itens = [];

        foreach($result as $item) {
            array_push(
                $itens,
                [
                    'id' => $item['cod_item'],
                    'label' => $item['cod_item']. " - " .$item['descricao']
                ]
            );
        }
        $items = [
            'items' => $itens
        ];
        return new JsonResponse($items);
    }
}
