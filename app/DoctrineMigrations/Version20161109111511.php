<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161109111511 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION empenho.retorna_notas(character varying, integer, integer)
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
                                        FROM
                                                empenho.pagamento_liquidacao    as pl
                                        WHERE
                                                pl.exercicio            = \'\'\' || stExercicio     || \'\'\'
                                        AND     pl.cod_ordem            = \' || inCodOrdem      || \'
                                        AND     pl.cod_entidade         = \' || inCodEntidade   || \'
                                    \';
                            FOR reRegistro IN EXECUTE stSql
                            LOOP
                                stSaida := stSaida || reRegistro.cod_nota || \'/\' || reRegistro.exercicio_liquidacao || \'   \n\';
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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION empenho.retorna_notas(character varying, integer, integer)');
    }
}
