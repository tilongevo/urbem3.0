<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ItemModel;

/**
 * Almoxarifado\Catalogo controller.
 *
 */
class CatalogoController extends ControllerCore\BaseController
{
    /**
     * Home Catalogo
     *
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render(
            'PatrimonialBundle::Almoxarifado/Catalogo/home.html.twig'
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaAlmoxarifadoCatalogoItemAction(Request $request)
    {
        $searchSql = sprintf("(lower(aci.descricao) LIKE '%%%s%%')", $request->get('q'));

        $params = [$searchSql];
        $catalogoItemModel = new CatalogoItemModel($this->db);
        $result = $catalogoItemModel->carregaAlmoxarifadoCatalogoItemQuery($params);

        $itens = [];


        foreach ($result as $item) {
            array_push($itens, ['id' => $item->cod_item, 'label' => $item->cod_item . ' - ' . $item->descricao]);
        }
        $items = [
            'items' => $itens
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaAlmoxarifadoCatalogoUnidadeAction(Request $request)
    {
        $catalogoItemModel = new CatalogoItemModel($this->db);
        $result = $catalogoItemModel->carregaAlmoxarifadoCatalogoUnidadeQuery($request->get('item'));
        return new JsonResponse($result);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaAlmoxarifadoSaldoCentroCustoAction(Request $request)
    {
        $catalogoItemModel = new CatalogoItemModel($this->db);
        $result = $catalogoItemModel->carregaAlmoxarifadoSaldoCentroCustoQuery($request->get('codCentro'), $request->get('codItem'));
        return new JsonResponse($result);
    }
}
