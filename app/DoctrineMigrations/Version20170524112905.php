<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170524112905 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('
            CREATE OR REPLACE FUNCTION economico.fn_busca_sociedade(integer)
                RETURNS character varying[]
                LANGUAGE plpgsql
                AS $function$
                DECLARE
                    reRecord                RECORD;
                    stValor                 VARCHAR[];
                    stSql                   VARCHAR;
                    inInscricaoEconomica    ALIAS FOR $1;
                    inCount                 INTEGER;
                BEGIN
                    stSql := \'
                        SELECT 
                            numcgm as valor
                        FROM
                            economico.sociedade
                        WHERE
                            inscricao_economica = \'||inInscricaoEconomica||\'
                        ORDER BY 
                            quota_socio DESC
                        
                      \';
                
                    inCount := 1;
                    FOR reRecord IN EXECUTE stSql LOOP
                --            stValor := stValor||\',\'|| reRecord.valor;
                        stValor[inCount] := reRecord.valor;
                        inCount := inCount +1;
                    END LOOP;
                
                --        stValor := SUBSTR( stValor, 2, LENGTH(stValor) );
                
                    RETURN stValor;
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

        $this->addSql('DROP FUNCTION economico.fn_busca_sociedade(integer)');
    }
}
