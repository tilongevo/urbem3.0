<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161109111215 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION empenho.retorna_empenhos(character varying, integer, integer)
                         RETURNS character varying
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            stExercicio         ALIAS FOR $1;
                            inCodOrdem          ALIAS FOR $2;
                            inCodEntidade       ALIAS FOR $3;
                            stSaida             VARCHAR   := \'\';
                            stSql               VARCHAR   := \'\';
                            reRegistro          RECORD;
                        BEGIN
                            stSql := \'
                                        SELECT
                                                 pl.cod_nota
                                                ,pl.exercicio_liquidacao
                                                ,nl.cod_empenho
                                                ,nl.exercicio_empenho
                                        FROM
                                                empenho.pagamento_liquidacao    as pl
                                               ,empenho.nota_liquidacao         as nl
                                        WHERE
                                                pl.exercicio_liquidacao = nl.exercicio
                                        AND     pl.cod_nota             = nl.cod_nota
                                        AND     pl.cod_entidade         = nl.cod_entidade
                                        AND     pl.exercicio            = \'\'\' || stExercicio     || \'\'\'
                                        AND     pl.cod_ordem            = \' || inCodOrdem      || \'
                                        AND     pl.cod_entidade         = \' || inCodEntidade   || \'
                                    \';
                            FOR reRegistro IN EXECUTE stSql
                            LOOP
                                stSaida := stSaida || reRegistro.cod_empenho || \'/\'|| reRegistro.exercicio_empenho  || \'   \n\';
                            END LOOP;
                        
                            stSaida := substr(stSaida,0,length(stSaida)-3);
                        
                            RETURN stSaida;
                        END;
                        $function$
                        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE OR REPLACE FUNCTION empenho.retorna_empenhos(character varying, integer, integer)');
    }
}
