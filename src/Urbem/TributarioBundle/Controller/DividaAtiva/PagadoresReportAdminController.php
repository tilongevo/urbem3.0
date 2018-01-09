<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Divida\PagadoresReportModel;

/**
 * Class DevedoresReportAdminController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class PagadoresReportAdminController extends CRUDController
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

        $pagadores_codigo_exercicio = array_combine($params['codigo'], $params['exercicio']);
        $pagadores_codigo_descricao = array_combine($params['codigo'], $params['descricao']);

        try {
            $pagadoresReportModel = (new PagadoresReportModel($em));
            foreach ($pagadores_codigo_exercicio as $codigo => $exercicio) {
                $filters = [
                    'exercicio' => $exercicio,
                    'codigo' => $codigo,
                    'limite' => $params['limite']
                ];

                $pagadores_creditos[( $params['tipo'] == RelatoriosController::CREDITO )
                    ? sprintf('%s - %s / %s', $codigo, $pagadores_codigo_descricao[$codigo], $exercicio)
                    : $pagadores_codigo_descricao[$codigo]] = ($params['tipo'] == RelatoriosController::CREDITO)
                    ? $pagadoresReportModel->getListaPagadoresCredito($filters)
                    : $pagadoresReportModel->getListaPagadoresGrupoCredito($filters);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $html =  $this->renderView(
            'TributarioBundle:DividaAtiva/Relatorios/Pagadores:relatorio_pagadores.html.twig',
            [
                'modulo' => 'Dívida Ativa',
                'subModulo' => 'Relatórios',
                'funcao' => 'Pagadores',
                'nomRelatorio' => 'Relatório de Pagadores',
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'creditos_pagadores' => $pagadores_creditos,
            ]
        );

        $now = new DateTime();
        $filename = sprintf('RelatorioPagadores_%s.pdf', $now->format('Y-m-d_His'));

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
