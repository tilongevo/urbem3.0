<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Monetario\Convenio;
use Sonata\AdminBundle\Model\ModelManagerInterface;

/**
 * Class ConvenioController
 * @package Urbem\TributarioBundle\Controller\Monetario
 */
class ConvenioController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Convenio::class)->createQueryBuilder('convenio');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $convenio) {
            $results[] = [
                'cod_convenio' => $convenio->getCodConvenio(),
                'num_convenio' => $convenio->getNumConvenio(),
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function carregaConvenioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Convenio::class)->createQueryBuilder('convenio');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $convenio) {
            $results[] = [
                'id' => $convenio->getCodConvenio(),
                'label' => $convenio->getNumConvenio(),
            ];
        }

        return new JsonResponse(['items' => $results]);
    }

    /**
     * @param QueryBuilder $qb
     * @param Request $request
     * @return void
     */
    protected function filterQueryString(QueryBuilder $qb, Request $request)
    {
        $tipoConvenio = $request->get('tipo_convenio');
        if ($tipoConvenio) {
            $qb->where(sprintf('%s.codTipo = :codTipo', $qb->getRootAlias()));
            $qb->setParameter('codTipo', $tipoConvenio);
        }

        $numConvenio = $request->get('q');
        if ($numConvenio) {
            $qb->where(sprintf('%s.numConvenio >= :numConvenio', $qb->getRootAlias()));
            $qb->setParameter('numConvenio', (int) $numConvenio);
        }

        $qb->orderBy('convenio.numConvenio', 'ASC');
    }
}
