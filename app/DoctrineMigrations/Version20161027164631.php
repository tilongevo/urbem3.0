<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161027164631 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_apagar_nota(character varying, integer, integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            
            DECLARE
                stExercicio                ALIAS FOR $1;
                inCodNota                  ALIAS FOR $2;
                inCodEntidade              ALIAS FOR $3;
                nuValor                    NUMERIC := 0.00;
            BEGIN
            
                SELECT
                    coalesce(sum(PL.vl_pagamento),0.00)
                    INTO nuValor
                FROM     empenho.pagamento_liquidacao AS PL
                        ,empenho.nota_liquidacao      AS NL
                WHERE   PL.cod_nota             = NL.cod_nota
                AND     Pl.exercicio_liquidacao = NL.exercicio
                AND     PL.cod_entidade         = NL.cod_entidade
                AND     NL.cod_entidade         = inCodEntidade
                AND     NL.cod_nota             = inCodNota
                AND     NL.exercicio            = stExercicio
            
            --    AND
            --        PL.cod_ordem || \'-\' || PL.exercicio || \'-\' || PL.cod_entidade || \'-\' || PL.exercicio_liquidacao || \'-\' || PL.cod_nota NOT IN(
            --            SELECT
            --                cod_ordem || \'-\' || exercicio || \'-\' || cod_entidade || \'-\' || exercicio_liquidacao || \'-\' || cod_nota
            --            FROM
            --                empenho.pagamento_liquidacao_nota_liquidacao_paga
            --            WHERE
            --                cod_entidade         = inCodEntidade    AND
            --                cod_nota             = inCodNota        AND
            --                exercicio_liquidacao = stExercicio
            --        )
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

        $this->addSql('DROP FUNCTION empenho.fn_consultar_valor_apagar_nota(character varying, integer, integer)');
    }
}
