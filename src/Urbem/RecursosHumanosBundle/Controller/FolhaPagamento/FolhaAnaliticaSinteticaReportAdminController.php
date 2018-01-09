<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaAnaliticaSinteticaReportModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;

/**
 * Class FolhaAnaliticaSinteticaReportAdminController
 * @package Urbem\RecursosHumanosBundle\Controller\FolhaPagamento
 */
class FolhaAnaliticaSinteticaReportAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function imprimirAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $formData = $request->request->get($request->query->get('uniqid'));

        $folha = (new FolhaAnaliticaSinteticaReportModel($entityManager))
        ->consultaFolha($formData, $this->admin->getExercicio(), $currentUser);

        $html = $this->renderView($folha['view'], $folha['parameters']);

        $filename = "";
        switch ($formData['stFolha']) {
            case 'analítica_resumida':
                $filename = 'folhaAnaliticaResumida.pdf';
                break;
            case 'analítica':
                $filename = 'folhaAnalitica.pdf';
                break;
            case 'sintética':
                $filename = 'folhaSintetica.pdf';
                break;
        }

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => false,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation' => 'Landscape',
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function folhaComplementarCompetenciaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $inCodComplementarChoices = (new FolhaComplementarModel($entityManager))
        ->listaFolhaPagamentoComplementar(
            $request->request->get('inAno'),
            $request->request->get('inCodMes')
        );

        return new JsonResponse($inCodComplementarChoices);
    }
}
