<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171209111334 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("UPDATE organograma.orgao_descricao SET \"timestamp\" = now() WHERE \"timestamp\" <= '0001-12-31'");
        $this->addSql("CREATE OR REPLACE FUNCTION organograma.fn_consulta_orgao(integer, integer)
            RETURNS character varying
            LANGUAGE plpgsql
            AS \$function\$

            DECLARE
                r_record          RECORD;

                v_codigo          VARCHAR;
                v_sql             VARCHAR;

                i_codOrganograma  INTEGER;
                i_codOrgao        INTEGER;

            BEGIN
                v_codigo = '';

                IF TRIM(cast($1 as varchar)) <> '0' THEN

                    i_codOrgao       := $2;
                    i_codOrganograma := $1;

                    v_sql := '
                        SELECT
                            o.valor, ni.mascaracodigo
                        FROM
                             organograma.orgao_nivel as o
                            ,organograma.nivel as ni
                        WHERE o.cod_organograma = ni.cod_organograma
                        AND o.cod_nivel = ni.cod_nivel
                        AND o.cod_organograma  = '||i_codOrganograma||'
                        AND o.cod_orgao  = '||i_codOrgao||'
                        ORDER BY o.cod_nivel
                        ';

                    FOR r_record IN EXECUTE v_sql LOOP
                        --v_codigo := v_codigo||'.'||publico.fn_mascara_dinamica ( ( case when r_record.mascaracodigo = '' then '0' else r_record.mascaracodigo end ) , r_record.valor);
                             v_codigo := v_codigo||'.'||sw_fn_mascara_dinamica ( ( case when r_record.mascaracodigo = '' then '0' else r_record.mascaracodigo end ) , r_record.valor);
                    END LOOP;

                END IF;

                v_codigo := SUBSTR(v_codigo,2,LENGTH(v_codigo));

                RETURN v_codigo;

            END;

            \$function\$
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
