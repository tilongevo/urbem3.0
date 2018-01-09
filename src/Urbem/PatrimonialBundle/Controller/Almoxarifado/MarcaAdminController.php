<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\MarcaModel;

/**
 * Class MarcaAdminController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class MarcaAdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteAction(Request $request)
    {
        $q = $request->get('q');
        $em = $this->getDoctrine()->getManager();

        $marcaModel = new MarcaModel($em);
        $results = $marcaModel->searchByDescricao($q);

        $marcas = [];
        /** @var Almoxarifado\Marca $marca */
        foreach ($results as $marca) {
            $id = $marcaModel->getObjectIdentifier($marca);
            $label = $marca->getDescricao();

            array_push($marcas, ['id' => $id, 'label' => $label]);
        }

        $items = [
            'items' => $marcas
        ];

        return new JsonResponse($items);
    }
}
