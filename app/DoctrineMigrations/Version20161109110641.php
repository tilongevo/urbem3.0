<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161109110641 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION empenho.fn_lista_empenhos_pagar_tesouraria(character varying, character varying, character varying)
                         RETURNS SETOF record
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            stFiltro            ALIAS FOR $1;
                            stFiltroOrdem       ALIAS FOR $2;
                            stFiltroAuxiliar    ALIAS FOR $3;
                        
                            stSql               VARCHAR := \'\';
                            reRegistro          RECORD;
                            dtDebug             timestamp;
                        
                        BEGIN
                        
                            stSql := \'
                            -- Cria temporaria da nota de liquidacao
                            CREATE TEMPORARY TABLE tmp_liquidacao AS (
                                SELECT ENL.cod_empenho||\'\'/\'\'||ENL.exercicio_empenho AS empenho
                                      ,ENL.cod_nota||\'\'/\'\'||ENL.exercicio            AS nota
                                      ,CAST( CASE WHEN EE.cod_categoria = 2 OR EE.cod_categoria = 3 THEN \'\'t\'\' ELSE \'\'f\'\' END AS VARCHAR )AS adiantamento
                                      ,CAST( \'\'\'\' as VARCHAR ) AS ordem
                                      ,ENL.cod_entidade
                                      ,CGME.nom_cgm AS entidade
                                      ,EPE.cgm_beneficiario
                                      ,CGMB.nom_cgm as beneficiario
                                      ,((empenho.fn_consultar_valor_liquidado_nota( ENL.exercicio
                                                                                  ,ENL.cod_empenho
                                                                                  ,ENL.cod_entidade
                                                                                  ,ENL.cod_nota
                                       )
                                      -empenho.fn_consultar_valor_liquidado_anulado_nota( ENL.exercicio
                                                                                         ,ENL.cod_empenho
                                                                                         ,ENL.cod_entidade
                                                                                         ,ENL.cod_nota
                                      ))
                                      -(empenho.fn_consultar_valor_apagar_nota( ENL.exercicio
                                                                               ,ENL.cod_nota
                                                                               ,ENL.cod_entidade
                                      )
                                      -empenho.fn_consultar_valor_apagar_anulado_nota( ENL.exercicio
                                                                                      ,ENL.cod_nota
                                                                                      ,ENL.cod_entidade
                                      ))
                                      ) as vl_nota
                                      ,CAST( 0.00 as NUMERIC ) AS vl_pagamento
                                FROM empenho.pre_empenho     AS EPE
                                    ,empenho.empenho         AS EE
                                    ,empenho.nota_liquidacao AS ENL
                                    ,orcamento.entidade      AS OE
                                    ,sw_cgm                  AS CGME
                                    ,sw_cgm                  AS CGMB
                                  -- Join pre_empenho / empenho
                                WHERE EPE.exercicio       = EE.exercicio
                                  AND EPE.cod_pre_empenho = EE.cod_pre_empenho
                                  -- Join empenho / nota liquidacao
                                  AND EE.exercicio        = ENL.exercicio_empenho
                                  AND EE.cod_entidade     = ENL.cod_entidade
                                  AND EE.cod_empenho      = ENL.cod_empenho
                                  -- Join empenho / entidade
                                  AND EE.exercicio        = OE.exercicio
                        
                                  AND EE.cod_entidade     = OE.cod_entidade
                                  -- Join entidade / cgm
                                  AND OE.numcgm           = CGME.numcgm
                                  -- Join pre_empenho / cgm
                                  AND EPE.cgm_beneficiario= CGMB.numcgm
                                  -- Filtros
                                  \' || stFiltro || \'
                            )
                            \';
                        
                            IF stFiltroOrdem ~ \'cod_ordem\' THEN 
                                CREATE TEMPORARY TABLE tmp_liquidacao(
                                    empenho          varchar
                                   ,nota             varchar
                                   ,adiantamento     varchar
                                   ,ordem            varchar
                                   ,cod_entidade     integer
                                   ,entidade         varchar
                                   ,cgm_beneficiario integer
                                   ,beneficiario     varchar
                                   ,vl_nota          numeric
                                   ,vl_pagamento     numeric
                                );
                            ELSE 
                                EXECUTE stSql;
                            END IF;
                        
                        
                            -- Exclui liquidacoes anuladas
                            DELETE FROM tmp_liquidacao WHERE vl_nota <= 0;
                        
                        
                            stSql := \'
                            -- Cria temporaria da ordem de pagamento
                            CREATE TEMPORARY TABLE tmp_ordem AS(
                                SELECT empenho.retorna_empenhos( EOP.exercicio, EOP.cod_ordem, EOP.cod_entidade ) AS empenho
                                      ,empenho.retorna_notas   ( EOP.exercicio, EOP.cod_ordem, EOP.cod_entidade ) AS nota
                                      ,empenho.verifica_adiantamento( EOP.exercicio, EOP.cod_ordem,EOP.cod_entidade) as adiantamento 
                                      ,EOP.cod_ordem||\'\'/\'\'||EOP.exercicio AS ordem
                                      ,EOP.cod_entidade
                                      ,CGME.nom_cgm AS entidade
                                      ,EPL.cgm_beneficiario
                                      ,EPL.beneficiario
                                      ,CAST( 0.00 as NUMERIC ) as vl_nota
                                      ,((empenho.fn_consultar_valor_pagamento_ordem( EOP.exercicio
                                                                                  ,EOP.cod_ordem
                                                                                  ,EOP.cod_entidade
                                       ) -empenho.fn_consultar_valor_pagamento_anulado_ordem( EOP.exercicio
                                                                                             ,EOP.cod_ordem
                                                                                             ,EOP.cod_entidade))
                                       - PL.vl_pago) as vl_pagamento
                                FROM empenho.ordem_pagamento AS EOP
                                -- Join com ordem pagamento liquidacao anulada
                                LEFT JOIN( SELECT EOPLA.exercicio
                                                 ,EOPLA.cod_entidade
                                                 ,EOPLA.cod_ordem
                                                 ,EOPLA.timestamp
                                                 ,sum(coalesce(EOPLA.vl_anulado,0.00)) as vl_anulado
                                           FROM empenho.ordem_pagamento_liquidacao_anulada AS EOPLA
                                           GROUP BY EOPLA.exercicio
                                                   ,EOPLA.cod_entidade
                                                   ,EOPLA.cod_ordem
                                                   ,EOPLA.timestamp 
                                ) AS EOPLA ON( EOP.exercicio    = EOPLA.exercicio
                                           AND EOP.cod_entidade = EOPLA.cod_entidade
                                           AND EOP.cod_ordem    = EOPLA.cod_ordem    ) 
                        
                                -- Join com pagamento de liquidacao
                                INNER JOIN(
                                    SELECT EPL.exercicio
                                          ,EPL.cod_entidade
                                          ,EPL.cod_ordem
                                          ,sum(EPL.vl_pagamento) as vl_op
                                          ,sum (coalesce(ENLP.vl_pago,0.00)) as vl_pago
                                    FROM empenho.pagamento_liquidacao AS EPL
                                         left join empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPLNLP on(
                                                EPL.exercicio            = EPLNLP.exercicio
                                            and EPL.cod_ordem            = EPLNLP.cod_ordem
                                            and EPL.cod_entidade         = EPLNLP.cod_entidade
                                            and EPL.cod_nota             = EPLNLP.cod_nota
                                            and EPL.exercicio_liquidacao = EPLNLP.exercicio_liquidacao
                                         )
                                         left join(
                                             select
                                                  ENLP.exercicio
                                                 ,ENLP.cod_nota
                                                 ,ENLP.cod_entidade
                                                 ,ENLP.timestamp
                                                 ,coalesce(ENLP.vl_pago,0.00) - coalesce(ENLPA.vl_pago_anulado,0.00) as vl_pago
                                             from
                                                 empenho.nota_liquidacao_paga as ENLP
                                                 left join(
                                                     select
                                                          ENLPA.exercicio
                                                         ,ENLPA.cod_nota
                                                         ,ENLPA.cod_entidade
                                                         ,ENLPA.timestamp
                                                         ,sum(coalesce(ENLPA.vl_anulado,0.00)) as vl_pago_anulado
                                                     from
                                                          empenho.nota_liquidacao_paga_anulada as ENLPA
                                                     group by
                                                          ENLPA.exercicio
                                                         ,ENLPA.cod_nota
                                                         ,ENLPA.cod_entidade
                                                         ,ENLPA.timestamp
                                                 ) as ENLPA ON(
                                                         ENLP.exercicio    = ENLPA.exercicio
                                                     AND ENLP.cod_nota     = ENLPA.cod_nota
                                                     AND ENLP.cod_entidade = ENLPA.cod_entidade
                                                     AND ENLP.timestamp    = ENLPA.timestamp
                                                 )
                                         ) as ENLP ON(
                                                 ENLP.exercicio    = EPLNLP.exercicio_liquidacao
                                             and ENLP.cod_nota     = EPLNLP.cod_nota
                                             and ENLP.cod_entidade = EPLNLP.cod_entidade
                                             and ENLP.timestamp    = EPLNLP.timestamp
                                         )
                                    group by 
                                             EPL.exercicio
                                            ,EPL.cod_entidade
                                            ,EPL.cod_ordem
                                ) AS  PL ON(  EOP.exercicio    = PL.exercicio
                                          AND EOP.cod_entidade = PL.cod_entidade
                                          AND EOP.cod_ordem    = PL.cod_ordem    )
                        
                                -- Join com empenho
                                INNER JOIN( SELECT EPL.exercicio
                                                  ,EE.exercicio AS exercicio_empenho
                                                  ,EPL.cod_entidade
                                                  ,EPL.cod_ordem
                                                  ,EPE.cgm_beneficiario
                                                  ,CGM.nom_cgm   as beneficiario
                                            FROM empenho.pagamento_liquidacao AS EPL
                                                ,empenho.nota_liquidacao      AS ENL
                                                ,empenho.empenho              AS EE
                                                ,empenho.pre_empenho          AS EPE
                                                ,sw_cgm                       AS CGM
                                              -- Join com nota Liquidacao
                                            WHERE EPL.exercicio_liquidacao = ENL.exercicio
                                              AND EPL.cod_entidade         = ENL.cod_entidade
                                              AND EPL.cod_nota             = ENL.cod_nota
                                              -- Join com empenho
                                              AND ENL.exercicio_empenho    = EE.exercicio
                                              AND ENL.cod_entidade         = EE.cod_entidade
                                              AND ENL.cod_empenho          = EE.cod_empenho
                                              -- Join com pre_empenho
                                              AND EE.exercicio             = EPE.exercicio
                                              AND EE.cod_pre_empenho       = EPE.cod_pre_empenho
                                              -- Join pre_empenho / cgm
                                              AND EPE.cgm_beneficiario     = CGM.numcgm
                                              -- Filtros
                                              \' || stFiltroAuxiliar || \'
                                            GROUP BY EPL.exercicio
                                                    ,EE.exercicio
                                                    ,EPL.cod_entidade
                                                    ,EPL.cod_ordem
                                                    ,EPE.cgm_beneficiario
                                                    ,CGM.nom_cgm
                                            ORDER BY EPL.exercicio
                                                    ,EE.exercicio
                                                    ,EPL.cod_entidade
                                                    ,EPL.cod_ordem
                                                    ,EPE.cgm_beneficiario
                                                    ,CGM.nom_cgm
                                ) AS EPL ON( EOP.exercicio    = EPL.exercicio
                                         AND EOP.cod_entidade = EPL.cod_entidade
                                         AND EOP.cod_ordem    = EPL.cod_ordem     )
                                    ,orcamento.entidade      AS OE
                                    ,sw_cgm                  AS CGME
                                WHERE
                                      (PL.vl_op - coalesce(EOPLA.vl_anulado,0.00)) > PL.vl_pago  
                                  -- Join com entidade
                                  and EOP.exercicio    = OE.exercicio
                                  AND EOP.cod_entidade = OE.cod_entidade
                                  -- Join entidade / cgm
                                  AND OE.numcgm        = CGME.numcgm
                                  -- Filtros da ordem
                                  \' || stFiltroOrdem || \'
                                ORDER BY EOP.exercicio
                                        ,EOP.cod_entidade
                                        ,EOP.cod_ordem
                            )
                            \';
                            EXECUTE stSql;
                        
                            stSql := \'
                                        SELECT CAST( empenho AS VARCHAR ) AS empenho
                                              ,CAST( nota    AS VARCHAR ) AS nota
                                              ,CAST( adiantamento AS VARCHAR ) AS adiantamento
                                              ,CAST( ordem   AS VARCHAR ) AS ordem
                                              ,cod_entidade
                                              ,CAST( entidade  AS VARCHAR ) AS entidade
                                              ,cgm_beneficiario
                                              ,CAST( beneficiario AS VARCHAR ) as beneficiario
                                              ,vl_nota
                                              ,vl_pagamento
                                        FROM tmp_liquidacao AS TL
                        
                                        UNION
                        
                                        SELECT CAST( empenho AS VARCHAR ) AS empenho
                                              ,CAST( nota    AS VARCHAR ) AS nota
                                              ,CAST(CASE WHEN adiantamento = true THEN \'\'t\'\' ELSE \'\'f\'\' END AS VARCHAR) AS adiantamento  
                                              ,CAST( ordem   AS VARCHAR ) AS ordem
                                              ,cod_entidade
                                              ,CAST( entidade  AS VARCHAR ) AS entidade
                                              ,cgm_beneficiario
                                              ,CAST( beneficiario AS VARCHAR ) as beneficiario
                                              ,vl_nota
                                              ,vl_pagamento
                                        FROM tmp_ordem AS TOR
                                        WHERE 
                                            vl_pagamento > 0.00
                        
                                        ORDER BY ordem;
                            \';
                            FOR reRegistro IN EXECUTE stSql
                            LOOP
                                RETURN NEXT reRegistro;
                            END LOOP;
                        
                        
                            DROP TABLE tmp_liquidacao;
                            DROP TABLE tmp_ordem;
                        
                        
                        RETURN;
                        
                        END;
                        
                        $function$');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP FUNCTION empenho.fn_lista_empenhos_pagar_tesouraria(character varying, character varying, character varying)');
    }
}
