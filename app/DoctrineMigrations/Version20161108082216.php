<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161108082216 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('
            CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_pagamento_nota(character varying, integer, integer)
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

        $this->addSql('DROP FUNCTION empenho.fn_consultar_valor_pagamento_nota(character varying, integer, integer)');
    }
}
