<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161109112050 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_pagamento_anulado_ordem(character varying, integer, integer)
                         RETURNS numeric
                         LANGUAGE plpgsql
                        AS $function$
                        
                        DECLARE
                            stExercicio                ALIAS FOR $1;
                            inCodOrdem                 ALIAS FOR $2;
                            inCodEntidade              ALIAS FOR $3;
                            nuValor                    NUMERIC := 0.00;
                        BEGIN
                        
                            SELECT
                                coalesce(sum(vl_anulado),0.00)
                                INTO nuValor
                            FROM     empenho.ordem_pagamento_liquidacao_anulada
                            WHERE   cod_entidade  = inCodEntidade
                            AND     cod_ordem     = inCodOrdem
                            AND     exercicio     = stExercicio
                            ;
                        
                            IF nuValor IS NULL THEN
                                nuValor := 0.00;
                            END IF;
                        
                            RETURN nuValor;
                        
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
        $this->addSql('CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_pagamento_anulado_ordem(character varying, integer, integer)');
    }
}
