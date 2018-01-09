<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161114152635 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
        CREATE OR REPLACE FUNCTION contabilidade.fn_insere_lote(character varying, integer, character varying, character varying, character varying)
         RETURNS integer
         LANGUAGE plpgsql
        AS $function$
        DECLARE
            reRecord        RECORD;
            inCodLote       INTEGER;
            chTipo          CHAR := \'\';
            stExercicio     ALIAS FOR $1;
            inCodEntidade   ALIAS FOR $2;
            stTipo          ALIAS FOR $3;
            stNomeLote      ALIAS FOR $4;
            stDataLote      ALIAS FOR $5;
            dtDataLote      DATE;
            stFiltro        VARCHAR := \'\';

        BEGIN
            chTipo      := substr(trim(stTipo),1,1);
            dtDataLote  := to_date(stDataLote,\'dd/mm/yyyy\');
            stFiltro    := \'WHERE exercicio=\' || quote_literal(stExercicio);
            stFiltro    := stFiltro || \' AND tipo = \' || quote_literal(chTipo);
            stFiltro    := stFiltro || \' AND cod_entidade = \' || inCodEntidade;
            inCodLote   := publico.fn_proximo_cod(\'cod_lote\',\'contabilidade.lote\',stFiltro);

            INSERT INTO contabilidade.lote
                (cod_lote,exercicio,tipo,cod_entidade,nom_lote,dt_lote)
            VALUES
                (inCodLote,stExercicio,chTipo,inCodEntidade,stNomeLote,dtDataLote)
                --(1,\'2005\',\'I\',1,\'AA\',to_date(\'01/02/2006\',\'dd/mm/yyyy\'))
            ;

            RETURN inCodLote;
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
        
        $this->addSql('DROP FUNCTION contabilidade.fn_insere_lote(character varying, integer, character varying, character varying, character varying)');
    }
}
