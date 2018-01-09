<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170214075230 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE FUNCTION ldo.servico_divida(integer, character varying, integer)
             RETURNS SETOF record
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inCodPPA                    ALIAS FOR $1;
                stExercicio                 ALIAS FOR $2;
                inCodSelic                  ALIAS FOR $3;
                dtInicioAno                 VARCHAR := \'\';
                dtFinalAno                  VARCHAR := \'\';
                stSql                       VARCHAR := \'\';
                stExercicioPrevisao1        VARCHAR := \'\';
                stExercicioPrevisao2        VARCHAR := \'\';
                stExercicioPrevisao3        VARCHAR := \'\';
                vlOperacoesCredito          NUMERIC[] := array[0];
                vlEncargos                  NUMERIC[] := array[0];
                vlAmortizacoes              NUMERIC[] := array[0];
                stExercicioArray            VARCHAR[] := array[0];
                vlTMP                       NUMERIC(14,2) := 0;
                inIdentificador             INTEGER;
                inIdentificador2            INTEGER;
                inCount                     INTEGER;
                reRegistro                  RECORD;
                reRegistroLoop              RECORD;
                reRegistroAux               RECORD;
            BEGIN
                stExercicioPrevisao1 := stExercicio;
                stExercicioPrevisao2 := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'99999\')+1), \'99999\'));
                stExercicioPrevisao3 := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'99999\')+2), \'99999\'));
            
                stExercicioArray[1] := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'99999\')-3), \'99999\'));
                stExercicioArray[2] := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'99999\')-2), \'99999\'));
                stExercicioArray[3] := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'99999\')-1), \'99999\'));
                dtInicioAno := \'01/01/\' || stExercicio;
                dtFinalAno  := \'31/12/\' || stExercicio;
            
                --verifica se a sequence servico_divida existe
                IF((SELECT 1 FROM pg_catalog.pg_statio_user_sequences WHERE relname=\'servico_divida\') IS NOT NULL) THEN
                    SELECT NEXTVAL(\'ldo.servico_divida\')
                      INTO inIdentificador;
                ELSE
                    CREATE SEQUENCE ldo.servico_divida START 1;
                    SELECT NEXTVAL(\'ldo.servico_divida\')
                      INTO inIdentificador;
                END IF;
            
                --verifica se a sequence valor_tmp existe
                IF((SELECT 1 FROM pg_catalog.pg_statio_user_sequences WHERE relname=\'valor_tmp\') IS NOT NULL) THEN
                    SELECT NEXTVAL(\'ldo.valor_tmp\')
                      INTO inIdentificador2;
                ELSE
                    CREATE SEQUENCE ldo.valor_tmp START 1;
                    SELECT NEXTVAL(\'ldo.valor_tmp\')
                      INTO inIdentificador2;
                END IF;
            
                -------------------------------------------------------
                -- Cria uma tabela temporaria para retornar os valores
                -------------------------------------------------------
                stSql := \'
                CREATE TEMPORARY TABLE tmp_retorno_\'||inIdentificador||\' (
                      ordem             INTEGER
                    , cod_tipo          INTEGER
                    , especificacao     VARCHAR
                    , valor_1           DECIMAL(14,2)
                    , valor_2           DECIMAL(14,2)
                    , valor_3           DECIMAL(14,2)
                    , valor_4           DECIMAL(14,2)
                    , valor_5           DECIMAL(14,2)
                    , valor_6           DECIMAL(14,2)
                    , bo_orcamento_1    DECIMAL(1)
                    , bo_orcamento_2    DECIMAL(1)
                    , bo_orcamento_3    DECIMAL(1)
                    , bo_orcamento_4    DECIMAL(1)
                    , bo_orcamento_5    DECIMAL(1)
                    , bo_orcamento_6    DECIMAL(1)
                    , exercicio_1       CHAR(4)
                    , exercicio_2       CHAR(4)
                    , exercicio_3       CHAR(4)
                    , exercicio_4       CHAR(4)
                    , exercicio_5       CHAR(4)
                    , exercicio_6       CHAR(4)
                ) \';
            
                EXECUTE stSql;
            
                stSql := \'
                CREATE TEMPORARY TABLE tmp_valor_\'||inIdentificador2||\' AS (
                        SELECT cod_tipo
                             , exercicio
                             , cod_estrutural
                             , descricao
                             , tipo
                             , nivel
                             , rpps
                             , orcamento_1
                             , orcamento_2
                             , orcamento_3
                             , orcamento_4
                             , valor_1
                             , valor_2
                             , valor_3
                             , valor_4
                          FROM ldo.fn_receita_configuracao(\'||inCodPPA||\', \'\'\'||stExercicio||\'\'\')
                            AS retorno( cod_tipo       INTEGER,
                                        exercicio      VARCHAR(4),
                                        cod_estrutural VARCHAR,
                                        descricao      VARCHAR,
                                        tipo           CHAR(1),
                                        nivel          NUMERIC(1),
                                        rpps           NUMERIC(1),
                                        orcamento_1    NUMERIC(1),
                                        orcamento_2    NUMERIC(1),
                                        orcamento_3    NUMERIC(1),
                                        orcamento_4    NUMERIC(1),
                                        valor_1        NUMERIC(14,2),
                                        valor_2        NUMERIC(14,2),
                                        valor_3        NUMERIC(14,2),
                                        valor_4        NUMERIC(14,2))
            
                    UNION ALL
            
                        SELECT cod_tipo
                             , exercicio
                             , cod_estrutural
                             , descricao
                             , tipo
                             , nivel
                             , rpps
                             , orcamento_1
                             , orcamento_2
                             , orcamento_3
                             , orcamento_4
                             , valor_1
                             , valor_2
                             , valor_3
                             , valor_4
                          FROM ldo.fn_despesa_configuracao(\'||inCodPPA||\', \'\'\'||stExercicio||\'\'\')
                            AS retorno( cod_tipo       INTEGER,
                                        exercicio      VARCHAR(4),
                                        cod_estrutural VARCHAR,
                                        descricao      VARCHAR,
                                        tipo           CHAR(1),
                                        nivel          NUMERIC(1),
                                        rpps           NUMERIC(1),
                                        orcamento_1    NUMERIC(1),
                                        orcamento_2    NUMERIC(1),
                                        orcamento_3    NUMERIC(1),
                                        orcamento_4    NUMERIC(1),
                                        valor_1        NUMERIC(14,2),
                                        valor_2        NUMERIC(14,2),
                                        valor_3        NUMERIC(14,2),
                                        valor_4        NUMERIC(14,2))
                ) \';
            
                EXECUTE stSql;
            
                stSql := \'
                    SELECT COALESCE(SUM(valor_4), 0.00) AS valor_4
                         , COALESCE(SUM(valor_3), 0.00) AS valor_3
                         , COALESCE(SUM(valor_2), 0.00) AS valor_2
                      FROM tmp_valor_\'||inIdentificador2||\'
                     WHERE cod_estrutural = \'\'2.1.0.0.00.00.00.00.00\'\'
                       AND nivel = 1
                \';
            
                FOR reRegistroAux IN EXECUTE stSql LOOP
                    vlOperacoesCredito[1] := reRegistroAux.valor_2;
                    vlOperacoesCredito[2] := reRegistroAux.valor_3;
                    vlOperacoesCredito[3] := reRegistroAux.valor_4;
                END LOOP;
            
                stSql := \'
                    SELECT COALESCE(SUM(valor_4), 0.00) AS valor_4
                         , COALESCE(SUM(valor_3), 0.00) AS valor_3
                         , COALESCE(SUM(valor_2), 0.00) AS valor_2
                      FROM tmp_valor_\'||inIdentificador2||\'
                     WHERE cod_estrutural = \'\'3.2.0.0.00.00.00.00.00\'\'
                       AND nivel = 1
                \';
            
                FOR reRegistroAux IN EXECUTE stSql LOOP
                    vlEncargos[1] := reRegistroAux.valor_2;
                    vlEncargos[2] := reRegistroAux.valor_3;
                    vlEncargos[3] := reRegistroAux.valor_4;
                END LOOP;
            
                stSql := \'
                    SELECT COALESCE(SUM(valor_4), 0.00) AS valor_4
                         , COALESCE(SUM(valor_3), 0.00) AS valor_3
                         , COALESCE(SUM(valor_2), 0.00) AS valor_2
                      FROM tmp_valor_\'||inIdentificador2||\'
                     WHERE cod_estrutural = \'\'4.6.0.0.00.00.00.00.00\'\'
                       AND nivel = 1
                \';
            
                FOR reRegistroAux IN EXECUTE stSql LOOP
                    vlAmortizacoes[1] := reRegistroAux.valor_2;
                    vlAmortizacoes[2] := reRegistroAux.valor_3;
                    vlAmortizacoes[3] := reRegistroAux.valor_4;
                END LOOP;
            
                stSql := \'
                        SELECT CAST(\' || stExercicioPrevisao1 || \' AS VARCHAR) AS exercicio
                        UNION
                        SELECT CAST(\' || stExercicioPrevisao2 || \' AS VARCHAR) AS exercicio
                        UNION
                        SELECT CAST(\' || stExercicioPrevisao3 || \' AS VARCHAR) AS exercicio
                \';
            
                ------------------------------------------------------------------------------------------
                -- Busca os valores dos 3 próximos exercícios, estes valores sempre virão da configuração
                ------------------------------------------------------------------------------------------
            
                inCount := 4;
                FOR reRegistroLoop IN EXECUTE stSql LOOP
                    SELECT COALESCE(SUM(vl_projetado), 0.00)
                      INTO vlTMP
                      FROM ldo.configuracao_receita_despesa
                      JOIN ldo.tipo_receita_despesa
                        ON tipo_receita_despesa.cod_tipo = configuracao_receita_despesa.cod_tipo
                       AND tipo_receita_despesa.tipo     = configuracao_receita_despesa.tipo
                     WHERE cod_estrutural = \'2.1.0.0.00.00.00.00.00\'
                       AND exercicio = reRegistroLoop.exercicio
                       AND nivel = 1;
            
                    IF (vlTMP = NULL) THEN
                        vlOperacoesCredito[inCount] := 0.00;
                    ELSE
                        vlOperacoesCredito[inCount] := vlTMP;
            
                    END IF;
            
                    SELECT COALESCE(SUM(vl_projetado), 0.00)
                      INTO vlTMP
                      FROM ldo.configuracao_receita_despesa
                      JOIN ldo.tipo_receita_despesa
                        ON tipo_receita_despesa.cod_tipo = configuracao_receita_despesa.cod_tipo
                       AND tipo_receita_despesa.tipo     = configuracao_receita_despesa.tipo
                     WHERE cod_estrutural = \'3.2.0.0.00.00.00.00.00\'
                       AND exercicio = reRegistroLoop.exercicio
                       AND nivel = 1;
            
                    IF (vlTMP = NULL) THEN
                        vlEncargos[inCount] := 0.00;
                    ELSE
                        vlEncargos[inCount] := vlTMP;
                    END IF;
            
                    SELECT indice
                      INTO vlTMP
                      FROM ldo.indicadores
                     WHERE exercicio = reRegistroLoop.exercicio
                       AND cod_tipo_indicador = inCodSelic;
            
                    vlAmortizacoes[inCount] := vlAmortizacoes[inCount-1] * (1+vlTMP);
            
                    stExercicioArray[inCount] := reRegistroLoop.exercicio;
                    inCount := inCount + 1;
                END LOOP;
            
                stSql := \'
                INSERT INTO tmp_retorno_\'||inIdentificador||\' ( ordem
                                                              , cod_tipo
                                                              , especificacao
                                                              , valor_1
                                                              , valor_2
                                                              , valor_3
                                                              , valor_4
                                                              , valor_5
                                                              , valor_6
                                                              , bo_orcamento_1
                                                              , bo_orcamento_2
                                                              , bo_orcamento_3
                                                              , bo_orcamento_4
                                                              , bo_orcamento_5
                                                              , bo_orcamento_6
                                                              , exercicio_1
                                                              , exercicio_2
                                                              , exercicio_3
                                                              , exercicio_4
                                                              , exercicio_5
                                                              , exercicio_6
                                                              )
                                                       VALUES ( 1
                                                              , 1
                                                              , \'\'Operações de Crédito\'\'
                                                              , \'||vlOperacoesCredito[1]||\'
                                                              , \'||vlOperacoesCredito[2]||\'
                                                              , \'||vlOperacoesCredito[3]||\'
                                                              , \'||vlOperacoesCredito[4]||\'
                                                              , \'||vlOperacoesCredito[5]||\'
                                                              , \'||vlOperacoesCredito[6]||\'
                                                              , 1
                                                              , 1
                                                              , 1
                                                              , 1
                                                              , 1
                                                              , 1
                                                              , \'\'\'||stExercicioArray[1]||\'\'\'
                                                              , \'\'\'||stExercicioArray[2]||\'\'\'
                                                              , \'\'\'||stExercicioArray[3]||\'\'\'
                                                              , \'\'\'||stExercicioArray[4]||\'\'\'
                                                              , \'\'\'||stExercicioArray[5]||\'\'\'
                                                              , \'\'\'||stExercicioArray[6]||\'\'\'
                                                              ) \';
            
                    EXECUTE stSql;
            
                    stSql := \'
                    INSERT INTO tmp_retorno_\'||inIdentificador||\' ( ordem
                                                                  , cod_tipo
                                                                  , especificacao
                                                                  , valor_1
                                                                  , valor_2
                                                                  , valor_3
                                                                  , valor_4
                                                                  , valor_5
                                                                  , valor_6
                                                                  , bo_orcamento_1
                                                                  , bo_orcamento_2
                                                                  , bo_orcamento_3
                                                                  , bo_orcamento_4
                                                                  , bo_orcamento_5
                                                                  , bo_orcamento_6
                                                                  , exercicio_1
                                                                  , exercicio_2
                                                                  , exercicio_3
                                                                  , exercicio_4
                                                                  , exercicio_5
                                                                  , exercicio_6
                                                                  )
                                                           VALUES ( 2
                                                                  , 2
                                                                  , \'\'Encargos\'\'
                                                                  , \'||vlEncargos[1]||\'
                                                                  , \'||vlEncargos[2]||\'
                                                                  , \'||vlEncargos[3]||\'
                                                                  , \'||vlEncargos[4]||\'
                                                                  , \'||vlEncargos[5]||\'
                                                                  , \'||vlEncargos[6]||\'
                                                                  , 1
                                                                  , 1
                                                                  , 1
                                                                  , 1
                                                                  , 1
                                                                  , 1
                                                                  , \'\'\'||stExercicioArray[1]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[2]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[3]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[4]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[5]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[6]||\'\'\'
                                                                  ) \';
            
                    EXECUTE stSql;
            
                    stSql := \'
                    INSERT INTO tmp_retorno_\'||inIdentificador||\' ( ordem
                                                                  , cod_tipo
                                                                  , especificacao
                                                                  , valor_1
                                                                  , valor_2
                                                                  , valor_3
                                                                  , valor_4
                                                                  , valor_5
                                                                  , valor_6
                                                                  , bo_orcamento_1
                                                                  , bo_orcamento_2
                                                                  , bo_orcamento_3
                                                                  , bo_orcamento_4
                                                                  , bo_orcamento_5
                                                                  , bo_orcamento_6
                                                                  , exercicio_1
                                                                  , exercicio_2
                                                                  , exercicio_3
                                                                  , exercicio_4
                                                                  , exercicio_5
                                                                  , exercicio_6
                                                                  )
                                                           VALUES ( 3
                                                                  , 3
                                                                  , \'\'Amortizações\'\'
                                                                  , \'||vlAmortizacoes[1]||\'
                                                                  , \'||vlAmortizacoes[2]||\'
                                                                  , \'||vlAmortizacoes[3]||\'
                                                                  , \'||vlAmortizacoes[4]||\'
                                                                  , \'||vlAmortizacoes[5]||\'
                                                                  , \'||vlAmortizacoes[6]||\'
                                                                  , 1
                                                                  , 1
                                                                  , 1
                                                                  , 1
                                                                  , 1
                                                                  , 1
                                                                  , \'\'\'||stExercicioArray[1]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[2]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[3]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[4]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[5]||\'\'\'
                                                                  , \'\'\'||stExercicioArray[6]||\'\'\'
                                                                  ) \';
            
                    EXECUTE stSql;
            
                ----------------------------------------------------
                -- Retorna os valores da tabela temporaria
                ----------------------------------------------------
                stSql := \'
                    SELECT *
                      FROM tmp_retorno_\'||inIdentificador||\'
                  ORDER BY ordem
                \';
            
                FOR reRegistro IN EXECUTE stSql
                LOOP
                    RETURN NEXT reRegistro;
                END LOOP;
            
                EXECUTE \'DROP TABLE tmp_retorno_\'||inIdentificador;
                EXECUTE \'DROP TABLE tmp_valor_\'||inIdentificador2;
            
                RETURN;
            
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
        $this->addSql('DROP FUNCTION ldo.servico_divida(integer, character varying, integer)');
    }
}
