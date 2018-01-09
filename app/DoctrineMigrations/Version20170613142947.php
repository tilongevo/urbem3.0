<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170613142947 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $sql = <<<SQL
CREATE OR REPLACE FUNCTION orcamento.fn_balancete_despesa(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS \$function$
DECLARE
    stExercicio             ALIAS FOR $1;
    stFiltro                ALIAS FOR $2;
    stDataInicial           ALIAS FOR $3;
    stDataFinal             ALIAS FOR $4;
    stCodEstruturalInicial  ALIAS FOR $5;
    stCodEstruturalFinal    ALIAS FOR $6;
    stCodReduzidoInicial    ALIAS FOR $7;
    stCodReduzidoFinal      ALIAS FOR $8;
    stControleDetalhado     ALIAS FOR $9;
    
    stSql               VARCHAR   := '';
    stMascClassDespesa  VARCHAR   := '';
    stMascRecurso       VARCHAR   := '';
    reRegistro          RECORD;
    arEmpenhado         NUMERIC[] := Array[0];
    arAnulado           NUMERIC[] := Array[0];
    arPaga              NUMERIC[] := Array[0];
    arLiquidado         NUMERIC[] := Array[0];
    dtInicioAno         VARCHAR;

BEGIN


    stSql := 'CREATE TEMPORARY TABLE tmp_empenhado AS (
               SELECT  
                     EE.dt_empenho       as dt_empenho,
                     EIPE.vl_total       as vl_total,
                     OCD.cod_conta       as cod_conta,
                     OD.num_orgao        as num_orgao,  
                     OD.num_unidade      as num_unidade,  
                     OD.cod_funcao       as cod_funcao,
                     OD.cod_subfuncao    as cod_subfuncao, 
                     OD.num_pao          as num_pao,
                     OD.cod_programa     as cod_programa,
                     OD.cod_entidade     as cod_entidade,
                     OD.cod_recurso      as cod_recurso,
                     OD.cod_despesa      as cod_despesa 
                     
               FROM  
                     orcamento.despesa           as OD,
                     orcamento.conta_despesa     as OCD,
                     empenho.pre_empenho_despesa as EPED,
                     empenho.empenho             as EE,
                     empenho.pre_empenho         as EPE,
                     empenho.item_pre_empenho    as EIPE
               WHERE 
                     OCD.cod_conta               = EPED.cod_conta 
                 And OCD.exercicio               = EPED.exercicio
                 And OD.exercicio                = EPED.exercicio
                 And OD.cod_despesa              = EPED.cod_despesa 
                 
                 And EPED.exercicio              = EPE.exercicio
                 And EPED.cod_pre_empenho        = EPE.cod_pre_empenho
                 
                 And EPE.exercicio               = EE.exercicio
                 And EPE.cod_pre_empenho         = EE.cod_pre_empenho
                 And EPE.exercicio               = EIPE.exercicio
                 And EPE.cod_pre_empenho         = EIPE.cod_pre_empenho
                 And EPE.exercicio               = ''' || stExercicio  ||''' ' || stFiltro ;
                
                if (stCodEstruturalInicial is not null and stCodEstruturalInicial <> '') then
                        stSql := stSql || ' AND ocd.cod_estrutural >= ''' || stCodEstruturalInicial || ''' AND ';
                end if;    
                    
                if (stCodEstruturalFinal is not null and stCodEstruturalFinal <> '') then
                       stSql := stSql || ' ocd.cod_estrutural <= ''' || stCodEstruturalFinal || '''';
                end if;
                 if (stCodReduzidoInicial is not null and stCodReduzidoInicial <> '') then
                        stSql := stSql || ' AND od.cod_despesa >= ''' || stCodReduzidoInicial || ''' AND ';
                end if;    
                    
                if (stCodReduzidoFinal is not null and stCodReduzidoFinal <> '') then
                       stSql := stSql || ' od.cod_despesa <= ''' || stCodReduzidoFinal || '''';
                end if;
              stSql := stSql || ')';
              EXECUTE stSql;


       stSql := 'CREATE TEMPORARY TABLE tmp_anulado as (
               SELECT  
                     EEAI.timestamp      as timestamp,
                     EEAI.vl_anulado     as vl_anulado,
                     OCD.cod_conta       as cod_conta,
                     OD.num_orgao        as num_orgao,  
                     OD.num_unidade      as num_unidade,  
                     OD.cod_funcao       as cod_funcao,
                     OD.cod_subfuncao    as cod_subfuncao, 
                     OD.num_pao          as num_pao,
                     OD.cod_programa     as cod_programa,
                     OD.cod_entidade     as cod_entidade,
                     OD.cod_recurso      as cod_recurso,
                     OD.cod_despesa      as cod_despesa 

                FROM
                    orcamento.despesa           as OD, 
                    orcamento.conta_despesa     as OCD,
                    empenho.pre_empenho_despesa as EPED,
                    empenho.pre_empenho         as EPE,
                    empenho.item_pre_empenho    as EIPE,
                    empenho.empenho_anulado_item as EEAI
               WHERE
                    OCD.cod_conta            = EPED.cod_conta 
                And OCD.exercicio            = EPED.exercicio
                
                And OD.cod_despesa           = EPED.cod_despesa 
                And OD.exercicio             = EPED.exercicio
                
                And EPED.exercicio           = EPE.exercicio
                And EPED.cod_pre_empenho     = EPE.cod_pre_empenho
                
                And EPE.exercicio            = EIPE.exercicio
                And EPE.cod_pre_empenho      = EIPE.cod_pre_empenho
                
                And EIPE.exercicio           = EEAI.exercicio
                And EIPE.cod_pre_empenho     = EEAI.cod_pre_empenho
                And EIPE.num_item            = EEAI.num_item
                And EEAI.exercicio           = ''' || stExercicio  || ''' ' || stFiltro ;
                
                if (stCodEstruturalInicial is not null and stCodEstruturalInicial <> '') then
                        stSql := stSql || ' AND ocd.cod_estrutural >= ''' || stCodEstruturalInicial || ''' AND ';
                end if;    
                    
                if (stCodEstruturalFinal is not null and stCodEstruturalFinal <> '') then
                       stSql := stSql || ' ocd.cod_estrutural <= ''' || stCodEstruturalFinal || '''';
                end if;
                 if (stCodReduzidoInicial is not null and stCodReduzidoInicial <> '') then
                        stSql := stSql || ' AND od.cod_despesa >= ''' || stCodReduzidoInicial || ''' AND ';
                end if;    
                    
                if (stCodReduzidoFinal is not null and stCodReduzidoFinal <> '') then
                       stSql := stSql || ' od.cod_despesa <= ''' || stCodReduzidoFinal || '''';
                end if;
              stSql := stSql || ')';
              EXECUTE stSql;



   stSql := 'CREATE TEMPORARY TABLE  tmp_nota_liquidacao AS( 
                 SELECT  
                       ENLI.vl_total     as vl_total,
                       ENL.dt_liquidacao as dt_liquidacao,
                       OCD.cod_conta       as cod_conta,
                       OD.num_orgao        as num_orgao,  
                       OD.num_unidade      as num_unidade,  
                       OD.cod_funcao       as cod_funcao,
                       OD.cod_subfuncao    as cod_subfuncao, 
                       OD.num_pao          as num_pao,
                       OD.cod_programa     as cod_programa,
                       OD.cod_entidade     as cod_entidade,
                       OD.cod_recurso      as cod_recurso,
                       OD.cod_despesa      as cod_despesa 
                       
                  FROM
                       orcamento.despesa             as OD,
                       orcamento.conta_despesa       as OCD,
                       empenho.pre_empenho_despesa   as EPED,
                       empenho.pre_empenho           as EPE,
                       empenho.empenho               as EE,
                       empenho.nota_liquidacao_item  as ENLI,
                       empenho.nota_liquidacao       as ENL
                 WHERE 
                       OCD.cod_conta               = EPED.cod_conta 
                   And OCD.exercicio               = EPED.exercicio
                   
                   And OD.cod_despesa              = EPED.cod_despesa  
                   And OD.exercicio                = EPED.exercicio
                   
                   And EPE.cod_pre_empenho         = EE.cod_pre_empenho
                   And EPE.exercicio               = EE.exercicio
                   
                   And EE.exercicio                = ENL.exercicio_empenho
                   And EE.cod_entidade             = ENL.cod_entidade
                   And EE.cod_empenho              = ENL.cod_empenho
                   
                   And ENL.exercicio               = ENLI.exercicio
                   And ENL.cod_nota                = ENLI.cod_nota
                   And ENL.cod_entidade            = ENLI.cod_entidade 
                   
                   And EPE.exercicio               = EPED.exercicio    
                   And EPE.cod_pre_empenho         = EPED.cod_pre_empenho
                   And EPE.exercicio               = '''|| stExercicio || ''' ' || stFiltro ;
                
                if (stCodEstruturalInicial is not null and stCodEstruturalInicial <> '') then
                        stSql := stSql || ' AND ocd.cod_estrutural >= ''' || stCodEstruturalInicial || ''' AND ';
                end if;    
                    
                if (stCodEstruturalFinal is not null and stCodEstruturalFinal <> '') then
                       stSql := stSql || ' ocd.cod_estrutural <= ''' || stCodEstruturalFinal || '''';
                end if;
                 if (stCodReduzidoInicial is not null and stCodReduzidoInicial <> '') then
                        stSql := stSql || ' AND od.cod_despesa >= ''' || stCodReduzidoInicial || ''' AND ';
                end if;    
                    
                if (stCodReduzidoFinal is not null and stCodReduzidoFinal <> '') then
                       stSql := stSql || ' od.cod_despesa <= ''' || stCodReduzidoFinal || '''';
                end if;
              stSql := stSql || ')';
              EXECUTE stSql;


   stSql := 'CREATE TEMPORARY TABLE  tmp_nota_liquidacao_anulada AS ( 
                 SELECT
                       ENLIA.timestamp  as timestamp,
                       ENLIA.vl_anulado as vl_anulado,
                       OCD.cod_conta       as cod_conta,
                       OD.num_orgao        as num_orgao,  
                       OD.num_unidade      as num_unidade,  
                       OD.cod_funcao       as cod_funcao,
                       OD.cod_subfuncao    as cod_subfuncao, 
                       OD.num_pao          as num_pao,
                       OD.cod_programa     as cod_programa,
                       OD.cod_entidade     as cod_entidade,
                       OD.cod_recurso      as cod_recurso,
                       OD.cod_despesa      as cod_despesa 

                   FROM 
                       orcamento.despesa                    as OD,   
                       orcamento.conta_despesa              as OCD,
                       empenho.pre_empenho_despesa          as EPED,
                       empenho.pre_empenho                  as EPE,
                       empenho.empenho                      as EE,
                       empenho.nota_liquidacao              as ENL, 
                       empenho.nota_liquidacao_item         as ENLI,
                       empenho.nota_liquidacao_item_anulado as ENLIA

                  WHERE
                       OCD.cod_conta            = EPED.cod_conta
                   And OCD.exercicio            = EPED.exercicio
                   
                   And OD.cod_despesa           = EPED.cod_despesa
                   And OD.exercicio             = EPED.exercicio
                   
                   And EPE.cod_pre_empenho      = EE.cod_pre_empenho
                   And EPE.exercicio            = EE.exercicio
                   
                   And EE.exercicio             = ENL.exercicio_empenho
                   And EE.cod_entidade          = ENL.cod_entidade
                   And EE.cod_empenho           = ENL.cod_empenho
                   
                   And ENL.exercicio            = ENLI.exercicio
                   And ENL.cod_nota             = ENLI.cod_nota
                   And ENL.cod_entidade         = ENLI.cod_entidade 
                   
                   And ENLI.exercicio           = ENLIA.exercicio
                   And ENLI.cod_pre_empenho     = ENLIA.cod_pre_empenho
                   And ENLI.num_item            = ENLIA.num_item
                   And ENLI.cod_entidade        = ENLIA.cod_entidade
                   And ENLI.exercicio_item      = ENLIA.exercicio_item
                   And ENLI.cod_nota            = ENLIA.cod_nota
                   
                   And EPED.exercicio           = EPE.exercicio
                   And EPED.cod_pre_empenho     = EPE.cod_pre_empenho
                   And ENLIA.exercicio          = '''|| stExercicio || ''' ' || stFiltro ;
                
                if (stCodEstruturalInicial is not null and stCodEstruturalInicial <> '') then
                        stSql := stSql || ' AND ocd.cod_estrutural >= ''' || stCodEstruturalInicial || ''' AND ';
                end if;    
                    
                if (stCodEstruturalFinal is not null and stCodEstruturalFinal <> '') then
                       stSql := stSql || ' ocd.cod_estrutural <= ''' || stCodEstruturalFinal || '''';
                end if;
                 if (stCodReduzidoInicial is not null and stCodReduzidoInicial <> '') then
                        stSql := stSql || ' AND od.cod_despesa >= ''' || stCodReduzidoInicial || ''' AND ';
                end if;    
                    
                if (stCodReduzidoFinal is not null and stCodReduzidoFinal <> '') then
                       stSql := stSql || ' od.cod_despesa <= ''' || stCodReduzidoFinal || '''';
                end if;
              stSql := stSql || ')';
              EXECUTE stSql;



   stSql := 'CREATE TEMPORARY TABLE  tmp_nota_liquidacao_paga AS ( 
               SELECT  
                     ENLP.vl_pago as vl_pago,
                     ENLP.timestamp as timestamp,
                     OCD.cod_conta       as cod_conta,
                     OD.num_orgao        as num_orgao,  
                     OD.num_unidade      as num_unidade,  
                     OD.cod_funcao       as cod_funcao,
                     OD.cod_subfuncao    as cod_subfuncao, 
                     OD.num_pao          as num_pao,
                     OD.cod_programa     as cod_programa,
                     OD.cod_entidade     as cod_entidade,
                     OD.cod_recurso      as cod_recurso,
                     OD.cod_despesa      as cod_despesa 
                     
               FROM 
                    orcamento.despesa          as OD,
                    orcamento.conta_despesa    as OCD,
                    empenho.pre_empenho_despesa          as EPED,
                    empenho.empenho                      as EE,
                    empenho.pre_empenho                  as EPE,
                    empenho.nota_liquidacao              as ENL,
                    empenho.nota_liquidacao_paga         as ENLP

               Where 
                     OCD.cod_conta            = EPED.cod_conta 
                 And OCD.exercicio            = EPED.exercicio
                 
                 And OD.cod_despesa           = EPED.cod_despesa 
                 And OD.exercicio             = EPED.exercicio

                 And EPED.cod_pre_empenho     = EPE.cod_pre_empenho
                 And EPED.exercicio           = EPE.exercicio
                 
                 And EPE.exercicio            = EE.exercicio
                 And EPE.cod_pre_empenho      = EE.cod_pre_empenho
                 
                 And EE.cod_empenho           = ENL.cod_empenho
                 And EE.exercicio             = ENL.exercicio_empenho
                 And EE.cod_entidade          = ENL.cod_entidade
                 
                 And ENL.cod_nota             = ENLP.cod_nota
                 And ENL.cod_entidade         = ENLP.cod_entidade
                 And ENL.exercicio            = ENLP.exercicio
                 And ENLP.exercicio           = '''|| stExercicio || ''' ' || stFiltro ;
                
                if (stCodEstruturalInicial is not null and stCodEstruturalInicial <> '') then
                        stSql := stSql || ' AND ocd.cod_estrutural >= ''' || stCodEstruturalInicial || ''' AND ';
                end if;    
                    
                if (stCodEstruturalFinal is not null and stCodEstruturalFinal <> '') then
                       stSql := stSql || ' ocd.cod_estrutural <= ''' || stCodEstruturalFinal || '''';
                end if;
                 if (stCodReduzidoInicial is not null and stCodReduzidoInicial <> '') then
                        stSql := stSql || ' AND od.cod_despesa >= ''' || stCodReduzidoInicial || ''' AND ';
                end if;    
                    
                if (stCodReduzidoFinal is not null and stCodReduzidoFinal <> '') then
                       stSql := stSql || ' od.cod_despesa <= ''' || stCodReduzidoFinal || '''';
                end if;
              stSql := stSql || ')';
              EXECUTE stSql;




   stSql := 'CREATE TEMPORARY TABLE tmp_nota_liquidacao_paga_anulada  AS( 
              SELECT  
                    ENLPA.timestamp_anulada as timestamp_anulada,
                    ENLPA.vl_anulado as vl_anulado,
                    OCD.cod_conta       as cod_conta,
                    OD.num_orgao        as num_orgao,  
                    OD.num_unidade      as num_unidade,  
                    OD.cod_funcao       as cod_funcao,
                    OD.cod_subfuncao    as cod_subfuncao, 
                    OD.num_pao          as num_pao,
                    OD.cod_programa     as cod_programa,
                    OD.cod_entidade     as cod_entidade,
                    OD.cod_recurso      as cod_recurso,
                    OD.cod_despesa      as cod_despesa 
                    
              FROM 
                    orcamento.despesa          as OD,
                    orcamento.conta_despesa    as OCD,
                    empenho.pre_empenho_despesa          as EPED,
                    empenho.empenho                      as EE,
                    empenho.pre_empenho                  as EPE,
                    empenho.nota_liquidacao              as ENL,
                    empenho.nota_liquidacao_paga         as ENLP,
                    empenho.nota_liquidacao_paga_anulada as ENLPA

               Where OCD.cod_conta            = EPED.cod_conta  
                 And OCD.exercicio            = EPED.exercicio
                 
                 And OD.cod_despesa           = EPED.cod_despesa 
                 And OD.exercicio             = EPED.exercicio
                
                 And EPED.exercicio           = EPE.exercicio
                 And EPED.cod_pre_empenho     = EPE.cod_pre_empenho
                 
                 And EPE.exercicio            = EE.exercicio
                 And EPE.cod_pre_empenho      = EE.cod_pre_empenho
                 
                 And EE.cod_empenho           = ENL.cod_empenho
                 And EE.exercicio             = ENL.exercicio_empenho
                 And EE.cod_entidade          = ENL.cod_entidade
                 
                 And ENL.exercicio            = ENLP.exercicio
                 And ENL.cod_nota             = ENLP.cod_nota
                 And ENL.cod_entidade         = ENLP.cod_entidade
                 
                 And ENLP.cod_entidade        = ENLPA.cod_entidade
                 And ENLP.cod_nota            = ENLPA.cod_nota
                 And ENLP.exercicio           = ENLPA.exercicio
                 And ENLP.timestamp           = ENLPA.timestamp
                 And ENLP.exercicio           = '''|| stExercicio || ''' ' || stFiltro ;
                
                if (stCodEstruturalInicial is not null and stCodEstruturalInicial <> '') then
                        stSql := stSql || ' AND ocd.cod_estrutural >= ''' || stCodEstruturalInicial || ''' AND ';
                end if;    
                    
                if (stCodEstruturalFinal is not null and stCodEstruturalFinal <> '') then
                       stSql := stSql || ' ocd.cod_estrutural <= ''' || stCodEstruturalFinal || '''';
                end if;
                 if (stCodReduzidoInicial is not null and stCodReduzidoInicial <> '') then
                        stSql := stSql || ' AND od.cod_despesa >= ''' || stCodReduzidoInicial || ''' AND ';
                end if;    
                    
                if (stCodReduzidoFinal is not null and stCodReduzidoFinal <> '') then
                       stSql := stSql || ' od.cod_despesa <= ''' || stCodReduzidoFinal || '''';
                end if;
              stSql := stSql || ')';
              EXECUTE stSql;


        SELECT INTO 
                   stMascRecurso
                   sw_configuracao.valor
         FROM   sw_configuracao 
        WHERE   sw_configuracao.cod_modulo = 8 
          AND   sw_configuracao.parametro = 'masc_recurso'
          AND   sw_configuracao.exercicio = stExercicio;

   --CRIA TABELA TEMPORÁRIA COM TODOS AS DESPESAS DA DESPESA, SETA ELAS COMO MÃE
    CREATE TEMPORARY TABLE tmp_pre_empenho_despesa AS
        SELECT   
                  exercicio
                 ,cod_conta
                 ,cod_despesa
                 ,cast('M' as varchar) as tipo_conta
        FROM
                 orcamento.despesa as d;
     
     --INSERE NA TABELA TEMPORARIA OS REGISTROS RESUTADOS DE UM SELECT
     --ESTE SELECT PREVEM DA TABELA PRE_EMPENHO_DESPESA ONDE TODOS OS REGISTROS SÃO SETADOS COMO FILHAS
        INSERT INTO tmp_pre_empenho_despesa 
            SELECT   
                    exercicio
                    ,cod_conta
                    ,cod_despesa
                    ,cast('F' as varchar) as tipo_conta
            FROM    empenho.pre_empenho_despesa
            WHERE   exercicio||'-'||cod_conta||'-'||cod_despesa NOT IN ( 
                        SELECT  exercicio||'-'||cod_conta||'-'||cod_despesa
                        FROM    orcamento.despesa
                    );


                
        dtInicioAno := '01/01/' || stExercicio;

        stSql := 'CREATE TEMPORARY TABLE tmp_relacao AS 
                SELECT
                   od.exercicio as exercicio, 
                   od.cod_despesa as cod_despesa, 
                   od.cod_entidade as cod_entidade,
                   od.cod_programa as cod_programa, 
                   eped.cod_conta, 
                   od.num_pao as num_pao, 
                   od.num_orgao as num_orgao, 
                   od.num_unidade as num_unidade,
                   od.cod_recurso as cod_recurso , 
                   od.cod_funcao as cod_funcao , 
                   od.cod_subfuncao as cod_subfuncao, 
                   od.vl_original as vl_original, 
                   od.dt_criacao as dt_criacao, 
                   ocd.cod_estrutural as classificacao, 
                   ocd.descricao as descricao , 
                   sw_fn_mascara_dinamica('''||stMascRecurso||''', cast(od.cod_recurso as varchar)) AS num_recurso, 
                   oru.nom_recurso as nom_recurso,
                   swo.nom_orgao as nom_orgao,
                   swu.nom_unidade as nom_unidade,
                   ofu.descricao AS nom_funcao,
                   osf.descricao AS nom_subfuncao,
                   opg.descricao AS nom_programa,
                   opao.nom_pao as nom_pao,
                   0.00    as empenhado_ano,
                   0.00    as empenhado_per,
                   0.00    as anulado_ano,
                   0.00    as anulado_per,
                   0.00    as paga_ano,
                   0.00    as paga_per,
                   0.00    as liquidado_ano,
                   0.00    as liquidado_per,
                   MAX(eped.tipo_conta) as tipo_conta,
                   coalesce(od.vl_original,0.00)as saldo_inicial,
                   coalesce(oss.valor,0.00)     as suplementacoes,
                   coalesce(osr.valor,0.00)     as reducoes,
                   (coalesce(od.vl_original,0.00)+coalesce(oss.valor,0.00)-coalesce(osr.valor,0.00)) as total_creditos,
                   coalesce(oss.credito_suplementar,0.00)        as credito_suplementar,
                   coalesce(oss.credito_especial,0.00)           as credito_especial,
                   coalesce(oss.credito_extraordinario,0.00)     as credito_extraordinario
    
                FROM 
                --  empenho.pre_empenho_despesa eped,
                    tmp_pre_empenho_despesa eped,
                    orcamento.conta_despesa ocd, 
                    orcamento.despesa od 
                 LEFT JOIN
                 (
                  select
                  SUM(Case When os.cod_tipo >= 1 and os.cod_tipo <= 5 Then
                                   oss1.valor
                           Else 0 End) as credito_suplementar,
                  SUM(Case When os.cod_tipo >= 6 and os.cod_tipo <= 10 Then
                                   oss1.valor
                           Else 0 End) as credito_especial,
                  SUM(Case When os.cod_tipo = 11 Then
                                   oss1.valor
                           Else 0 End) as credito_extraordinario,

                     cod_despesa,max(oss1.exercicio) as exercicio, sum(valor) as valor


                    from orcamento.suplementacao_suplementada as oss1,
                         orcamento.suplementacao as os
                         where os.cod_suplementacao = oss1.cod_suplementacao
                           and os.exercicio         = oss1.exercicio        
                           and os.cod_suplementacao || os.exercicio IN (Select 
                                                                              cod_suplementacao || cl.exercicio
                                                                          from
                                                                              contabilidade.transferencia_despesa ctd,
                                                                              contabilidade.lote cl
                                                                         where
                                                                              ctd.exercicio = cl.exercicio
                                                                          and ctd.cod_lote  = cl.cod_lote
                                                                          and ctd.tipo      = cl.tipo
                                                                          and ctd.cod_entidade = cl.cod_entidade
                                                                          and cl.dt_lote between  to_date('''|| dtInicioAno ||''',''dd/mm/yyyy'') And to_date('''|| stDataFinal ||''',''dd/mm/yyyy'')
                            )
                            AND os.cod_suplementacao || os.exercicio NOT IN (
                                                                             SELECT
                                                                                 cod_suplementacao || exercicio
                                                                             FROM
                                                                                 orcamento.suplementacao_anulada
                                                                             WHERE
                                                                                 exercicio   = ' || stExercicio  || '
                            )
                            AND os.cod_suplementacao || os.exercicio NOT IN (
                                                                             SELECT
                                                                                 cod_suplementacao_anulacao || exercicio
                                                                             FROM
                                                                                 orcamento.suplementacao_anulada
                                                                             WHERE
                                                                                 exercicio   = ' || stExercicio  || '
                            )
                         group by oss1.exercicio,oss1.cod_despesa) as oss

                  ON ( od.cod_despesa = oss.cod_despesa and
                       od.exercicio = oss.exercicio        )

                  LEFT JOIN  
                    (select cod_despesa,max(osr1.exercicio) as exercicio, sum(valor) as valor
                       from orcamento.suplementacao_reducao as osr1,
                            orcamento.suplementacao as os
                            where os.cod_suplementacao = osr1.cod_suplementacao
                            and   os.exercicio         = osr1.exercicio         
                            and os.cod_suplementacao || os.exercicio IN (Select 
                                                                              cod_suplementacao || cl.exercicio
                                                                          from
                                                                              contabilidade.transferencia_despesa ctd,
                                                                              contabilidade.lote cl
                                                                         where
                                                                              ctd.exercicio = cl.exercicio
                                                                          and ctd.cod_lote  = cl.cod_lote
                                                                          and ctd.tipo      = cl.tipo
                                                                          and ctd.cod_entidade = cl.cod_entidade
                                                                          and cl.dt_lote between  to_date('''|| dtInicioAno ||''',''dd/mm/yyyy'') And to_date('''|| stDataFinal ||''',''dd/mm/yyyy'')
                             )
                             AND os.cod_suplementacao || os.exercicio NOT IN (
                                                                             SELECT
                                                                                 cod_suplementacao || exercicio
                                                                             FROM
                                                                                 orcamento.suplementacao_anulada
                                                                             WHERE
                                                                                 exercicio   = ' || stExercicio  || '
                            )
                            AND os.cod_suplementacao || os.exercicio NOT IN (
                                                                             SELECT
                                                                                 cod_suplementacao_anulacao || exercicio
                                                                             FROM
                                                                                 orcamento.suplementacao_anulada
                                                                             WHERE
                                                                                 exercicio   = ' || stExercicio  || '
                           )
                           group by osr1.exercicio,cod_despesa
                         ) as osr
                    ON(               
                        od.cod_despesa        = osr.cod_despesa        and
                        od.exercicio          = osr.exercicio),        
                        
                    orcamento.recurso  oru,
                    orcamento.orgao oo, 
                    sw_orgao swo, 
                    orcamento.unidade ou, 
                    sw_unidade swu, 
                    orcamento.funcao ofu, 
                    orcamento.subfuncao osf, 
                    orcamento.programa opg, 
                    orcamento.pao opao
                WHERE   
                        eped.cod_despesa      = od.cod_despesa 
                AND     eped.exercicio        = od.exercicio
                And     eped.cod_conta        = ocd.cod_conta
                AND     od.cod_recurso        = oru.cod_recurso 
                AND     od.exercicio          = oru.exercicio 
                AND     od.num_orgao          = oo.num_orgao 
                AND     od.exercicio          = oo.exercicio 
                AND     oo.cod_orgao          = swo.cod_orgao 
                AND     oo.ano_exercicio      = swo.ano_exercicio 
                AND     ou.num_unidade        = od.num_unidade 
                AND     ou.num_orgao          = od.num_orgao 
                AND     ou.exercicio          = od.exercicio 
                AND     ou.cod_unidade        = swu.cod_unidade 
                AND     ou.ano_exercicio      = swu.ano_exercicio 
                AND     swu.cod_orgao         = swo.cod_orgao 
                AND     od.cod_funcao         = ofu.cod_funcao 
                AND     od.exercicio          = ofu.exercicio 
                AND     od.cod_subfuncao      = osf.cod_subfuncao 
                AND     od.exercicio          = osf.exercicio 
                AND     od.cod_programa       = opg.cod_programa 
                AND     od.exercicio          = opg.exercicio 
                AND     od.num_pao            = opao.num_pao 
                AND     od.exercicio          = opao.exercicio
                AND     od.exercicio          = ''' || stExercicio  ||''' ' || stFiltro;
                
                if (stCodEstruturalInicial is not null and stCodEstruturalInicial <> '') then
                        stSql := stSql || ' AND ocd.cod_estrutural >= ''' || stCodEstruturalInicial || ''' AND ';
                end if;    
                    
                if (stCodEstruturalFinal is not null and stCodEstruturalFinal <> '') then
                       stSql := stSql || ' ocd.cod_estrutural <= ''' || stCodEstruturalFinal || '''';
                end if;
                 if (stCodReduzidoInicial is not null and stCodReduzidoInicial <> '') then
                        stSql := stSql || ' AND od.cod_despesa >= ''' || stCodReduzidoInicial || ''' AND ';
                end if;    
                    
                if (stCodReduzidoFinal is not null and stCodReduzidoFinal <> '') then
                       stSql := stSql || ' od.cod_despesa <= ''' || stCodReduzidoFinal || '''';
                end if;
                  
                      stSql := stSql || ' group by  od.cod_entidade,
                                                     od.num_orgao, 
                                                     od.num_unidade,
                                                     od.cod_funcao, 
                                                     od.cod_subfuncao,                          
                                                     od.cod_programa,
                                                     od.num_pao,
                                                     ocd.cod_estrutural, 
                                                     od.cod_recurso,
                                                     num_recurso,
                                                     od.cod_despesa, 
                                                     od.exercicio ,  
                                                     eped.cod_conta, 
                                                     od.vl_original,           
                                                     od.dt_criacao,                            
                                                     ocd.descricao,                            
                                                     oru.nom_recurso,
                                                     swo.nom_orgao,
                                                     swu.nom_unidade,
                                                     ofu.descricao,
                                                     osf.descricao,
                                                     opg.descricao,
                                                     opao.nom_pao,
                                                     empenhado_ano,
                                                     empenhado_per,
                                                     anulado_ano,
                                                     anulado_per,
                                                     paga_ano,
                                                     paga_per,
                                                     liquidado_ano,
                                                     liquidado_per,
                                                     saldo_inicial,
                                                     suplementacoes,
                                                     reducoes,
                                                     credito_suplementar,
                                                     credito_especial,
                                                     credito_extraordinario,
                                                     total_creditos
                                           order by  od.cod_entidade,
                                                     od.num_orgao, 
                                                     od.num_unidade,
                                                     od.cod_funcao, 
                                                     od.cod_subfuncao,                          
                                                     od.cod_programa,
                                                     od.num_pao,
                                                     ocd.cod_estrutural, 
                                                     od.cod_recurso,
                                                     num_recurso,
                                                     od.cod_despesa, 
                                                     od.exercicio ,  
                                                     eped.cod_conta, 
                                                     od.vl_original,           
                                                     od.dt_criacao,                            
                                                     ocd.descricao,                            
                                                     oru.nom_recurso,
                                                     swo.nom_orgao,
                                                     swu.nom_unidade,
                                                     ofu.descricao,
                                                     osf.descricao,
                                                     opg.descricao,
                                                     opao.nom_pao,
                                                     empenhado_ano,
                                                     empenhado_per,
                                                     anulado_ano,
                                                     anulado_per,
                                                     paga_ano,
                                                     paga_per,
                                                     liquidado_ano,
                                                     liquidado_per,
                                                     saldo_inicial,
                                                     suplementacoes,
                                                     reducoes,
                                                     credito_suplementar,
                                                     credito_especial,
                                                     credito_extraordinario,
                                                     total_creditos  ';

                
                            
--    RAISE NOTICE '%',stSql;
        EXECUTE stSql;
        stSql := ' SELECT  
           od.exercicio, 
           od.cod_despesa, 
           od.cod_entidade,
           od.cod_programa, 
           CASE WHEN tr.cod_conta IS NOT NULL THEN tr.cod_conta 
                ELSE ocd.cod_conta
           END AS cod_conta,     
           od.num_pao, 
           od.num_orgao, 
           od.num_unidade,
           od.cod_recurso , 
           od.cod_funcao , 
           od.cod_subfuncao, 
           cast(tr.tipo_conta as varchar) as tipo_conta, 
           coalesce(od.vl_original,0.00) as vl_original,
           od.dt_criacao, 
           CASE WHEN tr.classificacao IS NOT NULL THEN tr.classificacao 
                ELSE ocd.cod_estrutural
           END as classificacao,
           CASE WHEN tr.descricao IS NOT NULL THEN tr.descricao 
                ELSE ocd.descricao
           END as descricao,
           sw_fn_mascara_dinamica('''||stMascRecurso||''', cast(od.cod_recurso as varchar)) AS num_recurso, 
           CASE WHEN tr.nom_recurso IS NOT NULL THEN tr.nom_recurso 
                ELSE oru.nom_recurso
           END as nom_recurso,
           CASE WHEN tr.nom_orgao IS NOT NULL THEN tr.nom_orgao 
                ELSE swo.nom_orgao
           END as nom_orgao,
           CASE WHEN tr.nom_unidade IS NOT NULL THEN tr.nom_unidade 
                ELSE swu.nom_unidade
           END as nom_unidade,
           CASE WHEN tr.nom_funcao IS NOT NULL THEN tr.nom_funcao 
                ELSE ofu.descricao
           END as nom_funcao,
           CASE WHEN tr.nom_subfuncao IS NOT NULL THEN tr.nom_subfuncao 
                ELSE osf.descricao
           END as nom_subfuncao,
           CASE WHEN tr.nom_programa IS NOT NULL THEN tr.nom_programa 
                ELSE opg.descricao
           END as nom_programa,
            CASE WHEN tr.nom_pao IS NOT NULL THEN tr.nom_pao 
                ELSE opao.nom_pao
           END as nom_pao,
           coalesce(tr.empenhado_ano) as empenhado_ano,
           coalesce(tr.empenhado_per) as empenhado_per,
           coalesce(tr.anulado_ano) as anulado_ano,
           coalesce(tr.anulado_per) as anulado_per,
           coalesce(tr.paga_ano) as paga_ano,
           coalesce(tr.paga_per) as paga_per,
           coalesce(tr.liquidado_ano) as liquidado_ano,
           coalesce(tr.liquidado_per) as liquidado_per,
           coalesce(od.vl_original) as  saldo_inicial,
           coalesce(tr.suplementacoes) as suplementacoes,
           coalesce(tr.reducoes) as reducoes ,
           coalesce(tr.total_creditos) as total_creditos,
           coalesce(tr.credito_suplementar) as credito_suplementar,                                          
           coalesce(tr.credito_especial) as credito_especial,
           coalesce(tr.credito_extraordinario) as credito_extraordinario                                       
        FROM    
           orcamento.conta_despesa  ocd
           ,orcamento.despesa        od
        LEFT JOIN      
           tmp_relacao tr
        ON(od.cod_despesa = tr.cod_despesa and
           od.exercicio   = tr.exercicio 
           ),
                    orcamento.recurso  oru,
                    orcamento.orgao oo, 
                    sw_orgao swo, 
                    orcamento.unidade ou, 
                    sw_unidade swu, 
                    orcamento.funcao ofu, 
                    orcamento.subfuncao osf, 
                    orcamento.programa opg, 
                    orcamento.pao opao
                WHERE  
                        od.exercicio          = ocd.exercicio
                AND     od.cod_conta          = ocd.cod_conta                
                AND     od.cod_recurso        = oru.cod_recurso 
                AND     od.exercicio          = oru.exercicio 
                AND     od.num_orgao          = oo.num_orgao 
                AND     od.exercicio          = oo.exercicio 
                AND     oo.cod_orgao          = swo.cod_orgao 
                AND     oo.ano_exercicio      = swo.ano_exercicio 
                AND     ou.num_unidade        = od.num_unidade 
                AND     ou.num_orgao          = od.num_orgao 
                AND     ou.exercicio          = od.exercicio 
                AND     ou.cod_unidade        = swu.cod_unidade 
                AND     ou.ano_exercicio      = swu.ano_exercicio 
                AND     swu.cod_orgao         = swo.cod_orgao 
                AND     od.cod_funcao         = ofu.cod_funcao 
                AND     od.exercicio          = ofu.exercicio 
                AND     od.cod_subfuncao      = osf.cod_subfuncao 
                AND     od.exercicio          = osf.exercicio 
                AND     od.cod_programa       = opg.cod_programa 
                AND     od.exercicio          = opg.exercicio 
                AND     od.num_pao            = opao.num_pao 
                AND     od.exercicio          = opao.exercicio
                AND     od.exercicio          = ''' || stExercicio || ''' ' || stFiltro;
        
           if (stCodEstruturalInicial is not null and stCodEstruturalInicial <> '') then
                   stSql := stSql || ' AND ocd.cod_estrutural >= ''' || stCodEstruturalInicial || ''' AND ';
           end if;    
               
           if (stCodEstruturalFinal is not null and stCodEstruturalFinal <> '') then
                  stSql := stSql || ' ocd.cod_estrutural <= ''' || stCodEstruturalFinal || '''';
           end if;
            if (stCodReduzidoInicial is not null and stCodReduzidoInicial <> '') then
                   stSql := stSql || ' AND od.cod_despesa >= ''' || stCodReduzidoInicial || ''' AND ';
           end if;    
               
           if (stCodReduzidoFinal is not null and stCodReduzidoFinal <> '') then
                  stSql := stSql || ' od.cod_despesa <= ''' || stCodReduzidoFinal || '''';
           end if;

                  stSql := stSql || ' ORDER BY od.cod_entidade,
                                                od.num_orgao, 
                                                od.num_unidade,
                                                od.cod_funcao , 
                                                od.cod_subfuncao, 
                                                od.cod_programa, 
                                                od.num_pao,';
                                                
                 if(stControleDetalhado  <> '') then
                    -- Detalhado Orcamento
                    stSql := stSql || '  to_number(translate(classificacao, ''.'',''''),''99999999999999''),
                                          od.cod_recurso';
                 else
                    -- Detalhado na execução 
                    stSql := stSql || '  od.cod_despesa,
                                          to_number(translate(classificacao, ''.'',''''),''99999999999999''),
                                          od.cod_recurso';
                 end if;                
   

                  
--    RAISE NOTICE '%',stSql;
 
    FOR reRegistro IN  EXECUTE stSql
        
    LOOP
       IF reRegistro.cod_conta IS NOT NULL THEN
        arEmpenhado := empenho.fn_despesa_empenhado_mes_ano(stExercicio,stDataInicial, stDataFinal, reRegistro.cod_conta, reRegistro.num_orgao, reRegistro.num_unidade,reRegistro.cod_funcao, reRegistro.cod_subfuncao,reRegistro.num_pao, reRegistro.cod_programa, reRegistro.cod_entidade, reRegistro.cod_recurso, reRegistro.cod_despesa );
        reRegistro.empenhado_ano := coalesce(arEmpenhado[1],0.00);
        reRegistro.empenhado_per := coalesce(arEmpenhado[2],0.00);
        
        arAnulado := empenho.fn_despesa_anulado_mes_ano(stExercicio,stDataInicial, stDataFinal, reRegistro.cod_conta, reRegistro.num_orgao, reRegistro.num_unidade,reRegistro.cod_funcao, reRegistro.cod_subfuncao,reRegistro.num_pao,reRegistro.cod_programa, reRegistro.cod_entidade, reRegistro.cod_recurso, reRegistro.cod_despesa );
        reRegistro.anulado_ano := coalesce(arAnulado[1],0.00);
        reRegistro.anulado_per := coalesce(arAnulado[2],0.00);
    
        arPaga := empenho.fn_despesa_paga_mes_ano(stExercicio,stDataInicial, stDataFinal, reRegistro.cod_conta, reRegistro.num_orgao, reRegistro.num_unidade,reRegistro.cod_funcao, reRegistro.cod_subfuncao,reRegistro.num_pao,reRegistro.cod_programa , reRegistro.cod_entidade, reRegistro.cod_recurso, reRegistro.cod_despesa );
        reRegistro.paga_ano := coalesce(arPaga[1],0.00);
        reRegistro.paga_per := coalesce(arPaga[2],0.00);
   
        arLiquidado := empenho.fn_despesa_liquidado_mes_ano(stExercicio,stDataInicial, stDataFinal, reRegistro.cod_conta, reRegistro.num_orgao, reRegistro.num_unidade,reRegistro.cod_funcao, reRegistro.cod_subfuncao,reRegistro.num_pao,reRegistro.cod_programa, reRegistro.cod_entidade, reRegistro.cod_recurso, reRegistro.cod_despesa );
        reRegistro.liquidado_ano := coalesce(arLiquidado[1],0.00);
        reRegistro.liquidado_per := coalesce(arLiquidado[2],0.00);

    END IF;  
       IF  
          reRegistro.empenhado_ano   <> 0.00 or 
          reRegistro.empenhado_per   <> 0.00 or
          reRegistro.anulado_per     <> 0.00 or
          reRegistro.anulado_ano     <> 0.00 or
          reRegistro.paga_per        <> 0.00 or
          reRegistro.paga_ano        <> 0.00 or
          reRegistro.liquidado_per   <> 0.00 or
          reRegistro.liquidado_ano   <> 0.00 or
--          reRegistro.suplementacoes  <> 0.00 or
--          reRegistro.reducoes        <> 0.00 or
          reRegistro.tipo_conta      <> 'F'
       THEN   
       RETURN next reRegistro;
     END IF; 
    END LOOP;


    DROP TABLE tmp_empenhado;
    DROP TABLE tmp_anulado;
    DROP TABLE tmp_nota_liquidacao;
    DROP TABLE tmp_nota_liquidacao_anulada;
    DROP TABLE tmp_nota_liquidacao_paga;
    DROP TABLE tmp_nota_liquidacao_paga_anulada;
   
    DROP TABLE tmp_pre_empenho_despesa;
    DROP TABLE tmp_relacao;

    RETURN;
END;
\$function$
SQL;

        $this->addSql($sql);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP FUNCTION IF EXISTS orcamento.fn_balancete_despesa(character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying, character varying);");
    }
}
