<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171024115021 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE FUNCTION public.tr_situacao_contrato_servidor()
             RETURNS trigger
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                stSchema        VARCHAR := \'\';
                stEntidade      VARCHAR := \'\';
                inCodPeriodo    INTEGER;
                stSQL           VARCHAR;
            BEGIN
            
                SELECT nspname
                  INTO stSchema
                  FROM pg_namespace
                  JOIN pg_class
                    ON pg_class.relnamespace = pg_namespace.oid
                 WHERE pg_class.oid = TG_RELID
                     ;
            
                IF substr(stSchema, length(stSchema)-1, 1) = \'_\' THEN
                    stEntidade := substr(stSchema, length(stSchema)-1, 2);
                END IF;
            
                IF TG_OP = \'INSERT\' THEN
                    inCodPeriodo := selectintointeger(\'
                                                          SELECT cod_periodo_movimentacao
                                                            FROM folhapagamento\'|| stEntidade ||\'.periodo_movimentacao
                                                        ORDER BY cod_periodo_movimentacao DESc
                                                           LIMIT 1
                                                               ;
                                                      \');
            
                    stSQL := \'
                               INSERT
                                 INTO \'|| stSchema ||\'.contrato_servidor_situacao
                                    ( cod_contrato
                                    , situacao
                                    , timestamp
                                    , cod_periodo_movimentacao
                                    , situacao_literal
                                    )
                               VALUES
                                    ( \'|| NEW.cod_contrato ||\'
                                    , \'|| quote_literal(\'A\') ||\',
                                    \'\'\' || now() ||\'\'\'
                                    , \'|| inCodPeriodo ||\'
                                    , \'|| quote_literal(\'Ativo\') ||\'
                                    );
                             \';
            
                    EXECUTE stSQL;
                    RETURN NEW;
                
                ELSEIF TG_OP = \'DELETE\' THEN
                    stSQL := \'
                               DELETE FROM \'|| stSchema ||\'.contrato_servidor_situacao
                                WHERE cod_contrato = \'|| OLD.cod_contrato ||\'
                                    ;
                             \';
                    EXECUTE stSQL;
                    RETURN OLD;
                
                ELSE
                    RETURN NEW;
                END IF;
            
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
    }
}
