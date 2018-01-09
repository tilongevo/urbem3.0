<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170809205117 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_consultas_lote_list', 'Consulta de Lote', 'tributario_arrecadacao_consultas_home');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_consultas_lote_consultar', 'Consultar', 'urbem_tributario_arrecadacao_consultas_lote_list');");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.calculaProporcaoParcela(integer) RETURNS numeric as $$
            DECLARE
                inCodParcela        ALIAS FOR $1;
                inCodLancamento     INT;
                nuValorParcela      NUMERIC;
                nuValorLancamento   NUMERIC;
                nuRetorno           NUMERIC;
            BEGIN

                SELECT lancamento.cod_lancamento
                     , lancamento.valor
                     , CASE WHEN parcela_reemissao.cod_parcela IS NOT NULL THEN
                         parcela_reemissao.valor
                       ELSE
                         parcela.valor
                       END AS valor
                  INTO inCodLancamento
                     , nuValorLancamento
                     , nuValorParcela
                  FROM arrecadacao.parcela
             LEFT JOIN (  SELECT valor
                               , cod_parcela
                            FROM arrecadacao.parcela_reemissao
                           WHERE cod_parcela= inCodParcela
                        ORDER BY timestamp ASC LIMIT 1) AS parcela_reemissao
                    ON parcela.cod_parcela = parcela_reemissao.cod_parcela
            INNER JOIN arrecadacao.lancamento
                    ON lancamento.cod_lancamento = parcela.cod_lancamento
                 WHERE parcela.cod_parcela= inCodParcela;

                IF ( nuValorLancamento > 0 and nuValorParcela > 0 ) THEN
                    nuRetorno := ((nuValorParcela*100)/nuValorLancamento)/100;
                ELSE
                    nuRetorno := 0.00;
                END IF;

                return nuRetorno;
            END;
          $$ language 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.fn_busca_soma_pagamento_calculo(varchar,integer,integer) returns numeric as '
            declare
                stNumeracao             ALIAS FOR $1;
                inCodConvenio           ALIAS FOR $2;
                inOcorrenciaPagamento   ALIAS FOR $3;
                stSql                   VARCHAR;
                nuRetorno               NUMERIC := 0.00;
                reRecord                RECORD;
            begin

                SELECT
                    sum(valor)
                INTO
                    nuRetorno
                FROM
                    arrecadacao.pagamento_calculo as apagc
                WHERE
                    apagc.numeracao = stNumeracao
                    AND apagc.cod_convenio = inCodConvenio
                    AND apagc.ocorrencia_pagamento = inOcorrenciaPagamento
                ;

                IF ( nuRetorno < 0.00 ) THEN
                    nuRetorno := 0.00;
                END IF;

               return nuRetorno::numeric(14,2);
            end;
            'language 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.buscaContribuinteLancamento( INTEGER )  RETURNS VARCHAR AS '
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
            ' LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.fn_info_parcela (integer) returns VARCHAR AS '
            DECLARE
               inCodParcela         ALIAS FOR $1;
               stInfo               VARCHAR;
               inCodLancamento      integer;
            BEGIN
                    SELECT
                        case
                            when ap.nr_parcela = 0 then ''Única''::VARCHAR
                            else (ap.nr_parcela::varchar||''/''|| arrecadacao.fn_total_parcelas(ap.cod_lancamento))::varchar
                        end as info
                    INTO
                        stInfo
                    FROM
                        arrecadacao.parcela ap
                    WHERE
                        ap.cod_parcela= inCodParcela;
                return stInfo;
            END;
            ' LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.buscaInscricaoLancamento( inCodLancamento    INTEGER
                                                               )  RETURNS           INTEGER AS '
            DECLARE
                inInscricao     integer;
            BEGIN

                   SELECT CASE
                               WHEN imovel_calculo.inscricao_municipal             IS NOT NULL THEN
                                    imovel_calculo.inscricao_municipal
                               WHEN cadastro_economico_calculo.inscricao_economica IS NOT NULL THEN
                                    cadastro_economico_calculo.inscricao_economica
                          END AS inscricao
                     INTO inInscricao
                     FROM arrecadacao.lancamento_calculo
                LEFT JOIN arrecadacao.imovel_calculo
                       ON imovel_calculo.cod_calculo = lancamento_calculo.cod_calculo
                LEFT JOIN arrecadacao.cadastro_economico_calculo
                       ON cadastro_economico_calculo.cod_calculo = lancamento_calculo.cod_calculo
                    WHERE lancamento_calculo.cod_lancamento = inCodLancamento
                        ;

                RETURN inInscricao;
            END;
            ' LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.buscaVinculoLancamento( inCodLancamento  INTEGER
                                                             , inExercicio      INTEGER
                                                             ) RETURNS          VARCHAR AS $$
            DECLARE
                stDesc          varchar;
            BEGIN

                   SELECT COALESCE( calculo_grupo_credito.cod_grupo ||' / '|| calculo_grupo_credito.ano_exercicio ||' - '|| grupo_credito.descricao
                                  , credito.descricao_credito
                                  ) AS vinculo
                     INTO stDesc
                     FROM arrecadacao.calculo
                     JOIN arrecadacao.lancamento_calculo
                       ON lancamento_calculo.cod_calculo = calculo.cod_calculo
                LEFT JOIN arrecadacao.calculo_grupo_credito
                       ON calculo_grupo_credito.cod_calculo = calculo.cod_calculo
                LEFT JOIN arrecadacao.grupo_credito
                       ON grupo_credito.cod_grupo     = calculo_grupo_credito.cod_grupo
                      AND grupo_credito.ano_exercicio = calculo_grupo_credito.ano_exercicio
                     JOIN monetario.credito
                       ON credito.cod_credito  = calculo.cod_credito
                      AND credito.cod_especie  = calculo.cod_especie
                      AND credito.cod_genero   = calculo.cod_genero
                      AND credito.cod_natureza = calculo.cod_natureza
                    WHERE lancamento_calculo.cod_lancamento = inCodLancamento
                      AND calculo.exercicio                 = inExercicio::varchar
                        ;

                PERFORM 1
                   FROM arrecadacao.lancamento
                  WHERE cod_lancamento = inCodLancamento
                    AND divida         = TRUE
                      ;
                IF FOUND THEN
                    stDesc := 'D.A. '||stDesc;
                END IF;

                RETURN stDesc;
            END;
            $$ LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.fn_atualiza_data_vencimento( date ) returns date as $$
            DECLARE

                dataVencimento  ALIAS FOR $1;
                ano             integer := substring ( $1::varchar, 0, 5 );
                mes             integer := substring ( $1::varchar, 6, 2 );
                dia             integer := substring ( $1::varchar, 9, 2 );

                anoV            varchar;
                mesV            char(2);
                diaV            varchar;
                dataVarchar     varchar;

                diaSemana       integer;
                diaFev          integer;
                novoVencimento  date;

                stSql           varchar;

                stRetorno       date;
                reRecord        RECORD;

            begin

            stSql := '
                SELECT EXTRACT( DOW FROM DATE '''||dataVencimento||''' ) as valor
                ';

                FOR reRecord IN EXECUTE stSql LOOP
                    diaSemana := reRecord.valor;
                END LOOP;

                --verifica ano bissexto
                IF ( ( ano - 1980 ) % 4 = 0 ) THEN
                    diaFev := 29;
                ELSE
                    diaFev := 28;
                END IF;


                IF diaSemana = 6 THEN -- se for SÁBADO
                    IF (dia = 31) OR ( mes = 2 AND dia = diaFev ) OR  ( dia = 30 AND mes in ( 04, 06, 09, 11 ) )  THEN
                        dia := 2;
                        IF mes = 12 THEN
                            mes := 1;
                            ano := ano + 1;
                        ELSE
                            mes := mes + 1;
                        END IF;
                    ELSIF ( (dia = (diaFev-1)) AND mes = 2) OR (dia = 29 AND mes in (04, 06, 09, 11)) OR (dia = 30 AND mes in (01, 03, 05, 07, 08, 10, 12) ) THEN
                        dia := 1;
                        IF mes = 12 THEN
                            mes := 1;
                            ano := ano + 1;
                        ELSE
                            mes := mes + 1;
                        END IF;
                    ELSE
                        dia := dia + 2;
                    END IF;

                ELSIF diaSemana = 0 THEN --se for DOMINGO
                    IF (dia = 31) OR ( mes = 2 AND dia = diaFev ) OR ( dia = 30 AND mes in ( 04, 06, 09, 11 ) ) THEN
                        dia := 1;
                        IF mes = 12 THEN
                            mes := 1;
                            ano := ano + 1;
                        ELSE
                            mes := mes + 1;
                        END IF;
                    ELSE
                        dia := dia + 1;
                    END IF;
                END IF;

                anoV := to_char(ano,'0000');
                mesV := substring ( to_char(mes,'00'), 2, 2 );
                diaV := substring ( to_char(dia,'00'), 2, 2 );

                dataVarchar := anoV||'-'||mesV||'-'||diaV;

                --novoVencimento := to_date ( dataVarchar, ''YYYY-MM-DD'');

                return dataVarchar;
            end;
            $$ LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.fn_total_parcelas( INTEGER )  RETURNS INTEGER AS '
            DECLARE
                inCodLancamento ALIAS FOR $1;
                inRetorno       INTEGER;
            BEGIN
                SELECT
                    count(nr_parcela) as total_parcela
                INTO
                    inRetorno
                FROM
                    arrecadacao.parcela
                WHERE
                    cod_lancamento = inCodLancamento AND
                    nr_parcela > 0;

                RETURN inRetorno;
            END;
            ' LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.dtBaixaLote(integer,integer) returns date as '
            declare
                inCodLote       ALIAS FOR $1;
                inExercicio     ALIAS FOR $2;
                dtBaixa         date;
            begin
                         select pag.data_baixa
                           into dtBaixa
                           from arrecadacao.pagamento pag INNER JOIN
                              ( select * from arrecadacao.pagamento_lote where cod_lote = inCodLote limit 1) as plote
                              ON plote.numeracao = pag.numeracao
                            and plote.ocorrencia_pagamento = pag.ocorrencia_pagamento
                            and plote.cod_convenio = pag.cod_convenio
                            INNER JOIN ( select * from arrecadacao.lote where cod_lote = inCodLote limit 1) as lote
                            ON lote.cod_lote = plote.cod_lote
                            and lote.exercicio = plote.exercicio
                          where
                            lote.cod_lote=  inCodLote
                            and lote.exercicio= inExercicio::varchar
                          limit 1;

               return dtBaixa;
            end;
            'language 'plpgsql';
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
