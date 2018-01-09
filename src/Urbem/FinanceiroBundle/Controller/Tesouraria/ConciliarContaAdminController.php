<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\Tesouraria\Conciliacao;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Model\Tesouraria\ConciliacaoModel;
use Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria\ConciliarContaAdmin;

class ConciliarContaAdminController extends CRUDController
{
    public function relatorioAction(Request $request)
    {
        $objectId = $this->getRequest()->get('id');
        list($codPlano, $exercicio, $mes, $dtExtrato) = explode('~', $objectId);
        list($d, $m, $y) = explode('/', $dtExtrato);
        $dtExtrato = new \DateTime(sprintf('%s-%s-%s', $y, $m, $d));

        $em = $this->getDoctrine()->getManager();

        $conciliacao = $em->getRepository(Conciliacao::class)
            ->findOneBy([
                'codPlano' => $codPlano,
                'exercicio' => $exercicio,
                'mes' => $mes
            ]);

        $conciliacaoModel = new ConciliacaoModel($em);
        /**
         * Cabeçalho do PDF
         */
        $cabecalho = $conciliacaoModel->montaRecuperaCabecalhoConciliacao($codPlano, $exercicio, $mes);

        /* Movimentação */
        $params = $conciliacaoModel->montaParamsMovimentacao($exercicio, $conciliacao->getFkContabilidadePlanoBanco()->getCodEntidade(), $dtExtrato->format('d/m/Y'), $codPlano, $mes);
        $movimentacoes = $conciliacaoModel->recuperaMovimentacao($params);

        unset($params);

        /* Pendências */
        $params = $conciliacaoModel->montaParamsMovimentacaoPendente($codPlano, $exercicio, $mes, $dtExtrato->format('d/m/Y'), $conciliacao->getFkContabilidadePlanoBanco()->getCodEntidade());
        $movimentacoesPendente = $conciliacaoModel->recuperaMovimentacaoPendente($params);

        /* Manual */
        $movimentacoesManuais = $conciliacaoModel->listLancamentosManuais($codPlano, $exercicio, $mes);
        $nuSaldoContabilConciliado = 0;
        for ($x = 0; $x < count($movimentacoes); $x++) {
            if (!$movimentacoes[$x]['conciliar']) {
                $nuSaldoContabilConciliado = bcadd($nuSaldoContabilConciliado, $movimentacoes[$x]['vl_lancamento'], 4);
            } else {
                if (substr($movimentacoes[$x]['dt_conciliacao'], 3, 2) != $conciliacao->getMes()) {
                    $nuSaldoContabilConciliado = bcadd($nuSaldoContabilConciliado, ($movimentacoes[$x]['vl_lancamento']), 4);
                }
            }
        }

        /* Pendencia */
        $arPendencia = (count($movimentacoesPendente) > 0) ? $movimentacoesPendente : array();

        /* Manual */
        $arManual = (count($movimentacoesManuais) > 0) ? $movimentacoesManuais : array();

        for ($x = 0; $x < count($arPendencia); $x++) {
            if (!$arPendencia[$x]['conciliar']) {
                $nuSaldoContabilConciliado = bcadd($nuSaldoContabilConciliado, ($arPendencia[$x]['vl_lancamento'] * (-1)), 4);
            } else {
                if (substr($arPendencia[$x]['dt_conciliacao'], 3, 2) != $conciliacao->getMes()) {
                    $nuSaldoContabilConciliado = bcadd($nuSaldoContabilConciliado, ($arPendencia[$x]['vl_lancamento'] * (-1)), 4);
                }
            }
        }

        $arLista = array_merge($movimentacoes, $arPendencia);

        for ($x = 0; $x < count($arManual); $x++) {
            $inSequencia = $arManual[$x]['sequencia'] - 1;
            $arManual[$x]['id'] = 'M' . $inSequencia;
            if ($arManual[$x]['conciliado'] != 'true') {
                $nuSaldoContabilConciliado = bcsub($nuSaldoContabilConciliado, $arManual[$x]['vl_lancamento'], 4);
            }
        }

        $arLista = array_merge($arLista, $arManual);

        if (count($arLista)) {
            sort($arLista);
        }

        $nuSaldoTesouraria = $conciliacaoModel->recuperaSaldoContaTesouraria($codPlano, $exercicio, false, $dtExtrato->format('d/m/Y'));
        $nuSaldoContabilConciliado = bcsub($nuSaldoTesouraria, $nuSaldoContabilConciliado, 4);
        $nuSaldoContabilConciliado = number_format($nuSaldoContabilConciliado, 2, ',', '.');

        $dados = $this->montaDadosRelatorio($arLista, $conciliacao);
        $container = $this->container;

        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $dtEmissao = new \DateTime('now');

        $entidadeModel = new EntidadeModel($em);
        $entidade = $entidadeModel->findOneByCodEntidade($cabecalho['cod_entidade']);
        $cgmPessoaJuridica = $em->getRepository(SwCgmPessoaJuridica::class)->find($entidade->getNumcgm());

        $mesExtenso = $this->admin->retornaMes($cabecalho['mes']);

        $assinaturas = $em->getRepository('CoreBundle:Tesouraria\Assinatura')->findBy(
            [
                'exercicio' => $exercicio,
                'codEntidade' => $entidade->getCodEntidade(),
                'tipo' => ConciliarContaAdmin::TIPO_ASSINATURA
            ]
        );

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $html = $this->renderView(
            'FinanceiroBundle:Tesouraria/ConciliarConta:pdf.html.twig',
            [
                'entidade' => $entidade,
                'cgmPessoaJuridica' => $cgmPessoaJuridica,
                'modulo' => 'Tesouraria',
                'subModulo' => 'Conciliação Bancária',
                'funcao' => 'Emitir Relatório',
                'nomRelatorio' => 'Conciliação Bancária Conta - Nro. ' . $cabecalho['nom_conta'],
                'dtEmissao' => $dtEmissao,
                'usuario' => $usuario,
                'versao' => $container->getParameter('version'),
                'nuSaldoContabilConciliado' => $nuSaldoContabilConciliado,
                'entradaTesouraria' => $dados['entradaTesouraria'],
                'saidaTesouraria' => $dados['saidaTesouraria'],
                'entradaBanco' => $dados['entradaBanco'],
                'saidaBanco' => $dados['saidaBanco'],
                'cabecalho' => $cabecalho,
                'nuSaldoTesouraria' => $nuSaldoTesouraria,
                'mesExtenso' => $mesExtenso,
                'assinaturas' => $assinaturas
            ]
        );

        $filename = sprintf('ConciliacaoBancaria-%s.pdf', date('Y-m-d'));

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

    /**
     * @param array $arLista
     * @param $conciliacao
     * @return mixed
     */
    public function montaDadosRelatorio(array $arLista, $conciliacao)
    {
        $arLinha2['entradaTesouraria'] = array();
        $arLinha2['saidaTesouraria'] = array();
        $arLinha2['entradaBanco'] = array();
        $arLinha2['saidaBanco'] = array();
        foreach ($arLista as $lista) {
            $inMesConciliacao = substr($lista['dt_conciliacao'], 3, 2);

            //regra: se nao estiver conciliado ou se a conciliacao nao e do mes corrente
            if ((!isset($lista['conciliar']) || (!isset($lista['conciliado']))) or $inMesConciliacao != $conciliacao->getMes()) {
                $nuVlLancamento = $lista["vl_lancamento"];
                if (intval(substr($lista["dt_lancamento"], 3, 2)) != $conciliacao->getMes() or isset($lista['conciliar'])) {
                    if ($lista['tipo_movimentacao']) {
                        $nuVlLancamento = $nuVlLancamento * (-1);
                    }
                }

                if (isset($lista['ordem']) and trim($lista['ordem']) == "") {
                    // tipo == C (entrada) | tipo == D (saida)
                    if ($lista['tipo_valor'] == ConciliarContaAdmin::TIPO_VALOR_ENTRADA) {
                        $stChave = 'entradaTesouraria';
                    } else {
                        $stChave = 'saidaTesouraria';
                    }
                    // se não é uma movimentacao corrente do mes passado
                } else {
                    if ($lista['vl_lancamento'] < 0) {
                        $stChave = 'entradaBanco';
                    } else {
                        $stChave = 'saidaBanco';
                    }
                }

                $inCount = count($arLinha2[$stChave]);

                list($dia, $mes, $ano) = explode('/', $lista["dt_lancamento"]);
                $arLinha2[$stChave][$inCount]['ordem'] = $ano . $mes . $dia;
                $arLinha2[$stChave][$inCount]['movimentacao'] = $lista["dt_lancamento"];
                $arLinha2[$stChave][$inCount]['valor'] = "";

                $stNom = $lista['descricao'];
                if (isset($lista['tipo']) and $lista['tipo'] == 'P' and trim($stNom)) {
                    if (!strstr($stNom, "Borderô") and isset($lista['observacao'])) {
                        $stNom .= " - " . trim($lista['observacao']);
                    }
                }

                $stNom = str_replace(chr(10), "", $stNom);
                $stNom = str_replace(chr(13), " ", $stNom);

                $stNom = wordwrap($stNom, 75, chr(13));
                $arNom = explode(chr(13), $stNom);

                foreach ($arNom as $stNom) {
                    $arLinha2[$stChave][$inCount]['descricao'] = $stNom;
                    $arLinha2[$stChave][$inCount]['valor'] = number_format($nuVlLancamento, 2, ",", ".");
                    $inCount++;
                }
            }
        }
        return $arLinha2;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteSwCgmPessoaFisicaAction(Request $request)
    {
        $parameter = $request->get('q');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(SwCgm::class);

        $qb = $repository->createQueryBuilder('o');
        $qb->innerJoin('o.fkSwCgmPessoaFisica', 'pf');
        $qb->where($qb->expr()->orX(
            $qb->expr()->like('LOWER(o.nomCgm)', ':nomCgm'),
            $qb->expr()->eq('pf.numcgm', ':numcgm'),
            $qb->expr()->eq('pf.cpf', ':cpf')
        ));
        $qb->setParameters([
            'nomCgm' => sprintf('%%%s%%', strtolower($parameter)),
            'numcgm' => ((int) $parameter) ? $parameter: null,
            'cpf' => (string) $parameter
        ]);
        $qb->orderBy('o.nomCgm', 'ASC');
        $result = $qb->getQuery()->getResult();

        $cgms = [];
        foreach ($result as $value) {
            array_push($cgms, ['id' => $value->getNumCgm(), 'label' => (string) $value]);
        }

        return new JsonResponse(array('items' => $cgms));
    }
}
