<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Monetario\GeneroCredito;
use Sonata\AdminBundle\Model\ModelManagerInterface;

/**
 * Class EspecieController
 * @package Urbem\TributarioBundle\Controller\Monetario
 */
class GeneroController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(GeneroCredito::class)->createQueryBuilder('genero');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $genero) {
            $results[] = [
                'id' => sprintf('%d~%d', $genero->getCodNatureza(), $genero->getCodGenero()),
                'cod_genero' => $genero->getCodGenero(),
                'nom_genero' => $genero->getNomGenero(),
            ];
        }

        return new JsonResponse($results);
    }

    protected function filterQueryString(QueryBuilder $qb, Request $request)
    {
        $natureza = $request->get('natureza');

        $qb->where(sprintf('%s.codNatureza = :codNatureza', $qb->getRootAlias()));
        if ($natureza) {
            $qb->setParameter('codNatureza', $natureza);
        }

        if (!$natureza) {
            $qb->setParameter('codNatureza', null);
        }
    }
}
