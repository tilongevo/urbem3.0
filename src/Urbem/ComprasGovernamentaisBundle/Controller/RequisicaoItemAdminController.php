<?php

namespace Urbem\ComprasGovernamentaisBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RequisicaoItemAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiMarcasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $results = ['items' => []];
        if (!$request->get('codItem')) {
            return new JsonResponse($results);
        }

        foreach ((array) $this->admin->getMarcas($request->query->all()) as $marca) {
            $results['items'][] = [
                'id' => $marca->getCodMarca(),
                'label' => (string) $marca,
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiCentrosCustoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $results = ['items' => []];

        foreach ((array) $this->admin->getCentrosCusto($request->query->all()) as $centroCusto) {
            $results['items'][] = [
                'id' => $centroCusto->getCodCentro(),
                'label' => (string) $centroCusto,
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiSaldoEstoqueAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        return new JsonResponse(['quantidade' => $this->admin->getSaldoEstoque($request->query->all())]);
    }
}
