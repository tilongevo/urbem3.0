<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161202093432 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE OR REPLACE FUNCTION contabilidade.fezencerramentoanuallancamentosorcamentario2013(varexercicio character varying, intcodentidade integer)
             RETURNS boolean
             LANGUAGE plpgsql
            AS $function$
            DECLARE
               bolFezLancamto BOOLEAN := FALSE;
            BEGIN
            
               PERFORM 1
                  FROM administracao.configuracao
                 WHERE exercicio =  varExercicio
                  AND cod_modulo = 9
                  AND parametro  =  \'encer_orc_\' || BTRIM(TO_CHAR(intCodEntidade, \'9\'));
            
               IF FOUND  THEN
                  bolFezLancamto := TRUE;
               END IF;
            
               RETURN bolFezLancamto;
            END;  $function$

        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP FUNCTION contabilidade.fezencerramentoanuallancamentosorcamentario2013(varexercicio character varying, intcodentidade integer)');
    }
}
