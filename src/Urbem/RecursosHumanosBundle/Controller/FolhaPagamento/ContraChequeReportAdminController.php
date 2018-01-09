<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class ContraChequeReportAdminController extends Controller
{
    public function consultaFolhaComplementarAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $ano = $request->request->get('ano');
        $mes = $request->request->get('mes');

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacaoModel->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacaoModel->getOnePeriodo($periodoUnico);

        $mes = ($mes < 10) ? '0'.$mes : $mes;

        $dtFinal = $mes.'/'.$ano;
        $periodoMovimentacao = $em->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtFinal);

        /** @var PeriodoMovimentacao $periodo */
        $periodo = $periodoMovimentacaoModel->findOneByCodPeriodoMovimentacao($periodoMovimentacao['cod_periodo_movimentacao']);
        $bens = [];
        $bens = [
            'id' => $periodo->getCodPeriodoMovimentacao(),
            'label' => $periodo->getCodPeriodoMovimentacao()
        ];

        $items = [
            'items' => $bens
        ];
        return new JsonResponse($items);
    }
}
