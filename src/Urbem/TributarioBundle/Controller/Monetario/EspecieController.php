<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Monetario\EspecieCredito;
use Sonata\AdminBundle\Model\ModelManagerInterface;

/**
 * Class EspecieController
 * @package Urbem\TributarioBundle\Controller\Monetario
 */
class EspecieController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(EspecieCredito::class)->createQueryBuilder('especie');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $especie) {
            $results[] = [
                'id' => sprintf('%d~%d~%d', $especie->getCodNatureza(), $especie->getCodGenero(), $especie->getCodEspecie()),
                'nom_especie' => $especie->getNomEspecie(),
            ];
        }

        return new JsonResponse($results);
    }

    protected function filterQueryString(QueryBuilder $qb, Request $request)
    {
        $codNatureza = $request->get('codNatureza');
        $qb->where(sprintf('%s.codNatureza = :codNatureza', $qb->getRootAlias()));
        if ($codNatureza) {
            $qb->setParameter('codNatureza', $codNatureza);
        }

        if (!$codNatureza) {
            $qb->setParameter('codNatureza', null);
        }

        $codGenero = $request->get('codGenero');
        $qb->andWhere(sprintf('%s.codGenero = :codGenero', $qb->getRootAlias()));
        if ($codGenero) {
            $qb->setParameter('codGenero', $codGenero);
        }

        if (!$codGenero) {
            $qb->setParameter('codGenero', null);
        }
    }
}
