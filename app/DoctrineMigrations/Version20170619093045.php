<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170619093045 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION economico.fn_busca_domicilio_fiscal(integer)
                         RETURNS character varying
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            inInscricaoEconomica    ALIAS FOR $1;
                            stRetorno   VARCHAR;
                            reRecord        		record;
                            stSql 					VARCHAR;
                            
                        BEGIN                        
                            stSql = \'
                                SELECT                     
                                    tl.nom_tipo::varchar as nom_tipo_logradouro,
                                    t.cod_logradouro::varchar as cod_logradouro,
                                    nl.nom_logradouro::varchar as logradouro,
                                    i.numero::varchar as numero,
                                    i.complemento::varchar as complemento,
                                    bairro.nom_bairro::varchar as bairro,
                                    ( i.cep )::varchar as cep,
                                    uf.cod_uf::varchar as cod_uf,
                                    uf.sigla_uf::varchar as sigla_uf,
                                    mun.cod_municipio::varchar as cod_municipio,
                                    mun.nom_municipio::varchar as municipio
                                FROM
                                    economico.domicilio_fiscal as edf
                                    
                                    INNER JOIN imobiliario.imovel as i
                                    ON i.inscricao_municipal = edf.inscricao_municipal
                            
                                    INNER JOIN imobiliario.imovel_confrontacao ic
                                    ON ic.inscricao_municipal  = i.inscricao_municipal
                            
                                    INNER JOIN imobiliario.confrontacao_trecho ct
                                    ON ct.cod_confrontacao	= ic.cod_confrontacao AND
                                    ct.cod_lote             = ic.cod_lote
                            
                                    INNER JOIN imobiliario.trecho t
                                    ON t.cod_trecho		= ct.cod_trecho   	AND
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
                                    edf.inscricao_economica   = \'|| inInscricaoEconomica ||\'
                            
                                order by edf.timestamp desc limit 1
                            
                                \';
                            
                                FOR reRecord IN EXECUTE stSql LOOP
                                    stRetorno := reRecord.nom_tipo_logradouro;
                                    stRetorno := stRetorno||\'§\'||reRecord.cod_logradouro;
                                    stRetorno := stRetorno||\'§\'||reRecord.logradouro;
                                    stRetorno := stRetorno||\'§\'||reRecord.numero;
                                    stRetorno := stRetorno||\'§\'||reRecord.complemento;
                                    stRetorno := stRetorno||\'§\'||reRecord.bairro;
                                    stRetorno := stRetorno||\'§\'||reRecord.cep;
                                    stRetorno := stRetorno||\'§\'||reRecord.cod_municipio;
                                    stRetorno := stRetorno||\'§\'||reRecord.municipio;
                                    stRetorno := stRetorno||\'§\'||reRecord.cod_uf;
                                    stRetorno := stRetorno||\'§\'||reRecord.sigla_uf;
                                END LOOP;
                            
                                RETURN stRetorno; 
                        END;
                        $function$
                ');
        $this->addSql('CREATE OR REPLACE FUNCTION economico.fn_busca_domicilio_informado(integer)
                     RETURNS character varying
                     LANGUAGE plpgsql
                    AS $function$
                    DECLARE
                        inInscricaoEconomica    ALIAS FOR $1;
                        stRetorno   			VARCHAR;
                        reRecord        		record;
                        stSql 					VARCHAR;
                        
                    BEGIN
                    
                        stSql = \'
                            SELECT 
                                tl.nom_tipo::varchar as nom_tipo_logradouro,
                                logr.cod_logradouro::varchar as cod_logradouro,
                                logr.nom_logradouro::varchar as logradouro,
                                edi.numero::varchar as numero,
                                edi.complemento::varchar as complemento,
                                bairro.nom_bairro::varchar as bairro,
                                ( edi.cep )::varchar as cep,
                                uf.cod_uf::varchar as cod_uf,
                                uf.sigla_uf::varchar as sigla_uf,
                                mun.cod_municipio::varchar as cod_municipio,
                                mun.nom_municipio::varchar as municipio
                            FROM
                                economico.domicilio_informado as edi
                            
                                INNER JOIN sw_uf as uf
                                ON uf.cod_uf = edi.cod_uf
                            
                                INNER JOIN sw_municipio as mun
                                ON mun.cod_municipio = edi.cod_municipio
                                AND mun.cod_uf = edi.cod_uf
                            
                                INNER JOIN sw_bairro as bairro
                                ON bairro.cod_bairro = edi.cod_bairro
                                AND bairro.cod_municipio = edi.cod_municipio
                                AND bairro.cod_uf = edi.cod_uf
                            
                                INNER JOIN sw_nome_logradouro as logr
                                ON logr.cod_logradouro = edi.cod_logradouro
                            
                                INNER JOIN sw_tipo_logradouro as tl
                                ON tl.cod_tipo = logr.cod_tipo
                            
                                where edi.inscricao_economica = \'||inInscricaoEconomica||\'
                            
                                order by edi.timestamp desc limit 1
                                
                                \';
                            
                                FOR reRecord IN EXECUTE stSql LOOP
                                    stRetorno := reRecord.nom_tipo_logradouro;
                                    stRetorno := stRetorno||\'§\'||reRecord.cod_logradouro;
                                    stRetorno := stRetorno||\'§\'||reRecord.logradouro;
                                    stRetorno := stRetorno||\'§\'||reRecord.numero;
                                    stRetorno := stRetorno||\'§\'||reRecord.complemento;
                                    stRetorno := stRetorno||\'§\'||reRecord.bairro;
                                    stRetorno := stRetorno||\'§\'||reRecord.cep;
                                    stRetorno := stRetorno||\'§\'||reRecord.cod_municipio;
                                    stRetorno := stRetorno||\'§\'||reRecord.municipio;
                                    stRetorno := stRetorno||\'§\'||reRecord.cod_uf;
                                    stRetorno := stRetorno||\'§\'||reRecord.sigla_uf;
                                END LOOP;
                            
                            RETURN stRetorno; 
                    END;
                    $function$
            ');
        $this->addSql('CREATE OR REPLACE FUNCTION imobiliario.fn_busca_endereco_imovel(integer)
                     RETURNS character varying
                     LANGUAGE plpgsql
                    AS $function$
                    DECLARE
                        inImovel    ALIAS FOR $1;
                        stRetorno   VARCHAR;
                        stSql       VARCHAR;
                        reRecord                record;
                        
                    BEGIN
                    
                        stSql := \'
                    
                            SELECT
                    
                                COALESCE( tl.nom_tipo::varchar, \'\' \'\' ) as nom_tipo_logradouro
                                , COALESCE( t.cod_logradouro::varchar, \'\' \'\' ) as cod_logradouro
                                , COALESCE( nl.nom_logradouro::varchar, \'\' \'\' ) as logradouro
                                , COALESCE( i.numero::varchar, \'\' \'\' ) as numero
                                , COALESCE( i.complemento::varchar, \'\' \'\' ) as complemento
                                , COALESCE( bairro.nom_bairro::varchar, \'\' \'\' ) as bairro
                                , COALESCE( i.cep::varchar, \'\' \'\' ) as cep
                                , COALESCE( uf.cod_uf::varchar, \'\' \'\' ) as cod_uf
                                , COALESCE( uf.sigla_uf::varchar, \'\' \'\' ) as sigla_uf
                                , COALESCE( mun.cod_municipio::varchar, \'\' \'\' ) as cod_municipio
                                , COALESCE( mun.nom_municipio::varchar, \'\' \'\' ) as municipio
                    
                            FROM
                    
                                imobiliario.imovel as i
                    
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
                                i.inscricao_municipal   = \'|| inImovel
                        ;
                    
                        FOR reRecord IN EXECUTE stSql LOOP
                            stRetorno := reRecord.nom_tipo_logradouro;
                            stRetorno := stRetorno||\'§\'||reRecord.cod_logradouro;
                            stRetorno := stRetorno||\'§\'||reRecord.logradouro;
                            stRetorno := stRetorno||\'§\'||reRecord.numero;
                            stRetorno := stRetorno||\'§\'||reRecord.complemento;
                            stRetorno := stRetorno||\'§\'||reRecord.bairro;
                            stRetorno := stRetorno||\'§\'||reRecord.cep;
                            stRetorno := stRetorno||\'§\'||reRecord.cod_municipio;
                            stRetorno := stRetorno||\'§\'||reRecord.municipio;
                            stRetorno := stRetorno||\'§\'||reRecord.cod_uf;
                            stRetorno := stRetorno||\'§\'||reRecord.sigla_uf;
                        END LOOP;
                    
                        RETURN stRetorno;
                    
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
    }
}
