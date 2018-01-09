<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Urbem\CoreBundle\Helper;

class OrdemPagamentoAdminController extends CRUDController
{
    const VISTO = 'visto';
    const ORDENADOR_DESPESA = 'ordenadorDespesa';
    const TESOUREIRO = 'tesoureiro';
    /**
     * @param Request $request
     * @return Response
     */
    public function dataOrdemAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Empenho\OrdemPagamento');
        $data = $repository->getDtOrdem($exercicio, $codEntidade);

        $response = new Response();
        $response->setContent(json_encode(['data' => $data]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function itemAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');
        $codEmpenho = $request->request->get('codEmpenho');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Empenho\OrdemPagamento');
        $data = $repository->getOrdemPagamentoItem($exercicio, $codEntidade, $codEmpenho);

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function empenhoAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Empenho\OrdemPagamento');
        $data = $repository->getOrdemPagamentoItem($exercicio, $codEntidade);

        $options = [];
        foreach ($data as $empenho) {
            if (((float) $empenho['vl_itens'] - (float) $empenho['vl_itens_anulados']) > ((float) $empenho['vl_ordem'] - (float) $empenho['vl_ordem_anulada'])) {
                $options[$empenho['cod_empenho'] . ' - ' . $empenho['beneficiario']] = $empenho['cod_empenho'];
            }
        }

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function receitaAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Empenho\OrdemPagamento');
        $data = $repository->getOrdemPagamentoReceita($exercicio, $codEntidade);

        $options = [];
        foreach ($data as $receita) {
            $options[$receita['cod_receita'] . ' - ' .$receita['descricao']] = $receita['cod_receita'];
        }

        $response = new Response();
        $response->setContent(json_encode($options));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function reemitirAction(Request $request)
    {
        $codOrdem = $request->query->get('codOrdem');
        $exercicio = $request->query->get('exercicio');
        $codEntidade = $request->query->get('codEntidade');
        $timestamp = $request->query->get('timestamp');
        if (array_key_exists('date', $timestamp)) {
            $timestamp = $timestamp['date'];
        }

        $container = $this->container;

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $ordemPagamentoAnulada = $em->getRepository('CoreBundle:Empenho\OrdemPagamentoAnulada')
            ->findOneBy([
                'codOrdem' => $codOrdem,
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
                'timestamp' => $timestamp
            ]);

        $tdEmissao = $ordemPagamentoAnulada->getTimestamp();

        $ordemPagamento = $ordemPagamentoAnulada->getFkEmpenhoOrdemPagamento();
        $pagamentoLiquidacaoAnulada = $ordemPagamentoAnulada->getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas()->last();
        $pagamentoLiquidacao = $pagamentoLiquidacaoAnulada->getFkEmpenhoPagamentoLiquidacao();
        $notaLiquidacao = $pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao();

        $codPreEmpenho = $notaLiquidacao->getFkEmpenhoNotaLiquidacaoItens()->last()->getCodPreEmpenho();
        $exercicioPreEmpenho = $notaLiquidacao->getFkEmpenhoNotaLiquidacaoItens()->last()->getExercicioItem();
        $dotacaoFormatada = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')->getDotacaoFormatada($exercicioPreEmpenho, $codPreEmpenho);

        $empenho = str_pad($notaLiquidacao->getFkEmpenhoEmpenho()->getCodEmpenho(), 6, '0', STR_PAD_LEFT) . '/' . $notaLiquidacao->getFkEmpenhoEmpenho()->getExercicio() . ' - ' . $dotacaoFormatada;
        $liquidacao = str_pad($notaLiquidacao->getCodNota(), 6, '0', STR_PAD_LEFT) . '/' . $notaLiquidacao->getExercicio() . ' - ' . $notaLiquidacao->getDtLiquidacao()->format('d/m/Y');
        $vlLiquidacao = $pagamentoLiquidacao->getVlPagamento();
        $vlAnulado = $pagamentoLiquidacaoAnulada->getVlAnulado();
        $dtAnulacao = new \DateTime($ordemPagamentoAnulada->getTimestamp());
        $motivo = $ordemPagamentoAnulada->getMotivo();

        $dados = [
            'empenho' => $empenho,
            'liquidacao' => $liquidacao,
            'vlLiquidacao' => $vlLiquidacao,
            'vlAnulado' => $vlAnulado,
            'dtAnulacao' => $dtAnulacao->format('d/m/Y'),
            'motivo' => $motivo
        ];

        $stBarCode = str_pad($ordemPagamento->getCodOrdem() . substr($ordemPagamento->getExercicio(), 2) . $ordemPagamento->getCodEntidade(), 18, '0', STR_PAD_LEFT);

        $barcode = new BarcodeGenerator();
        $barcode->setText($stBarCode);
        $barcode->setType(BarcodeGenerator::I25);

        $barcode->setScale(1);
        $barcode->setThickness(60);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        $html = $this->renderView(
            'FinanceiroBundle:Empenho/OrdemPagamento:reemitir.html.twig',
            [
                'object' => $ordemPagamento,
                'dados' => $dados,
                'modulo' => 'label.ordemPagamento.modulo',
                'codebar' => $code,
                'subModulo' => 'label.ordemPagamento.subModulo',
                'funcao' => 'label.ordemPagamento.funcao',
                'nomRelatorio' => 'label.ordemPagamento.nomRelatorio',
                'dtEmissao' => $tdEmissao,
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('AnulacaoDeOrdemDePagamento-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
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
    }

    public function relatorioAction(Request $request)
    {
        $codOrdem = $request->query->get('codOrdem');
        $exercicio = $request->query->get('exercicio');
        $codEntidade = $request->query->get('codEntidade');

        $container = $this->container;

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $tdEmissao = new \DateTime('now');

        $em = $this->getDoctrine()->getManager();

        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            -> findOneBy([
                'codOrdem' => $codOrdem,
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade
            ]);

        $assinaturas = array(
            self::VISTO => null,
            self::ORDENADOR_DESPESA => null,
            self::TESOUREIRO => null
        );

        $ordemPagamentoAssinatura = $ordemPagamento->getFkEmpenhoOrdemPagamentoAssinaturas();
        if ($ordemPagamentoAssinatura) {
            foreach ($ordemPagamentoAssinatura as $assinatura) {
                switch ($assinatura->getNumAssinatura()) {
                    case 1:
                        $tipo = self::VISTO;
                        break;
                    case 2:
                        $tipo = self::ORDENADOR_DESPESA;
                        break;
                    case 3:
                        $tipo = self::TESOUREIRO;
                        break;
                }

                $assinaturas[$tipo] = [
                    'nome' => $assinatura->getFkSwCgm()->getNomCgm(),
                    'cargo' => $assinatura->getCargo()
                ];
            }
        }

        $total = 0.00;
        $credor = array('cnpj' => null, 'nome' => null, 'numcgm' => null, 'cpf' => null);
        $empenho = array();
        foreach ($ordemPagamento->getFkEmpenhoPagamentoLiquidacoes() as $pagamentoLiquidacao) {
            $empenhoOriginal = $pagamentoLiquidacao
                ->getFkEmpenhoNotaLiquidacao()
                ->getFkEmpenhoEmpenho();

            $despesa = $pagamentoLiquidacao
                ->getFkEmpenhoNotaLiquidacao()
                ->getFkEmpenhoEmpenho()
                ->getFkEmpenhoPreEmpenho()
                ->getFkEmpenhoPreEmpenhoDespesa()
                ->getFkOrcamentoDespesa();

            $contaDespesa = $pagamentoLiquidacao
                ->getFkEmpenhoNotaLiquidacao()
                ->getFkEmpenhoEmpenho()
                ->getFkEmpenhoPreEmpenho()
                ->getFkEmpenhoPreEmpenhoDespesa()
                ->getFkOrcamentoContaDespesa();

            $notaLiquidacao = $pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao();

            $valorAnulado = 0.00;
            $codPagamentoLiquidacaoAnulado = $pagamentoLiquidacao->getFkEmpenhoOrdemPagamentoLiquidacaoAnuladas();
            foreach ($codPagamentoLiquidacaoAnulado as $pagamentoLiquidacaoAnulado) {
                $valorAnulado += $pagamentoLiquidacaoAnulado->getVlAnulado();
            }

            $preEmpenho = $pagamentoLiquidacao
                ->getFkEmpenhoNotaLiquidacao()
                ->getFkEmpenhoEmpenho()
                ->getFkEmpenhoPreEmpenho();

            $exercicioPreEmpenho = $preEmpenho->getExercicio();
            $codPreEmpenho = $preEmpenho->getCodPreEmpenho();

            $dotacaoFormatada = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
                ->getDotacaoFormatada($exercicioPreEmpenho, $codPreEmpenho);

            $empenho[$empenhoOriginal->getCodEmpenho()] = [
                'codEmpenho' => $empenhoOriginal->getCodEmpenho(),
                'exercicio' => $empenhoOriginal->getExercicio(),
                'codDespesa' => $despesa->getCodDespesa(),
                'codEstrutural' => $dotacaoFormatada,
                'descricao' => $contaDespesa->getDescricao(),
                'codRecurso' => $despesa->getFkOrcamentoRecurso()->getCodFonte(),
                'nomRecurso' => $despesa->getFkOrcamentoRecurso()->getNomRecurso(),
                'exercicioPao' => $despesa->getFkOrcamentoPao()->getExercicio(),
                'nomPao' => $despesa->getFkOrcamentoPao()->getNomPao(),
                'codLiquidacao' => $notaLiquidacao->getCodNota(),
                'dtLiquidacao' => $notaLiquidacao->getDtLiquidacao()->format('d/m/Y'),
                'vlPagamento' => $pagamentoLiquidacao->getVlPagamento(),
                'vlAnulado' => $valorAnulado
            ];

            $total += $pagamentoLiquidacao->getVlPagamento() - $valorAnulado;

            $pessoaJuridica = $em->getRepository('CoreBundle:SwCgmPessoaJuridica')
                ->findOneByNumcgm($preEmpenho->getCgmBeneficiario());

            if ($pessoaJuridica) {
                $credor['cnpj'] = $pessoaJuridica->getCnpj();
            } else {
                if ($pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao()->getFkEmpenhoNotaLiquidacaoItens()->last()->getFkEmpenhoItemPreEmpenho()->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getFkSwCgmPessoaFisica()) {
                    $credor['cpf'] = $pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao()->getFkEmpenhoNotaLiquidacaoItens()->last()->getFkEmpenhoItemPreEmpenho()->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getFkSwCgmPessoaFisica()->getCpf();
                }
            }

            $credor['nome'] = $preEmpenho->getFkSwCgm()->getNomcgm();
            $credor['numcgm'] = $preEmpenho->getFkSwCgm()->getNumcgm();
        }

        $dtRecibo = strftime('%d de %B de %Y', strtotime($ordemPagamento->getDtEmissao()->format('Y-m-d')));

        $stBarCode = $ordemPagamento->getCodOrdem();
        $stBarCode .= substr($ordemPagamento->getExercicio(), 2);
        $stBarCode .= str_pad($ordemPagamento->getCodEntidade(), 3, '0', STR_PAD_LEFT) . '0';
        $stBarCode = str_pad($stBarCode, 18, '0', STR_PAD_LEFT);

        $barcode = new BarcodeGenerator();
        $barcode->setText($stBarCode);
        $barcode->setType(BarcodeGenerator::I25);

        $barcode->setScale(1);
        $barcode->setThickness(60);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        $codReceita = array();
        $codReciboExtra = array();
        $codReciboExtra[] = 0;
        if ($ordemPagamento->getFkEmpenhoOrdemPagamentoReciboExtras()) {
            $codReciboExtra = array();
            foreach ($ordemPagamento->getFkEmpenhoOrdemPagamentoReciboExtras() as $reciboExtra) {
                $codReciboExtra[] = $reciboExtra->getCodReciboExtra();
            }
        }

        if ($ordemPagamento->getFkEmpenhoOrdemPagamentoRetencoes()) {
            $codReceita = array();
            foreach ($ordemPagamento->getFkEmpenhoOrdemPagamentoRetencoes() as $retencao) {
                if ($retencao->getCodReceita()) {
                    $codReceita[] = $retencao->getCodReceita();
                }
            }
        }

        if (!count($codReceita)) {
            $codReceita[] = 0;
        }

        $filename = sprintf('OrdemDePagamento-%s.pdf', date('Y-m-d'));

        if ($ordemPagamento->getFkEmpenhoOrdemPagamentoRetencoes()->count()) {
            $params = [
                'inCodGestao' => 2,
                'inCodModulo' => 10,
                'inCodRelatorio' => 7,
                'term_user' => $usuario->getUserName(),
                'cod_acao' => 816,
                'cod_acao_op' => 816,
                'exercicio' => $exercicio,
                'entidade' => $codEntidade,
                'acao_receita_extra' => 1534,
                'cod_ordem' => $codOrdem,
                'cod_fornecedor' => $credor['numcgm'],
                'nome_funcionario' => $usuario->getFkSwCgm()->getNomCgm(),
                'cod_recibo_extra' => implode(',', $codReciboExtra),
                'cod_receita' => implode(',', $codReceita),
                'cod_lancamento' => '',
                'total_pagina' => 1,
                'cod_febraban' => 9999,
                'break_page' => 0,
                'codigo_barra' => $stBarCode,
                'mostrar_codigo' => 'mostrar',
                'mostrar_rodape' => 'mostrar'
            ];

            $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/empenho/report/design/emitirOrdemPagamento.rptdesign';

            $apiService = $this->admin->getReportService();

            $apiService->setReportNameFile($filename);
            $apiService->setLayoutDefaultReport($layoutDefaultReport);
            $res = $apiService->getReportContent($params);

            $response = new Response();
            $response->setStatusCode(200);
            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '.pdf";');
            $response->setContent($res->getBody()->getContents());
            $response->sendHeaders();
            $response->send();
        } else {
            $html = $this->renderView(
                'FinanceiroBundle:Empenho/OrdemPagamento:pdf.html.twig',
                [
                    'object' => $ordemPagamento,
                    'credor' => $credor,
                    'total' => $total,
                    'assinaturas' => $assinaturas,
                    'empenhos' => $empenho,
                    'dtRecibo' => $dtRecibo,
                    'modulo' => 'label.ordemPagamento.modulo',
                    'codebar' => $code,
                    'subModulo' => 'label.ordemPagamento.subModulo',
                    'funcao' => 'label.ordemPagamento.funcao',
                    'nomRelatorio' => 'label.ordemPagamento.nomRelatorio',
                    'dtEmissao' => $tdEmissao,
                    'usuario' => $usuario,
                    'versao' => $container->getParameter('version')
                ]
            );

            return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml(
                    $html,
                    [
                        'encoding' => 'utf-8',
                        'enable-javascript' => true,
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
        }
    }

    public function buscaEmpenhoAction(Request $request)
    {
        $parameter = $request->get('q');
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('codEntidade');

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('CoreBundle:Empenho\Empenho');
        $queryBuilder = $repository->createQueryBuilder('o');
        $queryBuilder->innerJoin('o.fkEmpenhoNotaLiquidacoes', 'nl');
        $queryBuilder->innerJoin('o.fkEmpenhoPreEmpenho', 'pe');
        $queryBuilder->innerJoin('pe.fkSwCgm', 'cgm');
        $queryBuilder->where($queryBuilder->expr()->orX(
            $queryBuilder->expr()->like('LOWER(cgm.nomCgm)', ':nomCgm'),
            $queryBuilder->expr()->eq('nl.codEmpenho', ':codEmpenho')
        ));
        $queryBuilder->andWhere('o.exercicio = :exercicio');
        $queryBuilder->setParameters([
            'nomCgm' => sprintf('%%%s%%', strtolower($parameter)),
            'codEmpenho' => (int) $parameter,
            'exercicio' => $exercicio
        ]);
        $queryBuilder->orderBy('o.codEmpenho', 'ASC');
        $queryBuilder = $queryBuilder->getQuery();
        $result = $queryBuilder->getResult();

        $repository = $em->getRepository('CoreBundle:Empenho\OrdemPagamento');

        $cgmPessoaJuridica = [];
        foreach ($result as $value) {
            $data = $repository->getOrdemPagamentoItem($exercicio, $codEntidade, $value->getCodEmpenho());
            if ($data) {
                if (((float) $data['vl_itens'] - (float) $data['vl_itens_anulados']) > ((float) $data['vl_ordem'] - (float) $data['vl_ordem_anulada'])) {
                    array_push($cgmPessoaJuridica, ['id' => $value->getCodEmpenho(), 'label' => $value->getCodEmpenho() . ' - ' . $value->getFkEmpenhoPreEmpenho()->getFkSwCgm()->getNomCgm()]);
                }
            }
        }

        return new JsonResponse(array('items' => $cgmPessoaJuridica));
    }

    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $request = $this->getRequest();
        $route = $request->get('_route');

        Helper\BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->container->get('router'),
            $route,
            $entityManager,
            $param
        );
    }

    public function perfilAction(Request $request)
    {
        $id = $request->get('id');

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $id = explode('~', $id);
        list($codOrdem, $exercicio, $codEntidade) = $id;

        $em = $this->getDoctrine()->getManager();

        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->findOneBy([
                'codOrdem' => $codOrdem,
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade
            ]);

        $tipoRetencao = array(
            'orcamentaria' => 0,
            'extraOrcamentaria' => 0
        );

        $retencoes = $ordemPagamento->getFkEmpenhoOrdemPagamentoRetencoes();
        foreach ($retencoes as $retencao) {
            if ($retencao->getCodReceita()) {
                $tipoRetencao['orcamentaria']++;
            } else {
                $tipoRetencao['extraOrcamentaria']++;
            }
        }

        $fornecedor = null;
        $total = null;
        $info = null;
        $contaDespesa = null;
        $despesa = null;
        $notaLiquidacaoPagas = null;
        if ($ordemPagamento->getFkEmpenhoPagamentoLiquidacoes()->count()) {
            foreach ($ordemPagamento->getFkEmpenhoPagamentoLiquidacoes() as $pagamentoLiquidacao) {
                foreach ($pagamentoLiquidacao->getFkEmpenhoPagamentoLiquidacaoNotaLiquidacaoPagas() as $notaLiquidacaoPaga) {
                    $notaLiquidacaoPagas[] = $notaLiquidacaoPaga;
                }

                $contaDespesa = $pagamentoLiquidacao
                    ->getFkEmpenhoNotaLiquidacao()
                    ->getFkEmpenhoEmpenho()
                    ->getFkEmpenhoPreEmpenho()
                    ->getFkEmpenhoPreEmpenhoDespesa()
                    ->getFkOrcamentoContaDespesa();
                $despesa = $pagamentoLiquidacao
                    ->getFkEmpenhoNotaLiquidacao()
                    ->getFkEmpenhoEmpenho()
                    ->getFkEmpenhoPreEmpenho()
                    ->getFkEmpenhoPreEmpenhoDespesa()
                    ->getFkOrcamentoDespesa();
            }

            $pagamentoLiquidacao = $ordemPagamento->getFkEmpenhoPagamentoLiquidacoes()->last();

            $notaLiquidacaoItem = $pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao()->getFkEmpenhoNotaLiquidacaoItens()->last();

            $fornecedor = $em->getRepository('CoreBundle:Empenho\PreEmpenho')
                ->findOneBy([
                    'codPreEmpenho' => $notaLiquidacaoItem->getCodPreEmpenho(),
                    'exercicio' => $notaLiquidacaoItem->getExercicio(),
                ])->getFkSwCgm();
        }

        return $this->render('FinanceiroBundle::Empenho/OrdemPagamento/perfil.html.twig', array(
            'ordemPagamento' => $ordemPagamento,
            'tipoRetencao' => $tipoRetencao,
            'fornecedor' => $fornecedor,
            'contaDespesa' => $contaDespesa,
            'despesa' => $despesa,
            'notaLiquidacaoPagas' => $notaLiquidacaoPagas
        ));
    }
}
