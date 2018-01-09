<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161122160935 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE FUNCTION public.empenhopagamento (
                CHARACTER VARYING,
                numeric,
                CHARACTER VARYING,
                INTEGER,
                CHARACTER VARYING,
                INTEGER,
                INTEGER,
                CHARACTER VARYING,
                CHARACTER VARYING,
                INTEGER,
                BOOLEAN,
                INTEGER,
                INTEGER )
            RETURNS INTEGER LANGUAGE plpgsql AS $FUNCTION$ DECLARE EXERCICIO ALIAS FOR $1;
            VALOR ALIAS FOR $2;
            COMPLEMENTO ALIAS FOR $3;
            CODLOTE ALIAS FOR $4;
            TIPOLOTE ALIAS FOR $5;
            CODENTIDADE ALIAS FOR $6;
            CODNOTA ALIAS FOR $7;
            CONTAPAGAMENTOFINANC ALIAS FOR $8;
            CLASDESPESA ALIAS FOR $9;
            NUMORGAO ALIAS FOR $10;
            BOTCEMS ALIAS FOR $11;
            CODPLANODEBITO ALIAS FOR $12;
            CODPLANOCREDITO ALIAS FOR $13;
            SEQUENCIA INTEGER;
            SQLCONTAFIXA varchar := \'\';
            REREGISTROSCONTAFIXA RECORD;
            BEGIN
                IF EXERCICIO::INTEGER > 2012 THEN SQLCONTAFIXA := \'
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
                                           WHERE REPLACE(plano_conta.cod_estrutural, \'\'.\'\', \'\'\'\') LIKE \'\'622130300%\'\'
                                        ) AS debito
                             INNER JOIN (
                                          SELECT plano_conta.cod_estrutural
                                               , plano_analitica.cod_plano
                                               , plano_conta.exercicio
                                            FROM contabilidade.plano_conta
                                      INNER JOIN contabilidade.plano_analitica
                                              ON plano_conta.cod_conta = plano_analitica.cod_conta
                                             AND plano_conta.exercicio = plano_analitica.exercicio
                                           WHERE REPLACE(plano_conta.cod_estrutural, \'\'.\'\', \'\'\'\') LIKE \'\'622130400%\'\'
                                        ) AS credito
                                      ON debito.exercicio = credito.exercicio
                                   WHERE debito.exercicio = \'\'\' || EXERCICIO || \'\'\'
                         \';
            FOR REREGISTROSCONTAFIXA IN EXECUTE SQLCONTAFIXA LOOP SEQUENCIA := FAZERLANCAMENTO (
                REREGISTROSCONTAFIXA.estrutural_debito,
                REREGISTROSCONTAFIXA.estrutural_credito,
                903,
                EXERCICIO,
                VALOR,
                COMPLEMENTO,
                CODLOTE,
                TIPOLOTE,
                CODENTIDADE,
                REREGISTROSCONTAFIXA.plano_debito,
                REREGISTROSCONTAFIXA.plano_credito );
            END LOOP;
            SEQUENCIA := FAZERLANCAMENTO (
                CONTAPAGAMENTOFINANC,
                CLASDESPESA,
                903,
                EXERCICIO,
                VALOR,
                COMPLEMENTO,
                CODLOTE,
                TIPOLOTE,
                CODENTIDADE,
                CODPLANODEBITO,
                CODPLANOCREDITO );
            ELSE SEQUENCIA := FAZERLANCAMENTO (
                \'292410402000000\',
                \'292410403000000\',
                903,
                EXERCICIO,
                VALOR,
                COMPLEMENTO,
                CODLOTE,
                TIPOLOTE,
                CODENTIDADE );
            SEQUENCIA := EMPENHOPAGAMENTOFINANCEIROTIPOCREDOR (
                EXERCICIO,
                VALOR,
                COMPLEMENTO,
                CODLOTE,
                TIPOLOTE,
                CODENTIDADE,
                CODNOTA,
                CONTAPAGAMENTOFINANC,
                CLASDESPESA,
                NUMORGAO );
            END IF;
            IF EXERCICIO::INTEGER = 2013 THEN SQLCONTAFIXA := \'
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
                                           WHERE REPLACE(plano_conta.cod_estrutural, \'\'.\'\', \'\'\'\') LIKE \'\'622920903%\'\'
                                        ) AS debito
                             INNER JOIN (
                                          SELECT plano_conta.cod_estrutural
                                               , plano_analitica.cod_plano
                                               , plano_conta.exercicio
                                            FROM contabilidade.plano_conta
                                      INNER JOIN contabilidade.plano_analitica
                                              ON plano_conta.cod_conta = plano_analitica.cod_conta
                                             AND plano_conta.exercicio = plano_analitica.exercicio
                                           WHERE REPLACE(plano_conta.cod_estrutural, \'\'.\'\', \'\'\'\') LIKE \'\'622920904%\'\'
                                        ) AS credito
                                      ON debito.exercicio = credito.exercicio
                                   WHERE debito.exercicio = \'\'\' || EXERCICIO || \'\'\'
                         \';
            FOR REREGISTROSCONTAFIXA IN EXECUTE SQLCONTAFIXA LOOP SEQUENCIA := FAZERLANCAMENTO (
                REREGISTROSCONTAFIXA.estrutural_debito,
                REREGISTROSCONTAFIXA.estrutural_credito,
                903,
                EXERCICIO,
                VALOR,
                COMPLEMENTO,
                CODLOTE,
                TIPOLOTE,
                CODENTIDADE,
                REREGISTROSCONTAFIXA.plano_debito,
                REREGISTROSCONTAFIXA.plano_credito );
            END LOOP;
            END IF;
            RETURN SEQUENCIA;
            END;
            $FUNCTION$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        
        $this->addSql('DROP FUNCTION public.empenhopagamento(character varying, numeric, character varying, integer, character varying, integer, integer, character varying, character varying, integer, boolean, integer, integer)');
    }
}
