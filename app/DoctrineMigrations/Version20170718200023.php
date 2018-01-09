<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\ExProprietario;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170718200023 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_busca_lote_imovel(integer)
             RETURNS integer
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inIM                        ALIAS FOR $1;
                arRetorno                  VARCHAR ;
                inResultado                 INTEGER := 0;
                boLog                       BOOLEAN;
            
            BEGIN
                SELECT INTO inResultado (
                            SELECT
                                coalesce(l.cod_lote,0)
                            FROM
                                imobiliario.lote l
                            INNER JOIN  (
                                        SELECT il.inscricao_municipal, il.cod_lote, il."timestamp"
                                        FROM imobiliario.imovel_lote il
                                        WHERE il.inscricao_municipal = inIM
                                        ORDER BY il.timestamp DESC
                                        LIMIT 1
                                         ) ilote     ON l.cod_lote                   = ilote.cod_lote
                            INNER JOIN imobiliario.imovel i                     ON ilote.inscricao_municipal    = i.inscricao_municipal
            
                            WHERE
                               i.inscricao_municipal = inIM     );
            
                RETURN inResultado;
            END;
            $function$
        ');

        $this->addSql('
            CREATE OR REPLACE FUNCTION imobiliario.fn_area_real(integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inIM                        ALIAS FOR $1;
                inCodLote                   INTEGER;
                stSql                       VARCHAR   := \'\';
                reRecord                    RECORD;
                nuResultado                 NUMERIC   := 0.00;
                boLog   BOOLEAN;
            BEGIN
                inCodLote := imobiliario.fn_busca_lote_imovel(inIm);
                SELECT tbl_area.area INTO nuResultado
                FROM (
                    SELECT
                        coalesce(a.area_real,0) as area
                    FROM
                        imobiliario.area_lote a,
                        imobiliario.lote b
                    WHERE
                        a.cod_lote = b.cod_lote  and
                        a.cod_lote = inCodLote
                    ORDER BY a.timestamp DESC
                    LIMIT 1
                    ) as tbl_area;
                RETURN nuResultado;
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
            CREATE OR REPLACE FUNCTION public.calculafracaoideal(inimovel integer)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            DECLARE
              nuAreaImoveisLote  NUMERIC;
              nuAreaLote 	     NUMERIC;	
              nuFracaoIdeal      NUMERIC;	
              nuAreaImovel       NUMERIC;	
              inQuantidade 	     INTEGER; 		
            BEGIN
              inQuantidade 	    := recuperaQuantidadeImovelPorLote(inImovel); 
              nuAreaLote 	    := imobiliario.fn_area_real(inImovel); 
              nuAreaImoveisLote := imobiliario.fn_calcula_area_imovel_lote(inImovel);
              nuAreaImovel      := IMOBILIARIO.FN_CALCULA_AREA_IMOVEL( inImovel );
            
              IF ( nuAreaImoveisLote > 0 ) THEN
                nuFracaoIdeal     := (nuAreaImovel*nuAreaLote )/nuAreaImoveisLote ;
              ELSE
                nuFracaoIdeal     := 0.00;
              END IF;
            
              return ROUND (nuFracaoIdeal,2);
            
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
            CREATE OR REPLACE FUNCTION imobiliario.fn_rl_cadastro_imobiliario(character varying, character varying, character varying, character varying, character varying, character varying)
             RETURNS SETOF record
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                stFiltroLote        ALIAS FOR $1;
                stFiltroImovel      ALIAS FOR $2;
                stDistinct          ALIAS FOR $3;
                stFiltAtribImovel   ALIAS FOR $4;
                stFiltAtribLote     ALIAS FOR $5;
                stFiltAtribEdif     ALIAS FOR $6;
                stTEMPAtribImob     VARCHAR   := \'\';
                stTEMPAtribLote     VARCHAR   := \'\';
                stTEMPAtribEdif     VARCHAR   := \'\';
                stInscricao         VARCHAR   := \'\';
                stSql               VARCHAR   := \'\';
                stAuxJoin           VARCHAR   := \'LEFT JOIN\';
                reRegistro          RECORD;
                arRetorno           NUMERIC[];
                --crCursor            REFCURSOR;
            
            BEGIN
                IF ( stFiltAtribImovel IS NULL ) OR ( stFiltAtribImovel = \'\' ) THEN 
                    stTEMPAtribImob := \' GROUP BY atributo_imovel_valor.inscricao_municipal \';
                ELSE
                    stTEMPAtribImob := stFiltAtribImovel;
                END IF;
            
                IF ( stFiltAtribLote IS NULL ) OR ( stFiltAtribLote = \'\' ) THEN 
                    stTEMPAtribLote := \' GROUP BY cod_lote \';
                ELSE
                    stTEMPAtribLote := stFiltAtribLote;
                    stAuxJoin := \'INNER JOIN\';
                END IF;
            
                IF ( stFiltAtribEdif IS NULL ) OR ( stFiltAtribEdif = \'\' ) THEN 
                    stTEMPAtribEdif := \'
                        GROUP BY cod_construcao
                               , cod_tipo
                    \';
                ELSE
                    stTEMPAtribEdif := stFiltAtribEdif;
                END IF;
            
                IF stDistinct = \'TRUE\' THEN
                    stInscricao := \' DISTINCT ON( I.inscricao_municipal ) I.inscricao_municipal,\';
                ELSE
                    stInscricao := \' I.inscricao_municipal,\';
                END IF;
            
                stSql := \'CREATE TEMPORARY TABLE tmp_lote_urbano AS
                            SELECT DISTINCT ON ( I.inscricao_municipal ) I.inscricao_municipal
                                 , I.numero
                                 , I.complemento
                                 , I.dt_cadastro
                                 , C.numcgm
                                 , C.nom_cgm||\'\' - \'\'||IP.cota as proprietario_cota
                                 , L.cod_lote
                                 , 1 as tipo_lote
                                 , LL.valor
                                 , LOC.cod_localizacao
                                 , LOC.codigo_composto||\'\' \'\'||LOC.nom_localizacao as localizacao
                                 , IL.timestamp
                                 , I.cep
                              FROM imobiliario.imovel AS I
                        INNER JOIN ( SELECT IIL.*
                                       FROM imobiliario.imovel_lote IIL,
                                          ( SELECT MAX (TIMESTAMP) AS TIMESTAMP
                                                 , INSCRICAO_MUNICIPAL
                                              FROM imobiliario.imovel_lote
                                          GROUP BY INSCRICAO_MUNICIPAL
                                          ) AS IL
                                      WHERE IIL.INSCRICAO_MUNICIPAL = IL.INSCRICAO_MUNICIPAL
                                        AND IIL.TIMESTAMP = IL.TIMESTAMP
                                   ) AS IL 
                                ON I.inscricao_municipal = IL.inscricao_municipal
                        INNER JOIN imobiliario.proprietario AS IP
                                ON I.inscricao_municipal = IP.inscricao_municipal
                        INNER JOIN sw_cgm AS C
                                ON IP.numcgm = C.numcgm
                        INNER JOIN imobiliario.lote_urbano AS L
                                ON IL.cod_lote = L.cod_lote
                        INNER JOIN imobiliario.lote_localizacao AS LL
                                ON LL.cod_lote = IL.cod_lote 
                        INNER JOIN imobiliario.localizacao AS LOC
                                ON LL.cod_localizacao = LOC.cod_localizacao
                        \'||stAuxJoin||\' ( SELECT DISTINCT tmp.cod_lote
                                       FROM imobiliario.atributo_lote_urbano_valor AS tmp
                                 INNER JOIN ( SELECT max(timestamp) AS timestamp
                                                   , cod_lote
                                                FROM imobiliario.atributo_lote_urbano_valor
                                                \'|| stTEMPAtribLote ||\'
                                            )AS tmp2
                                         ON tmp.cod_lote = tmp2.cod_lote
                                        AND tmp.timestamp = tmp2.timestamp
                                   ) AS aluv
                                ON aluv.cod_lote = IL.cod_lote
                             WHERE LL.cod_localizacao = LOC.cod_localizacao
                                   \'|| stFiltroLote ||\'
                \';
            
                EXECUTE stSql;
            
                stSql := \'CREATE TEMPORARY TABLE tmp_lote_rural AS
                                SELECT DISTINCT ON ( I.inscricao_municipal ) I.inscricao_municipal
                                     , I.numero
                                     , I.complemento
                                     , C.numcgm
                                     , I.dt_cadastro
                                     , C.nom_cgm||\'\' - \'\'||IP.cota as proprietario_cota
                                     , L.cod_lote
                                     , 2 as tipo_lote
                                     , LL.valor
                                     , LOC.cod_localizacao
                                     , LOC.codigo_composto||\'\' \'\'||LOC.nom_localizacao as localizacao
                                     , IL.timestamp
                                     , I.cep
                                  FROM imobiliario.imovel AS I
                            INNER JOIN ( SELECT IIL.*
                                           FROM imobiliario.imovel_lote IIL
                                              , ( SELECT MAX (TIMESTAMP) AS TIMESTAMP
                                                       , INSCRICAO_MUNICIPAL
                                                    FROM imobiliario.imovel_lote
                                                GROUP BY INSCRICAO_MUNICIPAL
                                                ) AS IL
                                          WHERE IIL.INSCRICAO_MUNICIPAL = IL.INSCRICAO_MUNICIPAL
                                            AND IIL.TIMESTAMP = IL.TIMESTAMP
                                       ) AS IL 
                                    ON I.inscricao_municipal = IL.inscricao_municipal
                            INNER JOIN imobiliario.proprietario AS IP
                                    ON I.inscricao_municipal = IP.inscricao_municipal
                            INNER JOIN sw_cgm AS C
                                    ON IP.numcgm = C.numcgm
                            INNER JOIN imobiliario.lote_rural AS L
                                    ON IL.cod_lote = L.cod_lote
                            INNER JOIN imobiliario.lote_localizacao AS LL
                                    ON LL.cod_lote = IL.cod_lote 
                            INNER JOIN imobiliario.localizacao AS LOC
                                    ON LL.cod_localizacao = LOC.cod_localizacao
                            \'||stAuxJoin||\' ( SELECT DISTINCT tmp.cod_lote
                                           FROM imobiliario.atributo_lote_rural_valor AS tmp
                                     INNER JOIN ( SELECT max(timestamp) AS timestamp
                                                       , cod_lote
                                                    FROM imobiliario.atributo_lote_rural_valor
                                                    \'|| stTEMPAtribLote ||\'
                                                )AS tmp2
                                             ON tmp.cod_lote = tmp2.cod_lote
                                            AND tmp.timestamp = tmp2.timestamp
                                       ) AS aluv
                                    ON aluv.cod_lote = IL.cod_lote
                                 WHERE LL.cod_localizacao = LOC.cod_localizacao
                                 \'|| stFiltroLote ||\'
                \';
            
                EXECUTE stSql;
            
                --CREATE UNIQUE INDEX unq_urbano ON tmp_lote_urbano(inscricao_municipal,timestamp);
                --CREATE UNIQUE INDEX unq_rural  ON tmp_lote_rural (inscricao_municipal,timestamp);
            
                stSql := \'CREATE TEMPORARY TABLE tmp_imovel AS
                              SELECT inscricao_municipal
                                   , numero
                                   , complemento
                                   , numcgm
                                   , dt_cadastro
                                   , cep
                                   , proprietario_cota
                                   , cod_lote
                                   , tipo_lote
                                   , valor
                                   , cod_localizacao
                                   , localizacao 
                                FROM tmp_lote_urbano
                               UNION SELECT inscricao_municipal
                                          , numero
                                          , complemento
                                          , numcgm
                                          , dt_cadastro
                                          , cep 
                                          , proprietario_cota
                                          , cod_lote
                                          , tipo_lote
                                          , valor
                                          , cod_localizacao
                                          , localizacao 
                                       FROM tmp_lote_rural
                \';
            
                EXECUTE stSql;
            
                --CREATE UNIQUE INDEX unq_imovel ON tmp_imovel (inscricao_municipal,oid_temp);
            
                --seleciona todos imoveis
                stSql := \'
                    SELECT DISTINCT I.inscricao_municipal
                         , I.proprietario_cota
                         , I.cod_lote
                         , I.dt_cadastro
                         , CASE WHEN I.tipo_lote = 1 THEN \'\'Urbano\'\'
                                WHEN I.tipo_lote = 2 THEN \'\'Rural\'\'
                                 END AS tipo_lote
                         , I.valor as valor_lote
                         , ( imobiliario.fn_busca_endereco_imovel_formatado ( I.inscricao_municipal ) ) as endereco
                         , I.cep as cep
                         , I.cod_localizacao
                         , I.localizacao
                         , ICO.cod_condominio
                         , II.creci
                         , B.nom_bairro
                         , TLO.nom_tipo||\'\' \'\'||NLO.nom_logradouro as logradouro
                         , CASE WHEN ((BI.inscricao_municipal IS NULL) or (BI.dt_termino IS NOT NULL)) THEN \'\'Ativo\'\'
                                WHEN BI.inscricao_municipal IS NOT NULL THEN \'\'Baixado\'\'
                                 END AS situacao
                      FROM tmp_imovel AS I
                 LEFT JOIN ( SELECT DISTINCT tmp.inscricao_municipal
                               FROM imobiliario.atributo_imovel_valor AS tmp
                         INNER JOIN ( SELECT atributo_imovel_valor.inscricao_municipal
                                           , max(atributo_imovel_valor.timestamp) AS timestamp
                                        FROM imobiliario.atributo_imovel_valor
                                        \'|| stTEMPAtribImob ||\'
                                    )AS tmp2
                                 ON tmp.inscricao_municipal = tmp2.inscricao_municipal
                                AND tmp.timestamp = tmp2.timestamp
                         INNER JOIN tmp_imovel
                                 ON tmp_imovel.inscricao_municipal = tmp.inscricao_municipal
                           )AS aiv
                        ON aiv.inscricao_municipal = I.inscricao_municipal
                 LEFT JOIN ( SELECT DISTINCT IUA.inscricao_municipal
                               FROM imobiliario.atributo_tipo_edificacao_valor AS tmp
                         INNER JOIN ( SELECT max(timestamp) AS timestamp
                                           , cod_construcao
                                           , cod_tipo
                                        FROM imobiliario.atributo_tipo_edificacao_valor
                                        \'|| stTEMPAtribEdif ||\'
                                    )AS tmp2
                                 ON tmp.cod_construcao = tmp2.cod_construcao
                                AND tmp.cod_tipo = tmp2.cod_tipo
                                AND tmp.timestamp = tmp2.timestamp
                         INNER JOIN imobiliario.unidade_autonoma IUA 
                                 ON tmp.cod_construcao = IUA.cod_construcao
                                AND tmp.cod_tipo = IUA.cod_tipo
                         INNER JOIN tmp_imovel
                                 ON tmp_imovel.inscricao_municipal = IUA.inscricao_municipal
                           )AS atev
                        ON atev.inscricao_municipal = I.inscricao_municipal
                 LEFT JOIN imobiliario.imovel_imobiliaria II 
                        ON II.inscricao_municipal = I.inscricao_municipal
                 LEFT JOIN imobiliario.imovel_condominio ICO 
                        ON ICO.inscricao_municipal = I.inscricao_municipal
                 LEFT JOIN ( SELECT BAI.*
                               FROM imobiliario.baixa_imovel AS BAI
                                  , ( SELECT MAX (TIMESTAMP) AS TIMESTAMP
                                           , inscricao_municipal
                                        FROM imobiliario.baixa_imovel
                                    GROUP BY inscricao_municipal
                                    ) AS BI
                              WHERE BAI.inscricao_municipal = BI.inscricao_municipal 
                                AND BAI.timestamp = BI.timestamp 
                           ) BI 
                        ON BI.inscricao_municipal = I.inscricao_municipal
                 LEFT JOIN imobiliario.lote_bairro  LB
                        ON LB.cod_lote = I.cod_lote
                 LEFT JOIN sw_bairro B
                        ON LB.cod_bairro          = B.cod_bairro           
                       AND LB.cod_municipio       = B.cod_municipio        
                       AND LB.cod_uf              = B.cod_uf
                 LEFT JOIN imobiliario.imovel_confrontacao  IC
                        ON IC.inscricao_municipal = I.inscricao_municipal  
                       AND IC.cod_lote            = I.cod_lote
                 LEFT JOIN imobiliario.confrontacao_trecho  CT
                        ON CT.cod_confrontacao    = IC.cod_confrontacao    
                       AND CT.cod_lote            = IC.cod_lote            
                       AND CT.principal           = true
                 LEFT JOIN sw_logradouro LO
                        ON CT.cod_logradouro      = LO.cod_logradouro
                 LEFT JOIN ( SELECT snl.*
                               FROM ( SELECT NL.* 
                                        from ( SELECT cod_logradouro
                                                    , cod_tipo
                                                    , nom_logradouro
                                                    , max(timestamp) as timestamp
                                                 FROM sw_nome_logradouro
                                             GROUP BY cod_logradouro
                                                    , cod_tipo
                                                    , nom_logradouro 
                                             ORDER BY 1
                                             ) NL
                                   LEFT JOIN sw_tipo_logradouro TLO
                                          ON NL.cod_tipo = TLO.cod_tipo
                                    ) as snl
                               JOIN ( SELECT cod_logradouro
                                           , max(timestamp) as timestamp
                                        FROM sw_nome_logradouro
                                    GROUP BY cod_logradouro
                                    ) as snlm
                                 ON snlm.cod_logradouro = snl.cod_logradouro 
                                and snlm.timestamp      = snl.timestamp
                           )  NLO
                        ON NLO.cod_logradouro     = LO.cod_logradouro
                 LEFT JOIN sw_tipo_logradouro               TLO
                        ON NLO.cod_tipo           = TLO.cod_tipo
                     WHERE i.inscricao_municipal is not NULL
                     \'||stFiltroImovel||\' 
                  \';
            
                FOR reRegistro IN EXECUTE stSql
                LOOP
                    RETURN NEXT reRegistro;
                END LOOP;
            
                DROP TABLE tmp_lote_urbano;
                DROP TABLE tmp_lote_rural;
                DROP TABLE tmp_imovel;
            
                RETURN;
            END;
            $function$
        ');

        $this->changeColumnToDateTimeMicrosecondType(ExProprietario::class, 'timestamp');

        $this->insertRoute('tributario_imobiliario_consultas_home', 'Cadastro Imobiliário - Consultas', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_consultas_cadastro_imobiliario_list', 'Consultar Cadastro Imobiliário', 'tributario_imobiliario_consultas_home');
        $this->insertRoute('urbem_tributario_imobiliario_consultas_cadastro_imobiliario_show', 'Detalhe', 'urbem_tributario_imobiliario_consultas_cadastro_imobiliario_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.fn_busca_lote_imovel(integer);');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.imobiliario.fn_area_real(integer);');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.fn_busca_situacao_imovel(integer, date);');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.fn_calcula_area_construcao(integer);');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.fn_calcula_area_imovel_construcao(integer);');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.fn_calcula_area_imovel(integer);');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.fn_calcula_area_imovel_lote(integer);');
        $this->addSql('DROP FUNCTION IF EXISTS public.calculafracaoideal(inimovel integer);');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.fn_busca_endereco_imovel_formatado(integer);');
        $this->addSql('DROP FUNCTION IF EXISTS imobiliario.fn_rl_cadastro_imobiliario(character varying, character varying, character varying, character varying, character varying, character varying);');
    }
}
