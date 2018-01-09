<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Helper\DateTimePK;

/**
 * Class CargosModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Folhapagamento
 */
class CargosModel extends PeriodoMovimentacaoModel
{
    /**
     * @param string   $ultimoTimestampPeriodoMovimentacao
     * @param string   $exercicio
     * @param string   $stEntidade
     * @param integer  $codEntidade
     * @param integer  $codPeriodoMovimentacao
     *
     * @return mixed
     */
    public function getDadosExportacao($ultimoTimestampPeriodoMovimentacao, $exercicio, $stEntidade, $codEntidade, $codPeriodoMovimentacao)
    {
        $dataFinalCompetencia = $this->getDataFinalCompetenciaPeriodoMovimentacao($codPeriodoMovimentacao, $stEntidade);

        $sql = <<<SQL
SELECT
  LPAD(numero_entidade :: TEXT, 2, '0')                        AS numero_entidade,
  mes_ano,
  LPAD(codigo :: TEXT, 10, '0')                                AS codigo,
  RPAD(descricao_cargo, 60, ' ')                               AS descricao_cargo,
  RPAD(tipo_cargo, 20, ' ')                                    AS tipo_cargo,
  RPAD(lei, 10, ' ')                                           AS lei,
  RPAD(descricao_padrao, 60, ' ')                              AS descricao_padrao,
  LPAD(REPLACE(cargahoraria_mensal :: TEXT, '.', ''), 7, '0')  AS cargahoraria_mensal,
  LPAD(REPLACE(cargahoraria_semanal :: TEXT, '.', ''), 7, '0') AS cargahoraria_semanal,
  LPAD(REPLACE(valor :: TEXT, '.', ''), 13, '0')               AS valor,
  vigencia,
  RPAD(regime_subdivisao, 80, ' ')                             AS regime_subdivisao,
  LPAD(regexp_replace(vagas_criadas :: TEXT, '[^1-9]', '', 'g'), 6, '0')        AS vagas_criadas,
  LPAD(regexp_replace(vagas_ocupadas :: TEXT, '[^1-9]', '', 'g'), 6, '0')       AS vagas_ocupadas,
  LPAD(regexp_replace(vagas_disponiveis :: TEXT, '[^1-9]', '', 'g'), 6, '0')    AS vagas_disponiveis
FROM (
SELECT
  (SELECT cod_entidade
   FROM orcamento.entidade
   WHERE cod_entidade = $codEntidade AND exercicio = '$exercicio')                                          AS numero_entidade,
  to_char(('$dataFinalCompetencia' :: DATE), 'mm/yyyy') AS mes_ano,
  cargo.cod_cargo                                                                                           AS codigo,
  trim(
      cargo.descricao)                                                                                      AS descricao_cargo,
  (CASE WHEN cargo.cargo_cc
    THEN 'COMISSIONADO'
   WHEN cargo.funcao_gratificada
     THEN 'FUNÇÃO GRATIFICADA'
   ELSE 'QUADRO GERAL'
   END)                                                                                                     AS tipo_cargo,
  (norma.num_norma || '/' || norma.exercicio)                                                               AS lei,
  trim(
      padrao.descricao)                                                                                     AS descricao_padrao,
  padrao.horas_mensais                                                                                      AS cargahoraria_mensal,
  padrao.horas_semanais                                                                                     AS cargahoraria_semanal,
  padrao_padrao.valor,
  to_char(padrao_padrao.vigencia, 'ddmmyyyy')                                                               AS vigencia,
  sub_divisao.descricao                                                                                     AS regime_subdivisao,
  COALESCE(vagas_cadastradas.nro_vaga_criada,
           0)                                                                                               AS vagas_criadas,
  COALESCE(contador.contador, 0) + COALESCE(contador_principal.contador,
                                            0)                                                              AS vagas_ocupadas,
  (COALESCE(vagas_cadastradas.nro_vaga_criada, 0) - COALESCE(contador.contador, 0) +
   COALESCE(contador_principal.contador,
            0))                                                                                             AS vagas_disponiveis

FROM pessoal$stEntidade.cargo

  INNER JOIN (SELECT
                cargo_padrao.cod_padrao,
                cargo_padrao.cod_cargo
              FROM pessoal$stEntidade.cargo_padrao, (SELECT
                                                       cod_cargo,
                                                       max(timestamp) AS timestamp
                                                     FROM pessoal$stEntidade.cargo_padrao
                                                     GROUP BY cod_cargo) AS max_cargo_padrao
              WHERE max_cargo_padrao.cod_cargo = cargo_padrao.cod_cargo
                    AND max_cargo_padrao.timestamp = cargo_padrao.timestamp) AS cargo_padrao
    ON cargo_padrao.cod_cargo = cargo.cod_cargo

  INNER JOIN folhapagamento$stEntidade.padrao ON cargo_padrao.cod_padrao = padrao.cod_padrao

  INNER JOIN (SELECT
                padrao_padrao.cod_padrao,
                padrao_padrao.valor,
                padrao_padrao.vigencia
              FROM folhapagamento$stEntidade.padrao_padrao, (SELECT
                                                               cod_padrao,
                                                               max(timestamp) AS timestamp
                                                             FROM folhapagamento$stEntidade.padrao_padrao
                                                             WHERE to_char(vigencia, 'yyyy-mm-dd') <=
                                                                   '$ultimoTimestampPeriodoMovimentacao'
                                                             GROUP BY cod_padrao) AS max_padrao_padrao
              WHERE max_padrao_padrao.cod_padrao = padrao_padrao.cod_padrao
                    AND max_padrao_padrao.timestamp = padrao_padrao.timestamp) AS padrao_padrao
    ON padrao_padrao.cod_padrao = padrao.cod_padrao

  INNER JOIN pessoal$stEntidade.cargo_sub_divisao ON cargo_sub_divisao.cod_cargo = cargo.cod_cargo
                                                     AND cargo_sub_divisao.nro_vaga_criada > 0

  INNER JOIN (SELECT
                cod_cargo,
                cod_sub_divisao,
                max(timestamp) AS timestamp
              FROM pessoal$stEntidade.cargo_sub_divisao
              GROUP BY cod_cargo, cod_sub_divisao) AS max_cargo_sub_divisao
    ON max_cargo_sub_divisao.cod_cargo = cargo_sub_divisao.cod_cargo
       AND max_cargo_sub_divisao.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao
       AND max_cargo_sub_divisao.timestamp = cargo_sub_divisao.timestamp

  INNER JOIN pessoal$stEntidade.sub_divisao ON sub_divisao.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao

  --inicia
  --primeira funcao parte 1
  LEFT JOIN (SELECT
               cargo_sub_divisao.nro_vaga_criada,
               cargo_sub_divisao.cod_cargo,
               cargo_sub_divisao.cod_sub_divisao,
               sub_divisao.cod_regime
             FROM pessoal$stEntidade.cargo_sub_divisao
               INNER JOIN (SELECT
                             cargo_sub_divisao.cod_cargo,
                             cargo_sub_divisao.cod_sub_divisao,
                             max(timestamp) AS timestamp
                           FROM pessoal$stEntidade.cargo_sub_divisao
                           WHERE timestamp <= '$ultimoTimestampPeriodoMovimentacao'
                           GROUP BY cod_cargo, cod_sub_divisao) AS max_cargo_sub_divisao
                 ON cargo_sub_divisao.cod_cargo = max_cargo_sub_divisao.cod_cargo
                    AND cargo_sub_divisao.cod_sub_divisao = max_cargo_sub_divisao.cod_sub_divisao
                    AND cargo_sub_divisao.timestamp = max_cargo_sub_divisao.timestamp
               INNER JOIN pessoal$stEntidade.sub_divisao
                 ON cargo_sub_divisao.cod_sub_divisao = sub_divisao.cod_sub_divisao
               INNER JOIN pessoal$stEntidade.regime ON sub_divisao.cod_regime = regime.cod_regime) AS vagas_cadastradas
    ON vagas_cadastradas.cod_cargo = cargo.cod_cargo
       AND vagas_cadastradas.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao
       AND vagas_cadastradas.cod_regime = sub_divisao.cod_regime
  --segunda funcao parte 1
  LEFT JOIN (SELECT
               count(1) AS contador,
               contrato_servidor.cod_cargo,
               contrato_servidor.cod_sub_divisao,
               contrato_servidor.cod_regime
             FROM pessoal$stEntidade.contrato_servidor

               INNER JOIN (SELECT
                             contrato.cod_contrato,
                             CASE
                             WHEN pensionista.total = 1 AND aposentado.total IS NULL AND rescindido.total IS NULL
                               THEN
                                 'E'
                             WHEN pensionista.total IS NULL AND aposentado.total > 0 AND rescindido.total IS NULL
                               THEN
                                 'P'
                             WHEN pensionista.total IS NULL AND aposentado.total IS NULL AND rescindido.total > 0
                               THEN
                                 'R'
                             WHEN pensionista.total IS NULL AND aposentado.total IS NULL AND rescindido.total IS NULL
                               THEN
                                 'A'
                             END AS status
                           FROM pessoal$stEntidade.contrato
                             LEFT JOIN (SELECT
                                          contrato_pensionista.cod_contrato,
                                          count(*) AS total
                                        FROM pessoal$stEntidade.contrato_pensionista
                                        GROUP BY contrato_pensionista.cod_contrato) AS pensionista
                               ON pensionista.cod_contrato = contrato.cod_contrato
                             LEFT JOIN (SELECT
                                          interna.cod_contrato,
                                          count(*) AS total
                                        FROM (SELECT
                                                aposentadoria.cod_contrato,
                                                max(aposentadoria.timestamp)
                                              FROM pessoal$stEntidade.aposentadoria
                                                LEFT JOIN pessoal$stEntidade.aposentadoria_excluida
                                                  ON aposentadoria_excluida.cod_contrato = aposentadoria.cod_contrato
                                                     AND aposentadoria_excluida.timestamp = aposentadoria.timestamp
                                              WHERE aposentadoria.dt_concessao <= (SELECT periodo_movimentacao.dt_final
                                                                                   FROM
                                                                                     folhapagamento$stEntidade.periodo_movimentacao
                                                                                   WHERE cod_periodo_movimentacao =
                                                                                         (SELECT MAX(
                                                                                             cod_periodo_movimentacao)
                                                                                          FROM
                                                                                            folhapagamento$stEntidade.periodo_movimentacao))
                                                    AND aposentadoria_excluida.cod_contrato IS NULL
                                              GROUP BY aposentadoria.cod_contrato) AS interna
                                        GROUP BY interna.cod_contrato) AS aposentado
                               ON aposentado.cod_contrato = contrato.cod_contrato
                             LEFT JOIN (SELECT
                                          contrato_servidor_caso_causa.cod_contrato,
                                          count(*) AS total
                                        FROM pessoal$stEntidade.contrato_servidor_caso_causa
                                        WHERE dt_rescisao <= (SELECT periodo_movimentacao.dt_final
                                                              FROM folhapagamento$stEntidade.periodo_movimentacao
                                                              WHERE cod_periodo_movimentacao =
                                                                    (SELECT MAX(cod_periodo_movimentacao)
                                                                     FROM
                                                                       folhapagamento$stEntidade.periodo_movimentacao))
                                        GROUP BY contrato_servidor_caso_causa.cod_contrato) AS rescindido
                               ON rescindido.cod_contrato = contrato.cod_contrato) AS situacao_contrato
                 ON situacao_contrato.cod_contrato = contrato_servidor.cod_contrato
             WHERE situacao_contrato.status = 'A'
             GROUP BY contrato_servidor.cod_cargo, contrato_servidor.cod_sub_divisao,
               contrato_servidor.cod_regime) AS contador ON contador.cod_cargo = cargo.cod_cargo
                                                            AND
                                                            contador.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao
                                                            AND contador.cod_regime = sub_divisao.cod_regime
  --  segunda funcao parte 2
  LEFT JOIN (SELECT
               count(1) AS contador,
               contrato_servidor_funcao.cod_cargo,
               contrato_servidor_sub_divisao_funcao.cod_sub_divisao,
               contrato_servidor_regime_funcao.cod_regime
             FROM pessoal$stEntidade.contrato_servidor
               INNER JOIN pessoal$stEntidade.contrato_servidor_funcao
                 ON contrato_servidor.cod_contrato = contrato_servidor_funcao.cod_contrato
               INNER JOIN (SELECT
                             cod_contrato,
                             max(timestamp) AS timestamp
                           FROM pessoal$stEntidade.contrato_servidor_funcao
                           WHERE timestamp <= '$ultimoTimestampPeriodoMovimentacao'
                           GROUP BY cod_contrato) AS max_contrato_servidor_funcao
                 ON contrato_servidor_funcao.cod_contrato = max_contrato_servidor_funcao.cod_contrato
                    AND contrato_servidor_funcao.timestamp = max_contrato_servidor_funcao.timestamp
               INNER JOIN pessoal$stEntidade.contrato_servidor_sub_divisao_funcao
                 ON contrato_servidor.cod_contrato = contrato_servidor_sub_divisao_funcao.cod_contrato
               INNER JOIN (SELECT
                             cod_contrato,
                             max(timestamp) AS timestamp
                           FROM pessoal$stEntidade.contrato_servidor_sub_divisao_funcao
                           WHERE timestamp <= '$ultimoTimestampPeriodoMovimentacao'
                           GROUP BY cod_contrato) AS max_contrato_servidor_sub_divisao_funcao ON
                                                                                                contrato_servidor_sub_divisao_funcao.cod_contrato
                                                                                                =
                                                                                                max_contrato_servidor_sub_divisao_funcao.cod_contrato
                                                                                                AND
                                                                                                contrato_servidor_sub_divisao_funcao.timestamp
                                                                                                =
                                                                                                max_contrato_servidor_sub_divisao_funcao.timestamp
               INNER JOIN pessoal$stEntidade.contrato_servidor_regime_funcao
                 ON contrato_servidor.cod_contrato = contrato_servidor_regime_funcao.cod_contrato
               INNER JOIN (SELECT
                             cod_contrato,
                             max(timestamp) AS timestamp
                           FROM pessoal$stEntidade.contrato_servidor_regime_funcao
                           WHERE timestamp <= '$ultimoTimestampPeriodoMovimentacao'
                           GROUP BY cod_contrato) AS max_contrato_servidor_regime_funcao
                 ON contrato_servidor_regime_funcao.cod_contrato = max_contrato_servidor_regime_funcao.cod_contrato
                    AND contrato_servidor_regime_funcao.timestamp = max_contrato_servidor_regime_funcao.timestamp
               INNER JOIN (SELECT
                             contrato.cod_contrato,
                             CASE
                             WHEN pensionista.total = 1 AND aposentado.total IS NULL AND rescindido.total IS NULL
                               THEN
                                 'E'
                             WHEN pensionista.total IS NULL AND aposentado.total > 0 AND rescindido.total IS NULL
                               THEN
                                 'P'
                             WHEN pensionista.total IS NULL AND aposentado.total IS NULL AND rescindido.total > 0
                               THEN
                                 'R'
                             WHEN pensionista.total IS NULL AND aposentado.total IS NULL AND rescindido.total IS NULL
                               THEN
                                 'A'
                             END AS status
                           FROM pessoal$stEntidade.contrato
                             LEFT JOIN (SELECT
                                          contrato_pensionista.cod_contrato,
                                          count(*) AS total
                                        FROM pessoal$stEntidade.contrato_pensionista
                                        GROUP BY contrato_pensionista.cod_contrato) AS pensionista
                               ON pensionista.cod_contrato = contrato.cod_contrato
                             LEFT JOIN (SELECT
                                          interna.cod_contrato,
                                          count(*) AS total
                                        FROM (SELECT
                                                aposentadoria.cod_contrato,
                                                max(aposentadoria.timestamp)
                                              FROM pessoal$stEntidade.aposentadoria
                                                LEFT JOIN pessoal$stEntidade.aposentadoria_excluida
                                                  ON aposentadoria_excluida.cod_contrato = aposentadoria.cod_contrato
                                                     AND aposentadoria_excluida.timestamp = aposentadoria.timestamp
                                              WHERE aposentadoria.dt_concessao <= (SELECT periodo_movimentacao.dt_final
                                                                                   FROM
                                                                                     folhapagamento$stEntidade.periodo_movimentacao
                                                                                   WHERE cod_periodo_movimentacao =
                                                                                         (SELECT MAX(
                                                                                             cod_periodo_movimentacao)
                                                                                          FROM
                                                                                            folhapagamento$stEntidade.periodo_movimentacao))
                                                    AND aposentadoria_excluida.cod_contrato IS NULL
                                              GROUP BY aposentadoria.cod_contrato) AS interna
                                        GROUP BY interna.cod_contrato) AS aposentado
                               ON aposentado.cod_contrato = contrato.cod_contrato
                             LEFT JOIN (SELECT
                                          contrato_servidor_caso_causa.cod_contrato,
                                          count(*) AS total
                                        FROM pessoal$stEntidade.contrato_servidor_caso_causa
                                        WHERE dt_rescisao <= (SELECT periodo_movimentacao.dt_final
                                                              FROM folhapagamento$stEntidade.periodo_movimentacao
                                                              WHERE cod_periodo_movimentacao =
                                                                    (SELECT MAX(cod_periodo_movimentacao)
                                                                     FROM
                                                                       folhapagamento$stEntidade.periodo_movimentacao))
                                        GROUP BY contrato_servidor_caso_causa.cod_contrato) AS rescindido
                               ON rescindido.cod_contrato = contrato.cod_contrato) AS situacao_contrato
                 ON situacao_contrato.cod_contrato = contrato_servidor.cod_contrato
             WHERE (contrato_servidor.cod_cargo != contrato_servidor_funcao.cod_cargo
                    OR contrato_servidor.cod_sub_divisao != contrato_servidor_sub_divisao_funcao.cod_sub_divisao
                    OR contrato_servidor.cod_regime != contrato_servidor_regime_funcao.cod_regime)
                   AND situacao_contrato.status = 'A'
             GROUP BY contrato_servidor_funcao.cod_cargo, contrato_servidor_sub_divisao_funcao.cod_sub_divisao,
               contrato_servidor_regime_funcao.cod_regime) AS contador_principal
    ON contador_principal.cod_cargo = cargo.cod_cargo
       AND contador_principal.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao
       AND contador_principal.cod_regime = sub_divisao.cod_regime


  INNER JOIN normas.norma ON norma.cod_norma = cargo_sub_divisao.cod_norma

UNION

SELECT
  (SELECT cod_entidade
   FROM orcamento.entidade
   WHERE cod_entidade = $codEntidade AND exercicio = '$exercicio')                                                AS numero_entidade,
  to_char(('$dataFinalCompetencia' :: DATE), 'mm/yyyy')                                                                                              AS mes_ano,
  especialidade.cod_cargo                                                                                         AS codigo,
  (SELECT trim(descricao)
   FROM pessoal$stEntidade.cargo
   WHERE cod_cargo = especialidade.cod_cargo) || ' / ' ||
  especialidade.descricao                                                                                         AS descricao_cargo,
  (CASE WHEN (SELECT cargo_cc
              FROM pessoal$stEntidade.cargo
              WHERE cod_cargo = especialidade.cod_cargo)
    THEN 'COMISSIONADO'
   WHEN (SELECT funcao_gratificada
         FROM pessoal$stEntidade.cargo
         WHERE cod_cargo = especialidade.cod_cargo)
     THEN 'FUNÇÃO GRATIFICADA'
   ELSE 'QUADRO GERAL'
   END)                                                                                                           AS tipo_cargo,
  (norma.num_norma || '/' ||
   norma.exercicio)                                                                                               AS lei,
  trim(
      padrao.descricao)                                                                                           AS descricao_padrao,
  padrao.horas_mensais                                                                                            AS cargahoraria_mensal,
  padrao.horas_semanais                                                                                           AS cargahoraria_semanal,
  padrao_padrao.valor,
  to_char(padrao_padrao.vigencia,
          'ddmmyyyy')                                                                                             AS vigencia,
  sub_divisao.descricao                                                                                           AS regime_subdivisao,
  COALESCE(vagas_cadastradas.nro_vaga_criada,
           0)                                                                                                     AS vagas_criadas,
  COALESCE(contador_principal_especialidade.contador, 0) + COALESCE(contador_principal_especialidade.contador,
                                                                    0)                                            AS vagas_ocupadas,
  (COALESCE(vagas_cadastradas.nro_vaga_criada, 0)) - (COALESCE(contador_especialidade.contador, 0) +
                                                      COALESCE(contador_principal_especialidade.contador,
                                                               0))                                                AS vagas_disponiveis

FROM pessoal$stEntidade.especialidade

  INNER JOIN (SELECT
                especialidade_padrao.cod_padrao,
                especialidade_padrao.cod_especialidade
              FROM pessoal$stEntidade.especialidade_padrao, (SELECT
                                                               cod_especialidade,
                                                               max(timestamp) AS timestamp
                                                             FROM pessoal$stEntidade.especialidade_padrao
                                                             GROUP BY cod_especialidade) AS max_especialidade_padrao
              WHERE max_especialidade_padrao.cod_especialidade = especialidade_padrao.cod_especialidade
                    AND max_especialidade_padrao.timestamp = especialidade_padrao.timestamp) AS especialidade_padrao
    ON especialidade_padrao.cod_especialidade = especialidade.cod_especialidade
  INNER JOIN folhapagamento$stEntidade.padrao ON especialidade_padrao.cod_padrao = padrao.cod_padrao

  INNER JOIN (SELECT
                padrao_padrao.cod_padrao,
                padrao_padrao.valor,
                padrao_padrao.vigencia
              FROM folhapagamento$stEntidade.padrao_padrao, (SELECT
                                                               cod_padrao,
                                                               max(timestamp) AS timestamp
                                                             FROM folhapagamento$stEntidade.padrao_padrao
                                                             WHERE to_char(vigencia, 'yyyy-mm-dd') <=
                                                                   '$ultimoTimestampPeriodoMovimentacao'
                                                             GROUP BY cod_padrao) AS max_padrao_padrao
              WHERE max_padrao_padrao.cod_padrao = padrao_padrao.cod_padrao
                    AND max_padrao_padrao.timestamp = padrao_padrao.timestamp) AS padrao_padrao
    ON padrao_padrao.cod_padrao = padrao.cod_padrao

  INNER JOIN pessoal$stEntidade.cargo_sub_divisao ON cargo_sub_divisao.cod_cargo = especialidade.cod_cargo
                                                     AND cargo_sub_divisao.nro_vaga_criada > 0

  INNER JOIN (SELECT
                cod_cargo,
                cod_sub_divisao,
                max(timestamp) AS timestamp
              FROM pessoal$stEntidade.cargo_sub_divisao
              GROUP BY cod_cargo, cod_sub_divisao) AS max_cargo_sub_divisao
    ON max_cargo_sub_divisao.cod_cargo = cargo_sub_divisao.cod_cargo
       AND max_cargo_sub_divisao.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao
       AND max_cargo_sub_divisao.timestamp = cargo_sub_divisao.timestamp

  INNER JOIN pessoal$stEntidade.sub_divisao ON sub_divisao.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao


  INNER JOIN normas.norma ON norma.cod_norma = cargo_sub_divisao.cod_norma

  -- inicia funcao
  LEFT JOIN (SELECT
               nro_vaga_criada,
               especialidade_sub_divisao.cod_especialidade,
               especialidade_sub_divisao.cod_sub_divisao,
               regime.cod_regime
             FROM pessoal$stEntidade.especialidade_sub_divisao
               INNER JOIN (SELECT
                             cod_especialidade,
                             cod_sub_divisao,
                             max(timestamp) AS timestamp
                           FROM pessoal$stEntidade.especialidade_sub_divisao
                           WHERE timestamp <= '$ultimoTimestampPeriodoMovimentacao'
                           GROUP BY cod_especialidade, cod_sub_divisao) AS max_especialidade_sub_divisao
                 ON especialidade_sub_divisao.cod_especialidade = max_especialidade_sub_divisao.cod_especialidade
                    AND especialidade_sub_divisao.cod_sub_divisao = max_especialidade_sub_divisao.cod_sub_divisao
                    AND especialidade_sub_divisao.timestamp = max_especialidade_sub_divisao.timestamp
               INNER JOIN pessoal$stEntidade.sub_divisao
                 ON especialidade_sub_divisao.cod_sub_divisao = sub_divisao.cod_sub_divisao
               INNER JOIN pessoal$stEntidade.regime ON sub_divisao.cod_regime = regime.cod_regime) AS vagas_cadastradas
    ON vagas_cadastradas.cod_especialidade = especialidade.cod_especialidade
       AND vagas_cadastradas.cod_sub_divisao = sub_divisao.cod_sub_divisao
       AND vagas_cadastradas.cod_regime = sub_divisao.cod_regime

  -- funcao 1
  LEFT JOIN (SELECT
               count(1) AS contador,
               contrato_servidor_especialidade_cargo.cod_especialidade,
               contrato_servidor.cod_sub_divisao,
               contrato_servidor.cod_regime
             FROM pessoal$stEntidade.contrato_servidor_especialidade_cargo
               INNER JOIN pessoal$stEntidade.contrato_servidor
                 ON contrato_servidor.cod_contrato = contrato_servidor_especialidade_cargo.cod_contrato
               INNER JOIN (SELECT
                             contrato.cod_contrato,
                             CASE
                             WHEN pensionista.total = 1 AND aposentado.total IS NULL AND rescindido.total IS NULL
                               THEN
                                 'E'
                             WHEN pensionista.total IS NULL AND aposentado.total > 0 AND rescindido.total IS NULL
                               THEN
                                 'P'
                             WHEN pensionista.total IS NULL AND aposentado.total IS NULL AND rescindido.total > 0
                               THEN
                                 'R'
                             WHEN pensionista.total IS NULL AND aposentado.total IS NULL AND rescindido.total IS NULL
                               THEN
                                 'A'
                             END AS status
                           FROM pessoal$stEntidade.contrato
                             LEFT JOIN (SELECT
                                          contrato_pensionista.cod_contrato,
                                          count(*) AS total
                                        FROM pessoal$stEntidade.contrato_pensionista
                                        GROUP BY contrato_pensionista.cod_contrato) AS pensionista
                               ON pensionista.cod_contrato = contrato.cod_contrato
                             LEFT JOIN (SELECT
                                          interna.cod_contrato,
                                          count(*) AS total
                                        FROM (SELECT
                                                aposentadoria.cod_contrato,
                                                max(aposentadoria.timestamp)
                                              FROM pessoal$stEntidade.aposentadoria
                                                LEFT JOIN pessoal$stEntidade.aposentadoria_excluida
                                                  ON aposentadoria_excluida.cod_contrato = aposentadoria.cod_contrato
                                                     AND aposentadoria_excluida.timestamp = aposentadoria.timestamp
                                              WHERE aposentadoria.dt_concessao <= (SELECT periodo_movimentacao.dt_final
                                                                                   FROM
                                                                                     folhapagamento$stEntidade.periodo_movimentacao
                                                                                   WHERE cod_periodo_movimentacao =
                                                                                         (SELECT MAX(
                                                                                             cod_periodo_movimentacao)
                                                                                          FROM
                                                                                            folhapagamento$stEntidade.periodo_movimentacao))
                                                    AND aposentadoria_excluida.cod_contrato IS NULL
                                              GROUP BY aposentadoria.cod_contrato) AS interna
                                        GROUP BY interna.cod_contrato) AS aposentado
                               ON aposentado.cod_contrato = contrato.cod_contrato
                             LEFT JOIN (SELECT
                                          contrato_servidor_caso_causa.cod_contrato,
                                          count(*) AS total
                                        FROM pessoal$stEntidade.contrato_servidor_caso_causa
                                        WHERE dt_rescisao <= (SELECT periodo_movimentacao.dt_final
                                                              FROM folhapagamento$stEntidade.periodo_movimentacao
                                                              WHERE cod_periodo_movimentacao =
                                                                    (SELECT MAX(cod_periodo_movimentacao)
                                                                     FROM
                                                                       folhapagamento$stEntidade.periodo_movimentacao))
                                        GROUP BY contrato_servidor_caso_causa.cod_contrato) AS rescindido
                               ON rescindido.cod_contrato = contrato.cod_contrato) AS situacao_contrato
                 ON situacao_contrato.cod_contrato = contrato_servidor.cod_contrato
             WHERE situacao_contrato.status = 'A'
             GROUP BY contrato_servidor_especialidade_cargo.cod_especialidade, contrato_servidor.cod_sub_divisao,
               contrato_servidor.cod_regime) AS contador_especialidade
    ON contador_especialidade.cod_especialidade = especialidade.cod_especialidade
       AND contador_especialidade.cod_sub_divisao = sub_divisao.cod_sub_divisao
       AND contador_especialidade.cod_regime = sub_divisao.cod_regime
  -- funcao 2
  LEFT JOIN (SELECT
               count(1) AS contador,
               contrato_servidor_especialidade_funcao.cod_especialidade,
               contrato_servidor_sub_divisao_funcao.cod_sub_divisao,
               contrato_servidor_regime_funcao.cod_regime
             FROM pessoal$stEntidade.contrato_servidor
               LEFT JOIN pessoal$stEntidade.contrato_servidor_especialidade_funcao
                 ON contrato_servidor.cod_contrato = contrato_servidor_especialidade_funcao.cod_contrato
               LEFT JOIN pessoal$stEntidade.contrato_servidor_especialidade_cargo
                 ON contrato_servidor.cod_contrato = contrato_servidor_especialidade_cargo.cod_contrato
               LEFT JOIN (SELECT
                            cod_contrato,
                            max(timestamp) AS timestamp
                          FROM pessoal$stEntidade.contrato_servidor_especialidade_funcao
                          WHERE timestamp <= '$ultimoTimestampPeriodoMovimentacao'
                          GROUP BY cod_contrato) AS max_contrato_servidor_especialidade_funcao ON
                                                                                                 contrato_servidor_especialidade_funcao.cod_contrato
                                                                                                 =
                                                                                                 max_contrato_servidor_especialidade_funcao.cod_contrato
                                                                                                 AND
                                                                                                 contrato_servidor_especialidade_funcao.timestamp
                                                                                                 =
                                                                                                 max_contrato_servidor_especialidade_funcao.timestamp
               INNER JOIN pessoal$stEntidade.contrato_servidor_sub_divisao_funcao
                 ON contrato_servidor.cod_contrato = contrato_servidor_sub_divisao_funcao.cod_contrato
               INNER JOIN (SELECT
                             cod_contrato,
                             max(timestamp) AS timestamp
                           FROM pessoal$stEntidade.contrato_servidor_sub_divisao_funcao
                           WHERE timestamp <= '$ultimoTimestampPeriodoMovimentacao'
                           GROUP BY cod_contrato) AS max_contrato_servidor_sub_divisao_funcao ON
                                                                                                contrato_servidor_sub_divisao_funcao.cod_contrato
                                                                                                =
                                                                                                max_contrato_servidor_sub_divisao_funcao.cod_contrato
                                                                                                AND
                                                                                                contrato_servidor_sub_divisao_funcao.timestamp
                                                                                                =
                                                                                                max_contrato_servidor_sub_divisao_funcao.timestamp
               INNER JOIN pessoal$stEntidade.contrato_servidor_regime_funcao
                 ON contrato_servidor.cod_contrato = contrato_servidor_regime_funcao.cod_contrato
               INNER JOIN (SELECT
                             cod_contrato,
                             max(timestamp) AS timestamp
                           FROM pessoal$stEntidade.contrato_servidor_regime_funcao
                           WHERE timestamp <= '$ultimoTimestampPeriodoMovimentacao'
                           GROUP BY cod_contrato) AS max_contrato_servidor_regime_funcao
                 ON contrato_servidor_regime_funcao.cod_contrato = max_contrato_servidor_regime_funcao.cod_contrato
                    AND contrato_servidor_regime_funcao.timestamp = max_contrato_servidor_regime_funcao.timestamp
               INNER JOIN (SELECT
                             contrato.cod_contrato,
                             CASE
                             WHEN pensionista.total = 1 AND aposentado.total IS NULL AND rescindido.total IS NULL
                               THEN
                                 'E'
                             WHEN pensionista.total IS NULL AND aposentado.total > 0 AND rescindido.total IS NULL
                               THEN
                                 'P'
                             WHEN pensionista.total IS NULL AND aposentado.total IS NULL AND rescindido.total > 0
                               THEN
                                 'R'
                             WHEN pensionista.total IS NULL AND aposentado.total IS NULL AND rescindido.total IS NULL
                               THEN
                                 'A'
                             END AS status
                           FROM pessoal$stEntidade.contrato
                             LEFT JOIN (SELECT
                                          contrato_pensionista.cod_contrato,
                                          count(*) AS total
                                        FROM pessoal$stEntidade.contrato_pensionista
                                        GROUP BY contrato_pensionista.cod_contrato) AS pensionista
                               ON pensionista.cod_contrato = contrato.cod_contrato
                             LEFT JOIN (SELECT
                                          interna.cod_contrato,
                                          count(*) AS total
                                        FROM (SELECT
                                                aposentadoria.cod_contrato,
                                                max(aposentadoria.timestamp)
                                              FROM pessoal$stEntidade.aposentadoria
                                                LEFT JOIN pessoal$stEntidade.aposentadoria_excluida
                                                  ON aposentadoria_excluida.cod_contrato = aposentadoria.cod_contrato
                                                     AND aposentadoria_excluida.timestamp = aposentadoria.timestamp
                                              WHERE aposentadoria.dt_concessao <= (SELECT periodo_movimentacao.dt_final
                                                                                   FROM
                                                                                     folhapagamento$stEntidade.periodo_movimentacao
                                                                                   WHERE cod_periodo_movimentacao =
                                                                                         (SELECT MAX(
                                                                                             cod_periodo_movimentacao)
                                                                                          FROM
                                                                                            folhapagamento$stEntidade.periodo_movimentacao))
                                                    AND aposentadoria_excluida.cod_contrato IS NULL
                                              GROUP BY aposentadoria.cod_contrato) AS interna
                                        GROUP BY interna.cod_contrato) AS aposentado
                               ON aposentado.cod_contrato = contrato.cod_contrato
                             LEFT JOIN (SELECT
                                          contrato_servidor_caso_causa.cod_contrato,
                                          count(*) AS total
                                        FROM pessoal$stEntidade.contrato_servidor_caso_causa
                                        WHERE dt_rescisao <= (SELECT periodo_movimentacao.dt_final
                                                              FROM folhapagamento$stEntidade.periodo_movimentacao
                                                              WHERE cod_periodo_movimentacao =
                                                                    (SELECT MAX(cod_periodo_movimentacao)
                                                                     FROM
                                                                       folhapagamento$stEntidade.periodo_movimentacao))
                                        GROUP BY contrato_servidor_caso_causa.cod_contrato) AS rescindido
                               ON rescindido.cod_contrato = contrato.cod_contrato) AS situacao_contrato
                 ON situacao_contrato.cod_contrato = contrato_servidor.cod_contrato
             WHERE situacao_contrato.status = 'A'
                   AND ((contrato_servidor_especialidade_cargo.cod_especialidade !=
                         contrato_servidor_especialidade_funcao.cod_especialidade
                         OR contrato_servidor_especialidade_cargo.cod_especialidade IS NULL)
                        OR contrato_servidor.cod_sub_divisao != contrato_servidor_sub_divisao_funcao.cod_sub_divisao
                        OR contrato_servidor.cod_regime != contrato_servidor_regime_funcao.cod_regime)
             GROUP BY contrato_servidor_especialidade_funcao.cod_especialidade,
               contrato_servidor_sub_divisao_funcao.cod_sub_divisao,
               contrato_servidor_regime_funcao.cod_regime) AS contador_principal_especialidade
    ON contador_principal_especialidade.cod_especialidade = especialidade.cod_especialidade
       AND contador_principal_especialidade.cod_sub_divisao = sub_divisao.cod_sub_divisao
       AND contador_principal_especialidade.cod_regime = sub_divisao.cod_regime
--termina funcao

ORDER BY codigo) AS tabela;
SQL;

        return $this->getQueryResults($sql);
    }
}
