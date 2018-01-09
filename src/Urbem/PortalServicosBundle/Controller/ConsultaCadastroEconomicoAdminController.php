<?php

namespace Urbem\PortalServicosBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;

/**
 * Class ConsultaCadastroEconomicoAdminController
 * @package Urbem\PortalServicosBundle\Controller
 */
class ConsultaCadastroEconomicoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exportAction(Request $request)
    {
        $qb = $this->admin->createQuery();

        $qb->resetDQLPart('select');
        $qb->addSelect(sprintf('%s.inscricaoEconomica', $qb->getRootAlias()));
        $qb->addSelect(sprintf('CONCAT(%s.inscricaoEconomica, \' - \', cgm.numcgm, \' - \', cgm.nomCgm) as inscricaoEconomicaLabel', $qb->getRootAlias()));
        $qb->addSelect(
            sprintf(
                'CASE WHEN (SELECT COUNT(0) FROM %s bce WHERE bce.inscricaoEconomica = %s.inscricaoEconomica AND bce.dtTermino IS NULL) > 0 THEN \'Inativo\' ELSE \'Ativo\' END AS situacao',
                BaixaCadastroEconomico::class,
                $qb->getRootAlias()
            )
        );
        $qb->addSelect(sprintf('%s.timestamp AS timestamp', $qb->getRootAlias()));

        $this->applyFilter($qb, $request);

        return new JsonResponse($qb->getQuery()->getResult());
    }

    /**
    * @param ProxyQuery $qb
    * @param Request $request
    * @return void
    */
    protected function applyFilter(ProxyQuery $qb, Request $request)
    {
        if ($request->get('orderBy')) {
            $sort = $request->get('sort', 'ASC');

            $qb->orderBy($request->get('orderBy'), $sort);
        }

        $size = $request->get('size', 15);
        $qb->setMaxResults($size);
    }
}
