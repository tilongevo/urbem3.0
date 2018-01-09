<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Arrecadacao\LoteModel;

/**
 * Class ResumoLotesReportAdmin
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class ResumoLotesReportAdminController extends CRUDController
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

        try {
            $relatorioContadoresModel = (new LoteModel($em));
            $lotes = $relatorioContadoresModel->getListaLotes($params);

            if (!$lotes) {
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.arrecadacaoResumoLotesReport.erro'));
                return $this->redirect($this->generateUrl('urbem_tributario_arrecadacao_relatorio_resumo_lotes_create'));
            }

            $listaOrigem = $relatorioContadoresModel->getListaCreditoOrigem($lotes);

            if (!$listaOrigem) {
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.arrecadacaoResumoLotesReport.erro'));
                return $this->redirect($this->generateUrl('urbem_tributario_arrecadacao_relatorio_resumo_lotes_create'));
            }

            foreach ($listaOrigem as $origem) {
                $listaNormais = ($params['tipoRelatorio'] == 'sintetico') ? $relatorioContadoresModel->getSomatoriosNormais($lotes, $origem) : $relatorioContadoresModel->getSomatoriosNormaisAnalitico($lotes, $origem);
                $somatoriosNormais[$origem['origem']] = $relatorioContadoresModel->getTotalNormais($listaNormais);
                $somatoriosNormaisOrigem[$origem['origem']] = ($params['tipoRelatorio'] == 'analitico') ? $relatorioContadoresModel->getSomatoriosNormaisOrigem($listaNormais) : [];
                $somaInconsistenteAgrupado[$origem['origem']] = $relatorioContadoresModel->getResumoLoteListaInconsistenteAgrupado($lotes, $origem);
            }

            $listaInconsistenteDividaAtiva = $relatorioContadoresModel->getResumoLoteListaInconsistenteDividaAtiva($lotes);
            $listaInconsistenteSemVinculo = $relatorioContadoresModel->getResumoLoteListaInconsistenteSemVinculo($lotes);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
            throw $e;
        }

        $html = $this->renderView(
            sprintf('TributarioBundle:Arrecadacao/Relatorios:resumo_lotes_arrecadacao_%s.html.twig', $params['tipoRelatorio']),
            [
                'modulo' => 'Arrecadação',
                'subModulo' => 'Relatórios',
                'funcao' => 'Lotes',
                'nomRelatorio' => sprintf('Resumo de Lotes (%s)', $params['tipoRelatorio']),
                'dtEmissao' => new DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'lotes' => $lotes,
                'listaOrigem' => $listaOrigem,
                'somatoriosNormais' => $somatoriosNormais,
                'totaisRelatorio' => $relatorioContadoresModel->getTotaisRelatorio($somatoriosNormais),
                'inconsistenteDividaAtiva' => $relatorioContadoresModel->getTotalInconsistente($listaInconsistenteDividaAtiva),
                'inconsistenteSemVinculo' => $relatorioContadoresModel->getTotalInconsistente($listaInconsistenteSemVinculo),
                'somatoriosNormaisOrigem' => $somatoriosNormaisOrigem
            ]
        );

        $now = new DateTime();
        $filename = sprintf('RelatorioResumodeLotes_%s.pdf', $now->format('Y-m-d_His'));

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
                    'orientation' => 'Landscape'
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }
}
