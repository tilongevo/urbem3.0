<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170913201832 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE FUNCTION arrecadacao.fn_numeracao_migrada(character varying)
             RETURNS character varying
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                stNumeracao     ALIAS FOR $1;
                stRetorno       VARCHAR;
                reRegistro      RECORD;
                stSql           VARCHAR;
            BEGIN

                -- Consulta o valor do carne migrado
                stSql := \' SELECT
                                numeracao_migracao
                            FROM
                                arrecadacao.carne_migracao
                            WHERE
                                numeracao = \'\'\'||stNumeracao||\'\'\';
                        \';

                FOR reRegistro IN EXECUTE stSql LOOP
                    stRetorno := trim(reRegistro.numeracao_migracao);
                END LOOP;

                return stRetorno;
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
    }
}
