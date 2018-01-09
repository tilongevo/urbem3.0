<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161102143516 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        /**
         * @todo Algumas linhas foram comentadas pois está com raise exception. Será necessário debugar.
         */
        $this->addSql('
            CREATE OR REPLACE FUNCTION public.empenholiquidacaorestosapagartcems(character varying, numeric, character varying, integer, character varying, integer, integer, character varying)
                 RETURNS integer
                 LANGUAGE plpgsql
                AS $function$
                DECLARE                                                                                                                                               
                    EXERCICIO ALIAS FOR $1;                                                                                                                               
                    VALOR ALIAS FOR $2;                                                                                                                                   
                    COMPLEMENTO ALIAS FOR $3;                                                                                                                             
                    CODLOTE ALIAS FOR $4;                                                                                                                                 
                    TIPOLOTE ALIAS FOR $5;                                                                                                                                
                    CODENTIDADE ALIAS FOR $6;                                                                                                                             
                    CODNOTA ALIAS FOR $7;                                                                                                                                 
                    EXERCRP ALIAS FOR $8;                                                                                                                                 
                                                                                                                                                                      
                    SEQUENCIA INTEGER;
                    inCodDespesa INTEGER;
                    INCONTCONFIGURACAO INTEGER := 0;
                    boImplantado BOOLEAN;
                    SQLCONTA VARCHAR := \'\';
                    SQLCONTAFIXA VARCHAR := \'\';
                    SQLCONFIGURACAO VARCHAR := \'\';
                    RECONTA RECORD;
                    REREGISTROSCONTAFIXA RECORD;
                    REREGISTROSCONFIGURACAO RECORD;
                    
                    
                    inExercicioEmpenho VARCHAR := \'\';
                BEGIN 
                
                     inExercicioEmpenho := selectIntoInteger(\' SELECT nota_liquidacao.exercicio_empenho
                                                                 FROM empenho.nota_liquidacao
                                                           INNER JOIN empenho.empenho
                                                                   ON empenho.cod_empenho  = nota_liquidacao.cod_empenho
                                                                  AND empenho.exercicio    = nota_liquidacao.exercicio_empenho
                                                                  AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                                                           INNER JOIN empenho.pre_empenho
                                                                   ON pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
                                                                  AND pre_empenho.exercicio       = empenho.exercicio
                                                           INNER JOIN empenho.pre_empenho_despesa
                                                                   ON pre_empenho_despesa.cod_pre_empenho = pre_empenho.cod_pre_empenho
                                                                  AND pre_empenho_despesa.exercicio       = pre_empenho.exercicio
                                                           INNER JOIN orcamento.despesa
                                                                   ON despesa.cod_despesa = pre_empenho_despesa.cod_despesa
                                                                  AND despesa.exercicio   = pre_empenho_despesa.exercicio
                                                                WHERE nota_liquidacao.cod_nota = \' || CODNOTA || \'
                                                                  AND nota_liquidacao.exercicio = \'\'\'||EXERCICIO||\'\'\'\');
                                                                  
                           inCodDespesa := selectIntoInteger(\' SELECT despesa.cod_despesa
                                                                 FROM empenho.nota_liquidacao
                                                           INNER JOIN empenho.empenho
                                                                   ON empenho.cod_empenho  = nota_liquidacao.cod_empenho
                                                                  AND empenho.exercicio    = nota_liquidacao.exercicio_empenho
                                                                  AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                                                           INNER JOIN empenho.pre_empenho
                                                                   ON pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
                                                                  AND pre_empenho.exercicio       = empenho.exercicio
                                                           INNER JOIN empenho.pre_empenho_despesa
                                                                   ON pre_empenho_despesa.cod_pre_empenho = pre_empenho.cod_pre_empenho
                                                                  AND pre_empenho_despesa.exercicio       = pre_empenho.exercicio
                                                           INNER JOIN orcamento.despesa
                                                                   ON despesa.cod_despesa = pre_empenho_despesa.cod_despesa
                                                                  AND despesa.exercicio   = pre_empenho_despesa.exercicio
                                                                WHERE nota_liquidacao.cod_nota = \' || CODNOTA || \'
                                                                  AND nota_liquidacao.exercicio = \'\'\'||EXERCICIO||\'\'\'\');
                
                    boImplantado := selectIntoBoolean(\' SELECT pre_empenho.implantado
                                                          FROM empenho.nota_liquidacao
                                                    INNER JOIN empenho.empenho
                                                            ON empenho.cod_empenho  = nota_liquidacao.cod_empenho
                                                           AND empenho.exercicio    = nota_liquidacao.exercicio_empenho
                                                           AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                                                    INNER JOIN empenho.pre_empenho
                                                            ON pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
                                                           AND pre_empenho.exercicio       = empenho.exercicio
                                                         WHERE nota_liquidacao.cod_nota = \' || CODNOTA || \'
                                                           AND nota_liquidacao.exercicio = \'\'\'||EXERCICIO||\'\'\'
                                                           \');
                
                    IF EXERCICIO::integer > 2013 THEN
                        IF boImplantado = FALSE THEN
                            SQLCONFIGURACAO := \'
                                    SELECT REPLACE(plano_analitica_debito.cod_plano::VARCHAR, \'\'.\'\', \'\'\'\')::integer AS conta_debito
                                         , REPLACE(plano_analitica_credito.cod_plano::VARCHAR, \'\'.\'\', \'\'\'\')::integer AS conta_credito
                                         , configuracao_lancamento_debito.cod_conta_despesa
                                         , REPLACE(plano_conta_debito.cod_estrutural, \'\'.\'\', \'\'\'\') as estrutural_debito
                                         , REPLACE(plano_conta_credito.cod_estrutural, \'\'.\'\', \'\'\'\') as estrutural_credito
                                      FROM empenho.nota_liquidacao
                                INNER JOIN empenho.empenho
                                        ON empenho.cod_empenho  = nota_liquidacao.cod_empenho
                                       AND empenho.exercicio    = nota_liquidacao.exercicio_empenho
                                       AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                                INNER JOIN empenho.pre_empenho
                                        ON pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
                                       AND pre_empenho.exercicio       = empenho.exercicio
                                INNER JOIN empenho.pre_empenho_despesa
                                        ON pre_empenho_despesa.cod_pre_empenho = pre_empenho.cod_pre_empenho
                                       AND pre_empenho_despesa.exercicio       = pre_empenho.exercicio
                                INNER JOIN orcamento.conta_despesa
                                        ON conta_despesa.cod_conta = pre_empenho_despesa.cod_conta
                                       AND conta_despesa.exercicio = pre_empenho_despesa.exercicio
                                INNER JOIN contabilidade.configuracao_lancamento_credito
                                        ON configuracao_lancamento_credito.cod_conta_despesa = conta_despesa.cod_conta
                                       AND configuracao_lancamento_credito.exercicio         = \'\'\'||EXERCICIO||\'\'\'
                                INNER JOIN contabilidade.configuracao_lancamento_debito
                                        ON configuracao_lancamento_credito.exercicio = configuracao_lancamento_debito.exercicio
                                       AND configuracao_lancamento_credito.cod_conta_despesa = configuracao_lancamento_debito.cod_conta_despesa
                                       AND configuracao_lancamento_credito.tipo = configuracao_lancamento_debito.tipo
                                       AND configuracao_lancamento_credito.estorno = configuracao_lancamento_debito.estorno
                                INNER JOIN contabilidade.plano_conta plano_conta_credito
                                        ON plano_conta_credito.cod_conta = configuracao_lancamento_credito.cod_conta
                                       AND plano_conta_credito.exercicio = configuracao_lancamento_credito.exercicio
                                INNER JOIN contabilidade.plano_analitica plano_analitica_credito
                                        ON plano_conta_credito.cod_conta = plano_analitica_credito.cod_conta
                                       AND plano_conta_credito.exercicio = plano_analitica_credito.exercicio
                                INNER JOIN contabilidade.plano_conta plano_conta_debito
                                        ON plano_conta_debito.cod_conta = configuracao_lancamento_debito.cod_conta
                                       AND plano_conta_debito.exercicio = configuracao_lancamento_debito.exercicio
                                INNER JOIN contabilidade.plano_analitica plano_analitica_debito
                                        ON plano_conta_debito.cod_conta = plano_analitica_debito.cod_conta
                                       AND plano_conta_debito.exercicio = plano_analitica_debito.exercicio
                                     WHERE configuracao_lancamento_credito.estorno = \'\'false\'\'
                                       AND configuracao_lancamento_credito.exercicio = \'\'\'||EXERCICIO||\'\'\'
                                       AND configuracao_lancamento_credito.tipo = \'\'liquidacao\'\'
                                       AND nota_liquidacao.cod_nota = \' || CODNOTA || \'
                                       AND nota_liquidacao.exercicio = \'\'\'||EXERCICIO||\'\'\'
                            \';
                        ELSE
                            SQLCONFIGURACAO := \'
                                    SELECT REPLACE(plano_analitica_debito.cod_plano::VARCHAR, \'\'.\'\', \'\'\'\')::integer AS conta_debito
                                         , REPLACE(plano_analitica_credito.cod_plano::VARCHAR, \'\'.\'\', \'\'\'\')::integer AS conta_credito
                                         , configuracao_lancamento_debito.cod_conta_despesa
                                         , REPLACE(plano_conta_debito.cod_estrutural, \'\'.\'\', \'\'\'\') as estrutural_debito
                                         , REPLACE(plano_conta_credito.cod_estrutural, \'\'.\'\', \'\'\'\') as estrutural_credito
                                      FROM empenho.nota_liquidacao
                                INNER JOIN empenho.empenho
                                        ON empenho.cod_empenho  = nota_liquidacao.cod_empenho
                                       AND empenho.exercicio    = nota_liquidacao.exercicio_empenho
                                       AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                                INNER JOIN empenho.pre_empenho
                                        ON pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
                                       AND pre_empenho.exercicio       = empenho.exercicio
                                INNER JOIN empenho.restos_pre_empenho
                                        ON restos_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
                                       AND restos_pre_empenho.exercicio       = pre_empenho.exercicio
                                INNER JOIN orcamento.conta_despesa
                                        ON REPLACE(conta_despesa.cod_estrutural, \'\'.\'\', \'\'\'\') = restos_pre_empenho.cod_estrutural
                                       AND conta_despesa.exercicio = \'\'\'||EXERCICIO||\'\'\'
                                INNER JOIN contabilidade.configuracao_lancamento_credito
                                        ON configuracao_lancamento_credito.cod_conta_despesa = conta_despesa.cod_conta
                                       AND configuracao_lancamento_credito.exercicio         = \'\'\'||EXERCICIO||\'\'\'
                                INNER JOIN contabilidade.configuracao_lancamento_debito
                                        ON configuracao_lancamento_credito.exercicio = configuracao_lancamento_debito.exercicio
                                       AND configuracao_lancamento_credito.cod_conta_despesa = configuracao_lancamento_debito.cod_conta_despesa
                                       AND configuracao_lancamento_credito.tipo = configuracao_lancamento_debito.tipo
                                       AND configuracao_lancamento_credito.estorno = configuracao_lancamento_debito.estorno
                                INNER JOIN contabilidade.plano_conta plano_conta_credito
                                        ON plano_conta_credito.cod_conta = configuracao_lancamento_credito.cod_conta
                                       AND plano_conta_credito.exercicio = configuracao_lancamento_credito.exercicio
                                INNER JOIN contabilidade.plano_analitica plano_analitica_credito
                                        ON plano_conta_credito.cod_conta = plano_analitica_credito.cod_conta
                                       AND plano_conta_credito.exercicio = plano_analitica_credito.exercicio
                                INNER JOIN contabilidade.plano_conta plano_conta_debito
                                        ON plano_conta_debito.cod_conta = configuracao_lancamento_debito.cod_conta
                                       AND plano_conta_debito.exercicio = configuracao_lancamento_debito.exercicio
                                INNER JOIN contabilidade.plano_analitica plano_analitica_debito
                                        ON plano_conta_debito.cod_conta = plano_analitica_debito.cod_conta
                                       AND plano_conta_debito.exercicio = plano_analitica_debito.exercicio
                                     WHERE configuracao_lancamento_credito.estorno = \'\'false\'\'
                                       AND configuracao_lancamento_credito.exercicio = \'\'\'||EXERCICIO||\'\'\'
                                       AND configuracao_lancamento_credito.tipo = \'\'liquidacao\'\'
                                       AND nota_liquidacao.cod_nota = \' || CODNOTA || \'
                                       AND nota_liquidacao.exercicio = \'\'\'||EXERCICIO||\'\'\'
                            \';
                        END IF;
                    
                        FOR REREGISTROSCONFIGURACAO IN EXECUTE SQLCONFIGURACAO
                        LOOP
                            SEQUENCIA := FAZERLANCAMENTO(  REREGISTROSCONFIGURACAO.estrutural_debito , REREGISTROSCONFIGURACAO.estrutural_credito , 916 , EXERCICIO , VALOR , COMPLEMENTO , CODLOTE , TIPOLOTE , CODENTIDADE , REREGISTROSCONFIGURACAO.conta_debito, REREGISTROSCONFIGURACAO.conta_credito );
                            INCONTCONFIGURACAO := INCONTCONFIGURACAO + 1;
                        END LOOP;
                
                        IF ( INCONTCONFIGURACAO = 0 ) THEN
                            -- RAISE EXCEPTION \'Configuração dos lançamentos de despesa não configurados para esta despesa.\';
                        END IF;
                    END IF;
                
                    SQLCONTAFIXA := \'
                            SELECT debito.cod_estrutural AS estrutural_debito
                                 , credito.cod_estrutural AS estrutural_credito
                                 , debito.cod_plano AS plano_debito
                                 , credito.cod_plano AS plano_credito
                                 , debito.exercicio
                              FROM (
                                     SELECT plano_conta.cod_estrutural
                                          , plano_analitica.cod_plano
                                          , plano_conta.exercicio
                                       FROM contabilidade.plano_conta
                                 INNER JOIN contabilidade.plano_analitica
                                         ON plano_conta.cod_conta = plano_analitica.cod_conta
                                        AND plano_conta.exercicio = plano_analitica.exercicio
                                      WHERE REPLACE(plano_conta.cod_estrutural, \'\'.\'\',  \'\'\'\') LIKE \'\'6311%\'\'
                                   ) AS debito
                        INNER JOIN (
                                     SELECT plano_conta.cod_estrutural
                                          , plano_analitica.cod_plano
                                          , plano_conta.exercicio
                                       FROM contabilidade.plano_conta
                                 INNER JOIN contabilidade.plano_analitica
                                         ON plano_conta.cod_conta = plano_analitica.cod_conta
                                        AND plano_conta.exercicio = plano_analitica.exercicio
                                      WHERE REPLACE(plano_conta.cod_estrutural, \'\'.\'\', \'\'\'\') LIKE \'\'6313%\'\'
                                   ) AS credito
                                 ON debito.exercicio = credito.exercicio
                              WHERE debito.exercicio = \'\'\'||EXERCICIO||\'\'\'
                    \';
                
                    FOR REREGISTROSCONTAFIXA IN EXECUTE SQLCONTAFIXA
                    LOOP
                            SEQUENCIA := FAZERLANCAMENTO(  REREGISTROSCONTAFIXA.estrutural_debito , REREGISTROSCONTAFIXA.estrutural_credito , 916 , EXERCICIO , VALOR , COMPLEMENTO , CODLOTE , TIPOLOTE , CODENTIDADE , REREGISTROSCONTAFIXA.plano_debito, REREGISTROSCONTAFIXA.plano_credito );
                    END LOOP;
                
                    
                    INCONTCONFIGURACAO = 0;
                
                    IF EXERCICIO::integer > 2013 THEN
                        IF boImplantado = FALSE THEN
                            SQLCONTAFIXA := \'
                        SELECT tabela_debito.plano_debito
                             , tabela_debito.estrutural_debito
                             , tabela_credito.plano_credito
                             , tabela_credito.estrutural_credito
                          FROM orcamento.despesa
                          JOIN orcamento.recurso
                            ON recurso.cod_recurso = despesa.cod_recurso
                           AND recurso.exercicio   = despesa.exercicio
                          JOIN ( SELECT plano_recurso.cod_recurso
                                      , plano_recurso.exercicio
                                      , plano_analitica.cod_plano AS plano_debito
                                      , plano_conta.cod_estrutural AS estrutural_debito
                                   FROM contabilidade.plano_recurso
                                   JOIN contabilidade.plano_analitica
                                     ON plano_analitica.cod_plano = plano_recurso.cod_plano
                                    AND plano_analitica.exercicio = plano_recurso.exercicio
                                   JOIN contabilidade.plano_conta
                                     ON plano_conta.cod_conta = plano_analitica.cod_conta
                                    AND plano_conta.exercicio = plano_analitica.exercicio
                                  WHERE plano_conta.cod_estrutural LIKE \'\'8.2.1.1.2%\'\'
                                    AND plano_conta.exercicio = \'\'\'||EXERCICIO||\'\'\'
                             ) AS tabela_debito
                            ON tabela_debito.cod_recurso = recurso.cod_recurso
                          JOIN ( SELECT plano_recurso.cod_recurso
                                      , plano_recurso.exercicio
                                      , plano_analitica.cod_plano AS plano_credito
                                      , plano_conta.cod_estrutural AS estrutural_credito
                                   FROM contabilidade.plano_recurso
                                   JOIN contabilidade.plano_analitica
                                     ON plano_analitica.cod_plano = plano_recurso.cod_plano
                                    AND plano_analitica.exercicio = plano_recurso.exercicio
                                   JOIN contabilidade.plano_conta
                                     ON plano_conta.cod_conta = plano_analitica.cod_conta
                                    AND plano_conta.exercicio = plano_analitica.exercicio
                                  WHERE plano_conta.cod_estrutural LIKE \'\'8.2.1.1.3%\'\'
                                    AND plano_conta.exercicio = \'\'\'||EXERCICIO||\'\'\'
                             ) AS tabela_credito
                            ON tabela_credito.cod_recurso = recurso.cod_recurso
                         WHERE despesa.cod_despesa = \'||inCodDespesa||\'
                           AND despesa.exercicio = \'\'\'||inExercicioEmpenho||\'\'\'
                            \';
                        ELSE
                            SQLCONTAFIXA := \'
                        SELECT tabela_debito.plano_debito
                             , tabela_debito.estrutural_debito
                             , tabela_credito.plano_credito
                             , tabela_credito.estrutural_credito
                          FROM empenho.nota_liquidacao
                    INNER JOIN empenho.empenho
                            ON empenho.cod_empenho  = nota_liquidacao.cod_empenho
                           AND empenho.exercicio    = nota_liquidacao.exercicio_empenho
                           AND empenho.cod_entidade = nota_liquidacao.cod_entidade
                    INNER JOIN empenho.pre_empenho
                            ON pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho
                           AND pre_empenho.exercicio       = empenho.exercicio
                    INNER JOIN empenho.restos_pre_empenho
                            ON restos_pre_empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
                           AND restos_pre_empenho.exercicio       = pre_empenho.exercicio
                          JOIN ( SELECT plano_recurso.cod_recurso
                                      , plano_recurso.exercicio
                                      , plano_analitica.cod_plano AS plano_debito
                                      , plano_conta.cod_estrutural AS estrutural_debito
                                   FROM contabilidade.plano_recurso
                                   JOIN contabilidade.plano_analitica
                                     ON plano_analitica.cod_plano = plano_recurso.cod_plano
                                    AND plano_analitica.exercicio = plano_recurso.exercicio
                                   JOIN contabilidade.plano_conta
                                     ON plano_conta.cod_conta = plano_analitica.cod_conta
                                    AND plano_conta.exercicio = plano_analitica.exercicio
                                  WHERE plano_conta.cod_estrutural LIKE \'\'8.2.1.1.2%\'\'
                                    AND plano_conta.exercicio = \'\'\'||EXERCICIO||\'\'\'
                             ) AS tabela_debito
                            ON tabela_debito.cod_recurso = restos_pre_empenho.recurso
                          JOIN ( SELECT plano_recurso.cod_recurso
                                      , plano_recurso.exercicio
                                      , plano_analitica.cod_plano AS plano_credito
                                      , plano_conta.cod_estrutural AS estrutural_credito
                                   FROM contabilidade.plano_recurso
                                   JOIN contabilidade.plano_analitica
                                     ON plano_analitica.cod_plano = plano_recurso.cod_plano
                                    AND plano_analitica.exercicio = plano_recurso.exercicio
                                   JOIN contabilidade.plano_conta
                                     ON plano_conta.cod_conta = plano_analitica.cod_conta
                                    AND plano_conta.exercicio = plano_analitica.exercicio
                                  WHERE plano_conta.cod_estrutural LIKE \'\'8.2.1.1.3%\'\'
                                    AND plano_conta.exercicio = \'\'\'||EXERCICIO||\'\'\'
                             ) AS tabela_credito
                            ON tabela_credito.cod_recurso = restos_pre_empenho.recurso
                         WHERE nota_liquidacao.cod_nota  = \' || CODNOTA || \'
                           AND nota_liquidacao.exercicio = \'\'\'||EXERCICIO||\'\'\'
                            \';
                        END IF;
                    
                        FOR REREGISTROSCONTAFIXA IN EXECUTE SQLCONTAFIXA
                        LOOP
                            SEQUENCIA := FAZERLANCAMENTO(  REREGISTROSCONTAFIXA.estrutural_debito , REREGISTROSCONTAFIXA.estrutural_credito , 916 , EXERCICIO , VALOR , COMPLEMENTO , CODLOTE , TIPOLOTE , CODENTIDADE , REREGISTROSCONTAFIXA.plano_debito, REREGISTROSCONTAFIXA.plano_credito );
                            INCONTCONFIGURACAO := INCONTCONFIGURACAO + 1;
                        END LOOP;
                 
                         IF ( INCONTCONFIGURACAO = 0 ) THEN
                            -- RAISE EXCEPTION \'Contas do recurso não cadastradas!.\';
                         END IF;
                    END IF;
                
                      RETURN SEQUENCIA;                                                                                                                                     
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

        $this->addSql('DROP FUNCTION public.empenholiquidacaorestosapagartcems(character varying, numeric, character varying, integer, character varying, integer, integer, character varying)');
    }
}
