<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio;

/**
 * Class BancoController
 * @package Urbem\TributarioBundle\Controller\Monetario
 */
class BancoController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Banco::class)->createQueryBuilder('banco');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $agencia) {
            $results[] = [
                'cod_banco' => $agencia->getCodBanco(),
                'num_banco' => $agencia->getNumBanco(),
                'nom_banco' => $agencia->getNomBanco(),
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param QueryBuilder $qb
     * @param Request $request
     * @return void
     */
    protected function filterQueryString(QueryBuilder $qb, Request $request)
    {
        $codConvenio = $request->get('codConvenio');
        if ($codConvenio) {
            $qb->join(ContaCorrenteConvenio::class, 'conta_corrente_convenio', 'WITH', 'banco.codBanco = conta_corrente_convenio.codBanco');
            $qb->where('conta_corrente_convenio.codConvenio = :codConvenio');
            $qb->setParameter('codConvenio', $codConvenio);
        }

        $qb->orderBy('banco.numBanco', 'ASC');
    }
}
