<?php

namespace Urbem\PortalServicosBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel;

/**
 * Class ConsultaImovelAdminController
 * @package Urbem\PortalServicosBundle\Controller
 */
class ConsultaImovelAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exportAction(Request $request)
    {
        $qb = $this->admin->createQuery();

        $qb->resetDQLPart('select');
        $qb->addSelect(sprintf('%s.inscricaoMunicipal as inscricaoMunicipal', $qb->getRootAlias()));
        $qb->addSelect(
            sprintf(
                'CASE WHEN (SELECT COUNT(0) FROM %s bi WHERE bi.inscricaoMunicipal = %s.inscricaoMunicipal AND bi.dtTermino IS NULL) > 0 THEN \'Inativo\' ELSE \'Ativo\' END AS situacao',
                BaixaImovel::class,
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
