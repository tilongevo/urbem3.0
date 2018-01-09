<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161027164915 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_liquidado_anulado_nota(character varying, integer, integer, integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            
            DECLARE
                stExercicio                ALIAS FOR $1;
                inCodEmpenho               ALIAS FOR $2;
                inCodEntidade              ALIAS FOR $3;
                inCodNota                  ALIAS FOR $4;
                nuValorLiquidacaoAnulada   NUMERIC := 0.00;
            BEGIN
                SELECT
                    coalesce(sum(IA.vl_anulado),0.00)
                    INTO    nuValorLiquidacaoAnulada
                FROM     empenho.nota_liquidacao               AS NL
                        ,empenho.nota_liquidacao_item          AS LI
                        ,empenho.nota_liquidacao_item_anulado  AS IA
                WHERE
                        LI.exercicio         = NL.exercicio
                AND     LI.cod_nota          = NL.cod_nota
                AND     LI.cod_entidade      = NL.cod_entidade
                AND     IA.cod_entidade      = LI.cod_entidade
                AND     IA.cod_nota          = LI.cod_nota
                AND     IA.exercicio         = LI.exercicio
                AND     IA.cod_pre_empenho   = LI.cod_pre_empenho
                AND     IA.num_item          = LI.num_item
                AND     NL.cod_entidade      = inCodEntidade
                AND     NL.cod_empenho       = inCodEmpenho
                AND     NL.exercicio         = stExercicio
                AND     NL.cod_nota          = inCodNota
                ;
            
                IF nuValorLiquidacaoAnulada IS NULL THEN
                    nuValorLiquidacaoAnulada := 0.00;
                END IF;
            
                RETURN nuValorLiquidacaoAnulada;
            
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

        $this->addSql('DROP FUNCTION empenho.fn_consultar_valor_liquidado_anulado_nota(character varying, integer, integer, integer)');
    }
}
