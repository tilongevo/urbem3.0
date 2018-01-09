<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170109104413 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('DROP FUNCTION IF EXISTS contabilidade.encerramentoanuallancamentosorcamentario2013(varexercicio character varying, intcodentidade integer)');

        $this->addSql('
        CREATE OR REPLACE FUNCTION contabilidade.encerramentoanuallancamentosorcamentario2013(varexercicio character varying, intcodentidade integer)
         RETURNS void
         LANGUAGE plpgsql
        AS $function$
        DECLARE
           recLancamento        Record;
           varAux               VARCHAR;
           intCodLote           INTEGER;
           intCodHistorico      INTEGER := 803;
           bolCriouLote         BOOLEAN := FALSE;
        
           intSeqIns            INTEGER := 0;
           stSql                VARCHAR := \'\';
           bolEncerramentoOrcamento        BOOLEAN;
        BEGIN
        
            IF NOT contabilidade.fezEncerramentoAnualLancamentosOrcamentario2013( varExercicio, intCodEntidade ) THEN
        
                IF bolEncerramentoOrcamento THEN
                   RAISE EXCEPTION \'Encerramento já realizado......\';
                END IF;
        
                INSERT INTO contabilidade.historico_contabil( cod_historico
                                                             , exercicio
                                                             , nom_historico
                                                             , complemento)
                                                        SELECT intCodHistorico
                                                             , varExercicio
                                                             , \'Encerramento do exercício – Sistema Orçamentário\'
                                                             , \'f\'
                                                       WHERE 0  = ( SELECT Count(1)
                                                                      FROM contabilidade.historico_contabil
                                                                     WHERE cod_historico = intCodHistorico
                                                                       AND exercicio     = varExercicio);
        
                 -- Ticket #22953 pede para apurar o saldo e fazer o lancamento das contas  6.3.1.4, 5.3.1.1, 6.3.2.2, 5.3.2.1
                 -- Ticket #22953 pede para apurar o saldo e fazer o lancamento das contas  6.3.1.9.1, 5.3.1.2, 6.3.2.9.9, 5.3.2.2
                 IF ( varExercicio >= \'2014\' ) THEN
                --APURA O SALDO E FAZ O LANCAMENTO DAS CONTAS 6.3.1.4, 6.3.2.2, 6.3.1.9.1 E 6.3.2.9.9 PARA CREDITAR NAS CONTAS 5.3.1.1, 5.3.2.1, 5.3.1.2 E 5.3.2.2 RESPECTIVAMENTE
                    stSql := \' SELECT plano_conta.cod_estrutural
                                    , plano_analitica.cod_plano
                                    , coalesce(total_credito.valor,0.00)            AS valor_cre
                                    , coalesce(total_debito.valor,0.00)             AS valor_deb
                                    , ABS(coalesce(( COALESCE(abs(-(total_credito.valor)),0) - COALESCE(total_debito.valor,0) ),0.00)) AS saldo
                                FROM contabilidade.plano_conta
                                    , contabilidade.plano_analitica
                            LEFT JOIN ( SELECT cod_plano, conta_debito.exercicio, SUM(vl_lancamento) AS valor
                                        FROM contabilidade.valor_lancamento
                                            , contabilidade.conta_debito
                                        WHERE conta_debito.cod_lote     = valor_lancamento.cod_lote
                                        AND conta_debito.tipo         = valor_lancamento.tipo
                                        AND conta_debito.sequencia    = valor_lancamento.sequencia
                                        AND conta_debito.exercicio    = valor_lancamento.exercicio
                                        AND conta_debito.tipo_valor   = valor_lancamento.tipo_valor
                                        AND conta_debito.cod_entidade = valor_lancamento.cod_entidade
                                        AND conta_debito.cod_entidade =  \' || intCodEntidade || \'
                                    GROUP BY cod_plano,conta_debito.exercicio
                                    ) AS total_debito
                                ON contabilidade.plano_analitica.cod_plano = total_debito.cod_plano
                                AND contabilidade.plano_analitica.exercicio = total_debito.exercicio
                            LEFT JOIN ( SELECT cod_plano, conta_credito.exercicio, SUM(vl_lancamento) AS valor
                                        FROM contabilidade.valor_lancamento
                                            , contabilidade.conta_credito
                                        WHERE conta_credito.cod_lote     = valor_lancamento.cod_lote
                                        AND conta_credito.tipo         = valor_lancamento.tipo
                                        AND conta_credito.sequencia    = valor_lancamento.sequencia
                                        AND conta_credito.exercicio    = valor_lancamento.exercicio
                                        AND conta_credito.tipo_valor   = valor_lancamento.tipo_valor
                                        AND conta_credito.cod_entidade = valor_lancamento.cod_entidade
                                        AND conta_credito.cod_entidade =  \' || intCodEntidade || \'
                                    GROUP BY cod_plano,conta_credito.exercicio
                                    ) AS total_credito
                                ON contabilidade.plano_analitica.cod_plano = total_credito.cod_plano
                                AND contabilidade.plano_analitica.exercicio = total_credito.exercicio
                                WHERE plano_conta.cod_conta     = plano_analitica.cod_conta
                                AND plano_conta.exercicio     = plano_analitica.exercicio
                                AND plano_conta.cod_sistema   = 2
                                AND plano_conta.exercicio     =  \' || quote_literal(varExercicio) || \'
                                AND (    plano_conta.cod_estrutural LIKE \'\'6.3.1.4%\'\'
                                      OR plano_conta.cod_estrutural LIKE \'\'6.3.2.2%\'\'
                                      OR plano_conta.cod_estrutural LIKE \'\'6.3.1.9.1%\'\'
                                      OR plano_conta.cod_estrutural LIKE \'\'6.3.2.9.9%\'\'
                                    )
                                AND NOT ( total_debito.valor IS NULL AND total_credito.valor IS NULL )
                            ORDER BY plano_conta.cod_estrutural \';
                    For recLancamento IN EXECUTE stSql
                    LOOP
                        IF recLancamento.saldo != 0 THEN
                            IF NOT bolCriouLote  THEN
                                intCodLote  := contabilidade.fn_insere_lote( varExercicio
                                                                        , intCodEntidade
                                                                        , \'M\'
                                                                        , \'Orçamentário/\' || varExercicio
                                                                        , \'31-12-\' || varExercicio
                                                                        );
                                bolCriouLote := TRUE;
                            END IF;
        
                            IF substr(recLancamento.cod_estrutural,1,15) = \'6.3.1.4.0.00.00\' THEN
                                intSeqIns := FazerLancamento(\'6.3.1.4.0.00.00.00.00.00\',\'5.3.1.1.0.00.00.00.00.00\',intCodHistorico,varExercicio,RecLancamento.saldo,\'\',intCodlote,CAST(\'M\' AS VARCHAR),intCodEntidade);
                            ELSIF substr(recLancamento.cod_estrutural,1,15) = \'6.3.2.2.0.00.00\' THEN
                                intSeqIns := FazerLancamento(\'6.3.2.2.0.00.00.00.00.00\',\'5.3.2.1.0.00.00.00.00.00\',intCodHistorico,varExercicio,RecLancamento.saldo,\'\',intCodlote,CAST(\'M\' AS VARCHAR),intCodEntidade);
                            ELSIF substr(recLancamento.cod_estrutural,1,15) = \'6.3.1.9.1.00.00\' THEN
                                intSeqIns := FazerLancamento(\'6.3.1.9.1.00.00.00.00.00\',\'5.3.1.2.0.00.00.00.00.00\',intCodHistorico,varExercicio,RecLancamento.saldo,\'\',intCodlote,CAST(\'M\' AS VARCHAR),intCodEntidade);
                            ELSIF substr(recLancamento.cod_estrutural,1,15) = \'6.3.2.9.9.00.00\' THEN
                                intSeqIns := FazerLancamento(\'6.3.2.9.9.00.00.00.00.00\',\'5.3.2.2.0.00.00.00.00.00\',intCodHistorico,varExercicio,RecLancamento.saldo,\'\',intCodlote,CAST(\'M\' AS VARCHAR),intCodEntidade);
                            END IF;
                        END IF;
                    END LOOP;
        
                    --APURA O SALDO DAS CONTAS 5.3.1.2 E 5.3.2.2 JA COM OS LANCAMENTOS ACIMA REALIZADO, E FAZ OS LANCAMENTOS NECESSARIOS
                    stSql := \' SELECT plano_conta.cod_estrutural
                                    , plano_analitica.cod_plano
                                    , coalesce(total_credito.valor,0.00)            AS valor_cre
                                    , coalesce(total_debito.valor,0.00)             AS valor_deb
                                    , ABS(coalesce(( COALESCE(abs(-(total_credito.valor)),0) - COALESCE(total_debito.valor,0) ),0.00)) AS saldo
                                FROM contabilidade.plano_conta
                                    , contabilidade.plano_analitica
                            LEFT JOIN ( SELECT cod_plano, conta_debito.exercicio, SUM(vl_lancamento) AS valor
                                        FROM contabilidade.valor_lancamento
                                            , contabilidade.conta_debito
                                        WHERE conta_debito.cod_lote     = valor_lancamento.cod_lote
                                        AND conta_debito.tipo         = valor_lancamento.tipo
                                        AND conta_debito.sequencia    = valor_lancamento.sequencia
                                        AND conta_debito.exercicio    = valor_lancamento.exercicio
                                        AND conta_debito.tipo_valor   = valor_lancamento.tipo_valor
                                        AND conta_debito.cod_entidade = valor_lancamento.cod_entidade
                                        AND conta_debito.cod_entidade =  \' || intCodEntidade || \'
                                    GROUP BY cod_plano,conta_debito.exercicio
                                    ) AS total_debito
                                ON contabilidade.plano_analitica.cod_plano = total_debito.cod_plano
                                AND contabilidade.plano_analitica.exercicio = total_debito.exercicio
                            LEFT JOIN ( SELECT cod_plano, conta_credito.exercicio, SUM(vl_lancamento) AS valor
                                        FROM contabilidade.valor_lancamento
                                            , contabilidade.conta_credito
                                        WHERE conta_credito.cod_lote     = valor_lancamento.cod_lote
                                        AND conta_credito.tipo         = valor_lancamento.tipo
                                        AND conta_credito.sequencia    = valor_lancamento.sequencia
                                        AND conta_credito.exercicio    = valor_lancamento.exercicio
                                        AND conta_credito.tipo_valor   = valor_lancamento.tipo_valor
                                        AND conta_credito.cod_entidade = valor_lancamento.cod_entidade
                                        AND conta_credito.cod_entidade =  \' || intCodEntidade || \'
                                    GROUP BY cod_plano,conta_credito.exercicio
                                    ) AS total_credito
                                ON contabilidade.plano_analitica.cod_plano = total_credito.cod_plano
                                AND contabilidade.plano_analitica.exercicio = total_credito.exercicio
                                WHERE plano_conta.cod_conta     = plano_analitica.cod_conta
                                AND plano_conta.exercicio     = plano_analitica.exercicio
                                AND plano_conta.cod_sistema   = 2
                                AND plano_conta.exercicio     =  \' || quote_literal(varExercicio) || \'
                                AND (  plano_conta.cod_estrutural LIKE \'\'5.3.1.1%\'\'
                                        OR plano_conta.cod_estrutural LIKE \'\'5.3.2.1%\'\'
                                    )
                                AND NOT ( total_debito.valor IS NULL AND total_credito.valor IS NULL )
                            ORDER BY plano_conta.cod_estrutural\';
        
                    For recLancamento IN EXECUTE stSql
                    LOOP
                        IF recLancamento.saldo != 0 THEN
                            IF NOT bolCriouLote  THEN
                                intCodLote  := contabilidade.fn_insere_lote( varExercicio
                                                                        , intCodEntidade
                                                                        , \'M\'
                                                                        , \'Orçamentário/\' || varExercicio
                                                                        , \'31-12-\' || varExercicio
                                                                        );
                                bolCriouLote := TRUE;
                            END IF;
        
                            IF substr(recLancamento.cod_estrutural,1,15) = \'5.3.1.1.0.00.00\' THEN
                                intSeqIns := FazerLancamento(\'5.3.1.2.0.00.00.00.00.00\',\'5.3.1.1.0.00.00.00.00.00\',intCodHistorico,varExercicio,RecLancamento.saldo,\'\',intCodlote,CAST(\'M\' AS VARCHAR),intCodEntidade);
                            ELSIF substr(recLancamento.cod_estrutural,1,15) = \'5.3.2.1.0.00.00\' THEN
                                intSeqIns := FazerLancamento(\'5.3.2.2.0.00.00.00.00.00\',\'5.3.2.1.0.00.00.00.00.00\',intCodHistorico,varExercicio,RecLancamento.saldo,\'\',intCodlote,CAST(\'M\' AS VARCHAR),intCodEntidade);
                            END IF;
                        END IF;
                    END LOOP;
                END IF; ---- FIM Ticket #22953, APURACAO DE SALDOS E LANCAMENTOS
        
                stSql := \' SELECT plano_conta.cod_estrutural
                                , plano_analitica.cod_plano
                                , coalesce(total_credito.valor,0.00)            AS valor_cre
                                , coalesce(total_debito.valor,0.00)             AS valor_deb
                                , (coalesce(( COALESCE(abs(-(total_credito.valor)),0) - COALESCE(total_debito.valor,0) ),0.00)) AS saldo
                             FROM contabilidade.plano_conta
                                , contabilidade.plano_analitica
                        LEFT JOIN ( SELECT cod_plano, conta_debito.exercicio, SUM(vl_lancamento) AS valor
                                      FROM contabilidade.valor_lancamento
                                         , contabilidade.conta_debito
                                     WHERE conta_debito.cod_lote     = valor_lancamento.cod_lote
                                       AND conta_debito.tipo         = valor_lancamento.tipo
                                       AND conta_debito.sequencia    = valor_lancamento.sequencia
                                       AND conta_debito.exercicio    = valor_lancamento.exercicio
                                       AND conta_debito.tipo_valor   = valor_lancamento.tipo_valor
                                       AND conta_debito.cod_entidade = valor_lancamento.cod_entidade
                                       AND conta_debito.cod_entidade =  \' || intCodEntidade || \'
                                  GROUP BY cod_plano,conta_debito.exercicio
                                ) AS total_debito
                               ON contabilidade.plano_analitica.cod_plano = total_debito.cod_plano
                              AND contabilidade.plano_analitica.exercicio = total_debito.exercicio
                        LEFT JOIN ( SELECT cod_plano, conta_credito.exercicio, SUM(vl_lancamento) AS valor
                                      FROM contabilidade.valor_lancamento
                                         , contabilidade.conta_credito
                                     WHERE conta_credito.cod_lote     = valor_lancamento.cod_lote
                                       AND conta_credito.tipo         = valor_lancamento.tipo
                                       AND conta_credito.sequencia    = valor_lancamento.sequencia
                                       AND conta_credito.exercicio    = valor_lancamento.exercicio
                                       AND conta_credito.tipo_valor   = valor_lancamento.tipo_valor
                                       AND conta_credito.cod_entidade = valor_lancamento.cod_entidade
                                       AND conta_credito.cod_entidade =  \' || intCodEntidade || \'
                                  GROUP BY cod_plano,conta_credito.exercicio
                                ) AS total_credito
                               ON contabilidade.plano_analitica.cod_plano = total_credito.cod_plano
                              AND contabilidade.plano_analitica.exercicio = total_credito.exercicio
                            WHERE plano_conta.cod_conta     = plano_analitica.cod_conta
                              AND plano_conta.exercicio     = plano_analitica.exercicio
                              AND plano_conta.cod_sistema   = 2
                              AND plano_conta.exercicio     =  \' || quote_literal(varExercicio) || \'
                              AND SUBSTR(plano_conta.cod_estrutural,01,01) IN (\'\'5\'\',\'\'6\'\')\';
        
                          IF ( varExercicio <= \'2013\' ) THEN
                            -- Ticket #20198 pede para não zerar os saldos dessas contas específicas
                            stSql := stSql || \'
                                              AND NOT ( plano_conta.cod_estrutural LIKE \'\'5.3.1.7%\'\'
                                                      OR plano_conta.cod_estrutural LIKE \'\'5.3.2.7%\'\'
                                                      OR plano_conta.cod_estrutural LIKE \'\'6.3.1.7%\'\'
                                                      OR plano_conta.cod_estrutural LIKE \'\'6.3.2.7%\'\'
                                            )\';
                        ELSE
                            -- Ticket #22953 pede para não zerar os saldos dessas contas específicas, estas contas mantêm seus saldos para o próximo exercício
                            stSql := stSql || \'
                                              AND NOT ( plano_conta.cod_estrutural LIKE \'\'5.3.1.2%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'5.3.1.3%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'5.3.1.6%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'5.3.2.2%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'5.3.1.7%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'5.3.2.7%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.1.1%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.1.2%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.1.3%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.1.5%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.1.6%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.1.7.1%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.1.7.2%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.2.1%\'\'
                                                       OR plano_conta.cod_estrutural LIKE \'\'6.3.2.7%\'\'
                                                    )\';
                                END IF;
                            stSql := stSql || \'
                            AND NOT ( total_debito.valor IS NULL AND total_credito.valor IS NULL )
                           ORDER BY plano_conta.cod_estrutural \';
                For recLancamento IN EXECUTE stSql
                LOOP
                    IF recLancamento.saldo != 0 THEN
                        IF NOT bolCriouLote  THEN
                            intCodLote  := contabilidade.fn_insere_lote( varExercicio
                                                                       , intCodEntidade
                                                                       , \'M\'
                                                                       , \'Orçamentário/\' || varExercicio
                                                                       , \'31-12-\' || varExercicio
                                                                     );
                            bolCriouLote := TRUE;
                        END IF;
        
                        IF recLancamento.saldo > 0 THEN
                            intSeqIns := contabilidade.fn_insere_lancamentos(varExercicio, RecLancamento.cod_plano, 0,\'\', \'\', RecLancamento.saldo, intCodlote, intCodEntidade, intCodHistorico, CAST(\'M\' AS VARCHAR), \'\');
                        ELSE
                            intSeqIns := contabilidade.fn_insere_lancamentos(varExercicio, 0, RecLancamento.cod_plano,\'\', \'\', ABS(RecLancamento.saldo), intCodlote, intCodEntidade, intCodHistorico, CAST(\'M\' AS VARCHAR), \'\');
                        END IF;
                    END IF;
                END LOOP;
        
               Insert Into administracao.configuracao ( exercicio
                                                      , cod_modulo
                                                      , parametro
                                                      , valor)
                                               Values ( varExercicio
                                                       , 9
                                                       , \'encer_orc_\' || BTRIM(TO_CHAR(intCodEntidade, \'9\'))
                                                       , \'TRUE\');
        
               END IF;
               RETURN;
            END;  $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP FUNCTION contabilidade.encerramentoanuallancamentosorcamentario2013(varexercicio character varying, intcodentidade integer)');
    }
}
