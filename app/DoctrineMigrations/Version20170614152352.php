<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170614152352 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_consulta_endereco_todos(integer, integer, integer)
                 RETURNS character varying
                 LANGUAGE plpgsql
                AS $function$
                DECLARE
                    inInscricao     ALIAS FOR $1; --cgm, inscricao_municipal,inscricao_economica
                    inTipo          ALIAS FOR $2; --qual tipo (3 = cgm, 1 = ins munc, 2 = insc eco)
                    inDados         ALIAS FOR $3; --(1=endereco, 2=bairro, 3=cep,4=municipio,5=localizacao,6=numero)
                    stRetorno       VARCHAR;
                    stTipo          VARCHAR;
                    inImovel        integer;
                    
                BEGIN
                
                    IF ( inTipo = 1 ) THEN --inscricao municipal
                        IF ( inDados = 1 ) THEN
                            SELECT
                                coalesce(tl.nom_tipo,\' \')         ||\' \'||                                                    
                                coalesce(nl.nom_logradouro,\' \')   ||\' \'||
                                coalesce(ltrim(i.numero)::varchar,\' \')   ||\' \'||
                                coalesce(i.complemento,\' \')  
                            INTO
                                stRetorno
                            FROM                                                                   
                                (   SELECT * FROM
                                    imobiliario.imovel
                                    WHERE inscricao_municipal = inInscricao
                                ) i,                                              
                                imobiliario.imovel_confrontacao ic,                                
                                imobiliario.confrontacao_trecho ct,                                
                                imobiliario.trecho t,                                              
                                sw_logradouro l,
                                sw_nome_logradouro nl,                                               
                                sw_tipo_logradouro tl
                            WHERE                                                                  
                                ic.inscricao_municipal  = i.inscricao_municipal     AND            
                                ct.cod_confrontacao     = ic.cod_confrontacao       AND            
                                ct.cod_lote             = ic.cod_lote               AND            
                                t.cod_trecho            = ct.cod_trecho             AND            
                                t.cod_logradouro        = ct.cod_logradouro         AND            
                                l.cod_logradouro        = t.cod_logradouro          AND            
                                nl.cod_logradouro       = l.cod_logradouro          AND               
                                tl.cod_tipo             = nl.cod_tipo               AND               
                                i.inscricao_municipal   = inInscricao ;
                        ELSIF ( inDados = 2 ) THEN
                            SELECT
                                coalesce(sb.nom_bairro, \' \')
                            INTO
                                stRetorno
                            FROM                                                                   
                                (   SELECT * FROM
                                    imobiliario.imovel
                                    WHERE inscricao_municipal = inInscricao
                                ) i,                                              
                                imobiliario.imovel_lote il,                                
                                imobiliario.lote ilot,
                                imobiliario.lote_bairro ilb,
                                sw_bairro sb
                
                            WHERE
                                il.inscricao_municipal  = i.inscricao_municipal     AND
                                ilot.cod_lote = il.cod_lote                         AND
                                ilot.cod_lote = ilb.cod_lote                        AND
                                sb.cod_bairro = ilb.cod_bairro                      AND
                                sb.cod_uf = ilb.cod_uf                              AND
                                sb.cod_municipio = ilb.cod_municipio                AND
                                i.inscricao_municipal = inInscricao 
                
                            ORDER BY ilot.timestamp, ilb.timestamp DESC LIMIT 1;
                        ELSIF ( inDados = 3 ) THEN
                            SELECT 
                                coalesce(imovel.cep, \' \')
                            INTO
                                stRetorno 
                            FROM
                                imobiliario.imovel
                            WHERE 
                                inscricao_municipal = inInscricao;
                        ELSIF ( inDados = 4 ) THEN
                            SELECT
                                coalesce(sm.nom_municipio, \' \')||\' - \'||
                                coalesce(su.nom_uf, \' \')
                            INTO
                                stRetorno
                            FROM                                                                   
                                (   SELECT * FROM
                                    imobiliario.imovel
                                    WHERE inscricao_municipal = inInscricao
                                ) i,                                              
                                imobiliario.imovel_lote il,                                
                                imobiliario.lote ilot,
                                imobiliario.lote_bairro ilb,
                                sw_municipio sm,
                                sw_uf su
                
                            WHERE
                                il.inscricao_municipal  = i.inscricao_municipal     AND
                                ilot.cod_lote = il.cod_lote                         AND
                                ilot.cod_lote = ilb.cod_lote                        AND
                                sm.cod_uf = ilb.cod_uf                              AND
                                sm.cod_municipio = ilb.cod_municipio                AND
                                su.cod_uf = ilb.cod_uf                              AND
                                i.inscricao_municipal = inInscricao 
                
                            ORDER BY ilot.timestamp, ilb.timestamp DESC LIMIT 1;
                        ELSIF ( inDados = 5 ) THEN
                            SELECT
                                (
                                    SELECT 
                                        tmp_il.nom_localizacao 
                                    FROM 
                                        imobiliario.localizacao AS tmp_il 
                                    INNER JOIN 
                                        imobiliario.localizacao_nivel AS tmp_iln 
                                    ON  
                                        tmp_il.codigo_composto = tmp_iln.valor || \'.00\' 
                                        AND tmp_iln.cod_localizacao = lote_localizacao.cod_localizacao 
                                        AND tmp_iln.cod_nivel = 1
                                )
                            INTO
                                stRetorno
                
                            FROM
                                imobiliario.imovel_lote
                
                            INNER JOIN
                                (
                                    SELECT
                                        max(tmp.timestamp) AS timestamp,
                                        tmp.inscricao_municipal
                                    FROM
                                        imobiliario.imovel_lote AS tmp
                                    GROUP BY
                                        tmp.inscricao_municipal
                                )AS iml
                            ON
                                iml.inscricao_municipal = imovel_lote.inscricao_municipal
                                AND iml.timestamp = imovel_lote.timestamp
                
                            INNER JOIN
                                imobiliario.lote_localizacao
                            ON
                                lote_localizacao.cod_lote = imovel_lote.cod_lote
                
                            WHERE
                                imovel_lote.inscricao_municipal = inInscricao;
                        
                        ELSIF ( inDados = 6 ) THEN
                            SELECT
                                coalesce(imovel.numero, \' \')
                            INTO
                                stRetorno 
                            FROM
                                imobiliario.imovel
                            WHERE
                                inscricao_municipal = inInscricao;
                                
                        END IF;
                    ELSIF ( inTipo = 2 ) THEN --inscricao economica
                            SELECT tipo 
                                    INTO stTipo
                                    FROM (   select inscricao_economica
                                                    , timestamp
                                                    , \'informado\' as tipo 
                                                from economico.domicilio_informado 
                                                where inscricao_economica = inInscricao
                                        union select inscricao_economica
                                                    , timestamp
                                                    , \'fiscal\' as tipo 
                                                from economico.domicilio_fiscal 
                                                where inscricao_economica = inInscricao
                                            order by timestamp desc limit 1
                                        ) as res;
                            
                                if stTipo = \'fiscal\' then
                                    SELECT 
                                        inscricao_municipal 
                                    INTO 
                                        inImovel 
                                    FROM 
                                        economico.domicilio_fiscal 
                                    where 
                                        inscricao_economica= inInscricao ORDER BY timestamp DESC LIMIT 1;
                
                                    IF ( inDados = 5 ) THEN
                                        SELECT
                                            (
                                                SELECT 
                                                    tmp_il.nom_localizacao 
                                                FROM 
                                                    imobiliario.localizacao AS tmp_il 
                                                INNER JOIN 
                                                    imobiliario.localizacao_nivel AS tmp_iln 
                                                ON  
                                                    tmp_il.codigo_composto = tmp_iln.valor || \'.00\' 
                                                    AND tmp_iln.cod_localizacao = lote_localizacao.cod_localizacao 
                                                    AND tmp_iln.cod_nivel = 1
                                            )
                                        INTO
                                            stRetorno
                
                                        FROM
                                            imobiliario.imovel_lote
                            
                                        INNER JOIN
                                            (
                                                SELECT
                                                    max(tmp.timestamp) AS timestamp,
                                                    tmp.inscricao_municipal
                                                FROM
                                                    imobiliario.imovel_lote AS tmp
                                                GROUP BY
                                                    tmp.inscricao_municipal
                                            )AS iml
                                        ON
                                            iml.inscricao_municipal = imovel_lote.inscricao_municipal
                                            AND iml.timestamp = imovel_lote.timestamp
                            
                                        INNER JOIN
                                            imobiliario.lote_localizacao
                                        ON
                                            lote_localizacao.cod_lote = imovel_lote.cod_lote
                            
                                        WHERE
                                            imovel_lote.inscricao_municipal = inImovel;
                                    ELSE
                                        stRetorno := arrecadacao.fn_consulta_endereco_todos(inImovel, 1, inDados);
                                        if stRetorno is null then
                                            stRetorno := \'Endereço Inválido!\';
                                        end if;
                                    END IF;
                                elsif stTipo = \'informado\' then    
                                    IF ( inDados = 1 ) THEN
                                        SELECT                     
                                            coalesce(tl.nom_tipo,\' \')         ||\' \'||
                                            coalesce(nl.nom_logradouro,\' \')   ||\' \'||
                                            coalesce(ltrim(di.numero,\'0\'),\' \')  ||\' \'||
                                            coalesce(di.complemento,\' \')  
                                        INTO
                                            stRetorno
                                        FROM                                                                   
                                            economico.domicilio_informado di,
                                            sw_logradouro l,
                                            sw_nome_logradouro nl,                                               
                                            sw_tipo_logradouro tl
                                        WHERE                                                                  
                                            l.cod_logradouro        = di.cod_logradouro         AND            
                                            nl.cod_logradouro       = l.cod_logradouro          AND               
                                            tl.cod_tipo             = nl.cod_tipo               AND
                                            di.inscricao_economica  = inInscricao
                                        ORDER BY di.timestamp DESC limit 1;
                                    ELSIF ( inDados = 2 ) THEN
                                        SELECT
                                            coalesce(sb.nom_bairro, \' \')
                                        INTO
                                            stRetorno
                                        FROM                                                                   
                                            economico.domicilio_informado di,
                                            sw_bairro sb
                                        WHERE                                                                  
                                            di.cod_bairro = sb.cod_bairro             AND
                                            di.cod_uf = sb.cod_uf                     AND
                                            di.cod_municipio = sb.cod_municipio       AND
                                            di.inscricao_economica  = inInscricao
                                        ORDER BY di.timestamp DESC limit 1;
                                    ELSIF ( inDados = 3 ) THEN
                                        SELECT
                                            coalesce(di.cep, \' \')
                                        INTO
                                            stRetorno
                                        FROM                                                                   
                                            economico.domicilio_informado di
                                        WHERE                                                                  
                                            di.inscricao_economica  = inInscricao
                                        ORDER BY di.timestamp DESC limit 1;
                                    ELSIF ( inDados = 4 ) THEN
                                        SELECT
                                            coalesce(sm.nom_municipio, \' \')||\' - \'||coalesce(su.nom_uf, \' \')
                                        INTO
                                            stRetorno
                                        FROM                                                                   
                                            economico.domicilio_informado di,
                                            sw_municipio sm,
                                            sw_uf su
                                        WHERE
                                            sm.cod_uf = di.cod_uf                     AND
                                            di.cod_uf = su.cod_uf                     AND
                                            di.cod_municipio = sm.cod_municipio       AND
                                            di.inscricao_economica  = inInscricao
                                        ORDER BY di.timestamp DESC limit 1;
                                        
                                    ELSIF ( inDados = 6 ) THEN
                                        SELECT
                                            coalesce(di.numero, \' \')
                                        INTO
                                            stRetorno
                                        FROM
                                            economico.domicilio_informado di
                                        WHERE                                   
                                            di.inscricao_economica  = inInscricao
                                        ORDER BY di.timestamp DESC limit 1;                        
                                        
                                    END IF;
                                else
                                    stRetorno := \'Não Encontrado\';
                                end if;
                        ELSIF ( inTipo = 3 ) THEN --cgm
                            IF ( inDados = 1 ) THEN
                                SELECT
                                    coalesce(cgm.tipo_logradouro, \' \')    ||\' \'||
                                    coalesce(cgm.logradouro, \' \')         ||\' \'||
                                    coalesce(ltrim(cgm.numero, \'0\' ), \' \')  ||\' \'||
                                    coalesce(cgm.complemento, \' \')
                                INTO
                                    stRetorno
                                FROM                                                                   
                                    sw_cgm cgm
                                WHERE                                                                  
                                    cgm.numcgm = inInscricao ;
                            ELSIF ( inDados = 2 ) THEN
                                SELECT
                                    coalesce(cgm.bairro, \' \')
                                INTO
                                    stRetorno
                                FROM                                                                   
                                    sw_cgm cgm
                                WHERE                                                                  
                                    cgm.numcgm = inInscricao ;
                            ELSIF ( inDados = 3 ) THEN
                                SELECT
                                    coalesce(cgm.cep, \' \')
                                INTO
                                    stRetorno
                                FROM                                                                   
                                    sw_cgm cgm
                                WHERE                                                                  
                                    cgm.numcgm = inInscricao ;
                            ELSIF ( inDados = 4 ) THEN
                                SELECT
                                    coalesce(sm.nom_municipio, \' \')||\' - \'||coalesce(su.nom_uf, \' \')
                                INTO
                                    stRetorno
                                FROM                                                                   
                                    sw_cgm cgm,
                                    sw_municipio sm,
                                    sw_uf su
                                WHERE
                                    sm.cod_uf = cgm.cod_uf                     AND
                                    cgm.cod_uf = su.cod_uf                     AND
                                    cgm.cod_municipio = sm.cod_municipio       AND
                                    cgm.numcgm = inInscricao ;
                                    
                            ELSIF ( inDados = 6 ) THEN
                                SELECT
                                    coalesce(cgm.numero, \' \')
                                INTO
                                    stRetorno
                                FROM                                                                   
                                    sw_cgm cgm
                                WHERE                                                                  
                                    cgm.numcgm = inInscricao ;                    
                            END IF;
                        END IF;
                
                    RETURN stRetorno;
                END;
                $function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_busca_origem_lancamento(integer, integer, integer, integer)
                     RETURNS character varying
                     LANGUAGE plpgsql
                    AS $function$
                    DECLARE
                        inCodLancamento    	ALIAS FOR $1;
                        inExercicio         ALIAS FOR $2;
                        inTipoGrupo         ALIAS FOR $3;
                        inTipoCredito       ALIAS FOR $4;
                        stOrigem            VARCHAR := \'\'\'\';
                        stGrupo             VARCHAR := \'\'\'\';
                    BEGIN
                                
                    -- TIPO GRUPO:
                        -- caso esteja com valor 0, mostra codigo do grupo / grupo_descricao
                        -- caso esteja com valor 1, mostra codigo do grupo / ano exercicio
                        -- caso valor = 2, mostra cod_grupo, cod_modulo , descricao e ano_exercicio
                    
                    -- TIPO CREDITO:
                        -- caso esteja com valor 0, mostra codigo do credito - cod_especie - cod_genero - cod_natureza - descricao
                        -- caso esteja com valor 1, mostra apenas descricao_credito
                        
                    
                        SELECT
                            (   CASE WHEN al.divida = true THEN
                                    \'DA\'
                                ELSE
                                    CASE WHEN acgc.cod_grupo IS NOT NULL THEN
                                        CASE WHEN inTipoGrupo = 1 THEN
                                            agc.descricao ||\' / \'|| acgc.ano_exercicio
                                        ELSE
                                            CASE WHEN inTipoGrupo = 2 THEN
                                                \'§\'|| acgc.cod_grupo ||\'§\'|| agc.descricao ||\'§\'|| acgc.ano_exercicio ||\'§§\'|| agc.cod_modulo
                                            ELSE
                                                CASE WHEN inTipoGrupo = 3 THEN
                                                    to_char(mc.cod_credito,\'FM999099\')||\'.\'|| to_char(mc.cod_especie,\'FM999099\')||\'.\'|| to_char(mc.cod_genero,\'FM999099\')||\'.    \'|| mc.cod_natureza||\' - \'|| mc.descricao_credito||\' \'|| acgc.cod_grupo ||\' / \'|| acgc.ano_exercicio ||\' - \'|| agc.descricao
                                                ELSE
                                                    acgc.cod_grupo ||\' § \'|| agc.descricao
                                                END
                                            END
                                        END
                                    ELSE
                                        CASE WHEN inTipoCredito = 1 THEN
                                            mc.descricao_credito ||\' / \'|| ac.exercicio
                                        ELSE
                                            CASE WHEN inTipoGrupo = 2 THEN
                                                mc.cod_credito ||\'§§\'|| mc.descricao_credito ||\'§\'|| ac.exercicio ||\'§§\'|| mc.cod_especie ||\'§\'|| mc.cod_genero ||\'§\'|| mc.cod_natureza
                                            ELSE
                                                to_char(mc.cod_credito,\'FM999099\')||\'.\'|| to_char(mc.cod_especie,\'FM999099\')||\'.\'|| to_char(mc.cod_genero,\'FM999099\')||\'.    \'|| mc.cod_natureza||\' - \'|| mc.descricao_credito
                                            END
                                        END
                                    END
                                END
                            )::varchar
                        INTO 
                            stOrigem
                        FROM
                            arrecadacao.lancamento as al
                    
                            INNER JOIN (
                                SELECT
                                    cod_lancamento
                                    , max(cod_calculo) as cod_calculo
                                FROM arrecadacao.lancamento_calculo
                                GROUP BY
                                    cod_lancamento
                            ) as alc
                            ON alc.cod_lancamento = al.cod_lancamento
                    
                            INNER JOIN arrecadacao.calculo as ac
                            ON ac.cod_calculo = alc.cod_calculo
                            
                            LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
                            ON acgc.cod_calculo = ac.cod_calculo
                            AND acgc.ano_exercicio = ac.exercicio
                    
                            LEFT JOIN arrecadacao.grupo_credito as agc
                            ON agc.cod_grupo = acgc.cod_grupo
                            AND agc.ano_exercicio = acgc.ano_exercicio
                    
                            LEFT JOIN monetario.credito as mc
                            ON mc.cod_credito = ac.cod_credito
                            AND mc.cod_especie = ac.cod_especie
                            AND mc.cod_genero = ac.cod_genero
                            AND mc.cod_natureza = ac.cod_natureza
                            
                        WHERE
                            al.cod_lancamento = inCodLancamento
                            and ac.exercicio = quote_literal(inExercicio);
                    
                    
                        IF ( stOrigem = \'DA\' ) THEN
                            SELECT DISTINCT
                                \'§§DA - \'||  dp.numero_parcelamento  ||\'§\'|| ddp.exercicio
                            INTO
                                stOrigem
                            FROM
                                divida.parcelamento as dp
                                INNER JOIN divida.divida_parcelamento as ddp
                                ON ddp.num_parcelamento = dp.num_parcelamento
                                INNER JOIN divida.parcela as dpar
                                ON dpar.num_parcelamento = dp.num_parcelamento
                                INNER JOIN divida.parcela_calculo as dpc
                                ON dpc.num_parcelamento = dpar.num_parcelamento
                                AND dpc.num_parcela = dpar.num_parcela
                                INNER JOIN arrecadacao.lancamento_calculo as alc
                                ON alc.cod_calculo = dpc.cod_calculo
                            WHERE
                                alc.cod_lancamento = inCodLancamento;
                        END IF;
                    
                    
                        return stOrigem;
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
    }
}
