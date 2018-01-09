<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161101101809 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('
            CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_liquidado_anulado_item(character varying, integer, integer, integer)
                 RETURNS numeric
                 LANGUAGE plpgsql
                AS $function$
                
                DECLARE
                    stExercicio                ALIAS FOR $1;
                    inCodEmpenho               ALIAS FOR $2;
                    inCodEntidade              ALIAS FOR $3;
                    inNumItem                  ALIAS FOR $4;
                    nuValorLiquidacaoAnulada   NUMERIC := 0.00;
                BEGIN
                
                    SELECT
                        coalesce(sum(IA.vl_anulado),0.00)
                        INTO nuValorLiquidacaoAnulada
                    FROM     empenho.empenho                       AS  E
                            ,empenho.nota_liquidacao               AS NL
                            ,empenho.nota_liquidacao_item          AS LI
                            ,empenho.nota_liquidacao_item_anulado  AS IA
                    WHERE   E.cod_entidade       = inCodEntidade
                    AND     E.cod_empenho        = inCodEmpenho
                    AND     E.exercicio          = stExercicio
                    AND     NL.exercicio_empenho = E.exercicio
                    AND     NL.cod_empenho       = E.cod_empenho
                    AND     NL.cod_entidade      = E.cod_entidade
                    AND     LI.exercicio         = NL.exercicio
                    AND     LI.cod_nota          = NL.cod_nota
                    AND     LI.cod_entidade      = NL.cod_entidade
                    AND     LI.cod_pre_empenho   = E.cod_pre_empenho
                    AND     LI.num_item          = inNumItem
                    AND     IA.cod_entidade      = LI.cod_entidade
                    AND     IA.cod_nota          = LI.cod_nota
                    AND     IA.exercicio         = LI.exercicio
                    AND     IA.num_item          = LI.num_item
                    AND     IA.cod_pre_empenho   = LI.cod_pre_empenho
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
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP FUNCTION empenho.fn_consultar_valor_liquidado_anulado_item(character varying, integer, integer, integer)');
    }
}
