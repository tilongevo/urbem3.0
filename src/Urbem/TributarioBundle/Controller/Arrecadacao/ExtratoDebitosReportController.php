<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Arrecadacao\ExtratoDebitosReportModel;

/**
 * Class ExtratoDebitosReportController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class ExtratoDebitosReportController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiInscricaoEconomicaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('q')) {
            return new JsonResponse($results);
        }

        $inscricaoEconomicas = (new ExtratoDebitosReportModel($em))
            ->getSwCgmInscricaoEconomico($request->get('q'));

        foreach ($inscricaoEconomicas as $inscricaoEconomica) {
            $results['items'][] = [
                'id' => sprintf("%d~%s", $inscricaoEconomica['inscricao_economica'], $inscricaoEconomica['nom_cgm']),
                'label' => (string) sprintf("%d - %d - %s", $inscricaoEconomica['inscricao_economica'], $inscricaoEconomica['numcgm'], $inscricaoEconomica['nom_cgm']),
            ];
        }

        return new JsonResponse($results);
    }
}
