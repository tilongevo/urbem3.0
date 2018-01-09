<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170524150046 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE FUNCTION public.fn_conceder_desoneracao_grupo(integer, character varying, character varying)
                 RETURNS integer
                 LANGUAGE plpgsql
                AS $function$
                DECLARE
                     desoneracao     ALIAS FOR $1;
                     regraConcessao  ALIAS FOR $2;
                     tipoDesoneracao ALIAS FOR $3;
                     stSql           varchar;
                     reRecord        record;
                     iCount          integer := 0;    
                 
                BEGIN
                
                    IF tipoDesoneracao = \'II\' THEN
                   
                    stSql := \' 
                          SELECT
                              I.INSCRICAO_MUNICIPAL, 
                              IP.NUMCGM
                          FROM
                              IMOBILIARIO.IMOVEL AS I
                          LEFT JOIN (
                              SELECT
                                  BAL.*
                              FROM
                                  imobiliario.baixa_imovel AS BAL,
                                  (
                                  SELECT
                                      MAX (TIMESTAMP) AS TIMESTAMP,
                                      inscricao_municipal
                                  FROM
                                      imobiliario.baixa_imovel
                                  GROUP BY
                                      inscricao_municipal
                                  ) AS BT
                              WHERE
                                  BAL.inscricao_municipal = BT.inscricao_municipal AND
                                  BAL.timestamp = BT.timestamp
                          ) bi
                          ON
                              I.inscricao_municipal = bi.inscricao_municipal
                           LEFT JOIN imobiliario.proprietario AS IP
                           ON
                           IP.inscricao_municipal = I.inscricao_municipal
                          WHERE
                              ((bi.dt_inicio IS NULL) OR (bi.dt_inicio IS NOT NULL AND bi.dt_termino IS NOT NULL)
                              AND bi.inscricao_municipal=I.inscricao_municipal)
                              AND \'||regraConcessao||\'(I.INSCRICAO_MUNICIPAL) = true
                    \'; 
                
                
                    FOR reRecord IN EXECUTE stSql LOOP
                  
                        PERFORM 1 FROM arrecadacao.desonerado  WHERE numcgm  = reRecord.numcgm AND cod_desoneracao = desoneracao;
                
                        IF NOT FOUND then
                            INSERT INTO arrecadacao.desonerado (cod_desoneracao, numcgm, data_concessao, data_prorrogacao, data_revogacao, ocorrencia) VALUES ( desoneracao, reRecord.numcgm, now()::date, null, null, 1  );
                        END IF;
                
                        --PERFORM 1 FROM arrecadacao.desonerado_imovel  WHERE numcgm  = reRecord.numcgm AND cod_desoneracao = desoneracao AND inscricao_municipal =  reRecord.inscricao_municipal;
                             
                        --IF NOT FOUND THEN
                            INSERT INTO arrecadacao.desonerado_imovel VALUES ( reRecord.numcgm, desoneracao, reRecord.inscricao_municipal, 1 );
                        --END IF;
                          iCount := iCount + 1 ;
                 
                    END LOOP;
                
                    ELSIF tipoDesoneracao  = \'IE\' THEN
                    
                    stSql := \' 
                            SELECT DISTINCT                                                                              
                               COALESCE (                                                                                
                                   ef.numcgm,                                                                          
                                   ed.numcgm,                                                                         
                                   au.numcgm                                                                          
                               ) AS numcgm,                                                                           
                               ce.inscricao_economica,                                                          
                               ce.timestamp,                                                                          
                               TO_CHAR(ce.dt_abertura,\'\'dd/mm/yyyy\'\') as dt_abertura,               
                               cgm.nom_cgm,                                                                         
                               CASE                                                                                          
                                   WHEN                                                                                     
                                       CAST( ef.numcgm AS VARCHAR) IS NOT NULL                            
                                       THEN \'\'1\'\'                                                                              
                                   WHEN                                                                                     
                                       CAST( au.numcgm AS VARCHAR) IS NOT NULL                           
                                       THEN \'\'3\'\'                                                                             
                                   WHEN                                                                                     
                                       cast( ed.numcgm as varchar) is not null                           
                                   THEN \'\'2\'\'                                                                             
                                END AS enquadramento,                                                           
                              economico.fn_busca_sociedade(ce.inscricao_economica) AS sociedade    
                           FROM                                                                                                    
                                   economico.cadastro_economico AS ce                                            
                                   LEFT JOIN economico.cadastro_economico_empresa_fato AS ef       
                                   ON ce.inscricao_economica = ef.inscricao_economica                    
                                   LEFT JOIN economico.cadastro_economico_autonomo AS au           
                                   ON ce.inscricao_economica = au.inscricao_economica                   
                                   LEFT JOIN economico.cadastro_economico_empresa_direito AS ed  
                                   ON ce.inscricao_economica = ed.inscricao_economica                   
                                   LEFT JOIN economico.baixa_cadastro_economico AS ba                   
                                   ON ce.inscricao_economica = ba.inscricao_economica,                  
                                  sw_cgm AS cgm                                                                                 
                            WHERE                                                                                                    
                                  COALESCE (                                                                                         
                                      ef.numcgm,                                                                                   
                                      ed.numcgm,                                                                                  
                                      au.numcgm                                                                                   
                                  ) = cgm.numcgm                                                                              
                            AND ba.inscricao_economica IS NULL
                            AND \'||regraConcessao||\'(ce.inscricao_economica) = TRUE
                
                            ORDER BY ce.inscricao_economica 
                       \';
                
                          FOR reRecord IN EXECUTE stSql LOOP
                
                          PERFORM 1 FROM arrecadacao.desonerado  WHERE numcgm  = reRecord.numcgm AND cod_desoneracao = desoneracao;
                
                          IF NOT FOUND then
                             INSERT INTO arrecadacao.desonerado (cod_desoneracao, numcgm, data_concessao, data_prorrogacao, data_revogacao, ocorrencia) VALUES ( desoneracao, reRecord.numcgm, now()::date, null, null, 1  );
                          END IF;
                
                          --PERFORM 1 FROM arrecadacao.desonerado_cad_economico  WHERE numcgm  = reRecord.numcgm AND cod_desoneracao = desoneracao AND inscricao_economica =  reRecord.inscricao_economica;
                         
                          --IF NOT FOUND THEN
                
                             INSERT INTO arrecadacao.desonerado_cad_economico VALUES ( reRecord.numcgm, desoneracao, reRecord.inscricao_economica, 1 );
                          --END IF;     
                
                          iCount := iCount + 1 ;
                
                    END LOOP;
                
                    END IF;
                    
                RETURN iCount; 
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
        $this->addSql('DROP FUNCTION public.fn_conceder_desoneracao_grupo(integer, character varying, character varying)');
    }
}
