<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Doctrine\ORM;

class OrdemPagamentoRepository extends ORM\EntityRepository
{
    public function getProximoCodOrdem($exercicio, $codEntidade)
    {
        $sql = "SELECT COALESCE(MAX(cod_ordem), 0) AS CODIGO FROM empenho.ordem_pagamento WHERE cod_entidade = :codEntidade AND exercicio = :exercicio";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        $retorno = $query->fetch();
        if ($retorno) {
            $codOrdem = (int) $retorno['codigo'] + 1;
        } else {
            $codOrdem = 1;
        }
        return $codOrdem;
    }

    public function getDtOrdem($exercicio, $codEntidade)
    {
        $sql = "
        SELECT CASE
            WHEN to_date('01/01/2016', 'dd/mm/yyyy') < to_date('01/01/2016', 'dd/mm/yyyy')
                THEN CASE
                        WHEN max(dt_emissao) < to_date('01/01/2016', 'dd/mm/yyyy')
                            THEN '01/01/2016'
                        ELSE to_char(max(dt_emissao), 'dd/mm/yyyy')
                        END
            ELSE CASE
                    WHEN max(dt_emissao) < to_date('01/01/2016', 'dd/mm/yyyy')
                        THEN '01/01/2016'
                    ELSE CASE
                            WHEN max(dt_emissao) < to_date('01/01/2016', 'dd/mm/yyyy')
                                THEN '01/01/2016'
                            ELSE to_char(max(dt_emissao), 'dd/mm/yyyy')
                            END
                    END
            END AS data_ordem
        FROM empenho.ordem_pagamento
        WHERE cod_entidade IN (:codEntidade)
            AND exercicio = :exercicio
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        $retorno = $query->fetch();

        return $retorno['data_ordem'];
    }

    public function getOrdemPagamentoItem($exercicio, $codEntidade, $codEmpenho = null, $saldo = true)
    {
        $andEmpenho = $andSaldo = '';
        if ($codEmpenho) {
            $andEmpenho .= "AND ENL.cod_empenho = :codEmpenho";
        }
        if ($saldo) {
            $andSaldo = "AND ((empenho.fn_consultar_valor_liquidado_nota(ENL.exercicio, ENL.cod_empenho, ENL.cod_entidade, ENL.cod_nota) - empenho.fn_consultar_valor_liquidado_anulado_nota(ENL.exercicio, ENL.cod_empenho, ENL.cod_entidade, ENL.cod_nota)) > (empenho.fn_consultar_valor_apagar_nota(ENL.exercicio, ENL.cod_nota, ENL.cod_entidade) - empenho.fn_consultar_valor_apagar_anulado_nota(ENL.exercicio, ENL.cod_nota, ENL.cod_entidade)))";
        }
        $sql = "
        SELECT ENL.cod_nota
            ,EPE.descricao
            ,ENL.cod_entidade
            ,ENL.exercicio
            ,TO_CHAR(ENL.dt_liquidacao, 'dd/mm/yyyy') AS dt_liquidacao
            ,CGME.numcgm AS entidade
            ,ENL.cod_empenho
            ,ENL.exercicio_empenho
            ,ENL.exercicio AS exercicio_nota
            ,coalesce(OD.cod_recurso, ERPE.recurso) AS cod_recurso
            ,empenho.fn_consultar_valor_liquidado_nota(ENL.exercicio, ENL.cod_empenho, ENL.cod_entidade, ENL.cod_nota) AS vl_itens
            ,empenho.fn_consultar_valor_liquidado_anulado_nota(ENL.exercicio, ENL.cod_empenho, ENL.cod_entidade, ENL.cod_nota) AS vl_itens_anulados
            ,empenho.fn_consultar_valor_apagar_nota(ENL.exercicio, ENL.cod_nota, ENL.cod_entidade) AS vl_ordem
            ,empenho.fn_consultar_valor_apagar_anulado_nota(ENL.exercicio, ENL.cod_nota, ENL.cod_entidade) AS vl_ordem_anulada
            ,TO_CHAR(EE.dt_empenho, 'dd/mm/yyyy') AS dt_empenho
            ,EPE.cgm_beneficiario
            ,EPE.implantado
            ,CGM.nom_cgm AS beneficiario
        FROM empenho.nota_liquidacao AS ENL
        LEFT JOIN orcamento.entidade AS OE ON (
                OE.cod_entidade = ENL.cod_entidade
                AND OE.exercicio = ENL.exercicio
                )
        LEFT JOIN sw_cgm AS CGME ON CGME.numcgm = OE.numcgm
            ,empenho.empenho AS EE
            ,empenho.pre_empenho AS EPE
        LEFT JOIN empenho.pre_empenho_despesa AS EPD ON (
                EPD.cod_pre_empenho = EPE.cod_pre_empenho
                AND EPD.exercicio = EPE.exercicio
                )
        LEFT JOIN orcamento.despesa AS OD ON (
                OD.cod_despesa = EPD.cod_despesa
                AND OD.exercicio = EPD.exercicio
                )
        LEFT JOIN empenho.restos_pre_empenho AS ERPE ON (
                EPE.cod_pre_empenho = ERPE.cod_pre_empenho
                AND EPE.exercicio = ERPE.exercicio
                )
        LEFT JOIN sw_cgm AS CGM ON CGM.numcgm = EPE.cgm_beneficiario
        WHERE EE.cod_empenho = ENL.cod_empenho
            AND EE.exercicio = ENL.exercicio_empenho
            AND EE.cod_entidade = ENL.cod_entidade
            AND EPE.exercicio = EE.exercicio
            AND EPE.cod_pre_empenho = EE.cod_pre_empenho
            AND ENL.exercicio_empenho = :exercicio
            AND EE.cod_entidade = :codEntidade
            {$andEmpenho}
            AND ENL.cod_nota = (
                SELECT max(cod_nota)
                FROM empenho.nota_liquidacao
                WHERE cod_empenho = ENL.cod_empenho
                    AND cod_entidade = ENL.cod_entidade
                    AND exercicio = ENL.exercicio
            )
            {$andSaldo}
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        if ($codEmpenho) {
            $query->bindValue('codEmpenho', $codEmpenho);
            $query->execute();
            return $query->fetch();
        } else {
            $query->execute();
            return $query->fetchAll();
        }
    }

    public function getOrdemPagamentoReceita($exercicio, $codEntidade)
    {
        $sql = "
        SELECT CLASSIFICACAO.mascara_classificacao
            ,CLASSIFICACAO.descricao
            ,RECEITA.*
        FROM orcamento.VW_CLASSIFICACAO_RECEITA AS CLASSIFICACAO
            ,ORCAMENTO.RECEITA AS RECEITA
            ,ORCAMENTO.CONTA_RECEITA AS CR
            ,CONTABILIDADE.CONFIGURACAO_LANCAMENTO_RECEITA AS CLR
        WHERE CLASSIFICACAO.exercicio IS NOT NULL
            AND RECEITA.cod_conta = CLASSIFICACAO.cod_conta
            AND RECEITA.exercicio = CLASSIFICACAO.exercicio
            AND RECEITA.exercicio = CR.exercicio
            AND RECEITA.cod_conta = CR.cod_conta
            AND CR.exercicio = CLR.exercicio
            AND CR.cod_conta = CLR.cod_conta_receita
            AND RECEITA.exercicio = :exercicio
            AND RECEITA.cod_entidade IN (:codEntidade)
            AND NOT EXISTS (
                SELECT dr.cod_receita_secundaria
                FROM contabilidade.desdobramento_receita AS dr
                WHERE receita.cod_receita = dr.cod_receita_secundaria
                    AND receita.exercicio = dr.exercicio
                )
            AND CLR.estorno = 'false'
        ORDER BY mascara_classificacao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        return $query->fetchAll();
    }

    public function getOrdemPagamentoReceitaCodPlano($exercicio, $codEntidade, $codReceita)
    {
        $sql = "
        SELECT plano_analitica.cod_plano
	          , receita.cod_receita
	       FROM orcamento.receita
	       JOIN orcamento.conta_receita
	         ON receita.cod_conta = conta_receita.cod_conta
	        AND receita.exercicio = conta_receita.exercicio

	       JOIN contabilidade.configuracao_lancamento_receita
	         ON configuracao_lancamento_receita.cod_conta_receita = conta_receita.cod_conta
	        AND configuracao_lancamento_receita.exercicio = conta_receita.exercicio

	       JOIN contabilidade.plano_conta
	         ON plano_conta.cod_conta = configuracao_lancamento_receita.cod_conta
	        AND plano_conta.exercicio = configuracao_lancamento_receita.exercicio

	       JOIN contabilidade.plano_analitica
	         ON plano_analitica.cod_conta = plano_conta.cod_conta
	        AND plano_analitica.exercicio = plano_conta.exercicio

	      WHERE plano_conta.exercicio = :exercicio
	        AND receita.cod_receita = :codReceita
	        AND receita.cod_entidade = :codEntidade
	        AND configuracao_lancamento_receita.estorno = 'f'
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codReceita', $codReceita);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        $retorno = $query->fetch();

        return $retorno['cod_plano'];
    }

    public function getOrdemPagamentoAnulada($exercicio, $codEntidade)
    {
        if (is_array($codEntidade)) {
            $codEntidade = implode(',', $codEntidade);
        }

        $sql = "
            select
              pl.cod_ordem,
              pl.vl_pagamento,
              (
                select SUM(vl_anulado) as vl_total
                from empenho.ordem_pagamento_liquidacao_anulada
                where cod_ordem = pl.cod_ordem
                  and exercicio = pl.exercicio
                  and cod_entidade = pl.cod_entidade
              ) as vl_anulado
              from empenho.pagamento_liquidacao pl
              where pl.exercicio = :exercicio
                and pl.cod_entidade in (:codEntidade)
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', $codEntidade);
        $query->execute();
        $retorno = $query->fetchAll();
        $anulados = array();
        foreach ($retorno as $item) {
            if ($item['vl_pagamento'] == $item['vl_anulado']) {
                $anulados[$item['cod_ordem']] = $item['cod_ordem'];
            }
        }
        return $anulados;
    }

    public function getDotacaoFormatada($exercicio, $codPreEmpenho)
    {
        $sql = "
        SELECT
            publico.fn_mascara_dinamica (
                (
                    SELECT
                        valor
                    FROM
                        administracao.configuracao
                    WHERE
                        parametro = 'masc_despesa'
                        AND exercicio = :exercicio ),
                (
                    SELECT
                        d.num_orgao ::VARCHAR || '.' || d.num_unidade ::VARCHAR || '.' || d.cod_funcao ::VARCHAR || '.' || d.cod_subfuncao ::VARCHAR || '.' || ppa.programa.num_programa ::VARCHAR || '.' || ppa.acao.num_acao ::VARCHAR || '.' || REPLACE (
                            cd.cod_estrutural,
                            '.',
                            '' ) AS dotacao
                    FROM
                        empenho.pre_empenho_despesa AS ped,
                        orcamento.despesa AS d
                    INNER JOIN orcamento.programa_ppa_programa ON programa_ppa_programa.cod_programa = d.cod_programa
                        AND programa_ppa_programa.exercicio = d.exercicio
                    INNER JOIN ppa.programa ON ppa.programa.cod_programa = programa_ppa_programa.cod_programa_ppa
                    INNER JOIN orcamento.pao_ppa_acao ON pao_ppa_acao.num_pao = d.num_pao
                        AND pao_ppa_acao.exercicio = d.exercicio
                    INNER JOIN ppa.acao ON ppa.acao.cod_acao = pao_ppa_acao.cod_acao,
                        orcamento.recurso AS r,
                        orcamento.pao AS pao,
                        orcamento.unidade AS ou,
                        orcamento.orgao AS oo,
                        orcamento.conta_despesa AS cd
                    WHERE
                        --Orcamento/Despesa
                        ped.cod_despesa = d.cod_despesa
                        AND ped.exercicio = d.exercicio --Órgão
                        AND d.num_orgao = ou.num_orgao
                        AND d.num_unidade = ou.num_unidade
                        AND d.exercicio = ou.exercicio
                        AND ou.num_orgao = oo.num_orgao
                        AND ou.exercicio = oo.exercicio --Unidade
                        --Conta Despesa
                        AND ped.cod_conta = cd.cod_conta
                        AND ped.exercicio = cd.exercicio --Recurso
                        AND d.cod_recurso = r.cod_recurso
                        AND d.exercicio = r.exercicio --PAO
                        AND d.num_pao = pao.num_pao
                        AND d.exercicio = pao.exercicio
                        AND ped.exercicio = :exercicio
                        AND ped.cod_pre_empenho = :codPreEmpenho ) ) AS dotacao_formatada
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codPreEmpenho', $codPreEmpenho);
        $query->execute();
        $retorno = $query->fetch();
        $dotacaoFormatada = null;
        if ($retorno) {
            $dotacaoFormatada = $retorno['dotacao_formatada'];
        }
        return $dotacaoFormatada;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getOrdemPagamentoParaBordero(array $params)
    {
        $sql = <<<SQL
SELECT *
FROM
  (
    SELECT
      eop.cod_ordem,
      emp.exercicio_empenho,
      eop.exercicio,
      eop.cod_entidade,
      to_char(eop.dt_vencimento, 'dd/mm/yyyy') AS dt_vencimento,
      to_char(eop.dt_emissao, 'dd/mm/yyyy') AS dt_emissao,
      cgmemp.nom_cgm AS beneficiario,
      empenho.fn_consultar_valor_pagamento_ordem(eop.exercicio, eop.cod_ordem, eop.cod_entidade) AS valor_pagamento,
      coalesce(eopa.vl_anulado, 0.00) AS vl_anulado,
      emp.cgm_beneficiario,
      coalesce(sum(emp.vl_pago_nota), 0.00) AS vl_pago_nota,
      replace(empenho.retorna_notas_empenhos(eop.exercicio, eop.cod_ordem, eop.cod_entidade), '', '<br>') AS nota_empenho,
      emp.implantado
    FROM
      empenho.ordem_pagamento AS eop
      LEFT JOIN
      (
        SELECT
          opa.cod_ordem,
          opa.exercicio,
          opa.cod_entidade,
          coalesce(sum(opla.vl_anulado), 0.00) AS vl_anulado
        FROM
          empenho.ordem_pagamento_anulada AS opa
          JOIN
          empenho.ordem_pagamento_liquidacao_anulada AS opla
            ON (opa.exercicio = opla.exercicio
                AND opa.cod_ordem = opla.cod_ordem
                AND opa.cod_entidade = opla.cod_entidade
                AND opa.timestamp = opla.timestamp)
        GROUP BY
          opa.cod_ordem,
          opa.exercicio,
          opa.cod_entidade
      )
        AS eopa
        ON (eopa.cod_ordem = eop.cod_ordem
            AND eopa.exercicio = eop.exercicio
            AND eopa.cod_entidade = eop.cod_entidade)
      LEFT JOIN
      (
        SELECT
          pl.cod_ordem,
          pl.exercicio,
          pl.cod_entidade,
          pe.cgm_beneficiario,
          pe.implantado,
          nl.exercicio_empenho,
          nl.cod_empenho,
          nl.cod_nota,
          pe.cod_pre_empenho,
          sum(nlp.vl_pago) AS vl_pago_nota
        FROM
          empenho.pagamento_liquidacao AS pl,
          empenho.nota_liquidacao AS nl
          LEFT JOIN
          (
            SELECT
              nlp.exercicio,
              nlp.cod_entidade,
              nlp.cod_nota,
              nlp.timestamp,
              coalesce(sum(nlp.vl_pago), 0.00) - coalesce(sum(nlp.vl_anulado), 0.00) AS vl_pago
            FROM
              (
                SELECT
                  cod_nota,
                  cod_entidade,
                  exercicio,
                  timestamp,
                  sum(vl_pago) AS vl_pago,
                  0.00         AS vl_anulado
                FROM
                  empenho.nota_liquidacao_paga
                GROUP BY
                  cod_nota,
                  timestamp,
                  cod_entidade,
                  exercicio,
                  vl_anulado
                UNION
                SELECT
                  cod_nota,
                  cod_entidade,
                  exercicio,
                  timestamp,
                  0.00            AS vl_pago,
                  sum(vl_anulado) AS vl_anulado
                FROM
                  empenho.nota_liquidacao_paga_anulada
                GROUP BY
                  cod_nota,
                  timestamp,
                  cod_entidade,
                  exercicio,
                  vl_pago
              )
                AS nlp
            GROUP BY
              nlp.exercicio,
              nlp.timestamp,
              nlp.cod_entidade,
              nlp.cod_nota
          )
            AS nlp
            ON (nlp.cod_nota = nl.cod_nota
                AND nlp.exercicio = nl.exercicio
                AND nlp.cod_entidade = nl.cod_entidade)
          ,
          empenho.empenho AS e,
          empenho.pre_empenho AS pe
        WHERE
          pl.cod_nota = nl.cod_nota
          AND pl.exercicio_liquidacao = nl.exercicio
          AND pl.cod_entidade = nl.cod_entidade
          AND pl.exercicio = :exercicio
          AND pl.cod_entidade = :cod_entidade
          AND nl.cod_empenho = e.cod_empenho
          AND nl.exercicio_empenho = e.exercicio
          AND nl.cod_entidade = e.cod_entidade
          AND e.cod_pre_empenho = pe.cod_pre_empenho
          AND e.exercicio = pe.exercicio
        GROUP BY
          pl.cod_ordem,
          pl.exercicio,
          pl.cod_entidade,
          pe.cgm_beneficiario,
          pe.implantado,
          nl.exercicio_empenho,
          nl.cod_empenho,
          nl.cod_nota,
          pe.cod_pre_empenho
      )
        AS emp
        ON (eop.cod_ordem = emp.cod_ordem
            AND eop.exercicio = emp.exercicio
            AND eop.cod_entidade = emp.cod_entidade)
      LEFT JOIN
      orcamento.entidade AS oe
        ON (oe.cod_entidade = eop.cod_entidade
            AND oe.exercicio = eop.exercicio)
      LEFT JOIN
      sw_cgm AS cgmemp
        ON cgmemp.numcgm = emp.cgm_beneficiario
      JOIN
      empenho.pre_empenho_despesa
        ON pre_empenho_despesa.exercicio = emp.exercicio
           AND pre_empenho_despesa.cod_pre_empenho = emp.cod_pre_empenho
      JOIN
      orcamento.despesa
        ON despesa.exercicio = pre_empenho_despesa.exercicio
           AND despesa.cod_despesa = pre_empenho_despesa.cod_despesa
    WHERE
      eop.cod_ordem IS NOT NULL
      AND eop.exercicio = :exercicio
      AND eop.cod_entidade = :cod_entidade
    GROUP BY
      eop.exercicio,
      eop.dt_vencimento,
      eop.dt_emissao,
      emp.exercicio_empenho,
      eop.cod_ordem,
      eop.cod_entidade,
      emp.cgm_beneficiario,
      cgmemp.nom_cgm,
      valor_pagamento,
      emp.implantado,
      eopa.vl_anulado
    ORDER BY
      eop.cod_ordem
  )
    AS tbl
WHERE (valor_pagamento - vl_anulado) > vl_pago_nota;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * @param array $params
     * @return array
     */
    public function recuperaOrdemPagamentoRelatorio(array $params)
    {
        $sql = <<<SQL
SELECT *
FROM (
       SELECT
         cod_ordem,
         exercicio,
         cod_entidade,
         dt_emissao,
         dt_vencimento,
         observacao,
         entidade,
         cod_recurso,
         masc_recurso_red,
         cod_detalhamento,
         cgm_beneficiario,
         implantado,
         beneficiario,
         sum(num_exercicio_empenho)           AS num_exercicio_empenho,
         exercicio_empenho,
         ''                                   AS dt_estorno,
         coalesce(sum(valor_pagamento), 0.00) AS valor_pagamento,
         coalesce(sum(valor_anulada), 0.00)   AS valor_anulada,
         coalesce(sum(saldo_pagamento), 0.00) AS saldo_pagamento,
         nota_empenho,
         vl_nota,
         vl_nota_anulacoes,
         vl_nota_original,
         CASE WHEN (sum(coalesce(saldo_pagamento, 0.00)) < coalesce(vl_nota, 0.00))
                   AND (vl_nota > 0.00)
           THEN 'A Pagar'
         WHEN (sum(coalesce(saldo_pagamento, 0.00)) = coalesce(vl_nota, 0.00))
              AND (vl_nota > 0.00)
           THEN 'Paga'
         WHEN (vl_nota = 0.00)
           THEN 'Anulada'
         END                                  AS situacao,
         CASE WHEN coalesce(sum(valor_anulada), 0.00) > 0.00
           THEN 'Sim'
         ELSE 'Não'
         END                                  AS pagamento_estornado
       FROM (
              SELECT
                op.cod_ordem,
                op.exercicio,
                op.cod_entidade,
                to_char(op.dt_emissao, 'dd/mm/yyyy')                                        AS dt_emissao,
                to_char(op.dt_vencimento, 'dd/mm/yyyy')                                     AS dt_vencimento,
                op.observacao,
                cgm.nom_cgm                                                                 AS entidade,
                1                                                                           AS num_exercicio_empenho,
                em.exercicio                                                                AS exercicio_empenho,
                rec.masc_recurso_red,
                rec.cod_recurso,
                rec.cod_detalhamento,
                pe.cgm_beneficiario,
                pe.implantado,
                cgm_pe.nom_cgm                                                              AS beneficiario,
                coalesce(nota_liq_paga.vl_pago, 0.00)                                       AS valor_pagamento,
                coalesce(nota_liq_paga.vl_anulado, 0.00)                                    AS valor_anulada,
                coalesce(nota_liq_paga.saldo_pagamento, 0.00)                               AS saldo_pagamento,
                nota_liq_paga.cod_nota,
                empenho.retorna_notas_empenhos(op.exercicio, op.cod_ordem, op.cod_entidade) AS nota_empenho,
                sum(coalesce(tot_op.total_op, 0.00))                                        AS vl_nota,
                sum(coalesce(tot_op.anulacoes_op, 0.00))                                    AS vl_nota_anulacoes,
                sum(coalesce(tot_op.vl_original_op, 0.00))                                  AS vl_nota_original

              FROM empenho.ordem_pagamento AS op
                LEFT JOIN empenho.ordem_pagamento_anulada AS opa ON (
                  op.cod_ordem = opa.cod_ordem
                  AND op.exercicio = opa.exercicio
                  AND op.cod_entidade = opa.cod_entidade
                  )

                JOIN empenho.pagamento_liquidacao AS pl ON (
                  op.cod_ordem = pl.cod_ordem
                  AND op.exercicio = pl.exercicio
                  AND op.cod_entidade = pl.cod_entidade
                  )
                JOIN (SELECT
                        coalesce(sum(pl.vl_pagamento), 0.00) - coalesce(opla.vl_anulado, 0.00) AS total_op,
                        coalesce(opla.vl_anulado, 0.00)                                        AS anulacoes_op,
                        coalesce(sum(pl.vl_pagamento), 0.00)                                   AS vl_original_op,
                        pl.cod_ordem,
                        pl.cod_entidade,
                        pl.exercicio
                      FROM empenho.pagamento_liquidacao AS pl
                        LEFT JOIN (
                                    SELECT
                                      opla.cod_ordem,
                                      opla.cod_entidade,
                                      opla.exercicio,
                                      opla.exercicio_liquidacao,
                                      opla.cod_nota,
                                      coalesce(sum(opla.vl_anulado), 0.00) AS vl_anulado
                                    FROM empenho.ordem_pagamento_liquidacao_anulada AS opla
                                    GROUP BY opla.cod_ordem
                                      , opla.cod_entidade
                                      , opla.exercicio
                                      , opla.cod_nota
                                      , opla.exercicio_liquidacao
                                  ) AS opla
                          ON (
                          opla.cod_ordem = pl.cod_ordem
                          AND opla.cod_entidade = pl.cod_entidade
                          AND opla.exercicio = pl.exercicio
                          AND opla.exercicio_liquidacao = pl.exercicio_liquidacao
                          AND opla.cod_nota = pl.cod_nota
                          )
                      WHERE pl.cod_ordem IS NOT NULL
                      GROUP BY pl.cod_ordem
                        , pl.cod_entidade
                        , pl.exercicio
                        , opla.vl_anulado
                     ) AS tot_op ON (
                  tot_op.cod_ordem = pl.cod_ordem
                  AND tot_op.exercicio = pl.exercicio
                  AND tot_op.cod_entidade = pl.cod_entidade
                  )

                JOIN empenho.nota_liquidacao AS nl ON (pl.cod_nota = nl.cod_nota
                                                       AND pl.cod_entidade = nl.cod_entidade
                                                       AND pl.exercicio_liquidacao = nl.exercicio
                  )

                LEFT JOIN (
                            SELECT
                              nlp.cod_entidade,
                              nlp.cod_nota,
                              plnlp.cod_ordem,
                              plnlp.exercicio,
                              nlp.exercicio                                        AS exercicio_liquidacao,
                              sum(coalesce(nlp.vl_pago, 0.00))                     AS vl_pago,
                              sum(coalesce(nlpa.vl_anulado, 0.00))                 AS vl_anulado,
                              (sum(nlp.vl_pago) - coalesce(nlpa.vl_anulado, 0.00)) AS saldo_pagamento

                            FROM empenho.pagamento_liquidacao_nota_liquidacao_paga AS plnlp
                              , empenho.nota_liquidacao_paga AS nlp
                              LEFT JOIN (
                                          SELECT
                                            exercicio,
                                            cod_nota,
                                            cod_entidade,
                                            timestamp,
                                            coalesce(sum(nlpa.vl_anulado), 0.00) AS vl_anulado
                                          FROM empenho.nota_liquidacao_paga_anulada AS nlpa
                                          GROUP BY exercicio, cod_nota, cod_entidade, timestamp
                                        ) AS nlpa ON (nlp.exercicio = nlpa.exercicio
                                                      AND nlp.cod_nota = nlpa.cod_nota
                                                      AND nlp.cod_entidade = nlpa.cod_entidade
                                                      AND nlp.timestamp = nlpa.timestamp
                                )
                            WHERE nlp.cod_entidade = plnlp.cod_entidade
                                  AND nlp.cod_nota = plnlp.cod_nota
                                  AND nlp.exercicio = plnlp.exercicio_liquidacao
                                  AND nlp.timestamp = plnlp.timestamp

                            GROUP BY nlp.cod_entidade
                              , nlp.cod_nota
                              , nlp.exercicio
                              , nlpa.vl_anulado
                              , plnlp.cod_ordem
                              , plnlp.exercicio

                          ) AS nota_liq_paga ON (pl.cod_nota = nota_liq_paga.cod_nota
                                                 AND pl.cod_entidade = nota_liq_paga.cod_entidade
                                                 AND pl.exercicio = nota_liq_paga.exercicio
                                                 AND pl.cod_ordem = nota_liq_paga.cod_ordem
                                                 AND pl.exercicio_liquidacao = nota_liq_paga.exercicio_liquidacao
                  )
                JOIN empenho.empenho AS em ON (nl.cod_empenho = em.cod_empenho
                                               AND nl.exercicio_empenho = em.exercicio
                                               AND nl.cod_entidade = em.cod_entidade
                  )
                JOIN empenho.pre_empenho AS pe ON (em.exercicio = pe.exercicio
                                                   AND em.cod_pre_empenho = pe.cod_pre_empenho
                  )
                JOIN sw_cgm AS cgm_pe ON (pe.cgm_beneficiario = cgm_pe.numcgm)
                LEFT JOIN empenho.pre_empenho_despesa AS ped ON (pe.cod_pre_empenho = ped.cod_pre_empenho
                                                                 AND pe.exercicio = ped.exercicio
                  )

                LEFT JOIN orcamento.despesa AS de ON (ped.cod_despesa = de.cod_despesa
                                                      AND ped.exercicio = de.exercicio
                  )
                LEFT JOIN orcamento.recurso('') AS rec
                  ON (de.cod_recurso = rec.cod_recurso
                      AND de.exercicio = rec.exercicio
                  )
                JOIN orcamento.entidade AS en ON (op.cod_entidade = en.cod_entidade
                                                  AND op.exercicio = en.exercicio
                  )
                JOIN sw_cgm AS cgm ON (en.numcgm = cgm.numcgm)
              GROUP BY op.cod_ordem
                , op.exercicio
                , op.cod_entidade
                , to_char(op.dt_emissao, 'dd/mm/yyyy')
                , to_char(op.dt_vencimento, 'dd/mm/yyyy')
                , op.observacao
                , cgm.nom_cgm
                , num_exercicio_empenho
                , em.exercicio
                , de.cod_recurso
                , rec.masc_recurso_red
                , rec.cod_recurso
                , rec.cod_detalhamento
                , pe.cgm_beneficiario
                , pe.implantado
                , cgm_pe.nom_cgm
                , empenho.retorna_notas_empenhos(op.exercicio, op.cod_ordem, op.cod_entidade)
                , pl.exercicio_liquidacao
                , nota_liq_paga.cod_nota
                , nota_liq_paga.vl_pago
                , nota_liq_paga.vl_anulado
                , nota_liq_paga.saldo_pagamento
            ) AS tabela
       GROUP BY
         cod_ordem
         , exercicio
         , cod_entidade
         , dt_emissao
         , dt_vencimento
         , observacao
         , entidade
         , cod_recurso
         , masc_recurso_red
         , cod_detalhamento
         , cgm_beneficiario
         , implantado
         , beneficiario
         , dt_estorno
         , nota_empenho
         , exercicio_empenho
         , vl_nota
         , vl_nota_original
         , vl_nota_anulacoes
     ) AS tbl
WHERE num_exercicio_empenho > 0
      AND cod_ordem = :cod_ordem
      AND exercicio = :exercicio
      AND cod_entidade = :cod_entidade;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return \DateTime|null
     */
    public function getDtOrdemPagamento($exercicio, $codEntidade)
    {
        $sql = "
            select
                case
                    when to_date(
                        '',
                        'dd/mm/yyyy'
                    )< to_date(
                        :dtInicio,
                        'dd/mm/yyyy'
                    ) then case
                        when max( dt_emissao )< to_date(
                            :dtInicio,
                            'dd/mm/yyyy'
                        ) then :dtInicio
                        else to_char(
                            max( dt_emissao ),
                            'dd/mm/yyyy'
                        )
                    end
                    else case
                        when max( dt_emissao )< to_date(
                            :dtInicio,
                            'dd/mm/yyyy'
                        ) then ''
                        else case
                            when max( dt_emissao )< to_date(
                                '',
                                'dd/mm/yyyy'
                            ) then ''
                            else to_char(
                                max( dt_emissao ),
                                'dd/mm/yyyy'
                            )
                        end
                    end
                end as data_ordem
            from
                empenho.ordem_pagamento
            where
                cod_entidade in(:codEntidade)
                and exercicio = :exercicio
        ";

        $dtInicio = sprintf('01/01/%s', $exercicio);

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('dtInicio', $dtInicio, \PDO::PARAM_STR);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('codEntidade', $codEntidade, \PDO::PARAM_INT);
        $query->execute();
        $retorno = $query->fetch();
        $dtOrdemPagamento = null;
        if ($retorno) {
            list($dia, $mes, $ano) = explode('/', $retorno['data_ordem']);
            $dtOrdemPagamento = new \DateTime(sprintf('%s-%s-%s', $ano, $mes, $dia));
        }
        return $dtOrdemPagamento;
    }
}
