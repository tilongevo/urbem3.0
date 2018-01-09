<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Divida\DevedoresReportModel;

/**
 * Class DevedoresReportAdminController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class DevedoresReportAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function creditoAction(Request $request)
    {
        $this->admin->filtroPor = 'Crédito';
        return $this->createAction();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function grupoCreditoAction(Request $request)
    {
        $this->admin->filtroPor = 'Grupo Crédito';
        return $this->createAction();
    }

    public function relatorioAction(Request $request)
    {
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();

        $params = $request->query->all();

        $devedores_codigo_exercicio = array_combine($params['codigo'], $params['exercicio']);
        $devedores_codigo_descricao = array_combine($params['codigo'], $params['descricao']);

        try {
            $devedoresReportModel = (new DevedoresReportModel($em));
            foreach ($devedores_codigo_exercicio as $codigo => $exercicio) {
                $filters = [
                    'exercicio' => $exercicio,
                    'codigo' => $codigo,
                    'limite' => $params['limite']
                ];

                $devedores_creditos[( $params['tipo'] == RelatoriosController::CREDITO )
                    ? sprintf('%s - %s / %s', $codigo, $devedores_codigo_descricao[$codigo], $exercicio)
                    : $devedores_codigo_descricao[$codigo]] = ($params['tipo'] == RelatoriosController::CREDITO)
                    ? $devedoresReportModel->getListaDevedoresCredito($filters)
                    : $devedoresReportModel->getListaDevedoresGrupoCredito($filters);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $html =  $this->renderView(
            'TributarioBundle:DividaAtiva/Relatorios/Devedores:relatorio_devedores.html.twig',
            [
                'modulo' => 'Dívida Ativa',
                'subModulo' => 'Relatórios',
                'funcao' => 'Devedores',
                'nomRelatorio' => 'Relatório de Devedores',
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'creditos_devedores' => $devedores_creditos
            ]
        );

        $now = new DateTime();
        $filename = sprintf('RelatorioDevedores_%s.pdf', $now->format('Y-m-d_His'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation'=>'Landscape'
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }
}
