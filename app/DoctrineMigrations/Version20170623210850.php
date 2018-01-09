<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Arrecadacao\Carne;
use Urbem\CoreBundle\Entity\Arrecadacao\Calculo;
use Urbem\CoreBundle\Entity\Divida\Parcelamento;
use Urbem\CoreBundle\Entity\Divida\ParcelamentoCancelamento;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170623210850 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('tributario_arrecadacao_baixa_debitos_home', 'Arrecadação - Baixa de Débitos', 'tributario');
        $this->insertRoute('urbem_tributario_arrecadacao_baixa_manual_debito_list', 'Baixa Manual de Débito', 'tributario_arrecadacao_baixa_debitos_home');
        $this->insertRoute('urbem_tributario_arrecadacao_baixa_manual_debito_edit', 'Dados para Baixa Manual de Débito', 'urbem_tributario_arrecadacao_baixa_manual_debito_list');
        $this->changeColumnToDateTimeMicrosecondType(Carne::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Parcelamento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Calculo::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ParcelamentoCancelamento::class, 'timestamp');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.calculaproporcaoparcela(integer)
         RETURNS numeric
         LANGUAGE plpgsql
        AS $function$
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
        $function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION public.aplica_acrescimo_modalidade_carne(character varying, integer, integer, integer, integer, integer, integer, numeric, date, date, text)
         RETURNS character varying
         LANGUAGE plpgsql
        AS $function$
        declare
            stNumeracao         ALIAS FOR $1;
            inCobrancaJudicial  ALIAS FOR $2;
            inCodInscricao      ALIAS FOR $3;
            inExercicio         ALIAS FOR $4;
            inCodModalidade     ALIAS FOR $5;
            inCodTipo           ALIAS FOR $6;
            inRegistro          ALIAS FOR $7;
            nuValor             ALIAS FOR $8;
            dtDataVencimento    ALIAS FOR $9;
            dtDataBase          ALIAS FOR $10;
            boIncidencia        ALIAS FOR $11;
            stSqlFuncoes        VARCHAR;
            stExecuta           VARCHAR;
            stRetorno           VARCHAR;
            stTabela            VARCHAR;
            stSqlCreditos       VARCHAR;
            stValores           VARCHAR := \'\';
            inValorTotal        NUMERIC := 0.00;
            inValorParcial      NUMERIC;
            nuProp              NUMERIC;
            reRecordFuncoes     RECORD;
            reRecordExecuta     RECORD;
            reRecordExecutaGambi     RECORD;
            boUtilizar          BOOLEAN;
            inTMP               INTEGER;
            stTMP               TEXT;

        begin

            inTMP := criarbufferinteiro( \'inCodInscricao\', COALESCE(inCodInscricao,0) );
            inTMP := criarbufferinteiro( \'inExercicio\', COALESCE(inExercicio,0) );
            inTMP := criarbufferinteiro( \'inCodModalidade\', inCodModalidade );
            inTMP := criarbufferinteiro( \'inRegistro\', inRegistro );
            stTMP := criarbuffertexto( \'boIncidencia\', boIncidencia );
            inTMP := criarbufferinteiro( \'judicial\', inCobrancaJudicial );

            stSqlFuncoes := \'
                SELECT
                    administracao.funcao.nom_funcao as funcao
                    , divida.modalidade_acrescimo.cod_acrescimo
                    , divida.modalidade_acrescimo.cod_tipo
                    , (
                        SELECT
                            administracao.funcao.nom_funcao
                        FROM
                            administracao.funcao
                        WHERE
                            administracao.funcao.cod_funcao = divida.modalidade_acrescimo.cod_funcao
                            AND administracao.funcao.cod_modulo = divida.modalidade_acrescimo.cod_modulo
                            AND administracao.funcao.cod_biblioteca = divida.modalidade_acrescimo.cod_biblioteca
                      )AS funcao_valida

                FROM
                    divida.modalidade

                INNER JOIN
                    divida.modalidade_vigencia
                ON
                    divida.modalidade_vigencia.timestamp = divida.modalidade.ultimo_timestamp
                    AND divida.modalidade_vigencia.cod_modalidade = divida.modalidade.cod_modalidade

                INNER JOIN
                    divida.modalidade_acrescimo
                ON
                    divida.modalidade_acrescimo.timestamp = divida.modalidade.ultimo_timestamp
                    AND divida.modalidade_acrescimo.cod_modalidade = divida.modalidade.cod_modalidade
                    AND divida.modalidade_acrescimo.cod_tipo = \'||inCodTipo||\'
                    AND divida.modalidade_acrescimo.pagamento = \'||boIncidencia||\'

                INNER JOIN
                    (
                        SELECT
                            tmp.*
                        FROM
                           monetario.formula_acrescimo AS tmp,
                           (
                                SELECT
                                    MAX(timestamp)AS timestamp,
                                    cod_tipo,
                                    cod_acrescimo
                                FROM
                                    monetario.formula_acrescimo
                                GROUP BY
                                    cod_tipo, cod_acrescimo
                           )AS tmp2
                        WHERE
                            tmp.timestamp = tmp2.timestamp
                            AND tmp.cod_tipo = tmp2.cod_tipo
                            AND tmp.cod_acrescimo = tmp2.cod_acrescimo
                    )AS mfa
                ON
                    mfa.cod_acrescimo = divida.modalidade_acrescimo.cod_acrescimo
                    AND mfa.cod_tipo = divida.modalidade_acrescimo.cod_tipo

                INNER JOIN
                    administracao.funcao
                ON
                    administracao.funcao.cod_funcao = mfa.cod_funcao
                    AND administracao.funcao.cod_modulo = mfa.cod_modulo
                    AND administracao.funcao.cod_biblioteca = mfa.cod_biblioteca

                WHERE
                    divida.modalidade.cod_modalidade = \'||inCodModalidade||\'
            \';


            stSqlCreditos := \'
                              SELECT  CAL.cod_calculo
                                    , CAL.cod_credito
                                    , CAL.cod_especie
                                    , CAL.cod_genero
                                    , CAL.cod_natureza
                                    , PAR.cod_parcela
                                    , LC.valor
                                FROM   arrecadacao.carne CAR
                                    INNER JOIN arrecadacao.parcela PAR ON PAR.cod_parcela = CAR.cod_parcela
                                    INNER JOIN arrecadacao.lancamento LAN ON LAN.cod_lancamento = PAR.cod_lancamento
                                    INNER JOIN arrecadacao.lancamento_calculo LC ON LC.cod_lancamento = LAN.cod_lancamento
                                    INNER JOIN arrecadacao.calculo CAL ON CAL.cod_calculo = LC.cod_calculo
                               WHERE
                                 CAR.numeracao = \'\'\'||stNumeracao||\'\'\'
                \';

            IF ( dtDataVencimento < dtDataBase ) THEN
                -- executa
                FOR reRecordFuncoes IN EXECUTE stSqlFuncoes LOOP

                    stExecuta :=  \'SELECT \'||reRecordFuncoes.funcao_valida||\'( \'||inRegistro||\' ) as utilizar \';
                    FOR reRecordExecuta IN EXECUTE stExecuta LOOP
                        boUtilizar := reRecordExecuta.utilizar;
                    END LOOP;

                    IF ( boUtilizar ) THEN
                        inValorParcial := 0.00;
                        FOR reRecordExecutaGambi IN EXECUTE stSqlCreditos LOOP
                            SELECT
                                arrecadacao.calculaproporcaoparcela( reRecordExecutaGambi.cod_parcela )
                            INTO
                                nuProp;

                            nuProp := nuProp * reRecordExecutaGambi.valor;

                            stExecuta :=  \'SELECT \'||reRecordFuncoes.funcao||\'(\'\'\'||dtDataVencimento||\'\'\',\'\'\'||dtDataBase||\'\'\',\'||nuProp||\', \'||reRecordFuncoes.cod_acrescimo||\' , \'||reRecordFuncoes.cod_tipo||\') as valor \';

                            FOR reRecordExecuta IN EXECUTE stExecuta LOOP
                                inValorTotal := inValorTotal + reRecordExecuta.valor;
                                inValorParcial := inValorParcial + reRecordExecuta.valor;
                            END LOOP;
                        END LOOP;

                        stValores := stValores || \';\' || inValorParcial || \';\' || reRecordFuncoes.cod_acrescimo || \';\' || reRecordFuncoes.cod_tipo;
                    END IF;
                END LOOP;
            END IF;

            stRetorno := inValorTotal || stValores;
           return stRetorno;
        end;
        $function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_atualiza_data_vencimento(date)
     RETURNS date
     LANGUAGE plpgsql
    AS $function$
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

    stSql := \'
        SELECT EXTRACT( DOW FROM DATE \'\'\'||dataVencimento||\'\'\' ) as valor
        \';

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

        anoV := to_char(ano,\'0000\');
        mesV := substring ( to_char(mes,\'00\'), 2, 2 );
        diaV := substring ( to_char(dia,\'00\'), 2, 2 );

        dataVarchar := anoV||\'-\'||mesV||\'-\'||diaV;

        --novoVencimento := to_date ( dataVarchar, \'\'YYYY-MM-DD\'\');

        return dataVarchar;
    end;
    $function$
            ');


        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_desconto_credito_lancamento(integer, integer, integer, integer, integer, integer, integer, date, numeric, integer)
     RETURNS numeric
     LANGUAGE plpgsql
    AS $function$
    DECLARE
        inCodLancamento ALIAS FOR $1;
        inCodParcela    ALIAS FOR $2;
        inCodCalculo    ALIAS FOR $3;
        inCodCredito    ALIAS FOR $4;
        inCodEspecie    ALIAS FOR $5;
        inCodGenero     ALIAS FOR $6;
        inCodNatureza   ALIAS FOR $7;
        dtDataBase      ALIAS FOR $8;
        nuValor         ALIAS FOR $9;
        inExercicio     ALIAS FOR $10;
        boDesconto      BOOLEAN;
        boGrupo         BOOLEAN;
        nuValorCalc     NUMERIC;
        nuValorParc     NUMERIC;
        nuValorTotal    NUMERIC;
        nuProporcao     NUMERIC;
        nuValorDesc     NUMERIC;
        nuRetorno       NUMERIC := 0.00;

    BEGIN
        --Verifica se o credito pertence a um grupo
            SELECT CASE WHEN (( SELECT 1
                                  FROM arrecadacao.calculo_grupo_credito
                                 WHERE calculo_grupo_credito.cod_calculo   = inCodCalculo
                                   AND calculo_grupo_credito.ano_exercicio = \'\'||inExercicio||\'\'
                              ) IS NOT NULL)
                        THEN TRUE
                        ELSE FALSE
                   END
              INTO boGrupo;

        --Se pertencer a um grupo, faz os calculos baseados no grupo
        IF boGrupo IS TRUE THEN

                SELECT desconto, calc.valor
                  INTO boDesconto, nuValorCalc
                  FROM arrecadacao.calculo calc
            INNER JOIN arrecadacao.calculo_grupo_credito acgc
                    ON acgc.cod_calculo = calc.cod_calculo
            INNER JOIN arrecadacao.grupo_credito agc
                    ON agc.cod_grupo     = acgc.cod_grupo
                   AND agc.ano_exercicio = acgc.ano_exercicio
            INNER JOIN arrecadacao.credito_grupo acg
                    ON acg.cod_grupo    = agc.cod_grupo
                   AND acg.cod_credito  = calc.cod_credito
                   AND acg.cod_especie  = calc.cod_especie
                   AND acg.cod_genero   = calc.cod_genero
                   AND acg.cod_natureza = calc.cod_natureza
                 WHERE calc.cod_calculo  = inCodCalculo
                   AND calc.cod_credito  = inCodCredito
                   AND calc.cod_especie  = inCodEspecie
                   AND calc.cod_genero   = inCodGenero
                   AND calc.cod_natureza = inCodNatureza
                   AND agc.ano_exercicio = \'\'||inExercicio||\'\';

            SELECT SUM(ac.valor)
              INTO nuValorTotal
              FROM arrecadacao.calculo AS ac
        INNER JOIN  arrecadacao.lancamento_calculo AS alc
                ON alc.cod_calculo    = ac.cod_calculo
               AND alc.cod_lancamento = inCodLancamento
        INNER JOIN arrecadacao.calculo_grupo_credito AS acgc
                ON acgc.cod_calculo = alc.cod_calculo
               AND ac.exercicio     = acgc.ano_exercicio
             WHERE ac.cod_credito IN ( SELECT cod_credito
                                         FROM arrecadacao.credito_grupo AS acg
                                        WHERE acg.desconto       = TRUE
                                          AND acg.cod_grupo      = acgc.cod_grupo
                                          AND acgc.ano_exercicio = \'\'||inExercicio||\'\'
                                     )
               AND acgc.ano_exercicio = \'\'||inExercicio||\'\';

        --Se nao, calcula baseado no credito
        ELSE
            SELECT valor
              INTO nuValorCalc
              FROM arrecadacao.calculo
             WHERE calculo.cod_calculo  = inCodCalculo
               AND calculo.cod_credito  = inCodCredito
               AND calculo.cod_especie  = inCodEspecie
               AND calculo.cod_genero   = inCodGenero
               AND calculo.cod_natureza = inCodNatureza
               AND calculo.exercicio    = \'\'||inExercicio||\'\';

            SELECT CASE WHEN (( SELECT 1
                                  FROM arrecadacao.parcela_desconto
                                 WHERE parcela_desconto.cod_parcela = inCodParcela
                              ) IS NOT NULL)
                        THEN TRUE
                        ELSE FALSE
                   END
              INTO boDesconto;

            nuValorTotal := nuValorCalc;

        END IF;

        SELECT valor INTO nuValorParc FROM arrecadacao.parcela WHERE cod_parcela = inCodParcela;

        IF nuValorTotal > 0 THEN
            nuProporcao := (nuValorCalc * 100) / nuValorTotal;
        ELSE
            nuProporcao := 0;
        END IF;

        nuValorDesc := fn_busca_desconto_parcela(inCodParcela,dtDataBase);

        IF boDesconto = true THEN
            nuRetorno :=  ( (nuValorParc - nuValorDesc) * ( nuProporcao/100))::NUMERIC(14,2);
            RETURN nuRetorno;
        ELSE
            return nuRetorno;
        END IF;

    END;
    $function$
    ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.buscavalorparcela(integer)
         RETURNS numeric
         LANGUAGE plpgsql
        AS $function$

        DECLARE
            inCodParcela    ALIAS FOR $1;
            nuValor         numeric;

        BEGIN
            -- Verifica se a parcela possui desconto
            SELECT
                valor
            INTO
                nuValor
            FROM
                arrecadacao.parcela_desconto
            WHERE
                cod_parcela = inCodParcela;

            IF ( nuValor IS NULL ) THEN
                SELECT
                    valor
                INTO
                    nuValor
                FROM
                    arrecadacao.parcela
                WHERE
                    cod_parcela = inCodParcela;
            END IF;

           return nuValor;
        end;
        $function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_total_parcelas(integer)
         RETURNS integer
         LANGUAGE plpgsql
        AS $function$
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
        $function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_situacao_carne(character varying, character varying)
         RETURNS character varying
         LANGUAGE plpgsql
        AS $function$
        DECLARE
            stNumeracao     ALIAS FOR $1;
            stSexo          ALIAS FOR $2;
            stTeste         VARCHAR;
            inCodMotivo     INTEGER;
            stAdd           VARCHAR;
            boAdd           BOOLEAN := TRUE;
            stRetorno       VARCHAR;
        BEGIN
            -- verifica sexo pra devolução
            IF stSexo = \'m\' THEN
                stAdd := \'o\';
            ELSIF stSexo = \'f\' THEN
                stAdd := \'a\';
            END IF;


            -- busca situacao do carne
            SELECT
                numeracao
                , cod_motivo
            INTO stTeste, inCodMotivo
            FROM arrecadacao.carne_devolucao
            WHERE numeracao = stNumeracao AND dt_devolucao <= now()::date;



            IF stTeste IS NOT NULL THEN

                select descricao_resumida
                into stRetorno
                from arrecadacao.motivo_devolucao
                where cod_motivo=inCodMotivo;
                boAdd := false;

            ELSE
                SELECT numeracao INTO stTeste FROM arrecadacao.pagamento
                WHERE numeracao = stNumeracao;
                IF stTeste IS NOT NULL THEN
                    stRetorno := \'Pag\';
                ELSE
                    SELECT b.cod_parcela::varchar INTO stTeste FROM arrecadacao.carne a, arrecadacao.parcela b WHERE a.numeracao = stNumeracao AND b.cod_parcela=a.cod_parcela AND vencimento < now()::date;
                    IF stTeste IS NOT NULL THEN
                        stRetorno := \'Vencid\';
                    ELSE
                        stRetorno := \'A Vencer\';
                        stAdd := \'\';
                    END IF;
                END IF;

            END IF;

            if ( boAdd = true) then
                stRetorno := stRetorno||stAdd;
            else
                stRetorno := stRetorno;
            end if;
            RETURN stRetorno;
        END;
        $function$
        ');

        $this->addSql("
            CREATE OR REPLACE function public.fn_add_col(_tbl regclass, _col  text, _type regtype)
              RETURNS bool AS
            \$func$
            BEGIN
               IF EXISTS (SELECT 1 FROM pg_attribute
                          WHERE  attrelid = _tbl
                          AND    attname = _col
                          AND    NOT attisdropped) THEN
                  RETURN FALSE;
               ELSE
                  EXECUTE format('ALTER TABLE %s ADD COLUMN %I %s', _tbl, _col, _type);
                  RETURN TRUE;
               END IF;
            END
            \$func$  LANGUAGE plpgsql;
        ");
        $this->addSql("SELECT public.fn_add_col('arrecadacao.carne', 'i_lancto', 'int');");
        $this->addSql("SELECT public.fn_add_col('arrecadacao.carne', 'i_debito', 'int');");
        $this->addSql("DROP FUNCTION public.fn_add_col(_tbl regclass, _col  text, _type regtype);");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
