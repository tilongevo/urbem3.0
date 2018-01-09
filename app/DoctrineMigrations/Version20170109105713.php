<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170109105713 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('DROP FUNCTION IF EXISTS contabilidade.encerramentoanuallancamentoscontrole2013(varexercicio character varying, intcodentidade integer)');

        $this->addSql('
        CREATE OR REPLACE FUNCTION contabilidade.encerramentoanuallancamentoscontrole2013(varexercicio character varying, intcodentidade integer)
         RETURNS void
         LANGUAGE plpgsql
        AS $function$
        DECLARE
           recLancamento        Record;
           varAux               VARCHAR;
           intCodLote           INTEGER;
           intCodHistorico      INTEGER := 804;
           bolCriouLote         BOOLEAN := FALSE;
        
           intSeqIns            INTEGER := 0;
        
           bolEncerramentoOrcamento        BOOLEAN;
        BEGIN
        
           IF NOT contabilidade.fezEncerramentoAnualLancamentosControle2013( varExercicio, intCodEntidade ) THEN
        
              IF bolEncerramentoOrcamento THEN
                 RAISE EXCEPTION \'Encerramento já realizado......\';
              END IF;
        
              INSERT INTO contabilidade.historico_contabil( cod_historico
                                                          , exercicio
                                                          , nom_historico
                                                          , complemento)
                                                     SELECT intCodHistorico
                                                          , varExercicio
                                                          , \'Encerramento do exercício – Sistema Controle\'
                                                          , \'f\'
                                                       WHERE 0  = ( SELECT Count(1)
                                                                      FROM contabilidade.historico_contabil
                                                                     WHERE cod_historico = intCodHistorico
                                                                       AND exercicio     = varExercicio);
        
              For recLancamento IN SELECT plano_conta.cod_estrutural
                                        , plano_analitica.cod_plano
                                        , coalesce(total_credito.valor,0.00)            AS valor_cre
                                        , coalesce(total_debito.valor,0.00)             AS valor_deb
                                        , coalesce(( COALESCE(abs(-(total_credito.valor)),0) - COALESCE(total_debito.valor,0) ),0.00) AS saldo
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
                                               AND conta_debito.cod_entidade =  intCodEntidade
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
                                               AND conta_credito.cod_entidade = intCodEntidade
                                          GROUP BY cod_plano,conta_credito.exercicio
                                        ) AS total_credito
                                       ON contabilidade.plano_analitica.cod_plano = total_credito.cod_plano
                                      AND contabilidade.plano_analitica.exercicio = total_credito.exercicio
                                    WHERE plano_conta.cod_conta     = plano_analitica.cod_conta
                                      AND plano_conta.exercicio     = plano_analitica.exercicio
                                      AND plano_conta.cod_sistema   = 3
                                      AND plano_conta.exercicio     = varExercicio
        
                                  AND NOT ( plano_conta.cod_estrutural LIKE \'7.9%\' OR plano_conta.cod_estrutural LIKE \'8.9%\' )
        
                                      -- AND ( plano_conta.cod_estrutural LIKE \'7.2.3%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'7.2.4%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.2.1.1.4%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.2.2.1.4%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.2.3%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.2.4%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.3.1.2%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.3.1.3%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.3.2.4%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.3.2.5%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.4.1%\'
                                      --    OR plano_conta.cod_estrutural LIKE \'8.4.2%\' )
        
                                  AND NOT ( total_debito.valor IS NULL AND total_credito.valor IS NULL )
                                 ORDER BY plano_conta.cod_estrutural
              LOOP
                 IF recLancamento.saldo != 0 THEN
                    IF NOT bolCriouLote  THEN
                       intCodLote  := contabilidade.fn_insere_lote( varExercicio
                                                                 , intCodEntidade
                                                                 , \'M\'
                                                                 , \'Controle/\' || varExercicio
                                                                 , \'31-12-\' || varExercicio
                                                                    );
                       bolCriouLote := TRUE;
                    END IF;
        
        
                    varAux            := RecLancamento.cod_estrutural || \' Codigo plano => \' ||recLancamento.cod_plano;
                    intSeqIns         := intSeqIns  + 1;
        
                    -- IF RecLancamento.cod_estrutural LIKE \'8.2.2.1.4%\' THEN
                    --     PERFORM contabilidade.encerramentoAnualLancamentos( varExercicio
                    --                                                       , intSeqIns
                    --                                                       , intCodlote
                    --                                                       , intCodEntidade
                    --                                                       , intCodHistorico
                    --                                                       , RecLancamento.saldo
                    --                                                       , RecLancamento.cod_estrutural
                    --                                                       , \'7.2.2.1.0.00.00\'
                    --                                                       );
                    -- ELSE
                    INSERT INTO contabilidade.lancamento( sequencia
                                                        , cod_lote
                                                        , tipo
                                                        , exercicio
                                                        , cod_entidade
                                                        , cod_historico
                                                        , complemento)
                                                 VALUES ( intSeqIns
                                                        , intCodlote
                                                        , \'M\'
                                                        , varExercicio
                                                        , intCodEntidade
                                                        , intCodHistorico
                                                        , \'\');
        
                    -- VERIFICANDO SE DEVE FAZER LANCAMENTO DE DEBITO OU DE CREDITO
                    CASE SUBSTR(RecLancamento.cod_estrutural,01,01)
                        WHEN \'7\' THEN
        
                            IF (RecLancamento.saldo > 0) THEN
        
                                -- AS CONTAS DO GRUPO 7 DEVEM SER CREDITADAS
                                INSERT INTO contabilidade.valor_lancamento( cod_lote
                                                                          , tipo
                                                                          , sequencia
                                                                          , exercicio
                                                                          , tipo_valor
                                                                          , cod_entidade
                                                                          , vl_lancamento)
                                                                   VALUES ( intCodlote
                                                                          , \'M\'
                                                                          , intSeqIns
                                                                          , varExercicio
                                                                          , \'D\'
                                                                          , intCodEntidade
                                                                          , RecLancamento.saldo);
        
                                INSERT INTO contabilidade.conta_debito ( cod_lote
                                                                       , tipo
                                                                       , sequencia
                                                                       , exercicio
                                                                       , tipo_valor
                                                                       , cod_entidade
                                                                       , cod_plano)
                                                                VALUES ( intCodlote
                                                                       , \'M\'
                                                                       , intSeqIns
                                                                       , varExercicio
                                                                       , \'D\'
                                                                       , intCodEntidade
                                                                       , RecLancamento.cod_plano);
                        ELSE
                                -- AS CONTAS DO GRUPO 7 DEVEM SER CREDITADAS
                                INSERT INTO contabilidade.valor_lancamento( cod_lote
                                                                          , tipo
                                                                          , sequencia
                                                                          , exercicio
                                                                          , tipo_valor
                                                                          , cod_entidade
                                                                          , vl_lancamento)
                                                                   VALUES ( intCodlote
                                                                          , \'M\'
                                                                          , intSeqIns
                                                                          , varExercicio
                                                                          , \'C\'
                                                                          , intCodEntidade
                                                                          , RecLancamento.saldo);
        
                                INSERT INTO contabilidade.conta_credito( cod_lote
                                                                       , tipo
                                                                       , sequencia
                                                                       , exercicio
                                                                       , tipo_valor
                                                                       , cod_entidade
                                                                       , cod_plano)
                                                                VALUES ( intCodlote
                                                                       , \'M\'
                                                                       , intSeqIns
                                                                       , varExercicio
                                                                       , \'C\'
                                                                       , intCodEntidade
                                                                       , RecLancamento.cod_plano);
        
                        END IF;
        
        
                        WHEN \'8\' THEN
        
                            IF (RecLancamento.saldo > 0) THEN
        
                                -- AS CONTAS DO GRUPO 8 DEVEM SER DEBITADAS
                                INSERT INTO contabilidade.valor_lancamento( cod_lote
                                                                          , tipo
                                                                          , sequencia
                                                                          , exercicio
                                                                          , tipo_valor
                                                                          , cod_entidade
                                                                          , vl_lancamento)
                                                                   VALUES ( intCodlote
                                                                          , \'M\'
                                                                          , intSeqIns
                                                                          , varExercicio
                                                                          , \'D\'
                                                                          , intCodEntidade
                                                                          , RecLancamento.saldo);
        
                                INSERT INTO contabilidade.conta_debito( cod_lote
                                                                    , tipo
                                                                    , sequencia
                                                                    , exercicio
                                                                    , tipo_valor
                                                                    , cod_entidade
                                                                    , cod_plano)
                                                             VALUES ( intCodlote
                                                                    , \'M\'
                                                                    , intSeqIns
                                                                    , varExercicio
                                                                    , \'D\'
                                                                    , intCodEntidade
                                                                    , RecLancamento.cod_plano);
                        ELSE
                                INSERT INTO contabilidade.valor_lancamento( cod_lote
                                                                          , tipo
                                                                          , sequencia
                                                                          , exercicio
                                                                          , tipo_valor
                                                                          , cod_entidade
                                                                          , vl_lancamento)
                                                                   VALUES ( intCodlote
                                                                          , \'M\'
                                                                          , intSeqIns
                                                                          , varExercicio
                                                                          , \'C\'
                                                                          , intCodEntidade
                                                                          , RecLancamento.saldo);
        
        
                            IF RecLancamento.cod_estrutural LIKE \'8.2.2.1.4%\' THEN
        
                                INSERT INTO contabilidade.conta_credito( cod_lote
                                                                    , tipo
                                                                    , sequencia
                                                                    , exercicio
                                                                    , tipo_valor
                                                                    , cod_entidade
                                                                    , cod_plano)
                                                             VALUES ( intCodlote
                                                                    , \'M\'
                                                                    , intSeqIns
                                                                    , varExercicio
                                                                    , \'C\'
                                                                    , intCodEntidade
                                                                    , \'7.2.2.1.0.00.00\');
        
                            ELSE
        
                                INSERT INTO contabilidade.conta_credito( cod_lote
                                                                    , tipo
                                                                    , sequencia
                                                                    , exercicio
                                                                    , tipo_valor
                                                                    , cod_entidade
                                                                    , cod_plano)
                                                             VALUES ( intCodlote
                                                                    , \'M\'
                                                                    , intSeqIns
                                                                    , varExercicio
                                                                    , \'C\'
                                                                    , intCodEntidade
                                                                    , RecLancamento.cod_plano);
                            END IF;
                        END IF;
                     ELSE
                    END CASE;
        
                 END IF;
              END LOOP;
        
              Insert Into administracao.configuracao ( exercicio
                                                     , cod_modulo
                                                     , parametro
                                                     , valor)
                                              Values ( varExercicio
                                                      , 9
                                                      , \'encer_ctrl_\' || BTRIM(TO_CHAR(intCodEntidade, \'9\'))
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
        $this->addSql('DROP FUNCTION contabilidade.encerramentoanuallancamentoscontrole2013(varexercicio character varying, intcodentidade integer)');
    }
}
