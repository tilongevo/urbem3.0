<?php

namespace Urbem\CoreBundle\Controller\Filter\Compras;

use Doctrine\ORM;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\Compras\Fornecedor;
use Urbem\CoreBundle\Model\Patrimonial\Compras\FornecedorModel;

/**
 * Class FornecedorAdminController
 * @package Urbem\CoreBundle\Controller\Filter\Compras
 */
class FornecedorAdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteAction(Request $request)
    {
        $q = $request->get('q');

        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getEntityManager();

        $fornecedorModel = new FornecedorModel($entityManager);
        $results = $fornecedorModel->searchByNomCgm($q);

        $fornecedores = [];
        /** @var Fornecedor $fornecedor */
        foreach ($results as $fornecedor) {
            $id = $fornecedorModel->getObjectIdentifier($fornecedor);
            $label = (string) $fornecedor;

            array_push($fornecedores, ['id' => $id, 'label' => $label]);
        }

        $items = [
            'items' => $fornecedores
        ];

        return (new JsonResponse($items));
    }
}
