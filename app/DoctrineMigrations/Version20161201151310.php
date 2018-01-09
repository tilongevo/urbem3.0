<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201151310 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('
        CREATE OR REPLACE FUNCTION contabilidade.saldo_conta_banco_recurso(character varying, integer, integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            DECLARE
            
                stExercicio   ALIAS FOR $1;
                inCodRecurso  ALIAS FOR $2;
                inCodEntidade ALIAS FOR $3;
            
                flValor      NUMERIC := 0;
            
            BEGIN
                IF(inCodRecurso = 0)
                THEN
                     SELECT SUM(COALESCE(contabilidade.fn_saldo_conta_banco(plano_analitica.exercicio,plano_analitica.cod_plano),0)) AS saldo
                      INTO flValor
                      FROM contabilidade.plano_analitica
                INNER JOIN contabilidade.plano_banco
                        ON plano_analitica.exercicio = plano_banco.exercicio
                       AND plano_analitica.cod_plano = plano_banco.cod_plano
                     WHERE plano_analitica.exercicio = stExercicio
                       AND plano_banco.cod_entidade  = inCodEntidade
                       AND NOT EXISTS ( SELECT 1
                                          FROM contabilidade.plano_recurso
                                         WHERE plano_analitica.exercicio = plano_recurso.exercicio
                                           AND plano_analitica.cod_plano = plano_recurso.cod_plano
                                      );
            
                ELSE
                    SELECT SUM(COALESCE(contabilidade.fn_saldo_conta_banco(plano_analitica.exercicio,plano_analitica.cod_plano),0)) AS saldo
                      INTO flValor
                      FROM contabilidade.plano_recurso
                INNER JOIN contabilidade.plano_analitica
                        ON plano_recurso.exercicio = plano_analitica.exercicio
                       AND plano_recurso.cod_plano = plano_analitica.cod_plano
                INNER JOIN contabilidade.plano_banco
                        ON plano_analitica.exercicio = plano_banco.exercicio
                       AND plano_analitica.cod_plano = plano_banco.cod_plano
                     WHERE plano_recurso.exercicio   = stExercicio
                       AND plano_recurso.cod_recurso = inCodRecurso
                       AND plano_banco.cod_entidade  = inCodEntidade;
            
                END IF;
            
                RETURN flValor;
            
            END;
            
            $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP FUNCTION contabilidade.saldo_conta_banco_recurso(character varying, integer, integer)');
    }
}
