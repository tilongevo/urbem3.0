<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170322193027 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION tesouraria.fn_ordem_pagamento_estorno(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying)
         RETURNS SETOF record
         LANGUAGE plpgsql
        AS $function$
        DECLARE
        
            stExercicioBoletim  ALIAS FOR $1;
            stExercicioEmpenho  ALIAS FOR $2;
            stCodEntidade       ALIAS FOR $3;
            inCodOrdemInicial   ALIAS FOR $4;
            inCodOrdemFinal     ALIAS FOR $5;
            inCodEmpenhoInicial ALIAS FOR $6;       
            inCodEmpenhoFinal   ALIAS FOR $7;        
            inCodNotaInicial    ALIAS FOR $8;
            inCodNotaFinal      ALIAS FOR $9;
            inNumCgm            ALIAS FOR $10;
         
            stFiltroOrdem       VARCHAR := \'\';
            stFiltroEmpLiq      VARCHAR := \'\';
            stFiltroPrestacao   VARCHAR := \'\';
            stFiltroPagTes      VARCHAR := \'\'; 
            stSql               VARCHAR := \'\';
            reRecord            RECORD;
            flTotalOrdem        DECIMAL(14,2) := 0;
            flTotalNota         DECIMAL(14,2) := 0;
            arOrdemInserida     VARCHAR[];
        BEGIN
           
            arOrdemInserida[0] = \'\';
             
            --monta os filtros para a consulta
            IF stExercicioBoletim <> \'\' THEN
                stFiltroPagTes := stFiltroPagTes || \' AND TP.exercicio_boletim = \'\'\'|| stExercicioBoletim ||\'\'\'  \';
            END IF;
            IF stCodEntidade <> \'\' THEN
                stFiltroPagTes := stFiltroPagTes || \' AND TP.cod_entidade IN ( \' || stCodEntidade || \' ) \';
            END IF; 
            IF inCodOrdemInicial <> \'\' THEN
                stFiltroOrdem := stFiltroOrdem || \' AND EPLNLP.cod_ordem >= \' || inCodOrdemInicial || \' \';
            END IF; 
            IF inCodOrdemFinal <> \'\' THEN
                stFiltroOrdem := stFiltroOrdem || \' AND EPLNLP.cod_ordem <= \' || inCodOrdemFinal || \' \';
            END IF;
            IF inCodEmpenhoInicial <> \'\' THEN
                stFiltroEmpLiq := stFiltroEmpLiq || \' AND EE.cod_empenho >= \' || inCodEmpenhoInicial || \' \';
            END IF; 
            IF inCodEmpenhoFinal <> \'\' THEN
                stFiltroEmpLiq := stFiltroEmpLiq || \' AND EE.cod_empenho <= \' || inCodEmpenhoFinal || \' \';
            END IF; 
            IF stExercicioEmpenho <> \'\' THEN
                stFiltroEmpLiq := stFiltroEmpLiq || \' AND EE.exercicio = \'\'\' || stExercicioEmpenho || \'\'\' \';
            END IF; 
            IF inCodNotaInicial <> \'\' THEN
                stFiltroEmpLiq := stFiltroEmpLiq || \' AND ENL.cod_nota >= \' || inCodNotaInicial || \' \';
            END IF;
            IF inCodNotaFinal <> \'\' THEN
                stFiltroEmpLiq := stFiltroEmpLiq || \' AND ENL.cod_nota <= \' || inCodNotaFinal || \' \';
            END IF; 
            IF inNumCgm <> \'\' THEN
                stFiltroEmpLiq := stFiltroEmpLiq || \' AND EPE.cgm_beneficiario = \' || inNumCgm || \' \';
            END IF;
            
            stFiltroPrestacao := \' AND vl_pago - vl_prestado > 0.00 \';
        
            --cria uma tabela temporaria para armazenar os dados de retorno
            CREATE TEMPORARY TABLE tmp_retorno(
                exercicio            VARCHAR,
                empenho_pagamento    VARCHAR, 
                exercicio_liquidacao VARCHAR,
                exercicio_empenho    VARCHAR,
                cod_entidade         INTEGER,
                cod_empenho          INTEGER,
                cod_nota             INTEGER,
                empenho              VARCHAR,
                nota                 VARCHAR,
                ordem                VARCHAR,
                beneficiario         VARCHAR,
                vl_nota              DECIMAL(14,2),
                vl_ordem             DECIMAL(14,2),
                vl_prestado          DECIMAL(14,2),
                cod_conta            INTEGER,
                nom_conta            VARCHAR
            );
        
            stSql := \'
            CREATE TEMPORARY TABLE tmp_ordem_pagamento_estorno AS
                SELECT EOP.exercicio
                     , EOP.exercicio AS empenho_pagamento
                     , CGM.exercicio_liquidacao
                     , CGM.exercicio_empenho                                                                                   
                     , EOP.cod_entidade                                                                                
                     , EOP.cod_empenho                                                                                
                     , EOP.cod_nota                                                                                
                     , empenho.retorna_empenhos( EOP.exercicio, EOP.cod_ordem, EOP.cod_entidade ) AS empenho           
                     , empenho.retorna_notas   ( EOP.exercicio, EOP.cod_ordem, EOP.cod_entidade ) AS nota              
                     , EOP.cod_ordem||\'\'/\'\'||EOP.exercicio as ordem                                                      
                     , CGM.nom_cgm AS beneficiario                                                                     
                     , 0.00 AS vl_nota                                                                                 
                     , coalesce(EOP.vl_pago,0.00) as vl_ordem                                                          
                     , coalesce(CGM.vl_prestado,0.00) as vl_prestado                                                   
                     , EOP.cod_conta as cod_conta                                                                                  
                     , EOP.nom_conta                                                                                  
                     , CASE WHEN ordem_pagamento_retencao.cod_ordem IS NOT NULL
                            THEN TRUE
                            ELSE FALSE
                       END AS retencao 
                  FROM ( SELECT EPLNLP.cod_ordem                                                                          
                              , ENLP.cod_entidade                                                                       
                              , ENLP.cod_empenho                                                                       
                              , EPLNLP.exercicio                                                                          
                              , EPLNLP.cod_nota                                                                          
                              , sum(coalesce(ENLP.vl_pago,0.00)) as vl_pago                                               
                              , ENLP.cod_conta AS cod_conta                                                    
                              , ENLP.nom_conta AS nom_conta                                                    
                           FROM empenho.pagamento_liquidacao_nota_liquidacao_paga as EPLNLP                                 
                     INNER JOIN ( SELECT TP.exercicio                                                                       
                                       , TP.cod_entidade                                                                    
                                       , TP.cod_nota                                                                        
                                       , TP.timestamp                                                                       
                                       , (coalesce(ENLP.vl_pago,0.00) - coalesce(TPE.vl_anulado,0.00)) as vl_pago
                                       , CPC.cod_conta as cod_conta
                                       , CPC.nom_conta as nom_conta
                                       , ENL.cod_empenho
                                    FROM tesouraria.pagamento AS TP                                                           
                               LEFT JOIN ( SELECT ENLPA.cod_nota                                                            
                                                , ENLPA.cod_entidade                                                        
                                                , ENLPA.exercicio                                                           
                                                , ENLPA.timestamp                                                           
                                                , sum(coalesce(ENLPA.vl_anulado,0.00)) as vl_anulado                        
                                             FROM tesouraria.pagamento_estornado as TPE 
                                       INNER JOIN empenho.nota_liquidacao_paga_anulada as ENLPA                                 
                                               ON ENLPA.cod_entidade         = TPE.cod_entidade
                                              AND ENLPA.exercicio             = TPE.exercicio 
                                              AND ENLPA.timestamp             = TPE.timestamp
                                              AND ENLPA.timestamp_anulada     = TPE.timestamp_anulado
                                         GROUP BY ENLPA.cod_nota                                                          
                                                , ENLPA.cod_entidade                                                      
                                                , ENLPA.exercicio                                                         
                                                , ENLPA.timestamp                                                         
                                         ) AS TPE 
                                        ON TP.cod_nota     = TPE.cod_nota                                             
                                       AND TP.cod_entidade = TPE.cod_entidade                                         
                                       AND TP.exercicio    = TPE.exercicio                                            
                                       AND TP.timestamp    = TPE.timestamp                                            
                                 LEFT JOIN contabilidade.plano_analitica AS CPA
                                        ON TP.cod_plano=CPA.cod_plano 
                                       AND TP.exercicio = CPA.exercicio
                                 LEFT JOIN contabilidade.plano_conta AS CPC
                                        ON CPC.exercicio=CPA.exercicio 
                                       AND CPC.cod_conta = CPA.cod_conta
                                         , empenho.nota_liquidacao_paga as ENLP
                                         , empenho.nota_liquidacao AS ENL
                                     WHERE TP.exercicio    = ENLP.exercicio                                                    
                                       AND TP.cod_entidade = ENLP.cod_entidade                                                 
                                       AND TP.cod_nota     = ENLP.cod_nota                                                     
                                       AND TP.timestamp    = ENLP.timestamp
                                       AND ENLP.exercicio    = ENL.exercicio
                                       AND ENLP.cod_entidade = ENL.cod_entidade 
                                       AND ENLP.cod_nota     = ENL.cod_nota    
                                       \' || stFiltroPagTes || \' 
                                    ) as ENLP 
                                   ON ENLP.exercicio    = EPLNLP.exercicio_liquidacao                                                
                                  AND ENLP.cod_entidade = EPLNLP.cod_entidade                                             
                                  AND ENLP.cod_nota     = EPLNLP.cod_nota                                                 
                                  AND ENLP.timestamp    = EPLNLP.timestamp              
                                WHERE coalesce(ENLP.vl_pago,0.00) > 0.00                                                        
                                      \' || stFiltroOrdem || \' 
                             GROUP BY EPLNLP.cod_ordem                                                                        
                                    , ENLP.cod_entidade                                                                     
                                    , EPLNLP.cod_nota                                                                     
                                    , ENLP.cod_empenho                                                                     
                                    , EPLNLP.exercicio                                                                        
                                    , ENLP.cod_conta                                                                          
                                    , ENLP.nom_conta                                                                          
                       ) as EOP              
              LEFT JOIN( SELECT ordem_pagamento_retencao.exercicio
                              , ordem_pagamento_retencao.cod_entidade
                              , ordem_pagamento_retencao.cod_ordem
                           FROM empenho.ordem_pagamento_retencao
                       GROUP BY ordem_pagamento_retencao.exercicio
                              , ordem_pagamento_retencao.cod_entidade
                              , ordem_pagamento_retencao.cod_ordem
                       ) AS ordem_pagamento_retencao
                      ON EOP.exercicio    = ordem_pagamento_retencao.exercicio
                     AND EOP.cod_entidade = ordem_pagamento_retencao.cod_entidade
                     AND EOP.cod_ordem    = ordem_pagamento_retencao.cod_ordem
             INNER JOIN( SELECT EPLNLP.exercicio
                              , EPLNLP.exercicio_liquidacao
                              , EE.exercicio AS exercicio_empenho                                                                
                              , EPLNLP.cod_entidade                                                             
                              , EPLNLP.cod_ordem                                                                
                              , CGM.nom_cgm                                                                     
                              , coalesce(itens.vl_prestado,0.00) as vl_prestado                                 
                           FROM empenho.pagamento_liquidacao_nota_liquidacao_paga as EPLNLP                       
                              , empenho.pagamento_liquidacao AS EPL                                               
                              , empenho.nota_liquidacao      AS ENL                                               
                              , empenho.empenho              AS EE                                                
                      LEFT JOIN ( SELECT cod_empenho                                                    
                                       , exercicio                                                      
                                       , cod_entidade                                                   
                                       , coalesce(SUM(valor_item),0.00) as vl_prestado                  
                                    FROM empenho.item_prestacao_contas as eipc                           
                                   WHERE NOT EXISTS ( SELECT num_item                                        
                                                        FROM empenho.item_prestacao_contas_anulado          
                                                       WHERE cod_empenho     = eipc.cod_empenho              
                                                         AND exercicio       = eipc.exercicio                
                                                         AND cod_entidade    = eipc.cod_entidade             
                                                         AND num_item        = eipc.num_item                 
                                                    )                                                       
                                GROUP BY cod_empenho
                                       , exercicio
                                       , cod_entidade                              
                                 ) AS itens 
                              ON itens.cod_empenho  = EE.cod_empenho               
                             AND itens.exercicio    = EE.exercicio                 
                             AND itens.cod_entidade = EE.cod_entidade              
                               , empenho.pre_empenho          AS EPE                                               
                               , sw_cgm                       AS CGM                                               
                           WHERE EPLNLP.exercicio_liquidacao = EPL.exercicio_liquidacao                           
                             AND EPLNLP.cod_entidade         = EPL.cod_entidade                                   
                             AND EPLNLP.cod_ordem            = EPL.cod_ordem                                      
                             AND EPLNLP.exercicio            = EPL.exercicio                                      
                             AND EPLNLP.cod_nota             = EPL.cod_nota                                       
                                                                                                                  
                             AND EPL.exercicio_liquidacao = ENL.exercicio                                         
                             AND EPL.cod_entidade         = ENL.cod_entidade                                      
                             AND EPL.cod_nota             = ENL.cod_nota                                          
                             AND ENL.exercicio_empenho    = EE.exercicio                                          
                             AND ENL.cod_entidade         = EE.cod_entidade                                       
                             AND ENL.cod_empenho          = EE.cod_empenho                                        
                             AND EE.exercicio             = EPE.exercicio                                         
                             AND EE.cod_pre_empenho       = EPE.cod_pre_empenho                                   
                             AND EPE.cgm_beneficiario     = CGM.numcgm                                            
                                 \' || stFiltroEmpLiq || \'
                        GROUP BY EPLNLP.exercicio                                                              
                               , EPLNLP.cod_entidade                                                           
                               , EPLNLP.cod_ordem                                                              
                               , CGM.nom_cgm                                                                   
                               , itens.vl_prestado 
                               , EPLNLP.exercicio_liquidacao
                               , EE.exercicio                                                                   
                        ORDER BY EPLNLP.exercicio                                                              
                               , EPLNLP.cod_entidade                                                           
                               , EPLNLP.cod_ordem                                                              
                               , CGM.nom_cgm                                                                   
                       ) AS CGM 
                    ON CGM.exercicio    = EOP.exercicio                                                      
                   AND CGM.cod_entidade = EOP.cod_entidade                                                   
                   AND CGM.cod_ordem    = EOP.cod_ordem                                                    
                       \' || stFiltroPrestacao || \'
              \';
        
            EXECUTE stSql;
        
            stSql := \'SELECT * FROM tmp_ordem_pagamento_estorno\';
        
            FOR reRecord IN EXECUTE stSql
            LOOP
                --se for uma op com retencao, totaliza o valor
                --se nao, insere os valores na tabela sem totalizar
                IF reRecord.retencao IS TRUE THEN   
                    --se nao tiver sido incluido na base, inclui e adiciona no array de inseridos 
                    IF ((reRecord.cod_entidade || \'_\' || reRecord.ordem) <> ALL(arOrdemInserida)) THEN
                        SELECT SUM(COALESCE(vl_nota,0))
                             , SUM(COALESCE(vl_ordem,0))
                          INTO flTotalNota
                             , flTotalOrdem
                          FROM tmp_ordem_pagamento_estorno
                         WHERE ordem        = reRecord.ordem
                           AND cod_entidade = reRecord.cod_entidade;
        
                        arOrdemInserida := ARRAY_APPEND(arOrdemInserida,CAST(reRecord.cod_entidade || \'_\' || reRecord.ordem AS VARCHAR));
        
                        INSERT INTO tmp_retorno VALUES (  reRecord.exercicio
                                                        , reRecord.empenho_pagamento   
                                                        , reRecord.exercicio_liquidacao
                                                        , reRecord.exercicio_empenho   
                                                        , reRecord.cod_entidade        
                                                        , reRecord.cod_empenho         
                                                        , reRecord.cod_nota            
                                                        , reRecord.empenho             
                                                        , reRecord.ordem                
                                                        , reRecord.nota                
                                                        , reRecord.beneficiario        
                                                        , flTotalNota             
                                                        , flTotalOrdem            
                                                        , reRecord.vl_prestado         
                                                        , reRecord.cod_conta           
                                                        , reRecord.nom_conta ); 
            
                    
                    END IF;
                ELSE
                    INSERT INTO tmp_retorno VALUES (  reRecord.exercicio
                                                    , reRecord.empenho_pagamento   
                                                    , reRecord.exercicio_liquidacao
                                                    , reRecord.exercicio_empenho   
                                                    , reRecord.cod_entidade        
                                                    , reRecord.cod_empenho         
                                                    , reRecord.cod_nota            
                                                    , reRecord.empenho             
                                                    , reRecord.ordem 
                                                    , reRecord.nota                
                                                    , reRecord.beneficiario        
                                                    , reRecord.vl_nota             
                                                    , reRecord.vl_ordem            
                                                    , reRecord.vl_prestado         
                                                    , reRecord.cod_conta           
                                                    , reRecord.nom_conta ); 
         
                END IF;
            END LOOP;
        
            --recupera os dados da tabela tmp_retorno 
            stSql := \'SELECT * FROM tmp_retorno\';
            
            FOR reRecord IN EXECUTE stSql
            LOOP
                RETURN next reRecord;
            END LOOP;
        
            DROP TABLE tmp_retorno;
            DROP TABLE tmp_ordem_pagamento_estorno;
        
        END;
        
        $function$
        ');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_financeiro_tesouraria_pagamentos_orcamentaria_estornos_list\', \'Orçamentária - Estornos\', \'financeiro_tesouraria_pagamentos_home\');');
        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_financeiro_tesouraria_pagamentos_orcamentaria_estornos_create\', \'Estornar\', \'urbem_financeiro_tesouraria_pagamentos_orcamentaria_estornos_list\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP FUNCTION tesouraria.fn_ordem_pagamento_estorno(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying)');
    }
}
