<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170818144029 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_recursos_humanos_pessoal_rescisao_contrato_servidor_list', 'Rescisão de Contrato', 'recursos_humanos');
        $this->addSql('create or replace VIEW pessoal.vw_rescisaocontratoservidor AS
            SELECT                                                                       
                     pc.registro                                                             
                    ,TO_CHAR(contrato_servidor_nomeacao_posse.dt_nomeacao,\'dd/mm/yyyy\') as dt_nomeacao              
                    ,TO_CHAR(contrato_servidor_nomeacao_posse.dt_posse   ,\'dd/mm/yyyy\') as dt_posse                 
                    ,TO_CHAR(contrato_servidor_nomeacao_posse.dt_admissao   ,\'dd/mm/yyyy\') as dt_admissao                 
                    ,oon.orgao                                                               
                    ,recuperaDescricaoOrgao(oon.cod_orgao,(\'2017-01-01\')::date) as descricao    
                    ,ps.numcgm                                                               
                    ,cgm.nom_cgm                                                             
                    ,pcs.cod_sub_divisao                                                     
                    ,pscs.cod_contrato
                FROM                                                                         
                     pessoal.servidor as ps                                                  
                    ,pessoal.servidor_contrato_servidor as pscs                              
                    ,pessoal.contrato_servidor as pcs                                        
                    ,pessoal.contrato as pc                                                  
                    ,sw_cgm as cgm                                                           
                    ,pessoal.contrato_servidor_nomeacao_posse                                
                    ,(                                                                       
                        SELECT                                                               
                            pcsnp.cod_contrato,                                              
                            MAX ( pcsnp.timestamp ) AS timestamp                             
                        FROM                                                                 
                            pessoal.contrato_servidor_nomeacao_posse pcsnp                   
                        GROUP BY                                                             
                            pcsnp.cod_contrato) AS pcsnp_max                                 
                    ,(                                                                       
                        SELECT                                                               
                             pcso.cod_contrato                                               
                            ,pcso.cod_orgao                                                  
                        FROM                                                                 
                             pessoal.contrato_servidor_orgao pcso                            
                            ,(                                                               
                                SELECT                                                       
                                     cod_contrato                                            
                                    ,MAX(timestamp) as timestamp                             
                                FROM                                                         
                                     pessoal.contrato_servidor_orgao                         
                                GROUP BY                                                     
                                    cod_contrato ) as pcso_max                               
                        WHERE                                                                
                                pcso.cod_contrato = pcso_max.cod_contrato                    
                            AND pcso.timestamp    = pcso_max.timestamp) as pcso              
                    ,organograma.vw_orgao_nivel as oon
                WHERE                                                                        
                        pscs.cod_servidor = ps.cod_servidor                                  
                    AND pcs.cod_contrato = pscs.cod_contrato                                 
                    AND pc.cod_contrato = pcs.cod_contrato                                   
                    AND pcsnp_max.cod_contrato = pcs.cod_contrato                            
                    AND pcso.cod_contrato = pcs.cod_contrato                                 
                    AND oon.cod_orgao = pcso.cod_orgao                                       
                    AND cgm.numcgm = ps.numcgm                                               
                    AND contrato_servidor_nomeacao_posse.cod_contrato = pcsnp_max.cod_contrato 
                    AND contrato_servidor_nomeacao_posse.timestamp = pcsnp_max.timestamp       
                AND pcs.cod_contrato NOT IN (                                            
                        SELECT                                                               
                            cod_contrato                                                     
                        FROM                                                                 
                            pessoal.contrato_servidor_caso_causa )                           
                 ORDER BY                         
                      pc.registro;  ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->removeRoute('urbem_recursos_humanos_pessoal_rescisao_contrato_servidor_list', 'recursos_humanos');
    }
}
