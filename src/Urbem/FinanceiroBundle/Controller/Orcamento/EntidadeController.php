<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class EntidadeController
 * @package Urbem\PatrimonialBundle\Controller\Orcamento
 */
class EntidadeController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaOrcamentoEntidadesAction(Request $request)
    {
        $filtro = $request->get('q');
        $em = $this->getDoctrine()->getManager();

        $searchSql = is_numeric($filtro) ?
            sprintf("AND E.cod_entidade = %s", $filtro) :
            sprintf(
                "AND lower(C.nom_cgm) LIKE '%%%s%%'",
                strtolower($filtro)
            );
        $params = $searchSql;
        $entidadeModel = new Model\Orcamento\EntidadeModel($em);
        $result = $entidadeModel->getEntidades($this->getExercicio(), $params);
        $entidades = [];

        foreach($result as $entidade) {
            array_push(
                $entidades,
                [
                    'id' => $entidade['cod_entidade'],
                    'label' => $entidade['cod_entidade'] . " - " . $entidade['nom_cgm']
                ]
            );
        }
        $items = [
            'items' => $entidades
        ];
        return new JsonResponse($items);
    }

    public function carregaEmpenhoEntidadesAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $em = $this->getDoctrine()->getManager();
        $entidadeModel = new Model\Orcamento\EntidadeModel($em);
        $res = $entidadeModel->recuperaEntidadeEmpenho($exercicio);

        $entidades = [];

        /** @var Entity\Orcamento\Entidade $entidade */
        foreach ($res as $entidade) {
            array_push(
                $entidades,
                [
                    'id' => $entidadeModel->getObjectIdentifier($entidade),
                    'label' => (string) $entidade
                ]
            );
        }

        return new JsonResponse($entidades);
    }
}
