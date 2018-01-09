<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170808194315 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_arrecadacao_consultas_consulta_financeira_imovel_list', 'Consulta Financeira de Imóvel', 'tributario_arrecadacao_consultas_home');
        $this->insertRoute('urbem_tributario_arrecadacao_consultas_consulta_financeira_imovel_show', 'Ver Imóvel', 'urbem_tributario_arrecadacao_consultas_consulta_financeira_imovel_list');
        $this->addSql('
            CREATE OR REPLACE FUNCTION arrecadacao.buscavalorlancadolancamento(integer, character varying)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            declare
                inCodLancamento        ALIAS FOR $1;
                stExercicio                   ALIAS FOR $2;
                nuValor                        numeric;
            begin
            -- Lancamento do Calculo do Imovel
                    select sum( alc.valor )
                      into nuValor
                      from
                        arrecadacao.calculo as calc
                        INNER JOIN arrecadacao.lancamento_calculo alc ON alc.cod_calculo = calc.cod_calculo
                     where
                       alc.cod_lancamento = inCodLancamento
                       and calc.exercicio = stExercicio
                     ;

               return nuValor;
            end;
            $function$');
        $this->addSql('
            CREATE OR REPLACE FUNCTION arrecadacao.buscavalorcalculadolancamento(integer, character varying)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            declare
                inCodLancamento        ALIAS FOR $1;
                stExercicio                   ALIAS FOR $2;
                nuValor                        numeric;
            begin
            -- Lancamento do Calculo do Imovel
                    select sum(calc.valor)
                      into nuValor
                      from
                        arrecadacao.calculo as calc
                        INNER JOIN arrecadacao.lancamento_calculo alc ON alc.cod_calculo = calc.cod_calculo
                     where
                       alc.cod_lancamento = inCodLancamento
                       and calc.exercicio = stExercicio
                     ;

               return nuValor;
            end;
            $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
