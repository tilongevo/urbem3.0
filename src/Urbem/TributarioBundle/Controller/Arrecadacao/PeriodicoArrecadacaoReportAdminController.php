<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Arrecadacao\ParcelaModel;

/**
 * Class PeriodicoArrecadacaoReportAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class PeriodicoArrecadacaoReportAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        $params = $request->query->all();

        $results = array();
        try {
            $parcelaModel = new ParcelaModel($em);

            if ($params['tipoRelatorio'] == 'sintetico') {
                $results = $parcelaModel->getFnPeriodicoArrecadacaoSintetico($params);
            } elseif ($params['tipoRelatorio'] == 'analitico') {
                $results = $parcelaModel->getFnPeriodicoArrecadacaoAnalitico($params);
            }
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
            throw $e;
        }

        $html = $this->renderView(
            sprintf('TributarioBundle:Arrecadacao/Relatorios:periodico_arrecadacao_%s.html.twig', strtolower($params['tipoRelatorio'])),
            [
                'filtros' => $params,
                'results' => $results,
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Arrecadação',
                'subModulo' => 'Relatórios',
                'funcao' => 'Periódico de Arrecadação',
                'nomRelatorio' => 'Relatório de Periódico de Arrecadação',
                'dtEmissao' => new \DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioPeriodicoDeArrecadacao_%s.pdf', date('Y-m-d'));

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
