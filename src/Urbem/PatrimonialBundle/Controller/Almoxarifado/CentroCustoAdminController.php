<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;

/**
 * Class CentroCustoAdminController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class CentroCustoAdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteAction(Request $request)
    {
        $q = $request->get('q');
        $em = $this->getDoctrine()->getEntityManager();

        $centroCustoModel = new CentroCustoModel($em);
        $result = $centroCustoModel->searchCentroCusto($q);

        $centros = [];
        /** @var CentroCusto $centroCusto */
        foreach ($result as $centroCusto) {
            $id = $centroCustoModel->getObjectIdentifier($centroCusto);
            $label = (string) $centroCusto;

            array_push($centros, ['id' => $id, 'label' => $label]);
        }

        $items = [
            'items' => $centros
        ];

        return new JsonResponse($items);
    }
}
