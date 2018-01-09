<?php

namespace Urbem\CoreBundle\Controller\API;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class CompetenciaPagamentoController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function preencherCompetenciaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoUnico = reset($periodoUnico);

        $meses = $entityManager->getRepository(Mes::class)->findAll();

        $arData = explode("/", $periodoUnico->dt_final);
        $inAno = (int) $arData[2];
        $inCodMes = (int) $arData[1];

        $options = [];
        foreach ($meses as $mes) {
            if ($inAno <= (int) $request->request->get('ano')) {
                if ($mes->getCodMes() >= $inCodMes) {
                    $options[] = [
                        'id' => $mes->getCodMes(),
                        'label' => trim($mes->getDescricao())
                    ];
                }
            }
        }

        return new JsonResponse($options);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function preencherCompetenciaFolhaPagamentoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoUnico = reset($periodoUnico);

        $meses = $entityManager->getRepository(Mes::class)->findAll();

        $arData = explode("/", $periodoUnico->dt_final);
        $inAno = (int) $arData[2];
        $inCodMes = (int) $arData[1];

        $options = [];
        foreach ($meses as $mes) {
            if ($inAno == (int) $request->request->get('ano')) {
                if ($mes->getCodMes() <= $inCodMes) {
                    $options[] = [
                        'id' => $mes->getCodMes(),
                        'label' => trim($mes->getDescricao())
                    ];
                }
            } elseif ($inAno > (int) $request->request->get('ano')) {
                $options[] = [
                    'id' => $mes->getCodMes(),
                    'label' => trim($mes->getDescricao())
                ];
            }
        }

        return new JsonResponse($options);
    }
}
