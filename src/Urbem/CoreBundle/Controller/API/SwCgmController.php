<?php

namespace Urbem\CoreBundle\Controller\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Beneficio\BeneficiarioModel;
use Urbem\CoreBundle\Model\SwCgmModel;

class SwCgmController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function findByNumcgmAndNomcgmAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $term = $request->get('q');

        $swcgmModel = new SwCgmModel($em);
        $cgmList = $swcgmModel->getCgmPessoaFisicaByNumcgmAndNomCgm($term);

        $cgms = array();

        foreach ($cgmList as $cgm) {
            array_push(
                $cgms,
                array(
                    'id' => $cgm->numcgm,
                    'label' => $cgm->numcgm . " - " . $cgm->nom_cgm
                )
            );
        }

        $items = array(
            'items' => $cgms
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function findByNomCgmAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('q')) {
            return new JsonResponse($results);
        }

        $qb = $em->getRepository(SwCgm::class)->createQueryBuilder('sw_cgm');
        $qb->where('LOWER(sw_cgm.nomCgm) LIKE :nomCgm');
        $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($request->get('q'))));
        foreach ((array) $qb->getQuery()->getResult() as $swCgm) {
            $results['items'][] = [
                'id' => $swCgm->getNumcgm(),
                'label' => (string) $swCgm,
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function findByNomCgmWithBeneficiarioLayoutAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('q')) {
            return new JsonResponse($results);
        }
        $numcgm = $request->get('q');
        $searchSql = is_numeric($numcgm) ?
            sprintf("numcgm = %s", $numcgm) :
            sprintf("(lower(nom_cgm) LIKE '%%%s%%')", strtolower($request->get('q')));

        $params = [$searchSql];

        /** @var BeneficiarioModel $beneficiarioModel */
        $beneficiarioModel = new BeneficiarioModel($em);
        $result = $beneficiarioModel->recuperaBeneficiariosLayoutFornecedor($params);

        foreach ($result as $swCgm) {
            $results['items'][] = [
                'id' => $swCgm->numcgm,
                'label' => $swCgm->numcgm." - ". $swCgm->nom_cgm,
            ];
        }

        return new JsonResponse($results);
    }
}
