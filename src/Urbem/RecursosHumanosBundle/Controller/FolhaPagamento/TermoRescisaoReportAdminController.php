<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoRescisaoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoPensionistaCasoCausaModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorCasoCausaModel;

class TermoRescisaoReportAdminController extends CRUDController
{
    public function gerarRelatorioAction(Request $request)
    {
        $tipo = $request->get('tipo');
        $ordenacao = $request->get('ordenacao');
        $tipoValor = $request->get('tipoValor');
        $mes = $request->get('mes');
        $ano = $request->get('ano');

        $em = $this->getDoctrine()->getEntityManager();

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $codEntidadePrefeitura = $configuracaoModel->getConfiguracao(
            'cod_entidade_prefeitura',
            Modulo::MODULO_ORCAMENTO,
            true,
            $this->admin->getExercicio()
        );

        /** @var Entidade $entidade */
        $prefeitura = $em->getRepository(Entidade::class)->findOneBy(
            [
                'codEntidade' => $codEntidadePrefeitura,
                'exercicio' => $this->admin->getExercicio()
            ]
        );

        switch ($tipo) {
            case "matricula":
                $stOrdem = $ordenacao == "A" ? "nom_cgm" : "registro";
                $stFiltroContratos = " AND contrato.cod_contrato IN (";

                foreach ($tipoValor as $valor) {
                    $stFiltroContratos .= $valor . " ,";
                }

                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1) . ")";

                break;
            case "lotacao":
                $stOrdem = $ordenacao == "A" ? "desc_orgao,nom_cgm" : "orgao,registro";
                $stFiltroContratos = " AND contrato_servidor_orgao.cod_orgao IN (";

                foreach ($tipoValor as $valor) {
                    $stFiltroContratos .= $valor . " ,";
                }

                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1) . ")";
                break;
            case "local":
                $stOrdem = $ordenacao == "A" ? "desc_local,nom_cgm" : "cod_local,registro";
                $stFiltroContratos = " AND contrato_servidor_local.cod_local IN (";

                foreach ($tipoValor as $valor) {
                    $stFiltroContratos .= $valor . " ,";
                }

                $stFiltroContratos = substr($stFiltroContratos, 0, strlen($stFiltroContratos) - 1) . ")";
                break;
            case "geral":
                $stFiltroContratos = "";
                $stOrdem = $ordenacao == "A" ? "nom_cgm" : "registro";
                break;
        }

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);

        $mes = ((int) $mes < 10) ? "0" . $mes : $mes;
        $dtFinal = $mes . '/' . $ano;
        $periodoMovimentacao = $em->getRepository(PeriodoMovimentacao::class)
            ->consultaPeriodoMovimentacaoCompetencia($dtFinal);

        /** @var PeriodoMovimentacao $periodo */
        $periodoFinal = $periodoMovimentacaoModel->findOneByCodPeriodoMovimentacao($periodoMovimentacao['cod_periodo_movimentacao']);

        if (strlen(trim($stFiltroContratos)) > 0) {
            $stFiltroContratos = substr_replace($stFiltroContratos, ' WHERE ', 0, 4);
        }

        /**
         * Esperando parâmetro de qual tipo de contrato
         * será gerado o relatório.
         */
        if (false) {
            $contratoPensionistaCasoCausaModel = new ContratoPensionistaCasoCausaModel($em);
            $rsContratos = $contratoPensionistaCasoCausaModel
                ->recuperaTermoRescisao($stFiltroContratos, $stOrdem, $this->admin->getExercicio(), $periodoFinal->getCodPeriodoMovimentacao());
        } else {
            $contratoServidorCasoCausaModel = new ContratoServidorCasoCausaModel($em);
            $rsContratos = $contratoServidorCasoCausaModel
                ->recuperaTermoRescisao($stFiltroContratos, $stOrdem, $this->admin->getExercicio(), $periodoFinal->getCodPeriodoMovimentacao());
        }

        $eventoRescisaoCalculadoModel = new EventoRescisaoCalculadoModel($em);
        $totalContratos = 0;
        $arEventos = array();

        $date = new \DateTime();
//        $arquivoName = sprintf('arquivo%s.zip', $date->format('Ymdhis'));

        $arquivoGerado = false;
        $filename = sprintf('Termo-de-rescisao-%s.pdf', date('Y-m-d'));
        $contratos = [];
        foreach ($rsContratos as $contrato) {
            $ordemEvento = " desdobramento_texto, descricao  ";

            $filtroEvento = " AND cod_contrato = " . $contrato->cod_contrato;
            $filtroEvento .= " AND cod_periodo_movimentacao = " . $periodoFinal->getCodPeriodoMovimentacao();

            $filtroEventoN = " AND natureza = 'P'";
            $proventosCalculados = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($filtroEvento . $filtroEventoN, $ordemEvento);
            $stFiltroEventoN = " AND natureza = 'D'";
            $descontosCalculados = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($filtroEvento . $stFiltroEventoN, $ordemEvento);
            $stFiltroEventoN = " AND natureza = 'B'";
            $basesCalculados = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($filtroEvento . $stFiltroEventoN, $ordemEvento);
            $stFiltroEventoN = " AND natureza = 'I'";
            $informativosCalculados = $eventoRescisaoCalculadoModel->recuperaEventoRescisaoCalculado($filtroEvento . $stFiltroEventoN, $ordemEvento);

            $inDivisor = 15;
            $inContador = count($proventosCalculados);
            $inContador = (count($descontosCalculados) > $inContador) ? count($descontosCalculados) : $inContador;
            $inContador = (count($basesCalculados) > $inContador) ? count($basesCalculados) : $inContador;
            $inContador = (count($informativosCalculados) > $inContador) ? count($informativosCalculados) : $inContador;

            $inResto = $inContador % $inDivisor;
            $inContador = $inContador / $inDivisor;
            $inContador = ($inResto == 0) ? $inContador : $inContador + 1;
            $inContador = (int) $inContador;

            $inOffset = 0;

            if ($inContador > 0) {
                $arquivoGerado = true;
                $totalContratos++;
                for ($inPag = 1; $inPag <= $inContador; $inPag++) {
                    $arEventos[$contrato->cod_contrato]['P'] = array_slice($proventosCalculados, $inOffset, $inDivisor);
                    $arEventos[$contrato->cod_contrato]['D'] = array_slice($descontosCalculados, $inOffset, $inDivisor);
                    $arEventos[$contrato->cod_contrato]['B'] = array_slice($basesCalculados, $inOffset, $inDivisor);
                    $arEventos[$contrato->cod_contrato]['I'] = array_slice($informativosCalculados, $inOffset, $inDivisor);

                    $totalEventos[$contrato->cod_contrato] = 0;
                    $totalDescontos[$contrato->cod_contrato] = 0;

                    foreach ($arEventos[$contrato->cod_contrato]['P'] as $evento) {
                        $totalEventos[$contrato->cod_contrato] += $evento->valor;
                    }

                    foreach ($arEventos[$contrato->cod_contrato]['D'] as $evento) {
                        $totalDescontos[$contrato->cod_contrato] += $evento->valor;
                    }

                    $contrato->totalEventos = $totalEventos[$contrato->cod_contrato];
                    $contrato->totalDescontos = $totalDescontos[$contrato->cod_contrato];
                    $contrato->vlLiquido = $contrato->totalEventos - $contrato->totalDescontos;
                }
                $contratos[] = $contrato;
            }
        }

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $cnae = $configuracaoModel
            ->getConfiguracao('cnae_fiscal', Modulo::MODULO_IMA, true, $this->admin->getExercicio());

        $html =  $this->renderView('RecursosHumanosBundle:FolhaPagamento/Relatorios:termoDeRescisao.html.twig', [
            'contratos' => $contratos,
            'nomRelatorio' => 'Termo de Rescisão do Contrato de Trabalho',
            'prefeitura' => $prefeitura,
            'cnae' => $cnae,
            'eventos' => $arEventos,
        ]);

        $pdf =  new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => false,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br'
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );

        $fp = fopen('/tmp/'.$filename, "w");
        fwrite($fp, $pdf);
        fclose($fp);
        return new JsonResponse([
            'filename' => $filename,
            'contratos' => $totalContratos,
        ], 200);
    }

    /**
     * @param Request $request
     * @param $filename
     * @return Response
     */
    public function viewDownloadArquivoAction(Request $request, $filename)
    {
        $id = $filename;
        $this->admin->setBreadCrumb($id ? ['filename' => $id] : []);

        $total = $request->get('total');

        if ($total > 0) {
            $message = $this->trans('label.relatorios.termoRescisao.sucesso', [], 'messages');
            $this->container->get('session')->getFlashBag()->add('success', $message);
        } else {
            $message = $this->trans('label.relatorios.termoRescisao.erro', [], 'messages');
            $this->container->get('session')->getFlashBag()->add('error', $message);
        }

        return $this->render('RecursosHumanosBundle:FolhaPagamento/Relatorios:viewRelatorioTermodeRescisao.html.twig', [
            'total' => $total,
            'filename' => $filename
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function downloadArquivoAction(Request $request)
    {
        $filename = $request->get('filename');

        $arquivo = file_get_contents('/tmp/'.$filename);

        return new Response(
            $arquivo,
            200,
            [
                'Content-Type' => 'application/force-download',
                'Content-Disposition' => sprintf('attachment; filename='.$filename)
            ]
        );
    }
}
