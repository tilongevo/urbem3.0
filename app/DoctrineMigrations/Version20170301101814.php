<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170301101814 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE FUNCTION orcamento.fn_masc_orgao(stexercicio character varying)
             RETURNS character varying
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                stRetorno       VARCHAR = \'\';
            BEGIN
            
                SELECT split_part(valor, \'.\', 1) AS masc_orgao FROM administracao.configuracao WHERE parametro = \'masc_despesa\' AND exercicio = stExercicio INTO stRetorno;
            
                RETURN stRetorno;
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
        $this->addSql('DROP FUNCTION orcamento.fn_masc_orgao(stexercicio character varying);');
    }
}
