<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Monetario\Carteira;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio;

/**
 * Class CarteiraController
 * @package Urbem\TributarioBundle\Controller\Monetario
 */
class CarteiraController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Carteira::class)->createQueryBuilder('carteira');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $carteira) {
            $results[] = [
                'id' => sprintf('%d~%d', $carteira->getCodConvenio(), $carteira->getCodCarteira()),
                'cod_carteira' => $carteira->getCodCarteira(),
                'num_carteira' => $carteira->getNumCarteira(),
            ];
        }

        return new JsonResponse($results);
    }

    protected function filterQueryString(QueryBuilder $qb, Request $request)
    {
        $codConvenio = $request->get('codConvenio');
        $qb->where(sprintf('%s.codConvenio = :codConvenio', $qb->getRootAlias()));
        if ($codConvenio) {
            $qb->setParameter('codConvenio', $codConvenio);
        }

        if (!$codConvenio) {
            $qb->setParameter('codConvenio', null);
        }
    }
}
