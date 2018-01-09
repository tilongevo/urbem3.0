<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170704150940 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.buscacgmlancamento(integer)
                         RETURNS integer
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            inCodLancamento ALIAS FOR $1;   
                            inCgm           integer;
                            inCalculo       integer;
                            stCgm           varchar;
                            stNome          varchar;
                        
                        BEGIN
                        
                            SELECT
                                max(cod_calculo)             
                            INTO
                                inCalculo
                            FROM 
                                arrecadacao.lancamento_calculo
                            WHERE 
                                cod_lancamento = inCodLancamento; 
                        
                            SELECT 
                                max(numcgm)
                            INTO 
                                inCgm
                            FROM 
                                arrecadacao.calculo_cgm 
                            WHERE 
                                cod_calculo = inCalculo;
                            
                            return inCgm;
                         
                        END;
                        $function$;
                        ');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.buscacontribuintelancamento(integer)
                         RETURNS character varying
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            inCodLancamento ALIAS FOR $1;   
                            inCgm           integer;
                            stNome          VARCHAR;
                            inCalculo       integer;
                        BEGIN
                        
                            SELECT
                                max(cod_calculo)             
                            INTO
                                inCalculo
                            FROM 
                                arrecadacao.lancamento_calculo
                            WHERE 
                                cod_lancamento = inCodLancamento; 
                        
                            SELECT 
                                max(numcgm)
                            INTO 
                                inCgm
                            FROM 
                                arrecadacao.calculo_cgm 
                            WHERE 
                                cod_calculo = inCalculo;
                            
                            select
                                nom_cgm
                            into    
                                stNome
                            from 
                                sw_cgm
                            where numcgm = inCgm;   
                          
                            return stNome; 
                        END;
                        $function$;
                        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_consulta_endereco_imovel(integer)
                         RETURNS character varying
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            inImovel    ALIAS FOR $1;
                            stRetorno   VARCHAR;
                            
                        BEGIN
                            SELECT                     
                                coalesce(tl.nom_tipo,\' \')         ||\' \'||                                                    
                                coalesce(nl.nom_logradouro,\' \')   ||\' \'||
                                coalesce(ltrim(i.numero::varchar,\'0\'),\' \') ||\' \'||
                                coalesce(i.complemento,\' \')  
                            INTO
                                stRetorno
                            FROM                                                                   
                                (   SELECT * FROM
                                    imobiliario.imovel
                                    WHERE inscricao_municipal = inImovel
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
                                i.inscricao_municipal   = inImovel
                            ;
                        
                            RETURN stRetorno;
                        END;
                        $function$;
                        ');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_consulta_endereco_empresa(integer)
                         RETURNS character varying
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            inIE        ALIAS FOR $1;
                            stTipo      VARCHAR;
                            inImovel    integer;
                            stRetorno   VARCHAR;
                            
                        BEGIN
                                -- pega tipo do ultimo domicilio
                                SELECT tipo 
                                  INTO stTipo
                                  FROM (   select inscricao_economica
                                                , timestamp
                                                , \'informado\' as tipo 
                                             from economico.domicilio_informado 
                                            where inscricao_economica = inIE
                                     union select inscricao_economica
                                                , timestamp
                                                , \'fiscal\' as tipo 
                                             from economico.domicilio_fiscal 
                                            where inscricao_economica = inIE
                                         order by timestamp desc limit 1
                                    ) as res;
                        
                            if stTipo = \'fiscal\' then
                                SELECT inscricao_municipal INTO inImovel FROM economico.domicilio_fiscal where inscricao_economica=inIE ORDER BY timestamp DESC LIMIT 1;
                                stRetorno := arrecadacao.fn_consulta_endereco_imovel(inImovel);
                                if stRetorno is null then
                                    stRetorno := \'Endereço Inválido!\';
                                end if;
                            elsif stTipo = \'informado\' then    
                                SELECT                     
                                    coalesce(tl.nom_tipo,\' \')         ||\' \'||                                                    
                                    coalesce(nl.nom_logradouro,\' \')   ||\' \'||
                                    coalesce(di.numero,\' \')   ||\' \'||
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
                                    di.inscricao_economica = inIE
                                ORDER BY di.timestamp DESC limit 1
                                ;
                            else
                                stRetorno := \'Não Encontrado\';     
                            end if;
                        
                            RETURN stRetorno;
                        END;
                        $function$;
                        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP FUNCTION arrecadacao.buscacgmlancamento(integer)');
        $this->addSql('DROP FUNCTION arrecadacao.buscacontribuintelancamento(integer)');
        $this->addSql('DROP FUNCTION arrecadacao.fn_consulta_endereco_imovel(integer)');
        $this->addSql('DROP FUNCTION arrecadacao.fn_consulta_endereco_empresa(integer)');
    }
}
