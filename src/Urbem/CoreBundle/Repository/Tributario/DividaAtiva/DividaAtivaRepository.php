<?php

namespace Urbem\CoreBundle\Repository\Tributario\DividaAtiva;

use Urbem\CoreBundle\Repository\AbstractRepository;

class DividaAtivaRepository extends AbstractRepository
{

    /**
     * @param $params
     * @return array
     */
    public function filtraInscricaoDividaAtiva($params)
    {
        $andWhere = "";

        if (isset($params['periodoDe']) && $params['periodoDe'] != "") {
            $andWhere .= sprintf(" AND divida_ativa.dt_inscricao BETWEEN TO_DATE('%s','dd/mm/yyyy') AND TO_DATE('%s','dd/mm/yyyy')", $params['periodoDe'], $params['periodoAte']);
        }

        if (isset($params['cod_credito']) && $params['cod_credito'] != "") {
            $andWhere .= sprintf(" AND parcela_origem.cod_credito  = %s", $params['cod_credito']);
            $andWhere .= sprintf(" AND parcela_origem.cod_especie  = %s", $params['cod_especie']);
            $andWhere .= sprintf(" AND parcela_origem.cod_genero  = %s", $params['cod_genero']);
            $andWhere .= sprintf(" AND parcela_origem.cod_natureza  = %s", $params['cod_natureza']);
        }

        if (isset($params['cod_grupo']) && $params['cod_grupo'] != "") {
            $andWhere .= sprintf(" AND grupo_credito.cod_grupo  = %s", $params['cod_grupo']);
            $andWhere .= sprintf(" AND grupo_credito.ano_exercicio  = '%s'", $params['grupo_ano_exercicio']);
        }

        if (isset($params['contribuinte']) && $params['contribuinte'] != "") {
            $andWhere .= sprintf(" AND divida_cgm.numcgm IN (%s)", $params['contribuinte']);
        }

        if (isset($params['inscricaoEconomicaDe']) && $params['inscricaoEconomicaDe'] != "") {
            $andWhere .= sprintf(" AND divida_empresa.inscricao_economica >= %s", $params['inscricaoEconomicaDe']);
        }

        if (isset($params['inscricaoEconomicaAte']) && $params['inscricaoEconomicaAte'] != "") {
            $andWhere .= sprintf(" AND divida_empresa.inscricao_economica <= %s", $params['inscricaoEconomicaAte']);
        }

        if (isset($params['inscricaoImobiliariaDe']) && $params['inscricaoImobiliariaDe'] != "") {
            $andWhere .= sprintf(" AND divida_imovel.inscricao_municipal >= %s", $params['inscricaoImobiliariaDe']);
        }

        if (isset($params['inscricaoImobiliariaAte']) && $params['inscricaoImobiliariaAte'] != "") {
            $andWhere .= sprintf(" AND divida_imovel.inscricao_municipal <= %s", $params['inscricaoImobiliariaAte']);
        }

        if (isset($params['inscricaoImobiliariaDe']) && $params['inscricaoImobiliariaDe'] != "" || isset($params['inscricaoImobiliariaAte']) && $params['inscricaoImobiliariaAte'] != "") {
            $select = "CASE WHEN divida_imovel.inscricao_municipal > 0 THEN
                            divida_imovel.inscricao_municipal
                        ELSE
                            divida_empresa.inscricao_economica
                        END ";
        } else {
            $select = "divida_cgm.numcgm ";
        }

        $sql = sprintf("
            SELECT DISTINCT
                    $select AS inscricao_origem
                    , divida_ativa.exercicio
                    , credito.descricao_credito || ' / ' || COALESCE(grupo_credito.descricao, '') AS imposto
                    , divida_ativa.num_livro    AS livro
                    , divida_ativa.num_folha    AS folha
                    , divida_ativa.cod_inscricao || '/' || divida_ativa.exercicio AS ida
                    , SUM(parcela_origem.valor) AS valor_origem
                     FROM divida.divida_ativa
               JOIN (SELECT MIN(divida_parcelamento.num_parcelamento) as num_parcelamento
                               , divida_parcelamento.exercicio
                               , divida_parcelamento.cod_inscricao
                            FROM divida.divida_parcelamento
                        GROUP BY divida_parcelamento.exercicio
                               , divida_parcelamento.cod_inscricao
                         ) AS divida_parcelamento
                   ON divida_parcelamento.exercicio     = divida_ativa.exercicio
                 AND divida_parcelamento.cod_inscricao = divida_ativa.cod_inscricao
                 JOIN divida.divida_cgm
                   ON divida_cgm.exercicio     = divida_ativa.exercicio
                 AND divida_cgm.cod_inscricao = divida_ativa.cod_inscricao
                    JOIN divida.parcelamento
                      ON parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento
                    JOIN divida.parcela_origem
                      ON parcela_origem.num_parcelamento = parcelamento.num_parcelamento
                LEFT JOIN monetario.credito
                       ON credito.cod_credito  = parcela_origem.cod_credito
                      AND credito.cod_natureza = parcela_origem.cod_natureza
                      AND credito.cod_genero   = parcela_origem.cod_genero
                      AND credito.cod_especie  = parcela_origem.cod_especie
                    JOIN arrecadacao.parcela
                      ON parcela.cod_parcela = parcela_origem.cod_parcela
                    JOIN arrecadacao.lancamento
                      ON lancamento.cod_lancamento = parcela.cod_lancamento
               INNER JOIN arrecadacao.lancamento_calculo
                       ON lancamento_calculo.cod_lancamento = lancamento.cod_lancamento
               INNER JOIN arrecadacao.calculo
                       ON calculo.cod_calculo  = lancamento_calculo.cod_calculo
           LEFT JOIN arrecadacao.calculo_grupo_credito
                       ON calculo.cod_calculo = calculo_grupo_credito.cod_calculo
            LEFT JOIN arrecadacao.grupo_credito
                       ON calculo_grupo_credito.cod_grupo     = grupo_credito.cod_grupo
                      AND calculo_grupo_credito.ano_exercicio = grupo_credito.ano_exercicio
                LEFT JOIN divida.divida_empresa
                       ON divida_empresa.exercicio     = divida_ativa.exercicio
                      AND divida_empresa.cod_inscricao = divida_ativa.cod_inscricao

                LEFT JOIN divida.divida_imovel
                       ON divida_imovel.exercicio     = divida_ativa.exercicio
                      AND divida_imovel.cod_inscricao = divida_ativa.cod_inscricao

               INNER JOIN divida.modalidade_vigencia
                       ON modalidade_vigencia.cod_modalidade  = parcelamento.cod_modalidade
                      AND modalidade_vigencia.timestamp       = parcelamento.timestamp_modalidade

               INNER JOIN divida.modalidade
                       ON modalidade.cod_modalidade = modalidade_vigencia.cod_modalidade
         WHERE 1=1
        %s
        GROUP BY inscricao_origem
	         , divida_ativa.exercicio
	         , imposto
	         , livro
	         , folha
	         , ida
        ORDER BY inscricao_origem, ida
        ", $andWhere);

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $numParcelamento
     * @param $diasAtraso
     * @return array
     */
    public function getEstornarCobrancaList($numParcelamento = null, $diasAtraso = null)
    {
        $sql = '
        SELECT DISTINCT
                  dp.num_parcelamento,
                  dparc.numero_parcelamento,
                  dparc.exercicio AS exercicio_cobranca,
                  ddc.numcgm,
                  (
                      SELECT
                          nom_cgm
                      FROM
                          sw_cgm
                      WHERE
                          sw_cgm.numcgm = ddc.numcgm
                  )AS nom_cgm,
                  ded.num_documento,
                  vlr.valor AS valor_parcelamento,
                  tot.parcela AS qtd_parcelas,
                  CASE WHEN tot_vencida.parcela IS NULL THEN
                      0
                  ELSE
                      tot_vencida.parcela
                  END AS qtd_parcelas_vencidas,
                  lista_inscricao_por_num_parcelamento( dp.num_parcelamento ) AS inscricao,
                  CASE WHEN ( max_vencida.dt_vencimento_parcela IS NOT NULL ) THEN
                      to_char(now() - max_vencida.dt_vencimento_parcela, \'dd\')::integer
                  ELSE
                      0
                  END AS dias_atraso
              FROM
                  divida.documento AS dd

              LEFT JOIN
                  divida.emissao_documento AS ded
              ON
                  ded.num_parcelamento = dd.num_parcelamento
                  AND ded.cod_documento = dd.cod_documento
                  AND ded.cod_tipo_documento = dd.cod_tipo_documento

              INNER JOIN
                  divida.divida_parcelamento AS ddp
              ON
                  ddp.num_parcelamento = dd.num_parcelamento

              INNER JOIN
                  divida.parcelamento AS dparc
              ON
                  dparc.num_parcelamento = dd.num_parcelamento

              INNER JOIN
                  divida.divida_cgm AS ddc
              ON
                  ddc.cod_inscricao = ddp.cod_inscricao
                  AND ddc.exercicio = ddp.exercicio

              LEFT JOIN
                  divida.divida_cancelada AS ddcanc
              ON
                  ddcanc.cod_inscricao = ddp.cod_inscricao
                  AND ddcanc.exercicio = ddp.exercicio

              INNER JOIN
                  (
                      SELECT
                          SUM(vlr_parcela) AS valor,
                          num_parcelamento
                      FROM
                          divida.parcela
                      WHERE
                          paga = false
                          AND cancelada = false
                      GROUP BY
                          num_parcelamento
                  ) AS vlr
              ON
                  vlr.num_parcelamento = dd.num_parcelamento

              INNER JOIN
                  (
                      SELECT
                          COUNT(num_parcela) AS parcela,
                          num_parcelamento
                      FROM
                          divida.parcela
                      WHERE
                          paga = false
                          AND cancelada = false
                      GROUP BY
                          num_parcelamento
                  ) AS tot
              ON
                  tot.num_parcelamento = dd.num_parcelamento

              LEFT JOIN
                  (
                      SELECT
                          COUNT(num_parcela) AS parcela,
                          num_parcelamento
                      FROM
                          divida.parcela
                      WHERE
                          paga = false
                          AND cancelada = false
                          AND dt_vencimento_parcela < now()
                      GROUP BY
                          num_parcelamento
                  ) AS tot_vencida
              ON
                  tot_vencida.num_parcelamento = dd.num_parcelamento

              LEFT JOIN
                  (
                      SELECT
                          min(dt_vencimento_parcela) AS dt_vencimento_parcela,
                          num_parcelamento
                      FROM
                          divida.parcela
                      WHERE
                          paga = false
                          AND cancelada = false
                          AND now() > dt_vencimento_parcela
                      GROUP BY
                          num_parcelamento
                  )AS max_vencida
              ON
                  max_vencida.num_parcelamento = dd.num_parcelamento

              INNER JOIN
                  divida.parcela AS dp
              ON
                  dp.num_parcelamento = dd.num_parcelamento

             WHERE
             ddcanc.cod_inscricao IS NULL
             %s
        ';

        $where[] = ' AND 1=1';

        if ($numParcelamento) {
            $where[] = 'dp.num_parcelamento = :numParcelamento ';
        }

        if ($diasAtraso) {
            $where[] = '(to_char(now() - max_vencida.dt_vencimento_parcela, \'dd\')::integer) = :diasAtraso';
        }

        $sql = sprintf($sql, implode(' AND ', $where));
        $q = $this->_em->getConnection()->prepare($sql);

        if ($numParcelamento) {
            $q->bindValue('numParcelamento', $numParcelamento, \PDO::PARAM_STR);
        }

        if ($diasAtraso) {
            $q->bindValue('diasAtraso', $diasAtraso, \PDO::PARAM_INT);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $numParcelamento
     * @return false|array
     */
    public function getListaInscricaoByNumParcelamento($numParcelamento)
    {
        $sql = 'select lista_inscricao_por_num_parcelamento(:numParcelamento)';

        if (!$numParcelamento) {
            return false;
        }

        $q = $this->_em->getConnection()->prepare($sql);
        $q->bindValue('numParcelamento', $numParcelamento, \PDO::PARAM_STR);
        $q->execute();

        return $q->fetchAll();
    }

    /**
     * @param $numcgm
     * @param $inscricaoImobiliariaIni
     * @param $inscricaoImobiliariaEnd
     * @param $inscricaoEconomicaIni
     * @param $inscricaoEconomicaEnd
     * @param $inscricao
     * @param $exercicio
     * @return array
     */
    public function getCobrarDividaList($numcgm, $inscricaoImobiliariaIni, $inscricaoImobiliariaEnd, $inscricaoEconomicaIni, $inscricaoEconomicaEnd, $inscricao, $exercicio)
    {
        $sql = '
          SELECT cod_inscricao
                          , exercicio
                          , dt_vencimento_origem
                          , total_parcelas_divida
                          , inscricao
                          , inscricao_tipo
                          , cod_especie
                          , cod_genero
                          , cod_natureza
                          , cod_credito
                          , credito_formatado
                          , origem
                          , descricao_credito
                          , valor
                          , valor_corrigido
                          , numcgm
                          , nom_cgm
                       FROM divida.fn_busca_saldo_divida(%s, %s, %s, %s, %s, %s, %s, true)
                         AS (
                            cod_inscricao          INTEGER
                          , exercicio              CHAR(4)
                          , dt_vencimento_origem   DATE
                          , total_parcelas_divida  INTEGER
                          , inscricao              INTEGER
                          , inscricao_tipo         TEXT
                          , cod_especie            INTEGER
                          , cod_genero             INTEGER
                          , cod_natureza           INTEGER
                          , cod_credito            INTEGER
                          , credito_formatado      TEXT
                          , origem                 VARCHAR
                          , descricao_credito      TEXT
                          , valor                  NUMERIC
                          , valor_corrigido        NUMERIC
                          , numcgm                 INTEGER
                          , nom_cgm                VARCHAR(200) )
        ';

        $sql = sprintf(
            $sql,
            ($numcgm) ? ':numcgm' : 'null',
            ($inscricaoImobiliariaIni) ? ':inscricaoImobiliariaIni' : 'null',
            ($inscricaoImobiliariaEnd) ? ':inscricaoImobiliariaEnd' : 'null',
            ($inscricaoEconomicaIni) ? ':inscricaoEconomicaIni' : 'null',
            ($inscricaoEconomicaEnd) ? ':inscricaoEconomicaEnd' : 'null',
            ($inscricao) ? ':inscricao' : 'null',
            ($exercicio) ? ':exercicio' : '\'\''
        );

        $q = $this->_em->getConnection()->prepare($sql);

        if ($numcgm) {
            $q->bindValue('numcgm', $numcgm, \PDO::PARAM_INT);
        }
        if ($inscricaoImobiliariaIni) {
            $q->bindValue('inscricaoImobiliariaIni', $inscricaoImobiliariaIni, \PDO::PARAM_INT);
        }
        if ($inscricaoImobiliariaEnd) {
            $q->bindValue('inscricaoImobiliariaEnd', $inscricaoImobiliariaEnd, \PDO::PARAM_INT);
        }
        if ($inscricaoEconomicaIni) {
            $q->bindValue('inscricaoEconomicaIni', $inscricaoEconomicaIni, \PDO::PARAM_INT);
        }
        if ($inscricaoEconomicaEnd) {
            $q->bindValue('inscricaoEconomicaEnd', $inscricaoEconomicaEnd, \PDO::PARAM_INT);
        }
        if ($inscricao) {
            $q->bindValue('inscricao', $inscricao, \PDO::PARAM_INT);
        }
        if ($exercicio) {
            $q->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     *  @param $numcgm
     *  @param $inscricaoImobiliariaIni
     *  @param $inscricaoImobiliariaEnd
     *  @param $inscricaoEconomicaIni
     *  @param $inscricaoEconomicaEnd
     *  @param $inscricaoAno
     *  @return array
     */
    public function getRegistroParcelas($numcgm, $inscricaoImobiliariaIni, $inscricaoImobiliariaEnd, $inscricaoEconomicaIni, $inscricaoEconomicaEnd, $inscricaoAno, $groupBy = true)
    {
        $sql = 'SELECT cod_inscricao
                            , exercicio
                            , dt_vencimento_origem
                            , total_parcelas_divida
                            , inscricao
                            , inscricao_tipo
                            , cod_especie
                            , cod_genero
                            , cod_natureza
                            , cod_credito
                            , credito_formatado
                            , origem
                            , descricao_credito
                            , valor
                            , valor_corrigido
                            , numcgm
                            , nom_cgm
                         FROM divida.fn_busca_saldo_divida(:numcgm,:inscricaoImobiliariaIni,:inscricaoImobiliariaEnd,:inscricaoEconomicaIni,:inscricaoEconomicaEnd,:inscricao,:exercicio,:groupBy)
                           AS (
                              cod_inscricao          INTEGER
                            , exercicio              CHAR(4)
                            , dt_vencimento_origem   DATE
                            , total_parcelas_divida  INTEGER
                            , inscricao              INTEGER
                            , inscricao_tipo         TEXT
                            , cod_especie            INTEGER
                            , cod_genero             INTEGER
                            , cod_natureza           INTEGER
                            , cod_credito            INTEGER
                            , credito_formatado      TEXT
                            , origem                 VARCHAR
                            , descricao_credito      TEXT
                            , valor                  NUMERIC
                            , valor_corrigido        NUMERIC
                            , numcgm                 INTEGER
                            , nom_cgm                VARCHAR(200) )';

        $q = $this->_em->getConnection()->prepare($sql);

        $numcgm = ($numcgm) ?: null;
        $q->bindValue('numcgm', $numcgm, \PDO::PARAM_INT);

        $inscricaoImobiliariaIni = ($inscricaoImobiliariaIni) ?: null;
        $q->bindValue('inscricaoImobiliariaIni', $inscricaoImobiliariaIni, \PDO::PARAM_INT);

        $inscricaoImobiliariaEnd = ($inscricaoImobiliariaEnd) ?: null;
        $q->bindValue('inscricaoImobiliariaEnd', $inscricaoImobiliariaEnd, \PDO::PARAM_INT);

        $inscricaoEconomicaIni = ($inscricaoEconomicaIni) ?: null;
        $q->bindValue('inscricaoEconomicaIni', $inscricaoEconomicaIni, \PDO::PARAM_INT);

        $inscricaoEconomicaEnd = ($inscricaoEconomicaEnd) ?: null;
        $q->bindValue('inscricaoEconomicaEnd', $inscricaoEconomicaEnd, \PDO::PARAM_INT);

        $inscricaoAno = ($inscricaoAno) ? explode('/', $inscricaoAno) : null;
        $q->bindValue('inscricao', $inscricaoAno[0], \PDO::PARAM_INT);

        $exercicio = (isset($inscricaoAno[1])) ? $inscricaoAno[1]: null;
        $q->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);

        $q->bindValue('groupBy', $groupBy, \PDO::PARAM_BOOL);

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     *  @return array
     */
    public function getModalidades()
    {
        $sql = '
            SELECT
         dm.cod_modalidade,
         dm.descricao,
         dmv.cod_forma_inscricao,
         to_char(dmv.vigencia_inicial, \'dd/mm/YYYY\') AS vigencia_inicial,
         to_char(dmv.vigencia_final, \'dd/mm/YYYY\') AS vigencia_final,
         dmv.cod_funcao,
         dmv.cod_biblioteca,
         dmv.cod_modulo,
         dmv.cod_norma,
         dmv.cod_tipo_modalidade,
                            (
                                SELECT
                                    descricao
                                FROM
                                    divida.tipo_modalidade
                                WHERE
                                    tipo_modalidade.cod_tipo_modalidade = dmv.cod_tipo_modalidade
                            )AS descricao_tipo_modalidade,
         dmv.timestamp
     FROM
         divida.modalidade AS dm
     INNER JOIN
         divida.modalidade_vigencia AS dmv
     ON
         dmv.cod_modalidade = dm.cod_modalidade
         AND dmv.timestamp = dm.ultimo_timestamp
     WHERE  dm.ativa = \'t\' AND dmv.vigencia_inicial <= :curDate AND dmv.vigencia_final >= :curDate AND
     ( dmv.cod_tipo_modalidade = 2 OR dmv.cod_tipo_modalidade = 3 ) ORDER BY dm.cod_modalidade
        ';

        $q = $this->_em->getConnection()->prepare($sql);
        $q->bindValue('curDate', date("Y-m-d"), \PDO::PARAM_STR);
        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     *  @param $inscricao
     *  @param $ano
     *  @return array
     */
    public function getInscricoesVinculadas($inscricao, $ano)
    {
        $sql = '
            SELECT divida_ativa.*
                            , parcela.num_parcela
                            , parcelamento.numcgm_usuario

                         FROM divida.divida_ativa

                   INNER JOIN divida.divida_parcelamento
                           ON divida_parcelamento.cod_inscricao = divida_ativa.cod_inscricao
                          AND divida_parcelamento.exercicio = divida_ativa.exercicio

                   INNER JOIN divida.parcelamento
                           ON divida_parcelamento.num_parcelamento = parcelamento.num_parcelamento

                    LEFT JOIN divida.parcela
                           ON parcelamento.num_parcelamento = parcela.num_parcelamento

                    LEFT JOIN divida.parcelamento_cancelamento
                           ON parcelamento.num_parcelamento = parcelamento_cancelamento.num_parcelamento

                        WHERE ( ( parcelamento_cancelamento.num_parcelamento IS NULL AND parcelamento.judicial = FALSE ) OR
                                ( parcelamento_cancelamento.num_parcelamento IS NOT NULL AND parcelamento.judicial = TRUE AND parcela.cancelada = TRUE )
                              )  AND divida_ativa.cod_inscricao = :inscricao AND divida_ativa.exercicio = :ano
        ';

        $q = $this->_em->getConnection()->prepare($sql);

        if ($inscricao) {
            $q->bindValue('inscricao', $inscricao, \PDO::PARAM_INT);
        }

        if ($ano) {
            $q->bindValue('ano', $ano, \PDO::PARAM_STR);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     *  @param $inscricao
     *  @param $ano
     *  @param $valor
     *  @param $dataPagamento
     *  @return array
     */
    public function getTaxas($inscricao, $ano, $valor, $dtVencimento, $dtPagamento)
    {
        $sql = '
            SELECT
            aplica_acrescimo_modalidade( 0, :inscricao, :ano, 2, 2, 0 ,:valor, :dtVencimento, :dtPagamento, \'false\' ) AS juros
            , aplica_acrescimo_modalidade( 0, :inscricao, :ano, 2, 3, 0 ,:valor, :dtVencimento, :dtPagamento, \'false\' ) AS multa
            , aplica_acrescimo_modalidade( 0, :inscricao, :ano, 2, 1, 0 ,:valor, :dtVencimento, :dtPagamento, \'false\' ) AS correcao
        ';

        $q = $this->_em->getConnection()->prepare($sql);

        if ($inscricao) {
            $q->bindValue(':inscricao', $inscricao, \PDO::PARAM_INT);
        }

        if ($ano) {
            $q->bindValue(':ano', $ano, \PDO::PARAM_INT);
        }

        if ($valor) {
            $q->bindValue(':valor', $valor, \PDO::PARAM_INT);
        }

        if ($dtVencimento) {
            $q->bindValue(':dtVencimento', $dtVencimento, \PDO::PARAM_STR);
        }

        if ($dtPagamento) {
            $q->bindValue(':dtPagamento', $dtPagamento, \PDO::PARAM_STR);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public function getModelos($codAcao)
    {
        $sql = '
            SELECT
                        amc.nom_modelo,
                        amc.nom_arquivo,
                        amc.cod_modelo

                    FROM
                        arrecadacao.modelo_carne AS amc

                    INNER JOIN
                        arrecadacao.acao_modelo_carne AS aamc
                    ON
                        aamc.cod_modelo = amc.cod_modelo

            WHERE aamc.cod_acao = :codAcao
        ';

        $q = $this->_em->getConnection()->prepare($sql);
        $q->bindValue('codAcao', $codAcao, \PDO::PARAM_INT);
        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $inscricao
     * @param $exercicio
     * @return array
     */
    public function getParcelasByInscricao($inscricao, $exercicio)
    {
        $sql = '
            SELECT parcela_origem.cod_parcela
             , parcela_origem.cod_especie
             , parcela_origem.cod_genero
             , parcela_origem.cod_natureza
             , parcela_origem.cod_credito
             , parcela_origem.num_parcelamento
             , divida_parcelamento_ultimo.num_parcelamento AS num_parcelamento_ultimo
             , parcela_origem.valor
          FROM divida.parcelamento
            INNER JOIN (  SELECT MIN(divida_parcelamento.num_parcelamento) AS num_parcelamento
                               , divida_parcelamento.cod_inscricao
                               , divida_parcelamento.exercicio
                            FROM divida.divida_parcelamento
                           WHERE divida_parcelamento.cod_inscricao = :inscricao
                             AND divida_parcelamento.exercicio = :exercicio
                        GROUP BY divida_parcelamento.cod_inscricao
                               , divida_parcelamento.exercicio) AS divida_parcelamento
                    ON parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento
            INNER JOIN (  SELECT MAX(divida_parcelamento.num_parcelamento) AS num_parcelamento
                               , divida_parcelamento.cod_inscricao
                               , divida_parcelamento.exercicio
                            FROM divida.divida_parcelamento
                           WHERE divida_parcelamento.cod_inscricao = :inscricao
                             AND divida_parcelamento.exercicio = :exercicio
                        GROUP BY divida_parcelamento.cod_inscricao
            , divida_parcelamento.exercicio) AS divida_parcelamento_ultimo
                    ON divida_parcelamento.cod_inscricao = divida_parcelamento_ultimo.cod_inscricao
                   AND divida_parcelamento.exercicio = divida_parcelamento_ultimo.exercicio
            INNER JOIN divida.parcela_origem
                    ON parcelamento.num_parcelamento = parcela_origem.num_parcelamento
            ORDER BY parcela_origem.cod_parcela
        ';

        $q = $this->_em->getConnection()->prepare($sql);

        if ($inscricao) {
            $q->bindValue('inscricao', $inscricao, \PDO::PARAM_INT);
        }

        if ($exercicio) {
            $q->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codModalidade
     * @return array
     */
    public function getDocumentos($codModalidade)
    {
        $sql = '
            SELECT
                            dmd.cod_documento
                            , dmd.cod_tipo_documento
                            , dm.cod_modalidade
                            , dm.ultimo_timestamp
                            , amd.nome_arquivo_agt
                            , amd.nome_documento
                            , aad.nome_arquivo_swx
                        FROM
                            divida.modalidade AS dm

                        INNER JOIN
                            divida.modalidade_documento AS dmd
                        ON
                            dm.cod_modalidade = dmd.cod_modalidade
                            AND dm.ultimo_timestamp = dmd.timestamp

                        INNER JOIN
                            administracao.modelo_documento AS amd
                        ON
                            amd.cod_documento = dmd.cod_documento
                            AND amd.cod_tipo_documento = dmd.cod_tipo_documento

                        INNER JOIN
                            administracao.modelo_arquivos_documento AS amad
                        ON
                            amad.cod_documento = dmd.cod_documento
                            AND amad.cod_tipo_documento = dmd.cod_tipo_documento
                            AND amad.padrao = true

                        INNER JOIN
                            administracao.arquivos_documento AS aad
                        ON
                            aad.cod_arquivo = amad.cod_arquivo

            WHERE dm.cod_modalidade = :codModalidade AND amad.cod_acao = 1648
        ';

        $q = $this->_em->getConnection()->prepare($sql);

        if ($codModalidade) {
            $q->bindValue('codModalidade', $codModalidade, \PDO::PARAM_INT);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public function getNumeracaoDivida()
    {
        $sql = 'SELECT  numeracaodivida (\'-1\') as valor ';
        $q = $this->_em->getConnection()->prepare($sql);
        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public function getMonetarioConvenio()
    {
        $sql = '
            select
          c.cod_convenio,
          c.num_convenio,
          c.cod_tipo,
          c.taxa_bancaria,
          c.cedente,
          tc.*
          from
              monetario.convenio as c
          INNER JOIN
              monetario.tipo_convenio as tc
          ON
              c.cod_tipo = tc.cod_tipo
         WHERE c.cod_convenio = -1
        ';

        $q = $this->_em->getConnection()->prepare($sql);
        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codDocumento
     * @param $codTipoDocumento
     * @param $exercicio
     * @return array
     */
    public function getEmissaoDocumento($codDocumento, $codTipoDocumento, $exercicio)
    {
        $sql = 'SELECT
        num_parcelamento ,
        num_emissao ,
        cod_tipo_documento ,
        cod_documento ,
        num_documento ,
        exercicio ,
        TO_CHAR(timestamp,\'yyyy-mm-dd hh24:mi:ss.us\') AS timestamp ,
        numcgm_usuario
        FROM
        divida.emissao_documento WHERE cod_documento = :codDocumento AND cod_tipo_documento = :codTipoDocumento AND exercicio = :exercicio ORDER BY num_documento DESC LIMIT 1
        ';

        $q = $this->_em->getConnection()->prepare($sql);

        if ($codDocumento) {
            $q->bindValue('codDocumento', $codDocumento, \PDO::PARAM_INT);
        }

        if ($codTipoDocumento) {
            $q->bindValue('codTipoDocumento', $codTipoDocumento, \PDO::PARAM_INT);
        }

        if ($exercicio) {
            $q->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codParcela
     * @param $dataVencimento
     * @return array
     */
    public function getParcelaBoleto($codParcela, \DateTime $dataVencimento)
    {
        $sql = '
        select
              ap.cod_parcela,
              ap.cod_lancamento,
              ap.nr_parcela,
              arrecadacao.fn_info_parcela(ap.cod_parcela) as info,
              ap.vencimento-:dataVencimento::date as fator_vencimento,
         to_char(arrecadacao.fn_atualiza_data_vencimento (ap.vencimento),\'dd/mm/yyyy\') as vencimento,
              arrecadacao.fn_atualiza_data_vencimento (ap.vencimento) as vencimento_US,
              ap.valor,
                fn_busca_desconto_parcela( ap.cod_parcela,
              ap.vencimento) as desconto,
              mar.numeracao,
              mar.timestamp as timestamp
         from
                arrecadacao.parcela as ap
                INNER JOIN
             (select
                 cod_parcela,
                 numeracao,
                 exercicio,
                 max(timestamp) as timestamp
             from
                 arrecadacao.carne
             group by
                 cod_parcela,
                 numeracao,
                 exercicio
             ) as mar
             ON mar.cod_parcela = ap.cod_parcela
         WHERE ap.cod_parcela = :codParcela ORDER BY timestamp desc limit 1
        ';

        $q = $this->_em->getConnection()->prepare($sql);

        if ($codParcela) {
            $q->bindValue('codParcela', $codParcela, \PDO::PARAM_INT);
        }

        if ($dataVencimento) {
            $q->bindValue('dataVencimento', $dataVencimento->format('Y-m-d'), \PDO::PARAM_STR);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $numcgm
     * @param $exercicio
     * @param $codLancamento
     * @return array
     */
    public function getDadosContribuinte($numcgm, $exercicio, $codLancamento)
    {
        $sql = '
            select distinct
                        coalesce( dde.inscricao_economica, ddi.inscricao_municipal) as inscricao_municipal,
                        CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            arrecadacao.fn_consulta_endereco_imovel(ddi.inscricao_municipal)
                        ELSE
                            CASE WHEN (edf.inscricao_municipal IS NOT NULL) AND (edi.inscricao_economica IS NOT NULL) THEN
                                CASE WHEN (edf.timestamp > edi.timestamp) THEN
                                    economico.fn_busca_domicilio_fiscal( edf.inscricao_municipal )
                                ELSE
                                    economico.fn_busca_domicilio_informado( edi.inscricao_economica )
                                END
                            ELSE
                                CASE WHEN (edf.inscricao_municipal IS NOT NULL) THEN
                                    economico.fn_busca_domicilio_fiscal( edf.inscricao_municipal )
                                ELSE
                                    CASE WHEN (edi.inscricao_economica IS NOT NULL) THEN
                                        economico.fn_busca_domicilio_informado( edi.inscricao_economica )
                                    ELSE
                                            cgm.tipo_logradouro||\' \'||cgm.logradouro||\' \'||cgm.numero||\' \'||cgm.complemento
                                    END
                                END
                            END
                        END as nom_logradouro,
                        ac.cod_calculo,
                        ac.exercicio,
                        to_char(now(),\'dd/mm/yyyy\') as data_processamento,
                        case when acgc.descricao is not null then
                            acgc.descricao
                        else mc.descricao_credito
                        end as descricao,
                        case when acgc.cod_grupo is not null then
                            acgc.cod_grupo::varchar
                        else mc.cod_credito||\'.\'||mc.cod_especie||\'.\'||mc.cod_genero||\'.\'||mc.cod_natureza
                        end as cod_grupo,
                        arrecadacao.fn_busca_origem_lancamento(al.cod_lancamento,ac.exercicio,1,1) as descricao_cred,
                        mc.descricao_credito,
                        mc.cod_credito,
                        ac.valor,
                        cgm.nom_cgm,
                        cgm.numcgm,
                        CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            arrecadacao.fn_proprietarios_imovel_nomes(ddi.inscricao_municipal)
                        ELSE
                            \'\'
                        END as proprietarios,
                        al.observacao,
                        al.cod_lancamento,
                        ddc.cod_inscricao,
                        ddp.num_parcelamento,
                        dpar.numero_parcelamento,
                        dpar.exercicio AS exercicio_cobranca
                    from
                        divida.divida_cgm AS ddc

                    LEFT JOIN
                        divida.divida_imovel AS ddi
                    ON
                        ddi.cod_inscricao = ddc.cod_inscricao
                        AND ddi.exercicio = ddc.exercicio

                    LEFT JOIN
                        divida.divida_empresa AS dde
                    ON
                        dde.cod_inscricao = ddc.cod_inscricao
                        AND dde.exercicio = ddc.exercicio

                    INNER JOIN
                        divida.divida_parcelamento AS ddp
                    ON
                        ddp.exercicio = ddc.exercicio
                        AND ddp.cod_inscricao = ddc.cod_inscricao

                    INNER JOIN
                        divida.parcelamento AS dpar
                    ON
                        dpar.num_parcelamento = ddp.num_parcelamento

                    INNER JOIN
                        divida.parcela AS dp
                    ON
                        dp.num_parcelamento = ddp.num_parcelamento

                    INNER JOIN
                        divida.parcela_calculo AS dpc
                    ON
                        dpc.num_parcelamento = dp.num_parcelamento
                        AND dpc.num_parcela = dp.num_parcela

                    INNER JOIN
                        arrecadacao.calculo as ac
                    ON
                        ac.cod_calculo = dpc.cod_calculo

                    INNER JOIN
                        monetario.credito as mc
                    ON
                        mc.cod_credito = ac.cod_credito AND mc.cod_natureza = ac.cod_natureza
                        AND mc.cod_especie = ac.cod_especie  AND mc.cod_genero = ac.cod_genero

                    INNER JOIN
                        sw_cgm as cgm
                    ON
                        cgm.numcgm = ddc.numcgm

                    INNER JOIN
                        arrecadacao.lancamento_calculo as alc
                    ON
                        alc.cod_calculo = ac.cod_calculo

                    INNER JOIN
                        arrecadacao.lancamento as al
                    ON
                        al.cod_lancamento = alc.cod_lancamento

                    LEFT JOIN (
                        SELECT
                            edf_tmp.inscricao_economica,
                            edf_tmp.inscricao_municipal,
                            edf_tmp.timestamp
                        FROM
                            economico.domicilio_fiscal AS edf_tmp,
                            (
                                SELECT
                                    MAX (timestamp) AS timestamp,
                                    inscricao_economica
                                FROM
                                    economico.domicilio_fiscal
                                GROUP BY
                                    inscricao_economica
                            )AS tmp
                        WHERE
                            tmp.timestamp = edf_tmp.timestamp
                            AND tmp.inscricao_economica = edf_tmp.inscricao_economica
                    )AS edf
                    ON
                        edf.inscricao_economica = dde.inscricao_economica

                    LEFT JOIN (
                        SELECT
                            edi_tmp.timestamp,
                            edi_tmp.inscricao_economica
                        FROM
                            economico.domicilio_informado AS edi_tmp,
                            (
                                SELECT
                                    MAX(timestamp) AS timestamp,
                                    inscricao_economica
                                FROM
                                    economico.domicilio_informado
                                GROUP BY
                                    inscricao_economica
                            )AS tmp
                        WHERE
                            tmp.timestamp = edi_tmp.timestamp
                            AND tmp.inscricao_economica = edi_tmp.inscricao_economica
                    )AS edi
                    ON
                        dde.inscricao_economica = edi.inscricao_economica




                    LEFT JOIN
                        ( select agc.descricao, agc.cod_grupo, acgc.cod_calculo, agc.ano_exercicio
                            from arrecadacao.grupo_credito as agc
                            INNER JOIN  arrecadacao.calculo_grupo_credito as acgc
                            ON acgc.cod_grupo = agc.cod_grupo AND acgc.ano_exercicio = agc.ano_exercicio
                        ) as acgc
                    ON
                        acgc.cod_calculo = alc.cod_calculo AND acgc.ano_exercicio = ac.exercicio
                    where
                        cgm.numcgm  is not null

             and cgm.numcgm = :numcgm and ac.exercicio = :exercicio
             and al.cod_lancamento = :codLancamento
        ';

        $q = $this->_em->getConnection()->prepare($sql);

        if ($numcgm) {
            $q->bindValue('numcgm', $numcgm, \PDO::PARAM_INT);
        }

        if ($exercicio) {
            $q->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        }

        if ($codLancamento) {
            $q->bindValue('codLancamento', $codLancamento, \PDO::PARAM_INT);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $param
     * @return array
     */
    public function calculaJuroOrMultaParcelasReemissao(array $param)
    {
        if (!$param['numeracao'] || !$param['exercicio'] || !$param['codParcela'] || !$param['dataBase'] || !$param['tipo']) {
            return false;
        }

        $sql = 'SELECT arrecadacao.calculaJuroOrMultaParcelasReemissao(:numeracao, :exercicio, :codParcela, :dataBase, :tipo) as valor';

        $q = $this->_em->getConnection()->prepare($sql);

        if ($param['numeracao']) {
            $q->bindValue('numeracao', $param['numeracao'], \PDO::PARAM_INT);
        }

        if ($param['exercicio']) {
            $q->bindValue('exercicio', $param['exercicio'], \PDO::PARAM_STR);
        }

        if ($param['codParcela']) {
            $q->bindValue('codParcela', $param['codParcela'], \PDO::PARAM_INT);
        }

        if ($param['dataBase']) {
            $dataBasePart = explode('/', $param['dataBase']);
            $dataBase = sprintf('%d-%d-%d', $dataBasePart[2], $dataBasePart[1], $dataBasePart[0]);
            $q->bindValue('dataBase', $dataBase, \PDO::PARAM_STR);
        }

        if ($param['tipo']) {
            $q->bindValue('tipo', $param['tipo'], \PDO::PARAM_STR);
        }

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codModalidade
     * @param $inscricao
     * @param $valor
     * @param $codAcrescimo
     * @param $codTipo
     * @param $dtVencimento
     * @param $qtdParcelas
     * @return array
     */
    public function getReducaoModalidadeAcrescimo($codModalidade, $inscricao, $valor, $codAcrescimo, $codTipo, $dtVencimento, $qtdParcelas)
    {
        $sql = "
            SELECT
            aplica_reducao_modalidade_acrescimo(:codModalidade, :inscricao, :valor, :codAcrescimo, :codTipo, :dtVencimento, :qtdParcelas ) AS valor
        ";

        $q = $this->_em->getConnection()->prepare($sql);

        $q->bindValue(':codModalidade', $codModalidade, \PDO::PARAM_INT);
        $q->bindValue(':inscricao', $inscricao, \PDO::PARAM_INT);
        $q->bindValue(':valor', $valor, \PDO::PARAM_INT);
        $q->bindValue(':codAcrescimo', $codAcrescimo, \PDO::PARAM_INT);
        $q->bindValue(':codTipo', $codTipo, \PDO::PARAM_INT);
        $q->bindValue(':dtVencimento', $dtVencimento, \PDO::PARAM_STR);
        $q->bindValue(':qtdParcelas', $qtdParcelas, \PDO::PARAM_INT);

        $q->execute();

        return $q->fetchAll(\PDO::FETCH_OBJ);
    }

    /* @param $codModalidade
     * @return array
     */
    public function getListaAcrescimosDaModalidade($codModalidade)
    {
        $sql = "SELECT
                        modalidade_acrescimo.cod_acrescimo,
                        modalidade_acrescimo.cod_tipo,
                        acrescimo.descricao_acrescimo

                    FROM
                        divida.modalidade

                    INNER JOIN
                        divida.modalidade_acrescimo
                    ON
                        modalidade_acrescimo.cod_modalidade = modalidade.cod_modalidade
                        AND modalidade_acrescimo.timestamp = modalidade.ultimo_timestamp

                    INNER JOIN
                        monetario.acrescimo
                    ON
                        acrescimo.cod_acrescimo = modalidade_acrescimo.cod_acrescimo
                        AND acrescimo.cod_tipo = modalidade_acrescimo.cod_tipo
            WHERE modalidade.cod_modalidade = :codModalidade AND (modalidade_acrescimo.pagamento = false OR modalidade_acrescimo.pagamento = true)
        ";

        $q = $this->_em->getConnection()->prepare($sql);
        $q->bindValue(':codModalidade', $codModalidade, \PDO::PARAM_INT);
        $q->execute();

        return $q->fetchAll(\PDO::FETCH_ASSOC);
    }
}
