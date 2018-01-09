<?php

namespace Application\Migrations;

use PDO;
use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Divida\DividaEstorno;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Divida\Parcelamento;
use Urbem\CoreBundle\Entity\Divida\ParcelamentoCancelamento;
use Urbem\CoreBundle\Helper\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170901194442 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $triggerExists = $this->connection->query('SELECT 1 FROM pg_trigger WHERE tgname = \'tr_atualiza_ultima_modalidade_divida\'')->fetch(PDO::FETCH_COLUMN, 0);

        if ($triggerExists) {
            $this->addSql("DROP TRIGGER IF EXISTS tr_atualiza_ultima_modalidade_divida ON divida.modalidade_vigencia;");
        }

        $this->changeColumnToDateTimeMicrosecondType(EmissaoDocumento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Parcelamento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Parcelamento::class, 'timestamp_modalidade');
        $this->changeColumnToDateTimeMicrosecondType(ParcelamentoCancelamento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(DividaEstorno::class, 'timestamp');

        if ($triggerExists) {
            $this->addSql("CREATE TRIGGER tr_atualiza_ultima_modalidade_divida
                BEFORE INSERT OR UPDATE ON divida.modalidade_vigencia
                FOR EACH ROW
                EXECUTE PROCEDURE divida.fn_atualiza_ultima_modalidade_divida();");
        }

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_divida_ativa_emitir_documento_filtro', 'Emitir Documentos - Filtro', 'tributario_divida_ativa_emissao_documento_home');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_divida_ativa_emitir_documento_create', 'Emitir Documentos', 'urbem_tributario_divida_ativa_emitir_documento_filtro');");

        $this->addSql("
            CREATE OR REPLACE FUNCTION lista_cobranca_por_documento(integer,integer,integer) returns varchar as $$
            DECLARE
                inNumDocumento          ALIAS FOR $1;
                inCodDocumento          ALIAS FOR $2;
                inCodTipoDocumento      ALIAS FOR $3;
                stSqlFuncoes            VARCHAR;
                stExecuta               VARCHAR;
                stRetorno               VARCHAR := '';
                reRecordFuncoes         RECORD;

            BEGIN
                stSqlFuncoes := '
                    SELECT DISTINCT
                        PARCELAMENTO.numero_parcelamento,
                        PARCELAMENTO.exercicio

                    FROM
                        DIVIDA.PARCELAMENTO

                    INNER JOIN
                        (
                            SELECT
                                tmp.*
                            FROM
                                DIVIDA.EMISSAO_DOCUMENTO AS tmp
                            INNER JOIN
                                (
                                    SELECT
                                        MAX(num_emissao) AS num_emissao,
                                        cod_documento,
                                        cod_tipo_documento,
                                        num_documento
                                    FROM
                                        DIVIDA.EMISSAO_DOCUMENTO
                                    GROUP BY
                                        cod_documento,
                                        cod_tipo_documento,
                                        num_documento
                                )AS tmp2
                            ON
                                tmp.cod_documento = tmp2.cod_documento
                                AND tmp.cod_tipo_documento = tmp2.cod_tipo_documento
                                AND tmp.num_documento = tmp2.num_documento
                                AND tmp.num_emissao = tmp2.num_emissao
                        )AS EMISSAO_DOCUMENTO
                    ON
                        EMISSAO_DOCUMENTO.num_parcelamento = PARCELAMENTO.num_parcelamento

                    WHERE
                        PARCELAMENTO.numero_parcelamento != -1
                        AND PARCELAMENTO.exercicio::INTEGER != -1
                        AND EMISSAO_DOCUMENTO.cod_documento = '||inCodDocumento||'
                        AND EMISSAO_DOCUMENTO.cod_tipo_documento = '||inCodTipoDocumento||'
                        AND EMISSAO_DOCUMENTO.num_documento = '||inNumDocumento||'
                ';

                FOR reRecordFuncoes IN EXECUTE stSqlFuncoes LOOP
                    stRetorno := stRetorno || reRecordFuncoes.numero_parcelamento || '/' || reRecordFuncoes.exercicio::varchar || '<br>';
                END LOOP;

                return stRetorno;
            end;
            $$ language 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION lista_inscricao_por_documento(integer,integer,integer,char(4)) returns varchar as $$
            DECLARE
                inNumDocumento          ALIAS FOR $1;
                inCodDocumento          ALIAS FOR $2;
                inCodTipoDocumento      ALIAS FOR $3;
                chExercicioEmissao      ALIAS FOR $4;
                stSqlFuncoes            VARCHAR;
                stExecuta               VARCHAR;
                stRetorno               VARCHAR := '';
                reRecordFuncoes         RECORD;

            BEGIN
                stSqlFuncoes := '
                    SELECT DISTINCT
                        DIVIDA_PARCELAMENTO.cod_inscricao,
                        DIVIDA_PARCELAMENTO.exercicio

                    FROM
                        DIVIDA.DIVIDA_PARCELAMENTO

                    INNER JOIN
                        (
                            SELECT
                                tmp.*
                            FROM
                                DIVIDA.EMISSAO_DOCUMENTO AS tmp
                            INNER JOIN
                                (
                                    SELECT
                                        MAX(num_emissao) AS num_emissao,
                                        cod_documento,
                                        cod_tipo_documento,
                                        num_documento
                                    FROM
                                        DIVIDA.EMISSAO_DOCUMENTO
                                    GROUP BY
                                        cod_documento,
                                        cod_tipo_documento,
                                        num_documento
                                )AS tmp2
                            ON
                                tmp.cod_documento = tmp2.cod_documento
                                AND tmp.cod_tipo_documento = tmp2.cod_tipo_documento
                                AND tmp.num_documento = tmp2.num_documento
                                AND tmp.num_emissao = tmp2.num_emissao
                        )AS EMISSAO_DOCUMENTO
                    ON
                        EMISSAO_DOCUMENTO.num_parcelamento = DIVIDA_PARCELAMENTO.num_parcelamento

                    WHERE
                        EMISSAO_DOCUMENTO.cod_documento = '||inCodDocumento||'
                        AND EMISSAO_DOCUMENTO.cod_tipo_documento = '||inCodTipoDocumento||'
                        AND EMISSAO_DOCUMENTO.num_documento = '||inNumDocumento||'
                        AND EMISSAO_DOCUMENTO.exercicio = '|| quote_literal(chExercicioEmissao) ||'

                ';

                FOR reRecordFuncoes IN EXECUTE stSqlFuncoes LOOP
                    stRetorno := stRetorno || reRecordFuncoes.cod_inscricao || '/' || reRecordFuncoes.exercicio || '<br>';
                END LOOP;

                return stRetorno;
            end;
            $$ language 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION imobiliario.fn_busca_endereco_imovel( INTEGER )  RETURNS varchar AS '
            DECLARE
                inImovel    ALIAS FOR $1;
                stRetorno   VARCHAR;
                stSql       VARCHAR;
                reRecord                record;

            BEGIN

                stSql := ''

                    SELECT

                        COALESCE( tl.nom_tipo::varchar, '''' '''' ) as nom_tipo_logradouro
                        , COALESCE( t.cod_logradouro::varchar, '''' '''' ) as cod_logradouro
                        , COALESCE( nl.nom_logradouro::varchar, '''' '''' ) as logradouro
                        , COALESCE( i.numero::varchar, '''' '''' ) as numero
                        , COALESCE( i.complemento::varchar, '''' '''' ) as complemento
                        , COALESCE( bairro.nom_bairro::varchar, '''' '''' ) as bairro
                        , COALESCE( i.cep::varchar, '''' '''' ) as cep
                        , COALESCE( uf.cod_uf::varchar, '''' '''' ) as cod_uf
                        , COALESCE( uf.sigla_uf::varchar, '''' '''' ) as sigla_uf
                        , COALESCE( mun.cod_municipio::varchar, '''' '''' ) as cod_municipio
                        , COALESCE( mun.nom_municipio::varchar, '''' '''' ) as municipio

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
                        i.inscricao_municipal   = ''|| inImovel
                ;

                FOR reRecord IN EXECUTE stSql LOOP
                    stRetorno := reRecord.nom_tipo_logradouro;
                    stRetorno := stRetorno||''§''||reRecord.cod_logradouro;
                    stRetorno := stRetorno||''§''||reRecord.logradouro;
                    stRetorno := stRetorno||''§''||reRecord.numero;
                    stRetorno := stRetorno||''§''||reRecord.complemento;
                    stRetorno := stRetorno||''§''||reRecord.bairro;
                    stRetorno := stRetorno||''§''||reRecord.cep;
                    stRetorno := stRetorno||''§''||reRecord.cod_municipio;
                    stRetorno := stRetorno||''§''||reRecord.municipio;
                    stRetorno := stRetorno||''§''||reRecord.cod_uf;
                    stRetorno := stRetorno||''§''||reRecord.sigla_uf;
                END LOOP;

                RETURN stRetorno;

            END;
            ' LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION economico.fn_busca_domicilio_fiscal( INTEGER )  RETURNS varchar AS '
            DECLARE
                inInscricaoEconomica    ALIAS FOR $1;
                stRetorno   VARCHAR;
                reRecord                record;
                stSql                   VARCHAR;

            BEGIN

            stSql = ''
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
                    edf.inscricao_economica   = ''|| inInscricaoEconomica ||''

                order by edf.timestamp desc limit 1

                '';

                FOR reRecord IN EXECUTE stSql LOOP
                    stRetorno := reRecord.nom_tipo_logradouro;
                    stRetorno := stRetorno||''§''||reRecord.cod_logradouro;
                    stRetorno := stRetorno||''§''||reRecord.logradouro;
                    stRetorno := stRetorno||''§''||reRecord.numero;
                    stRetorno := stRetorno||''§''||reRecord.complemento;
                    stRetorno := stRetorno||''§''||reRecord.bairro;
                    stRetorno := stRetorno||''§''||reRecord.cep;
                    stRetorno := stRetorno||''§''||reRecord.cod_municipio;
                    stRetorno := stRetorno||''§''||reRecord.municipio;
                    stRetorno := stRetorno||''§''||reRecord.cod_uf;
                    stRetorno := stRetorno||''§''||reRecord.sigla_uf;
                END LOOP;

                RETURN stRetorno;
            END;
            ' LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION economico.fn_busca_domicilio_informado( INTEGER )  RETURNS varchar AS '
            DECLARE
                inInscricaoEconomica    ALIAS FOR $1;
                stRetorno               VARCHAR;
                reRecord                record;
                stSql                   VARCHAR;

            BEGIN

            stSql = ''
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

                where edi.inscricao_economica = ''||inInscricaoEconomica||''

                order by edi.timestamp desc limit 1

                '';

                FOR reRecord IN EXECUTE stSql LOOP
                    stRetorno := reRecord.nom_tipo_logradouro;
                    stRetorno := stRetorno||''§''||reRecord.cod_logradouro;
                    stRetorno := stRetorno||''§''||reRecord.logradouro;
                    stRetorno := stRetorno||''§''||reRecord.numero;
                    stRetorno := stRetorno||''§''||reRecord.complemento;
                    stRetorno := stRetorno||''§''||reRecord.bairro;
                    stRetorno := stRetorno||''§''||reRecord.cep;
                    stRetorno := stRetorno||''§''||reRecord.cod_municipio;
                    stRetorno := stRetorno||''§''||reRecord.municipio;
                    stRetorno := stRetorno||''§''||reRecord.cod_uf;
                    stRetorno := stRetorno||''§''||reRecord.sigla_uf;
                END LOOP;

                RETURN stRetorno;
            END;
            ' LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.fn_consulta_endereco_todos( INTEGER, INTEGER, INTEGER )  RETURNS varchar AS $$
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
                            coalesce(tl.nom_tipo,' ')         ||' '||
                            coalesce(nl.nom_logradouro,' ')   ||' '||
                            coalesce(ltrim(i.numero)::varchar,' ')   ||' '||
                            coalesce(i.complemento,' ')
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
                            coalesce(sb.nom_bairro, ' ')
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
                            coalesce(imovel.cep, ' ')
                        INTO
                            stRetorno
                        FROM
                            imobiliario.imovel
                        WHERE
                            inscricao_municipal = inInscricao;
                    ELSIF ( inDados = 4 ) THEN
                        SELECT
                            coalesce(sm.nom_municipio, ' ')||' - '||
                            coalesce(su.nom_uf, ' ')
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
                                    tmp_il.codigo_composto = tmp_iln.valor || '.00'
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
                            coalesce(imovel.numero, ' ')
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
                                                , 'informado' as tipo
                                            from economico.domicilio_informado
                                            where inscricao_economica = inInscricao
                                    union select inscricao_economica
                                                , timestamp
                                                , 'fiscal' as tipo
                                            from economico.domicilio_fiscal
                                            where inscricao_economica = inInscricao
                                        order by timestamp desc limit 1
                                    ) as res;

                            if stTipo = 'fiscal' then
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
                                                tmp_il.codigo_composto = tmp_iln.valor || '.00'
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
                                        stRetorno := 'Endereço Inválido!';
                                    end if;
                                END IF;
                            elsif stTipo = 'informado' then
                                IF ( inDados = 1 ) THEN
                                    SELECT
                                        coalesce(tl.nom_tipo,' ')         ||' '||
                                        coalesce(nl.nom_logradouro,' ')   ||' '||
                                        coalesce(ltrim(di.numero,'0'),' ')  ||' '||
                                        coalesce(di.complemento,' ')
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
                                        coalesce(sb.nom_bairro, ' ')
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
                                        coalesce(di.cep, ' ')
                                    INTO
                                        stRetorno
                                    FROM
                                        economico.domicilio_informado di
                                    WHERE
                                        di.inscricao_economica  = inInscricao
                                    ORDER BY di.timestamp DESC limit 1;
                                ELSIF ( inDados = 4 ) THEN
                                    SELECT
                                        coalesce(sm.nom_municipio, ' ')||' - '||coalesce(su.nom_uf, ' ')
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
                                        coalesce(di.numero, ' ')
                                    INTO
                                        stRetorno
                                    FROM
                                        economico.domicilio_informado di
                                    WHERE
                                        di.inscricao_economica  = inInscricao
                                    ORDER BY di.timestamp DESC limit 1;

                                END IF;
                            else
                                stRetorno := 'Não Encontrado';
                            end if;
                    ELSIF ( inTipo = 3 ) THEN --cgm
                        IF ( inDados = 1 ) THEN
                            SELECT
                                coalesce(cgm.tipo_logradouro, ' ')    ||' '||
                                coalesce(cgm.logradouro, ' ')         ||' '||
                                coalesce(ltrim(cgm.numero, '0' ), ' ')  ||' '||
                                coalesce(cgm.complemento, ' ')
                            INTO
                                stRetorno
                            FROM
                                sw_cgm cgm
                            WHERE
                                cgm.numcgm = inInscricao ;
                        ELSIF ( inDados = 2 ) THEN
                            SELECT
                                coalesce(cgm.bairro, ' ')
                            INTO
                                stRetorno
                            FROM
                                sw_cgm cgm
                            WHERE
                                cgm.numcgm = inInscricao ;
                        ELSIF ( inDados = 3 ) THEN
                            SELECT
                                coalesce(cgm.cep, ' ')
                            INTO
                                stRetorno
                            FROM
                                sw_cgm cgm
                            WHERE
                                cgm.numcgm = inInscricao ;
                        ELSIF ( inDados = 4 ) THEN
                            SELECT
                                coalesce(sm.nom_municipio, ' ')||' - '||coalesce(su.nom_uf, ' ')
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
                                coalesce(cgm.numero, ' ')
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
            $$ LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.fn_busca_origem_lancamento( integer, integer, integer, integer ) RETURNS VARCHAR AS $$
            DECLARE
                inCodLancamento     ALIAS FOR $1;
                inExercicio         ALIAS FOR $2;
                inTipoGrupo         ALIAS FOR $3;
                inTipoCredito       ALIAS FOR $4;
                stOrigem            VARCHAR := '''';
                stGrupo             VARCHAR := '''';
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
                            'DA'
                        ELSE
                            CASE WHEN acgc.cod_grupo IS NOT NULL THEN
                                CASE WHEN inTipoGrupo = 1 THEN
                                    agc.descricao ||' / '|| acgc.ano_exercicio
                                ELSE
                                    CASE WHEN inTipoGrupo = 2 THEN
                                        '§'|| acgc.cod_grupo ||'§'|| agc.descricao ||'§'|| acgc.ano_exercicio ||'§§'|| agc.cod_modulo
                                    ELSE
                                        CASE WHEN inTipoGrupo = 3 THEN
                                            to_char(mc.cod_credito,'FM999099')||'.'|| to_char(mc.cod_especie,'FM999099')||'.'|| to_char(mc.cod_genero,'FM999099')||'.    '|| mc.cod_natureza||' - '|| mc.descricao_credito||' '|| acgc.cod_grupo ||' / '|| acgc.ano_exercicio ||' - '|| agc.descricao
                                        ELSE
                                            acgc.cod_grupo ||' § '|| agc.descricao
                                        END
                                    END
                                END
                            ELSE
                                CASE WHEN inTipoCredito = 1 THEN
                                    mc.descricao_credito ||' / '|| ac.exercicio
                                ELSE
                                    CASE WHEN inTipoGrupo = 2 THEN
                                        mc.cod_credito ||'§§'|| mc.descricao_credito ||'§'|| ac.exercicio ||'§§'|| mc.cod_especie ||'§'|| mc.cod_genero ||'§'|| mc.cod_natureza
                                    ELSE
                                        to_char(mc.cod_credito,'FM999099')||'.'|| to_char(mc.cod_especie,'FM999099')||'.'|| to_char(mc.cod_genero,'FM999099')||'.    '|| mc.cod_natureza||' - '|| mc.descricao_credito
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


                IF ( stOrigem = 'DA' ) THEN
                    SELECT DISTINCT
                        '§§DA - '||  dp.numero_parcelamento  ||'§'|| ddp.exercicio
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
            $$ LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.fn_busca_origem_inscricao_divida_ativa( integer, integer, integer ) RETURNS VARCHAR AS $$
            declare
                inCodInscricao      ALIAS FOR $1;
                inExercicio         ALIAS FOR $2;
                inTipo              ALIAS FOR $3;
                stOrigem            VARCHAR := '';
                stSQL2              VARCHAR;
                stSQL1              VARCHAR;
                reRecordExecuta     RECORD;
                reRecordExecuta2    RECORD;

            begin

            -- TIPO :
                -- caso esteja com valor 0, mostra codigo do grupo / grupo_descricao
                -- caso esteja com valor 1, mostra codigo do grupo / ano exercicio
                -- caso valor = 2, mostra cod_grupo, cod_modulo , descricao e ano_exercicio

                stSQL2 := '
                    SELECT DISTINCT
                        (
                            CASE WHEN lancamento.divida = true THEN
                                ''DA''
                            ELSE
                                CASE WHEN acgc.cod_grupo IS NOT NULL THEN
                                    CASE WHEN ( '|| inTipo ||' = 1 OR '|| inTipo ||' = 4 )  THEN
                                        agc.descricao||'' / ''|| acgc.ano_exercicio
                                    ELSE
                                        CASE WHEN '|| inTipo ||' = 2 THEN
                                            ''§''|| acgc.cod_grupo||''§''|| agc.descricao||''§''|| acgc.ano_exercicio||''§§''|| agc.cod_modulo
                                        ELSE
                                            CASE WHEN '|| inTipo ||' = 6 THEN
                                                acgc.cod_grupo||'' / ''|| acgc.ano_exercicio||'' - ''|| agc.descricao
                                            ELSE
                                                acgc.cod_grupo||'' § ''|| agc.descricao
                                            END
                                        END
                                    END
                                ELSE
                                    CASE WHEN ( '|| inTipo ||' = 1 OR '|| inTipo ||' = 4 )  THEN
                                        mc.descricao_credito||'' / ''|| ac.exercicio
                                    ELSE
                                        CASE WHEN '|| inTipo ||' = 2 THEN
                                            mc.cod_credito||''§§''|| mc.descricao_credito||''§''|| ac.exercicio||''§§''|| mc.cod_especie||''§''|| mc.cod_genero||''§''|| mc.cod_natureza
                                        ELSE
                                            to_char(mc.cod_credito,''FM999099'')||''.''|| to_char(mc.cod_especie,''FM999099'')||''.''|| to_char(mc.cod_genero,''FM999099'')||''.''|| mc.cod_natureza||'' - ''|| mc.descricao_credito||'' ''|| ac.exercicio
                                        END
                                    END
                                END
                            END
                        )::varchar AS stOrigem,
                        CASE WHEN acgc.cod_grupo IS NOT NULL THEN
                            1
                        ELSE
                            0
                        END::integer AS inEhGrupo

                    FROM
                        divida.divida_parcelamento

                    INNER JOIN
                        (
                            --validar cobranca
                            SELECT
                                min( divida_parcelamento.num_parcelamento ) AS num_parcelamento,
                                divida_parcelamento.cod_inscricao,
                                divida_parcelamento.exercicio

                            FROM
                                divida.divida_parcelamento

                            LEFT JOIN
                                divida.parcela
                            ON
                                parcela.num_parcelamento = divida_parcelamento.num_parcelamento

                            WHERE
                                CASE WHEN parcela.num_parcelamento IS NOT NULL THEN
                                    CASE WHEN (
                                        SELECT
                                            t.num_parcelamento
                                        FROM
                                            divida.parcela AS t
                                        WHERE
                                            t.num_parcelamento = divida_parcelamento.num_parcelamento
                                            AND t.cancelada = true
                                        LIMIT 1
                                    ) IS NULL THEN
                                        true
                                    ELSE
                                        false
                                    END
                                ELSE
                                    true
                                END

                            GROUP BY
                                divida_parcelamento.cod_inscricao,
                                divida_parcelamento.exercicio
                        )AS parcelamento
                    ON
                        parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento
                        AND parcelamento.cod_inscricao = divida_parcelamento.cod_inscricao
                        AND parcelamento.exercicio = divida_parcelamento.exercicio

                    INNER JOIN
                        divida.parcela_origem
                    ON
                        parcela_origem.num_parcelamento = divida_parcelamento.num_parcelamento

                    INNER JOIN
                        arrecadacao.parcela
                    ON
                        parcela.cod_parcela = parcela_origem.cod_parcela

                    INNER JOIN
                        arrecadacao.lancamento_calculo
                    ON
                        lancamento_calculo.cod_lancamento = parcela.cod_lancamento

                    INNER JOIN
                        arrecadacao.lancamento
                    ON
                        lancamento.cod_lancamento = lancamento_calculo.cod_lancamento

                    INNER JOIN
                        arrecadacao.calculo AS ac
                    ON
                        ac.cod_calculo = lancamento_calculo.cod_calculo

                    INNER JOIN
                        monetario.credito as mc
                    ON
                        mc.cod_credito = ac.cod_credito
                        AND mc.cod_especie = ac.cod_especie
                        AND mc.cod_genero = ac.cod_genero
                        AND mc.cod_natureza = ac.cod_natureza

                    LEFT JOIN
                        arrecadacao.calculo_grupo_credito as acgc
                    ON
                        acgc.cod_calculo = ac.cod_calculo
                        AND acgc.ano_exercicio = ac.exercicio

                    LEFT JOIN
                        arrecadacao.grupo_credito as agc
                    ON
                        agc.cod_grupo = acgc.cod_grupo
                        AND agc.ano_exercicio = acgc.ano_exercicio

                    WHERE
                        divida_parcelamento.cod_inscricao = '|| inCodInscricao ||'
                        AND divida_parcelamento.exercicio = '''|| inExercicio ||'''
                ';

                FOR reRecordExecuta2 IN EXECUTE stSQL2 LOOP
                    IF ( reRecordExecuta2.stOrigem = 'DA' ) THEN
                        stSQL1 := '
                            SELECT DISTINCT
                                ''§§DA - ''||  ddp.cod_inscricao ||''§''|| ddp.exercicio AS origem

                            FROM
                                divida.parcelamento as dp

                            INNER JOIN
                                divida.divida_parcelamento as ddp
                            ON
                                ddp.num_parcelamento = dp.num_parcelamento

                            INNER JOIN
                                divida.parcela as dpar
                            ON
                                dpar.num_parcelamento = dp.num_parcelamento

                            INNER JOIN
                                divida.parcela_calculo as dpc
                            ON
                                dpc.num_parcelamento = dpar.num_parcelamento
                                AND dpc.num_parcela = dpar.num_parcela

                            INNER JOIN
                                arrecadacao.lancamento_calculo as alc
                            ON
                                alc.cod_calculo = dpc.cod_calculo

                            WHERE
                                alc.cod_lancamento in (
                                    SELECT DISTINCT
                                        parcela.cod_lancamento
                                    FROM
                                        divida.divida_parcelamento

                                    INNER JOIN
                                        divida.parcela_origem
                                    ON
                                        parcela_origem.num_parcelamento = divida_parcelamento.num_parcelamento

                                    INNER JOIN
                                        arrecadacao.parcela
                                    ON
                                        parcela.cod_parcela = parcela_origem.cod_parcela

                                    WHERE
                                        divida_parcelamento.cod_inscricao = '|| inCodInscricao ||'
                                        AND divida_parcelamento.exercicio = '''|| inExercicio ||'''
                                );
                        ';

                        FOR reRecordExecuta IN EXECUTE stSQL1 LOOP
                            stOrigem := reRecordExecuta.stOrigem ||'; '|| reRecordExecuta2.stOrigem ||'; '|| stOrigem;
                        END LOOP;
                    ELSEIF ( reRecordExecuta2.inEhGrupo = 1 ) THEN
                        stSQL1 := '
                            SELECT DISTINCT
                                CASE WHEN '|| inTipo ||' = 4 THEN
                                    credito.descricao_credito
                                ELSE
                                    to_char(credito.cod_credito,''FM999099'')||''.''|| to_char(credito.cod_especie,''FM999099'')||''.''|| to_char(credito.cod_genero,''FM999099'')||''.''|| credito.cod_natureza||'' - ''|| credito.descricao_credito
                                END AS cred_desc

                            FROM
                                divida.divida_parcelamento

                             INNER JOIN ( SELECT divida_parcelamento.cod_inscricao
                                               , divida_parcelamento.exercicio
                                               , max(divida_parcelamento.num_parcelamento) AS num_parcelamento
                                            FROM divida.divida_parcelamento
                           LEFT JOIN divida.parcelamento_cancelamento
                              ON divida_parcelamento.num_parcelamento = parcelamento_cancelamento.num_parcelamento
                               WHERE parcelamento_cancelamento.num_parcelamento IS NULL
                                        GROUP BY divida_parcelamento.cod_inscricao
                                               , divida_parcelamento.exercicio
                                        )AS parcelamento

                                     ON parcelamento.cod_inscricao = divida_parcelamento.cod_inscricao
                                    AND parcelamento.exercicio = divida_parcelamento.exercicio

                            INNER JOIN
                                divida.parcela_origem
                            ON
                                parcela_origem.num_parcelamento = divida_parcelamento.num_parcelamento

                            INNER JOIN
                                monetario.credito
                            ON
                                credito.cod_credito = parcela_origem.cod_credito
                                AND credito.cod_especie = parcela_origem.cod_especie
                                AND credito.cod_genero = parcela_origem.cod_genero
                                AND credito.cod_natureza = parcela_origem.cod_natureza

                            WHERE
                                divida_parcelamento.cod_inscricao = '|| inCodInscricao ||'
                                AND divida_parcelamento.exercicio = '''|| inExercicio ||'''';

                        FOR reRecordExecuta IN EXECUTE stSQL1 LOOP
                            IF ( stOrigem IS NOT NULL ) THEN
                                stOrigem := '; '|| stOrigem;
                            END IF;

                            IF ( inTipo = 4 ) THEN
                                stOrigem := reRecordExecuta.cred_desc ||' - '|| reRecordExecuta2.stOrigem;
                            ELSE
                                stOrigem := reRecordExecuta.cred_desc ||'; '|| reRecordExecuta2.stOrigem;
                            END IF;

                        END LOOP;
                    ELSE
                        stOrigem := reRecordExecuta2.stOrigem ||'; '|| stOrigem;
                    END IF;
                END LOOP;

                return stOrigem;

            end;
            $$ language 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION imobiliario.fn_busca_lote_imovel(INTEGER)  RETURNS INTEGER AS '
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
                        SELECT
                            il.inscricao_municipal
                            , il.cod_lote
                            , max( il.timestamp ) as timestamp
                        FROM imobiliario.imovel_lote il
                        WHERE il.inscricao_municipal = inIM
                        GROUP BY
                            il.inscricao_municipal, il.cod_lote
                    ) ilote
                    ON l.cod_lote = ilote.cod_lote

                    INNER JOIN imobiliario.imovel i
                    ON ilote.inscricao_municipal = i.inscricao_municipal

                    WHERE
                        i.inscricao_municipal = inIM
                );

                RETURN inResultado;
            END;
            ' LANGUAGE 'plpgsql';
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
