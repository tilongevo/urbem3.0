<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170822175613 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE FUNCTION arrecadacao.fn_rl_periodico_arrecadacao(tipo character varying, data_ini date, data_fim date, credito_ini character varying, credito_fim character varying, grupo_ini character varying, grupo_fim character varying, imob_ini integer, imob_fim integer, econ_ini integer, econ_fim integer, cgm_ini integer, cgm_fim integer, cod_est_atividade_ini character varying, cod_est_atividade_fim character varying)
             RETURNS SETOF record
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                stSqlPrincipal  VARCHAR := \'\';
                stSqlAux        VARCHAR := \'\';
                reRecord        RECORD;
                nuSomatorio     NUMERIC(14,2);
                stFiltroPeriodo VARCHAR := \'\';
                stFiltroCredito VARCHAR := \'\';
                stFiltroGrupo   VARCHAR := \'\';
                stFiltroImob    VARCHAR := \'\';
                stFiltroEcon    VARCHAR := \'\';
                stFiltroCGM     VARCHAR := \'\';
                stFiltro        VARCHAR := \'\';
                stFiltroTmp     VARCHAR := \'\';
                stTabelaNome varchar :=to_char(now(),\'DDMMYYYYHH12MISS\');
            BEGIN
                IF DATA_FIM IS NULL THEN
                    stFiltroPeriodo:=\' AND PARCELA.VENCIMENTO =\'|| quote_literal(DATA_INI) ||\' \';
                ELSE
                    stFiltroPeriodo:=\' AND PARCELA.VENCIMENTO BETWEEN \'|| quote_literal(DATA_INI) ||\' AND \'|| quote_literal(DATA_FIM) ||\' \';
                END IF;
            
                IF CREDITO_INI != \'\' THEN
                    stFiltroCredito := stFiltroCredito ||\' (CREDITO.COD_CREDITO = \'|| SPLIT_PART(CREDITO_INI,\'.\',1) ||\'  AND\';
                    stFiltroCredito := stFiltroCredito ||\' CREDITO.COD_NATUREZA = \'|| SPLIT_PART(CREDITO_INI,\'.\',4) ||\'  AND\';
                    stFiltroCredito := stFiltroCredito ||\' CREDITO.COD_GENERO   = \'|| SPLIT_PART(CREDITO_INI,\'.\',3) ||\'  AND\';
                    stFiltroCredito := stFiltroCredito ||\' CREDITO.COD_ESPECIE  = \'|| SPLIT_PART(CREDITO_INI,\'.\',2) ||\')\';
                END IF;
                IF CREDITO_FIM != \'\' THEN
                    stFiltroTmp := stFiltroTmp ||\' (CREDITO.COD_CREDITO = \'|| SPLIT_PART(CREDITO_FIM,\'.\',1) ||\' AND\';
                    stFiltroTmp := stFiltroTmp ||\' CREDITO.COD_NATUREZA = \'|| SPLIT_PART(CREDITO_FIM,\'.\',4) ||\' AND\';
                    stFiltroTmp := stFiltroTmp ||\' CREDITO.COD_GENERO   = \'|| SPLIT_PART(CREDITO_FIM,\'.\',3) ||\' AND\';
                    stFiltroTmp := stFiltroTmp ||\' CREDITO.COD_ESPECIE  = \'|| SPLIT_PART(CREDITO_FIM,\'.\',2) ||\')\';
                END IF;
            
                IF CREDITO_INI != \'\' AND CREDITO_FIM != \'\' THEN
                    stFiltroCredito := \' AND (\'|| stFiltroCredito ||\' OR \'|| stFiltroTmp ||\')\';
                    stFiltroTmp:=\'\';
                ELSE
                    IF CREDITO_INI != \'\' OR CREDITO_FIM != \'\' THEN
                        stFiltroCredito := \' AND \'|| stFiltroCredito||stFiltroTmp;
                        stFiltroTmp:=\'\';
                    END IF;
                END IF;
            
                IF GRUPO_INI != \'\' THEN
                    stFiltroGrupo := stFiltroGrupo ||\' (GRUPO_CREDITO.COD_GRUPO = \'|| SPLIT_PART(GRUPO_INI,\'/\',1) ||\'  AND \';
                    stFiltroGrupo := stFiltroGrupo ||\' GRUPO_CREDITO.ANO_EXERCICIO = \'|| quote_literal(SPLIT_PART(GRUPO_INI,\'/\',2)) ||\')\';
                END IF;
                IF GRUPO_FIM != \'\' THEN
                    stFiltroTmp := stFiltroTmp ||\' (GRUPO_CREDITO.COD_GRUPO = \'|| SPLIT_PART(GRUPO_FIM,\'/\',1) ||\' AND \';
                    stFiltroTmp := stFiltroTmp ||\' GRUPO_CREDITO.ANO_EXERCICIO = \'|| quote_literal(SPLIT_PART(GRUPO_FIM,\'/\',2)) ||\')\';
                END IF;
            
                IF GRUPO_INI != \'\' AND GRUPO_FIM != \'\' THEN
                    stFiltroGrupo := \' AND (\'|| stFiltroGrupo ||\' OR \'|| stFiltroTmp ||\')\';
                    stFiltroTmp:=\'\';
                ELSE
                    IF GRUPO_INI != \'\' OR GRUPO_FIM != \'\' THEN
                        stFiltroGrupo := \' AND \'|| stFiltroGrupo||stFiltroTmp;
                        stFiltroTmp:=\'\';
                    END IF;
                END IF;
            
                IF IMOB_INI IS NOT NULL  THEN
                    IF IMOB_FIM IS NULL THEN
                        stFiltroImob:= \' AND IMOVEL_CALCULO.INSCRICAO_MUNICIPAL =\'|| IMOB_INI;
                    ELSE
                        stFiltroImob:= \' AND IMOVEL_CALCULO.INSCRICAO_MUNICIPAL  BETWEEN \'|| IMOB_INI ||\' AND \'|| IMOB_FIM;
                    END IF;
                END IF;
            
                IF ECON_INI IS NOT NULL THEN
                    IF ECON_FIM IS NULL THEN
                        stFiltroEcon:= \' AND CADASTRO_ECONOMICO_CALCULO.INSCRICAO_ECONOMICA = \'|| ECON_INI;
                    ELSE
                        stFiltroEcon:= \' AND CADASTRO_ECONOMICO_CALCULO.INSCRICAO_ECONOMICA BETWEEN \'|| ECON_INI ||\' AND \'|| ECON_FIM;
                    END IF;
                END IF;
            
                IF COD_EST_ATIVIDADE_INI IS NOT NULL THEN
                    IF COD_EST_ATIVIDADE_FIM IS NULL THEN
                        stFiltroEcon:= stFiltroEcon  ||\' AND atividade.cod_estrutural = \'|| quote_literal(COD_EST_ATIVIDADE_INI) ||\' \';
                    ELSE
                        stFiltroEcon:= stFiltroEcon  ||\' AND atividade.cod_estrutural BETWEEN \'|| quote_literal(COD_EST_ATIVIDADE_INI) ||\' AND \'|| quote_literal(COD_EST_ATIVIDADE_FIM) ||\' \';
                    END IF;
                END IF;
            
                IF CGM_INI IS NOT NULL THEN
                    IF CGM_FIM IS NULL THEN
                        stFiltroCGM:= \' AND CALCULO_CGM.NUMCGM = \'|| CGM_INI;
                    ELSE
                        stFiltroCGM:= \' AND CALCULO_CGM.NUMCGM BETWEEN \'|| CGM_INI ||\' AND \'|| CGM_FIM;
                    END IF;
                END IF;
            
                EXECUTE \'
                    CREATE TEMP TABLE TMP_1 AS
                    SELECT
                    --parcela
                        parcela.cod_parcela
                        ,parcela.cod_lancamento
                        ,parcela.nr_parcela
                        ,parcela.vencimento AS parcela_vencimento
                        ,parcela.valor
                    --cgm
                        ,ARRAY(
                            SELECT
                                SW_CGM.NUMCGM||\'\' - \'\'|| SW_CGM.NOM_CGM
                            FROM
                                ARRECADACAO.CALCULO_CGM
                            INNER JOIN
                                SW_CGM
                            ON
                                CALCULO_CGM.NUMCGM=SW_CGM.NUMCGM
                            WHERE
                                CALCULO_CGM.COD_CALCULO = CALCULO.COD_CALCULO
                        ) AS cgm
                    --lancamento
                        ,lancamento.vencimento AS lancamento_vencimento
                        ,lancamento.valor AS lancamento_valor
                        ,lancamento.total_parcelas
                        ,lancamento.ativo AS lancamento_ativo
                        ,lancamento.observacao
                        ,lancamento.observacao_sistema
                        ,lancamento.divida
                    --lancamento_calculo
                        ,lancamento_calculo.dt_lancamento
                        ,lancamento_calculo.valor AS lancamento_calculo_valor
                    --calculo
                        ,calculo.cod_calculo
                        ,calculo.exercicio
                        ,calculo.valor As calculo_valor
                        ,calculo.nro_parcelas
                        ,calculo.ativo AS calculo_ativo
                        ,calculo.timestamp AS calculo_timestamp
                        ,calculo.calculado
                    --monetario.credito
                        ,credito.cod_credito
                        ,credito.cod_especie
                        ,credito.cod_genero
                        ,credito.cod_natureza
                        ,credito.descricao_credito
                    --grupo_credito
                        ,grupo_credito.cod_grupo
                        ,grupo_credito.descricao AS descricao_grupo
                    --parcela_desconto
                        ,parcela_desconto.vencimento AS desconto_vencimento
                        ,parcela_desconto.valor AS desconto_valor
                    --carne
                        ,carne.numeracao
                    --carne_devoluvao
                        ,carne_devolucao.cod_motivo
                        ,carne_devolucao.dt_devolucao
                    --pagamento
                        ,pagamento.numcgm AS pagamento_numcgm
                        ,pagamento.data_baixa
                        ,pagamento.data_pagamento
                        ,pagamento.inconsistente
                        ,pagamento.valor AS pagamento_valor
                        ,pagamento.observacao AS pagamento_observacao
                    --tipo_pargamento
                        ,tipo_pagamento.cod_tipo
                        ,tipo_pagamento.nom_tipo
                        ,tipo_pagamento.nom_resumido
                        ,tipo_pagamento.sistema
                        ,tipo_pagamento.pagamento
                    FROM
                        arrecadacao.parcela
                    INNER JOIN
                        arrecadacao.lancamento
                    ON
                        parcela.cod_lancamento  = lancamento.cod_lancamento
                    INNER JOIN
                        arrecadacao.lancamento_calculo
                    ON
                        lancamento.cod_lancamento  = lancamento_calculo.cod_lancamento
                    INNER JOIN
                        arrecadacao.calculo
                    ON
                        lancamento_calculo.cod_calculo = calculo.cod_calculo
                    INNER JOIN
                        monetario.credito
                    ON
                        calculo.cod_credito  = credito.cod_credito
                        AND calculo.cod_especie  = credito.cod_especie
                        AND calculo.cod_genero   = credito.cod_genero
                        AND calculo.cod_natureza = credito.cod_natureza
                    LEFT JOIN
                        arrecadacao.imovel_calculo
                    ON
                        calculo.cod_calculo = imovel_calculo.cod_calculo
                    LEFT JOIN
                        arrecadacao.cadastro_economico_calculo
                    ON
                        calculo.cod_calculo = cadastro_economico_calculo.cod_calculo
            
                    LEFT JOIN
                        economico.atividade_cadastro_economico
                    ON
                        atividade_cadastro_economico.inscricao_economica = cadastro_economico_calculo.inscricao_economica
            
                    LEFT JOIN
                        economico.atividade
                    ON
                        atividade.cod_atividade = atividade_cadastro_economico.cod_atividade
            
                    LEFT JOIN
                        ARRECADACAO.CALCULO_GRUPO_CREDITO
                    ON
                        CALCULO.COD_CALCULO = CALCULO_GRUPO_CREDITO.COD_CALCULO
                    LEFT JOIN
                        ARRECADACAO.GRUPO_CREDITO
                    ON
                        CALCULO_GRUPO_CREDITO.COD_GRUPO = GRUPO_CREDITO.COD_GRUPO
                        AND CALCULO_GRUPO_CREDITO.ANO_EXERCICIO = GRUPO_CREDITO.ANO_EXERCICIO
                    LEFT JOIN
                        arrecadacao.parcela_desconto
                    ON
                        parcela.cod_parcela = parcela_desconto.cod_parcela
                    LEFT JOIN
                        arrecadacao.carne
                    ON
                        parcela.cod_parcela = carne.cod_parcela
                    LEFT JOIN
                        arrecadacao.carne_devolucao
                    ON
                        carne.numeracao = carne_devolucao.numeracao
                        AND carne.cod_convenio = carne_devolucao.cod_convenio
                    LEFT JOIN
                        arrecadacao.pagamento
                    ON
                        carne.numeracao = pagamento.numeracao
                        AND carne.cod_convenio = pagamento.cod_convenio
                    LEFT JOIN
                        arrecadacao.tipo_pagamento
                    ON
                        pagamento.cod_tipo = tipo_pagamento.cod_tipo
                    WHERE
                        EXISTS (
                                SELECT
                                    1
                                FROM
                                    ARRECADACAO.CALCULO_CGM
                                WHERE
                                    CALCULO_CGM.COD_CALCULO = CALCULO.COD_CALCULO
                                \'|| stFiltroCGM ||\'
                            )
                        AND calculo.ativo = \'\'t\'\'
                        AND lancamento.ativo = \'\'t\'\'
                        AND (tipo_pagamento.pagamento IS NULL OR tipo_pagamento.pagamento=TRUE)
                        AND carne_devolucao.cod_motivo IS NULL
                        \'|| stFiltroPeriodo||stFiltroImob||stFiltroEcon||stFiltroCredito||stFiltroGrupo ||\'
                GROUP BY
                        parcela.cod_parcela
                        ,parcela.cod_lancamento
                        ,parcela.nr_parcela
                        ,parcela.vencimento
                        ,parcela.valor
                    --cgm
                        ,cgm
                    --lancamento
                        ,lancamento.vencimento
                        ,lancamento.valor
                        ,lancamento.total_parcelas
                        ,lancamento.ativo
                        ,lancamento.observacao
                        ,lancamento.observacao_sistema
                        ,lancamento.divida
                    --lancamento_calculo
                        ,lancamento_calculo.dt_lancamento
                        ,lancamento_calculo.valor
                    --calculo
                        ,calculo.cod_calculo
                        ,calculo.exercicio
                        ,calculo.valor
                        ,calculo.nro_parcelas
                        ,calculo.ativo
                        ,calculo.timestamp
                        ,calculo.calculado
                    --monetario.credito
                        ,credito.cod_credito
                        ,credito.cod_especie
                        ,credito.cod_genero
                        ,credito.cod_natureza
                        ,credito.descricao_credito
                    --grupo_credito
                        ,grupo_credito.cod_grupo
                        ,grupo_credito.descricao
                    --parcela_desconto
                        ,parcela_desconto.vencimento
                        ,parcela_desconto.valor
                    --carne
                        ,carne.numeracao
                    --carne_devoluvao
                        ,carne_devolucao.cod_motivo
                        ,carne_devolucao.dt_devolucao
                    --pagamento
                        ,pagamento.numcgm
                        ,pagamento.data_baixa
                        ,pagamento.data_pagamento
                        ,pagamento.inconsistente
                        ,pagamento.valor
                        ,pagamento.observacao
                    --tipo_pargamento
                        ,tipo_pagamento.cod_tipo
                        ,tipo_pagamento.nom_tipo
                        ,tipo_pagamento.nom_resumido
                        ,tipo_pagamento.sistema
                        ,tipo_pagamento.pagamento\';
            
                EXECUTE \'
                        CREATE TEMP TABLE tmp_parcela_valida AS
                        SELECT
                            tmp_1.*
                        FROM
                            tmp_1
                        LEFT JOIN
                            --PARCELA 0 VALIDA
                            (
                             SELECT
                                 cod_parcela
                                 ,cod_lancamento
                                 ,nr_parcela
                             FROM
                                 tmp_1
                             WHERE
                                 nr_parcela=0
                                 AND ((parcela_vencimento>=TO_DATE(NOW()::varchar,\'\'yyyy-mm-dd\'\')
                                 AND cod_motivo IS NULL
                                 AND (data_pagamento IS NULL )) OR (total_parcelas = 0 ))
                             GROUP BY
                                  cod_parcela
                                 ,cod_lancamento
                                 ,nr_parcela
                            ) AS parcela_unica
                        ON
                            tmp_1.cod_lancamento = parcela_unica.cod_lancamento
                            AND tmp_1.nr_parcela    != parcela_unica.nr_parcela
                        LEFT JOIN
                            --PARCELA 0 INVALIDA
                            (
                             SELECT
                                 cod_parcela
                                 ,cod_lancamento
                                 ,nr_parcela
                             FROM
                                 tmp_1
                             WHERE
                                 nr_parcela=0
                                 AND parcela_vencimento<TO_DATE(NOW()::varchar,\'\'yyyy-mm-dd\'\')
                                 AND cod_motivo IS NULL
                                 AND ( data_pagamento IS NULL )
                                 AND total_parcelas > 0
                             GROUP BY
                                  cod_parcela
                                 ,cod_lancamento
                                 ,nr_parcela
                            ) AS parcela_unica_invalida
                        ON
                            tmp_1.cod_lancamento = parcela_unica_invalida.cod_lancamento
                            AND tmp_1.nr_parcela = parcela_unica_invalida.nr_parcela
                        WHERE
                            (1=1)
                            AND (
                                (tmp_1.nr_parcela > 0 AND parcela_unica.cod_parcela IS NULL) --elimina as parcelas que nÃ£o sÃ£o unicas
                            OR
                                (tmp_1.nr_parcela  = 0 AND parcela_unica_invalida.cod_parcela IS NULL) --elimina as parcelas unicas invalidas
                            )\';
            
            
            
            
                EXECUTE \'CREATE TEMP TABLE tmp_relatorio_periodico AS
                        SELECT
                            tmp_parcela_valida.*
                            --VALOR ORIGINAL DO CREDITO
                            ,CASE WHEN LANCAMENTO_VALOR > 0 THEN
                                (((VALOR / 100 ) * ( LANCAMENTO_CALCULO_VALOR * 100 / LANCAMENTO_VALOR ))::numeric(14,6))::numeric(14,2)
                            ELSE
                                0.00
                            END AS VALOR_CREDITO
                            --VALOR COM DESCONTO DO CREDITO
                            ,CASE WHEN desconto_valor IS NOT NULL AND LANCAMENTO_VALOR > 0 THEN
                                (((desconto_valor / 100 ) * ( LANCAMENTO_CALCULO_VALOR * 100 / LANCAMENTO_VALOR ))::numeric(14,6))::numeric(14,2)
                            ELSE
                                0.00
                            END AS VALOR_CREDITO_DESCONTO
                            --VALOR DO PAGAMENTO DO CREDITO
                            ,CASE WHEN pagamento_valor IS NOT NULL AND LANCAMENTO_VALOR > 0 THEN
                                (((pagamento_valor / 100 ) * ( LANCAMENTO_CALCULO_VALOR * 100 / LANCAMENTO_VALOR ))::numeric(14,6))::numeric(14,2)
                            ELSE
                                0.00
                            END AS VALOR_CREDITO_PAGAMENTO
                        FROM
                            tmp_parcela_valida\';
            
                EXECUTE \'CREATE TEMP TABLE TMP_ARREDONDA_CREDITO AS
                        SELECT
                                tmp_relatorio_periodico.cod_parcela,
                                ultimo_credito.cod_credito,
                                sum(VALOR_CREDITO) as VALOR_CREDITO,
                                sum(VALOR_CREDITO_DESCONTO) as VALOR_CREDITO_DESCONTO,
                                sum(VALOR_CREDITO_PAGAMENTO) as VALOR_CREDITO_PAGAMENTO
                        FROM
                                tmp_relatorio_periodico
                        INNER JOIN (
                        select
                                cod_parcela,
                                max(cod_credito) as cod_credito
                        from
                                tmp_relatorio_periodico
                        where
                                total_parcelas > 0
                        group by
                                cod_parcela ) AS ultimo_credito
                        ON
                                tmp_relatorio_periodico.cod_parcela = ultimo_credito.cod_parcela
                                AND tmp_relatorio_periodico.cod_credito !=  ultimo_credito.cod_credito
                        GROUP BY
                                tmp_relatorio_periodico.cod_parcela,
                                ultimo_credito.cod_credito\';
            
                EXECUTE \'update tmp_relatorio_periodico set
                                VALOR_CREDITO =  ( tmp_relatorio_periodico.VALOR - TMP_ARREDONDA_CREDITO.VALOR_CREDITO),
                                VALOR_CREDITO_DESCONTO = ( tmp_relatorio_periodico.desconto_valor - TMP_ARREDONDA_CREDITO.VALOR_CREDITO_DESCONTO ),
                                VALOR_CREDITO_PAGAMENTO = ( tmp_relatorio_periodico.pagamento_valor - TMP_ARREDONDA_CREDITO.VALOR_CREDITO_PAGAMENTO)
                        FROM
                                TMP_ARREDONDA_CREDITO
                        WHERE
                                tmp_relatorio_periodico.COD_CREDITO = TMP_ARREDONDA_CREDITO.COD_CREDITO
                                AND tmp_relatorio_periodico.COD_PARCELA = TMP_ARREDONDA_CREDITO.COD_PARCELA\';
            
            
                EXECUTE \'CREATE TEMP TABLE tmp_relatorio_formatado AS
                        SELECT
                            cod_parcela
                            ,cgm
                            ,cod_credito
                            ,CASE WHEN divida=TRUE THEN
                                \'\'D.A. \'\'|| descricao_credito
                            ELSE
                                descricao_credito
                            END AS descricao_credito
                            ,cod_grupo
                            ,descricao_grupo
            
                            ,CASE WHEN data_pagamento IS NOT NULL AND pagamento=TRUE  THEN
                                valor_credito_pagamento
                --            WHEN desconto_vencimento <= TO_DATE(NOW()::varchar,\'\'yyyy-mm-dd\'\') THEN
                --                valor_credito_desconto
                            ELSE
                                valor_credito
                            END AS valor
            
                            ,COALESCE(valor_credito_pagamento,0.00) AS valor_credito_pagamento
            
                            ,CASE WHEN data_pagamento IS NOT NULL AND pagamento=TRUE  THEN
                                valor_credito_pagamento
                            ELSE
                                0.00
                            END AS valor_recebido
            
                            ,CASE WHEN (data_pagamento IS NULL OR pagamento=FALSE) AND parcela_vencimento < TO_DATE(NOW()::varchar,\'\'yyyy-mm-dd\'\') THEN
                                valor_credito
                            ELSE
                                0.00
                            END AS valor_vencido
            
                            ,CASE WHEN (data_pagamento IS NULL OR pagamento=FALSE )AND parcela_vencimento >= TO_DATE(NOW()::varchar,\'\'yyyy-mm-dd\'\') THEN
                                valor_credito
                            ELSE
                                0.00
                            END AS valor_receber
                        FROM
                            tmp_relatorio_periodico\';
            
            
            
                IF TIPO = \'SINTETICO\' THEN
                    stSqlPrincipal:=\'
                                    SELECT
                                        cod_grupo AS cod
                                        ,descricao_grupo AS descricao
                                        ,sum(valor) as valor
                                        ,sum(valor_credito_pagamento) as recebido
                                        ,sum(valor_vencido) as vencido
                                        ,sum(valor_receber) as receber
                                    from
                                        tmp_relatorio_formatado
                                    where cod_grupo is not null
                                    group by
                                        cod_grupo
                                        ,descricao_grupo
            
                                    UNION
            
                                    SELECT
                                        cod_credito AS cod
                                        ,descricao_credito AS descricao
                                        ,sum(valor) as valor
                                        ,sum(valor_credito_pagamento) as recebido
                                        ,sum(valor_vencido) as vencido
                                        ,sum(valor_receber) as receber
                                    from
                                        tmp_relatorio_formatado
                                    where cod_grupo is null
                                    group by
                                        cod_credito
                                        ,descricao_credito
                                    ORDER BY
                                        descricao\';
                ELSE
                    stSqlPrincipal:=\'
                                    SELECT
                                        cod_grupo AS cod
                                        ,descricao_grupo AS descricao
                                        ,ARRAY_TO_STRING(cgm,\'\' / \'\') AS cgm
                                        ,sum(valor) as valor
                                        ,sum(valor_credito_pagamento) as recebido
                                        ,sum(valor_vencido) as vencido
                                        ,sum(valor_receber) as receber
                                    from
                                        tmp_relatorio_formatado
                                    where cod_grupo is not null
                                    group by
                                        cod_grupo
                                        ,descricao_grupo
                                        ,cgm
                                    UNION
            
                                    SELECT
                                        cod_credito AS cod
                                        ,descricao_credito AS descricao
                                        ,ARRAY_TO_STRING(cgm,\'\' / \'\') AS cgm
                                        ,sum(valor) as valor
                                        ,sum(valor_credito_pagamento) as recebido
                                        ,sum(valor_vencido) as vencido
                                        ,sum(valor_receber) as receber
                                    from
                                        tmp_relatorio_formatado
                                    where cod_grupo is null
                                    group by
                                        cod_credito
                                        ,descricao_credito
                                        ,cgm
                                    ORDER BY
                                        3,1;
                    \';
                END IF;
            
                FOR reRecord IN EXECUTE stSqlPrincipal LOOP
                        return next reRecord;
                END LOOP;
            
            
                SET search_path = \'public\';
                RETURN ;
            END;
            $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP FUNCTION arrecadacao.fn_rl_periodico_arrecadacao(tipo character varying, data_ini date, data_fim date, credito_ini character varying, credito_fim character varying, grupo_ini character varying, grupo_fim character varying, imob_ini integer, imob_fim integer, econ_ini integer, econ_fim integer, cgm_ini integer, cgm_fim integer, cod_est_atividade_ini character varying, cod_est_atividade_fim character varying)');
    }
}
