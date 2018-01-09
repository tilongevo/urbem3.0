<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateInterval;
use DateTime;

/**
 * Class ServidoresModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class ServidoresModel extends PeriodoMovimentacaoModel
{
    /**
     * @param string|int $codPeriodoMovimentacao
     * @param string|int $codEntidade
     * @param string     $stEntidade
     *
     * @return array
     */
    public function getDadosExportacao($codPeriodoMovimentacao, $codEntidade, $stEntidade)
    {
        $dataFinalCompetencia = $this->getDataFinalCompetenciaPeriodoMovimentacao($codPeriodoMovimentacao, $stEntidade);

        $sql = <<<SQL
SELECT
  LPAD(cod_entidade :: VARCHAR, 2, '0')                        AS cod_entidade,
  LPAD(matricula :: VARCHAR, 8, '0')                           AS matricula,
  LPAD(REPLACE(horas_mensais :: VARCHAR, '.', ''), 12, '0')    AS horas_mensais,
  RPAD(mesano, 7, ' ')                                         AS mesano,
  RPAD(nom_cgm, 60, ' ')                                       AS nom_cgm,
  RPAD(COALESCE(situacao, ' '), 40, ' ')                       AS situacao,
  RPAD(NULLIF(dt_admissao, ''), 8, ' ')                        AS dt_admissao,
  RPAD(ato_nomeacao, 10, ' ')                                  AS ato_nomeacao,
  RPAD(COALESCE(dt_rescisao, ' '), 8, ' ')                     AS dt_rescisao,
  RPAD(COALESCE(descricao_causa_rescisao, ' '), 60, ' ')       AS descricao_causa_rescisao,
  RPAD(COALESCE(descricao_regime_funcao, ' '), 3, ' ')         AS descricao_regime_funcao,
  RPAD(COALESCE(descricao_sub_divisao_funcao, ' '), 40, ' ')   AS descricao_sub_divisao_funcao,
  RPAD(COALESCE(descricao_funcao, ' '), 60, ' ')               AS descricao_funcao,
  RPAD(COALESCE(descricao_especialidade_funcao, ' '), 60, ' ') AS descricao_especialidade_funcao,
  RPAD(COALESCE(descricao_padrao, ' '), 60, ' ')               AS descricao_padrao,
  RPAD(COALESCE(lotacao, ' '), 20, ' ')                        AS lotacao,
  RPAD(COALESCE(descricao_lotacao, ' '), 60, ' ')              AS descricao_lotacao,
  RPAD(COALESCE(descricao_local, ' '), 60, ' ')                AS descricao_local
FROM (SELECT
        '$codEntidade'                                        AS cod_entidade,
        to_char(('$dataFinalCompetencia' :: DATE), 'mm/yyyy') AS mesano,
        contrato.registro                          AS matricula,
        servidor_pensionista.*
      FROM pessoal$stEntidade.contrato, (-- Inicio consulta servidores (ativos, aposentados e rescindidos)
                                 SELECT
                                   contrato_servidor.cod_contrato,
                                   sw_cgm.nom_cgm,
                                   recuperarSituacaoDoContratoLiteral(contrato_servidor.cod_contrato, '$codPeriodoMovimentacao',
                                                                      '$stEntidade')                                         AS situacao,
                                   to_char(ultimo_contrato_servidor_nomeacao_posse.dt_admissao :: DATE,
                                           'ddmmyyyy')                                                              AS dt_admissao,
                                   (SELECT norma.num_norma || '/' || norma.exercicio
                                    FROM normas.norma
                                    WHERE norma.cod_norma =
                                          contrato_servidor.cod_norma)                                              AS ato_nomeacao,
                                   to_char(ultimo_contrato_servidor_caso_causa.dt_rescisao,
                                           'ddmmyyyy')                                                              AS dt_rescisao,
                                   (SELECT causa_rescisao.descricao
                                    FROM pessoal$stEntidade.causa_rescisao, pessoal$stEntidade.caso_causa
                                    WHERE
                                      caso_causa.cod_caso_causa = ultimo_contrato_servidor_caso_causa.cod_caso_causa AND
                                      caso_causa.cod_causa_rescisao =
                                      causa_rescisao.cod_causa_rescisao)                                            AS descricao_causa_rescisao,
                                   (SELECT descricao
                                    FROM pessoal$stEntidade.regime
                                    WHERE cod_regime =
                                          ultimo_contrato_servidor_regime_funcao.cod_regime_funcao)                 AS descricao_regime_funcao,
                                   (SELECT descricao
                                    FROM pessoal$stEntidade.sub_divisao
                                    WHERE cod_sub_divisao =
                                          ultimo_contrato_servidor_sub_divisao_funcao.cod_sub_divisao_funcao)       AS descricao_sub_divisao_funcao,
                                   (SELECT descricao
                                    FROM pessoal$stEntidade.cargo
                                    WHERE cod_cargo =
                                          ultimo_contrato_servidor_funcao.cod_cargo)                                AS descricao_funcao,
                                   (SELECT descricao
                                    FROM pessoal$stEntidade.especialidade
                                    WHERE especialidade.cod_especialidade =
                                          ultimo_contrato_servidor_especialidade_funcao.cod_especialidade_funcao)   AS descricao_especialidade_funcao,
                                   (SELECT descricao
                                    FROM folhapagamento$stEntidade.padrao
                                    WHERE padrao.cod_padrao =
                                          ultimo_contrato_servidor_padrao.cod_padrao)                               AS descricao_padrao,
                                   ultimo_contrato_servidor_salario.horas_mensais,
                                   (SELECT orgao
                                    FROM organograma.vw_orgao_nivel
                                    WHERE cod_orgao =
                                          ultimo_contrato_servidor_orgao.cod_orgao)                                 AS lotacao,
                                   recuperaDescricaoOrgao(ultimo_contrato_servidor_orgao.cod_orgao,
                                                          to_date('$dataFinalCompetencia',
                                                                  'yyyy-mm-dd'))                                    AS descricao_lotacao,
                                   local.descricao                                                                  AS descricao_local
                                 FROM pessoal$stEntidade.contrato_servidor

                                   INNER JOIN pessoal$stEntidade.servidor_contrato_servidor
                                     ON contrato_servidor.cod_contrato = servidor_contrato_servidor.cod_contrato

                                   INNER JOIN pessoal$stEntidade.servidor
                                     ON servidor_contrato_servidor.cod_servidor = servidor.cod_servidor

                                   INNER JOIN sw_cgm ON servidor.numcgm = sw_cgm.numcgm

                                   INNER JOIN
                                       ultimo_contrato_servidor_orgao('$stEntidade', '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_orgao
                                     ON contrato_servidor.cod_contrato = ultimo_contrato_servidor_orgao.cod_contrato

                                   INNER JOIN ultimo_contrato_servidor_nomeacao_posse('$stEntidade',
                                                                                      '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_nomeacao_posse
                                     ON contrato_servidor.cod_contrato =
                                        ultimo_contrato_servidor_nomeacao_posse.cod_contrato
                                        AND
                                        ultimo_contrato_servidor_nomeacao_posse.dt_admissao <= ('$dataFinalCompetencia' :: DATE)

                                   INNER JOIN
                                       ultimo_contrato_servidor_funcao('$stEntidade', '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_funcao
                                     ON contrato_servidor.cod_contrato = ultimo_contrato_servidor_funcao.cod_contrato

                                   INNER JOIN ultimo_contrato_servidor_regime_funcao('$stEntidade',
                                                                                     '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_regime_funcao
                                     ON contrato_servidor.cod_contrato =
                                        ultimo_contrato_servidor_regime_funcao.cod_contrato

                                   INNER JOIN
                                       ultimo_contrato_servidor_padrao('$stEntidade', '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_padrao
                                     ON contrato_servidor.cod_contrato = ultimo_contrato_servidor_padrao.cod_contrato

                                   INNER JOIN
                                       ultimo_contrato_servidor_salario('$stEntidade', '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_salario
                                     ON contrato_servidor.cod_contrato = ultimo_contrato_servidor_salario.cod_contrato

                                   INNER JOIN ultimo_contrato_servidor_sub_divisao_funcao('$stEntidade',
                                                                                          '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_sub_divisao_funcao
                                     ON contrato_servidor.cod_contrato =
                                        ultimo_contrato_servidor_sub_divisao_funcao.cod_contrato

                                   LEFT JOIN pessoal$stEntidade.contrato_servidor_especialidade_cargo
                                     ON contrato_servidor.cod_contrato =
                                        contrato_servidor_especialidade_cargo.cod_contrato

                                   LEFT JOIN pessoal$stEntidade.especialidade ON especialidade.cod_especialidade =
                                                                        contrato_servidor_especialidade_cargo.cod_especialidade

                                   LEFT JOIN
                                       ultimo_contrato_servidor_local('$stEntidade', '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_local
                                     ON contrato_servidor.cod_contrato = ultimo_contrato_servidor_local.cod_contrato

                                   LEFT JOIN organograma.local
                                     ON local.cod_local = ultimo_contrato_servidor_local.cod_local

                                   LEFT JOIN ultimo_contrato_servidor_especialidade_funcao('$stEntidade',
                                                                                           '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_especialidade_funcao
                                     ON contrato_servidor.cod_contrato =
                                        ultimo_contrato_servidor_especialidade_funcao.cod_contrato

                                   LEFT JOIN
                                       ultimo_contrato_servidor_caso_causa('$stEntidade',
                                                                           '$codPeriodoMovimentacao') AS ultimo_contrato_servidor_caso_causa
                                     ON contrato_servidor.cod_contrato =
                                        ultimo_contrato_servidor_caso_causa.cod_contrato

                                 WHERE ultimo_contrato_servidor_caso_causa.dt_rescisao IS NULL
                                       OR
                                       TO_CHAR(ultimo_contrato_servidor_caso_causa.dt_rescisao, 'yyyymmdd') :: DATE >=
                                       ('$dataFinalCompetencia' :: DATE)

                                 -- Fim consulta servidores (ativos, aposentados e rescindidos)

                                 UNION

                                 -- Inicio consulta pensionista
                                 SELECT
                                   contrato_pensionista.cod_contrato,
                                   sw_cgm.nom_cgm,
                                   recuperarSituacaoDoContratoLiteral(contrato_pensionista.cod_contrato, '$codPeriodoMovimentacao',
                                                                      '$stEntidade')                                          AS situacao,
                                   to_char(ultimo_contrato_pensionista_nomeacao_posse.dt_admissao :: DATE,
                                           'ddmmyyyy')                                                               AS dt_admissao,
                                   (SELECT norma.num_norma || '/' || norma.exercicio
                                    FROM normas.norma
                                    WHERE norma.cod_norma =
                                          contrato_servidor.cod_norma)                                               AS ato_nomeacao,
                                   (CASE WHEN contrato_pensionista.dt_encerramento :: DATE >=
                                              ('$dataFinalCompetencia' :: DATE)
                                     THEN to_char(contrato_pensionista.dt_encerramento :: DATE, 'ddmmyyyy')
                                    ELSE NULL
                                    END)                                                                             AS dt_rescisao,
                                   (CASE WHEN contrato_pensionista.dt_encerramento :: DATE >=
                                              ('$dataFinalCompetencia' :: DATE)
                                     THEN contrato_pensionista.motivo_encerramento
                                    ELSE NULL
                                    END)                                                                             AS descricao_causa_rescisao,
                                   (SELECT descricao
                                    FROM pessoal$stEntidade.regime
                                    WHERE cod_regime =
                                          ultimo_contrato_pensionista_regime_funcao.cod_regime_funcao)               AS descricao_regime_funcao,
                                   (SELECT descricao
                                    FROM pessoal$stEntidade.sub_divisao
                                    WHERE cod_sub_divisao =
                                          ultimo_contrato_pensionista_sub_divisao_funcao.cod_sub_divisao_funcao)     AS descricao_sub_divisao_funcao,
                                   (SELECT descricao
                                    FROM pessoal$stEntidade.cargo
                                    WHERE cod_cargo =
                                          ultimo_contrato_pensionista_funcao.cod_cargo)                              AS descricao_funcao,
                                   (SELECT descricao
                                    FROM pessoal$stEntidade.especialidade
                                    WHERE especialidade.cod_especialidade =
                                          ultimo_contrato_pensionista_especialidade_funcao.cod_especialidade_funcao) AS descricao_especialidade_funcao,
                                   (SELECT descricao
                                    FROM folhapagamento$stEntidade.padrao
                                    WHERE padrao.cod_padrao =
                                          ultimo_contrato_pensionista_padrao.cod_padrao)                             AS descricao_padrao,
                                   ultimo_contrato_pensionista_salario.horas_mensais,
                                   (SELECT orgao
                                    FROM organograma.vw_orgao_nivel
                                    WHERE cod_orgao =
                                          ultimo_contrato_pensionista_orgao.cod_orgao)                               AS lotacao,
                                   recuperaDescricaoOrgao(ultimo_contrato_pensionista_orgao.cod_orgao,
                                                          to_date('$dataFinalCompetencia',
                                                                  'yyyy-mm-dd'))                                     AS descricao_lotacao,
                                   local.descricao                                                                   AS descricao_local
                                 FROM pessoal$stEntidade.contrato_pensionista

                                   INNER JOIN pessoal$stEntidade.pensionista
                                     ON contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                                        AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente

                                   INNER JOIN sw_cgm ON sw_cgm.numcgm = pensionista.numcgm

                                   INNER JOIN
                                       ultimo_contrato_pensionista_orgao('$stEntidade',
                                                                         '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_orgao
                                     ON contrato_pensionista.cod_contrato =
                                        ultimo_contrato_pensionista_orgao.cod_contrato

                                   INNER JOIN ultimo_contrato_servidor_nomeacao_posse('$stEntidade',
                                                                                      '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_nomeacao_posse
                                     ON pensionista.cod_contrato_cedente =
                                        ultimo_contrato_pensionista_nomeacao_posse.cod_contrato

                                   INNER JOIN pessoal$stEntidade.contrato_servidor
                                     ON pensionista.cod_contrato_cedente = contrato_servidor.cod_contrato

                                   INNER JOIN
                                       ultimo_contrato_servidor_funcao('$stEntidade',
                                                                       '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_funcao
                                     ON pensionista.cod_contrato_cedente =
                                        ultimo_contrato_pensionista_funcao.cod_contrato

                                   INNER JOIN ultimo_contrato_servidor_regime_funcao('$stEntidade',
                                                                                     '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_regime_funcao
                                     ON pensionista.cod_contrato_cedente =
                                        ultimo_contrato_pensionista_regime_funcao.cod_contrato

                                   INNER JOIN
                                       ultimo_contrato_servidor_padrao('$stEntidade',
                                                                       '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_padrao
                                     ON pensionista.cod_contrato_cedente =
                                        ultimo_contrato_pensionista_padrao.cod_contrato

                                   INNER JOIN
                                       ultimo_contrato_servidor_salario('$stEntidade',
                                                                        '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_salario
                                     ON pensionista.cod_contrato_cedente =
                                        ultimo_contrato_pensionista_salario.cod_contrato

                                   INNER JOIN ultimo_contrato_servidor_sub_divisao_funcao('$stEntidade',
                                                                                          '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_sub_divisao_funcao
                                     ON pensionista.cod_contrato_cedente =
                                        ultimo_contrato_pensionista_sub_divisao_funcao.cod_contrato

                                   LEFT JOIN
                                   pessoal$stEntidade.contrato_servidor_especialidade_cargo AS contrato_pensionista_especialidade_cargo
                                     ON pensionista.cod_contrato_cedente =
                                        contrato_pensionista_especialidade_cargo.cod_contrato

                                   LEFT JOIN pessoal$stEntidade.especialidade ON especialidade.cod_especialidade =
                                                                        contrato_pensionista_especialidade_cargo.cod_especialidade

                                   LEFT JOIN
                                       ultimo_contrato_servidor_local('$stEntidade', '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_local
                                     ON pensionista.cod_contrato_cedente =
                                        ultimo_contrato_pensionista_local.cod_contrato

                                   LEFT JOIN organograma.local
                                     ON local.cod_local = ultimo_contrato_pensionista_local.cod_local

                                   LEFT JOIN ultimo_contrato_servidor_especialidade_funcao('$stEntidade',
                                                                                           '$codPeriodoMovimentacao') AS ultimo_contrato_pensionista_especialidade_funcao
                                     ON pensionista.cod_contrato_cedente =
                                        ultimo_contrato_pensionista_especialidade_funcao.cod_contrato

                                 WHERE contrato_pensionista.dt_encerramento :: DATE IS NULL
                                       OR contrato_pensionista.dt_encerramento :: DATE >=
                                          ('$dataFinalCompetencia' :: DATE)

                                 -- Fim consulta pensionista
                               ) AS servidor_pensionista
      WHERE contrato.cod_contrato = servidor_pensionista.cod_contrato) AS servidores
WHERE (substring(servidores.dt_admissao FROM 5 FOR 4) || substring(servidores.dt_admissao FROM 3 FOR 2) ||
       substring(servidores.dt_admissao FROM 1 FOR 2)) :: INTEGER <
      to_char(('$dataFinalCompetencia' :: DATE), 'yyyymmdd') :: INTEGER
ORDER BY nom_cgm, matricula;
SQL;

        return $this->getQueryResults($sql);
    }
}
