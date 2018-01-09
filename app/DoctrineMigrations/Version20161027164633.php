<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161027164633 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        
        $this->addSql('
        CREATE OR REPLACE FUNCTION empenho.fn_consultar_valor_empenhado_pago_anulado(character varying, integer, integer)
         RETURNS numeric
         LANGUAGE plpgsql
        AS $function$

        DECLARE
            stExercicio                ALIAS FOR $1;
            inCodEmpenho               ALIAS FOR $2;
            inCodEntidade              ALIAS FOR $3;
            nuValor                    NUMERIC := 0.00;
        BEGIN

        set search_path = empenho,public;
        select
                sum( coalesce( nota_liquidacao_paga_anulada.vl_anulado, 0 ) ) as vl_anulado
                    INTO nuValor
                from nota_liquidacao, nota_liquidacao_paga_anulada, empenho e
                where e.exercicio    = nota_liquidacao.exercicio_empenho and
                       e.cod_empenho  = nota_liquidacao.cod_empenho       and
                       e.cod_entidade = nota_liquidacao.cod_entidade      and
                       nota_liquidacao.exercicio                      = nota_liquidacao_paga_anulada.exercicio    and
                       nota_liquidacao.cod_nota                       = nota_liquidacao_paga_anulada.cod_nota     and
                       nota_liquidacao.cod_entidade                   = nota_liquidacao_paga_anulada.cod_entidade and
                       e.cod_empenho  = inCodEmpenho   and
                       e.cod_entidade = inCodEntidade  and
                       e.exercicio    = stExercicio
                group by e.exercicio,
                          e.cod_empenho,
                          e.cod_entidade,
                          nota_liquidacao.exercicio_empenho,
                          nota_liquidacao.cod_empenho,
                          nota_liquidacao.cod_entidade
        ;

            IF nuValor IS NULL THEN
                nuValor := 0.00;
            END IF;

            SET search_path = public, pg_catalog;

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

        $this->addSql('DROP FUNCTION empenho.fn_consultar_valor_empenhado_pago_anulado(character varying, integer, integer);');
    }
}
