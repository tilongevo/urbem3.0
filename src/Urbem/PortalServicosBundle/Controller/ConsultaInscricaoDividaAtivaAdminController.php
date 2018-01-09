<?php

namespace Urbem\PortalServicosBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Divida\ConsultaInscricaoDividaModel;

/**
 * Class ConsultaInscricaoDividaAtivaAdminController
 * @package Urbem\PortalServicosBundle\Controller
 */
class ConsultaInscricaoDividaAtivaAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exportAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $qb = $this->admin->createQuery();

        $qb->resetDQLPart('select');
        $qb->addSelect(sprintf('%s.codInscricao', $qb->getRootAlias()));
        $qb->addSelect(sprintf('%s.dtInscricao AS dtInscricao', $qb->getRootAlias()));

        $this->applyFilter($qb, $request);

        $codInscricoes = array_column($qb->getQuery()->getResult(), 'codInscricao');

        $dividasAtivas = (new ConsultaInscricaoDividaModel($em))->getDadosDividasAtivas($codInscricoes);

        return new JsonResponse($dividasAtivas);
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
