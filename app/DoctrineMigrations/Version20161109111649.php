<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161109111649 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION empenho.verifica_adiantamento(character varying, integer, integer)
                         RETURNS boolean
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            stExercicio         ALIAS FOR $1;
                            inCodOrdem          ALIAS FOR $2;
                            inCodEntidade       ALIAS FOR $3;
                            boSaida             BOOLEAN  := false;
                            stSql               VARCHAR  := \'\';
                            reRegistro          RECORD;
                        BEGIN
                            stSql := \'
                                    select 
                                        em.cod_categoria 
                                    from     
                                    empenho.pagamento_liquidacao as pl 
                                    join empenho.nota_liquidacao as nl   
                                    on (    nl.exercicio    = pl.exercicio_liquidacao   
                                        and nl.cod_entidade = pl.cod_entidade   
                                        and nl.cod_nota     = pl.cod_nota   
                                      )   
                                    join empenho.empenho as em   
                                    on (     em.cod_empenho  = nl.cod_empenho   
                                        and em.cod_entidade = nl.cod_entidade   
                                        and em.exercicio    = nl.exercicio_empenho   
                                      )
                                    WHERE 
                                            pl.exercicio    = \'\'\' || stExercicio   || \'\'\'   
                                        and pl.cod_entidade = \' || inCodEntidade || \'   
                                        and pl.cod_ordem    = \' || inCodOrdem    || \'           
                                    \';
                            FOR reRegistro IN EXECUTE stSql
                            LOOP
                                IF reRegistro.cod_categoria = 2 OR reRegistro.cod_categoria = 3
                                    THEN boSaida := true ;
                                END IF;
                         
                            END LOOP;
                        
                            RETURN boSaida;
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
        $this->addSql('CREATE OR REPLACE FUNCTION empenho.verifica_adiantamento(character varying, integer, integer)');
    }
}
