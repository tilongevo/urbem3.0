<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170214074731 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE FUNCTION ldo.evolucao_divida(integer, character varying)
             RETURNS SETOF record
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inCodPPA                    ALIAS FOR $1;
                stExercicio                 ALIAS FOR $2;
                dtInicioAno                 VARCHAR := \'\';
                dtFinalAno                  VARCHAR := \'\';
                stSql                       VARCHAR := \'\';
                stExercicioAnterior         VARCHAR := \'\';
                stExercicioAnterior1        VARCHAR := \'\';
                stExercicioAnterior2        VARCHAR := \'\';
                stExercicioAnterior3        VARCHAR := \'\';
                stExercicioPrevisao1        VARCHAR := \'\';
                stExercicioPrevisao2        VARCHAR := \'\';
                stExercicioPrevisao3        VARCHAR := \'\';
                boLancamento                BOOLEAN;
                vlDividaConsolidada         NUMERIC[] := array[0];
                vlDividaConsolidadaLiquida  NUMERIC[] := array[0];
                vlDisponibilidadeFinanceira NUMERIC[] := array[0];
                vlDividaFiscalLiquida       NUMERIC[] := array[0];
                vlPassivosReconhecidos      NUMERIC[] := array[0];
                vlResultadoNominal          NUMERIC[] := array[0];
                boOrcamento                 INTEGER[] := array[0];
                stExercicioArray            VARCHAR[] := array[0];
                vlTMP                       NUMERIC(14,2) := 0;
                inIdentificador             INTEGER;
                inCount                     INTEGER;
                reRegistro                  RECORD;
                reRegistroLoop              RECORD;
            BEGIN
                stExercicioAnterior1 := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'9999\')-1), \'9999\'));
                stExercicioAnterior2 := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'9999\')-2), \'9999\'));
                stExercicioAnterior3 := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'9999\')-3), \'9999\'));
            
                stExercicioPrevisao1 := stExercicio;
                stExercicioPrevisao2 := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'9999\')+1), \'9999\'));
                stExercicioPrevisao3 := TRIM(TO_CHAR((TO_NUMBER(stExercicio, \'9999\')+2), \'9999\'));
            
                --verifica se a sequence evolucao_divida existe
                IF((SELECT 1 FROM pg_catalog.pg_statio_user_sequences WHERE relname=\'evolucao_divida\') IS NOT NULL) THEN
                    SELECT NEXTVAL(\'ldo.evolucao_divida\')
                      INTO inIdentificador;
                ELSE
                    CREATE SEQUENCE ldo.evolucao_divida START 1;
                    SELECT NEXTVAL(\'ldo.evolucao_divida\')
                      INTO inIdentificador;
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
                        SELECT CAST(\' || stExercicioAnterior1 || \' AS VARCHAR) AS exercicio
                        UNION
                        SELECT CAST(\' || stExercicioAnterior2 || \' AS VARCHAR) AS exercicio
                        UNION
                        SELECT CAST(\' || stExercicioAnterior3 || \' AS VARCHAR) AS exercicio
                        order by exercicio asc
                \';
            
                inCount := 1;
            
                -------------------------------------------------------
                -- Busca os valores dos 3 exercícios anteriores ao LDO
                -------------------------------------------------------
                FOR reRegistroLoop IN EXECUTE stSql LOOP
                    stExercicioAnterior := TRIM(TO_CHAR((TO_NUMBER(reRegistroLoop.exercicio, \'9999\')-1), \'9999\'));
                    dtInicioAno := \'01/01/\'||reRegistroLoop.exercicio;
                    dtFinalAno := \'31/12/\'||reRegistroLoop.exercicio;
            
                    -- Verifica se possui lançamentos, se possuir, deve buscar os dados do orçamento, senão buscar da configuração do STN
                    SELECT CASE WHEN exercicio IS NOT NULL THEN 
                                    true 
                                ELSE 
                                    false 
                           END 
                      INTO boLancamento
                      FROM contabilidade.lancamento 
                     WHERE exercicio = reRegistroLoop.exercicio 
                  GROUP BY exercicio;
                
                    IF (boLancamento) THEN
                        -----------------------------------------------------
                        -- Busca os valores do orçamento
                        -----------------------------------------------------
            
                        SELECT cons.*
                             , (ativo_exercicio_anterior + haveres_financeiros_exercicio_anterior + restos_exercicio_anterior) as deducoes_exercicio_anterior
                             , (ativo_saldo_bimestre     + haveres_financeiros_bimestre           + restos_bimestre          ) as deducoes_bimestre
                          INTO reRegistro
                          FROM ( SELECT COALESCE(stn.pl_saldo_contas ( stExercicioAnterior
                                                                     , \'01/01/\' || stExercicioAnterior
                                                                     , \'31/12/\' || stExercicioAnterior
                                                                     , \'cod_estrutural like \'\'\'|| publico.fn_mascarareduzida(\'1.1.1.0.0.00.00.00.00.00\') || \'.%\'\' \'
                                                                     , \'\' ), 0.00) AS ativo_exercicio_anterior
                                      , COALESCE(stn.pl_saldo_contas ( reRegistroLoop.exercicio
                                                                     , dtInicioAno 
                                                                     , dtFinalAno
                                                                     , \'cod_estrutural like \'\'\'|| publico.fn_mascarareduzida(\'1.1.1.0.0.00.00.00.00.00\') || \'.%\'\' \'
                                                                     , \'\' ), 0.00) AS ativo_saldo_bimestre
                                      , COALESCE(stn.pl_saldo_contas ( stExercicioAnterior
                                                                     , \'01/01/\' || stExercicioAnterior
                                                                     , \'31/12/\' || stExercicioAnterior
                                                                     , \'cod_estrutural like \'\'1.1.2.%\'\'\'
                                                                     , \'\' ), 0.00) AS haveres_financeiros_exercicio_anterior
                                      , COALESCE(stn.pl_saldo_contas ( reRegistroLoop.exercicio
                                                                     , dtInicioAno 
                                                                     , dtFinalAno
                                                                     , \'cod_estrutural like \'\'1.1.2.%\'\' \'
                                                                     , \'\' ), 0.00) AS haveres_financeiros_bimestre
                                      , COALESCE((SELECT SUM(stn.pl_saldo_contas ( stExercicioAnterior
                                                                                 , \'01/01/\' || stExercicioAnterior
                                                                                 , \'31/12/\' || stExercicioAnterior
                                                                                 , \'cod_estrutural like \'\'\'|| publico.fn_mascarareduzida(plano_conta.cod_estrutural) || \'.%\'\' \'
                                                                                 , \'\' )) AS saldo_exercicio_anterior
                                            FROM contabilidade.plano_conta
                                           WHERE exercicio = stExercicioAnterior
                                             AND cod_estrutural IN (\'2.1.2.1.1.02.00.00.00.00\',
                                                                    \'2.1.2.1.1.03.02.00.00.00\',
                                                                    \'2.1.2.1.2.02.00.00.00.00\',
                                                                    \'2.1.2.1.2.03.02.00.00.00\',
                                                                    \'2.1.2.1.3.01.00.02.00.00\',
                                                                    \'2.1.2.1.3.03.00.02.00.00\',
                                                                    \'2.1.2.1.3.04.00.02.00.00\') ), 0.00) AS restos_exercicio_anterior
                                      , COALESCE(( SELECT SUM(stn.pl_saldo_contas ( plano_conta.exercicio
                                                                                  , dtInicioAno
                                                                                  , dtFinalAno
                                                                                  , \'cod_estrutural like \'\'\'|| publico.fn_mascarareduzida( plano_conta.cod_estrutural ) || \'.%\'\' \'
                                                                                  , \'\' )) AS saldo_bimestre_anterior
                                            FROM contabilidade.plano_conta
                                           WHERE exercicio = reRegistroLoop.exercicio
                                             AND cod_estrutural IN(\'2.1.2.1.1.02.00.00.00.00\',
                                                                   \'2.1.2.1.1.03.02.00.00.00\',
                                                                   \'2.1.2.1.2.02.00.00.00.00\',
                                                                   \'2.1.2.1.2.03.02.00.00.00\',
                                                                   \'2.1.2.1.3.01.00.02.00.00\',
                                                                   \'2.1.2.1.3.03.00.02.00.00\',
                                                                   \'2.1.2.1.3.04.00.02.00.00\')), 0.00) AS restos_bimestre
                                      , COALESCE(( SELECT SUM(stn.pl_saldo_contas ( stExercicioAnterior
                                                                                  , \'01/01/\' || stExercicioAnterior
                                                                                  , \'31/12/\' || stExercicioAnterior
                                                                                  , \' ( REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22211%\'\'
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22221%\'\'   
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22212%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22222%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'2121705%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'21231020203%\'\'     
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'2223\'\'      
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'2224401%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22244%\'\'   
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22249000002%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22%\'\')\'
                                                                                  , \'\' ) * -1 ) ), 0.00) AS divida_exercicio_anterior
                                      , COALESCE(( SELECT SUM(stn.pl_saldo_contas ( reRegistroLoop.exercicio
                                                                                  , dtInicioAno
                                                                                  , dtFinalAno 
                                                                                  , \' ( REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22211%\'\'
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22221%\'\'   
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22212%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22222%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'2121705%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'21231020203%\'\'     
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'2223\'\'      
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'2224401%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22244%\'\'   
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22249000002%\'\'    
                                                                                     OR REPLACE(plano_conta.cod_estrutural,\'\'.\'\',\'\'\'\') LIKE \'\'22%\'\')\'
                                                                                  , \'\' ) * -1 )), 0.00) AS divida_bimestre
                          ) AS cons;
            
                        vlDividaConsolidada[inCount] := reRegistro.divida_bimestre;
                        vlDisponibilidadeFinanceira[inCount] := reRegistro.ativo_saldo_bimestre + reRegistro.haveres_financeiros_bimestre + reRegistro.restos_bimestre;
            
                        IF (vlDisponibilidadeFinanceira[inCount] < 0) THEN
                            vlDividaConsolidadaLiquida[inCount] := vlDividaConsolidada[inCount] + vlDisponibilidadeFinanceira[inCount];
                        ELSE
                            vlDividaConsolidadaLiquida[inCount] := vlDividaConsolidada[inCount] - vlDisponibilidadeFinanceira[inCount];
                        END IF;
            
                        IF (vlDividaConsolidadaLiquida[inCount] < 0) THEN
                            vlDividaConsolidadaLiquida[inCount] := 0.00;
                        END IF;
                        vlPassivosReconhecidos[inCount] := 0.00;
            
                        IF (vlPassivosReconhecidos[inCount] < 0) THEN
                            vlDividaFiscalLiquida[inCount] := vlDividaConsolidadaLiquida[inCount] + vlPassivosReconhecidos[inCount]; 
                        ELSE
                            vlDividaFiscalLiquida[inCount] := vlDividaConsolidadaLiquida[inCount] - vlPassivosReconhecidos[inCount]; 
                        END IF;
            
                        boOrcamento[inCount] := 1;
                        stExercicioArray[inCount] := reRegistroLoop.exercicio;
                        IF (inCount = 1) THEN
                            SELECT COALESCE(SUM(COALESCE(valor, 0.00)), 0.00)
                              INTO vlTMP
                              FROM ldo.configuracao_divida
                             WHERE exercicio = reRegistroLoop.exercicio
                               AND cod_ppa = inCodPPA
                               AND cod_tipo = 6;
            
                            vlResultadoNominal[inCount] := vlTMP;
                        ELSE 
                            IF (vlDividaFiscalLiquida[inCount-1] < 0) THEN
                                vlResultadoNominal[inCount] := vlDividaFiscalLiquida[inCount] + vlDividaFiscalLiquida[inCount-1];
                            ELSE 
                                vlResultadoNominal[inCount] := vlDividaFiscalLiquida[inCount] - vlDividaFiscalLiquida[inCount-1];
                            END IF;
            
                        END IF;
            
                        inCount := inCount + 1;
            
                    ELSE 
                        -----------------------------------------------------
                        -- Busca os valores da configuração do LDO
                        -----------------------------------------------------
            
                        SELECT COALESCE(SUM(COALESCE(valor, 0.00)), 0.00)
                          INTO vlTMP
                          FROM ldo.configuracao_divida 
                         WHERE exercicio = reRegistroLoop.exercicio
                           AND cod_ppa = inCodPPA
                           AND cod_tipo = 1;
            
                        vlDividaConsolidada[inCount] := vlTMP;
            
                        SELECT COALESCE(SUM(COALESCE(valor, 0.00)), 0.00)
                          INTO vlTMP
                          FROM ldo.configuracao_divida 
                         WHERE exercicio = reRegistroLoop.exercicio
                           AND cod_ppa = inCodPPA
                           AND cod_tipo = 2;
            
                        vlDisponibilidadeFinanceira[inCount] := vlTMP;
            
                        IF (vlDisponibilidadeFinanceira[inCount] < 0) THEN
                            vlDividaConsolidadaLiquida[inCount] := vlDividaConsolidada[inCount] + vlDisponibilidadeFinanceira[inCount];
                        ELSE
                            vlDividaConsolidadaLiquida[inCount] := vlDividaConsolidada[inCount] - vlDisponibilidadeFinanceira[inCount];
                        END IF;
            
                        IF (vlDividaConsolidadaLiquida[inCount] < 0) THEN
                            vlDividaConsolidadaLiquida[inCount] := 0.00;
                        END IF;
            
                        SELECT COALESCE(SUM(COALESCE(valor, 0.00)), 0.00)
                          INTO vlTMP
                          FROM ldo.configuracao_divida 
                         WHERE exercicio = reRegistroLoop.exercicio
                           AND cod_ppa = inCodPPA
                           AND cod_tipo = 4;
            
                        vlPassivosReconhecidos[inCount] := vlTMP;
            
                        boOrcamento[inCount] := 0;
                        stExercicioArray[inCount] := reRegistroLoop.exercicio;
            
                        IF (vlPassivosReconhecidos[inCount] < 0) THEN
                            vlDividaFiscalLiquida[inCount] := vlDividaConsolidadaLiquida[inCount] + vlPassivosReconhecidos[inCount]; 
                        ELSE
                            vlDividaFiscalLiquida[inCount] := vlDividaConsolidadaLiquida[inCount] - vlPassivosReconhecidos[inCount]; 
                        END IF;
            
                        IF (inCount = 1) THEN
                            SELECT COALESCE(SUM(COALESCE(valor, 0.00)), 0.00)
                              INTO vlTMP
                              FROM ldo.configuracao_divida
                             WHERE exercicio = reRegistroLoop.exercicio
                               AND cod_ppa = inCodPPA
                               AND cod_tipo = 6;
            
                            vlResultadoNominal[inCount] := vlTMP;
                        ELSE 
                            IF (vlDividaFiscalLiquida[inCount-1] < 0) THEN
                                vlResultadoNominal[inCount] := vlDividaFiscalLiquida[inCount] + vlDividaFiscalLiquida[inCount-1];
                            ELSE 
                                vlResultadoNominal[inCount] := vlDividaFiscalLiquida[inCount] - vlDividaFiscalLiquida[inCount-1];
                            END IF;
                        END IF;
            
                        inCount := inCount + 1;
                    END IF;
                END LOOP;
            
                stSql := \'
                        SELECT CAST(\' || stExercicioPrevisao1 || \' AS VARCHAR) AS exercicio
                        UNION
                        SELECT CAST(\' || stExercicioPrevisao2 || \' AS VARCHAR) AS exercicio
                        UNION
                        SELECT CAST(\' || stExercicioPrevisao3 || \' AS VARCHAR) AS exercicio
                        order by exercicio asc
                \';
            
                ------------------------------------------------------------------------------------------
                -- Busca os valores dos 3 próximos exercícios, estes valores sempre virão da configuração
                ------------------------------------------------------------------------------------------
                FOR reRegistroLoop IN EXECUTE stSql LOOP
                    SELECT COALESCE(SUM(COALESCE(vl_projetado, 0.00)*-1), 0.00)
                      INTO vlTMP
                      FROM ldo.configuracao_receita_despesa
                     WHERE exercicio = reRegistroLoop.exercicio
                       AND tipo = \'R\'
                       AND cod_tipo IN (7, 31, 43);
            
                    IF (vlTMP = NULL) THEN
                        vlDividaConsolidada[inCount] := vlDividaConsolidada[inCount-1];
                    ELSE
                        vlDividaConsolidada[inCount] := vlDividaConsolidada[inCount-1] + vlTMP;
                    END IF; 
            
                    SELECT (( SELECT COALESCE(SUM(vl_projetado), 0.00)
                                FROM ldo.configuracao_receita_despesa
                               WHERE tipo = \'R\'
                                 AND exercicio = reRegistroLoop.exercicio )  
                          - ( SELECT COALESCE(SUM(vl_projetado), 0.00)
                                FROM ldo.configuracao_receita_despesa
                               WHERE cod_tipo IN (5, 9, 17, 24)
                                 AND exercicio = reRegistroLoop.exercicio )) 
                          - (( SELECT COALESCE(SUM(vl_projetado), 0.00)
                                 FROM ldo.configuracao_receita_despesa
                                WHERE tipo = \'D\'
                                  AND exercicio = reRegistroLoop.exercicio ) 
                            - (( SELECT COALESCE(SUM(vl_projetado), 0.00)
                                   FROM ldo.configuracao_receita_despesa
                                  WHERE cod_tipo IN (29, 32, 35, 39)
                                    AND exercicio = reRegistroLoop.exercicio )  
                              + (( SELECT COALESCE(SUM(vl_projetado), 0.00)
                                     FROM ldo.configuracao_receita_despesa
                                    WHERE cod_tipo IN (5, 9, 17, 24)
                                      AND exercicio = reRegistroLoop.exercicio )  
                                - ( SELECT COALESCE(SUM(vl_projetado), 0.00)
                                      FROM ldo.configuracao_receita_despesa
                                     WHERE cod_tipo IN (29, 32, 35, 39)
                                       AND exercicio = reRegistroLoop.exercicio )
                                )
                              )
                            )
                      INTO vlTMP;
            
                    IF (vlTMP = NULL) THEN
                        vlDisponibilidadeFinanceira[inCount] := 0.00;
                    ELSE
                        vlDisponibilidadeFinanceira[inCount] := vlDisponibilidadeFinanceira[inCount-1] + vlTMP;
                    END IF;        
            
                    IF (vlDisponibilidadeFinanceira[inCount] < 0) THEN
                        vlDividaConsolidadaLiquida[inCount] := vlDividaConsolidada[inCount] + vlDisponibilidadeFinanceira[inCount];
                    ELSE
                        vlDividaConsolidadaLiquida[inCount] := vlDividaConsolidada[inCount] - vlDisponibilidadeFinanceira[inCount];
                    END IF;
            
                    SELECT COALESCE(SUM(COALESCE(valor, 0.00)), 0.00)
                      INTO vlTMP
                      FROM ldo.configuracao_divida 
                     WHERE exercicio = reRegistroLoop.exercicio
                       AND cod_ppa = inCodPPA
                       AND cod_tipo = 4;
            
                    IF (vlTMP = NULL) THEN
                        vlPassivosReconhecidos[inCount] := 0.00;
                    ELSE
                        vlPassivosReconhecidos[inCount] := vlTMP;
                    END IF;        
             
                    IF (vlPassivosReconhecidos[inCount] < 0) THEN
                        vlDividaFiscalLiquida[inCount] := vlDividaConsolidadaLiquida[inCount] + vlPassivosReconhecidos[inCount]; 
                    ELSE
                        vlDividaFiscalLiquida[inCount] := vlDividaConsolidadaLiquida[inCount] - vlPassivosReconhecidos[inCount]; 
                    END IF;
            
                    IF (vlDividaFiscalLiquida[inCount-1] < 0) THEN
                        vlResultadoNominal[inCount] := vlDividaFiscalLiquida[inCount] + vlDividaFiscalLiquida[inCount-1];
                    ELSE
                        vlResultadoNominal[inCount] := vlDividaFiscalLiquida[inCount] - vlDividaFiscalLiquida[inCount-1];
                    END IF;
            
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
                                                                  , \'\'Dívida Consolidada\'\'
                                                                  , \'||vlDividaConsolidada[1]||\'
                                                                  , \'||vlDividaConsolidada[2]||\'
                                                                  , \'||vlDividaConsolidada[3]||\'
                                                                  , \'||vlDividaConsolidada[4]||\'
                                                                  , \'||vlDividaConsolidada[5]||\'
                                                                  , \'||vlDividaConsolidada[6]||\'
                                                                  , \'||boOrcamento[1]||\'
                                                                  , \'||boOrcamento[2]||\'
                                                                  , \'||boOrcamento[3]||\'
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
                                                                  , \'\'Disponibilidades Financeiras (Líquidas)\'\'
                                                                  , \'||vlDisponibilidadeFinanceira[1]||\'
                                                                  , \'||vlDisponibilidadeFinanceira[2]||\'
                                                                  , \'||vlDisponibilidadeFinanceira[3]||\'
                                                                  , \'||vlDisponibilidadeFinanceira[4]||\'
                                                                  , \'||vlDisponibilidadeFinanceira[5]||\'
                                                                  , \'||vlDisponibilidadeFinanceira[6]||\'
                                                                  , \'||boOrcamento[1]||\'
                                                                  , \'||boOrcamento[2]||\'
                                                                  , \'||boOrcamento[3]||\'
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
                                                                  , \'\'Dívida Consolidada Líquida\'\'
                                                                  , \'||vlDividaConsolidadaLiquida[1]||\'
                                                                  , \'||vlDividaConsolidadaLiquida[2]||\'
                                                                  , \'||vlDividaConsolidadaLiquida[3]||\'
                                                                  , \'||vlDividaConsolidadaLiquida[4]||\'
                                                                  , \'||vlDividaConsolidadaLiquida[5]||\'
                                                                  , \'||vlDividaConsolidadaLiquida[6]||\'
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
                                                           VALUES ( 4
                                                                  , 4
                                                                  , \'\'Passivos Reconhecidos\'\'
                                                                  , \'||vlPassivosReconhecidos[1]||\'
                                                                  , \'||vlPassivosReconhecidos[2]||\'
                                                                  , \'||vlPassivosReconhecidos[3]||\'
                                                                  , \'||vlPassivosReconhecidos[4]||\'
                                                                  , \'||vlPassivosReconhecidos[5]||\'
                                                                  , \'||vlPassivosReconhecidos[6]||\'
                                                                  , \'||boOrcamento[1]||\'
                                                                  , \'||boOrcamento[2]||\'
                                                                  , \'||boOrcamento[3]||\'
                                                                  , 0
                                                                  , 0
                                                                  , 0
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
                                                           VALUES ( 5
                                                                  , 5
                                                                  , \'\'Dívida Fiscal Líquida\'\'
                                                                  , \'||vlDividaFiscalLiquida[1]||\'
                                                                  , \'||vlDividaFiscalLiquida[2]||\'
                                                                  , \'||vlDividaFiscalLiquida[3]||\'
                                                                  , \'||vlDividaFiscalLiquida[4]||\'
                                                                  , \'||vlDividaFiscalLiquida[5]||\'
                                                                  , \'||vlDividaFiscalLiquida[6]||\'
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
                                                           VALUES ( 6
                                                                  , 6
                                                                  , \'\'Resultado Nominal\'\'
                                                                  , \'||vlResultadoNominal[1]||\'
                                                                  , \'||vlResultadoNominal[2]||\'
                                                                  , \'||vlResultadoNominal[3]||\'
                                                                  , \'||vlResultadoNominal[4]||\'
                                                                  , \'||vlResultadoNominal[5]||\'
                                                                  , \'||vlResultadoNominal[6]||\'
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
        $this->addSql('DROP FUNCTION ldo.evolucao_divida(integer, character varying)');
    }
}
