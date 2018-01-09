<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161020075754 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE OR REPLACE FUNCTION contabilidade.fn_saldo_conta_banco(character varying, integer)
         RETURNS numeric
         LANGUAGE plpgsql
        AS $function$
        
        DECLARE
            stExercicio    ALIAS FOR $1;
            inCodPlano     ALIAS FOR $2;
            stSql          VARCHAR := \'\';
            nuVlDebito     NUMERIC := 0.00;
            nuVlCredito    NUMERIC := 0.00;
            reRecord       RECORD;
        
        BEGIN
        
                SELECT coalesce(sum( vl_lancamento ), 0.00 )
                       INTO nuVlDebito
                FROM contabilidade.plano_banco      AS CPB
                    ,contabilidade.plano_analitica  AS CPA
                    ,contabilidade.conta_debito     AS CCD
                    ,contabilidade.valor_lancamento AS CVL
                  -- Join com plano_analitica
                WHERE CPB.exercicio    = CPA.exercicio
                  AND CPB.cod_plano    = CPA.cod_plano
                  -- Join com conta_debito
                  AND CPA.exercicio    = CCD.exercicio
                  AND CPA.cod_plano    = CCD.cod_plano
                  -- Join com valor_lacamento
                  AND CCD.exercicio    = CVL.exercicio
                  AND CCD.cod_entidade = CVL.cod_entidade
                  AND CCD.tipo         = CVL.tipo
                  AND CCD.tipo_valor   = CVL.tipo_valor
                  AND CCD.cod_lote     = CVL.cod_lote
                  AND CCD.sequencia    = CVL.sequencia
                  -- Filtros
                  AND CPA.exercicio    = stExercicio
                  AND CPB.cod_plano    = inCodPlano
                  ;
        
        
                SELECT coalesce(sum( vl_lancamento ), 0.00 )
                       INTO nuVlCredito
                FROM contabilidade.plano_banco      AS CPB
                    ,contabilidade.plano_analitica  AS CPA
                    ,contabilidade.conta_credito    AS CCC
                    ,contabilidade.valor_lancamento AS CVL
                  -- Join com plano_analitica
                WHERE CPB.exercicio    = CPA.exercicio
                  AND CPB.cod_plano    = CPA.cod_plano
                  -- Join com conta_debito
                  AND CPA.exercicio    = CCC.exercicio
                  AND CPA.cod_plano    = CCC.cod_plano
                  -- Join com valor_lacamento
                  AND CCC.exercicio    = CVL.exercicio
                  AND CCC.cod_entidade = CVL.cod_entidade
                  AND CCC.tipo         = CVL.tipo
                  AND CCC.tipo_valor   = CVL.tipo_valor
                  AND CCC.cod_lote     = CVL.cod_lote
                  AND CCC.sequencia    = CVL.sequencia
                  -- Filtros
                  AND CPA.exercicio    = stExercicio
                  AND CPB.cod_plano    = inCodPlano
                  ;
        
        
            RETURN nuVlDebito + nuVlCredito;
        
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

        $this->addSql('DROP FUNCTION contabilidade.fn_saldo_conta_banco(character varying, integer)');
    }
}
