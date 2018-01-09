<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161027165027 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_liquidado_nota(character varying, integer, integer, integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            
            DECLARE
                stExercicio                ALIAS FOR $1;
                inCodEmpenho               ALIAS FOR $2;
                inCodEntidade              ALIAS FOR $3;
                inCodNota                  ALIAS FOR $4;
                nuValorLiquidacao          NUMERIC := 0.00;
            BEGIN
            
                SELECT
                    coalesce(sum(LI.vl_total),0.00)
                    INTO    nuValorLiquidacao
                FROM     empenho.empenho               AS  E
                        ,empenho.nota_liquidacao       AS NL
                        ,empenho.nota_liquidacao_item  AS LI
                WHERE   NL.exercicio         = stExercicio
                AND     NL.exercicio_empenho = E.exercicio
                AND     NL.cod_empenho       = E.cod_empenho
                AND     NL.cod_entidade      = E.cod_entidade
                AND     LI.exercicio         = NL.exercicio
                AND     LI.cod_nota          = NL.cod_nota
                AND     LI.cod_entidade      = NL.cod_entidade
                AND     E.cod_entidade       = inCodEntidade
                AND     E.cod_empenho        = inCodEmpenho
                AND     LI.cod_nota          = inCodNota
                ;
            
                IF nuValorLiquidacao IS NULL THEN
                    nuValorLiquidacao := 0.00;
                END IF;
            
                RETURN nuValorLiquidacao;
            
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

        $this->addSql('DROP FUNCTION empenho.fn_consultar_valor_liquidado_nota(character varying, integer, integer, integer)');
    }
}
