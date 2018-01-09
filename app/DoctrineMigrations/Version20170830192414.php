<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170830192414 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('
            CREATE OR REPLACE FUNCTION economico.fn_busca_modalidade_atividade(integer, integer, integer)
                 RETURNS character varying
                 LANGUAGE plpgsql
                AS $function$
                declare
                    inInscricaoEconomica      ALIAS FOR $1;
                    inCodAtividade                  ALIAS FOR $2;
                    inOcorrenciaAtividade                  ALIAS FOR $3;
                    
                    stModalidade                  VARCHAR;
                    inCodModalidade                     INTEGER;
                begin
                            
                    SELECT 
                        mod.cod_modalidade, mod.nom_modalidade
                    INTO 
                        inCodModalidade, stModalidade
                    FROM 
                        economico.modalidade_lancamento as mod
                        INNER JOIN economico.cadastro_economico_modalidade_lancamento as ceml
                            ON ceml.cod_modalidade = mod.cod_modalidade
                    WHERE 
                        ceml.inscricao_economica = inInscricaoEconomica
                        and ceml.ocorrencia_atividade = inOcorrenciaAtividade
                        and ceml.cod_atividade = inCodAtividade;
                        
                    
                    IF ( inCodModalidade is not null ) THEN
                            SELECT 
                                mod.cod_modalidade, mod.nom_modalidade
                              INTO
                                inCodModalidade, stModalidade
                              FROM
                                   economico.modalidade_lancamento as mod
                                   INNER JOIN economico.atividade_modalidade_lancamento as aml
                                    ON aml.cod_modalidade = mod.cod_modalidade
                                WHERE
                                    aml.cod_atividade = inCodAtividade ;
                    END IF;
                    
                    IF ( stModalidade is null ) THEN
                        stModalidade := \'Não Informado\';
                    END IF;
                    return stModalidade;
                    --
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
        $this->addSql('DROP FUNCTION IF EXISTS economico.fn_busca_modalidade_atividade(integer, integer, integer)');
    }
}
