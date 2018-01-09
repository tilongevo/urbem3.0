<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;

/**
 * Class PlanoAnaliticaController
 * @package Urbem\AdministrativoBundle\Controller\Protocolo
 */
class PlanoAnaliticaController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaPlanoAnaliticaAction(Request $request)
    {
        $filtro = $request->get('q');
        $exercicio = $this->getExercicio();

        $codEstrutural = $request->get('codEstrutural');
        $codEstrutural = isset($codEstrutural) ? $codEstrutural : null;

        $planoAnaliticaModel = new Model\Contabilidade\PlanoAnaliticaModel($this->db);
        $queryBuilder = $planoAnaliticaModel->carregaPlanoAnaliticaQuery(strtolower($filtro), $codEstrutural);
        $queryBuilder
            ->andWhere("{$queryBuilder->getRootAlias()}.exercicio = :exercicio")
            ->setParameter('exercicio', $exercicio);

        $result = $queryBuilder->getQuery()->getResult();
        $contas = [];

        /** @var Entity\Contabilidade\PlanoAnalitica $processo */
        foreach ($result as $planoAnalitica) {
            array_push(
                $contas,
                [
                    'id' => $planoAnaliticaModel->getObjectIdentifier($planoAnalitica),
                    'label' => (string) $planoAnalitica
                ]
            );
        }

        $items = [
            'items' => $contas
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function montaRecuperaContaSinteticaAction(Request $request)
    {
        $filtro = $request->get('q');
        $exercicio = $this->getExercicio();

        $codEstrutural = $request->get('codEstrutural');
        $codEstrutural = isset($codEstrutural) ? $codEstrutural : null;

        $planoAnaliticaModel = new Model\Contabilidade\PlanoAnaliticaModel($this->db);
        $queryBuilder = $planoAnaliticaModel->montaRecuperaContaSintetica(strtolower($filtro), $codEstrutural);
        $queryBuilder
            ->andWhere("{$queryBuilder->getRootAlias()}.exercicio = :exercicio")
            ->setParameter('exercicio', $exercicio);

        $result = $queryBuilder->getQuery()->getResult();
        $contas = [];

        /** @var Entity\Contabilidade\PlanoAnalitica $processo */
        foreach ($result as $planoAnalitica) {
            array_push(
                $contas,
                [
                    'id' => $planoAnaliticaModel->getObjectIdentifier($planoAnalitica),
                    'label' => (string) $planoAnalitica
                ]
            );
        }

        $items = [
            'items' => $contas
        ];
        return new JsonResponse($items);
    }
}
