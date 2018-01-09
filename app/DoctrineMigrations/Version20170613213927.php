<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170613213927 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $sql_fn_exportacao_empenho_soma_dos_itens = <<<SQL
CREATE OR REPLACE FUNCTION tcers.fn_exportacao_empenho_soma_dos_itens(character varying, character varying, character varying, character varying)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS \$function$
DECLARE
    stExercicio     ALIAS FOR $1    ;
    stDataInicial   ALIAS FOR $2    ;
    stDataFinal     ALIAS FOR $3    ;
    stCodEntidade   ALIAS FOR $4    ;
    stSql           VARCHAR := '' ;
    raRegistro      RECORD          ;
    arDados         VARCHAR[] := array[0];
BEGIN
stSql = '
    -- Select para soma do itens  --> data vem de empenho.empenho.dt_empenho
SELECT
        0 as num_orgao      ,       -- ok
        0 as num_unidade    ,       -- ok
        0 as cod_funcao     ,       -- ok
        0 as cod_subfuncao  ,       -- ok
        0 as cod_programa   ,       -- ok
        0 as num_pao        ,       -- ok
        0 as cod_recurso    ,       -- ok
        cast('''' as varchar)  as cod_estrutural   ,
        ee.cod_empenho,
        ee.dt_empenho::DATE AS dt_empenho,              -- ok
        tcers.fn_exportacao_empenho_total_empenhado(ee.exercicio,ee.cod_empenho,ee.cod_entidade) as vl_empenhado,       --ok
        cast(''+'' as varchar) as sinal,
        pe.cgm_beneficiario,
        CAST(CASE WHEN trim(pe.descricao) = '''' THEN
             publico.concatenar_hifen(ie.quantidade::varchar) || '' '' || publico.concatenar_hifen(ie.nom_unidade) || '' '' || publico.concatenar_hifen(ie.nom_item) || '' '' || publico.concatenar_hifen(ie.complemento)
        ELSE pe.descricao END as varchar ) as historico,
        ee.cod_pre_empenho,
        ee.exercicio,
        ee.cod_entidade,
        cast(''1'' as integer) as ordem,
        ee.oid
    FROM
            orcamento.despesa           as od   ,
            orcamento.conta_despesa     as ocd  ,
            empenho.pre_empenho_despesa as ped  ,
            empenho.pre_empenho         as pe   ,
            empenho.empenho             as ee   ,
            empenho.item_pre_empenho    as ie
    WHERE
            ee.exercicio        = '''||stExercicio||'''
        AND ee.dt_empenho BETWEEN to_date('''||stDataInicial||''',''dd/mm/yyyy'') AND to_date('''||stDataFinal||''',''dd/mm/yyyy'')
        AND ee.cod_entidade     IN  ('||stCodEntidade||')
        -- ligar pre empenho
        AND pe.exercicio        = ee.exercicio
        AND pe.cod_pre_empenho  = ee.cod_pre_empenho
        -- ligar pre empenho despesa
        AND ped.exercicio       = pe.exercicio
        AND ped.cod_pre_empenho = pe.cod_pre_empenho
        -- ligar orcamento despesa
        AND od.exercicio        = ped.exercicio
        AND od.cod_despesa      = ped.cod_despesa
        -- ligar orcamento conta despesa
        AND ocd.exercicio       = ped.exercicio
        AND ocd.cod_conta       = ped.cod_conta
        -- ligar pre_empenho item_pre_empenho
        AND pe.exercicio        = ie.exercicio
        AND pe.cod_pre_empenho  = ie.cod_pre_empenho
        
        GROUP BY
            num_orgao      ,
            num_unidade    ,
            cod_funcao     ,
            cod_subfuncao  ,
            cod_programa   ,
            num_pao        ,
            cod_recurso    ,
            cod_estrutural   ,
            ee.cod_empenho,
            dt_empenho,
            vl_empenhado,
            sinal,
            pe.cgm_beneficiario,
            ee.cod_pre_empenho,
            ee.exercicio,
            ee.cod_entidade,
            ordem,
            pe.descricao,
            ee.oid
';

    FOR raRegistro IN EXECUTE stSql
    LOOP
        arDados := tcers.fn_exportacao_dados_empenho(raRegistro.cod_empenho,raRegistro.exercicio,raRegistro.cod_entidade);
        raRegistro.num_orgao        := to_number(arDados[1], '9999999999');
        raRegistro.num_unidade      := to_number(arDados[2], '9999999999');
        raRegistro.cod_funcao       := to_number(arDados[3], '9999999999');
        raRegistro.cod_subfuncao    := to_number(arDados[4], '9999999999');
        raRegistro.cod_programa     := to_number(arDados[5], '9999999999');
        raRegistro.num_pao          := to_number(arDados[6], '9999999999');
        raRegistro.cod_estrutural   := arDados[7];
        raRegistro.cod_recurso      := to_number(arDados[8], '9999999999');
        RETURN NEXT raRegistro;
    END LOOP;

    RETURN;
END;
\$function$
SQL;

        $sql_fn_exportacao_empenho_restos_pagar = <<<SQL
CREATE OR REPLACE FUNCTION tcers.fn_exportacao_empenho_restos_pagar(character varying, character varying)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS \$function$
DECLARE
    stExercicio     ALIAS FOR $1    ;
    stCodEntidade   ALIAS FOR $2    ;
    stSql           VARCHAR := '' ;
    raRegistro      RECORD          ;
    arDados         VARCHAR[] := array[0];
BEGIN

    stSql := 'CREATE TEMPORARY TABLE tmp_empenho AS
                SELECT  emp.exercicio, 
                        emp.cod_entidade, 
                        emp.cod_empenho, 
                        pre.cod_pre_empenho,
                        emp.dt_empenho::DATE AS dt_empenho,
                        pre.cgm_beneficiario,
                        pre.descricao,
                        pre.oid     as pre_oid
                FROM     empenho.empenho        as emp
                        ,empenho.pre_empenho    as pre
                WHERE   emp.exercicio        <   ''' || stExercicio || '''
                    AND emp.cod_entidade     IN ('||stCodEntidade||')
                    -- Liga a pre empenho
                    AND pre.exercicio       =   emp.exercicio
                    AND pre.cod_pre_empenho =   emp.cod_pre_empenho
                ';
    EXECUTE stSql;
    CREATE UNIQUE INDEX unq_tmp_empenho     ON tmp_empenho  (exercicio, cod_entidade, cod_empenho);
    CREATE UNIQUE INDEX unq_tmp_pre_empenho ON tmp_empenho  (exercicio, cod_pre_empenho);

    stSql := 'CREATE TEMPORARY TABLE tmp_item_empenho AS
                SELECT  temp.exercicio, 
                        temp.cod_pre_empenho, 
                        sum(ipre.vl_total) as vl_total,
                        max(ipre.nom_unidade) as nom_unidade,
                        max(ipre.nom_item) as nom_item,
                        max(ipre.quantidade) as quantidade,
                        max(ipre.complemento) as complemento
                        
                FROM     tmp_empenho   as temp
                        ,empenho.item_pre_empenho  as ipre
                WHERE   temp.exercicio       = ipre.exercicio
                    AND temp.cod_pre_empenho = ipre.cod_pre_empenho
                GROUP BY temp.exercicio, temp.cod_pre_empenho 
                ';
    EXECUTE stSql;
    CREATE UNIQUE INDEX unq_tmp_item_empenho   ON tmp_item_empenho  (exercicio, cod_pre_empenho);


    stSql := 'CREATE TEMPORARY TABLE tmp_item_empenho_anulado AS
                SELECT  temp.exercicio, 
                        temp.cod_pre_empenho, 
                        coalesce(Sum(eai.vl_anulado),0.00) as vl_anulado
                FROM     tmp_empenho   as temp
                        ,empenho.empenho_anulado_item    as eai
                WHERE   temp.exercicio       = eai.exercicio
                    AND temp.cod_pre_empenho = eai.cod_pre_empenho
                    AND eai.timestamp <= to_date(''31/12/''||(to_number('||stExercicio||'::varchar,''9999'')-1)::varchar,''dd/mm/yyyy'')
                GROUP BY temp.exercicio, temp.cod_pre_empenho 

                ';
    EXECUTE stSql;
    CREATE UNIQUE INDEX unq_tmp_item_empenho_anulado   ON tmp_item_empenho_anulado  (exercicio, cod_pre_empenho);

    stSql := 'CREATE TEMPORARY TABLE tmp_nota_paga AS
                SELECT  temp.exercicio, 
                        temp.cod_entidade,
                        temp.cod_empenho,
                        coalesce(Sum(enlp.vl_pago),0.00) as vl_pago
                FROM     tmp_empenho   as temp
                        ,empenho.nota_liquidacao         as enl
                        ,empenho.nota_liquidacao_paga    as enlp
                  -- Nota Liquidacao
                WHERE   enl.exercicio_empenho   =   temp.exercicio
                    AND enl.cod_empenho         =   temp.cod_empenho
                    AND enl.cod_entidade        =   temp.cod_entidade
                  -- Nota Liquidacao Paga
                    AND enlp.cod_entidade       =   enl.cod_entidade
                    AND enlp.cod_nota           =   enl.cod_nota
                    AND enlp.exercicio          =   enl.exercicio
                    AND enlp.timestamp <= to_date(''31/12/''||(to_number('||stExercicio||'::varchar,''9999'')-1)::varchar,''dd/mm/yyyy'')
                    GROUP BY temp.exercicio, temp.cod_entidade, temp.cod_empenho
                ';
    EXECUTE stSql;
    CREATE UNIQUE INDEX unq_tmp_nota_paga   ON tmp_nota_paga  (exercicio, cod_entidade, cod_empenho);

    stSql := 'CREATE TEMPORARY TABLE tmp_nota_paga_anulada AS
                SELECT  temp.exercicio, 
                        temp.cod_entidade,
                        temp.cod_empenho,
                        coalesce(Sum(enlpa.vl_anulado),0.00) as vl_anulado
                FROM     tmp_empenho   as temp
                        ,empenho.nota_liquidacao         as enl
                        ,empenho.nota_liquidacao_paga    as enlp
                        ,empenho.nota_liquidacao_paga_anulada    as enlpa
                  -- Nota Liquidacao
                WHERE   enl.exercicio_empenho   =   temp.exercicio
                    AND enl.cod_empenho         =   temp.cod_empenho
                    AND enl.cod_entidade        =   temp.cod_entidade
                  -- Nota Liquidacao Paga
                    AND enlp.cod_entidade       =   enl.cod_entidade
                    AND enlp.cod_nota           =   enl.cod_nota
                    AND enlp.exercicio          =   enl.exercicio
                    AND enlp.timestamp::date <= to_date(''31/12/''||(to_number('||stExercicio||'::varchar,''9999'')-1)::varchar,''dd/mm/yyyy'')
                 -- Nota Liquidacao Paga Anulada
                    AND enlpa.exercicio         =   enlp.exercicio
                    AND enlpa.cod_nota          =   enlp.cod_nota
                    AND enlpa.cod_entidade      =   enlp.cod_entidade
                    AND enlpa.timestamp       =   enlp.timestamp
                    AND enlpa.timestamp_anulada <= to_date(''31/12/''||(to_number('||stExercicio||'::varchar,''9999'')-1)::varchar, ''dd/mm/yyyy'')
                    GROUP BY temp.exercicio, temp.cod_entidade, temp.cod_empenho
                ';
    EXECUTE stSql;
    CREATE UNIQUE INDEX unq_tmp_nota_paga_anulada   ON tmp_nota_paga_anulada  (exercicio, cod_entidade, cod_empenho);



stSql = '
    -- Select para soma do itens  --> data vem de empenho.empenho.dt_empenho
SELECT
        -- Nome Tmp para campos que vem da funcao Dados Empenho
        0           as num_orgao        ,
        0           as num_unidade      ,
        0           as cod_funcao       ,
        0           as cod_subfuncao    ,
        0           as cod_programa     ,
        0           as num_pao          ,
        0           as cod_recurso      ,
        cast('''' as varchar)  as cod_estrutural   ,
        temp.cod_empenho,
        temp.dt_empenho ,
        
        (
            ( coalesce(titem.vl_total,0.00)
            - coalesce(Sum(tpago.vl_pago),0.00)
            )
        -
            ( coalesce(( SELECT vl_anulado FROM tmp_item_empenho_anulado tiea WHERE temp.exercicio=tiea.exercicio AND temp.cod_pre_empenho=tiea.cod_pre_empenho),0.00)
            - coalesce((SELECT vl_anulado FROM tmp_nota_paga_anulada as tanu WHERE temp.exercicio=tanu.exercicio AND temp.cod_entidade=tanu.cod_entidade AND temp.cod_empenho=tanu.cod_empenho),0.00)
            )
        )::numeric(14,2) as vl_empenhado,

        cast(''+'' as varchar(1)) as sinal,
        temp.cgm_beneficiario,
        CAST( CASE WHEN trim(temp.descricao) = '''' THEN
            publico.concatenar_hifen(titem.quantidade::varchar) || '' '' || publico.concatenar_hifen(titem.nom_unidade) || '' '' || publico.concatenar_hifen(titem.nom_item) || '' '' || publico.concatenar_hifen(titem.complemento)
        ELSE temp.descricao END as varchar ) as historico,
        temp.cod_pre_empenho,
        temp.exercicio,
        temp.cod_entidade,
        cast(''3'' as integer) as ordem ,
        temp.pre_oid

     FROM   tmp_item_empenho    as titem
           ,tmp_empenho         as temp
        LEFT JOIN
            tmp_nota_paga       as tpago
        ON (    temp.exercicio        = tpago.exercicio
            AND temp.cod_entidade     = tpago.cod_entidade
            AND temp.cod_empenho      = tpago.cod_empenho
        )
    WHERE   temp.exercicio        = titem.exercicio
        AND temp.cod_pre_empenho  = titem.cod_pre_empenho
        GROUP BY
            num_orgao      ,
            num_unidade    ,
            cod_funcao     ,
            cod_subfuncao  ,
            cod_programa   ,
            num_pao        ,
            cod_recurso    ,
            cod_estrutural   ,
            temp.cod_empenho,
            temp.dt_empenho,
            sinal,
            temp.cgm_beneficiario,
            temp.cod_pre_empenho,
            temp.exercicio,
            titem.vl_total,
            temp.cod_entidade,
            ordem,
            temp.descricao,
            temp.pre_oid
';

        -- Encerra conteudo do sql

    FOR raRegistro IN EXECUTE stSql
    LOOP
        IF (raRegistro.vl_empenhado > 0 ) THEN
            arDados := tcers.fn_exportacao_dados_empenho(raRegistro.cod_empenho,raRegistro.exercicio,raRegistro.cod_entidade);
            raRegistro.num_orgao        := to_number(arDados[1], '9999999999');
            raRegistro.num_unidade      := to_number(arDados[2], '9999999999');
            raRegistro.cod_funcao       := to_number(arDados[3], '9999999999');
            raRegistro.cod_subfuncao    := to_number(arDados[4], '9999999999');
            raRegistro.cod_programa     := to_number(arDados[5], '9999999999');
            raRegistro.num_pao          := to_number(arDados[6], '9999999999');
            raRegistro.cod_estrutural   := arDados[7];
            raRegistro.cod_recurso      := to_number(arDados[8], '9999999999');
            RETURN NEXT raRegistro;
        END IF;
    END LOOP;

    DROP INDEX unq_tmp_empenho;
    DROP INDEX unq_tmp_pre_empenho;
    DROP INDEX unq_tmp_item_empenho;
    DROP INDEX unq_tmp_item_empenho_anulado;
    DROP INDEX unq_tmp_nota_paga;
    DROP INDEX unq_tmp_nota_paga_anulada;

    DROP TABLE tmp_empenho;
    DROP TABLE tmp_item_empenho;
    DROP TABLE tmp_item_empenho_anulado;
    DROP TABLE tmp_nota_paga;
    DROP TABLE tmp_nota_paga_anulada;

    RETURN;
END;
\$function$
SQL;


        $this->addSql($sql_fn_exportacao_empenho_soma_dos_itens);
        $this->addSql($sql_fn_exportacao_empenho_restos_pagar);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DROP FUNCTION IF EXISTS tcers.fn_exportacao_empenho_soma_dos_itens(character varying, character varying, character varying, character varying);");
        $this->addSql("DROP FUNCTION IF EXISTS tcers.fn_exportacao_empenho_restos_pagar(character varying, character varying);");
    }
}
