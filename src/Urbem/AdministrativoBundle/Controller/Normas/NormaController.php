<?php

namespace Urbem\AdministrativoBundle\Controller\Normas;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Normas\Norma;

/**
 * Class NormaController
 * @package Urbem\AdministrativoBundle\Controller\Normas
 */
class NormaController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function carregaNormaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Norma::class)->createQueryBuilder('norma');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $norma) {
            $results[] = [
                'id' => $norma->getCodNorma(),
                'label' => (string) $norma,
            ];
        }

        return new JsonResponse(['items' => $results]);
    }

    /**
     * @param QueryBuilder $qb
     * @param Request $request
     */
    protected function filterQueryString(QueryBuilder $qb, Request $request)
    {
        $filtersNorma = $request->get('q');
        $qb->where(sprintf('LOWER(%s.nomNorma) LIKE :nomNorma', $qb->getRootAlias()));
        $qb->orWhere(sprintf('%s.exercicio = :exercicio', $qb->getRootAlias()));
        $qb->orWhere(sprintf('%s.numNorma = :numNorma', $qb->getRootAlias()));

        if ($filtersNorma) {
            $qb->setParameter('nomNorma', sprintf('%%%s%%', strtolower($filtersNorma)));
            $qb->setParameter('exercicio', $filtersNorma);
            $qb->setParameter('numNorma', sprintf('%d', str_pad($filtersNorma, 6, 0, STR_PAD_LEFT)));
        }

        if (!$filtersNorma) {
            $qb->setParameter('nomNorma', null);
            $qb->setParameter('exercicio', null);
            $qb->setParameter('numNorma', null);
        }
    }
}
