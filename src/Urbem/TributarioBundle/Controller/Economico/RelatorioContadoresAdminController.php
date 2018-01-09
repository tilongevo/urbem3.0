<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Economico\RelatorioContadoresModel;

/**
 * Class RelatorioContadoresAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class RelatorioContadoresAdminController extends CRUDController
{
    /**
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        $params = $request->query->all();

        try {
            $relatorioContadoresModel = (new RelatorioContadoresModel($em));
            $results = $relatorioContadoresModel->getListaContadores($params);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $contadores = array();
        if ($params['tipoRelatorio'] == 'sintetico') {
            foreach ($results as $contador) {
                $contadores[$contador['num_registro']] = $contador;
            }
        }

        $contadores = (count($contadores) > 0) ? $contadores : $results;

        $html = $this->renderView(
            'TributarioBundle:Economico/RelatorioContadores:relatorio_contadores.html.twig',
            [
                'modulo' => 'Cadastro Econômico',
                'subModulo' => 'Relatórios',
                'funcao' => 'Contadores',
                'nomRelatorio' => 'Relatório de Contadores',
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'contadores' => $contadores,
            ]
        );

        $now = new DateTime();
        $filename = sprintf('RelatorioDeContadores_%s.pdf', $now->format('Y-m-d_His'));

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
