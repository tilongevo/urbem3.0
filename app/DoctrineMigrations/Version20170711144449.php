<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170711144449 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("
            CREATE OR REPLACE FUNCTION economico.fn_consulta_situacao_licenca(INT,VARCHAR) RETURNS VARCHAR AS
                'DECLARE
                    reRecord                RECORD;
                    stValor                 VARCHAR := ''Temp'' ;
                    stSql                   VARCHAR;
                    inCodLicenca            ALIAS FOR $1;
                    stExercicio             ALIAS FOR $2;
                inTstLicenca        INTEGER;
                    inCount                 INTEGER;
                BEGIN
                SELECT  a.cod_licenca
                INTO    inTstLicenca
                FROM    economico.licenca a
                WHERE
                    a.cod_licenca =inCodLicenca AND
                    a.exercicio   =stExercicio::varchar  AND
                    a.dt_inicio <= now()::date and
                    Case
                        When a.dt_termino is not null then a.dt_termino >= now()::date
                        Else true::boolean
                    End;

                IF inTstLicenca IS NOT NULL THEN
                -- é ativa, mas pode estar baixada
                inTstLicenca := null;
                SELECT a.cod_tipo
                INTO   inTstLicenca
                FROM   economico.baixa_licenca a
                WHERE
                    a.cod_licenca =inCodLicenca AND
                    a.exercicio   =stExercicio::varchar  AND
                    a.dt_inicio <= now()::date and
                    Case
                        When a.dt_termino is not null then a.dt_termino >= now()::date
                        Else true::boolean
                    End;
                IF inTstLicenca IS NOT NULL THEN
                    SELECT  nom_baixa
                    INTO    stValor
                    FROM    economico.tipo_baixa
                    WHERE cod_tipo = inTstLicenca;

                    IF stValor = ''Suspensão'' THEN
                        stValor := ''Suspensa'';
                    ELSIF stValor = ''Cassação'' THEN
                        stValor := ''Cassada'';
                    ELSE
                        stValor := ''Baixada'';
                    END IF;

                ELSE
                    stValor := ''Ativa'';
                END IF;

                ELSE
                    stValor := '''';
                END IF;

                    RETURN stValor;
                END;'

            language 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION economico.fn_consulta_processo_licenca(INT,VARCHAR) RETURNS VARCHAR AS
                'DECLARE
                    inCodLicenca            ALIAS FOR $1;
                    stExercicio             ALIAS FOR $2;
                    stProcesso              VARCHAR;
                    stSituacao              VARCHAR;
                    stSql                   VARCHAR;
                reRecord        RECORD;
                BEGIN
                stSituacao := economico.fn_consulta_situacao_licenca(inCodLicenca, stExercicio);

                If stSituacao = ''Ativa'' OR stSituacao = ''Expirada'' THEN
                stSql := ''SELECT cod_processo, exercicio_processo
                       FROM economico.processo_licenca
                       WHERE   cod_licenca = ''||inCodLicenca||''
                       AND  exercicio   = ''''''||stExercicio||''''''   '';
                ELSE
                stSql := ''SELECT cod_processo,exercicio_processo
                     FROM   economico.processo_baixa_licenca
                     WHERE   cod_licenca = ''||inCodLicenca||''
                     AND    exercicio   = ''''''||stExercicio||''''''   '';
                END IF;

                FOR reRecord IN EXECUTE stSql LOOP
                    stProcesso := reRecord.cod_processo::varchar||''/''||reRecord.exercicio_processo::varchar ;
                END LOOP;
                    RETURN stProcesso;
                END;'

            language 'plpgsql';
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
