<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento;

class LoteamentoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function loteDisponivelAction(Request $request)
    {
        $qb = $this
            ->getDoctrine()
            ->getEntityManager()
            ->getRepository(LoteLoteamento::class)
            ->createQueryBuilder('o');

        $qb->where('o.codLote = :codLote');
        $qb->setParameter('codLote', $request->request->get('codLote'));

        if ($request->request->get('codLoteamento') != '') {
            $qb->where('o.codLoteamento != :codLoteamento');
            $qb->setParameter('codLoteamento', $request->request->get('codLoteamento'));
        }

        $loteLoteamento = $qb->getQuery()->getResult();

        $response = new Response();
        $response->setContent(json_encode(($loteLoteamento) ? false : true));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
