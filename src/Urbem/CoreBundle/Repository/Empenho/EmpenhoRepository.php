<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;

class EmpenhoRepository extends ORM\EntityRepository
{
    /**
     * @return mixed
     */
    public function getProximoCodEmpenho()
    {
        $sql = "
        SELECT COALESCE(max(e.cod_empenho), 0) AS cod_empenho
        FROM empenho.empenho e
        ;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->cod_empenho + 1;
    }

    /**
     * Função do sistema antigo, para gerar lotes
     *
     * @param  string  $stExercicio
     * @param  integer $inCodEntidade
     * @param  string  $stTipo
     * @param  string  $stNomeLote
     * @param  string  $stDataLote
     * @return integer
     */
    public function fnInsereLote($stExercicio, $inCodEntidade, $stTipo, $stNomeLote, $stDataLote)
    {
        $sql = sprintf(
            "SELECT contabilidade.fn_insere_lote('%s', %d, '%s', '%s', '%s') AS cod_lote",
            $stExercicio,
            $inCodEntidade,
            $stTipo,
            $stNomeLote,
            $stDataLote
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();

        $result = $result->fetch(\PDO::FETCH_OBJ);

        return $result->cod_lote;
    }

    /**
     * @param $exercicio
     * @param $valor
     * @param $complemento
     * @param $codLote
     * @param $tipoLote
     * @param $codEntidade
     * @param $codNota
     * @param $contaPagamentoFinanc
     * @param $clasDespesa
     * @param $numOrgao
     * @param $botCems
     * @param $codPlanoDebito
     * @param $codPlanoCredito
     * @return mixed
     */
    public function empenhoAnulacaoPagamento($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codNota, $contaPagamentoFinanc, $clasDespesa, $numOrgao, $botCems, $codPlanoDebito, $codPlanoCredito)
    {
        $sql = "
        SELECT
            public.empenhoanulacaopagamento(
                :exercicio,
                :valor,
                :complemento,
                :codLote,
                :tipoLote,
                :codEntidade,
                :codNota,
                :contaPagamentoFinanc,
                :clasDespesa,
                :numOrgao,
                :botCems,
                :codPlanoDebito,
                :codPlanoCredito) AS sequencia";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('valor', $valor);
        $query->bindValue('complemento', $complemento);
        $query->bindValue('codLote', $codLote);
        $query->bindValue('tipoLote', $tipoLote);
        $query->bindValue('codEntidade', $codEntidade);
        $query->bindValue('codNota', $codNota);
        $query->bindValue('contaPagamentoFinanc', $contaPagamentoFinanc);
        $query->bindValue('clasDespesa', $clasDespesa);
        $query->bindValue('numOrgao', $numOrgao);
        $query->bindValue('botCems', $botCems);
        $query->bindValue('codPlanoDebito', $codPlanoDebito);
        $query->bindValue('codPlanoCredito', $codPlanoCredito);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->sequencia;
    }

    /**
     * @param $exercicio
     * @param $valor
     * @param $complemento
     * @param $codLote
     * @param $tipoLote
     * @param $codEntidade
     * @param $codPreEmpenho
     * @param $codDespesa
     * @param $codClassDespesa
     * @return mixed
     */
    public function empenhoEmissao($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codPreEmpenho, $codDespesa, $codClassDespesa)
    {
        $sql = "
        SELECT EmpenhoEmissao(:exercicio, :valor, :complemento, :codLote, :tipoLote, :codEntidade, :codPreEmpenho, :codDespesa, :codClassDespesa) AS sequencia
        ;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('valor', $valor);
        $query->bindValue('complemento', $complemento);
        $query->bindValue('codLote', $codLote);
        $query->bindValue('tipoLote', $tipoLote);
        $query->bindValue('codEntidade', $codEntidade);
        $query->bindValue('codPreEmpenho', $codPreEmpenho);
        $query->bindValue('codDespesa', $codDespesa);
        $query->bindValue('codClassDespesa', $codClassDespesa);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->sequencia;
    }

    /**
     * @param $exercicio
     * @param $valor
     * @param $complemento
     * @param $codLote
     * @param $tipoLote
     * @param $codEntidade
     * @param $codNota
     * @param $contaPagamentoFinanc
     * @param $clasDespesa
     * @param $numOrgao
     * @param $botCems
     * @param $codPlanoDebito
     * @param $codPlanoCredito
     * @return mixed
     */
    public function empenhoPagamento($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codNota, $contaPagamentoFinanc, $clasDespesa, $numOrgao, $botCems, $codPlanoDebito, $codPlanoCredito)
    {
        $sql = "
        SELECT
            EmpenhoPagamento (
                :exercicio,
                :valor,
                :complemento,
                :codLote,
                :tipoLote,
                :codEntidade,
                :codNota,
                :contaPagamentoFinanc,
                :clasDespesa,
                :numOrgao,
                :botCems,
                :codPlanoDebito,
                :codPlanoCredito ) AS sequencia
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('valor', $valor);
        $query->bindValue('complemento', $complemento);
        $query->bindValue('codLote', $codLote);
        $query->bindValue('tipoLote', $tipoLote);
        $query->bindValue('codEntidade', $codEntidade);
        $query->bindValue('codNota', $codNota);
        $query->bindValue('contaPagamentoFinanc', $contaPagamentoFinanc);
        $query->bindValue('clasDespesa', $clasDespesa);
        $query->bindValue('numOrgao', $numOrgao);
        $query->bindValue('botCems', $botCems);
        $query->bindValue('codPlanoDebito', $codPlanoDebito);
        $query->bindValue('codPlanoCredito', $codPlanoCredito);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->sequencia;
    }

    /**
     * Função do sistema antigo que gera uma sequência para uma anulação de Empenho
     *
     * @param  string  $exercicio
     * @param  float   $valor
     * @param  string  $complemento
     * @param  integer $codLote
     * @param  string  $tipoLote
     * @param  integer $codEntidade
     * @param  integer $codPreEmpenho
     * @param  integer $codDespesa
     * @param  string  $codClassDespesa
     * @return [type]
     */
    public function empenhoEmissaoAnulacao($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codPreEmpenho, $codDespesa, $codClassDespesa)
    {
        $sql = "
        SELECT EmpenhoEmissaoAnulacao(:exercicio, :valor, :complemento, :codLote, :tipoLote, :codEntidade, :codPreEmpenho, :codDespesa, :codClassDespesa) AS sequencia
        ;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('valor', $valor);
        $query->bindValue('complemento', $complemento);
        $query->bindValue('codLote', $codLote);
        $query->bindValue('tipoLote', $tipoLote);
        $query->bindValue('codEntidade', $codEntidade);
        $query->bindValue('codPreEmpenho', $codPreEmpenho);
        $query->bindValue('codDespesa', $codDespesa);
        $query->bindValue('codClassDespesa', $codClassDespesa);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->sequencia;
    }

    public function filterPreEmpenho($filter)
    {
        $sql = "
        SELECT pe.cod_pre_empenho
        FROM empenho.pre_empenho pe
        INNER JOIN empenho.autorizacao_empenho ae ON ae.cod_pre_empenho = pe.cod_pre_empenho
        	AND ae.exercicio = pe.exercicio
        LEFT JOIN empenho.pre_empenho_despesa ped ON ped.cod_pre_empenho = pe.cod_pre_empenho
        	AND ped.exercicio = pe.exercicio
        LEFT JOIN empenho.item_pre_empenho ipe ON ipe.cod_pre_empenho = pe.cod_pre_empenho
        	AND ipe.exercicio = pe.exercicio
        LEFT JOIN empenho.item_pre_empenho_julgamento ipej ON ipej.cod_pre_empenho = ipe.cod_pre_empenho
        	AND ipej.exercicio = ipe.exercicio
        	AND ipej.num_item = ipe.num_item
        LEFT JOIN compras.julgamento_item ji ON ji.exercicio = ipej.exercicio_julgamento
        	AND ji.cod_cotacao = ipej.cod_cotacao
        	AND ji.cod_item = ipej.cod_item
        	AND ji.lote = ipej.lote
        	AND ji.cgm_fornecedor = ipej.cgm_fornecedor
        LEFT JOIN compras.cotacao_item ci ON ci.exercicio = ji.exercicio
        	AND ci.cod_cotacao = ji.cod_cotacao
        	AND ci.lote = ji.lote
        	AND ci.cod_item = ji.cod_item
        LEFT JOIN compras.cotacao c ON c.cod_cotacao = ci.cod_cotacao
        	AND c.exercicio = ci.exercicio
        LEFT JOIN compras.mapa_cotacao mc ON mc.cod_cotacao = c.cod_cotacao
        	AND mc.exercicio_cotacao = c.exercicio
        LEFT JOIN compras.mapa m ON m.cod_mapa = mc.cod_mapa
        	AND m.exercicio = mc.exercicio_mapa
        LEFT JOIN compras.compra_direta cd ON cd.cod_mapa = m.cod_mapa
        	AND cd.exercicio_mapa = m.exercicio
        LEFT JOIN licitacao.adjudicacao a ON a.exercicio_cotacao = ci.exercicio
        	AND a.cod_cotacao = ci.cod_cotacao
        	AND a.lote = ci.lote
        	AND a.cod_item = ci.cod_item
        WHERE 1 = 1
        ";

        if ($filter['codEntidade']['value'] !== "") {
            $sql .= " AND ae.cod_entidade = :cod_entidade";
        }

        if ($filter['codCentroCusto']['value'] !== "") {
            $sql .= " AND ipe.cod_centro = :cod_centro";
        }

        if ($filter['codDespesa']['value'] !== "") {
            $sql .= " AND ped.cod_despesa = :cod_despesa";
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $sql .= " AND ae.cod_autorizacao BETWEEN :codAutorizacaoInicial AND :codAutorizacaoFinal";
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $sql .= " AND ae.dt_autorizacao BETWEEN :periodoInicial AND :periodoFinal";
        }

        if ($filter['cgmBeneficiario']['value'] !== "") {
            $sql .= " AND pe.cgm_beneficiario = :cgm_beneficiario";
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $sql .= " AND cd.cod_modalidade = :cod_modalidade";
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $sql .= " AND cd.cod_compra_direta BETWEEN :codCompraDiretaInicial AND :codCompraDiretaFinal";
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $sql .= " AND a.cod_modalidade = :cod_modalidade";
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $sql .= " AND a.cod_licitacao BETWEEN :codLicitacaoInicial AND :codLicitacaoFinal";
        }

        $query = $this->_em->getConnection()->prepare($sql);

        if ($filter['codEntidade']['value'] !== "") {
            $query->bindValue(':cod_entidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codCentroCusto']['value'] !== "") {
            $query->bindValue(':cod_centro', $filter['codCentroCusto']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codDespesa']['value'] !== "") {
            $query->bindValue(':cod_despesa', $filter['codDespesa']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $query->bindValue(':codAutorizacaoInicial', $filter['codAutorizacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codAutorizacaoFinal', $filter['codAutorizacaoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
            $query->bindValue(':periodoInicial', $periodoInicial);
            $query->bindValue(':periodoFinal', $periodoFinal);
        }

        if ($filter['cgmBeneficiario']['value'] !== "") {
            $query->bindValue(':cgm_beneficiario', $filter['cgmBeneficiario']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeCompra']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $query->bindValue(':codCompraDiretaInicial', $filter['codCompraDiretaInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codCompraDiretaFinal', $filter['codCompraDiretaFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeLicitacao']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $query->bindValue(':codLicitacaoInicial', $filter['codLicitacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codLicitacaoFinal', $filter['codLicitacaoFinal']['value'], \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filter
     * @param $numcgm
     * @return array
     */
    public function filterEmpenho($filter, $numcgm)
    {
        $sql = "
        SELECT
            DISTINCT tabela.*
        FROM (
                SELECT
                    AE.cod_autorizacao,
                    EE.cod_empenho,
                    EE.vl_saldo_anterior,
                    to_char (
                        EE.dt_vencimento,
                        'dd/mm/yyyy' ) AS dt_vencimento,
                    to_char (
                        EE.dt_empenho,
                        'dd/mm/yyyy' ) AS dt_empenho,
                    PD.cod_despesa,
                    PE.descricao,
                    EE.exercicio AS exercicio_empenho,
                    PE.exercicio,
                    PE.cod_pre_empenho,
                    PE.cgm_beneficiario AS credor,
                    EE.cod_entidade,
                    AR.cod_reserva,
                    PD.cod_conta,
                    C.nom_cgm AS nom_fornecedor,
                    R.vl_reserva,
                    OD.num_orgao,
                    OD.num_unidade,
                    OCD.cod_estrutural,
                    OD.cod_recurso,
                    PE.cod_historico,
                    empenho.fn_consultar_valor_empenhado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado,
                    empenho.fn_consultar_valor_empenhado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado_anulado,
                    empenho.fn_consultar_valor_liquidado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado,
                    empenho.fn_consultar_valor_liquidado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado_anulado,
                    empenho.fn_consultar_valor_empenhado_pago (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago,
                    empenho.fn_consultar_valor_empenhado_pago_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago_anulado,
                    compra_direta.cod_modalidade AS compra_cod_modalidade,
                    compra_direta.cod_compra_direta,
                    adjudicacao.cod_modalidade AS licitacao_cod_modalidade,
                    adjudicacao.cod_licitacao
                FROM
                    empenho.empenho AS EE
                LEFT JOIN empenho.empenho_autorizacao AS EA ON EA.exercicio = EE.exercicio
                AND EA.cod_entidade = EE.cod_entidade
                AND EA.cod_empenho = EE.cod_empenho
            LEFT JOIN empenho.autorizacao_empenho AS AE ON AE.exercicio = EA.exercicio
            AND AE.cod_autorizacao = EA.cod_autorizacao
            AND AE.cod_entidade = EA.cod_entidade
            LEFT JOIN empenho.autorizacao_reserva AS AR ON AR.exercicio = AE.exercicio
            AND AR.cod_entidade = AE.cod_entidade
            AND AR.cod_autorizacao = AE.cod_autorizacao
            LEFT JOIN orcamento.reserva AS R ON R.cod_reserva = AR.cod_reserva
            AND R.exercicio = AR.exercicio
            INNER JOIN empenho.pre_empenho AS PE ON EE.cod_pre_empenho = PE.cod_pre_empenho
                AND EE.exercicio = PE.exercicio
            INNER JOIN sw_cgm AS C ON C.numcgm = PE.cgm_beneficiario
            INNER JOIN empenho.pre_empenho_despesa AS PD ON PD.cod_pre_empenho = PE.cod_pre_empenho
                AND PD.exercicio = PE.exercicio
            INNER JOIN orcamento.despesa AS OD ON OD.exercicio = PD.exercicio
                AND OD.cod_despesa = PD.cod_despesa
            LEFT OUTER JOIN orcamento.conta_despesa AS OCD ON OD.cod_conta = OCD.cod_conta
            AND OD.exercicio = OCD.exercicio
            LEFT JOIN empenho.item_pre_empenho ON item_pre_empenho.cod_pre_empenho = pe.cod_pre_empenho
            AND item_pre_empenho.exercicio = pe.exercicio
            LEFT JOIN empenho.item_pre_empenho_julgamento ON item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
            AND item_pre_empenho_julgamento.exercicio = item_pre_empenho.exercicio
            AND item_pre_empenho_julgamento.num_item = item_pre_empenho.num_item
            LEFT JOIN compras.julgamento_item ON julgamento_item.exercicio = item_pre_empenho_julgamento.exercicio_julgamento
            AND julgamento_item.cod_cotacao = item_pre_empenho_julgamento.cod_cotacao
            AND julgamento_item.cod_item = item_pre_empenho_julgamento.cod_item
            AND julgamento_item.lote = item_pre_empenho_julgamento.lote
            AND julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
            LEFT JOIN compras.cotacao_item ON cotacao_item.exercicio = julgamento_item.exercicio
            AND cotacao_item.cod_cotacao = julgamento_item.cod_cotacao
            AND cotacao_item.lote = julgamento_item.lote
            AND cotacao_item.cod_item = julgamento_item.cod_item
            LEFT JOIN compras.cotacao ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
            AND cotacao.exercicio = cotacao_item.exercicio
            LEFT JOIN compras.mapa_cotacao ON mapa_cotacao.cod_cotacao = cotacao.cod_cotacao
            AND mapa_cotacao.exercicio_cotacao = cotacao.exercicio
            LEFT JOIN compras.mapa ON mapa.cod_mapa = mapa_cotacao.cod_mapa
            AND mapa.exercicio = mapa_cotacao.exercicio_mapa
            LEFT JOIN compras.compra_direta ON compra_direta.cod_mapa = mapa.cod_mapa
            AND compra_direta.exercicio_mapa = mapa.exercicio
            LEFT JOIN licitacao.adjudicacao ON adjudicacao.exercicio_cotacao = cotacao_item.exercicio
            AND adjudicacao.cod_cotacao = cotacao_item.cod_cotacao
            AND adjudicacao.lote = cotacao_item.lote
            AND adjudicacao.cod_item = cotacao_item.cod_item
        WHERE
            CAST (
                OD.num_unidade AS varchar )
            || CAST (
                OD.num_orgao AS varchar )
            IN (
                SELECT
                    CAST (
                        num_unidade AS varchar )
                    || CAST (
                        num_orgao AS varchar )
                FROM
                    empenho.permissao_autorizacao
                WHERE
                    numcgm = :numcgm
                    AND exercicio = :exercicio ) ) AS tabela
        WHERE
            tabela.exercicio = :exercicio
        ";

        if ($filter['codEntidade']['value'] !== "") {
            $sql .= " AND tabela.cod_entidade = :cod_entidade";
        }

        if ($filter['codDespesa']['value'] !== "") {
            $sql .= " AND tabela.cod_despesa = :cod_despesa";
        }

        if ($filter['codEmpenhoInicial']['value'] !== "" && $filter['codEmpenhoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_empenho BETWEEN :codEmpenhoInicial AND :codEmpenhoFinal";
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_autorizacao BETWEEN :codAutorizacaoInicial AND :codAutorizacaoFinal";
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $sql .= " AND tabela.dt_empenho BETWEEN :periodoInicial AND :periodoFinal";
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $sql .= " AND tabela.compra_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_compra_direta BETWEEN :codCompraDiretaInicial AND :codCompraDiretaFinal";
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $sql .= " AND tabela.licitacao_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_licitacao BETWEEN :codLicitacaoInicial AND :codLicitacaoFinal";
        }

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':exercicio', $filter['exercicio']['value'], \PDO::PARAM_STR);
        $query->bindValue(':numcgm', $numcgm, \PDO::PARAM_INT);

        if ($filter['codEntidade']['value'] !== "") {
            $query->bindValue(':cod_entidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codDespesa']['value'] !== "") {
            $query->bindValue(':cod_despesa', $filter['codDespesa']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codEmpenhoInicial']['value'] !== "" && $filter['codEmpenhoFinal']['value'] !== "") {
            $query->bindValue(':codEmpenhoInicial', $filter['codEmpenhoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codEmpenhoFinal', $filter['codEmpenhoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $query->bindValue(':codAutorizacaoInicial', $filter['codAutorizacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codAutorizacaoFinal', $filter['codAutorizacaoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
            $query->bindValue(':periodoInicial', $periodoInicial);
            $query->bindValue(':periodoFinal', $periodoFinal);
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeCompra']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $query->bindValue(':codCompraDiretaInicial', $filter['codCompraDiretaInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codCompraDiretaFinal', $filter['codCompraDiretaFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeLicitacao']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $query->bindValue(':codLicitacaoInicial', $filter['codLicitacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codLicitacaoFinal', $filter['codLicitacaoFinal']['value'], \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public function getAllEmpenhoPreEmpenho()
    {
        $sql = "
        SELECT e.cod_pre_empenho
        FROM empenho.empenho e
        WHERE e.cod_pre_empenho IS NOT NULL;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codEntidade
     * @param $numCgm
     * @param $exercicio
     * @param $codEmpenhoInicial
     * @param $codEmpenhoFinal
     * @param $periodoInicial
     * @param $periodoFinal
     * @return array
     */
    public function getEmpenhoOriginal($codEntidade, $numCgm, $exercicio, $codEmpenhoInicial, $codEmpenhoFinal, $periodoInicial, $periodoFinal)
    {
        $sql = "
        SELECT
            tabela.*
        FROM (
                SELECT
                    AE.cod_autorizacao,
                    EE.cod_empenho,
                    EE.vl_saldo_anterior,
                    to_char (
                        EE.dt_vencimento,
                        'dd/mm/yyyy' ) AS dt_vencimento,
                    to_char (
                        EE.dt_empenho,
                        'dd/mm/yyyy' ) AS dt_empenho,
                    PD.cod_despesa,
                    PE.descricao,
                    EE.exercicio AS exercicio_empenho,
                    PE.exercicio,
                    PE.cod_pre_empenho,
                    PE.cgm_beneficiario AS credor,
                    EE.cod_entidade,
                    AR.cod_reserva,
                    PD.cod_conta,
                    C.nom_cgm AS nom_fornecedor,
                    R.vl_reserva,
                    OD.num_orgao,
                    OD.num_unidade,
                    OCD.cod_estrutural,
                    OD.cod_recurso,
                    PE.cod_historico,
                    empenho.fn_consultar_valor_empenhado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado,
                    empenho.fn_consultar_valor_empenhado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado_anulado,
                    empenho.fn_consultar_valor_liquidado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado,
                    empenho.fn_consultar_valor_liquidado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado_anulado,
                    empenho.fn_consultar_valor_empenhado_pago (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago,
                    empenho.fn_consultar_valor_empenhado_pago_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago_anulado
                FROM
                    empenho.empenho AS EE
                LEFT JOIN empenho.empenho_autorizacao AS EA ON EA.exercicio = EE.exercicio
                AND EA.cod_entidade = EE.cod_entidade
                AND EA.cod_empenho = EE.cod_empenho
            LEFT JOIN empenho.autorizacao_empenho AS AE ON AE.exercicio = EA.exercicio
            AND AE.cod_autorizacao = EA.cod_autorizacao
            AND AE.cod_entidade = EA.cod_entidade
            LEFT JOIN empenho.autorizacao_reserva AS AR ON AR.exercicio = AE.exercicio
            AND AR.cod_entidade = AE.cod_entidade
            AND AR.cod_autorizacao = AE.cod_autorizacao
            LEFT JOIN orcamento.reserva AS R ON R.cod_reserva = AR.cod_reserva
            AND R.exercicio = AR.exercicio
            INNER JOIN empenho.pre_empenho AS PE ON EE.cod_pre_empenho = PE.cod_pre_empenho
                AND EE.exercicio = PE.exercicio
            INNER JOIN sw_cgm AS C ON C.numcgm = PE.cgm_beneficiario
            INNER JOIN empenho.pre_empenho_despesa AS PD ON PD.cod_pre_empenho = PE.cod_pre_empenho
                AND PD.exercicio = PE.exercicio
            INNER JOIN orcamento.despesa AS OD ON OD.exercicio = PD.exercicio
                AND OD.cod_despesa = PD.cod_despesa
            LEFT JOIN orcamento.conta_despesa AS OCD ON OD.cod_conta = OCD.cod_conta
            AND OD.exercicio = OCD.exercicio
        WHERE
            CAST (
                OD.num_unidade AS varchar )
            || CAST (
                OD.num_orgao AS varchar )
            IN (
                SELECT
                    CAST (
                        num_unidade AS varchar )
                    || CAST (
                        num_orgao AS varchar )
                FROM
                    empenho.permissao_autorizacao
                WHERE
                    numcgm = :numcgm
                    AND exercicio = :exercicio ) ) AS tabela
        WHERE
            tabela.exercicio = :exercicio
            AND tabela.cod_entidade = :codEntidade
            AND tabela.cod_empenho >= :codEmpenhoInicial
            AND tabela.cod_empenho <= :codEmpenhoFinal
            AND to_date (
                dt_empenho,
                'dd/mm/yyyy' )
            BETWEEN to_date (
                :periodoInicial,
                'dd/mm/yyyy' )
            AND to_date (
                :periodoFinal,
                'dd/mm/yyyy' )
            AND (
                tabela.vl_empenhado - tabela.vl_empenhado_anulado )
            > 0
        ORDER BY
            tabela.cod_entidade,
            tabela.cod_empenho,
            tabela.nom_fornecedor
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':codEntidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue(':numcgm', $numCgm, \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $exercicio);
        $query->bindValue(':codEmpenhoInicial', $codEmpenhoInicial, \PDO::PARAM_INT);
        $query->bindValue(':codEmpenhoFinal', $codEmpenhoFinal, \PDO::PARAM_INT);
        $query->bindValue(':periodoInicial', $periodoInicial);
        $query->bindValue(':periodoFinal', $periodoFinal);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codEmpenho
     * @param $codEntidade
     * @param $numCgm
     * @param $exercicio
     * @return mixed
     */
    public function getInformacaoEmpenhoOriginal($codEmpenho, $codEntidade, $numCgm, $exercicio)
    {
        $sql = "
        SELECT
            tabela.*
        FROM (
                SELECT
                    AE.cod_autorizacao,
                    EE.cod_empenho,
                    EE.vl_saldo_anterior,
                    to_char (
                        EE.dt_vencimento,
                        'dd/mm/yyyy' ) AS dt_vencimento,
                    to_char (
                        EE.dt_empenho,
                        'dd/mm/yyyy' ) AS dt_empenho,
                    PD.cod_despesa,
                    PE.descricao,
                    EE.exercicio AS exercicio_empenho,
                    PE.exercicio,
                    PE.cod_pre_empenho,
                    PE.cgm_beneficiario AS credor,
                    EE.cod_entidade,
                    AR.cod_reserva,
                    PD.cod_conta,
                    C.nom_cgm AS nom_fornecedor,
                    R.vl_reserva,
                    OD.num_orgao,
                    OD.num_unidade,
                    OCD.cod_estrutural,
                    OD.cod_recurso,
                    PE.cod_historico,
                    empenho.fn_consultar_valor_empenhado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado,
                    empenho.fn_consultar_valor_empenhado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado_anulado,
                    empenho.fn_consultar_valor_liquidado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado,
                    empenho.fn_consultar_valor_liquidado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado_anulado,
                    empenho.fn_consultar_valor_empenhado_pago (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago,
                    empenho.fn_consultar_valor_empenhado_pago_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago_anulado,
                    EE.cod_categoria,
                    PE.cod_tipo
                FROM
                    empenho.empenho AS EE
                LEFT JOIN empenho.empenho_autorizacao AS EA ON EA.exercicio = EE.exercicio
                AND EA.cod_entidade = EE.cod_entidade
                AND EA.cod_empenho = EE.cod_empenho
            LEFT JOIN empenho.autorizacao_empenho AS AE ON AE.exercicio = EA.exercicio
            AND AE.cod_autorizacao = EA.cod_autorizacao
            AND AE.cod_entidade = EA.cod_entidade
            LEFT JOIN empenho.autorizacao_reserva AS AR ON AR.exercicio = AE.exercicio
            AND AR.cod_entidade = AE.cod_entidade
            AND AR.cod_autorizacao = AE.cod_autorizacao
            LEFT JOIN orcamento.reserva AS R ON R.cod_reserva = AR.cod_reserva
            AND R.exercicio = AR.exercicio
            INNER JOIN empenho.pre_empenho AS PE ON EE.cod_pre_empenho = PE.cod_pre_empenho
                AND EE.exercicio = PE.exercicio
            INNER JOIN sw_cgm AS C ON C.numcgm = PE.cgm_beneficiario
            INNER JOIN empenho.pre_empenho_despesa AS PD ON PD.cod_pre_empenho = PE.cod_pre_empenho
                AND PD.exercicio = PE.exercicio
            INNER JOIN orcamento.despesa AS OD ON OD.exercicio = PD.exercicio
                AND OD.cod_despesa = PD.cod_despesa
            LEFT JOIN orcamento.conta_despesa AS OCD ON OD.cod_conta = OCD.cod_conta
            AND OD.exercicio = OCD.exercicio
        WHERE
            CAST (
                OD.num_unidade AS varchar )
            || CAST (
                OD.num_orgao AS varchar )
            IN (
                SELECT
                    CAST (
                        num_unidade AS varchar )
                    || CAST (
                        num_orgao AS varchar )
                FROM
                    empenho.permissao_autorizacao
                WHERE
                    numcgm = :numcgm
                    AND exercicio = :exercicio ) ) AS tabela
        WHERE
            tabela.exercicio = :exercicio
            AND tabela.cod_entidade = :codEntidade
            AND tabela.cod_empenho = :codEmpenho
            AND (
                tabela.vl_empenhado - tabela.vl_empenhado_anulado )
            > 0
        ORDER BY
            tabela.cod_entidade,
            tabela.cod_empenho,
            tabela.nom_fornecedor
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':codEmpenho', $codEmpenho, \PDO::PARAM_INT);
        $query->bindValue(':codEntidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue(':numcgm', $numCgm, \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $exercicio);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codEmpenho
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function consultarValorItemLiquidacaoEmpenho($codEmpenho, $exercicio, $codEntidade)
    {
        $sql = sprintf(
            "SELECT
                EE.cod_empenho,
                PE.cod_pre_empenho,
                IE.num_item,
                IE.nom_item,
                IE.quantidade,
                IE.cod_unidade,
                IE.cod_grandeza,
                IE.nom_unidade,
                IE.vl_total,
                (IE.vl_total / IE.quantidade) AS vl_unitario,
                empenho.fn_consultar_valor_empenhado_anulado_item(
                    EE.exercicio,
                    EE.cod_empenho,
                    EE.cod_entidade,
                    IE.num_item
                ) AS vl_empenhado_anulado,
                empenho.fn_consultar_valor_liquidado_item(
                    EE.exercicio,
                    EE.cod_empenho,
                    EE.cod_entidade,
                    IE.num_item
                ) AS vl_liquidado,
                empenho.fn_consultar_valor_liquidado_anulado_item(
                    EE.exercicio,
                    EE.cod_empenho,
                    EE.cod_entidade,
                    IE.num_item
                ) AS vl_liquidado_anulado
            FROM
                empenho.pre_empenho AS PE,
                empenho.item_pre_empenho AS IE,
                empenho.empenho AS EE
            WHERE
                PE.exercicio = EE.exercicio
                AND PE.cod_pre_empenho = EE.cod_pre_empenho
                AND IE.cod_pre_empenho = PE.cod_pre_empenho
                AND IE.exercicio = PE.exercicio
                AND EE.cod_empenho = %d
                AND EE.cod_entidade = %d
                AND EE.exercicio = '%s'",
            $codEmpenho,
            $codEntidade,
            $exercicio
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $filter
     * @param $exercicio
     * @return array
     */
    public function filterConsultarEmpenho($filter, $exercicio)
    {
        $sql = "
        SELECT
            tabela.cod_entidade,
            tabela.cod_empenho,
            tabela.cod_pre_empenho,
            tabela.cod_autorizacao,
            tabela.cod_reserva,
            tabela.implantado,
            tabela.exercicio,
            tabela.dt_empenho,
            tabela.nom_fornecedor,
            tabela.vl_empenhado
        FROM (
                SELECT
                    AE.cod_autorizacao,
                    EE.cod_empenho,
                    EE.vl_saldo_anterior,
                    to_char (
                        EE.dt_vencimento,
                        'dd/mm/yyyy' ) AS dt_vencimento,
                    to_char (
                        EE.dt_empenho,
                        'dd/mm/yyyy' ) AS dt_empenho,
                    PED_D_CD.cod_despesa,
                    PE.descricao,
                    PE.exercicio,
                    PE.cod_pre_empenho,
                    PE.cgm_beneficiario AS credor,
                    EE.cod_entidade,
                    AR.cod_reserva,
                    PED_D_CD.cod_conta,
                    C.nom_cgm AS nom_fornecedor,
                    R.vl_reserva,
                    PE.implantado,
                    CASE
                        WHEN PE.implantado = TRUE THEN RE.num_orgao
                        ELSE PED_D_CD.num_orgao
                    END AS num_orgao,
                    CASE
                        WHEN PE.implantado = TRUE THEN RE.num_unidade
                        ELSE PED_D_CD.num_unidade
                    END AS num_unidade,
                    CASE
                        WHEN PE.implantado = TRUE THEN RE.cod_estrutural
                        ELSE PED_D_CD.cod_estrutural
                    END AS cod_estrutural,
                    CASE
                        WHEN PE.implantado = TRUE THEN RE.recurso
                        ELSE PED_D_CD.cod_recurso
                    END AS cod_recurso,
                    PED_D_CD.cod_fonte,
                    PE.cod_historico,
                    NL.cod_nota,
                    NL.exercicio AS exercicio_liquidacao,
                    empenho.fn_consultar_valor_empenhado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado,
                    empenho.fn_consultar_valor_empenhado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado_anulado,
                    empenho.fn_consultar_valor_liquidado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado,
                    empenho.fn_consultar_valor_liquidado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado_anulado,
                    empenho.fn_consultar_valor_empenhado_pago (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago,
                    empenho.fn_consultar_valor_empenhado_pago_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago_anulado,
                    compra_direta.cod_modalidade AS compra_cod_modalidade,
                    compra_direta.cod_compra_direta,
                    adjudicacao.cod_modalidade AS licitacao_cod_modalidade,
                    adjudicacao.cod_licitacao
                FROM
                    empenho.empenho AS EE
                LEFT JOIN empenho.nota_liquidacao AS NL ON NL.exercicio_empenho = EE.exercicio
                AND NL.cod_entidade = EE.cod_entidade
                AND NL.cod_empenho = EE.cod_empenho
            LEFT JOIN empenho.empenho_autorizacao AS EA ON EA.exercicio = EE.exercicio
            AND EA.cod_entidade = EE.cod_entidade
            AND EA.cod_empenho = EE.cod_empenho
            LEFT JOIN empenho.autorizacao_empenho AS AE ON AE.exercicio = EA.exercicio
            AND AE.cod_autorizacao = EA.cod_autorizacao
            AND AE.cod_entidade = EA.cod_entidade
            LEFT JOIN empenho.autorizacao_reserva AS AR ON AR.exercicio = AE.exercicio
            AND AR.cod_entidade = AE.cod_entidade
            AND AR.cod_autorizacao = AE.cod_autorizacao
            LEFT JOIN orcamento.reserva AS R ON R.cod_reserva = AR.cod_reserva
            AND R.exercicio = AR.exercicio
            INNER JOIN empenho.pre_empenho AS PE ON EE.cod_pre_empenho = PE.cod_pre_empenho
                AND EE.exercicio = PE.exercicio
            INNER JOIN sw_cgm AS C ON C.numcgm = PE.cgm_beneficiario
            LEFT OUTER JOIN empenho.restos_pre_empenho AS RE ON PE.exercicio = RE.exercicio
            AND PE.cod_pre_empenho = RE.cod_pre_empenho
            LEFT OUTER JOIN (
                SELECT
                    PED.exercicio,
                    PED.cod_pre_empenho,
                    D.cod_despesa,
                    D.num_pao,
                    D.num_orgao,
                    D.num_unidade,
                    D.cod_recurso,
                    rec.cod_fonte,
                    CD.cod_conta,
                    CD.cod_estrutural
                FROM
                    empenho.pre_empenho_despesa AS PED
                INNER JOIN orcamento.despesa AS D ON PED.cod_despesa = D.cod_despesa
                    AND PED.exercicio = D.exercicio
                INNER JOIN orcamento.recurso AS rec ON rec.cod_recurso = d.cod_recurso
                    AND rec.exercicio = d.exercicio
                INNER JOIN orcamento.conta_despesa AS CD ON CD.cod_conta = PED.cod_conta
                    AND CD.exercicio = D.exercicio ) AS PED_D_CD ON PE.exercicio = PED_D_CD.exercicio
            AND PE.cod_pre_empenho = PED_D_CD.cod_pre_empenho
            LEFT JOIN empenho.item_pre_empenho ON item_pre_empenho.cod_pre_empenho = pe.cod_pre_empenho
            AND item_pre_empenho.exercicio = pe.exercicio
            LEFT JOIN empenho.item_pre_empenho_julgamento ON item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
            AND item_pre_empenho_julgamento.exercicio = item_pre_empenho.exercicio
            AND item_pre_empenho_julgamento.num_item = item_pre_empenho.num_item
            LEFT JOIN compras.julgamento_item ON julgamento_item.exercicio = item_pre_empenho_julgamento.exercicio_julgamento
            AND julgamento_item.cod_cotacao = item_pre_empenho_julgamento.cod_cotacao
            AND julgamento_item.cod_item = item_pre_empenho_julgamento.cod_item
            AND julgamento_item.lote = item_pre_empenho_julgamento.lote
            AND julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
            LEFT JOIN compras.cotacao_item ON cotacao_item.exercicio = julgamento_item.exercicio
            AND cotacao_item.cod_cotacao = julgamento_item.cod_cotacao
            AND cotacao_item.lote = julgamento_item.lote
            AND cotacao_item.cod_item = julgamento_item.cod_item
            LEFT JOIN compras.cotacao ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
            AND cotacao.exercicio = cotacao_item.exercicio
            LEFT JOIN compras.mapa_cotacao ON mapa_cotacao.cod_cotacao = cotacao.cod_cotacao
            AND mapa_cotacao.exercicio_cotacao = cotacao.exercicio
            LEFT JOIN compras.mapa ON mapa.cod_mapa = mapa_cotacao.cod_mapa
            AND mapa.exercicio = mapa_cotacao.exercicio_mapa
            LEFT JOIN compras.compra_direta ON compra_direta.cod_mapa = mapa.cod_mapa
            AND compra_direta.exercicio_mapa = mapa.exercicio
            LEFT JOIN licitacao.adjudicacao ON adjudicacao.exercicio_cotacao = cotacao_item.exercicio
            AND adjudicacao.cod_cotacao = cotacao_item.cod_cotacao
            AND adjudicacao.lote = cotacao_item.lote
            AND adjudicacao.cod_item = cotacao_item.cod_item ) AS tabela
        WHERE
            tabela.exercicio = :exercicio
            AND (
                tabela.vl_pago - tabela.vl_pago_anulado )
            >= (
                tabela.vl_empenhado - tabela.vl_empenhado_anulado )
        ";

        if ($filter['codEntidade']['value'] !== "") {
            $sql .= " AND tabela.cod_entidade = :cod_entidade";
        }

        if (isset($filter['numOrgao']) && $filter['numOrgao']['value'] !== "") {
            $sql .= " AND tabela.num_orgao = :num_orgao";
        }

        if (isset($filter['numUnidade']) && $filter['numUnidade']['value'] !== "") {
            $sql .= " AND tabela.num_unidade = :num_unidade";
        }

        if ($filter['codDespesa']['value'] !== "") {
            $sql .= " AND tabela.cod_estrutural LIKE publico.fn_mascarareduzida (
                :cod_estrutural )
            || '.%'";
        }

        if (isset($filter['elementoDespesa']) && $filter['elementoDespesa']['value'] !== "") {
            $sql .= " AND tabela.cod_despesa = :cod_despesa";
        }

        if ($filter['codEmpenhoInicial']['value'] !== "" && $filter['codEmpenhoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_empenho BETWEEN :codEmpenhoInicial AND :codEmpenhoFinal";
        }

        if (isset($filter['codAutorizacao']) && $filter['codAutorizacao']['value'] !== "") {
            $sql .= " AND tabela.cod_autorizacao = :cod_autorizacao";
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $sql .= " AND tabela.dt_empenho BETWEEN :periodoInicial AND :periodoFinal";
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $sql .= " AND tabela.compra_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_compra_direta BETWEEN :codCompraDiretaInicial AND :codCompraDiretaFinal";
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $sql .= " AND tabela.licitacao_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_licitacao BETWEEN :codLicitacaoInicial AND :codLicitacaoFinal";
        }

        $atributos = (new \Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel($this->_em))
            ->getAtributosDinamicos();

        foreach ($atributos as $atributo) {
            $fieldName = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;

            if (isset($filter[$fieldName]) && $filter[$fieldName]['value'] != "") {
                $sql .= "
                AND EXISTS (
                    SELECT
                        1
                    FROM
                        empenho.atributo_empenho_valor
                    WHERE
                        atributo_empenho_valor.exercicio = tabela.exercicio
                        AND atributo_empenho_valor.cod_pre_empenho = tabela.cod_pre_empenho
                        AND atributo_empenho_valor.cod_modulo = 10
                        AND atributo_empenho_valor.cod_cadastro = {$atributo->cod_cadastro}
                        AND atributo_empenho_valor.cod_atributo = {$atributo->cod_atributo}
                        AND atributo_empenho_valor.valor = '{$filter[$fieldName]['value']}' )
                ";
            }
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);

        if ($filter['codEntidade']['value'] !== "") {
            $query->bindValue(':cod_entidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['numOrgao']) && $filter['numOrgao']['value'] !== "") {
            $query->bindValue(':num_orgao', $filter['numOrgao']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['numUnidade']) && $filter['numUnidade']['value'] !== "") {
            $query->bindValue(':num_unidade', $filter['numUnidade']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['codDespesa']) && $filter['codDespesa']['value'] !== "") {
            $query->bindValue(':cod_estrutural', $filter['codDespesa']['value'], \PDO::PARAM_STR);
        }

        if (isset($filter['elementoDespesa']) && $filter['elementoDespesa']['value'] !== "") {
            $query->bindValue(':cod_despesa', $filter['elementoDespesa']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codEmpenhoInicial']['value'] !== "" && $filter['codEmpenhoFinal']['value'] !== "") {
            $query->bindValue(':codEmpenhoInicial', $filter['codEmpenhoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codEmpenhoFinal', $filter['codEmpenhoFinal']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['codAutorizacao']) && $filter['codAutorizacao']['value'] !== "") {
            $query->bindValue(':cod_autorizacao', $filter['codAutorizacao']['value'], \PDO::PARAM_INT);
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
            $query->bindValue(':periodoInicial', $periodoInicial);
            $query->bindValue(':periodoFinal', $periodoFinal);
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeCompra']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $query->bindValue(':codCompraDiretaInicial', $filter['codCompraDiretaInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codCompraDiretaFinal', $filter['codCompraDiretaFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeLicitacao']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $query->bindValue(':codLicitacaoInicial', $filter['codLicitacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codLicitacaoFinal', $filter['codLicitacaoFinal']['value'], \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function filterEmpenhoLiquidacao($filter)
    {
        $sql = "SELECT                                                                        
	                    tabela.*                                                                
	                FROM (                                                                        
	                        SELECT                                                                   
	                                AE.cod_autorizacao,                                              
	                                EE.cod_empenho,                                                  
	                                EE.vl_saldo_anterior,                                            
	                                TO_CHAR(EE.dt_vencimento,'dd/mm/yyyy') AS dt_vencimento,         
	                                TO_CHAR(EE.dt_empenho,'dd/mm/yyyy') AS dt_empenho,               
	                                PD.cod_despesa,                                                  
	                                PE.descricao,                                                    
	                                EE.exercicio as exercicio_empenho,                               
	                                PE.exercicio,                                                    
	                                PE.cod_pre_empenho,                                              
	                                PE.cgm_beneficiario as credor,                                   
	                                EE.cod_entidade,                                                 
	                                AR.cod_reserva,                                                  
	                                PD.cod_conta,                                                    
	                                C.nom_cgm AS nom_fornecedor,                                     
	                                R.vl_reserva,                                                    
	                                OD.num_orgao,                                                    
	                                OD.num_unidade,                                                  
	                                OCD.cod_estrutural,                                              
	                                OD.cod_recurso,                                                  
	                                PE.cod_historico,                                                
	                                empenho.fn_consultar_valor_empenhado(                          
	                                                                     PE.exercicio               
	                                                                    ,EE.cod_empenho             
	                                                                    ,EE.cod_entidade            
	                                ) AS vl_empenhado,                                               
	                                empenho.fn_consultar_valor_empenhado_anulado(                  
	                                                                             PE.exercicio       
	                                                                            ,EE.cod_empenho     
	                                                                            ,EE.cod_entidade    
	                                ) AS vl_empenhado_anulado,                                       
	                                empenho.fn_consultar_valor_liquidado(                          
	                                                       PE.exercicio               
	                                                      ,EE.cod_empenho             
	                                                      ,EE.cod_entidade            
	                                ) AS vl_liquidado,                                               
	                                empenho.fn_consultar_valor_liquidado_anulado(                  
	                                                                             PE.exercicio       
	                                                                            ,EE.cod_empenho     
	                                                                            ,EE.cod_entidade    
	                                ) AS vl_liquidado_anulado,                                       
	                                empenho.fn_consultar_valor_empenhado_pago(                     
	                                                                         PE.exercicio       
	                                                                        ,EE.cod_empenho     
	                                                                        ,EE.cod_entidade    
	                                ) AS vl_pago,                                                    
	                                empenho.fn_consultar_valor_empenhado_pago_anulado(             
	                                                                                PE.exercicio       
	                                                                               ,EE.cod_empenho     
	                                                                               ,EE.cod_entidade    
	                                ) AS vl_pago_anulado                                             
	                        FROM                                                                     
	                                empenho.empenho             AS EE                            
	                        LEFT JOIN empenho.empenho_autorizacao AS EA 
	                             ON EA.exercicio       = EE.exercicio                             
	                            AND EA.cod_entidade    = EE.cod_entidade                          
	                            AND EA.cod_empenho     = EE.cod_empenho 
	                        LEFT JOIN empenho.autorizacao_empenho AS AE 
	                             ON AE.exercicio       = EA.exercicio                             
	                            AND AE.cod_autorizacao = EA.cod_autorizacao                       
	                            AND AE.cod_entidade    = EA.cod_entidade  
	                        LEFT JOIN empenho.autorizacao_reserva AS AR 
	                             ON AR.exercicio       = AE.exercicio                             
	                            AND AR.cod_entidade    = AE.cod_entidade                          
	                            AND AR.cod_autorizacao = AE.cod_autorizacao 
	                        LEFT JOIN orcamento.reserva AS  R 
	                             ON R.cod_reserva = AR.cod_reserva                           
	                            AND R.exercicio   = AR.exercicio 
	                        JOIN empenho.pre_empenho AS PE                           
	                             ON EE.cod_pre_empenho = PE.cod_pre_empenho                       
	                            AND EE.exercicio       = PE.exercicio                             
	                        JOIN sw_cgm AS  C
	                            ON C.numcgm = PE.cgm_beneficiario                           
	                        JOIN empenho.pre_empenho_despesa AS PD
	                             ON PD.cod_pre_empenho = PE.cod_pre_empenho                       
	                            AND PD.exercicio       = PE.exercicio                                                       
	                        JOIN orcamento.despesa AS OD  
	                             ON OD.exercicio       = PD.exercicio                             
	                            AND OD.cod_despesa     = PD.cod_despesa                                                     
	                        LEFT OUTER JOIN orcamento.conta_despesa AS OCD 
	                             ON OD.cod_conta = OCD.cod_conta 
	                            AND OD.exercicio = OCD.exercicio                              
	                        
	                        WHERE                                                                    
	                            CAST(OD.num_unidade as varchar)||CAST(OD.num_orgao as varchar) IN (                              
	                                                                                                SELECT                                            
	                                                                                                      CAST(num_unidade as varchar)||CAST(num_orgao as varchar)                       
	                                                                                                FROM                                              
	                                                                                                    empenho.permissao_autorizacao             
	                                                                                                WHERE numcgm    = 1302    
	                                                                                                AND   exercicio = '2017'
	                            )                            
	    ) AS tabela 
	     WHERE  ( tabela.vl_empenhado -  tabela.vl_empenhado_anulado ) > ( tabela.vl_liquidado - tabela.vl_liquidado_anulado ) 
      ";

        if ($filter['codEntidade']['value'] !== "") {
            $sql .= " AND tabela.cod_entidade = :codEntidade";
        }

        if ($filter['exercicio']['value'] !== "") {
            $sql .= " AND tabela.exercicio = :exercicio";
        }

        if (!empty($filter['codEmpenhoInicial']['value']) && empty($filter['codEmpenhoFinal']['value'])) {
            $sql .= " AND tabela.cod_empenho >= :codEmpenhoInicial";
        }

        if (empty($filter['codEmpenhoInicial']['value']) && !empty($filter['codEmpenhoFinal']['value'])) {
            $sql .= " AND tabela.cod_empenho <= :codEmpenhoFinal";
        }

        if (!empty($filter['codEmpenhoInicial']['value']) && !empty($filter['codEmpenhoFinal']['value'])) {
            $sql .= " AND tabela.cod_empenho BETWEEN :codEmpenhoInicial AND :codEmpenhoFinal";
        }

        if (!empty($filter['periodoInicial']['value']) && empty($filter['periodoFinal']['value'])) {
            $sql .= " AND to_char(tabela.dt_empenho,'YYYY-MM-DD') >= :periodoInicial";
        }

        if (empty($filter['periodoInicial']['value']) && !empty($filter['periodoFinal']['value'])) {
            $sql .= " AND to_char(tabela.dt_empenho,'YYYY-MM-DD') <= :periodoFinal";
        }

        if (!empty($filter['periodoInicial']['value']) && !empty($filter['periodoFinal']['value'])) {
            $sql .= " AND to_char(tabela.dt_empenho,'YYYY-MM-DD') BETWEEN :periodoInicial AND :periodoFinal";
        }

        if (!empty($filter['numeroLiquidacaoInicial']['value']) && empty($filter['numeroLiquidacaoFinal']['value'])) {
            $sql .= " AND tabela.cod_nota >= :numeroLiquidacaoInicial";
        }

        if (empty($filter['numeroLiquidacaoInicial']['value']) && !empty($filter['numeroLiquidacaoFinal']['value'])) {
            $sql .= " AND tabela.cod_nota <= :numeroLiquidacaoFinal";
        }

        if (!empty($filter['numeroLiquidacaoInicial']['value']) && !empty($filter['numeroLiquidacaoFinal']['value'])) {
            $sql .= " AND tabela.cod_nota BETWEEN :numeroLiquidacaoInicial AND :numeroLiquidacaoFinal";
        }

        if ($filter['vencimento']['value'] !== "") {
            $sql .= " AND to_char(tabela.dt_vencimento,'YYYY-MM-DD') = :vencimento";
        }

        if ($filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'] !== "") {
            $sql .= " and tabela.num_fornecedor = :credor";
        }


        $orderBy = "
             ORDER BY tabela.cod_entidade, tabela.cod_empenho, tabela.nom_fornecedor";

        $sql .= $orderBy;
        $query = $this->_em->getConnection()->prepare($sql);

        if ($filter['codEntidade']['value'] !== "") {
            $query->bindValue(':codEntidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        }

        if ($filter['exercicio']['value'] !== "") {
            $query->bindValue(':exercicio', $filter['exercicio']['value']);
        }

        if (!empty($filter['codEmpenhoInicial']['value']) && empty($filter['codEmpenhoFinal']['value'])) {
            $query->bindValue(':codEmpenhoInicial', $filter['codEmpenhoInicial']['value'], \PDO::PARAM_INT);
        }

        if (empty($filter['codEmpenhoInicial']['value']) && !empty($filter['codEmpenhoFinal']['value'])) {
            $query->bindValue(':codEmpenhoFinal', $filter['codEmpenhoFinal']['value'], \PDO::PARAM_INT);
        }

        if (!empty($filter['codEmpenhoInicial']['value']) && !empty($filter['codEmpenhoFinal']['value'])) {
            $query->bindValue(':codEmpenhoInicial', $filter['codEmpenhoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codEmpenhoFinal', $filter['codEmpenhoFinal']['value'], \PDO::PARAM_INT);
        }

        if (!empty($filter['periodoInicial']['value']) && !empty($filter['periodoFinal']['value'])) {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");

            $query->bindValue(':periodoInicial', $periodoInicial, \PDO::PARAM_STR);
            $query->bindValue(':periodoFinal', $periodoFinal, \PDO::PARAM_STR);
        }

        if (!empty($filter['periodoInicial']['value']) && empty($filter['periodoFinal']['value'])) {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $query->bindValue(':periodoInicial', $periodoInicial);
        }

        if (empty($filter['periodoInicial']['value']) && !empty($filter['periodoFinal']['value'])) {
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
            $query->bindValue(':periodoFinal', $periodoFinal);
        }

        if (!empty($filter['numeroLiquidacaoInicial']['value']) && empty($filter['numeroLiquidacaoFinal']['value'])) {
            $query->bindValue(':numeroLiquidacaoInicial', $filter['numeroLiquidacaoInicial']['value'], \PDO::PARAM_INT);
        }

        if (empty($filter['numeroLiquidacaoInicial']['value']) && !empty($filter['numeroLiquidacaoFinal']['value'])) {
            $query->bindValue(':numeroLiquidacaoFinal', $filter['numeroLiquidacaoFinal']['value'], \PDO::PARAM_INT);
        }

        if (!empty($filter['numeroLiquidacaoInicial']['value']) && !empty($filter['numeroLiquidacaoFinal']['value'])) {
            $query->bindValue(':numeroLiquidacaoInicial', $filter['numeroLiquidacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':numeroLiquidacaoFinal', $filter['numeroLiquidacaoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['vencimento']['value'] !== "") {
            $vencimento = \DateTime::createFromFormat("d/m/Y", $filter['vencimento']['value'])->format("Y-m-d");
            $query->bindValue(':vencimento', $vencimento);
        }

        if ($filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'] !== "") {
            $query->bindValue(':credor', $filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'], \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $numCgm
     * @param $exercicio
     * @param $codEntidade
     * @param $numOrgao
     * @param $numUnidade
     * @param $dtVencimento
     * @param $credor
     * @param $codRecurso
     * @param $codPreEmpenho
     * @param $codEmpenho
     * @return mixed
     */
    public function getSaldosEmpenho($numCgm, $exercicio, $codEntidade, $numOrgao, $numUnidade, $dtVencimento, $credor, $codRecurso, $codPreEmpenho, $codEmpenho)
    {
        $sql = "
        SELECT
            tabela.*
        FROM (
                SELECT
                    AE.cod_autorizacao,
                    EE.cod_empenho,empenho.autorizacao_reserva AS AR ON
                    EE.vl_saldo_anterior,
                    to_char (
                        EE.dt_vencimento,
                        'dd/mm/yyyy' ) AS dt_vencimento,
                    to_char (
                        EE.dt_empenho,
                        'dd/mm/yyyy' ) AS dt_empenho,
                    PD.cod_despesa,
                    PE.descricao,
                    EE.exercicio AS exercicio_empenho,
                    PE.exercicio,
                    PE.cod_pre_empenho,
                    PE.cgm_beneficiario AS credor,
                    EE.cod_entidade,
                    AR.cod_reserva,
                    PD.cod_conta,
                    C.nom_cgm AS nom_fornecedor,
                    R.vl_reserva,
                    OD.num_orgao,
                    OD.num_unidade,
                    OCD.cod_estrutural,
                    OD.cod_recurso,
                    PE.cod_historico,
                    empenho.fn_consultar_valor_empenhado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado,
                    empenho.fn_consultar_valor_empenhado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_empenhado_anulado,
                    empenho.fn_consultar_valor_liquidado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado,
                    empenho.fn_consultar_valor_liquidado_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_liquidado_anulado,
                    empenho.fn_consultar_valor_empenhado_pago (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago,
                    empenho.fn_consultar_valor_empenhado_pago_anulado (
                        PE.exercicio,
                        EE.cod_empenho,
                        EE.cod_entidade ) AS vl_pago_anulado
                FROM
                    empenho.empenho AS EE
                LEFT JOIN empenho.empenho_autorizacao AS EA ON EA.exercicio = EE.exercicio
                AND EA.cod_entidade = EE.cod_entidade
                AND EA.cod_empenho = EE.cod_empenho
            LEFT JOIN empenho.autorizacao_empenho AS AE ON AE.exercicio = EA.exercicio
            AND AE.cod_autorizacao = EA.cod_autorizacao
            AND AE.cod_entidade = EA.cod_entidade
            LEFT JOIN empenho.autorizacao_reserva AS AR ON AR.exercicio = AE.exercicio
            AND AR.cod_entidade = AE.cod_entidade
            AND AR.cod_autorizacao = AE.cod_autorizacao
            LEFT JOIN orcamento.reserva AS R ON R.cod_reserva = AR.cod_reserva
            AND R.exercicio = AR.exercicio
            JOIN empenho.pre_empenho AS PE ON EE.cod_pre_empenho = PE.cod_pre_empenho
            AND EE.exercicio = PE.exercicio
            JOIN sw_cgm AS C ON C.numcgm = PE.cgm_beneficiario
            JOIN empenho.pre_empenho_despesa AS PD ON PD.cod_pre_empenho = PE.cod_pre_empenho
            AND PD.exercicio = PE.exercicio
            JOIN orcamento.despesa AS OD ON OD.exercicio = PD.exercicio
            AND OD.cod_despesa = PD.cod_despesa
            LEFT OUTER JOIN orcamento.conta_despesa AS OCD ON OD.cod_conta = OCD.cod_conta
            AND OD.exercicio = OCD.exercicio
        WHERE
            CAST (
                OD.num_unidade AS varchar )
            || CAST (
                OD.num_orgao AS varchar )
            IN (
                SELECT
                    CAST (
                        num_unidade AS varchar )
                    || CAST (
                        num_orgao AS varchar )
                FROM
                    empenho.permissao_autorizacao
                WHERE
                    numcgm = :numcgm
                    AND exercicio = :exercicio ) ) AS tabela
        WHERE
            tabela.exercicio = :exercicio
            AND tabela.cod_entidade = :cod_entidade
            AND tabela.num_orgao = :num_orgao
            AND tabela.num_unidade = :num_unidade
            AND to_date (
                tabela.dt_vencimento,
                'dd/mm/yyyy' )
            = to_date (
                :dt_vencimento,
                'dd/mm/yyyy' )
            AND tabela.credor = :credor
            AND tabela.cod_recurso = :cod_recurso
            AND tabela.cod_pre_empenho = :cod_pre_empenho
            AND tabela.cod_empenho = :cod_empenho
        ORDER BY
            tabela.cod_entidade,
            tabela.cod_empenho,
            tabela.nom_fornecedor
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('numcgm', $numCgm, \PDO::PARAM_INT);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('cod_entidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue('num_orgao', $numOrgao, \PDO::PARAM_INT);
        $query->bindValue('num_unidade', $numUnidade, \PDO::PARAM_INT);
        $query->bindValue('dt_vencimento', $dtVencimento, \PDO::PARAM_STR);
        $query->bindValue('credor', $credor, \PDO::PARAM_INT);
        $query->bindValue('cod_recurso', $codRecurso, \PDO::PARAM_INT);
        $query->bindValue('cod_pre_empenho', $codPreEmpenho, \PDO::PARAM_INT);
        $query->bindValue('cod_empenho', $codEmpenho, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $paramsWhere
     * @param $limit
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function carregaEmpenhoEmpenho($paramsWhere, $limit = '')
    {
        $sql = sprintf(
            "SELECT * FROM empenho.empenho 
            WHERE %s
            %s",
            implode(" AND ", $paramsWhere),
            ($limit ? $limit : '')
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $params
     * @return array
     */
    public function getFnSaldoDotacaoDataAtualEmpenho($params)
    {
        $sql = sprintf(
            "SELECT empenho.fn_saldo_dotacao_data_atual_empenho(
                '%s',
                %d,
                '%s',
                '%s',
                %d,
                '%s'
            ) AS saldo_anterior",
            $params['exercicio'],
            $params['codDespesa'],
            $params['dtAtual'],
            $params['dtEmpenho'],
            $params['codEntidade'],
            $params['tipoEmissao']
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return array_shift($result);
    }


    /**
     * @param $exercicio
     * @param $codEntidade
     * @return mixed
     */
    public function recuperaUltimaDataEmpenho($exercicio, $codEntidade)
    {
        $sql = "
             SELECT empenho.dt_empenho
              FROM empenho.empenho
              LEFT JOIN ( SELECT coalesce(sum(vl_total),0.00) - coalesce(sum(vl_anulado),0.00) as valor
              ,ea.cod_empenho                                                              
              ,ea.cod_entidade                                                             
              ,ea.exercicio                                                                
              FROM empenho.empenho_anulado as ea                                                
              JOIN ( SELECT sum(vl_anulado) as vl_anulado                                  
              ,ipe.vl_total                                                   
              ,eai.cod_empenho                                                
              ,eai.cod_entidade                                               
              ,eai.exercicio                                                  
              FROM empenho.empenho_anulado_item eai                               
              JOIN empenho.item_pre_empenho as ipe                           
              ON (   ipe.exercicio       = eai.exercicio                     
              AND ipe.cod_pre_empenho = eai.cod_pre_empenho               
              AND ipe.num_item        = eai.num_item                      
              )                                                              
              GROUP BY ipe.vl_total, eai.cod_empenho, eai.cod_entidade, eai.exercicio 
              ) as itens ON ( itens.cod_empenho  = ea.cod_empenho                         
              AND itens.exercicio    = ea.exercicio                           
              AND itens.cod_entidade = ea.cod_entidade                        
              )                                                                           
              WHERE ea.exercicio = :exercicio                                       
              GROUP BY ea.cod_empenho, ea.cod_entidade, ea.exercicio                                 
              ) as it ON ( it.cod_empenho = empenho.cod_empenho                                            
              AND it.exercicio   = empenho.exercicio                                              
              AND it.cod_entidade = empenho.cod_entidade                                          
              )                                                                                      
              WHERE empenho.cod_empenho is not null AND (it.valor != 0.00 or it.valor is null)      
              AND empenho.cod_entidade = :cod_entidade
              AND empenho.exercicio = :exercicio
              ORDER BY empenho.dt_empenho DESC LIMIT 1
              ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('cod_entidade', $codEntidade, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filter
     * @param $exercicio
     * @param $numgcm
     * @return array
     */
    public function findListaAnularEmpenho($filter, $exercicio, $numgcm)
    {
        $sql = 'SELECT DISTINCT tabela.*                                                                
	                FROM (                                                                        
	                     SELECT  AE.cod_autorizacao,                                              
	                             EE.cod_empenho,                                                  
	                             EE.vl_saldo_anterior,                                            
	                             TO_CHAR(EE.dt_vencimento,\'dd/mm/yyyy\') AS dt_vencimento,         
	                             TO_CHAR(EE.dt_empenho,\'dd/mm/yyyy\') AS dt_empenho,               
	                             PD.cod_despesa,                                                  
	                             PE.descricao,                                                    
	                             EE.exercicio as exercicio_empenho,                               
	                             PE.exercicio,                                                    
	                             PE.cod_pre_empenho,                                              
	                             PE.cgm_beneficiario as credor,                                   
	                             EE.cod_entidade,                                                 
	                             AR.cod_reserva,                                                  
	                             PD.cod_conta,                                                    
	                             C.nom_cgm AS nom_fornecedor,                                     
	                             R.vl_reserva,                                                    
	                             OD.num_orgao,                                                    
	                             OD.num_unidade,                                                  
	                             OCD.cod_estrutural,                                              
	                             OD.cod_recurso,                                                  
	                             PE.cod_historico,                                                
	                             empenho.fn_consultar_valor_empenhado(  PE.exercicio               
	                                                                   ,EE.cod_empenho             
	                                                                   ,EE.cod_entidade            
	                             ) AS vl_empenhado,                                               
	                             empenho.fn_consultar_valor_empenhado_anulado(  PE.exercicio       
	                                                                            ,EE.cod_empenho     
	                                                                            ,EE.cod_entidade    
	                             ) AS vl_empenhado_anulado,                                       
	                             empenho.fn_consultar_valor_liquidado(  PE.exercicio               
	                                                                    ,EE.cod_empenho             
	                                                                    ,EE.cod_entidade            
	                                ) AS vl_liquidado,                                               
	                             empenho.fn_consultar_valor_liquidado_anulado(  PE.exercicio       
	                                                                            ,EE.cod_empenho     
	                                                                            ,EE.cod_entidade    
	                                ) AS vl_liquidado_anulado,                                       
	                             empenho.fn_consultar_valor_empenhado_pago( PE.exercicio       
	                                                                        ,EE.cod_empenho     
	                                                                        ,EE.cod_entidade    
	                                ) AS vl_pago,                                                    
	                             empenho.fn_consultar_valor_empenhado_pago_anulado( PE.exercicio       
	                                                                                ,EE.cod_empenho     
	                                                                                ,EE.cod_entidade    
	                             ) AS vl_pago_anulado,
	                             compra_direta.cod_modalidade AS compra_cod_modalidade,
	                             compra_direta.cod_compra_direta,
	                             adjudicacao.cod_modalidade AS licitacao_cod_modalidade,
	                             adjudicacao.cod_licitacao
	                
	                                                                          
	                        FROM empenho.empenho AS EE                            
	                
	                    LEFT JOIN empenho.empenho_autorizacao AS EA
	                           ON EA.exercicio       = EE.exercicio                             
	                          AND EA.cod_entidade    = EE.cod_entidade                          
	                          AND EA.cod_empenho     = EE.cod_empenho
	                          
	                    LEFT JOIN empenho.autorizacao_empenho AS AE
	                           ON  AE.exercicio       = EA.exercicio                             
	                          AND  AE.cod_autorizacao = EA.cod_autorizacao                       
	                          AND  AE.cod_entidade    = EA.cod_entidade                        
	                    
	                    LEFT JOIN empenho.autorizacao_reserva AS AR
	                           ON AR.exercicio       = AE.exercicio                             
	                          AND AR.cod_entidade    = AE.cod_entidade                          
	                          AND AR.cod_autorizacao = AE.cod_autorizacao
	                    
	                    LEFT JOIN orcamento.reserva AS  R
	                           ON R.cod_reserva     = AR.cod_reserva                           
	                          AND R.exercicio       = AR.exercicio
	                           
	                    INNER JOIN empenho.pre_empenho  AS PE
	                            ON EE.cod_pre_empenho = PE.cod_pre_empenho                       
	                           AND EE.exercicio       = PE.exercicio                                
	                      
	                    INNER JOIN sw_cgm AS  C
	                            ON C.numcgm  = PE.cgm_beneficiario
	                    
	                    INNER JOIN empenho.pre_empenho_despesa AS PD    
	                            ON PD.cod_pre_empenho = PE.cod_pre_empenho                       
	                           AND PD.exercicio       = PE.exercicio                             
	                     
	                    INNER JOIN orcamento.despesa AS OD
	                            ON OD.exercicio       = PD.exercicio                             
	                           AND OD.cod_despesa     = PD.cod_despesa
	                    
	                    LEFT OUTER JOIN orcamento.conta_despesa AS OCD
	                                 ON OD.cod_conta = OCD.cod_conta
	                                AND OD.exercicio = OCD.exercicio
	                    
	                    LEFT JOIN empenho.item_pre_empenho
	                           ON item_pre_empenho.cod_pre_empenho = pe.cod_pre_empenho
	                          AND item_pre_empenho.exercicio       = pe.exercicio
	                          
	                    LEFT JOIN empenho.item_pre_empenho_julgamento
	                           ON item_pre_empenho_julgamento.cod_pre_empenho  = item_pre_empenho.cod_pre_empenho   
	                          AND item_pre_empenho_julgamento.exercicio        = item_pre_empenho.exercicio
	                          AND item_pre_empenho_julgamento.num_item         = item_pre_empenho.num_item
	                    
	                    LEFT JOIN compras.julgamento_item
	                           ON julgamento_item.exercicio      = item_pre_empenho_julgamento.exercicio_julgamento
	                          AND julgamento_item.cod_cotacao    = item_pre_empenho_julgamento.cod_cotacao 
	                          AND julgamento_item.cod_item       = item_pre_empenho_julgamento.cod_item
	                          AND julgamento_item.lote           = item_pre_empenho_julgamento.lote
	                          AND julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
	                    
	                    LEFT JOIN compras.cotacao_item
	                           ON cotacao_item.exercicio   = julgamento_item.exercicio
	                          AND cotacao_item.cod_cotacao = julgamento_item.cod_cotacao
	                          AND cotacao_item.lote        = julgamento_item.lote
	                          AND cotacao_item.cod_item    = julgamento_item.cod_item
	                    
	                    LEFT JOIN compras.cotacao
	                           ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
	                          AND cotacao.exercicio   = cotacao_item.exercicio
	                    
	                    LEFT JOIN compras.mapa_cotacao
	                           ON mapa_cotacao.cod_cotacao       = cotacao.cod_cotacao
	                          AND mapa_cotacao.exercicio_cotacao = cotacao.exercicio
	                    
	                    LEFT JOIN compras.mapa
	                           ON mapa.cod_mapa  = mapa_cotacao.cod_mapa
	                          AND mapa.exercicio = mapa_cotacao.exercicio_mapa
	                    
	                    LEFT JOIN compras.compra_direta
	                           ON compra_direta.cod_mapa       = mapa.cod_mapa
	                          AND compra_direta.exercicio_mapa = mapa.exercicio
	                    
	                    LEFT JOIN licitacao.adjudicacao
	                           ON adjudicacao.exercicio_cotacao = cotacao_item.exercicio 
	                          AND adjudicacao.cod_cotacao       = cotacao_item.cod_cotacao
	                          AND adjudicacao.lote              = cotacao_item.lote
	                          AND adjudicacao.cod_item          = cotacao_item.cod_item 
	                       
	                       WHERE CAST(OD.num_unidade as varchar)||CAST(OD.num_orgao as varchar)
	                          IN ( SELECT CAST(num_unidade as varchar)||CAST(num_orgao as varchar)                       
	                                FROM empenho.permissao_autorizacao             
	                                WHERE numcgm  = :numgcm    
	                                AND exercicio = :exercicio
	                             )                            
	            ) AS tabela                                                                       
	     WHERE  
	          tabela.exercicio = :exercicio ';


        if ($filter['codEntidade']['value'] !== "") {
            $sql .= " AND tabela.cod_entidade = :cod_entidade ";
        }

        if ($filter['codEmpenhoInicial']['value'] !== "" && $filter['codEmpenhoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_empenho BETWEEN :codEmpenhoInicial AND :codEmpenhoFinal ";
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_autorizacao BETWEEN :codAutorizacaoInicial AND :codAutorizacaoFinal ";
        }

        if ($filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'] !== "") {
            $sql .= " AND tabela.credor = :credor ";
        }

        if ($filter['codDespesa']['value'] !== "") {
            $sql .= " AND tabela.cod_despesa = :codDespesa ";
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $sql .= " AND TO_DATE(dt_empenho, 'dd/mm/yyyy') BETWEEN TO_DATE(:periodoInicial,'dd/mm/yyyy') AND TO_DATE(:periodoFinal,'dd/mm/yyyy') ";
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $sql .= " AND tabela.compra_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_compra_direta BETWEEN :codCompraDiretaInicial AND :codCompraDiretaFinal";
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $sql .= " AND tabela.licitacao_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_licitacao BETWEEN :codLicitacaoInicial AND :codLicitacaoFinal";
        }

        $sql .= " AND ( tabela.vl_empenhado -  tabela.vl_empenhado_anulado ) > ( tabela.vl_liquidado - tabela.vl_liquidado_anulado ) ";
        $sql .= " ORDER BY tabela.cod_entidade, tabela.cod_empenho, tabela.nom_fornecedor ";


        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':numgcm', $numgcm, \PDO::PARAM_STR);
        $query->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);

        if ($filter['codEntidade']['value'] !== "") {
            $query->bindValue(':cod_entidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codDespesa']['value'] !== "") {
            $query->bindValue(':codDespesa', $filter['codDespesa']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codEmpenhoInicial']['value'] !== "" && $filter['codEmpenhoFinal']['value'] !== "") {
            $query->bindValue(':codEmpenhoInicial', $filter['codEmpenhoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codEmpenhoFinal', $filter['codEmpenhoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $query->bindValue(':codAutorizacaoInicial', $filter['codAutorizacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codAutorizacaoFinal', $filter['codAutorizacaoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'] !== "") {
            $query->bindValue(':credor', $filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codDespesa']['value'] !== "") {
            $query->bindValue(':codDespesa', $filter['codDespesa']['value'], \PDO::PARAM_INT);
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $query->bindValue(':periodoInicial', $filter['periodoInicial']['value'], \PDO::PARAM_STR);
            $query->bindValue(':periodoFinal', $filter['periodoFinal']['value'], \PDO::PARAM_STR);
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeCompra']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $query->bindValue(':codCompraDiretaInicial', $filter['codCompraDiretaInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codCompraDiretaFinal', $filter['codCompraDiretaFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeLicitacao']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $query->bindValue(':codLicitacaoInicial', $filter['codLicitacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codLicitacaoFinal', $filter['codLicitacaoFinal']['value'], \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * @param $filter
     * @param $numcgm
     * @return array
     */
    public function filterListaReemitirAutorizacao($filter, $numcgm)
    {
        $sql = "
          SELECT distinct tabela.*,                                                          
	                           CD.cod_estrutural  AS cod_estrutural_conta                         
	             FROM (                                                                 
	                     SELECT  AE.cod_autorizacao,                                        
	                             TO_CHAR(AE.dt_autorizacao,'dd/mm/yyyy') AS dt_autorizacao, 
	                             PD.cod_despesa,                                            
	                             D.cod_conta,                                               
	                             CD.cod_estrutural AS cod_estrutural_rubrica,               
	                             PE.descricao,                                              
	                             PE.exercicio,                                              
	                             PE.cod_pre_empenho,                                        
	                             PE.cgm_beneficiario as credor,                             
	                             AE.cod_entidade,                                           
	                             AE.num_orgao,                                              
	                             AE.num_unidade,                                            
	                             EM.cod_empenho,  
	                             AR.cod_reserva,                                            
	                             C.nom_cgm as nom_fornecedor,                              
	                         CASE WHEN O.anulada IS NOT NULL                                
	                              THEN O.anulada                                                 
	                              ELSE 'f'                                                       
	                         END AS anulada
	                             ,compra_direta.cod_modalidade AS compra_cod_modalidade
	                             ,compra_direta.cod_compra_direta
	                             ,adjudicacao.cod_modalidade AS licitacao_cod_modalidade
	                             ,adjudicacao.cod_licitacao
	                             ,item_pre_empenho.cod_centro AS centro_custo
	             
	                     FROM empenho.autorizacao_empenho AS AE
	                     
	                LEFT JOIN empenho.autorizacao_reserva AS AR                      
	                       ON AR.exercicio       = AE.exercicio
	                      AND AR.cod_entidade    = AE.cod_entidade
	                      AND AR.cod_autorizacao = AE.cod_autorizacao               
	                          
	                LEFT JOIN empenho.autorizacao_anulada AS AA                        
	                       ON AA.cod_autorizacao = AE.cod_autorizacao
	                      AND AA.exercicio       = AE.exercicio
	                      AND AA.cod_entidade    = AE.cod_entidade
	                      
	                LEFT JOIN orcamento.reserva AS  O                      
	                       ON O.exercicio   = AR.exercicio
	                      AND O.cod_reserva = AR.cod_reserva                        
	                             
	               INNER JOIN empenho.pre_empenho AS PE
	                       ON AE.cod_pre_empenho = PE.cod_pre_empenho
	                      AND AE.exercicio       = PE.exercicio
	                      
                   INNER JOIN empenho.empenho AS EM
                           ON EM.cod_pre_empenho = PE.cod_pre_empenho
                          AND EM.exercicio       = PE.exercicio
                          
	               INNER JOIN sw_cgm AS  C
	                       ON C.numcgm = PE.cgm_beneficiario             
	             
	                LEFT JOIN empenho.pre_empenho_despesa AS PD                      
	                       ON PD.cod_pre_empenho = PE.cod_pre_empenho
	                      AND PD.exercicio       = PE.exercicio                     
	                
	                LEFT JOIN orcamento.conta_despesa     AS CD                      
	                       ON CD.exercicio = PD.exercicio
	                      AND CD.cod_conta = PD.cod_conta                           
	                          
	                LEFT JOIN orcamento.despesa AS D                         
	                       ON D.exercicio   = PD.exercicio
	                      AND D.cod_despesa = PD.cod_despesa
	             
	             LEFT JOIN empenho.item_pre_empenho
	                    ON item_pre_empenho.cod_pre_empenho = pe.cod_pre_empenho
	                   AND item_pre_empenho.exercicio       = pe.exercicio
	                   
	             LEFT JOIN empenho.item_pre_empenho_julgamento
	                    ON item_pre_empenho_julgamento.cod_pre_empenho  = item_pre_empenho.cod_pre_empenho   
	                   AND item_pre_empenho_julgamento.exercicio        = item_pre_empenho.exercicio
	                   AND item_pre_empenho_julgamento.num_item         = item_pre_empenho.num_item
	             
	             LEFT JOIN compras.julgamento_item
	                    ON julgamento_item.exercicio      = item_pre_empenho_julgamento.exercicio_julgamento
	                   AND julgamento_item.cod_cotacao    = item_pre_empenho_julgamento.cod_cotacao 
	                   AND julgamento_item.cod_item       = item_pre_empenho_julgamento.cod_item
	                   AND julgamento_item.lote           = item_pre_empenho_julgamento.lote
	                   AND julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
	             
	             LEFT JOIN compras.cotacao_item
	                    ON cotacao_item.exercicio   = julgamento_item.exercicio
	                   AND cotacao_item.cod_cotacao = julgamento_item.cod_cotacao
	                   AND cotacao_item.lote        = julgamento_item.lote
	                   AND cotacao_item.cod_item    = julgamento_item.cod_item
	             
	             LEFT JOIN compras.cotacao
	                    ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
	                   AND cotacao.exercicio   = cotacao_item.exercicio
	             
	             LEFT JOIN compras.mapa_cotacao
	                    ON mapa_cotacao.cod_cotacao       = cotacao.cod_cotacao
	                   AND mapa_cotacao.exercicio_cotacao = cotacao.exercicio
	             
	             LEFT JOIN compras.mapa
	                    ON mapa.cod_mapa  = mapa_cotacao.cod_mapa
	                   AND mapa.exercicio = mapa_cotacao.exercicio_mapa
	             
	             LEFT JOIN compras.compra_direta
	                    ON compra_direta.cod_mapa       = mapa.cod_mapa
	                   AND compra_direta.exercicio_mapa = mapa.exercicio
	             
	             LEFT JOIN licitacao.adjudicacao
	                    ON adjudicacao.exercicio_cotacao = cotacao_item.exercicio 
	                   AND adjudicacao.cod_cotacao       = cotacao_item.cod_cotacao
	                   AND adjudicacao.lote              = cotacao_item.lote
	                   AND adjudicacao.cod_item          = cotacao_item.cod_item 
	                 WHERE AA.cod_autorizacao IS NULL AND EM.cod_empenho IS NOT NULL
	                 ) AS tabela                                                            
	             
	        LEFT JOIN orcamento.conta_despesa AS CD                                  
	               ON CD.exercicio = tabela.exercicio
	              AND CD.cod_conta = tabela.cod_conta                                
	                
	        LEFT JOIN orcamento.despesa AS D                                         
	               ON D.cod_despesa = tabela.cod_despesa
	              AND D.exercicio   = tabela.exercicio                               
	                                                                                      
	            WHERE tabela.num_orgao::varchar||tabela.num_unidade::varchar                            
	               IN ( SELECT num_orgao::varchar||num_unidade::varchar                               
	                      FROM empenho.permissao_autorizacao                     
	                     WHERE numcgm    = :numcgm
	                       AND exercicio = :exercicio        
	                ) 
	      AND tabela.exercicio = :exercicio 
        ";

        if ($filter['codEntidade']['value'] !== "") {
            $sql .= " AND tabela.cod_entidade = :cod_entidade";
        }

        if ($filter['codDespesa']['value'] !== "") {
            $sql .= " AND tabela.cod_despesa = :cod_despesa";
        }

        if ($filter['centroCusto']['value'] !== "") {
            $sql .= " AND tabela.centro_custo = :centro_custo";
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_autorizacao BETWEEN :codAutorizacaoInicial AND :codAutorizacaoFinal";
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $sql .= " AND tabela.dt_empenho BETWEEN :periodoInicial AND :periodoFinal";
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $sql .= " AND tabela.compra_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_compra_direta BETWEEN :codCompraDiretaInicial AND :codCompraDiretaFinal";
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $sql .= " AND tabela.licitacao_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_licitacao BETWEEN :codLicitacaoInicial AND :codLicitacaoFinal";
        }

        $sql .= " ORDER BY tabela.cod_entidade,tabela.cod_autorizacao";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':exercicio', $filter['exercicio']['value'], \PDO::PARAM_STR);
        $query->bindValue(':numcgm', $numcgm, \PDO::PARAM_INT);

        if ($filter['codEntidade']['value'] !== "") {
            $query->bindValue(':cod_entidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codDespesa']['value'] !== "") {
            $query->bindValue(':cod_despesa', $filter['codDespesa']['value'], \PDO::PARAM_INT);
        }

        if ($filter['centroCusto']['value'] !== "") {
            $query->bindValue(':centro_custo', $filter['centroCusto']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $query->bindValue(':codAutorizacaoInicial', $filter['codAutorizacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codAutorizacaoFinal', $filter['codAutorizacaoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
            $query->bindValue(':periodoInicial', $periodoInicial);
            $query->bindValue(':periodoFinal', $periodoFinal);
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeCompra']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $query->bindValue(':codCompraDiretaInicial', $filter['codCompraDiretaInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codCompraDiretaFinal', $filter['codCompraDiretaFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeLicitacao']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $query->bindValue(':codLicitacaoInicial', $filter['codLicitacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codLicitacaoFinal', $filter['codLicitacaoFinal']['value'], \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filter
     * @param $exercicio
     * @return mixed
     */
    public function getRazaoEmpenho($filter)
    {

        $sql = "SELECT                                                                                                                                     
                   tabela.*,                                                                                                                            
                   (vl_empenhado - vl_empenhado_anulado - vl_pago) as saldo_atual                                                                       
             FROM (                                                                                                                                     
                  SELECT                                                                                                                                
                     EE.cod_entidade,                                                                                                                   
                     EE.exercicio,                                                                                                                      
                     cgm_entidade.nom_cgm as nom_entidade,                                                                                              
                     EE.cod_empenho,                                                                                                                    
                     TO_CHAR(EE.dt_empenho,'dd/mm/yyyy') AS dt_empenho,                                                                                 
                     TO_CHAR(EE.dt_vencimento,'dd/mm/yyyy') AS dt_vencimento,                                                                           
                     HI.cod_historico, HI.nom_historico,                                                                                                
                     CASE WHEN pe.implantado = true THEN                                                                                                
                         restos.cod_recurso                                                                                                             
                     ELSE                                                                                                                               
                         ped_d_cd.cod_recurso                                                                                                           
                     END as cod_recurso,                                                                                                                
                     ped_d_cd.nom_recurso,                                                                                                              
                     CASE WHEN pe.implantado = true THEN                                                                                                
                         restos.num_orgao                                                                                                               
                     ELSE                                                                                                                               
                         ped_d_cd.num_orgao                                                                                                             
                     END as num_orgao,                                                                                                                  
                     ped_d_cd.nom_orgao,                                                                                                                
                     CASE WHEN pe.implantado = true THEN                                                                                                
                         restos.num_unidade                                                                                                             
                     ELSE                                                                                                                               
                         ped_d_cd.num_unidade                                                                                                           
                     END as num_unidade,                                                                                                                
                     ped_d_cd.nom_unidade,                                                                                                              
                     CASE WHEN pe.implantado = true THEN                                                                                                
                         restos.num_pao                                                                                                                 
                     ELSE                                                                                                                               
                         ped_d_cd.num_pao                                                                                                               
                     END as num_pao,                                                                                                                    
                     CASE WHEN pe.implantado = true THEN                                                                                                
                         restos.num_pao                                                                                                                 
                     ELSE                                                                                                                               
                         ped_d_cd.num_acao                                                                                                               
                     END as num_acao,                                                                                                                    
                     ped_d_cd.nom_pao,                                                                                                                  
                     ped_d_cd.cod_despesa,                                                                                                              
                     CASE                                                                                                                               
                         WHEN ped_d_cd.cod_estrutural <> ped_d_cd.cod_estrutural_dot THEN ped_d_cd.cod_estrutural                                       
                         ELSE ''                                                                                                                        
                     END AS cod_estrutural_desdobramento,                                                                                               
                     CASE                                                                                                                               
                         WHEN ped_d_cd.cod_estrutural <> ped_d_cd.cod_estrutural_dot THEN ped_d_cd.descricao                                            
                         ELSE ''                                                                                                                        
                     END AS descricao_desdobramento,                                                                                                    
                     ped_d_cd.cod_estrutural_dot,                                                                                                       
                     ped_d_cd.descricao_dot,                                                                                                            
                     PE.descricao,                                                                                                                      
                     PE.cgm_beneficiario as num_cgm,                                                                                                               
                     CG.nom_cgm AS nom_fornecedor,                                                                                                      
                     substr(CG.cep,1,2)||'.'||substr(CG.cep,3,3)||'-'||substr(CG.cep,6,3) as cep,                                                       
                     CASE                                                                                                                               
                         WHEN PF.numcgm IS NOT NULL THEN CG.fone_residencial                                                                            
                         ELSE CASE                                                                                                                      
                             WHEN CG.fone_comercial != '' THEN  CG.fone_comercial                                                                       
                             ELSE CG.fone_residencial                                                                                                   
                         END                                                                                                                            
                     END AS fone,                                                                                                                       
                     CG.tipo_logradouro||' '||CG.logradouro||' '||CG.numero||' '||CG.complemento as endereco,                                           
                     MU.nom_municipio||'/'||UF.sigla_uf as municipio_uf,                                                                                
                     EA.cod_autorizacao,                                                                                                                
                     empenho.fn_consultar_valor_empenhado(PE.exercicio,EE.cod_empenho,EE.cod_entidade) AS vl_empenhado,                                 
                     empenho.fn_consultar_valor_empenhado_anulado(PE.exercicio,EE.cod_empenho,EE.cod_entidade) AS vl_empenhado_anulado,                 
                     (empenho.fn_consultar_valor_liquidado(PE.exercicio,EE.cod_empenho,EE.cod_entidade) -                                               
                     empenho.fn_consultar_valor_liquidado_anulado(PE.exercicio,EE.cod_empenho,EE.cod_entidade) )AS vl_liquidado,                        
                     (empenho.fn_consultar_valor_empenhado_pago(PE.exercicio,EE.cod_empenho,EE.cod_entidade) -                                          
                     empenho.fn_consultar_valor_empenhado_pago_anulado(PE.exercicio,EE.cod_empenho,EE.cod_entidade) ) AS vl_pago,
                     PE.cod_pre_empenho AS cod_pre_empenho
                  FROM                                                                                                                                  
                     empenho.empenho             AS EE                                                                                                  
                     LEFT JOIN                                                                                                                          
                     empenho.empenho_autorizacao AS EA ON (                                                                                             
                           EA.exercicio       = EE.exercicio                                                                                            
                     AND   EA.cod_entidade    = EE.cod_entidade                                                                                         
                     AND   EA.cod_empenho     = EE.cod_empenho   )                                                                                      
                     LEFT JOIN                                                                                                                          
                     empenho.autorizacao_empenho AS AE ON (                                                                                             
                           AE.exercicio       = EA.exercicio                                                                                            
                     AND   AE.cod_autorizacao = EA.cod_autorizacao                                                                                      
                     AND   AE.cod_entidade    = EA.cod_entidade  )                                                                                      
                     LEFT JOIN                                                                                                                          
                     empenho.autorizacao_reserva AS AR ON (                                                                                             
                           AR.exercicio       = AE.exercicio                                                                                            
                     AND   AR.cod_entidade    = AE.cod_entidade                                                                                         
                     AND   AR.cod_autorizacao = AE.cod_autorizacao )                                                                                    
                     LEFT JOIN                                                                                                                          
                     orcamento.reserva           AS  R ON (                                                                                             
                            R.cod_reserva     = AR.cod_reserva                                                                                          
                     AND    R.exercicio       = AR.exercicio     ),                                                                                     
                     orcamento.entidade          AS OE                                                                                                  
                     LEFT JOIN sw_cgm as cgm_entidade ON (                                                                                              
                            cgm_entidade.numcgm = oe.numcgm ),                                                                                          
                     sw_cgm                      AS  CG                                                                                                 
                     LEFT JOIN                                                                                                                          
                     sw_cgm_pessoa_fisica        AS PF ON (                                                                                             
                           cg.numcgm = pf.numcgm)                                                                                                       
                     LEFT JOIN                                                                                                                          
                     sw_cgm_pessoa_juridica      AS PJ ON (                                                                                             
                           cg.numcgm = pj.numcgm),                                                                                                      
                     sw_municipio                AS MU,                                                                                                 
                     sw_uf                       AS UF,                                                                                                 
                     empenho.pre_empenho         AS PE                                                                                                  
                         LEFT JOIN (                                                                                                                    
                             SELECT                                                                                                                     
                                 ped.exercicio,                                                                                                         
                                 ped.cod_pre_empenho,                                                                                                   
                                 r.cod_recurso,                                                                                                         
                                 r.nom_recurso,                                                                                                         
                                 oo.num_orgao, oo.nom_orgao,                                                                                            
                                 ou.num_unidade, ou.nom_unidade,                                                                                        
                                 pao.num_pao, pao.nom_pao,                                                                                              
                                 d.cod_despesa,                                                                                                         
                                 cd.cod_estrutural,                                                                                                     
                                 cd.descricao,                                                                                                          
                                 cd_dot.cod_estrutural as cod_estrutural_dot,                                                                           
                                 cd_dot.descricao as descricao_dot,                                                                                     
                                 ppa.acao.num_acao AS num_acao                                                                                          
                             FROM                                                                                                                       
                                 empenho.pre_empenho_despesa as ped,                                                                                    
                                 orcamento.despesa           as d,                                                                                      
                                 orcamento.recurso           as r,                                                                                      
                                 orcamento.unidade           as ou,                                                                                     
                                 orcamento.orgao             as oo,                                                                                     
                                 orcamento.pao               as pao                                                                                    
                            JOIN orcamento.pao_ppa_acao                                                                                                 
                              ON pao_ppa_acao.num_pao = pao.num_pao                                                                                     
                             AND pao_ppa_acao.exercicio = pao.exercicio                                                                                 
                            JOIN ppa.acao                                                                                                               
                              ON ppa.acao.cod_acao = pao_ppa_acao.cod_acao                                                                              
                                 ,orcamento.conta_despesa     as cd_dot,                                                                                 
                                 orcamento.conta_despesa     as cd                                                                                      
                             WHERE                                                                                                                      
                                 --Orcamento/Despesa                                                                                                    
                                     ped.cod_despesa     = d.cod_despesa                                                                                
                                 AND ped.exercicio       = d.exercicio                                                                                  
                                 --Órgão
                                                AND d.exercicio         = oo.exercicio
                                                AND d.num_orgao         = oo.num_orgao
                                                --Unidade
                                                AND d.exercicio        = ou.exercicio
                                                AND d.num_orgao        = ou.num_orgao
                                                AND d.num_unidade      = ou.num_unidade                     --Conta Despesa Dotação                                                                                                
                                 AND d.cod_conta         = cd_dot.cod_conta                                                                             
                                 AND d.exercicio         = cd_dot.exercicio                                                                             
                                 --Conta Despesa                                                                                                        
                                 AND ped.cod_conta       = cd.cod_conta                                                                                 
                                 AND ped.exercicio       = cd.exercicio                                                                                 
                                 --Recurso                                                                                                              
                                 AND d.cod_recurso       = r.cod_recurso                                                                                
                                 AND d.exercicio         = r.exercicio                                                                                  
                                 --Pao                                                                                                                  
                                 AND d.num_pao           = pao.num_pao                                                                                  
                                 AND d.exercicio         = pao.exercicio                                                                                
                         ) as ped_d_cd ON pe.exercicio = ped_d_cd.exercicio AND pe.cod_pre_empenho = ped_d_cd.cod_pre_empenho                           
                         LEFT JOIN (                                                                                                                    
                             SELECT                                                                                                                     
                                r.num_orgao,                                                                                                            
                                r.num_unidade,                                                                                                          
                                r.num_pao,                                                                                                              
                                r.recurso as cod_recurso,                                                                                               
                                r.exercicio,                                                                                                            
                                r.cod_pre_empenho                                                                                                       
                             FROM                                                                                                                       
                                empenho.restos_pre_empenho as r                                                                                         
                          ) as restos on pe.exercicio = restos.exercicio AND pe.cod_pre_empenho = restos.cod_pre_empenho,                               
                         empenho.historico as HI                                                                                                        
                  WHERE  EE.cod_pre_empenho = PE.cod_pre_empenho                                                                                        
                  AND    EE.exercicio       = PE.exercicio                                                                                              
                                                                                                                                                        
                  AND    PE.cod_historico   = HI.cod_historico                                                                                          
                  AND    PE.exercicio       = HI.exercicio                                                                                              
                                                                                                                                                        
                  AND    OE.cod_entidade    = EE.cod_entidade                                                                                           
                  AND    OE.exercicio       = EE.exercicio                                                                                              
                                                                                                                                                        
                  AND    CG.numcgm          = PE.cgm_beneficiario                                                                                       
                                                                                                                                                        
                  AND    EE.cod_empenho     = :cod_empenho                                                                       
                  AND    EE.exercicio       = :exercicio                                                                       
                  AND    EE.cod_entidade    = :cod_entidade                                                                      
                                                                                                                                                        
                  AND    CG.cod_municipio   = MU.cod_municipio                                                                                          
                  AND    CG.cod_uf          = MU.cod_uf                                                                                                 
                                                                                                                                                        
                  AND    MU.cod_uf          = UF.cod_uf                                                                                                 
             ) AS tabela                                                                                                                                
             ;  ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':cod_empenho', $filter['cod_empenho'], \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $filter['exercicio'], \PDO::PARAM_STR);
        $query->bindValue(':cod_entidade', $filter['cod_entidade'], \PDO::PARAM_INT);

        $query->execute();

        return $query->fetch();
    }

    /**
     * @param $filter
     * @return array
     */
    public function getRazaoEmpenhoLancamentos($filter)
    {
        $sql = "SELECT                                                                  
	     to_char(CLO.dt_lote,'dd/mm/yyyy') as data,                         
	     CHC.nom_historico as historico,                                    
	     CASE WHEN CHC.complemento = true THEN CL.complemento               
	          ELSE ''                                                       
	     END AS complemento,                                                
	     abs(coalesce(CVL.vl_lancamento,0.00)) as valor,                    
	     contabilidade.fn_recupera_conta_lancamento(CVL.exercicio,CVL.cod_entidade,CVL.cod_lote,CVL.tipo,CVL.sequencia,'D') as debito, 
	     contabilidade.fn_recupera_conta_lancamento(CVL.exercicio,CVL.cod_entidade,CVL.cod_lote,CVL.tipo,CVL.sequencia,'C') as credito 
	FROM                                                                    
	    (                                                                   
	    SELECT                                                              
	        CE.exercicio,                                                   
	        CE.exercicio_empenho,                                           
	        CE.cod_entidade,                                                
	        CE.cod_empenho,                                                 
	        CE.cod_lote,                                                    
	        CE.tipo,                                                        
	        CE.sequencia                                                    
	    FROM                                                                
	        contabilidade.empenhamento  AS CE                               
	    WHERE                                                               
	            CE.cod_empenho    =  :cod_empenho     
	        AND CE.cod_entidade   =  :cod_entidade    
	        AND CE.exercicio_empenho = :exercicio     
	                                                                        
	    UNION                                                               
	                                                                        
	    SELECT                                                              
	        CL.exercicio,                                                   
	        EE.exercicio as exercicio_empenho,                              
	        CL.cod_entidade,                                                
	        ENL.cod_empenho,                                                
	        CL.cod_lote,                                                    
	        CL.tipo,                                                        
	        CL.sequencia                                                    
	    FROM                                                                
	        empenho.empenho            AS EE,                               
	        empenho.nota_liquidacao    AS ENL,                              
	        contabilidade.liquidacao   AS CL                                
	    WHERE                                                               
	            EE.exercicio        = ENL.exercicio_empenho                 
	        AND EE.cod_entidade     = ENL.cod_entidade                      
	        AND EE.cod_empenho      = ENL.cod_empenho                       
	                                                                        
	        AND ENL.exercicio       = CL.exercicio_liquidacao               
	        AND ENL.cod_entidade    = CL.cod_entidade                       
	        AND ENL.cod_nota        = CL.cod_nota                           
	                                                                        
	        AND EE.cod_empenho    = :cod_empenho     
	        AND EE.cod_entidade   = :cod_entidade    
	        AND EE.exercicio      = :exercicio     
	                                                                        
	    UNION                                                               
	                                                                        
	    SELECT                                                              
	        CP.exercicio,                                                   
	        EE.exercicio as exercicio_empenho,                              
	        CP.cod_entidade,                                                
	        ENL.cod_empenho,                                                
	        CP.cod_lote,                                                    
	        CP.tipo,                                                        
	        CP.sequencia                                                    
	    FROM                                                                
	        empenho.empenho              AS EE,                             
	        empenho.nota_liquidacao      AS ENL,                            
	        empenho.nota_liquidacao_paga AS ENLP,                           
	        contabilidade.pagamento      AS CP                              
	    WHERE                                                               
	            EE.exercicio      = ENL.exercicio_empenho                   
	        AND EE.cod_entidade   = ENL.cod_entidade                        
	        AND EE.cod_empenho    = ENL.cod_empenho                         
	                                                                        
	        AND ENL.exercicio     = ENLP.exercicio                          
	        AND ENL.cod_entidade  = ENLP.cod_entidade                       
	        AND ENL.cod_nota      = ENLP.cod_nota                           
	                                                                        
	        AND ENLP.exercicio    = CP.exercicio_liquidacao                 
	        AND ENLP.cod_entidade = CP.cod_entidade                         
	        AND ENLP.cod_nota     = CP.cod_nota                             
	        AND ENLP.timestamp    = CP.timestamp                            
	                                                                        
	        AND EE.cod_empenho    = :cod_empenho     
	        AND EE.cod_entidade   = :cod_entidade    
	        AND EE.exercicio      = :exercicio     
	                                                                        
	    ORDER BY                                                            
	        cod_entidade,                                                   
	        exercicio,                                                      
	        cod_empenho,                                                    
	        cod_lote,                                                       
	        sequencia                                                       
	    )                                 AS tbl                            
	    ,contabilidade.lancamento_empenho AS CLE                            
	    ,contabilidade.lancamento         AS CL                             
	    ,contabilidade.historico_contabil AS CHC                            
	    ,contabilidade.valor_lancamento   AS CVL                            
	    ,contabilidade.lote               AS CLO                            
	                                                                        
	WHERE                                                                   
	        tbl.exercicio    = CLE.exercicio                                
	    AND tbl.cod_entidade = CLE.cod_entidade                             
	    AND tbl.tipo         = CLE.tipo                                     
	    AND tbl.cod_lote     = CLE.cod_lote                                 
	    AND tbl.sequencia    = CLE.sequencia                                
	                                                                        
	    AND CLE.exercicio    = CL.exercicio                                 
	    AND CLE.cod_entidade = CL.cod_entidade                              
	    AND CLE.tipo         = CL.tipo                                      
	    AND CLE.cod_lote     = CL.cod_lote                                  
	                                                                        
	    AND CL.cod_historico = CHC.cod_historico                            
	    AND CL.exercicio     = CHC.exercicio                                
	                                                                        
	    AND CL.exercicio     = CVL.exercicio                                
	    AND CL.cod_entidade  = CVL.cod_entidade                             
	    AND CL.tipo          = CVL.tipo                                     
	    AND CL.cod_lote      = CVL.cod_lote                                 
	    AND CL.sequencia     = CVL.sequencia                                
	                                                                        
	    AND CL.exercicio     = CLO.exercicio                                
	    AND CL.cod_entidade  = CLO.cod_entidade                             
	    AND CL.cod_lote      = CLO.cod_lote                                 
	    AND CL.tipo          = CLO.tipo                                     
	                                                                        
	    AND CVL.tipo_valor      = 'D'                                       
	                                                                        
	    AND tbl.cod_empenho  = :cod_empenho          
	    AND tbl.cod_entidade = :cod_entidade         
	    AND tbl.exercicio_empenho = :exercicio          
	                                                                        
	GROUP BY                                                                
	    tbl.cod_empenho,                                                    
	    CLO.dt_lote,                                                        
	    CHC.nom_historico,                                                  
	    CHC.complemento,                                                    
	    CL.complemento,                                                     
	    CVL.vl_lancamento,                                                  
	    CVL.exercicio,                                                      
	    CVL.cod_entidade,                                                   
	    CVL.cod_lote,                                                       
	    CVL.tipo,                                                           
	    CVL.sequencia                                                       
	                                                                        
	ORDER BY                                                                
	    CLO.dt_lote,                                                        
	    CHC.nom_historico,                                                  
	    CHC.complemento,                                                    
	    CVL.vl_lancamento;";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':cod_empenho', $filter['cod_empenho'], \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $filter['exercicio'], \PDO::PARAM_STR);
        $query->bindValue(':cod_entidade', $filter['cod_entidade'], \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * gestaoFinanceira/fontes/PHP/empenho/popups/empenho/LSEmpenho.php:144
     * gestaoFinanceira/fontes/PHP/empenho/popups/empenho/LSEmpenho.php:128
     *
     * @param $term
     * @param Entidade $entidade
     * @param $exercicio
     * @return ORM\QueryBuilder
     */
    public function getEmpenhoNotaAsQueryBuilder($term, Entidade $entidade = null, $exercicio = null)
    {
        $qb = $this->createQueryBuilder('Empenho');
        /* gestaoFinanceira/fontes/PHP/empenho/classes/mapeamento/TEmpenhoEmpenho.class.php:5517 */
        /* gestaoFinanceira/fontes/PHP/empenho/classes/mapeamento/TEmpenhoEmpenho.class.php:5142 */
        $qb->join('Empenho.fkEmpenhoNotaLiquidacoes', 'fkEmpenhoNotaLiquidacoes');
        $qb->join('Empenho.fkEmpenhoPreEmpenho', 'fkEmpenhoPreEmpenho');
        $qb->join('fkEmpenhoPreEmpenho.fkSwCgm', 'fkSwCgm');

        if (null !== $entidade) {
            $qb->join('Empenho.fkOrcamentoEntidade', 'fkOrcamentoEntidade');
            $qb->andWhere('fkOrcamentoEntidade.codEntidade = :fkOrcamentoEntidade_codEntidade');
            $qb->andWhere('fkOrcamentoEntidade.exercicio = :fkOrcamentoEntidade_exercicio');
            $qb->setParameter('fkOrcamentoEntidade_codEntidade', $entidade->getCodEntidade());
            $qb->setParameter('fkOrcamentoEntidade_exercicio', $entidade->getExercicio());
        }

        if (null !== $exercicio) {
            $qb->andWhere('Empenho.exercicio = :exercicio');
            $qb->setParameter('exercicio', $exercicio);
        }

        $orx = $qb->expr()->orX();
        $orx->add($qb->expr()->like('STRING(fkSwCgm.numcgm)', ':term'));
        $orx->add($qb->expr()->like('LOWER(fkSwCgm.nomCgm)', ':term'));
        $orx->add($qb->expr()->like('STRING(Empenho.codEmpenho)', ':term'));

        $qb->andWhere($orx);
        $qb->setParameter('term', sprintf('%%%s%%', $term), Type::STRING);

        $qb->addGroupBy('Empenho.codEmpenho');
        $qb->addGroupBy('Empenho.exercicio');
        $qb->addGroupBy('Empenho.codEntidade');

        $qb->orderBy('Empenho.codEmpenho');

        return $qb;
    }

    /**
     * gestaoFinanceira/fontes/PHP/empenho/popups/empenho/LSEmpenho.php:96
     *
     * @param $term
     * @param Entidade|null $entidade
     * @param null $exercicio
     * @return ORM\QueryBuilder
     */
    public function getEmpenhoComplementarAsQueryBuilder($term, Entidade $entidade = null, $exercicio = null)
    {
        $qb = $this->createQueryBuilder('Empenho');
        $qb->join('Empenho.fkOrcamentoEntidade', 'fkOrcamentoEntidade');
        $qb->join('fkOrcamentoEntidade.fkSwCgm', 'fkSwCgm');
        $qb->join('Empenho.fkEmpenhoPreEmpenho', 'fkEmpenhoPreEmpenho');

        if (null !== $entidade) {
            $qb->andWhere('fkOrcamentoEntidade.codEntidade = :fkOrcamentoEntidade_codEntidade');
            $qb->andWhere('fkOrcamentoEntidade.exercicio = :fkOrcamentoEntidade_exercicio');
            $qb->setParameter('fkOrcamentoEntidade_codEntidade', $entidade->getCodEntidade());
            $qb->setParameter('fkOrcamentoEntidade_exercicio', $entidade->getExercicio());
        }

        if (null !== $exercicio) {
            $qb->andWhere('Empenho.exercicio = :exercicio');
            $qb->setParameter('exercicio', $exercicio);
        }

        /* gestaoFinanceira/fontes/PHP/empenho/popups/empenho/LSEmpenho.php:103 */
        /* gestaoFinanceira/fontes/PHP/empenho/classes/negocio/REmpenhoEmpenho.class.php:1614 */
        /* gestaoFinanceira/fontes/PHP/empenho/classes/mapeamento/TEmpenhoEmpenho.class.php:84 */
        /* gestaoFinanceira/fontes/PHP/empenho/classes/mapeamento/TEmpenhoEmpenho.class.php:111 */
        /* gestaoFinanceira/fontes/PHP/empenho/classes/mapeamento/TEmpenhoEmpenho.class.php:116 */
        $qb->andWhere('
            (EmpenhoConsultarValorEmpenhado(fkEmpenhoPreEmpenho.exercicio, Empenho.codEmpenho, Empenho.codEntidade) -
            EmpenhoConsultarValorEmpenhadoAnulado(fkEmpenhoPreEmpenho.exercicio, Empenho.codEmpenho, Empenho.codEntidade)) > 0
        ');

        $orx = $qb->expr()->orX();
        $orx->add($qb->expr()->like('STRING(fkSwCgm.numcgm)', ':term'));
        $orx->add($qb->expr()->like('LOWER(fkSwCgm.nomCgm)', ':term'));
        $orx->add($qb->expr()->like('STRING(Empenho.codEmpenho)', ':term'));

        $qb->andWhere($orx);
        $qb->setParameter('term', sprintf('%%%s%%', $term), Type::STRING);

        $qb->addGroupBy('Empenho.codEmpenho');
        $qb->addGroupBy('Empenho.exercicio');
        $qb->addGroupBy('Empenho.codEntidade');

        $qb->orderBy('Empenho.codEmpenho');

        $qb->setMaxResults(20);

        return $qb;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $term
     * @return ORM\QueryBuilder
     */
    public function getEmpenhoByAsExercicioAndTerm($exercicio, $codEntidade, $term)
    {
        $qb = $this->createQueryBuilder('e')
            ->select( 'e.codEmpenho', 'sc.nomCgm', 'e.exercicio')
            ->join('Urbem\CoreBundle\Entity\Empenho\PreEmpenho', 'pe', 'WITH', 'e.codPreEmpenho = pe.codPreEmpenho AND e.exercicio = pe.exercicio')
            ->join('Urbem\CoreBundle\Entity\SwCgm', 'sc', 'WITH', 'pe.cgmBeneficiario = sc.numcgm')
            ->andWhere('e.codEntidade = :codEntidade')
            ->andWhere('e.exercicio = :exercicio')
            ->setParameter('codEntidade', $codEntidade)
            ->setParameter('exercicio', $exercicio);

            if (is_numeric($term)) {
                $qb->andWhere('e.codEmpenho = :term');
                $qb->setParameter('term', $term);
            } else {
                $orx = $qb->expr()->orX();
                $orx->add($qb->expr()->like('STRING(sc.nomCgm)', ':term'));

                $qb->andWhere($orx);
                $qb->setParameter('term', sprintf('%%%s%%', $term), Type::STRING);
            }

        $qb->orderBy('e.codEmpenho');

        return $qb;
    }
}

