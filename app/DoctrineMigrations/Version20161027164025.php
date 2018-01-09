<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161027164025 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        
        $this->addSql('
        CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_empenhado_pago(character varying, integer, integer)
         RETURNS numeric
         LANGUAGE plpgsql
        AS $function$

        DECLARE
            stExercicio                ALIAS FOR $1;
            inCodEmpenho               ALIAS FOR $2;
            inCodEntidade              ALIAS FOR $3;
            nuValor                    NUMERIC := 0.00;
        BEGIN

            SELECT
                coalesce(sum(NLP.vl_pago),0.00)
                INTO nuValor
            FROM    empenho.empenho              AS EE
                   ,empenho.nota_liquidacao      AS NL
                   ,empenho.nota_liquidacao_paga AS NLP
            WHERE   NLP.cod_nota         = NL.cod_nota
            AND     NLP.exercicio        = NL.exercicio
            AND     NLP.cod_entidade     = NL.cod_entidade
            AND     NL.exercicio_empenho = EE.exercicio
            AND     NL.cod_entidade      = EE.cod_entidade
            AND     NL.cod_empenho       = EE.cod_empenho
            AND     EE.cod_entidade      = inCodEntidade
            AND     EE.cod_empenho       = inCodEmpenho
            AND     EE.exercicio         = stExercicio
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
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP FUNCTION empenho.fn_consultar_valor_empenhado_pago(character varying, integer, integer);');
    }
}
