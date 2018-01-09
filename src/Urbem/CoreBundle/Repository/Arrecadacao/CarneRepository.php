<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use PDO;
use Urbem\CoreBundle\Repository\AbstractRepository;

class CarneRepository extends AbstractRepository
{
    /**
     * Retorna a descricao do caso da causa
     * @param  array  $params (numeracao,data)
     * @return object
     */
    public function calculaValores($params)
    {
        $sql = "
        SELECT DISTINCT
                        parcelamento.cod_modalidade
                        , parcela.vencimento
                        , parcela.cod_lancamento
                        , lista_inscricao_imob_eco_cgm_por_num_parcelamento( parcelamento.num_parcelamento ) AS inscricao
                        , dp.vlr_parcela
                        , CASE WHEN parcelamento.judicial = TRUE IS NOT NULL THEN
                            split_part( aplica_acrescimo_modalidade_carne( carne.numeracao,  1, NULL, NULL, parcelamento.cod_modalidade, 2, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' ), ';', 1 )
                          ELSE
                            split_part( aplica_acrescimo_modalidade_carne( carne.numeracao,  0, NULL, NULL, parcelamento.cod_modalidade, 2, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' ), ';', 1 )
                          END AS juros

                        , CASE WHEN parcelamento.judicial = TRUE THEN
                            split_part( aplica_acrescimo_modalidade_carne( carne.numeracao,  1, NULL, NULL, parcelamento.cod_modalidade, 3, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' ), ';', 1 )
                          ELSE
                            split_part( aplica_acrescimo_modalidade_carne( carne.numeracao,  0, NULL, NULL, parcelamento.cod_modalidade, 3, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' ), ';', 1 )
                          END AS multa

                        , CASE WHEN parcelamento.judicial = TRUE THEN
                            split_part( aplica_acrescimo_modalidade_carne( carne.numeracao,  1, NULL, NULL, parcelamento.cod_modalidade, 1, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' ), ';', 1 )
                          ELSE
                            split_part( aplica_acrescimo_modalidade_carne( carne.numeracao,  0, NULL, NULL, parcelamento.cod_modalidade, 1, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' ), ';', 1 )
                          END AS correcao

                        , CASE WHEN parcelamento.judicial = TRUE THEN
                             aplica_acrescimo_modalidade_carne( carne.numeracao,  1, NULL, NULL, parcelamento.cod_modalidade, 2, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' )
                          ELSE
                             aplica_acrescimo_modalidade_carne( carne.numeracao,  0, NULL, NULL, parcelamento.cod_modalidade, 2, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' )
                          END AS juros_completo

                        , CASE WHEN parcelamento.judicial = TRUE THEN
                            aplica_acrescimo_modalidade_carne( carne.numeracao,  1, NULL, NULL, parcelamento.cod_modalidade, 3, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' )
                          ELSE
                            aplica_acrescimo_modalidade_carne( carne.numeracao,  0, NULL, NULL, parcelamento.cod_modalidade, 3, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' )
                          END AS multa_completo

                        , CASE WHEN parcelamento.judicial = TRUE THEN
                            aplica_acrescimo_modalidade_carne( carne.numeracao,  1, NULL, NULL, parcelamento.cod_modalidade, 1, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' )
                          ELSE
                            aplica_acrescimo_modalidade_carne( carne.numeracao,  0, NULL, NULL, parcelamento.cod_modalidade, 1, parcelamento.num_parcelamento ,dp.vlr_parcela, parcela.vencimento, :data, 'true' )
                          END AS correcao_completo

                        , dp.num_parcelamento
                        , dp.num_parcela
                    FROM arrecadacao.carne

                    INNER JOIN
                        (
                            SELECT  parcela.cod_parcela
                                      , CASE WHEN arrecadacao.fn_atualiza_data_vencimento ( COALESCE( reemissao.vencimento, parcela.vencimento ))  < :data THEN
                                            COALESCE( reemissao.vencimento, parcela.vencimento )
                                        ELSE
                                            arrecadacao.fn_atualiza_data_vencimento ( COALESCE( reemissao.vencimento, parcela.vencimento ) )
                                        END AS vencimento
                                      , parcela.valor
                                      , parcela.nr_parcela
                                      , parcela.cod_lancamento

                               FROM arrecadacao.parcela

                                 JOIN arrecadacao.carne
                                   ON carne.cod_parcela = parcela.cod_parcela
                                 AND carne.numeracao = :numeracao

                         LEFT JOIN
                                (          SELECT parcela_reemissao.timestamp
                                             , parcela_reemissao.cod_parcela
                                             , parcela_reemissao.vencimento
                                         FROM arrecadacao.parcela_reemissao
                                   INNER JOIN (SELECT MIN(parcela_reemissao.timestamp) as timestamp
                                                    , parcela_reemissao.cod_parcela
                                                 FROM arrecadacao.parcela_reemissao
                                                 JOIN arrecadacao.parcela
                                                   ON parcela.cod_parcela = parcela_reemissao.cod_parcela
                                                 JOIN arrecadacao.carne
                                                   ON carne.cod_parcela = parcela.cod_parcela
                                                WHERE carne.numeracao = :numeracao
                                             GROUP BY parcela_reemissao.cod_parcela
                                             ) AS min_parcela_remissao
                                  ON parcela_reemissao.cod_parcela = min_parcela_remissao.cod_parcela
                                 AND parcela_reemissao.timestamp = min_parcela_remissao.timestamp

                                )AS reemissao
                            ON reemissao.cod_parcela = parcela.cod_parcela
                        ) AS parcela
                               ON parcela.cod_parcela = carne.cod_parcela

                    INNER JOIN arrecadacao.lancamento_calculo
                                ON lancamento_calculo.cod_lancamento = parcela.cod_lancamento

                    INNER JOIN divida.parcela_calculo
                                ON parcela_calculo.num_parcela = parcela.nr_parcela
                              AND parcela_calculo.cod_calculo = lancamento_calculo.cod_calculo

                    INNER JOIN divida.parcela AS dp
                                ON dp.num_parcelamento = parcela_calculo.num_parcelamento
                              AND dp.num_parcela = parcela_calculo.num_parcela

                    INNER JOIN divida.parcelamento
                                ON parcelamento.num_parcelamento = parcela_calculo.num_parcelamento

                    WHERE

     carne.numeracao= :numeracao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('numeracao', $params['numeracao']);
        $query->bindValue('data', $params['data']);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * Retorna codLote
     * @param  string  $numeracao
     * @return string or false
     */
    public function getCodLote($numeracao)
    {
        $sql = '
                    SELECT
                alc.cod_calculo,
                CASE
                    WHEN aec.inscricao_economica IS NOT NULL THEN aec.inscricao_economica
                    WHEN aic.inscricao_municipal IS NOT NULL THEN aic.inscricao_municipal
                END AS inscricao,
                apa.numcgm,
                (
                    SELECT
                        nom_cgm
                    FROM
                        sw_cgm
                    WHERE
                        sw_cgm.numcgm = apa.numcgm
                ) AS nomcgm,
                ap.nr_parcela,
                ap.valor AS valor_parcela,
                CASE
                    WHEN acgc.descricao IS NOT NULL THEN acgc.descricao||\'/\'||acgc.cod_grupo
                    WHEN mc.descricao_credito IS NOT NULL THEN mc.descricao_credito||\'/\'||mc.cod_credito||\'/\'||mc.cod_natureza||\'/\'||mc.cod_genero||\'/\'||mc.cod_especie
                END AS descricao_grupo_credito,
                aplm.numeracao AS num_carne,
                alot.cod_banco,
                alot.cod_agencia,
                ma.num_agencia,
                mb.num_banco  ,
                aplm.ocorrencia_pagamento,
                aplm.cod_convenio,
                alot.cod_lote,
                alot.exercicio

            FROM
                arrecadacao.pagamento_lote AS aplm

            inner join
                (
                     SELECT
                        cod_lote,
                        exercicio
                    from
                        arrecadacao.pagamento_lote
                    group by cod_lote, exercicio having count(cod_lote) = 1
                ) AS tot_aplm
            ON
                tot_aplm.cod_lote = aplm.cod_lote
                AND tot_aplm.exercicio = aplm.exercicio

            inner join
                arrecadacao.lote AS alot
            on
                alot.cod_lote = aplm.cod_lote
                AND alot.exercicio = aplm.exercicio
                AND alot.automatico = FALSE

            inner join
                monetario.agencia ma
            on
                ma.cod_agencia = alot.cod_agencia
                and ma.cod_banco = alot.cod_banco

            inner join
                monetario.banco mb
            on
                mb.cod_banco = ma.cod_banco

            INNER JOIN
                arrecadacao.pagamento apa
            ON
                apa.numeracao = aplm.numeracao AND
                apa.cod_convenio = aplm.cod_convenio

            INNER JOIN
                arrecadacao.carne acr
            ON
                acr.numeracao = aplm.numeracao AND
                acr.cod_convenio = aplm.cod_convenio

            INNER JOIN
                arrecadacao.parcela ap
            ON
                acr.cod_parcela = ap.cod_parcela

            INNER JOIN
                arrecadacao.lancamento al
            ON
                al.cod_lancamento = ap.cod_lancamento

            INNER JOIN
                (
                    SELECT
                        max(cod_calculo) as cod_calculo,
                        cod_lancamento
                    FROM
                        arrecadacao.lancamento_calculo
                    GROUP BY
                        cod_lancamento
                ) alc
            ON
                alc.cod_lancamento = al.cod_lancamento

            LEFT JOIN
                (
                    SELECT
                        agc.cod_grupo,
                        agc.descricao,
                        acgc.cod_calculo
                    FROM
                        arrecadacao.calculo_grupo_credito as acgc,
                        arrecadacao.grupo_credito as agc
                    WHERE
                        agc.cod_grupo = acgc.cod_grupo
                        AND agc.ano_exercicio = acgc.ano_exercicio
                ) acgc
            ON
                acgc.cod_calculo = alc.cod_calculo

            INNER JOIN
                arrecadacao.calculo ac
            ON
                ac.cod_calculo = alc.cod_calculo

            LEFT JOIN
                monetario.credito as mc
            ON
                mc.cod_credito = ac.cod_credito AND
                mc.cod_natureza = ac.cod_natureza AND
                mc.cod_genero = ac.cod_genero AND
                mc.cod_especie = ac.cod_especie

            LEFT JOIN
                arrecadacao.imovel_calculo AS aic
            ON
                ac.cod_calculo = aic.cod_calculo

            LEFT JOIN
                arrecadacao.cadastro_economico_calculo AS aec
            ON
                ac.cod_calculo = aec.cod_calculo

        WHERE
        aplm.numeracao = :numeracao

        --aplm.cod_lote = 33

        --ma.num_agencia = \'999999\'

        -- apa.numcgm = 2497

        -- aic.inscricao_municipal = 33

        --aec.inscricao_economica = 10895
        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('numeracao', $numeracao, \PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        return ($result ? $result->cod_lote : false);
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function getParcelasAVencer(array $filtro = [])
    {
        $query = "
            SELECT DISTINCT
                            ap.cod_parcela,
                            (
                                SELECT
                                    carne.exercicio
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS exercicio,
                            COALESCE( ddi.inscricao_municipal, dde.inscricao_economica ) AS inscricao,
                            ddc.numcgm AS numcgm,
                            (
                                SELECT
                                    nom_cgm
                                FROM
                                    sw_cgm
                                WHERE
                                    sw_cgm.numcgm = ddc.numcgm
                            )AS nom_cgm,
                            ddpar.vlr_parcela AS valor_parcela,
                            to_char(ddpar.dt_vencimento_parcela, 'dd/mm/yyyy') AS vencimento_parcela_br,
                            ddpar.dt_vencimento_parcela,
                            ddp.num_parcelamento,
                            ddp.numero_parcelamento,
                            ddpar.num_parcela,
                            (
                                SELECT
                                    carne.numeracao
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS numeracao,
                            (
                                SELECT
                                    carne.exercicio
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS impresso,
                            alc.cod_lancamento,
                            ap.cod_parcela,
                            (
                                SELECT
                                    carne.cod_convenio
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS cod_convenio,
                            (
                                SELECT
                                    carne.cod_carteira
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS cod_carteira,
                            CASE WHEN ddpar.num_parcela = 0 THEN
                                'única'
                            ELSE (
                                SELECT
                                    ddpar.num_parcela ||'/'|| count(*) ::text
                                FROM
                                    divida.parcela
                                WHERE
                                    parcela.num_parcelamento = dp.num_parcelamento
                                    AND parcela.num_parcela != 0
                            )
                            END AS info_parcela,
                            arrecadacao.buscaVinculoLancamento ( alc.cod_lancamento, dda.exercicio::integer )::varchar as vinculo,
                            arrecadacao.buscaIdVinculo( alc.cod_lancamento, dda.exercicio::integer )::varchar as id_vinculo,
                            md5(arrecadacao.buscaVinculoLancamento ( alc.cod_lancamento, dda.exercicio::integer ))::varchar as chave_vinculo,
                            ddp.judicial

                        FROM
                            divida.divida_ativa AS dda

                        LEFT JOIN
                            divida.divida_imovel AS ddi
                        ON
                            ddi.cod_inscricao = dda.cod_inscricao
                            AND ddi.exercicio = dda.exercicio

                        LEFT JOIN
                            divida.divida_empresa AS dde
                        ON
                            dde.cod_inscricao = dda.cod_inscricao
                            AND dde.exercicio = dda.exercicio

                        INNER JOIN
                            divida.divida_cgm AS ddc
                        ON
                            ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio

                        INNER JOIN
                            divida.divida_parcelamento AS dp
                        ON
                            dp.cod_inscricao = dda.cod_inscricao
                            AND dp.exercicio = dda.exercicio

                        INNER JOIN
                            divida.parcelamento  AS ddp
                        ON
                            ddp.num_parcelamento = dp.num_parcelamento

                        INNER JOIN
                            divida.parcela AS ddpar
                        ON
                            ddpar.num_parcelamento = dp.num_parcelamento
                            AND ddpar.cancelada = false
                            AND ddpar.paga = false

                        INNER JOIN
                            divida.parcela_calculo AS dpc
                        ON
                            dpc.num_parcelamento = ddpar.num_parcelamento
                            AND dpc.num_parcela = ddpar.num_parcela

                        INNER JOIN
                            arrecadacao.calculo AS ac
                        ON
                            ac.cod_calculo = dpc.cod_calculo

                        INNER JOIN
                            arrecadacao.lancamento_calculo AS alc
                        ON
                            alc.cod_calculo = ac.cod_calculo

                        INNER JOIN
                            arrecadacao.parcela AS ap
                        ON
                            ap.cod_lancamento = alc.cod_lancamento
                            AND ap.nr_parcela = dpc.num_parcela

                        INNER JOIN
                            arrecadacao.carne AS acne
                        ON
                            acne.cod_parcela = ap.cod_parcela

                        LEFT JOIN
                            divida.divida_cancelada AS ddcanc
                        ON
                            ddcanc.cod_inscricao = dda.cod_inscricao
                            AND ddcanc.exercicio = dda.exercicio

                        LEFT JOIN
                            divida.divida_remissao AS ddrem
                        ON
                            ddrem.cod_inscricao = dda.cod_inscricao
                            AND ddrem.exercicio = dda.exercicio

                        WHERE
                            ddcanc.cod_inscricao IS NULL
                            AND ddrem.cod_inscricao IS NULL
                            AND ddpar.dt_vencimento_parcela >= CURRENT_TIMESTAMP
                            %s
     ORDER BY ddp.numero_parcelamento, ap.cod_parcela, ddpar.num_parcela";

        $where = '';
        if (!empty($filtro['numeracao'])) {
            $where .= sprintf("AND acne.numeracao = '%s'\n", $filtro['numeracao']);
        }

        if (!empty($filtro['cgm'])) {
            $where .= sprintf("AND ddc.cgm = %d\n", $filtro['cgm']);
        }

        if (!empty($filtro['inscricaoMunicipal'])) {
            $where .= sprintf("AND ddi.inscricao_municipal = %d\n", $filtro['inscricaoMunicipal']);
        }

        if (!empty($filtro['cadastroEconomico'])) {
            $where .= sprintf("AND dde.inscricao_economica = %d\n", $filtro['cadastroEconomico']);
        }

        if (!empty($filtro['inscricaoAno'])) {
            list($inscricao, $exercicio) = explode('/', $filtro['inscricaoAno']);
            $where .= sprintf("AND dda.inscricao = %d AND dda.exercicio = '%s'\n", $inscricao, $ano);
        }

        if (!empty($filtro['cobrancaAno'])) {
            list($parcela, $exercicio) = explode('/', $filtro['cobrancaAno']);
            $where .= sprintf("AND acne.cod_parcela = %d AND acne.exercicio = '%s'\n", $parcela, $ano);
        }

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare(sprintf($query, $where));
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_UNIQUE);
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function getParcelasVencidas(array $filtro = [])
    {
        $query = "
            SELECT DISTINCT
                            ap.cod_parcela,
                            (
                                SELECT
                                    carne.exercicio
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS exercicio,
                            COALESCE( ddi.inscricao_municipal, dde.inscricao_economica ) AS inscricao,
                            ddc.numcgm AS numcgm,
                            (
                                SELECT
                                    nom_cgm
                                FROM
                                    sw_cgm
                                WHERE
                                    sw_cgm.numcgm = ddc.numcgm
                            )AS nom_cgm,
                            ddpar.vlr_parcela AS valor_parcela,
                            to_char(ddpar.dt_vencimento_parcela, 'dd/mm/yyyy') AS vencimento_parcela_br,
                            ddpar.dt_vencimento_parcela,
                            ddp.num_parcelamento,
                            ddp.numero_parcelamento,
                            ddpar.num_parcela,
                            (
                                SELECT
                                    carne.numeracao
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS numeracao,
                            (
                                SELECT
                                    carne.exercicio
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS impresso,
                            alc.cod_lancamento,
                            ap.cod_parcela,
                            (
                                SELECT
                                    carne.cod_convenio
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS cod_convenio,
                            (
                                SELECT
                                    carne.cod_carteira
                                FROM
                                    arrecadacao.carne
                                WHERE
                                    carne.cod_parcela = ap.cod_parcela
                                ORDER BY
                                    carne.timestamp DESC
                                LIMIT 1
                            )AS cod_carteira,
                            CASE WHEN ddpar.num_parcela = 0 THEN
                                'única'
                            ELSE (
                                SELECT
                                    ddpar.num_parcela ||'/'|| count(*) ::text
                                FROM
                                    divida.parcela
                                WHERE
                                    parcela.num_parcelamento = dp.num_parcelamento
                                    AND parcela.num_parcela != 0
                            )
                            END AS info_parcela,
                            arrecadacao.buscaVinculoLancamento ( alc.cod_lancamento, dda.exercicio::integer )::varchar as vinculo,
                            arrecadacao.buscaIdVinculo( alc.cod_lancamento, dda.exercicio::integer )::varchar as id_vinculo,
                            md5(arrecadacao.buscaVinculoLancamento ( alc.cod_lancamento, dda.exercicio::integer ))::varchar as chave_vinculo,
                            ddp.judicial

                        FROM
                            divida.divida_ativa AS dda

                        LEFT JOIN
                            divida.divida_imovel AS ddi
                        ON
                            ddi.cod_inscricao = dda.cod_inscricao
                            AND ddi.exercicio = dda.exercicio

                        LEFT JOIN
                            divida.divida_empresa AS dde
                        ON
                            dde.cod_inscricao = dda.cod_inscricao
                            AND dde.exercicio = dda.exercicio

                        INNER JOIN
                            divida.divida_cgm AS ddc
                        ON
                            ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio

                        INNER JOIN
                            divida.divida_parcelamento AS dp
                        ON
                            dp.cod_inscricao = dda.cod_inscricao
                            AND dp.exercicio = dda.exercicio

                        INNER JOIN
                            divida.parcelamento  AS ddp
                        ON
                            ddp.num_parcelamento = dp.num_parcelamento

                        INNER JOIN
                            divida.parcela AS ddpar
                        ON
                            ddpar.num_parcelamento = dp.num_parcelamento
                            AND ddpar.cancelada = false
                            AND ddpar.paga = false

                        INNER JOIN
                            divida.parcela_calculo AS dpc
                        ON
                            dpc.num_parcelamento = ddpar.num_parcelamento
                            AND dpc.num_parcela = ddpar.num_parcela

                        INNER JOIN
                            arrecadacao.calculo AS ac
                        ON
                            ac.cod_calculo = dpc.cod_calculo

                        INNER JOIN
                            arrecadacao.lancamento_calculo AS alc
                        ON
                            alc.cod_calculo = ac.cod_calculo

                        INNER JOIN
                            arrecadacao.parcela AS ap
                        ON
                            ap.cod_lancamento = alc.cod_lancamento
                            AND ap.nr_parcela = dpc.num_parcela

                        INNER JOIN
                            arrecadacao.carne AS acne
                        ON
                            acne.cod_parcela = ap.cod_parcela

                        LEFT JOIN
                            divida.divida_cancelada AS ddcanc
                        ON
                            ddcanc.cod_inscricao = dda.cod_inscricao
                            AND ddcanc.exercicio = dda.exercicio

                        LEFT JOIN
                            divida.divida_remissao AS ddrem
                        ON
                            ddrem.cod_inscricao = dda.cod_inscricao
                            AND ddrem.exercicio = dda.exercicio

                        WHERE
                            ddcanc.cod_inscricao IS NULL
                            AND ddrem.cod_inscricao IS NULL
                            AND ddpar.dt_vencimento_parcela < CURRENT_TIMESTAMP
                            %s
     ORDER BY ddp.numero_parcelamento, ap.cod_parcela, ddpar.num_parcela";

        $where = '';
        if (!empty($filtro['numeracao'])) {
            $where .= sprintf("AND acne.numeracao = '%s'\n", $filtro['numeracao']);
        }

        if (!empty($filtro['cgm'])) {
            $where .= sprintf("AND ddc.cgm = %d\n", $filtro['cgm']);
        }

        if (!empty($filtro['inscricaoMunicipal'])) {
            $where .= sprintf("AND ddi.inscricao_municipal = %d\n", $filtro['inscricaoMunicipal']);
        }

        if (!empty($filtro['cadastroEconomico'])) {
            $where .= sprintf("AND dde.inscricao_economica = %d\n", $filtro['cadastroEconomico']);
        }

        if (!empty($filtro['inscricaoAno'])) {
            list($inscricao, $ano) = explode('/', $filtro['inscricaoAno']);
            $where .= sprintf("AND dda.inscricao = %d AND dda.exercicio = '%s'\n", $inscricao, $ano);
        }

        if (!empty($filtro['cobrancaAno'])) {
            list($parcela, $ano) = explode('/', $filtro['cobrancaAno']);
            $where .= sprintf("AND acne.cod_parcela = %d AND acne.exercicio = '%s'\n", $parcela, $ano);
        }

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare(sprintf($query, $where));
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_UNIQUE);
    }

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        $sql = "
            select distinct cnpj from
                (
                select
                    carne.numeracao,
                    ap.vencimento,
                    acc.numcgm,
                    substring( cnpj, 1, 2 )|| '.' || substring( cnpj, 3, 3 )|| '.' || substring( cnpj, 6, 3 )|| '/' || substring( cnpj, 9, 4 )|| '-' || substring( cnpj, 13, 2 ) as cnpj,
                    (
                        case
                            when apag.numeracao is not null then apag.pagamento_tipo
                            else case
                                when acd.devolucao_data is not null then acd.devolucao_descricao
                                else case
                                    when ap.nr_parcela = 0
                                    and(
                                        ap.vencimento < '2007-12-31'
                                    ) then 'Cancelada (Parcela Única vencida)'
                                    else 'Em Aberto'
                                end
                            end
                        end
                    )::varchar as situacao
                from
                    arrecadacao.carne as carne
                    inner join arrecadacao.parcela as ap on
                    ap.cod_parcela = carne.cod_parcela inner join arrecadacao.lancamento as al on
                    al.cod_lancamento = ap.cod_lancamento inner join arrecadacao.lancamento_calculo as alc on
                    alc.cod_lancamento = al.cod_lancamento
                          INNER JOIN arrecadacao.calculo as ac
                          ON ac.cod_calculo = alc.cod_calculo
                          INNER JOIN arrecadacao.calculo_cgm as acc
                          ON acc.cod_calculo = ac.cod_calculo
                          INNER JOIN sw_cgm_pessoa_juridica as scpj
                          ON scpj.numcgm = acc.numcgm
                          LEFT JOIN (
                              SELECT
                                  apag.numeracao
                                  , apag.cod_convenio
                                  , apag.observacao
                                  , atp.pagamento as tp_pagamento
                                  , apag.data_pagamento as pagamento_data
                                  , to_char(apag.data_baixa,'dd/mm/YYYY') as pagamento_data_baixa
                                  , app.cod_processo::varchar||'/'||app.ano_exercicio as processo_pagamento
                                  , cgm.numcgm as pagamento_cgm
                                  , cgm.nom_cgm as pagamento_nome
                                  , atp.nom_tipo as pagamento_tipo
                                  , apag.valor as pagamento_valor
                                  , apag.ocorrencia_pagamento
                              FROM
                           arrecadacao.pagamento as apag
                                  INNER JOIN sw_cgm as cgm
                                  ON cgm.numcgm = apag.numcgm
                                  INNER JOIN arrecadacao.tipo_pagamento as atp
                                  ON atp.cod_tipo = apag.cod_tipo
                                  LEFT JOIN arrecadacao.processo_pagamento as app
                                  ON app.numeracao = apag.numeracao AND app.cod_convenio = apag.cod_convenio
                          ) as apag
                          ON apag.numeracao = carne.numeracao
                          AND apag.cod_convenio = carne.cod_convenio
                          LEFT JOIN (
                              SELECT
                                  acd.numeracao
                                  , acd.cod_convenio
                                  , acd.dt_devolucao as devolucao_data
                                  , amd.descricao as devolucao_descricao
                              FROM
                                  arrecadacao.carne_devolucao as acd
                                  INNER JOIN arrecadacao.motivo_devolucao as amd
                                  ON amd.cod_motivo = acd.cod_motivo
                          ) as acd
                          ON acd.numeracao = carne.numeracao
                          AND acd.cod_convenio = carne.cod_convenio
                              WHERE
                                  apag.pagamento_data is null and
                                  devolucao_data is null      and
                                  scpj.cnpj is not null       and
                                  ap.vencimento < now()
                              ) as consulta
                               WHERE situacao = 'Em Aberto'
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /*
     * @param $codCredito
     * @param $codEspecie
     * @param $codGenero
     * @param $codNatureza
     * @return bool|string
     */
    public function getCodConvenio($codCredito, $codEspecie, $codGenero, $codNatureza)
    {
        $sql = sprintf(
            "
            SELECT DISTINCT
              mc.cod_credito,
              mn.cod_natureza,
              mn.nom_natureza,
              mg.cod_genero,
              mg.nom_genero,
              me.cod_especie,
              me.nom_especie,
              mc.descricao_credito,
              mc.cod_convenio,
              mcc.cod_conta_corrente,
              afdc.cod_modulo,
              afdc.cod_funcao,
              afdc.cod_biblioteca,
              afdc.nom_funcao

            FROM
              monetario.credito as mc
              LEFT JOIN
              monetario.regra_desoneracao_credito AS mrdc
                ON
                  mrdc.cod_credito = mc.cod_credito
                  AND mrdc.cod_especie = mc.cod_especie
                  AND mrdc.cod_natureza = mc.cod_natureza
                  AND mrdc.cod_genero = mc.cod_genero
              LEFT JOIN
              administracao.funcao AS afdc
                ON
                  afdc.cod_modulo = mrdc.cod_modulo
                  AND afdc.cod_funcao = mrdc.cod_funcao
                  AND afdc.cod_biblioteca = mrdc.cod_biblioteca
              LEFT JOIN
              monetario.credito_conta_corrente AS mcc
                ON
                  mcc.cod_credito = mc.cod_credito AND mcc.cod_genero = mc.cod_genero AND mcc.cod_natureza = mc.cod_natureza AND mcc.cod_especie = mc.cod_especie
              INNER JOIN
              monetario.especie_credito as me  ON mc.cod_natureza = me.cod_natureza
                                                  AND mc.cod_genero = me.cod_genero AND mc.cod_especie=me.cod_especie
              INNER JOIN
              monetario.genero_credito as mg ON me.cod_natureza = mg.cod_natureza
                                                AND me.cod_genero = mg.cod_genero
              INNER JOIN
              monetario.natureza_credito as mn ON mg.cod_natureza = mn.cod_natureza
            WHERE
              mc.cod_credito = '%s' AND
              me.cod_especie = '%s' AND
              mg.cod_genero = '%s' AND
              mn.cod_natureza = '%d'
            ORDER BY mc.cod_credito;
        ",
            str_pad($codCredito, 3, '0', STR_PAD_LEFT),
            str_pad($codEspecie, 3, '0', STR_PAD_LEFT),
            str_pad($codGenero, 2, '0', STR_PAD_LEFT),
            $codNatureza
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchColumn(8);
    }

    /**
     * @param $codConvenio
     * @return bool|string
     */
    public function getCodCarteira($codConvenio)
    {
        $sql = sprintf(
            "
            SELECT DISTINCT
              ccc.cod_agencia,
              ccc.cod_banco,
              ccc.cod_convenio,
              ccc.cod_conta_corrente,
              mcc.num_conta_corrente,
              ban.cod_banco,
              ban.nom_banco,
              ban.num_banco,
              ag.cod_agencia,
              ag.num_agencia,
              ag.nom_agencia,
              ca.cod_carteira,
              ca.variacao,
              con.taxa_bancaria,
              con.cedente,
              con.cod_tipo,
              con.num_convenio,
              tc.nom_tipo,
              tc.cod_modulo,
              tc.cod_biblioteca,
              tc.cod_funcao
            FROM
              monetario.conta_corrente_convenio as ccc
              INNER JOIN
              monetario.conta_corrente as mcc
                ON
                  mcc.cod_conta_corrente = ccc.cod_conta_corrente
              INNER JOIN
              monetario.banco as ban
                ON
                  ban.cod_banco = ccc.cod_banco
              INNER JOIN
              monetario.agencia as ag
                ON
                  ag.cod_banco = ccc.cod_banco
                  AND
                  ag.cod_agencia = ccc.cod_agencia
              INNER JOIN
              monetario.convenio as con
                ON
                  ccc.cod_convenio = con.cod_convenio
              INNER JOIN
              monetario.tipo_convenio as tc
                ON
                  con.cod_tipo = tc.cod_tipo
              LEFT JOIN
              monetario.carteira as ca
                ON ca.cod_convenio = con.cod_convenio
            WHERE  con.cod_convenio = %s;
        ",
            $codConvenio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchColumn(11);
    }

    /**
     * @param $codConvenio
     * @param $codCarteira
     * @return bool|string
     */
    public function getNumeracao($codConvenio, $codCarteira)
    {
        ($codConvenio) ? $codConvenio = (string) $codConvenio : $codConvenio = '';
        ($codCarteira) ? $codCarteira = (string) $codCarteira : $codCarteira = '';

        $sql = sprintf("SELECT numeracaobradesco('%s','%s') as valor;", $codCarteira, $codConvenio);
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchColumn(0);
    }

    /**
     * @param array $filtro
     * @return array
     */
    public function getBaixaManualByContribuinte($filter = null)
    {
        $sql = "
          SELECT todos.* FROM (
         SELECT
               TABELA.cod_lancamento
             , TABELA.nr_parcela
             , TABELA.vencimento
             , TABELA.numeracao
             , TABELA.exercicio
             , TABELA.cod_carteira
             , TABELA.cod_convenio
             , TABELA.numcgm
             , TABELA.nom_cgm
             , TABELA.cod_credito
             , TABELA.cod_natureza
             , TABELA.cod_genero
             , TABELA.cod_especie
             , TABELA.descricao_credito
             , TABELA.convenio_atual
             , TABELA.inscricao_economica
             , TABELA.inscricao_municipal
             , TABELA.inscricao
             , TABELA.carteira_atual
             , TABELA.info_parcela
             , TABELA.numeracao_migrada
             , TABELA.cod_grupo
             , TABELA.origem
             , TABELA.situacao
             , TABELA.valida
             , SUM(TABELA.valor_normal)  as valor
         FROM (
             select
                   CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                        al.cod_lancamento
                   ELSE
                        NULL
                   END AS cod_lancamento
                 , apar.cod_parcela
                 , CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                        apar.nr_parcela
                   ELSE
                        1
                   END AS nr_parcela
                 , COALESCE(aparr.valor, apar.valor) as valor_normal
                 , CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                        CASE WHEN aparr.vencimento IS NOT NULL THEN
                            to_char(aparr.vencimento,'dd/mm/YYYY')
                        ELSE
                            to_char(apar.vencimento,'dd/mm/YYYY')
                        END
                   ELSE
                        to_char(apar.vencimento,'dd/mm/YYYY')
                   END AS vencimento
                 , CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NOT NULL THEN
                        max(carne_consolidacao.numeracao_consolidacao)
                   ELSE
                        max(carne.numeracao)
                   END as numeracao
                 , carne.exercicio
                 , carne.cod_carteira
                 , carne.cod_convenio
                 , sw_cgm.numcgm
                 , sw_cgm.nom_cgm
                 , credito.cod_credito
                 , credito.cod_natureza
                 , credito.cod_genero
                 , credito.cod_especie
                 , credito.descricao_credito
                 , credito.cod_convenio as convenio_atual
                 , cec.inscricao_economica
                 , aic.inscricao_municipal
                 , ( CASE WHEN cec.inscricao_economica IS NOT NULL THEN
                         cec.inscricao_economica
                     WHEN aic.inscricao_municipal IS NOT NULL THEN
                         aic.inscricao_municipal
                     END
                 ) AS inscricao

                 , ( SELECT credito_carteira.cod_carteira
                     FROM monetario.credito_carteira
                     WHERE credito_carteira.cod_credito  = credito.cod_credito
                     and credito_carteira.cod_convenio = credito.cod_convenio
                     and credito_carteira.cod_natureza = credito.cod_natureza
                     and credito_carteira.cod_genero   = credito.cod_genero
                     and credito_carteira.cod_especie  = credito.cod_especie
                 )  as carteira_atual
                 , CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                        arrecadacao.fn_info_parcela( apar.cod_parcela )
                   ELSE
                        '1/1'
                   END AS info_parcela

                , arrecadacao.fn_numeracao_migrada(carne.numeracao) as numeracao_migrada

                , acgc.cod_grupo
                , ( CASE WHEN acgc.cod_grupo is not null THEN
                         acgc.cod_grupo ||' - '||agc.descricao
                     ELSE
                         credito.cod_credito ||' - '|| credito.descricao_credito
                     END
                ) as origem

                , arrecadacao.fn_situacao_carne(carne.numeracao,'f') as situacao
                , ( CASE WHEN apar.nr_parcela = 0
                        AND arrecadacao.fn_situacao_carne(carne.numeracao,'f') = 'Vencida'
                        AND baixa_manual_unica.valor = 'nao'
                    THEN
                        false
                    ELSE
                        true
                    END
                ) as valida

             FROM

                    arrecadacao.lancamento as al

                    INNER JOIN (
                        SELECT
                            max (alc.cod_calculo) as cod_calculo
                            , alc.cod_lancamento
                        FROM
                            arrecadacao.lancamento_calculo as alc
                        GROUP BY
                            alc.cod_lancamento
                    ) as alc
                    ON alc.cod_lancamento = al.cod_lancamento

                    INNER JOIN arrecadacao.calculo as ac
                    ON ac.cod_calculo = alc.cod_calculo

                    INNER JOIN monetario.credito
                    ON ac.cod_credito     = credito.cod_credito
                    and ac.cod_natureza    = credito.cod_natureza
                    and ac.cod_genero      = credito.cod_genero
                    and ac.cod_especie     = credito.cod_especie

                    LEFT join arrecadacao.imovel_calculo aic
                    ON aic.cod_calculo = ac.cod_calculo

                    LEFT join arrecadacao.cadastro_economico_calculo cec
                    ON cec.cod_calculo = ac.cod_calculo

                    INNER JOIN arrecadacao.calculo_cgm
                    ON calculo_cgm.cod_calculo = ac.cod_calculo

                    INNER JOIN sw_cgm
                    ON sw_cgm.numcgm = calculo_cgm.numcgm

                    INNER JOIN arrecadacao.parcela as apar
                    ON apar.cod_lancamento = al.cod_lancamento


                    LEFT JOIN (
                        select
                            exercicio
                            , valor
                        from administracao.configuracao
                        WHERE parametro = 'baixa_manual' AND cod_modulo = 25
                    ) as baixa_manual_unica
                    ON baixa_manual_unica.exercicio = ac.exercicio


                    LEFT JOIN (
                        SELECT
                            apr.vencimento
                            , apr.cod_parcela
                            , apr.valor
                        FROM
                            arrecadacao.parcela_reemissao apr
                            INNER JOIN (
                                SELECT
                                    MIN(app.timestamp) AS timestamp,
                                    app.cod_parcela
                                FROM
                                    arrecadacao.parcela_reemissao AS app
                                GROUP BY cod_parcela
                            )AS ap
                            ON ap.timestamp = apr.timestamp
                            and ap.cod_parcela = apr.cod_parcela
                    )as aparr
                    ON aparr.cod_parcela = apar.cod_parcela


                    INNER JOIN arrecadacao.carne as carne
                    ON carne.cod_parcela = apar.cod_parcela
                    AND carne.exercicio = ac.exercicio

                    LEFT JOIN arrecadacao.carne_consolidacao
                    ON carne.numeracao = carne_consolidacao.numeracao
                    AND carne.cod_convenio = carne_consolidacao.cod_convenio

                    LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
                    ON acgc.cod_calculo = ac.cod_calculo
                    AND acgc.ano_exercicio = ac.exercicio
                    LEFT JOIN arrecadacao.grupo_credito agc
                    ON agc.cod_grupo = acgc.cod_grupo
                    AND agc.ano_exercicio = acgc.ano_exercicio
                    LEFT JOIN administracao.modulo admm
                    ON admm.cod_modulo = agc.cod_modulo

                    WHERE %s and carne.cod_convenio != -1

                GROUP BY

                    carne.numeracao
                    , carne.exercicio
                    , carne.cod_carteira
                    , carne.cod_convenio
                    , apar.cod_parcela
                    , apar.nr_parcela
                    , apar.valor
                    , aparr.valor
                    , apar.vencimento
                    , al.cod_lancamento
                    , aparr.vencimento
                    , sw_cgm.numcgm
                    , sw_cgm.nom_cgm
                    , credito.cod_credito
                    , credito.cod_natureza
                    , credito.cod_genero
                    , credito.cod_especie
                    , credito.cod_convenio
                    , credito.descricao_credito
                    , aic.inscricao_municipal
                    , cec.inscricao_economica
                    , acgc.cod_grupo
                    , agc.descricao
                    , baixa_manual_unica.valor

            ) as TABELA

            WHERE  ( TABELA.situacao = 'A Vencer' or TABELA.situacao = 'Vencida' )
             group by cod_lancamento
                    , nr_parcela
                    , vencimento
                    , numeracao
                    , exercicio
                    , cod_carteira
                    , cod_convenio
                    , numcgm
                    , nom_cgm
                    , cod_credito
                    , cod_natureza
                    , cod_genero
                    , cod_especie
                    , descricao_credito
                    , convenio_atual
                    , inscricao_economica
                    , inscricao_municipal
                    , inscricao
                    , carteira_atual
                    , info_parcela
                    , numeracao_migrada
                    , cod_grupo
                    , origem
                    , situacao
                    , valida  ) as todos
             LEFT JOIN arrecadacao.pagamento
             ON todos.numeracao = pagamento.numeracao
             AND todos.cod_convenio = pagamento.cod_convenio
              WHERE pagamento.numeracao is null
             order by todos.inscricao, todos.numcgm, todos.cod_lancamento, todos.nr_parcela
            ";

        $condition = [];

        if ($filter['contribuinte']['value']) {
            $condition[] = 'sw_cgm.numcgm = :contribuinte';
        }

        //grupoCreditos
        if ($filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']) {
            $condition[] = 'acgc.cod_grupo = :codGrupoCreditos';
        }
        //creditos
        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $condition[] = 'ac.cod_credito = :codCredito and ac.cod_especie = :codEspecie and ac.cod_genero = :codGenero and ac.cod_natureza = :codNatureza';
        }

        if ($filter['exercicio']['value']) {
            $condition[] = 'ac.exercicio = :exercicio';
        }

        if ($filter['numeracao']['value']) {
            $condition[] = '(carne.numeracao = :numeracao or carne_consolidacao.numeracao_consolidacao = :numeracaoConsolidacao)';
        }

        $sql = sprintf($sql, implode(' AND ', $condition));
        $query = $this->_em->getConnection()->prepare($sql);

        //contribuinte
        if ($filter['contribuinte']['value']) {
            $query->bindValue('contribuinte', $filter['contribuinte']['value'], \PDO::PARAM_INT);
        }

        //grupoCreditos
        if ($filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']) {
            $pieces = explode('~', $filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']);
            $query->bindValue('codGrupoCreditos', $pieces[0], \PDO::PARAM_INT);
        }

        //creditos
        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $pieces = explode('~', $filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']);
            $query->bindValue('codCredito', $pieces[0], \PDO::PARAM_INT);
            $query->bindValue('codEspecie', $pieces[1], \PDO::PARAM_INT);
            $query->bindValue('codGenero', $pieces[2], \PDO::PARAM_INT);
            $query->bindValue('codNatureza', $pieces[3], \PDO::PARAM_INT);
        }

        if ($filter['exercicio']['value']) {
            $query->bindValue('exercicio', $filter['exercicio']['value'], \PDO::PARAM_STR);
        }

        if ($filter['numeracao']['value']) {
            $query->bindValue('numeracao', $filter['numeracao']['value'], \PDO::PARAM_STR);
            $query->bindValue('numeracaoConsolidacao', $filter['numeracao']['value'], \PDO::PARAM_STR);
        }

        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function getBaixaManualByImobiliario($filter = null)
    {
        $sql = '
            SELECT
                    TABELA.cod_lancamento,
                    --TABELA.cod_parcela,
                    TABELA.nr_parcela,
                    TABELA.vencimento,
                    TABELA.numeracao,
                    TABELA.exercicio,
                    TABELA.cod_carteira,
                    TABELA.cod_convenio,
                    TABELA.numcgm,
                    TABELA.nom_cgm,
                    TABELA.cod_credito,
                    TABELA.cod_natureza,
                    TABELA.cod_genero,
                    TABELA.cod_especie,
                    TABELA.descricao_credito,
                    TABELA.convenio_atual,
                    TABELA.inscricao,
                    TABELA.inscricao_municipal,
                    TABELA.carteira_atual,
                    TABELA.info_parcela,
                    TABELA.numeracao_migrada,
                    TABELA.cod_grupo,
                    TABELA.origem,
                    TABELA.situacao,
                    TABELA.valida,
                    sum(TABELA.valor_normal) as valor
            FROM (
                select
                       CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                            al.cod_lancamento
                       ELSE
                            NULL
                       END AS cod_lancamento
                    , apar.cod_parcela
                    , CASE WHEN max(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                            apar.nr_parcela
                      ELSE
                            1
                      END AS nr_parcela
                    , COALESCE(aparr.valor, apar.valor) as valor_normal
                    , CASE WHEN max(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                            ( CASE WHEN aparr.vencimento IS NOT NULL THEN
                                    to_char(aparr.vencimento,\'dd/mm/YYYY\')
                                ELSE
                                    to_char(apar.vencimento,\'dd/mm/YYYY\')
                                END
                            )
                      ELSE
                            to_char(apar.vencimento,\'dd/mm/YYYY\')
                      END AS vencimento
                    , CASE WHEN max(carne_consolidacao.numeracao_consolidacao) IS NOT NULL THEN
                            max(carne_consolidacao.numeracao_consolidacao)
                      ELSE
                            max(carne.numeracao)
                      END AS numeracao
            --        , max(carne.numeracao) as numeracao
                    , ac.exercicio
                    , carne.cod_carteira
                    , carne.cod_convenio
                    , CAST((SELECT array_to_string( ARRAY( select numcgm from sw_cgm where numcgm IN ( SELECT numcgm FROM arrecadacao.calculo_cgm WHERE cod_calculo = ac.cod_calculo)), \'/\' ) ) AS VARCHAR) AS numcgm
                    , CAST((SELECT array_to_string( ARRAY( select nom_cgm from sw_cgm where numcgm IN ( SELECT numcgm FROM arrecadacao.calculo_cgm WHERE cod_calculo = ac.cod_calculo)), \'/\' ) ) AS VARCHAR) AS nom_cgm
                    , credito.cod_credito
                    , credito.cod_natureza
                    , credito.cod_genero
                    , credito.cod_especie
                    , credito.descricao_credito
                    , credito.cod_convenio as convenio_atual
                    , aic.inscricao_municipal as inscricao
                    , aic.inscricao_municipal
                    , ( SELECT credito_carteira.cod_carteira
                        FROM monetario.credito_carteira
                        WHERE credito_carteira.cod_credito  = credito.cod_credito
                        and credito_carteira.cod_convenio = credito.cod_convenio
                        and credito_carteira.cod_natureza = credito.cod_natureza
                        and credito_carteira.cod_genero   = credito.cod_genero
                        and credito_carteira.cod_especie  = credito.cod_especie
                    )  as carteira_atual
            --        , arrecadacao.fn_info_parcela( apar.cod_parcela ) as info_parcela

                    , CASE WHEN max(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                            arrecadacao.fn_info_parcela( apar.cod_parcela )
                      ELSE
                            \'1/1\'
                      END AS info_parcela

                    , arrecadacao.fn_numeracao_migrada(carne.numeracao) as numeracao_migrada

                    , acgc.cod_grupo
                    , ( CASE WHEN acgc.cod_grupo is not null THEN
                             acgc.cod_grupo ||\' - \'||agc.descricao
                         ELSE
                             credito.cod_credito ||\' - \'|| credito.descricao_credito
                         END
                    ) as origem

                    , arrecadacao.fn_situacao_carne(carne.numeracao,\'f\') as situacao
                    , ( CASE WHEN apar.nr_parcela = 0
                            AND arrecadacao.fn_situacao_carne(carne.numeracao,\'f\') = \'Vencida\'
                            AND baixa_manual_unica.valor = \'nao\'
                        THEN
                            false
                        ELSE
                            true
                        END
                    ) as valida
            --      , carne_consolidacao.numeracao_consolidacao
                 FROM

                        arrecadacao.lancamento as al

                        INNER JOIN (
                            SELECT
                                max (alc.cod_calculo) as cod_calculo
                                , alc.cod_lancamento
                            FROM
                                arrecadacao.lancamento_calculo as alc
                            GROUP BY
                                alc.cod_lancamento
                        ) as alc
                        ON alc.cod_lancamento = al.cod_lancamento

                        INNER JOIN arrecadacao.calculo as ac
                        ON ac.cod_calculo = alc.cod_calculo

                        INNER JOIN monetario.credito
                        ON ac.cod_credito     = credito.cod_credito
                        and ac.cod_natureza    = credito.cod_natureza
                        and ac.cod_genero      = credito.cod_genero
                        and ac.cod_especie     = credito.cod_especie

                        INNER JOIN arrecadacao.imovel_calculo as aic
                        ON aic.cod_calculo = ac.cod_calculo

                        INNER JOIN arrecadacao.parcela as apar
                        ON apar.cod_lancamento = al.cod_lancamento


                        LEFT JOIN (
                            select
                                exercicio
                                , valor
                            from administracao.configuracao
                            WHERE parametro = \'baixa_manual_unica\' AND cod_modulo = 25
                        ) as baixa_manual_unica
                        ON baixa_manual_unica.exercicio = ac.exercicio


                        LEFT JOIN (
                            SELECT
                                apr.vencimento
                                , apr.cod_parcela
                                , apr.valor
                            FROM
                                arrecadacao.parcela_reemissao apr
                                INNER JOIN (
                                    SELECT
                                        MIN(app.timestamp) AS timestamp,
                                        app.cod_parcela
                                    FROM
                                        arrecadacao.parcela_reemissao AS app
                                    GROUP BY cod_parcela
                                )AS ap
                                ON ap.timestamp = apr.timestamp
                                and ap.cod_parcela = apr.cod_parcela
                        )as aparr
                        ON aparr.cod_parcela = apar.cod_parcela


                        INNER JOIN arrecadacao.carne as carne
                        ON carne.cod_parcela = apar.cod_parcela

                        LEFT JOIN arrecadacao.carne_consolidacao
                        ON carne.numeracao = carne_consolidacao.numeracao
                        AND carne.cod_convenio = carne_consolidacao.cod_convenio

                        LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
                        ON acgc.cod_calculo = ac.cod_calculo

                        LEFT JOIN arrecadacao.grupo_credito agc
                        ON agc.cod_grupo = acgc.cod_grupo
                        AND agc.ano_exercicio = acgc.ano_exercicio

                        LEFT JOIN administracao.modulo admm
                        ON admm.cod_modulo = agc.cod_modulo

                        WHERE %s and carne.cod_convenio != -1

                    GROUP BY

                        carne.numeracao
                        , ac.exercicio
                        , ac.cod_calculo
                        , carne.cod_carteira
                        , carne.cod_convenio
                        , apar.cod_parcela
                        , apar.nr_parcela
                        , aparr.valor
                        , apar.valor
                        , apar.vencimento
                        , al.cod_lancamento
                        , aparr.vencimento
                        , credito.cod_credito
                        , credito.cod_natureza
                        , credito.cod_genero
                        , credito.cod_especie
                        , credito.cod_convenio
                        , credito.descricao_credito
                        , aic.inscricao_municipal
                        , acgc.cod_grupo
                        , agc.descricao
                        , baixa_manual_unica.valor

                ) AS TABELA

                WHERE
                 ( TABELA.situacao = \'A Vencer\' or TABELA.situacao = \'Vencida\' )  group by cod_lancamento
                         , nr_parcela
                         , vencimento
                         , numeracao
                         , exercicio
                         , cod_carteira
                         , cod_convenio
                         , numcgm
                         , nom_cgm
                         , cod_credito
                         , cod_natureza
                         , cod_genero
                         , cod_especie
                         , descricao_credito
                         , convenio_atual
                         , inscricao
                         , inscricao_municipal
                         , carteira_atual
                         , info_parcela
                         , numeracao_migrada
                         , cod_grupo
                         , origem
                         , situacao
                         , valida
                 order by TABELA.inscricao, TABELA.numcgm, TABELA.cod_lancamento, TABELA.nr_parcela
                ';

        $condition = [];
        if ($filter['inscricaoMunicipal']['value']) {
            $condition[] = 'aic.inscricao_municipal = :inscricaoMunicipal';
        }

        //grupoCreditos
        if ($filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']) {
            $condition[] = 'acgc.cod_grupo = :codGrupoCreditos';
        }
        //creditos
        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $condition[] = 'ac.cod_credito = :codCredito and ac.cod_especie = :codEspecie and ac.cod_genero = :codGenero and ac.cod_natureza = :codNatureza';
        }

        if ($filter['exercicio']['value']) {
            $condition[] = 'ac.exercicio = :exercicio';
        }

        if ($filter['numeracao']['value']) {
            $condition[] = '(carne.numeracao = :numeracao or carne_consolidacao.numeracao_consolidacao = :numeracaoConsolidacao)';
        }

        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $condition[] = 'calculo.cod_credito = :codCredito and calculo.cod_especie = :codEspecie and calculo.cod_genero = :codGenero and calculo.cod_natureza = :codNatureza';
        }

        $sql = sprintf($sql, implode(' AND ', $condition));
        $query = $this->_em->getConnection()->prepare($sql);

        if ($filter['inscricaoMunicipal']['value']) {
            $query->bindValue('inscricaoMunicipal', $filter['inscricaoMunicipal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['exercicio']['value']) {
            $query->bindValue('exercicio', $filter['exercicio']['value'], \PDO::PARAM_STR);
        }

        if ($filter['numeracao']['value']) {
            $query->bindValue('numeracao', $filter['numeracao']['value'], \PDO::PARAM_STR);
            $query->bindValue('numeracaoConsolidacao', $filter['numeracao']['value'], \PDO::PARAM_STR);
        }

        //grupoCreditos
        if ($filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']) {
            $pieces = explode('~', $filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']);
            $query->bindValue('codGrupoCreditos', $pieces[0], \PDO::PARAM_INT);
        }

        //creditos
        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $pieces = explode('~', $filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']);
            $query->bindValue('codCredito', $pieces[0], \PDO::PARAM_INT);
            $query->bindValue('codEspecie', $pieces[1], \PDO::PARAM_INT);
            $query->bindValue('codGenero', $pieces[2], \PDO::PARAM_INT);
            $query->bindValue('codNatureza', $pieces[3], \PDO::PARAM_INT);
        }

        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function getBaixaManualByEconomico($filter = null)
    {
        $sql = "SELECT
           TABELA.cod_lancamento
         , TABELA.nr_parcela
         , TABELA.vencimento
         , TABELA.numeracao
         , TABELA.exercicio
         , TABELA.cod_carteira
         , TABELA.cod_convenio
         , TABELA.numcgm
         , TABELA.nom_cgm
         , TABELA.cod_credito
         , TABELA.cod_natureza
         , TABELA.cod_genero
         , TABELA.cod_especie
         , TABELA.descricao_credito
         , TABELA.convenio_atual
         , TABELA.inscricao
         , TABELA.inscricao_economica
         , TABELA.carteira_atual
         , TABELA.info_parcela
         , TABELA.numeracao_migrada
         , TABELA.origem
         , TABELA.situacao
         , TABELA.valida
         , SUM(TABELA.valor_normal) as valor
     FROM (
         select
               CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                    al.cod_lancamento
               ELSE
                    NULL
               END AS cod_lancamento
             , apar.cod_parcela
             , CASE WHEN max(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                    apar.nr_parcela
               ELSE
                    1
               END AS nr_parcela
             , COALESCE(aparr.valor, apar.valor) as valor_normal
             , CASE WHEN max(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                    ( CASE WHEN aparr.vencimento IS NOT NULL THEN
                            to_char(aparr.vencimento,'dd/mm/YYYY')
                        ELSE
                            to_char(apar.vencimento,'dd/mm/YYYY')
                        END
                    )
              ELSE
                    to_char(apar.vencimento,'dd/mm/YYYY')
              END AS vencimento
             , CASE WHEN max(carne_consolidacao.numeracao_consolidacao) IS NOT NULL THEN
                    max(carne_consolidacao.numeracao_consolidacao)
               ELSE
                    max(carne.numeracao)
               END AS numeracao
             , ac.exercicio
             , carne.cod_carteira
             , carne.cod_convenio
             , sw_cgm.numcgm
             , sw_cgm.nom_cgm
             , credito.cod_credito
             , credito.cod_natureza
             , credito.cod_genero
             , credito.cod_especie
             , credito.descricao_credito
             , credito.cod_convenio as convenio_atual
             , cec.inscricao_economica as inscricao
             , cec.inscricao_economica
             , ( SELECT credito_carteira.cod_carteira
                 FROM monetario.credito_carteira
                 WHERE credito_carteira.cod_credito  = credito.cod_credito
                 and credito_carteira.cod_convenio = credito.cod_convenio
                 and credito_carteira.cod_natureza = credito.cod_natureza
                 and credito_carteira.cod_genero   = credito.cod_genero
                 and credito_carteira.cod_especie  = credito.cod_especie
             )  as carteira_atual
             , CASE WHEN max(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                    CASE WHEN apar.nr_parcela = 0 THEN
                        'Única'
                    ELSE
                        (apar.nr_parcela::varchar||'/'|| count(apar.nr_parcela))--arrecadacao.fn_total_parcelas(al.cod_lancamento))::varchar
                    END
               ELSE
                    '1/1'
               END AS info_parcela

            , arrecadacao.fn_numeracao_migrada(carne.numeracao) as numeracao_migrada

            , acgc.cod_grupo
            , ( CASE WHEN acgc.cod_grupo is not null THEN
                     acgc.cod_grupo ||' - '||agc.descricao
                 ELSE
                     credito.cod_credito ||' - '|| credito.descricao_credito
                 END
            ) as origem

            , arrecadacao.fn_situacao_carne(carne.numeracao,'f') as situacao
            , ( CASE WHEN apar.nr_parcela = 0
                    AND arrecadacao.fn_situacao_carne(carne.numeracao,'f') = 'Vencida'
                    AND baixa_manual_unica.valor = 'nao'
                THEN
                    false
                ELSE
                    true
                END
            ) as valida

         FROM

                arrecadacao.lancamento as al

                INNER JOIN (
                    SELECT
                        max (alc.cod_calculo) as cod_calculo
                        , alc.cod_lancamento
                    FROM
                        arrecadacao.lancamento_calculo as alc
                    GROUP BY
                        alc.cod_lancamento
                ) as alc
                ON alc.cod_lancamento = al.cod_lancamento

                INNER JOIN arrecadacao.calculo as ac
                ON ac.cod_calculo = alc.cod_calculo

                INNER JOIN monetario.credito
                ON ac.cod_credito     = credito.cod_credito
                and ac.cod_natureza    = credito.cod_natureza
                and ac.cod_genero      = credito.cod_genero
                and ac.cod_especie     = credito.cod_especie

                INNER JOIN arrecadacao.cadastro_economico_calculo as cec
                ON cec.cod_calculo = ac.cod_calculo

                INNER JOIN arrecadacao.calculo_cgm
                ON calculo_cgm.cod_calculo = cec.cod_calculo

                INNER JOIN sw_cgm
                ON sw_cgm.numcgm = calculo_cgm.numcgm

                INNER JOIN arrecadacao.parcela as apar
                ON apar.cod_lancamento = al.cod_lancamento


                LEFT JOIN (
                    select
                        exercicio
                        , valor
                    from administracao.configuracao
                    WHERE parametro = 'baixa_manual' AND cod_modulo = 25
                ) as baixa_manual_unica
                ON baixa_manual_unica.exercicio = ac.exercicio


                LEFT JOIN (
                    SELECT
                        apr.vencimento
                        , apr.cod_parcela
                        , apr.valor
                    FROM
                        arrecadacao.parcela_reemissao apr
                        INNER JOIN (
                            SELECT
                                MIN(app.timestamp) AS timestamp,
                                app.cod_parcela
                            FROM
                                arrecadacao.parcela_reemissao AS app
                            GROUP BY cod_parcela
                        )AS ap
                        ON ap.timestamp = apr.timestamp
                        and ap.cod_parcela = apr.cod_parcela
                )as aparr
                ON aparr.cod_parcela = apar.cod_parcela


                INNER JOIN arrecadacao.carne as carne
                ON carne.cod_parcela = apar.cod_parcela

                LEFT JOIN arrecadacao.carne_consolidacao
                ON carne.numeracao = carne_consolidacao.numeracao
                AND carne.cod_convenio = carne_consolidacao.cod_convenio

                LEFT JOIN arrecadacao.pagamento
                ON carne.numeracao = pagamento.numeracao
                AND pagamento.cod_convenio = carne.cod_convenio

                LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
                ON acgc.cod_calculo = ac.cod_calculo
                AND acgc.ano_exercicio = ac.exercicio
                LEFT JOIN arrecadacao.grupo_credito agc
                ON agc.cod_grupo = acgc.cod_grupo
                AND agc.ano_exercicio = acgc.ano_exercicio
                --LEFT JOIN administracao.modulo admm
                --ON admm.cod_modulo = agc.cod_modulo



                WHERE %s and carne.cod_convenio != -1


            GROUP BY

                carne.numeracao
                , ac.exercicio
                , carne.cod_carteira
                , carne.cod_convenio
                , apar.cod_parcela
                , apar.nr_parcela
                , apar.valor
                , aparr.valor
                , apar.vencimento
                , al.cod_lancamento
                , aparr.vencimento
                , sw_cgm.numcgm
                , sw_cgm.nom_cgm
                , credito.cod_credito
                , credito.cod_natureza
                , credito.cod_genero
                , credito.cod_especie
                , credito.cod_convenio
                , credito.descricao_credito
                , cec.inscricao_economica
                , acgc.cod_grupo
                , agc.descricao
                , baixa_manual_unica.valor

        ) AS TABELA

        WHERE
         ( TABELA.situacao = 'A Vencer' or TABELA.situacao = 'Vencida' )  group by cod_lancamento
                , nr_parcela
                , vencimento
                , numeracao
                , exercicio
                , cod_carteira
                , cod_convenio
                , numcgm
                , nom_cgm
                , cod_credito
                , cod_natureza
                , cod_genero
                , cod_especie
                , descricao_credito
                , convenio_atual
                , inscricao
                , inscricao_economica
                , carteira_atual
                , info_parcela
                , numeracao_migrada
                , origem
                , situacao
                , valida
         order by TABELA.inscricao, TABELA.numcgm, TABELA.cod_lancamento, TABELA.nr_parcela
        ";

        $condition = [];

        if ($filter['fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico']['value']) {
            $condition[] = 'cec.inscricao_economica = :inscricaoEconomica';
        }

        //grupoCreditos
        if ($filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']) {
            $condition[] = 'acgc.cod_grupo = :codGrupoCreditos';
        }
        //creditos
        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $condition[] = 'ac.cod_credito = :codCredito and ac.cod_especie = :codEspecie and ac.cod_genero = :codGenero and ac.cod_natureza = :codNatureza';
        }

        if ($filter['exercicio']['value']) {
            $condition[] = 'ac.exercicio = :exercicio';
        }

        if ($filter['numeracao']['value']) {
            $condition[] = '(carne.numeracao = :numeracao or carne_consolidacao.numeracao_consolidacao = :numeracaoConsolidacao)';
        }

        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $condition[] = 'calculo.cod_credito = :codCredito and calculo.cod_especie = :codEspecie and calculo.cod_genero = :codGenero and calculo.cod_natureza = :codNatureza';
        }

        $sql = sprintf($sql, implode(' AND ', $condition));
        $query = $this->_em->getConnection()->prepare($sql);

        if ($filter['fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico']['value']) {
            $query->bindValue('inscricaoEconomica', $filter['fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico']['value'], \PDO::PARAM_INT);
        }

        if ($filter['exercicio']['value']) {
            $query->bindValue('exercicio', $filter['exercicio']['value'], \PDO::PARAM_STR);
        }

        if ($filter['numeracao']['value']) {
            $query->bindValue('numeracao', $filter['numeracao']['value'], \PDO::PARAM_STR);
            $query->bindValue('numeracaoConsolidacao', $filter['numeracao']['value'], \PDO::PARAM_STR);
        }

        //grupoCreditos
        if ($filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']) {
            $pieces = explode('~', $filter['fkArrecadacaoPagamentos__fkArrecadacaoPagamentoCalculos__calculo__fkArrecadacaoCalculoGrupoCredito__fkArrecadacaoGrupoCredito']['value']);
            $query->bindValue('codGrupoCreditos', $pieces[0], \PDO::PARAM_INT);
        }

        //creditos
        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $pieces = explode('~', $filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']);
            $query->bindValue('codCredito', $pieces[0], \PDO::PARAM_INT);
            $query->bindValue('codEspecie', $pieces[1], \PDO::PARAM_INT);
            $query->bindValue('codGenero', $pieces[2], \PDO::PARAM_INT);
            $query->bindValue('codNatureza', $pieces[3], \PDO::PARAM_INT);
        }

        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function getBaixaManualByDividaAtiva($filter = null)
    {
        $sql  = "SELECT tabela.cod_lancamento
                    , tabela.inscricao
--                    , tabela.cod_parcela
                    , tabela.nr_parcela
--                    , tabela.valor_normal
                    , tabela.vencimento
                    , tabela.numeracao
                    , tabela.cod_convenio
                    , tabela.cod_carteira
                    , tabela.numcgm
                    , tabela.nom_cgm
                    , tabela.info_parcela
                    , tabela.numeracao_migrada
                    , tabela.origem
                    , CASE WHEN tabela.nr_parcela         = 0
                            AND tabela.situacao           = 'Vencida'
                            AND tabela.baixa_manual_unica = 'nao' THEN
                            FALSE
                      ELSE
                            TRUE
                      END AS valida
                    , tabela.numero_parcelamento
                    , tabela.exercicio
                    , CASE WHEN tabela.situacao = 'Vencida' THEN
                          SUM(tabela.valor_normal)::numeric(14,2)
                      ELSE
                          SUM(arrecadacao.buscaValorParcela(tabela.cod_parcela))::numeric(14,2)
                      END AS valor
                FROM (
                           select distinct CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                                      lancamento.cod_lancamento
                                  ELSE
                                      NULL
                                  END AS cod_lancamento
                                , lista_inscricao_imob_eco_cgm_por_num_parcelamento( parcelamento.num_parcelamento )    AS inscricao
                                , parcela.cod_parcela
                                , CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                                        parcela.nr_parcela
                                  ELSE
                                        1
                                  END AS nr_parcela
                                , parcela.valor                                                                         AS valor_normal
                                , CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                                        ( CASE WHEN busca_primeira_reemissao(parcela.cod_parcela) IS NOT NULL THEN
                                                to_char(busca_primeira_reemissao(parcela.cod_parcela),'dd/mm/YYYY')
                                            ELSE
                                                to_char(parcela.vencimento,'dd/mm/YYYY')
                                            END
                                        )
                                  ELSE
                                        to_char(parcela.vencimento,'dd/mm/YYYY')
                                  END AS vencimento
                                , CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NOT NULL THEN
                                        max(carne_consolidacao.numeracao_consolidacao)
                                  ELSE
                                        max(carne.numeracao)
                                  END AS numeracao
                                , carne.cod_convenio
                                , carne.cod_carteira
                                , calculo_cgm.numcgm
                                , (
                                    SELECT nom_cgm
                                      FROM sw_cgm
                                     WHERE sw_cgm.numcgm = calculo_cgm.numcgm
                                )                                                                                       AS nom_cgm
                                , CASE WHEN MAX(carne_consolidacao.numeracao_consolidacao) IS NULL THEN
                                      CASE WHEN parcela.nr_parcela = 0 THEN
                                          'Única'
                                      ELSE
                                          (parcela.nr_parcela::varchar||'/'|| arrecadacao.fn_total_parcelas(lancamento.cod_lancamento))::varchar
                                      END
                                  ELSE
                                        '1/1'
                                  END AS info_parcela
                                , (
                                    SELECT numeracao_migracao
                                      FROM arrecadacao.carne_migracao
                                     WHERE numeracao = carne.numeracao
                                  )                                                                                     AS numeracao_migrada
                                , parcelamento.numero_parcelamento                                                      AS origem
                                , arrecadacao.fn_situacao_carne(carne.numeracao,'f')                                    AS situacao
                                , parcelamento.numero_parcelamento
                                , parcelamento.exercicio
                                , baixa_manual_unica.valor                                                              AS baixa_manual_unica
                             FROM divida.parcelamento
                       INNER JOIN divida.parcela_origem
                               ON parcela_origem.num_parcelamento = parcelamento.num_parcelamento
                       INNER JOIN divida.divida_parcelamento
                               ON parcelamento.num_parcelamento = divida.divida_parcelamento.num_parcelamento
                        LEFT JOIN divida.divida_cancelada
                               ON divida_cancelada.cod_inscricao = divida_parcelamento.cod_inscricao
                              AND divida_cancelada.exercicio = divida_parcelamento.exercicio
                       INNER JOIN divida.parcela AS divida_parcela
                               ON divida_parcela.num_parcelamento = divida_parcelamento.num_parcelamento
                              AND divida_parcela.paga = false
                              AND divida_parcela.cancelada = false
                       INNER JOIN divida.parcela_calculo
                               ON parcela_calculo.num_parcelamento = divida_parcela.num_parcelamento
                              AND parcela_calculo.num_parcela      = divida_parcela.num_parcela
                       INNER JOIN arrecadacao.calculo
                               ON calculo.cod_calculo = parcela_calculo.cod_calculo
                       INNER JOIN arrecadacao.calculo_cgm
                               ON calculo_cgm.cod_calculo = calculo.cod_calculo
                       INNER JOIN arrecadacao.lancamento_calculo
                               ON lancamento_calculo.cod_calculo = calculo.cod_calculo
                       INNER JOIN arrecadacao.lancamento
                               ON lancamento.cod_lancamento = lancamento_calculo.cod_lancamento
                       INNER JOIN arrecadacao.parcela
                               ON parcela.cod_lancamento = lancamento.cod_lancamento
                        LEFT JOIN (
                                    select exercicio
                                         , valor
                                      from administracao.configuracao
                                     WHERE parametro = 'baixa_manual'
                                       AND cod_modulo = 25
                                  ) AS baixa_manual_unica
                               ON baixa_manual_unica.exercicio = calculo.exercicio
                       INNER JOIN arrecadacao.carne
                               ON carne.cod_parcela = parcela.cod_parcela
                        LEFT JOIN arrecadacao.carne_consolidacao
                               ON carne_consolidacao.numeracao = carne.numeracao
                              AND carne_consolidacao.cod_convenio = carne.cod_convenio
                       INNER JOIN monetario.credito
                               ON calculo.cod_credito     = credito.cod_credito
                              and calculo.cod_natureza    = credito.cod_natureza
                              and calculo.cod_genero      = credito.cod_genero
                              and calculo.cod_especie     = credito.cod_especie

                            WHERE %s and divida_cancelada.cod_inscricao IS NULL

                         GROUP BY carne.numeracao
                                , carne.exercicio
                                , carne.cod_carteira
                                , carne.cod_convenio
                                , parcela.cod_parcela
                                , parcela.nr_parcela
                                , parcela.valor
                                , parcela.vencimento
                                , lancamento.cod_lancamento
                                , calculo_cgm.numcgm
                                , divida_parcelamento.cod_inscricao
                                , credito.cod_credito
                                , credito.cod_natureza
                                , credito.cod_genero
                                , credito.cod_especie
                                , credito.descricao_credito
                                , divida_parcelamento.exercicio
                                , baixa_manual_unica.valor
                                , parcelamento.numero_parcelamento
                                , parcelamento.num_parcelamento
                                , parcelamento.exercicio
                     ) AS TABELA

                     WHERE
                     ( TABELA.situacao = 'A Vencer' or TABELA.situacao = 'Vencida' )  GROUP BY cod_lancamento
                            , inscricao
                            , nr_parcela
                            , vencimento
                            , numeracao
                            , cod_convenio
                            , cod_carteira
                            , numcgm
                            , nom_cgm
                            , info_parcela
                            , numeracao_migrada
                            , origem
                            , valida
                            , numero_parcelamento
                            , exercicio
                            , situacao
                     order by TABELA.numero_parcelamento , TABELA.numcgm, TABELA.cod_lancamento, TABELA.nr_parcela
                     ";

        $condition = [];
        if ($filter['parcelamento']['value']) {
            $condition[] = 'parcelamento.numero_parcelamento = :parcelamento';
            $condition[] = 'parcelamento.exercicio = :exercicioParcelamento';
        }

        //creditos
        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $condition[] = 'calculo.cod_credito = :codCredito and calculo.cod_especie = :codEspecie and calculo.cod_genero = :codGenero and calculo.cod_natureza = :codNatureza';
        }

        if ($filter['numeracao']['value']) {
            $condition[] = '(carne.numeracao = :numeracao or carne_consolidacao.numeracao_consolidacao = :numeracaoConsolidacao)';
        }

        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $condition[] = 'calculo.cod_credito = :codCredito and calculo.cod_especie = :codEspecie and calculo.cod_genero = :codGenero and calculo.cod_natureza = :codNatureza';
        }

        $sql = sprintf($sql, implode(' AND ', $condition));
        $query = $this->_em->getConnection()->prepare($sql);

        if ($filter['parcelamento']['value']) {
            $pieces = explode('/', $filter['parcelamento']['value']);
            $query->bindValue('parcelamento', $pieces[0], \PDO::PARAM_STR);
            $query->bindValue('exercicioParcelamento', $pieces[1], \PDO::PARAM_STR);
        }

        if ($filter['numeracao']['value']) {
            $query->bindValue('numeracao', $filter['numeracao']['value'], \PDO::PARAM_STR);
            $query->bindValue('numeracaoConsolidacao', $filter['numeracao']['value'], \PDO::PARAM_STR);
        }
        //creditos
        if ($filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']) {
            $pieces = explode('~', $filter['fkMonetarioConvenio__fkMonetarioCreditos']['value']);
            $query->bindValue('codCredito', $pieces[0], \PDO::PARAM_INT);
            $query->bindValue('codEspecie', $pieces[1], \PDO::PARAM_INT);
            $query->bindValue('codGenero', $pieces[2], \PDO::PARAM_INT);
            $query->bindValue('codNatureza', $pieces[3], \PDO::PARAM_INT);
        }

        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
    * @param int $carne
    * @return array
    */
    public function getCalculosParcela($carne)
    {
        $sql = "SELECT DISTINCT
                        lancamento_calculo.cod_calculo,
                        (lancamento_calculo.valor * arrecadacao.calculaProporcaoParcela ( parcela.cod_parcela ))::numeric(14,2) AS valor_calculo,
                        COALESCE (
                            (
                                SELECT
                                    valor
                                FROM
                                    arrecadacao.parcela_desconto
                                WHERE
                                    cod_parcela = parcela.cod_parcela
                            ),
                            parcela.valor
                        ) AS valor_parcela,

                        COALESCE( aplica_multa ( carne.numeracao, carne.exercicio::int, parcela.cod_parcela, now()::date ) * arrecadacao.calculaProporcaoParcela ( parcela.cod_parcela ), 0.00 )::numeric(14,2) AS multa,
                        COALESCE( aplica_juro ( carne.numeracao, carne.exercicio::int, parcela.cod_parcela, now()::date ) * arrecadacao.calculaProporcaoParcela ( parcela.cod_parcela ), 0.00 )::numeric(14,2) AS juro,
                        COALESCE( aplica_correcao ( carne.numeracao, carne.exercicio::int, parcela.cod_parcela, now()::date ) * arrecadacao.calculaProporcaoParcela ( parcela.cod_parcela ), 0.00 )::numeric(14,2) AS correcao

                    FROM
                        arrecadacao.carne

                    INNER JOIN
                        arrecadacao.parcela
                    ON
                        parcela.cod_parcela = carne.cod_parcela

                    INNER JOIN
                        arrecadacao.lancamento_calculo
                    ON
                        lancamento_calculo.cod_lancamento = parcela.cod_lancamento

                    WHERE carne.numeracao = :carneNumeracao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('carneNumeracao', $carne, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
    * @param int $carne
    * @return array
    */
    public function getCalculosParcelaDA($carne)
    {
        $sql = "SELECT DISTINCT
                        to_char(parcela.vencimento, 'dd/mm/yyyy' ) AS vencimento
                        , (dp.vlr_parcela * arrecadacao.calculaProporcaoParcela ( parcela.cod_parcela ))::numeric(14,2) AS valor_calculo
                        , (split_part( aplica_acrescimo_modalidade( 0, divida_cgm.cod_inscricao, divida_cgm.exercicio::integer, parcelamento.cod_modalidade, 2, parcelamento.num_parcelamento, dp.vlr_parcela, parcela.vencimento, now()::date, 'true' ), ';', 1 )::numeric * arrecadacao.calculaProporcaoParcela ( parcela.cod_parcela ))::numeric(14,2) AS juro
                        , (split_part( aplica_acrescimo_modalidade( 0, divida_cgm.cod_inscricao, divida_cgm.exercicio::integer, parcelamento.cod_modalidade, 3, parcelamento.num_parcelamento, dp.vlr_parcela, parcela.vencimento, now()::date, 'true' ), ';', 1 )::numeric * arrecadacao.calculaProporcaoParcela ( parcela.cod_parcela ))::numeric(14,2) AS multa
                        , (split_part( aplica_acrescimo_modalidade( 0, divida_cgm.cod_inscricao, divida_cgm.exercicio::integer, parcelamento.cod_modalidade, 1, parcelamento.num_parcelamento, dp.vlr_parcela, parcela.vencimento, now()::date, 'true' ), ';', 1 )::numeric * arrecadacao.calculaProporcaoParcela ( parcela.cod_parcela ))::numeric(14,2) AS correcao
                        , split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 ), '§', 3)||'/'||split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 ), '§', 4) AS origem
                        , carne.numeracao
                        , carne.exercicio
                        , parcela.nr_parcela
                    FROM
                        arrecadacao.carne

                    INNER JOIN
                        arrecadacao.parcela
                    ON
                        parcela.cod_parcela = carne.cod_parcela

                    INNER JOIN
                        arrecadacao.lancamento_calculo
                    ON
                        lancamento_calculo.cod_lancamento = parcela.cod_lancamento

                    INNER JOIN
                        divida.parcela_calculo
                    ON
                        parcela_calculo.num_parcela = parcela.nr_parcela
                        AND parcela_calculo.cod_calculo = lancamento_calculo.cod_calculo

                    INNER JOIN
                        divida.parcela AS dp
                    ON
                        dp.num_parcelamento = parcela_calculo.num_parcelamento
                        AND dp.num_parcela = parcela_calculo.num_parcela

                    INNER JOIN
                        divida.parcelamento
                    ON
                        parcelamento.num_parcelamento = parcela_calculo.num_parcelamento

                    INNER JOIN
                        divida.divida_parcelamento
                    ON
                        divida_parcelamento.num_parcelamento = parcelamento.num_parcelamento

                    INNER JOIN
                        divida.divida_cgm
                    ON
                        divida_cgm.cod_inscricao = divida_parcelamento.cod_inscricao
                        AND divida_cgm.exercicio = divida_parcelamento.exercicio

                    LEFT JOIN
                        divida.divida_imovel
                    ON
                        divida_imovel.cod_inscricao = divida_parcelamento.cod_inscricao
                        AND divida_imovel.exercicio = divida_parcelamento.exercicio

                    LEFT JOIN
                        divida.divida_empresa
                    ON
                        divida_empresa.cod_inscricao = divida_parcelamento.cod_inscricao
                        AND divida_empresa.exercicio = divida_parcelamento.exercicio

                    WHERE carne.numeracao = :carneNumeracao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('carneNumeracao', $carne, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
    * @param string $filtro
    * @return array
    */
    public function getParcelasLancamento($filtro)
    {
        $sql = "SELECT
            c.numeracao, c.cod_convenio, p.nr_parcela,
            arrecadacao.consultaCarneDevolucao(c.numeracao,c.cod_convenio) as devolucao,
            arrecadacao.consultaCarnePago(c.numeracao) as pago
            FROM
            arrecadacao.carne c
            INNER JOIN arrecadacao.parcela p ON p.cod_parcela = c.cod_parcela
            %s
            ";

        if ($filtro) {
            $sql = sprintf($sql, $filtro);
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
