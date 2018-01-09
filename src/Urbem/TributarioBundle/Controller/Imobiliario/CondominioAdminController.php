<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelLote;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteCondominio;

class CondominioAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function consultarLoteCondominioAction(Request $request)
    {
        $qb = $this->getDoctrine()->getRepository(LoteCondominio::class)->createQueryBuilder('o');
        $qb->where('o.codLote = :codLote');
        $qb->setParameter('codLote', $request->request->get('codLote'));
        if ($request->request->get('codCondominio')) {
            $qb->andWhere('o.codCondominio != :codCondominio');
            $qb->setParameter('codCondominio', $request->request->get('codCondominio'));
        }
        $rlt = $qb->getQuery()->getResult();

        $imoveis = array();
        if (!$rlt) {
            /** @var Lote $lote */
            $lote = $this
                ->getDoctrine()
                ->getRepository(Lote::class)
                ->find($request->request->get('codLote'));

            /** @var ImovelLote $imovelLote */
            foreach ($lote->getFkImobiliarioImovelLotes() as $imovelLote) {
                $imoveis[] = $imovelLote->getInscricaoMunicipal();
            }
        }

        $response = new Response();
        $response->setContent(json_encode($imoveis));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteCondominioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->get('q');

        /** @var QueryBuilder $qb */
        $qb = $em->getRepository(Condominio::class)->createQueryBuilder('o');
        $qb->where('o.codCondominio = :codCondominio');
        $qb->orWhere('o.nomCondominio LIKE :nomCondominio');
        $qb->setParameters(
            array(
                'codCondominio' => (int) $term,
                'nomCondominio' => sprintf('%%%s%%', strtolower($term))
            )
        );
        $rlt = $qb->getQuery()->getResult();

        $condominios = array();

        /** @var Condominio $condominio */
        foreach ($rlt as $condominio) {
            array_push(
                $condominios,
                array(
                    'id' => $condominio->getCodCondominio(),
                    'label' => (string) $condominio
                )
            );
        }

        $items = array(
            'items' => $condominios
        );

        return new JsonResponse($items);
    }
}
