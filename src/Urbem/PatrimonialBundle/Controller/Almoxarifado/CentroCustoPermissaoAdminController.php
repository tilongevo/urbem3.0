<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoPermissaoModel;

/**
 * Class CentroCustoPermissaoAdminController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class CentroCustoPermissaoAdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $numcgm = $request->get('numcgm');
        $entityManager = $this->getDoctrine()->getEntityManager();

        $centroCustoPermissaoModel = new CentroCustoPermissaoModel($entityManager);
        $centroCustosPermissoes = $centroCustoPermissaoModel->getCentrosDeCustos($numcgm);

        $centroCustosPermissoesList = [];
        /** @var Almoxarifado\CentroCustoPermissao $centroCustoPermissao */
        foreach ($centroCustosPermissoes as $centroCustoPermissao) {
            $centroCusto = $centroCustoPermissao->getFkAlmoxarifadoCentroCusto();

            $id = $centroCustoPermissaoModel->getObjectIdentifier($centroCusto);
            $label = (string) $centroCusto;

            array_push($centroCustosPermissoesList, ['id' => $id, 'label' => $label]);
        }

        $items = [
            'items' => $centroCustosPermissoesList
        ];

        return new JsonResponse($items);
    }
}
