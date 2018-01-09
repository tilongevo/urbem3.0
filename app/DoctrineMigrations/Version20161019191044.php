<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191044 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE OR REPLACE FUNCTION contabilidade.fn_anular_restos_encerramento(character varying, integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $function$

DECLARE
    reRecord            RECORD;
    stOut               VARCHAR := \'\';
    stSql               VARCHAR := \'\';
    stExercicio         ALIAS FOR $1;
    inCodEntidade       ALIAS FOR $2;
    inLotes             INTEGER := 0;

BEGIN

    stSql := \'
        SELECT *
        FROM
             contabilidade.lote as lo
        WHERE  
             exercicio   = \'\'\'|| stExercicio ||\'\'\'
        AND  nom_lote ilike \'\'ENCERRAMENTO DO EXERCÍCIO\'\'
        AND  tipo = \'\'M\'\'
        AND  cod_entidade = \' || inCodEntidade || \'
        \';

    FOR reRecord IN EXECUTE stSql LOOP

        delete from contabilidade.conta_debito      where cod_lote = reRecord.cod_lote and exercicio=\'\'||stExercicio||\'\' and tipo=\'M\' and cod_entidade=reRecord.cod_entidade;
        delete from contabilidade.conta_credito     where cod_lote = reRecord.cod_lote and exercicio=\'\'||stExercicio||\'\' and tipo=\'M\' and cod_entidade=reRecord.cod_entidade;
        delete from contabilidade.valor_lancamento  where cod_lote = reRecord.cod_lote and exercicio=\'\'||stExercicio||\'\' and tipo=\'M\' and cod_entidade=reRecord.cod_entidade;
        delete from contabilidade.lancamento        where cod_lote = reRecord.cod_lote and exercicio=\'\'||stExercicio||\'\' and tipo=\'M\' and cod_entidade=reRecord.cod_entidade;
        delete from contabilidade.lote              where cod_lote = reRecord.cod_lote and exercicio=\'\'||stExercicio||\'\' and tipo=\'M\' and cod_entidade=reRecord.cod_entidade;

        inLotes := inLotes + 1;

    END LOOP;

    UPDATE administracao.configuracao set valor = \'F\' WHERE parametro = \'virada_GF\' and exercicio = \'\'||stExercicio||\'\'; 

    RETURN inLotes;

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

        $this->addSql('DROP FUNCTION contabilidade.fn_anular_restos_encerramento(character varying, integer);');
    }
}
