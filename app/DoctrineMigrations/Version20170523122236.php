<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao;
use Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma;
use Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaConstrucao;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170523122236 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_edificacao;');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_unidades;');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_max_area_un_dep;');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_construcao_outros;');
        $this->addSql('DROP VIEW IF EXISTS imobiliario.vw_max_area_un_aut;');

        $this->changeColumnToDateTimeMicrosecondType(Construcao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConstrucaoProcesso::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AreaConstrucao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BaixaConstrucao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(UnidadeDependente::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConstrucaoCondominio::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AreaUnidadeAutonoma::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoTipoEdificacaoValor::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AreaUnidadeDependente::class, 'timestamp');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_area_unidade_dependente(integer, integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inCodConstrucao      ALIAS FOR $1;
                inInscricaoMunicipal ALIAS FOR $2;
                nuAreaTotal          NUMERIC;
                reRegistro           RECORD;
                stSql                VARCHAR;
            
            BEGIN
            
                SELECT
                    aud.area
                INTO nuAreaTotal
                FROM
                (
                    SELECT
                        aud.inscricao_municipal,
                        aud.cod_construcao_dependente,
                        aud.cod_tipo,
                        aud.cod_construcao,
                        aud."timestamp",
                        aud.area
                    FROM
                        imobiliario.area_unidade_dependente aud,
                        (
                            SELECT
                                max(area_unidade_dependente."timestamp") AS "timestamp",
                                area_unidade_dependente.cod_construcao_dependente,
                                area_unidade_dependente.inscricao_municipal
                            FROM
                                imobiliario.area_unidade_dependente
                            GROUP BY
                                area_unidade_dependente.cod_construcao_dependente,
                                area_unidade_dependente.inscricao_municipal
                        ) maud
                    WHERE
                        aud.cod_construcao_dependente = maud.cod_construcao_dependente AND
                        aud.inscricao_municipal = maud.inscricao_municipal AND
                        aud."timestamp" = maud."timestamp"
                ) AS aud
                WHERE
                    aud.cod_construcao_dependente = $1 AND
                    aud.inscricao_municipal = $2;
            
                RETURN nuAreaTotal;
            END;
            $function$
        ');

        $this->addSql('
             CREATE OR REPLACE VIEW imobiliario.vw_max_area_un_dep AS
             SELECT aud.inscricao_municipal,
                aud.cod_construcao_dependente,
                aud.cod_tipo,
                aud.cod_construcao,
                aud."timestamp",
                aud.area
               FROM imobiliario.area_unidade_dependente aud,
                ( SELECT max(area_unidade_dependente."timestamp") AS "timestamp",
                        area_unidade_dependente.cod_construcao_dependente
                       FROM imobiliario.area_unidade_dependente
                      GROUP BY area_unidade_dependente.cod_construcao_dependente) maud
              WHERE aud.cod_construcao_dependente = maud.cod_construcao_dependente AND aud."timestamp" = maud."timestamp";
        ');

        $this->addSql('
             CREATE OR REPLACE VIEW imobiliario.vw_unidades AS
             SELECT uni.inscricao_municipal,
                uni.cod_tipo,
                uni.cod_tipo_dependente,
                uni.cod_construcao,
                uni."timestamp",
                uni.cod_construcao_dependente,
                uni.area,
                uni.nom_tipo,
                uni.data_construcao,
                    CASE
                        WHEN uni.cod_construcao_dependente::character varying::text = 0::text THEN \'Autônoma\'::text
                        ELSE \'Dependente\'::text
                    END AS tipo_unidade
               FROM ( SELECT ua.inscricao_municipal,
                        ua.cod_tipo,
                        ua.cod_tipo AS cod_tipo_dependente,
                        ua.cod_construcao,
                        ua."timestamp",
                        0 AS cod_construcao_dependente,
                        aua.area,
                        te.nom_tipo,
                        to_char(dc.data_construcao::timestamp with time zone, \'DD/MM/YYYY\'::text) AS data_construcao
                       FROM imobiliario.unidade_autonoma ua
                         LEFT JOIN ( SELECT bal.inscricao_municipal,
                                bal.cod_tipo,
                                bal.cod_construcao,
                                bal."timestamp",
                                bal.justificativa,
                                bal.justificativa_termino,
                                bal.dt_inicio,
                                bal.dt_termino
                               FROM imobiliario.baixa_unidade_autonoma bal,
                                ( SELECT max(baixa_unidade_autonoma."timestamp") AS "timestamp",
                                        baixa_unidade_autonoma.inscricao_municipal,
                                        baixa_unidade_autonoma.cod_tipo,
                                        baixa_unidade_autonoma.cod_construcao
                                       FROM imobiliario.baixa_unidade_autonoma
                                      GROUP BY baixa_unidade_autonoma.inscricao_municipal, baixa_unidade_autonoma.cod_tipo, baixa_unidade_autonoma.cod_construcao) bt
                              WHERE bal.inscricao_municipal = bt.inscricao_municipal AND bal.cod_tipo = bt.cod_tipo AND bal.cod_construcao = bt.cod_construcao AND bal."timestamp" = bt."timestamp") bua ON bua.inscricao_municipal = ua.inscricao_municipal AND bua.cod_tipo = ua.cod_tipo AND bua.cod_construcao = ua.cod_construcao
                         JOIN ( SELECT aua_1.inscricao_municipal,
                                aua_1.cod_tipo,
                                aua_1.cod_construcao,
                                aua_1."timestamp",
                                aua_1.area
                               FROM imobiliario.area_unidade_autonoma aua_1,
                                ( SELECT max(area_unidade_autonoma."timestamp") AS "timestamp",
                                        area_unidade_autonoma.inscricao_municipal
                                       FROM imobiliario.area_unidade_autonoma
                                      GROUP BY area_unidade_autonoma.inscricao_municipal) maua
                              WHERE aua_1.inscricao_municipal = maua.inscricao_municipal AND aua_1."timestamp" = maua."timestamp") aua ON ua.inscricao_municipal = aua.inscricao_municipal
                         LEFT JOIN imobiliario.tipo_edificacao te ON ua.cod_tipo = te.cod_tipo
                         LEFT JOIN imobiliario.data_construcao dc ON ua.cod_construcao = dc.cod_construcao
                      WHERE bua.dt_inicio IS NULL OR bua.dt_inicio IS NOT NULL AND bua.dt_termino IS NOT NULL AND bua.inscricao_municipal = ua.inscricao_municipal AND bua.cod_tipo = ua.cod_tipo AND bua.cod_construcao = ua.cod_construcao
                    UNION
                     SELECT ud.inscricao_municipal,
                        ud.cod_tipo,
                        ce.cod_tipo AS cod_tipo_dependente,
                        ud.cod_construcao,
                        ud."timestamp",
                        ud.cod_construcao_dependente,
                        aud.area,
                        te.nom_tipo,
                        to_char(dc.data_construcao::timestamp with time zone, \'DD/MM/YYYY\'::text) AS data_construcao
                       FROM imobiliario.construcao_edificacao ce,
                        imobiliario.unidade_dependente ud
                         JOIN imobiliario.vw_max_area_un_dep aud ON ud.inscricao_municipal = aud.inscricao_municipal AND aud.cod_construcao_dependente = ud.cod_construcao_dependente
                         LEFT JOIN ( SELECT bal.inscricao_municipal,
                                bal.cod_construcao_dependente,
                                bal.cod_construcao,
                                bal.cod_tipo,
                                bal."timestamp",
                                bal.justificativa,
                                bal.justificativa_termino,
                                bal.dt_inicio,
                                bal.dt_termino
                               FROM imobiliario.baixa_unidade_dependente bal,
                                ( SELECT max(baixa_unidade_dependente."timestamp") AS "timestamp",
                                        baixa_unidade_dependente.inscricao_municipal,
                                        baixa_unidade_dependente.cod_tipo,
                                        baixa_unidade_dependente.cod_construcao,
                                        baixa_unidade_dependente.cod_construcao_dependente
                                       FROM imobiliario.baixa_unidade_dependente
                                      GROUP BY baixa_unidade_dependente.inscricao_municipal, baixa_unidade_dependente.cod_tipo, baixa_unidade_dependente.cod_construcao, baixa_unidade_dependente.cod_construcao_dependente) bt
                              WHERE bal.inscricao_municipal = bt.inscricao_municipal AND bal.cod_tipo = bt.cod_tipo AND bal.cod_construcao = bt.cod_construcao AND bal.cod_construcao_dependente = bt.cod_construcao_dependente AND bal."timestamp" = bt."timestamp") bud ON bud.inscricao_municipal = ud.inscricao_municipal AND bud.cod_tipo = ud.cod_tipo AND bud.cod_construcao = ud.cod_construcao AND bud.cod_construcao_dependente = ud.cod_construcao_dependente
                         LEFT JOIN imobiliario.tipo_edificacao te ON ud.cod_tipo = te.cod_tipo
                         LEFT JOIN imobiliario.data_construcao dc ON dc.cod_construcao = ud.cod_construcao_dependente
                      WHERE aud.inscricao_municipal = ud.inscricao_municipal AND ce.cod_construcao = ud.cod_construcao_dependente AND (bud.dt_inicio IS NULL OR bud.dt_inicio IS NOT NULL AND bud.dt_termino IS NOT NULL AND bud.inscricao_municipal = ud.inscricao_municipal AND bud.cod_tipo = ud.cod_tipo AND bud.cod_construcao = ud.cod_construcao AND bud.cod_construcao_dependente = ud.cod_construcao_dependente)) uni;
        ');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_area_unidade_autonoma(integer, integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inCodConstrucao      ALIAS FOR $1;
                inInscricaoMunicipal ALIAS FOR $2;
                nuAreaTotal          NUMERIC;
                reRegistro           RECORD;
                stSql                VARCHAR;
            
            BEGIN
            
                SELECT
                    aua.area
                INTO nuAreaTotal
                FROM (
                SELECT
                    aua.inscricao_municipal,
                    aua.cod_tipo,
                    aua.cod_construcao,
                    aua."timestamp",
                    aua.area
                FROM
                    imobiliario.area_unidade_autonoma aua,
                    (
                        SELECT
                            max(area_unidade_autonoma."timestamp") AS "timestamp",
                            area_unidade_autonoma.cod_construcao,
                            area_unidade_autonoma.inscricao_municipal
                        FROM
                            imobiliario.area_unidade_autonoma
                        GROUP BY
                            area_unidade_autonoma.cod_construcao,
                            area_unidade_autonoma.inscricao_municipal
                    ) maua
                WHERE
                    aua.cod_construcao = maua.cod_construcao AND
                    aua.inscricao_municipal = maua.inscricao_municipal AND
                    aua."timestamp"= maua."timestamp"
                ) aua
                WHERE
                    aua.cod_construcao = $1 AND
                    aua.inscricao_municipal = $2;
            
                RETURN nuAreaTotal;
            END;
            $function$
        ');

        $this->addSql('
             CREATE OR REPLACE VIEW imobiliario.vw_edificacao AS
             SELECT ed.cod_construcao,
                cc."timestamp" AS timestamp_construcao,
                ud.cod_construcao AS cod_construcao_autonoma,
                ed.cod_tipo,
                ud.cod_tipo AS cod_tipo_autonoma,
                ac.area_real,
                te.nom_tipo,
                cp.cod_processo,
                cp.exercicio,
                to_char(bc.dt_inicio::timestamp with time zone, \'dd/mm/yyyy\'::text) AS data_baixa,
                to_char(bc.dt_termino::timestamp with time zone, \'dd/mm/yyyy\'::text) AS data_reativacao,
                bc."timestamp" AS timestamp_baixa,
                bc.justificativa,
                dc.data_construcao,
                bc.sistema,
                    CASE
                        WHEN ud.inscricao_municipal IS NOT NULL THEN ud.inscricao_municipal
                        WHEN ua.inscricao_municipal IS NOT NULL THEN ua.inscricao_municipal
                        ELSE cd.cod_condominio
                    END AS imovel_cond,
                cd.nom_condominio,
                    CASE
                        WHEN ud.inscricao_municipal::character varying IS NOT NULL THEN imobiliario.fn_area_unidade_dependente(ed.cod_construcao, ud.inscricao_municipal)::character varying
                        WHEN ua.inscricao_municipal::character varying IS NOT NULL THEN imobiliario.fn_area_unidade_autonoma(ed.cod_construcao, ua.inscricao_municipal)::character varying
                        ELSE NULL::character varying
                    END AS area_unidade,
                    CASE
                        WHEN ud.inscricao_municipal::character varying IS NOT NULL THEN \'Dependente\'::text
                        WHEN ua.inscricao_municipal::character varying IS NOT NULL THEN \'Autônoma\'::text
                        ELSE \'Condomínio\'::text
                    END AS tipo_vinculo
               FROM imobiliario.construcao_edificacao ed
                 JOIN imobiliario.construcao cc ON cc.cod_construcao = ed.cod_construcao
                 JOIN imobiliario.data_construcao dc ON dc.cod_construcao = ed.cod_construcao
                 LEFT JOIN ( SELECT ac_1.cod_construcao,
                        ac_1."timestamp",
                        ac_1.area_real
                       FROM imobiliario.area_construcao ac_1,
                        ( SELECT max(area_construcao."timestamp") AS "timestamp",
                                area_construcao.cod_construcao
                               FROM imobiliario.area_construcao
                              GROUP BY area_construcao.cod_construcao) mac
                      WHERE ac_1.cod_construcao = mac.cod_construcao AND ac_1."timestamp" = mac."timestamp") ac ON ac.cod_construcao = ed.cod_construcao
                 JOIN imobiliario.tipo_edificacao te ON te.cod_tipo = ed.cod_tipo
                 LEFT JOIN ( SELECT cp_1.cod_construcao,
                        cp_1.cod_processo,
                        cp_1.exercicio,
                        cp_1."timestamp"
                       FROM imobiliario.construcao_processo cp_1,
                        ( SELECT max(construcao_processo."timestamp") AS "timestamp",
                                construcao_processo.cod_construcao
                               FROM imobiliario.construcao_processo
                              GROUP BY construcao_processo.cod_construcao) mcp
                      WHERE cp_1.cod_construcao = mcp.cod_construcao AND cp_1."timestamp" = mcp."timestamp") cp ON ed.cod_construcao = cp.cod_construcao
                 LEFT JOIN imobiliario.unidade_dependente ud ON ud.cod_construcao_dependente = ed.cod_construcao
                 LEFT JOIN imobiliario.unidade_autonoma ua ON ua.cod_construcao = ed.cod_construcao
                 LEFT JOIN ( SELECT cc_1.cod_construcao,
                        cd_1.cod_condominio,
                        cd_1.cod_tipo,
                        cd_1.nom_condominio,
                        cd_1."timestamp"
                       FROM imobiliario.construcao_condominio cc_1,
                        imobiliario.condominio cd_1
                      WHERE cd_1.cod_condominio = cc_1.cod_condominio) cd ON cd.cod_construcao = ed.cod_construcao
                 LEFT JOIN ( SELECT bal.cod_construcao,
                        bal."timestamp",
                        bal.justificativa,
                        bal.sistema,
                        bal.justificativa_termino,
                        bal.dt_inicio,
                        bal.dt_termino
                       FROM imobiliario.baixa_construcao bal,
                        ( SELECT max(baixa_construcao."timestamp") AS "timestamp",
                                baixa_construcao.cod_construcao
                               FROM imobiliario.baixa_construcao
                              GROUP BY baixa_construcao.cod_construcao) bt
                      WHERE bal.cod_construcao = bt.cod_construcao AND bal."timestamp" = bt."timestamp") bc ON ed.cod_construcao = bc.cod_construcao
              WHERE
                    CASE
                        WHEN bc."timestamp" IS NOT NULL AND bc.dt_termino IS NULL THEN
                        CASE
                            WHEN bc.sistema = true THEN false
                            ELSE true
                        END
                        ELSE true
                    END;
        ');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_calcula_area_imovel(integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                stInscricaoMunicipal ALIAS FOR $1;
                nuAreaTotal         NUMERIC := 0;
                nuAreaAutonoma      NUMERIC := 0;
                nuAreaDependente    NUMERIC := 0;
            BEGIN
            
                SELECT 
                    Coalesce( areaa.area , 0)
                INTO 
                    nuAreaAutonoma
                FROM 
                    imobiliario.area_unidade_autonoma as areaa
                    LEFT JOIN 
                    (
                            SELECT
                                BAL.*
                            FROM
                                imobiliario.baixa_construcao AS BAL,
                                (
                                SELECT
                                    MAX (TIMESTAMP) AS TIMESTAMP,
                                    cod_construcao
                                FROM
                                    imobiliario.baixa_construcao 
                                GROUP BY
                                    cod_construcao
                                ) AS BT
                            WHERE
                                BAL.cod_construcao = BT.cod_construcao AND
                                BAL.timestamp = BT.timestamp
                    ) bl  ON areaa.cod_construcao = bl.cod_construcao
                    
                    INNER JOIN
                    (
                    SELECT 
                        max (ua.timestamp) as timestamp,
                        ua.cod_construcao
                    FROM 
                        imobiliario.area_unidade_autonoma ua
                    WHERE 
                        ua.inscricao_municipal =  stInscricaoMunicipal 
                    GROUP BY 
                        ua.cod_construcao
                 ) as tabela ON tabela.timestamp = areaa.timestamp 
                 AND areaa.cod_construcao = tabela.cod_construcao
            
                LEFT JOIN 
                    (
                        SELECT
                            BAL.*
                        FROM
                            imobiliario.baixa_unidade_autonoma AS BAL,
                            (
                            SELECT
                                MAX (TIMESTAMP) AS TIMESTAMP,
                                cod_construcao,
                                inscricao_municipal
                            FROM
                                imobiliario.baixa_unidade_autonoma
                            GROUP BY
                                cod_construcao,
                                inscricao_municipal
                            ) AS BT
                        WHERE
                            BAL.cod_construcao = BT.cod_construcao AND
                            BAL.inscricao_municipal = BT.inscricao_municipal AND
                            BAL.timestamp = BT.timestamp
                    )as bua
                ON bua.cod_construcao = areaa.cod_construcao AND bua.inscricao_municipal = areaa.inscricao_municipal
            
                 WHERE
                    case 
                        when bua.cod_construcao is not null then
                            case 
                                 when ( bua.dt_inicio::date > now()::date OR bua.dt_termino < now()::date ) then
                                    true
                                else
                                    false
                            end
                       else
                            true
                    end     
               ;
            
            SELECT
                Coalesce( sum( aread.area ) , 0) as area
            INTO
                nuAreaDependente
            FROM 
                imobiliario.area_unidade_dependente as aread
                INNER JOIN
                (
                    SELECT 
                        max (ud.timestamp) as timestamp,
                        ud.cod_construcao_dependente
                    FROM 
                        imobiliario.area_unidade_dependente ud
                    WHERE 
                        ud.inscricao_municipal = stInscricaoMunicipal
                    GROUP BY 
                        ud.cod_construcao_dependente
                 ) as tabela ON tabela.timestamp = aread.timestamp 
                 AND aread.cod_construcao_dependente = tabela.cod_construcao_dependente
                 
                LEFT JOIN 
                    (
                        SELECT
                            BAL.*
                        FROM
                            imobiliario.baixa_construcao AS BAL,
                            (
                            SELECT
                                MAX (TIMESTAMP) AS TIMESTAMP,
                                cod_construcao
                            FROM
                                imobiliario.baixa_construcao 
                            GROUP BY
                                cod_construcao
                            ) AS BT
                        WHERE
                            BAL.cod_construcao = BT.cod_construcao AND
                            BAL.timestamp = BT.timestamp
                    ) bl
                ON  
                    ( aread.cod_construcao = bl.cod_construcao OR aread.cod_construcao_dependente = bl.cod_construcao )
                
                LEFT JOIN 
                    (
                        SELECT
                            BAL.*
                        FROM
                            imobiliario.baixa_unidade_dependente AS BAL,
                            (
                            SELECT
                                MAX (TIMESTAMP) AS TIMESTAMP,
                                cod_construcao,
                                cod_construcao_dependente,
                                inscricao_municipal
                            FROM
                                imobiliario.baixa_unidade_dependente
                            GROUP BY
                                cod_construcao,
                                cod_construcao_dependente,
                                inscricao_municipal
                            ) AS BT
                        WHERE
                            BAL.cod_construcao = BT.cod_construcao AND
                            BAL.cod_construcao_dependente = BT.cod_construcao_dependente AND
                            BAL.inscricao_municipal = BT.inscricao_municipal AND
                            BAL.timestamp = BT.timestamp
                    )as bud
                ON bud.cod_construcao_dependente = aread.cod_construcao_dependente
                AND bud.cod_construcao = aread.cod_construcao
                AND bud.inscricao_municipal = aread.inscricao_municipal
            
                WHERE 
                    CASE WHEN bl.cod_construcao IS NOT NULL THEN
                        CASE WHEN bl.dt_termino IS NOT NULL THEN
                            true 
                        ELSE
                            false
                        END
                    ELSE
                        true
                    END
                    AND
                    case 
                        when bud.cod_construcao is not null then
                            case 
                                when ( bud.dt_inicio::date > now()::date OR bud.dt_termino < now()::date ) then
                                    true
                                else
                                    false
                            end
                       else
                            true
                    end     
               ;
               nuAreaTotal := Coalesce(nuAreaAutonoma,0) + Coalesce(nuAreaDependente,0) ;
            
                RETURN nuAreaTotal;
            END;
            $function$
        ');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_busca_situacao_imovel(integer, date)
             RETURNS character varying
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inIM                        ALIAS FOR $1;
                dtData                      ALIAS FOR $2;
                stSituacao                  varchar;
                stDetalhe                   varchar;
                stInicio                    varchar;
                stTermino                   varchar;
                stDataB                     varchar; 
                stJustifica                 varchar; 
                inTeste                     integer;
                inVerificador             varchar;
            BEGIN
            
            --        select inscricao_municipal
            --            , to_char(timestamp , \'dd/mm/YYYY\')
            --             , to_char(dt_inicio , \'dd/mm/YYYY\')
            --             , to_char(dt_termino, \'dd/mm/YYYY\') 
            --             , justificativa
            --          into inTeste, stDataB,stInicio,stTermino, stJustifica
            --          from imobiliario.baixa_imovel 
            --         where inscricao_municipal = inIM 
            --           and dtData
            --       between dt_inicio and dt_termino;
            
            --    if (FOUND) then
            --        stSituacao:= (\'Baixado*-*\'||stDataB||\'*-*\'||stInicio||\'*-*\'||coalesce(stTermino,\'Indeterminado\')||\'*-*\'||stJustifica)::varchar;
            --    else
            --        stSituacao:= \'Ativo\'::varchar;
            --    end if;   
            
                   
            select 
                 
                 ( case when ( tabela.inscricao_municipal is not null ) and ( dtData >= tabela.dt_inicio ) then
                        case when ( tabela.dt_termino is null ) or ( ( tabela.dt_termino is not null )  and ( dtData <= tabela.dt_termino ) )  then
                            \'Baixado*-*\'||tabela.stDataBase||\'*-*\'||tabela.dataInicio||\'*-*\'||coalesce(tabela.dataTermino,\'Indeterminado\')||\'*-*\'||tabela.justificativa
                        else
                            \'Ativo\'
                        end
                    else
                        \'Ativo\'
                    end)::varchar as valor
                  
            INTO stSituacao
            FROM
            (        
                    select 
                           inscricao_municipal
                         , to_char(timestamp , \'dd/mm/YYYY\') as stDataBase
                         , to_char(dt_inicio , \'dd/mm/YYYY\')     as dataInicio
                         , to_char(dt_termino, \'dd/mm/YYYY\' ) as dataTermino
                         , dt_inicio
                         , dt_termino
                         , justificativa
                     from imobiliario.baixa_imovel 
                     where inscricao_municipal = inIM
            ) as tabela;
            
                if ( stSituacao is null ) then
                    stSituacao := \'Ativo\'::varchar;
                end if;
                
                return stSituacao;
            
            end;
            $function$
        ');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_calcula_area_imovel_lote(integer)
            RETURNS numeric
            LANGUAGE plpgsql
            AS $function$
            DECLARE
                stInscricaoMunicipal ALIAS FOR $1;
                nuAreaLote           NUMERIC;
                inCodLote            INTEGER;
                reRegistro           RECORD;
            BEGIN
            
               SELECT imovel_lote.cod_lote
                 INTO inCodLote
                 FROM imobiliario.imovel_lote
                WHERE imovel_lote.inscricao_municipal = stInscricaoMunicipal
                ORDER BY timestamp DESC LIMIT 1;
            
                nuAreaLote := 0;
                FOR reRegistro IN 
                SELECT 
                    imobiliario.fn_calcula_area_imovel(imovel_lote.inscricao_municipal) as area_imovel
                FROM 
                    imobiliario.imovel_lote
                    INNER JOIN ( SELECT MAX(imovel_lote.timestamp) as timestamp
                            , imovel_lote.inscricao_municipal
                            , imovel_lote.cod_lote
                            FROM imobiliario.imovel_lote
                        WHERE imovel_lote.cod_lote = inCodLote
                    
                        GROUP BY imovel_lote.inscricao_municipal, imovel_lote.cod_lote
                 ) as imovel_lote_max
                
                ON
                    imovel_lote.cod_lote            = imovel_lote_max.cod_lote
                    AND imovel_lote.timestamp           = imovel_lote_max.timestamp
                    AND imovel_lote.inscricao_municipal = imovel_lote_max.inscricao_municipal
                    AND imovel_lote.inscricao_municipal = imovel_lote_max.inscricao_municipal
                WHERE
                    imovel_lote.cod_lote            = inCodLote
                    AND imobiliario.fn_busca_situacao_imovel( imovel_lote.inscricao_municipal, now()::date ) = \'Ativo\'
            
                LOOP
                  nuAreaLote := nuAreaLote + COALESCE(reRegistro.area_imovel,0);
                END LOOP;
            
                RETURN nuAreaLote;
            END;
            $function$
        ');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_calcula_area_construcao(integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inCodConstrucao      ALIAS FOR $1;
                nuAreaTotal          NUMERIC;
                reRegistro           RECORD;
                stSql                VARCHAR;
            
            BEGIN
            nuAreaTotal = 0.00;
            
                stSql := \'
                        SELECT
                            (coalesce (AUTONOMA.area_autonoma, 0) + coalesce(DEPENDENTE.area_dependente,0) ) as AREA_TOTAL,
                            AUTONOMA.area_real
                        FROM
                        (
                            SELECT
                                SUM( UA.area ) as area_autonoma,
                                MAX( AC.area_real ) as area_real
                            FROM
                                (
                                    SELECT
                                        IMUA.*
                                    FROM
                                        imobiliario.area_unidade_autonoma AS IMUA,
                                        (SELECT
                                            MAX (TIMESTAMP) AS TIMESTAMP,
                                            COD_CONSTRUCAO,
                                            COD_TIPO,
                                            INSCRICAO_MUNICIPAL
                                        FROM
                                            imobiliario.area_unidade_autonoma
                                        GROUP BY
                                            COD_CONSTRUCAO,
                                            COD_TIPO,
                                            INSCRICAO_MUNICIPAL
                                        ) AS IMUAA
                                    WHERE
                                        IMUA.COD_CONSTRUCAO      = IMUAA.COD_CONSTRUCAO
                                        AND IMUA.COD_TIPO            = IMUAA.COD_TIPO
                                        AND IMUA.INSCRICAO_MUNICIPAL = IMUAA.INSCRICAO_MUNICIPAL
                                        AND IMUA.COD_CONSTRUCAO      = \' || inCodConstrucao || \'
                                        AND IMUA.TIMESTAMP           = IMUAA.TIMESTAMP
                                ) AS UA
                                 
                                LEFT JOIN imobiliario.baixa_unidade_autonoma as bua
                                ON bua.cod_construcao = UA.cod_construcao AND bua.inscricao_municipal = UA.inscricao_municipal
                                
                                INNER JOIN imobiliario.construcao_edificacao CE
                                ON  UA.cod_construcao = CE.cod_construcao   AND UA.cod_tipo = CE.cod_tipo
                                
                                INNER JOIN imobiliario.construcao             C
                                ON C.cod_construcao =  CE.cod_construcao 
                                ,
                                (
                                    SELECT
                                        IMAC.*
                                    FROM
                                        imobiliario.area_construcao AS IMAC,
                                        (SELECT
                                            MAX (TIMESTAMP) AS TIMESTAMP,
                                            COD_CONSTRUCAO
                                        FROM
                                            imobiliario.area_construcao
                                        GROUP BY
                                            COD_CONSTRUCAO
                                        ) AS IMACC
                                    WHERE
                                        IMAC.COD_CONSTRUCAO = IMACC.COD_CONSTRUCAO
                                        AND IMAC.TIMESTAMP  = IMACC.TIMESTAMP
                                ) AS AC
                            WHERE
                                UA.COD_CONSTRUCAO = \' || inCodConstrucao || \'
                                AND C.cod_construcao  = AC.cod_construcao
                                and
                                case 
                                    when bua.cod_construcao is not null then
                                        case 
                                            when ( bua.dt_inicio::date > now()::date OR bua.dt_termino::date < now()::date ) then
                                                true
                                            else
                                                false
                                        end
                                   else
                                        true
                                end     
                        ) AS AUTONOMA,
                        (
                            SELECT
                                COALESCE( sum( UD.area ), 0 ) as area_dependente
            
                            FROM
                                imobiliario.area_unidade_dependente UD
                                INNER JOIN
                                (
                                    SELECT
                                        max(timestamp) as timestamp,
                                        cod_construcao_dependente,
                                        cod_construcao
                                    FROM
                                        imobiliario.area_unidade_dependente
                                    WHERE 
                                        cod_construcao = \' || inCodConstrucao || \'
                                    GROUP BY cod_construcao, cod_construcao_dependente
                                ) as tabela ON tabela.timestamp = UD.timestamp 
                                  AND tabela.cod_construcao = UD.cod_construcao
                                  AND tabela.cod_construcao_dependente = UD.cod_construcao_dependente
                                  
                                LEFT JOIN imobiliario.baixa_unidade_dependente as bud
                                ON bud.cod_construcao_dependente = UD.cod_construcao_dependente
                                  AND bud.cod_construcao = UD.cod_construcao
                                  AND bud.inscricao_municipal = UD.inscricao_municipal
            
                                LEFT JOIN 
                                    (
                                        SELECT
                                            BAL.*
                                        FROM
                                            imobiliario.baixa_construcao AS BAL,
                                            (
                                            SELECT
                                                MAX (TIMESTAMP) AS TIMESTAMP,
                                                cod_construcao
                                            FROM
                                                imobiliario.baixa_construcao 
                                            GROUP BY
                                                cod_construcao
                                            ) AS BT
                                        WHERE
                                            BAL.cod_construcao = BT.cod_construcao AND
                                            BAL.timestamp = BT.timestamp
                                    ) bl
                                ON
                                    (UD.cod_construcao = bl.cod_construcao OR UD.cod_construcao_dependente = bl.cod_construcao)
                            WHERE
                                UD.COD_CONSTRUCAO      = \' || inCodConstrucao || \'
                                and
                                CASE WHEN bl.cod_construcao IS NOT NULL THEN
                                    CASE WHEN bl.dt_termino IS NOT NULL THEN
                                        true 
                                    ELSE
                                        false
                                    END
                                ELSE
                                    true
                                END
                                AND
                                case 
                                    when bud.cod_construcao is not null then
                                        case 
                                            when ( bud.dt_inicio::date > now()::date OR bud.dt_termino::date < now()::date ) then
                                                true
                                            else
                                                false
                                        end
                                   else
                                        true
                                end     
                        ) AS DEPENDENTE
                \';
            
            
                FOR reRegistro IN EXECUTE stSql
                LOOP
                    nuAreaTotal := nuAreaTotal + reRegistro.AREA_TOTAL;
                END LOOP;
            
                RETURN nuAreaTotal;
            END;
            $function$
        ');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_calcula_area_imovel_construcao(integer)
            RETURNS numeric
            LANGUAGE plpgsql
            AS $function$
            DECLARE
                stInscricaoMunicipal ALIAS FOR $1;
                nuAreaConstrucao     NUMERIC;
                inCodConstrucao      INTEGER;
                reRegistro           RECORD;
                reRegistroArea       RECORD;
                stSql                VARCHAR;
                stSql2               VARCHAR;
            BEGIN
            
                BEGIN
                    stSql := \'
                        SELECT
                            max(IUA.timestamp),
                            IUA.cod_construcao
                        FROM
                            imobiliario.unidade_autonoma IUA
                        WHERE
                            IUA.inscricao_municipal = \' || stInscricaoMunicipal || \'
                        GROUP BY
                            IUA.cod_construcao
                    \';
            
                    EXECUTE stSql;
            
                EXCEPTION
                    WHEN plpgsql_error OR raise_exception THEN
                END;
            
                FOR reRegistro IN EXECUTE stSql LOOP
                    inCodConstrucao := reRegistro.cod_construcao;
                END LOOP;
            
                IF inCodConstrucao IS NULL THEN
                    nuAreaConstrucao := 0;
                ELSE
            
                    stSql := \'
                        SELECT
                            IUA.*
                        FROM
                            imobiliario.unidade_autonoma IUA,
                            (
                                SELECT
                                    max(timestamp) as timestamp,
                                    inscricao_municipal,
                                    cod_construcao
                                FROM
                                    imobiliario.unidade_autonoma
                                WHERE
                                    cod_construcao = \' || inCodConstrucao || \'
                                GROUP BY
                                    inscricao_municipal,
                                    cod_construcao
                            ) as IUAA
                        WHERE
                            IUAA.cod_construcao = IUA.cod_construcao AND
                            IUAA.timestamp = IUA.timestamp
                    \';
            
                    nuAreaConstrucao := 0;
            
                    FOR reRegistro IN EXECUTE stSql LOOP
            
                        stSql := \' select imobiliario.fn_calcula_area_construcao( \'|| inCodConstrucao ||\' ) as area \';
                        FOR reRegistroArea IN EXECUTE stSql LOOP
                            nuAreaConstrucao := nuAreaConstrucao + reRegistroArea.area;
                        END LOOP;
            
                    END LOOP;
            
                END IF;
            
                RETURN nuAreaConstrucao;
            END;
            $function$
        ');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_busca_endereco_imovel_formatado(integer)
             RETURNS character varying
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inImovel    ALIAS FOR $1;
                stRetorno   VARCHAR := null;
                stSql       VARCHAR;
                reRecord                record;
                
            BEGIN
            
            
                SELECT                     
            
                    coalesce (tl.nom_tipo, \'\' )::varchar||\' \'|| coalesce(nl.nom_logradouro, \'\')::varchar||\' \'||
                    coalesce (i.numero, \'\')::varchar||\' \'||coalesce (i.complemento, \'\')::varchar||\' - \'||
                    coalesce (bairro.nom_bairro, \'\')::varchar
            
                INTO
            
                    stRetorno
            
                FROM
                    (   SELECT * FROM
                        imobiliario.imovel
                        WHERE inscricao_municipal = inImovel
                    ) i
                    INNER JOIN imobiliario.imovel_confrontacao ic
                    ON ic.inscricao_municipal  = i.inscricao_municipal
            
                    INNER JOIN imobiliario.confrontacao_trecho ct
                    ON ct.cod_confrontacao  = ic.cod_confrontacao AND
                    ct.cod_lote             = ic.cod_lote
            
                    INNER JOIN imobiliario.trecho t
                    ON t.cod_trecho     = ct.cod_trecho     AND
                    t.cod_logradouro    = ct.cod_logradouro
            
                    INNER JOIN sw_logradouro l
                    ON l.cod_logradouro = t.cod_logradouro
            
                    INNER JOIN sw_nome_logradouro nl
                    ON nl.cod_logradouro = l.cod_logradouro
                                                           
                    INNER JOIN sw_tipo_logradouro tl
                    ON tl.cod_tipo       = nl.cod_tipo
            
                    INNER JOIN imobiliario.lote_bairro as ilb
                    ON ilb.cod_lote = ic.cod_lote
                    AND ilb.cod_municipio = l.cod_municipio
                    AND ilb.cod_uf = l.cod_uf
            
                    INNER JOIN sw_bairro as bairro
                    ON bairro.cod_bairro = ilb.cod_bairro
                    AND bairro.cod_municipio = l.cod_municipio
                    AND bairro.cod_uf = l.cod_uf
            
                    INNER JOIN sw_municipio as mun
                    ON mun.cod_municipio = l.cod_municipio
                    AND mun.cod_uf = l.cod_uf
            
                    INNER JOIN sw_uf as uf
                    ON uf.cod_uf = mun.cod_uf
            
                WHERE                                                                  
                    i.inscricao_municipal   = inImovel
                ;
            
            
                RETURN stRetorno;
            END;
            $function$
        ');

        $this->addSql('
             CREATE OR REPLACE VIEW imobiliario.vw_construcao_outros AS
             SELECT DISTINCT ON (ct.cod_construcao) ct.cod_construcao,
                ct.descricao,
                ac."timestamp",
                cp.cod_processo,
                cp.exercicio,
                dc.data_construcao,
                COALESCE(to_char(bc.dt_inicio::timestamp with time zone, \'DD/MM/YYYY\'::text), NULL::text) AS data_baixa,
                COALESCE(bc.justificativa, NULL::text) AS justificativa,
                bc."timestamp" AS timestamp_baixa,
                    CASE
                        WHEN bc.dt_inicio IS NULL OR bc.dt_inicio IS NOT NULL AND bc.dt_termino IS NOT NULL THEN \'Ativo\'::text
                        ELSE \'Baixado\'::text
                    END AS situacao,
                    CASE
                        WHEN ud.inscricao_municipal IS NOT NULL THEN ud.inscricao_municipal
                        ELSE cd.cod_condominio
                    END AS imovel_cond,
                    CASE
                        WHEN cd.cod_condominio IS NOT NULL THEN cd.nom_condominio
                        ELSE NULL::character varying
                    END AS nom_condominio,
                    CASE
                        WHEN ud.inscricao_municipal::character varying IS NOT NULL THEN \'Dependente\'::text
                        ELSE \'Condomínio\'::text
                    END AS tipo_vinculo,
                    CASE
                        WHEN ud.inscricao_municipal::character varying IS NOT NULL THEN aud.area
                        ELSE ac.area_real
                    END AS area_real
               FROM imobiliario.construcao_outros ct
                 LEFT JOIN ( SELECT bal.cod_construcao,
                        bal."timestamp",
                        bal.justificativa,
                        bal.sistema,
                        bal.justificativa_termino,
                        bal.dt_inicio,
                        bal.dt_termino
                       FROM imobiliario.baixa_construcao bal,
                        ( SELECT max(baixa_construcao."timestamp") AS "timestamp",
                                baixa_construcao.cod_construcao
                               FROM imobiliario.baixa_construcao
                              GROUP BY baixa_construcao.cod_construcao) bt
                      WHERE bal.cod_construcao = bt.cod_construcao AND bal."timestamp" = bt."timestamp") bc ON ct.cod_construcao = bc.cod_construcao
                 LEFT JOIN imobiliario.data_construcao dc ON dc.cod_construcao = ct.cod_construcao
                 LEFT JOIN ( SELECT ac_1.cod_construcao,
                        ac_1."timestamp",
                        ac_1.area_real
                       FROM imobiliario.area_construcao ac_1,
                        ( SELECT max(area_construcao."timestamp") AS "timestamp",
                                area_construcao.cod_construcao
                               FROM imobiliario.area_construcao
                              GROUP BY area_construcao.cod_construcao) mac
                      WHERE ac_1.cod_construcao = mac.cod_construcao AND ac_1."timestamp" = mac."timestamp") ac ON ct.cod_construcao = ac.cod_construcao
                 LEFT JOIN imobiliario.construcao_processo cp ON ct.cod_construcao = cp.cod_construcao
                 LEFT JOIN imobiliario.unidade_dependente ud ON ct.cod_construcao = ud.cod_construcao_dependente
                 LEFT JOIN ( SELECT aud_1.inscricao_municipal,
                        aud_1.cod_construcao_dependente,
                        aud_1.cod_tipo,
                        aud_1.cod_construcao,
                        aud_1."timestamp",
                        aud_1.area
                       FROM imobiliario.area_unidade_dependente aud_1,
                        ( SELECT max(area_unidade_dependente."timestamp") AS "timestamp",
                                area_unidade_dependente.cod_construcao_dependente
                               FROM imobiliario.area_unidade_dependente
                              GROUP BY area_unidade_dependente.cod_construcao_dependente) maud
                      WHERE aud_1.cod_construcao_dependente = maud.cod_construcao_dependente AND aud_1."timestamp" = maud."timestamp") aud ON ct.cod_construcao = aud.cod_construcao_dependente
                 LEFT JOIN ( SELECT cc.cod_construcao,
                        cd_1.cod_condominio,
                        cd_1.cod_tipo,
                        cd_1.nom_condominio,
                        cd_1."timestamp"
                       FROM imobiliario.construcao_condominio cc,
                        imobiliario.condominio cd_1
                      WHERE cd_1.cod_condominio = cc.cod_condominio) cd ON ct.cod_construcao = cd.cod_construcao
              ORDER BY ct.cod_construcao;
        ');

        $this->addSql('
             CREATE OR REPLACE VIEW imobiliario.vw_max_area_un_aut AS
             SELECT aua.inscricao_municipal,
                aua.cod_tipo,
                aua.cod_construcao,
                aua."timestamp",
                aua.area
               FROM imobiliario.area_unidade_autonoma aua,
                ( SELECT max(area_unidade_autonoma."timestamp") AS "timestamp",
                        area_unidade_autonoma.cod_construcao
                       FROM imobiliario.area_unidade_autonoma
                      GROUP BY area_unidade_autonoma.cod_construcao) maua
              WHERE aua.cod_construcao = maua.cod_construcao AND aua."timestamp" = maua."timestamp";
        ');

        $this->insertRoute('tributario_imobiliario_edificacao_home', 'Cadastro Imobiliário - Edificação', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_imovel_list', 'Imóvel', 'tributario_imobiliario_edificacao_home');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_imovel_create', 'Incluir', 'urbem_tributario_imobiliario_edificacao_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_imovel_edit', 'Alterar', 'urbem_tributario_imobiliario_edificacao_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_imovel_delete', 'Excluir', 'urbem_tributario_imobiliario_edificacao_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_edificacao_imovel_show', 'Detalhe', 'urbem_tributario_imobiliario_edificacao_imovel_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
