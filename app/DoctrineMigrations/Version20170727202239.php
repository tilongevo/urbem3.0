<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170727202239 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("
            CREATE OR REPLACE FUNCTION imobiliario.fn_consulta_cep(integer)
                RETURNS character varying
                LANGUAGE plpgsql
                AS \$function\$
                
                DECLARE
                    reRecord          RECORD;
                
                    stValor          VARCHAR := '';
                    stSql            VARCHAR;
                
                    inCodLogradouro  ALIAS FOR $1;
                
                BEGIN
                    stSql := '
                              SELECT
                                  cep
                              FROM
                                  sw_cep_logradouro
                              WHERE
                                  cod_logradouro = '||inCodLogradouro||'
                              ORDER BY
                                   cep ASC
                              ';
                    FOR reRecord IN EXECUTE stSql LOOP
                        stValor := stValor||', '|| reRecord.cep;
                    END LOOP;
                
                    stValor := SUBSTR( stValor, 3, LENGTH(stValor) );
                
                    RETURN stValor;
                END;
                \$function\$
        ");
        $this->insertRoute('tributario_imobiliario_relatorios_home', 'Cadastro Imobiliário - Relatórios', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_relatorio_logradouro_create', 'Logradouros', 'tributario_imobiliario_relatorios_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP FUNCTION IF EXISTS imobiliario.fn_consulta_cep(integer);");
    }
}
