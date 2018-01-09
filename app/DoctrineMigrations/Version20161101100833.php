<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161101100833 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql(
            'CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_empenhado_anulado_item(character varying, integer, integer, integer) 
            RETURNS numeric
                 LANGUAGE plpgsql
                AS $function$
                
                DECLARE
                    stExercicio                ALIAS FOR $1;
                    inCodEmpenho               ALIAS FOR $2;
                    inCodEntidade              ALIAS FOR $3;
                    inNumItem                  ALIAS FOR $4;
                    nuValorAnulado             NUMERIC := 0.00;
                    inCodPreEmpenho            INTEGER := 0;
                BEGIN
                    SELECT      cod_pre_empenho
                         INTO   inCodPreEmpenho
                    FROM    empenho.empenho
                    WHERE   cod_empenho     = inCodEmpenho
                    AND     exercicio       = stExercicio
                    AND     cod_entidade    = inCodEntidade
                    ;
                
                    SELECT      coalesce(sum(vl_anulado),0.00)
                        INTO    nuValorAnulado
                    FROM    empenho.empenho_anulado_item
                    WHERE   cod_entidade     = inCodEntidade
                    AND     cod_empenho      = inCodEmpenho
                    AND     exercicio        = stExercicio
                    AND     num_item         = inNumItem
                    AND     cod_pre_empenho  = inCodPreEmpenho
                    ;
                
                    IF nuValorAnulado IS NULL THEN
                        nuValorAnulado := 0.00;
                    END IF;
                
                    RETURN nuValorAnulado;
                
                END;
            $function$'
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP FUNCTION empenho.fn_consultar_valor_empenhado_anulado_item(character varying, integer, integer, integer)');
    }
}
