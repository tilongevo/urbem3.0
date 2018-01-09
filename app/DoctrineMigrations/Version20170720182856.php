<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170720182856 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('tributario_arrecadacao_consultas_home', 'Arrecadação - Consultas', 'tributario');
        $this->insertRoute('urbem_tributario_arrecadacao_consultas_consulta_arrecadacao_list', 'Consulta de Arrecadação', 'tributario_arrecadacao_consultas_home');
        $this->insertRoute('urbem_tributario_arrecadacao_consultas_consulta_arrecadacao_show', 'Detalhes', 'urbem_tributario_arrecadacao_consultas_consulta_arrecadacao_list');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_busca_lancamento_situacao(integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE

    inCodLancamento             ALIAS FOR $1;
    inRetorno                   integer;
    reRegistro                  RECORD;
    stSql                       VARCHAR;
    stMotivo                    VARCHAR;
    stRetorno                   VARCHAR := \'\';
    stRetorno2                  VARCHAR := \'\';
    inDivida                    integer;
    inNumeroParcelasN           integer;
    inNumeroParcelasU           integer;
    inNumeroParcelasTotal       integer;
    inNumParcelaGroup           integer;
    inParcelaUnicaPago          integer := 0;
    inNumParcelaGroupPago       integer := 0;
    inNumParcelaGroupDev        integer := 0;
    inNumParcelaGroupPagFalse   integer := 0;
    inPagamentoReemissao        integer := 0;
    inCodMotivoCancelamento     integer := 0;
    stNomParcelaGroup           VARCHAR := \'\';
    boSentencaLancamento        BOOLEAN := false;
    stSentencaLancamento        VARCHAR := \'\';
    boValido                    BOOLEAN := true;
    boDesonerado                BOOLEAN := false;

BEGIN

    --numero de parcelas normais
    SELECT coalesce(fn_total_parcelas, 0 )
      INTO inNumeroParcelasN
      FROM arrecadacao.fn_total_parcelas( inCodLancamento )
         ;

    --numero de parcelas unicas
    SELECT coalesce ( count(cod_parcela), 0 )
      INTO inNumeroParcelasU
      FROM arrecadacao.parcela
     WHERE cod_lancamento = inCodLancamento
       AND nr_parcela = 0
         ;

--  IF inNumeroParcelasU > 1 THEN
--      inNumeroParcelasU := 1;
--  END IF;

    inNumeroParcelasTotal := inNumeroParcelasU + inNumeroParcelasN;
    ----------------------------------------------------------------------------------------------------


    --------------------------------------------------------------------------------
    -- VERIFICAÇÃO 1
    --
    -- Desonerações - retorna descricao da desoneracao
    --------------------------------------------------------------------------------
    IF ( inNumeroParcelasTotal = 0 ) THEN

        -- Verifica se o lancamento está na USA DESONERACAO

            SELECT atd.descricao
              INTO stRetorno
              FROM arrecadacao.lancamento_usa_desoneracao as alud
        INNER JOIN arrecadacao.desoneracao as ad
                ON ad.cod_desoneracao = alud.cod_desoneracao
        INNER JOIN arrecadacao.tipo_desoneracao as atd
                ON atd.cod_tipo_desoneracao = ad.cod_tipo_desoneracao
             WHERE alud.cod_lancamento = inCodLancamento
                 ;

            SELECT count( faturamento_sem_movimento )
              INTO stRetorno2
              FROM arrecadacao.lancamento_calculo
        INNER JOIN arrecadacao.cadastro_economico_calculo
                ON cadastro_economico_calculo.cod_calculo = lancamento_calculo.cod_calculo
        INNER JOIN arrecadacao.faturamento_sem_movimento
                ON faturamento_sem_movimento.inscricao_economica = cadastro_economico_calculo.inscricao_economica
               AND faturamento_sem_movimento.timestamp = cadastro_economico_calculo.timestamp
             WHERE lancamento_calculo.cod_lancamento = inCodLancamento
                 ;

        IF ( stRetorno2::numeric != 0 ) THEN
            boValido        := true;
            boDesonerado    := true;
            stRetorno := \'Sem Movimento\';
        ELSEIF ( stRetorno != \'\' ) THEN
            boValido        := true;
            boDesonerado    := true;
            stRetorno := \'Desonerado - \'||stRetorno;
        ELSE
            boValido := false;
            stRetorno := \'Inválido\';
        END IF;

    END IF;


    --------------------------------------------------------------------------------
    -- VERIFICAÇÃO 2
    --
    -- Pagamentos False - Verifica se a Cota Unica ou TODAS as normais estão com a mesma situação
    -- Retorno: a descricao desse pagamento
    --------------------------------------------------------------------------------

    --verifica se os pagamentos sao false e de um UNICO jeito
    IF ( ( boValido IS TRUE ) AND ( stRetorno = \'\' ) ) THEN

            SELECT COUNT(ap.cod_parcela)::integer
                 , atp.nom_resumido
              INTO inNumParcelaGroupPagFalse
                 , stNomParcelaGroup
              FROM arrecadacao.parcela AS ap
        INNER JOIN arrecadacao.carne
                ON carne.cod_parcela = ap.cod_parcela
        INNER JOIN arrecadacao.pagamento AS apag
                ON apag.numeracao = carne.numeracao
               AND apag.cod_convenio = carne.cod_convenio
        INNER JOIN arrecadacao.tipo_pagamento AS atp
                ON atp.cod_tipo = apag.cod_tipo
               AND atp.pagamento = false
             WHERE ap.cod_lancamento = inCodLancamento
          GROUP BY atp.nom_resumido
                 ;

        SELECT count (total.cod_parcela)
          INTO inNumParcelaGroupPago
          FROM (
                     SELECT distinct ap.cod_parcela
                       from arrecadacao.parcela as ap
                 INNER JOIN arrecadacao.carne
                         ON carne.cod_parcela = ap.cod_parcela
                 INNER JOIN arrecadacao.pagamento as apag
                         ON apag.numeracao = carne.numeracao
                        AND apag.cod_convenio = carne.cod_convenio
                 INNER JOIN arrecadacao.tipo_pagamento as atp
                         ON atp.cod_tipo = apag.cod_tipo
                        AND atp.pagamento = true
--                         AND atp.cod_tipo != 5
                      WHERE ap.cod_lancamento = inCodLancamento
               ) AS total
             ;

        IF inNumParcelaGroupPagFalse IS NOT NULL AND ( inNumParcelaGroupPagFalse = inNumeroParcelasTotal ) AND ( inNumParcelaGroupPago = 0 ) THEN
            boValido := false;
            stRetorno := stNomParcelaGroup;
        END IF;

    END IF;


    --------------------------------------------------------------------------------
    -- VERIFICAÇÃO 3
    --
    -- Carne Devoluao - Verifica se a Cota Única ou TODAS as NORMAIS estão estão com a mesma situação
    -- Retorno: a Descrição da devolução
    --------------------------------------------------------------------------------

    IF boValido IS TRUE THEN

          SELECT COUNT(cod_parcela)
               , cod_motivo
               , CASE WHEN EXISTS (
                                        SELECT DISTINCT amd.descricao_resumida
                                          FROM arrecadacao.parcela AS ap
                                    INNER JOIN arrecadacao.carne
                                            ON carne.cod_parcela = ap.cod_parcela
                                    INNER JOIN arrecadacao.carne_devolucao AS acd
                                            ON acd.numeracao = carne.numeracao
                                           AND acd.cod_convenio = carne.cod_convenio
                                    INNER JOIN arrecadacao.motivo_devolucao AS amd
                                            ON amd.cod_motivo = acd.cod_motivo
                                     LEFT JOIN arrecadacao.pagamento AS apag
                                            ON apag.numeracao = carne.numeracao
                                           AND apag.cod_convenio = carne.cod_convenio
                                         WHERE amd.descricao_resumida = \'Inscrito em D.A.\'
                                           AND ap.cod_lancamento = inCodLancamento
                                           AND apag.numeracao IS NULL
                                      GROUP BY amd.descricao_resumida
                                  ) THEN \'Inscrito em D.A.\'
                      WHEN EXISTS (
                                        SELECT DISTINCT amd.descricao_resumida
                                          FROM arrecadacao.parcela AS ap
                                    INNER JOIN arrecadacao.carne
                                            ON carne.cod_parcela = ap.cod_parcela
                                    INNER JOIN arrecadacao.carne_devolucao AS acd
                                            ON acd.numeracao = carne.numeracao
                                           AND acd.cod_convenio = carne.cod_convenio
                                    INNER JOIN arrecadacao.motivo_devolucao AS amd
                                            ON amd.cod_motivo = acd.cod_motivo
                                     LEFT JOIN arrecadacao.pagamento AS apag
                                            ON apag.numeracao = carne.numeracao
                                           AND apag.cod_convenio = carne.cod_convenio
                                         WHERE amd.descricao_resumida = \'Reemitida\'
                                           AND ap.cod_lancamento = inCodLancamento
                                           AND apag.numeracao IS NULL
                                      GROUP BY amd.descricao_resumida
                                  ) THEN \'Reemitida\'
                      ELSE
                          trim( descricao_resumida )
                 END as descricao_resumida
            INTO inNumParcelaGroupDev
               , inCodMotivoCancelamento
               , stNomParcelaGroup
            FROM (
                       SELECT DISTINCT ap.cod_parcela::integer
                            , amd.cod_motivo
                            , amd.descricao_resumida
                         FROM arrecadacao.parcela as ap
                   INNER JOIN arrecadacao.carne
                           ON carne.cod_parcela = ap.cod_parcela
                   INNER JOIN arrecadacao.carne_devolucao as acd
                           ON acd.numeracao = carne.numeracao
                          AND acd.cod_convenio = carne.cod_convenio
                   INNER JOIN arrecadacao.motivo_devolucao as amd
                           ON amd.cod_motivo = acd.cod_motivo
                    LEFT JOIN arrecadacao.pagamento as apag
                           ON apag.numeracao = carne.numeracao
                          AND apag.cod_convenio = carne.cod_convenio
                        WHERE ap.cod_lancamento = inCodLancamento
                          AND apag.numeracao IS NULL
                          AND acd.cod_motivo != 10
                     ORDER BY amd.descricao_resumida
                 ) as busca
        GROUP BY cod_motivo
               , descricao_resumida
        ORDER BY cod_motivo
               ;

        SELECT count (total.cod_parcela)
          INTO inNumParcelaGroupPago
          FROM (
                     SELECT distinct ap.cod_parcela
                       from arrecadacao.parcela as ap
                 INNER JOIN arrecadacao.carne
                         ON carne.cod_parcela = ap.cod_parcela
                 INNER JOIN arrecadacao.pagamento as apag
                         ON apag.numeracao = carne.numeracao
                        AND apag.cod_convenio = carne.cod_convenio
                 INNER JOIN arrecadacao.tipo_pagamento as atp
                         ON atp.cod_tipo = apag.cod_tipo
                        AND atp.pagamento = true
                        AND atp.cod_tipo != 5
                      WHERE ap.cod_lancamento = inCodLancamento
               ) AS total
             ;

      SELECT count (total.cod_parcela)
          INTO inParcelaUnicaPago
          FROM (
                     SELECT distinct ap.cod_parcela
                       from arrecadacao.parcela as ap
                 INNER JOIN arrecadacao.carne
                         ON carne.cod_parcela = ap.cod_parcela
                 INNER JOIN arrecadacao.pagamento as apag
                         ON apag.numeracao = carne.numeracao
                        AND apag.cod_convenio = carne.cod_convenio
                 INNER JOIN arrecadacao.tipo_pagamento as atp
                         ON atp.cod_tipo = apag.cod_tipo
                        AND atp.pagamento = true
                        AND atp.cod_tipo != 5
                      WHERE ap.cod_lancamento = inCodLancamento
            and ap.nr_parcela = 0
               ) AS total
             ;

        inNumParcelaGroupPagFalse := coalesce ( inNumParcelaGroupPagFalse, 0 );
        inNumParcelaGroupDev      := coalesce ( inNumParcelaGroupDev,      0 );
        inNumParcelaGroupPago     := coalesce ( inNumParcelaGroupPago,     0 );


        IF inNumParcelaGroupPagFalse = (inNumParcelaGroupDev + inNumParcelaGroupPago) THEN
            inNumParcelaGroupPagFalse := 0;
        END IF;

        IF (inNumParcelaGroupDev IS NOT NULL AND inNumParcelaGroupPago IS NULL AND ( inNumParcelaGroupDev = inNumeroParcelasTotal )) THEN -- OR (inNumParcelaGroupDev IS NOT NULL AND inNumParcelaGroupDev > 0 AND inNumParcelaGroupPago IS NOT NULL) THEN
            boValido := false;
            stRetorno := stNomParcelaGroup;

            IF stRetorno = \'Reemitida\' THEN
               SELECT count(carne.cod_parcela)
                 INTO inPagamentoReemissao
                 FROM arrecadacao.carne
                 JOIN arrecadacao.pagamento
                   ON pagamento.numeracao = carne.numeracao
                 JOIN arrecadacao.parcela
                   ON parcela.cod_parcela = carne.cod_parcela
                WHERE parcela.cod_lancamento =  inCodLancamento
                    ;

                   IF inPagamentoReemissao >= inNumeroParcelasTotal THEN
                          stRetorno := \'Quitado\';
                   ELSIF inPagamentoReemissao < inNumeroParcelasTotal THEN
                          stRetorno := \'Ativo\';
                   END IF;
            END IF;

        ELSIF ( ( inNumParcelaGroupDev IS NOT NULL )
                AND ( inNumParcelaGroupDev > 0 )
                AND ( stNomParcelaGroup = \'Cancelada\' OR stNomParcelaGroup = \'Cancelado\' )
                AND ((inNumParcelaGroupPagFalse+inNumParcelaGroupDev) = (inNumeroParcelasTotal)) -- - (inNumParcelaGroupPagFalse+inNumParcelaGroupDev)))
            )  THEN

            IF (inCodMotivoCancelamento IS NOT NULL AND (inCodMotivoCancelamento = 100 OR inCodMotivoCancelamento = 101)) THEN
                boValido := false;
                stRetorno := \'Ativo\';
            ELSE
                boValido := false;
                stRetorno := stNomParcelaGroup;
            END IF;

        ELSIF ( stNomParcelaGroup = \'Inscrito em D.A.\' ) THEN

            boValido := false;
            stRetorno := stNomParcelaGroup;

        END IF;



    END IF;


    --------------------------------------------------------------------------------
    -- VERIFICAÇÃO 4
    --
    -- Pagamento TRUE - Verifica se a Cota Única ou TODAS as NORMAIS estão estão com a mesma situação
    -- Retorno: Quitado
    --------------------------------------------------------------------------------
    -- stRetorno := \'\'\'\';
    -- boValido:= true;

    IF ( ( boValido IS TRUE ) AND ( stRetorno = \'\' )) THEN

--        SELECT count (total.cod_parcela)
--          INTO inNumParcelaGroupPago
--          FROM (
--                     SELECT distinct ap.cod_parcela
--                       from arrecadacao.parcela as ap
--                 INNER JOIN arrecadacao.carne
--                         ON carne.cod_parcela = ap.cod_parcela
--                 INNER JOIN arrecadacao.pagamento as apag
--                         ON apag.numeracao = carne.numeracao
--                        AND apag.cod_convenio = carne.cod_convenio
--                 INNER JOIN arrecadacao.tipo_pagamento as atp
--                         ON atp.cod_tipo = apag.cod_tipo
--                        AND atp.pagamento = true
--                        AND atp.cod_tipo != 5
--                      WHERE ap.cod_lancamento = inCodLancamento
--               ) AS total
--             ;

        inNumParcelaGroupPagFalse := coalesce ( inNumParcelaGroupPagFalse, 0 );
        inNumParcelaGroupDev      := coalesce ( inNumParcelaGroupDev,      0 );
        inNumParcelaGroupPago     := coalesce ( inNumParcelaGroupPago,     0 );

            SELECT DISTINCT lancamento_calculo.cod_lancamento
              INTO inDivida
              FROM arrecadacao.lancamento_calculo
        INNER JOIN divida.parcela_calculo
                ON parcela_calculo.cod_calculo = lancamento_calculo.cod_calculo
             WHERE lancamento_calculo.cod_lancamento = inCodLancamento
                 ;

        IF ( inNumParcelaGroupPago = inNumeroParcelasTotal ) OR (inParcelaUnicaPago > 0) THEN
            boValido := false;
            stRetorno := \'Quitado\';

        ELSIF ((inNumParcelaGroupPago = (inNumeroParcelasTotal -(inNumParcelaGroupPagFalse+inNumParcelaGroupDev)))) THEN
            boValido := false;
--            IF ( inDivida IS NOT NULL ) THEN
--                SELECT DISTINCT
--                    atp.nom_resumido
--                INTO
--                    stNomParcelaGroup
--                from
--                    arrecadacao.parcela as ap
--                    INNER JOIN arrecadacao.carne
--                    ON carne.cod_parcela = ap.cod_parcela
--                    INNER JOIN arrecadacao.pagamento as apag
--                    ON apag.numeracao = carne.numeracao
--                    AND apag.cod_convenio = carne.cod_convenio
--                    INNER JOIN arrecadacao.tipo_pagamento as atp
--                    ON atp.cod_tipo = apag.cod_tipo
--                    AND atp.pagamento = false
--                WHERE ap.cod_lancamento =  inCodLancamento;
--                stRetorno := stNomParcelaGroup;
--            ELSE
                stRetorno := \'Quitado\';
--            END IF;
        END IF;

    END IF;


    -----------------------------------------------------------------------------------------

    IF ( boValido is true AND boDesonerado IS FALSE ) THEN
        --inNumLancAtivos := inNumLancAtivos + 1;
        stRetorno := \'Ativo\';
    ELSE

        stRetorno := stRetorno;
    END IF;

    return stRetorno;
END;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_busca_origem_lancamento_sem_exercicio(integer, integer, integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
    inCodLancamento     ALIAS FOR $1;
    inTipoGrupo         ALIAS FOR $2;
    inTipoCredito       ALIAS FOR $3;
    stOrigem            VARCHAR := \'\';
    stGrupo             VARCHAR := \'\';
    inNumParcelamento   INTEGER;
    reRecordFuncoes     RECORD;
    stSqlFuncoes        VARCHAR;
begin

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
                        agc.descricao||\' / \'||acgc.ano_exercicio
                    ELSE
                        CASE WHEN inTipoGrupo = 2 THEN
                            \'§\'||acgc.cod_grupo||\'§\'||agc.descricao||\'§\'||acgc.ano_exercicio||\'§§\'||agc.cod_modulo
                        ELSE
                            acgc.cod_grupo||\' § \'||agc.descricao
                        END
                    END
                ELSE
                    CASE WHEN inTipoCredito = 1 THEN
                        mc.descricao_credito||\' / \'||ac.exercicio
                    ELSE
                        CASE WHEN inTipoGrupo = 2 THEN
                            mc.cod_credito||\'§§\'||mc.descricao_credito||\'§\'||ac.exercicio||\'§§\'||mc.cod_especie||\'§\'||mc.cod_genero||\'§\'||mc.cod_natureza
                        ELSE
                            mc.cod_credito||\'.\'||mc.cod_especie||\'.\'||mc.cod_genero||\'.\'||mc.cod_natureza||\'.\'||mc.descricao_credito
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
            --   AND acgc.ano_exercicio = ac.exercicio

         LEFT JOIN arrecadacao.grupo_credito as agc
                  ON agc.cod_grupo = acgc.cod_grupo
                AND agc.ano_exercicio = acgc.ano_exercicio

        LEFT JOIN monetario.credito as mc
                 ON mc.cod_credito = ac.cod_credito
               AND mc.cod_especie = ac.cod_especie
               AND mc.cod_genero = ac.cod_genero
               AND mc.cod_natureza = ac.cod_natureza

        WHERE al.cod_lancamento = inCodLancamento
--        and ac.exercicio = inExercicio;
        ;


    IF ( stOrigem = \'DA\' ) THEN
    SELECT distinct num_parcelamento
        INTO
            inNumParcelamento
        FROM divida.parcela_calculo as dpc
            INNER JOIN arrecadacao.lancamento_calculo as alc
            ON alc.cod_calculo = dpc.cod_calculo
        WHERE
            alc.cod_lancamento = inCodLancamento;

 stSqlFuncoes := \'
        SELECT
            DIVIDA_PARCELAMENTO.cod_inscricao,
            DIVIDA_PARCELAMENTO.exercicio

        FROM
            DIVIDA.DIVIDA_PARCELAMENTO
        WHERE
            DIVIDA_PARCELAMENTO.num_parcelamento = \'||inNumParcelamento||\'
    \';
    stOrigem := \'§§\';
    FOR reRecordFuncoes IN EXECUTE stSqlFuncoes LOOP
        stOrigem := stOrigem || \'DA - \' || reRecordFuncoes.cod_inscricao || \'/\' || reRecordFuncoes.exercicio || \'<br>\';
    END LOOP;
    stOrigem := stOrigem || \'§\';

    END IF;



    return stOrigem;
    --
end;
$function$
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
$function$
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
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_ultimo_venal_por_im_lanc(integer, integer)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$
DECLARE
    inInscricaoMunicipal   ALIAS FOR $1;
    inCodLancamento        ALIAS FOR $2;
    inMaxCodCalculo        integer;
    tsTimestampCalculo     timestamp;
    tsMaiorTimestamp       timestamp;
    nuResultado     NUMERIC;
BEGIN
-- pega calculo do lancamento
     select max(cod_calculo)
       into inMaxCodCalculo
       from arrecadacao.lancamento_calculo
      where cod_lancamento = inCodLancamento;

-- timestamp do calculo
     select timestamp
       into tsTimestampCalculo
       from arrecadacao.calculo
      where cod_calculo = inMaxCodCalculo;

-- maior timestamp menor que timestamp do calculo
     select max(timestamp)
       into tsMaiorTimestamp
       from arrecadacao.imovel_v_venal
      where timestamp <= tsTimestampCalculo
        and inscricao_municipal = inInscricaoMunicipal
        and (venal_total_informado IS not null OR venal_total_calculado IS not null);

-- venal do timestamp encontrado
     select coalesce(iv.venal_total_informado, iv.venal_total_calculado,0.00)
       into nuResultado
       from arrecadacao.imovel_v_venal as iv
      where inscricao_municipal = inInscricaoMunicipal
        and timestamp = tsMaiorTimestamp
   order by iv.venal_total_informado,venal_total_calculado desc
      limit 1;

    return coalesce(nuResultado,0.00);
END;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_tipo_ultimo_venal_por_im_lanc(integer, integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE
    inInscricaoMunicipal   ALIAS FOR $1;
    inCodLancamento        ALIAS FOR $2;
    inMaxCodCalculo        integer;
    tsTimestampCalculo     timestamp;
    tsMaiorTimestamp       timestamp;
    stResultado            varchar;
BEGIN
-- pega calculo do lancamento
     select max(cod_calculo)
       into inMaxCodCalculo
       from arrecadacao.lancamento_calculo
      where cod_lancamento = inCodLancamento;

-- timestamp do calculo
     select timestamp
       into tsTimestampCalculo
       from arrecadacao.calculo
      where cod_calculo = inMaxCodCalculo;

-- maior timestamp menor que timestamp do calculo
     select max(timestamp)
       into tsMaiorTimestamp
       from arrecadacao.imovel_v_venal
      where timestamp <= tsTimestampCalculo
        and inscricao_municipal = inInscricaoMunicipal
        and (venal_total_informado IS not null OR venal_total_calculado IS not null);

-- venal do timestamp encontrado
     select
            case when ( iv.venal_total_informado is not null ) then
                \'Informado\'
            else
                case when ( iv.venal_total_calculado is not null ) then
                    \'Calculado\'
                end
            end

       into stResultado
       from arrecadacao.imovel_v_venal as iv
      where inscricao_municipal = inInscricaoMunicipal
        and timestamp = tsMaiorTimestamp
   order by iv.venal_total_informado,venal_total_calculado desc
      limit 1;

    return stResultado;
END;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_num_unicas(integer)
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
        nr_parcela = 0;

    RETURN inRetorno;
END;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION monetario.fn_busca_mascara_credito(integer, integer, integer, integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE

    inCodCredito    ALIAS FOR $1;
    inCodEspecie    ALIAS FOR $2;
    inCodGenero     ALIAS FOR $3;
    inCodNatureza   ALIAS FOR $4;
    stRetorno       VARCHAR;
    reRecord        record;
    stSql           VARCHAR;

BEGIN

stSql = \'
    SELECT
        c.descricao_credito,
        lpad ( c.cod_credito::varchar, max_credito.valor, \'\'0\'\' ) as cod_credito,
        lpad ( c.cod_especie::varchar, max_especie.valor, \'\'0\'\' ) as cod_especie,
        lpad ( c.cod_genero::varchar,  max_genero.valor, \'\'0\'\' ) as cod_genero,
        lpad ( c.cod_natureza::varchar, max_natureza.valor, \'\'0\'\' ) as cod_natureza,

        ( lpad ( c.cod_credito::varchar, max_credito.valor, \'\'0\'\' )||\'\'.\'\'|| lpad( c.cod_especie::varchar, max_especie.valor, \'\'0\'\' )||\'\'.\'\'|| lpad (c.cod_genero::varchar, max_genero.valor, \'\'0\'\' )||\'\'.\'\'|| lpad( c.cod_natureza::varchar, max_natureza.valor, \'\'0\'\' )) as codigo_composto

    FROM
        monetario.credito as c,
        ( select length(max(cod_credito)::varchar) as valor from monetario.credito ) as max_credito,
        ( select length(max(cod_genero)::varchar) as valor from monetario.genero_credito ) as max_genero,
        ( select length(max(cod_especie)::varchar) as valor from monetario.especie_credito ) as max_especie,
        ( select length(max(cod_natureza)::varchar) as valor from monetario.natureza_credito ) as max_natureza
    WHERE
        c.cod_credito = \'|| inCodCredito ||\'
        AND c.cod_especie   = \'|| inCodEspecie ||\'
        AND c.cod_genero    = \'|| inCodGenero ||\'
        AND c.cod_natureza  = \'|| inCodNatureza ||\'
    GROUP BY
        c.cod_credito, c.descricao_credito, c.cod_especie, c.cod_genero, c.cod_natureza,
        max_credito.valor, max_especie.valor, max_genero.valor, max_natureza.valor
    \';

    FOR reRecord IN EXECUTE stSql LOOP
        stRetorno := reRecord.codigo_composto;
        stRetorno := stRetorno||\'§\'||reRecord.cod_credito;
        stRetorno := stRetorno||\'§\'||reRecord.cod_especie;
        stRetorno := stRetorno||\'§\'||reRecord.cod_genero;
        stRetorno := stRetorno||\'§\'||reRecord.cod_natureza;
        stRetorno := stRetorno||\'§\'||reRecord.descricao_credito;
    END LOOP;

    RETURN stRetorno;
END;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_consulta_parcela(integer, date)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $function$
DECLARE
   inCodLancamento      ALIAS FOR $1;
   dtDataBase           ALIAS FOR $2;
   stSql                VARCHAR;
   stSql2               VARCHAR;
   reRecord1            RECORD;
   reRecord2            RECORD;
BEGIN
    stSql = \'
        SELECT
            al.cod_lancamento::integer
            , ap.cod_parcela::integer
            , ap.nr_parcela::integer

            , ( case when apr.cod_parcela is not null then
                    apr.valor
                else
                    ap.valor
                end
            )::numeric(14,2) as valor
            , (to_char(ap.vencimento,\'\'dd/mm/YYYY\'\'))::varchar as vencimento
            , \'\'\'\'::varchar as vencimento_original
            , ap.vencimento as vencimento_us
            , ( case when ap.nr_parcela = 0
                then \'\'Única\'\'::VARCHAR
              else
                (ap.nr_parcela::varchar||\'\'/\'\'|| arrecadacao.fn_total_parcelas(al.cod_lancamento))::varchar
              end
            ) as info_parcela

            , now()::date as database

            , (to_char(now()::date, \'\'dd/mm/YYYY\'\'))::varchar as database_br,
            \'\'\'\'::varchar as numeracao,
            \'\'\'\'::varchar as exercicio,
            \'\'\'\'::varchar as situacao,
            \'\'\'\'::varchar as situacao_resumida,
            \'\'\'\'::varchar as numeracao_migracao,
            \'\'\'\'::varchar as prefixo,
            now()::date  as pagamento,
            0::integer as ocorrencia_pagamento
        FROM
            arrecadacao.lancamento al
            INNER JOIN (
                select
                    cod_lancamento, cod_parcela, nr_parcela, valor,
                    arrecadacao.fn_atualiza_data_vencimento( vencimento ) as vencimento
                from arrecadacao.parcela
            ) as ap ON al.cod_lancamento   = ap.cod_lancamento

            LEFT JOIN
            (
                select apr.cod_parcela, vencimento, valor
                from arrecadacao.parcela_reemissao apr
                inner join (
                    select cod_parcela, min(timestamp) as timestamp
                    from arrecadacao.parcela_reemissao as x
                    group by cod_parcela
                ) as apr2
                ON apr2.cod_parcela = apr.cod_parcela AND
                apr2.timestamp = apr.timestamp
            ) as apr
            ON apr.cod_parcela = ap.cod_parcela
        WHERE
            al.cod_lancamento=\'||inCodLancamento||\'
        ORDER BY
            ap.cod_parcela
        \';

    FOR reRecord1 IN EXECUTE stSql LOOP
        stSql2 := \'
            SELECT
                *
            FROM
                arrecadacao.fn_consulta_numeracao_parcela (\'||reRecord1.cod_parcela||\',\'\'\'||dtDataBase||\'\'\')
            as ( numeracao varchar, exercicio varchar, situacao varchar, situacao_resumida varchar, numeracao_migracao varchar, prefixo varchar, vencimento_original varchar, pagamento date, ocorrencia_pagamento int )
        \';


      FOR reRecord2 IN EXECUTE stSql2 LOOP
           reRecord1.numeracao              := reRecord2.numeracao;
           reRecord1.exercicio              := reRecord2.exercicio;
           reRecord1.situacao               := reRecord2.situacao ;
           reRecord1.situacao_resumida      := reRecord2.situacao_resumida;
           reRecord1.numeracao_migracao     := reRecord2.numeracao_migracao||\'/\'||reRecord2.prefixo;
           reRecord1.prefixo                := reRecord2.prefixo ;
           reRecord1.pagamento              := reRecord2.pagamento;
           reRecord1.vencimento_original    := reRecord2.vencimento_original;
           reRecord1.ocorrencia_pagamento   := reRecord2.ocorrencia_pagamento;
      END LOOP;
      return next reRecord1;
    END LOOP;

            return;
        END;
        $function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_consulta_numeracao_parcela(integer, date)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $function$
DECLARE
    inCodParcela    ALIAS FOR $1;
    dtDataBase1      ALIAS FOR $2;
    dtDataBase      date;
    stSql           VARCHAR;
    reRecord        RECORD;
    stNumeracao     VARCHAR;
BEGIN

        SELECT numeracao, data_pagamento into stNumeracao, dtDataBase
          FROM arrecadacao.carne
         INNER JOIN(SELECT max(timestamp)as timestamp
                         , data_pagamento
                      FROM arrecadacao.carne
                     INNER JOIN arrecadacao.pagamento
                     USING(numeracao)
                     WHERE cod_parcela = inCodParcela
                     GROUP BY data_pagamento )as temp using(TIMESTAMP);
    IF dtDataBase IS NULL THEN
       dtDataBase := dtDataBase1;
    end if;
    stSql := \'
    SELECT
        case when ap.numeracao is not null then
            ap.numeracao::varchar
        else
            case when parcela_paga_reemissao.consultacarnepagoreemissao is not null then
                parcela_paga_reemissao.consultacarnepagoreemissao::varchar
            else
                ac.numeracao::varchar
            end
        end as numeracao,
        ac.exercicio::varchar,

        case when ap.numeracao is not null then
            case when ap.pagamento = true then
                case when arrecadacao.verificaPagUnica(\'||inCodParcela||\',\'\'\'||dtDataBase||\'\'\' ) and ( select nr_parcela from arrecadacao.parcela where cod_parcela = \'||inCodParcela||\') != 0 then
                    \'\'Pagamento Duplicado <hr> Pagamento de Cota Única ja efetuado\'\'::varchar
                else
                    case when ( select count(ac.numeracao) from arrecadacao.carne as ac
                                    INNER JOIN arrecadacao.pagamento as ap ON ap.numeracao = ac.numeracao
                                    where ac.cod_parcela = \'||inCodParcela||\'
                                    ) > 1 then
                    \'\'Pagamento Duplicado\'\'
                    else
                        case when accon.numeracao is not null then
                            ap.nom_tipo||\'\' (C)\'\'
                        else
                            ap.nom_tipo
                        end
                    end
                end
            else
                case when accon.numeracao is not null then
                    ap.nom_tipo||\'\' (C)\'\'
                else
                    ap.nom_tipo
                end
            end
        else
            case  when acd.numeracao is not null  AND acd.dt_devolucao <= \'\'\'||dtDataBase||\'\'\' then
                ( select descricao from arrecadacao.motivo_devolucao amd where amd.cod_motivo = acd.cod_motivo )::varchar
            else
                case when ( parcela_paga_reemissao.consultacarnepagoreemissao  is not null ) then
                    (   select atp2.nom_tipo
                        from arrecadacao.tipo_pagamento as atp2
                        INNER JOIN arrecadacao.pagamento as apag2 ON apag2.cod_tipo = atp2.cod_tipo
                        where apag2.numeracao = parcela_paga_reemissao.consultacarnepagoreemissao
--                      order by apag2.ocorrencia_pagamento DESC
                        limit 1
                        )::varchar
                else
                    case when apr.cod_parcela is not null and accon.numeracao is null then
                        (
                            select t.motivo || \'\'<hr>Vencimento da Reemissão: \'\' || t.dtVencR ||\'\'<br>Valor: \'\'||t.valor  from
                            (
                            select
                                (to_char(ap.vencimento,\'\'dd/mm/YYYY\'\')) as dtVencR,
                                apr.valor as ValorAntigo,
                                ( select descricao from arrecadacao.motivo_devolucao amd
                                where amd.cod_motivo = 10 ) as motivo,
                                ap.valor as valor
                            from
                                arrecadacao.parcela as ap
                            where
                                ap.cod_parcela = \'||inCodParcela||\'
                            ) as t
                        )
                    else
                        case when accon.numeracao is not null then
                            \'\'Em Aberto - (Consolidada)<hr>Numeração:
                            \'\'||accon.numeracao_consolidacao||
                            \'\'<br>Valor: R$ \'\'||par.valor||
                            \'\'<br>Vencimento Consolidação: \'\'|| to_char(par.vencimento,\'\'dd/mm/YYYY\'\') ::varchar
                        else
                            case when par.nr_parcela = 0 and baixa_manual_unica.valor = \'\'nao\'\' then
                                \'\'Parcela Única Vencida\'\'::varchar
                            else
                                \'\'Em Aberto\'\'::varchar
                            end
                        end
                    end
                end
            end
        end as situacao,

        case when ap.numeracao is not null then

            case when ap.pagamento = true then
                case when arrecadacao.verificaPagUnica(\'||inCodParcela||\',\'\'\'||dtDataBase||\'\'\' ) and ( select nr_parcela from arrecadacao.parcela where cod_parcela = \'||inCodParcela||\') != 0 then
                        \'\'Pago(!)\'\'::varchar
                else
                    case when ( select count(ac.numeracao) from arrecadacao.carne as ac
                                        INNER JOIN arrecadacao.pagamento as ap ON ap.numeracao = ac.numeracao
                                        where ac.cod_parcela = \'||inCodParcela||\'
                                    ) > 1 then
                            ( select nom_tipo||\'\'(!)\'\' from arrecadacao.tipo_pagamento where cod_tipo = ap.cod_tipo )
                    else
                        ap.nom_tipo
                    end
                end
            else
                ap.nom_resumido
            end
        else
            case when acd.numeracao is not null  AND acd.dt_devolucao <= \'\'\'||dtDataBase||\'\'\' then
                    ( select descricao_resumida from arrecadacao.motivo_devolucao amd where amd.cod_motivo = acd.cod_motivo limit 1)::varchar
            else
                case when ( parcela_paga_reemissao.consultacarnepagoreemissao  is not null ) then
                    (   select atp2.nom_resumido
                        from arrecadacao.tipo_pagamento as atp2
                        INNER JOIN arrecadacao.pagamento as apag2 ON apag2.cod_tipo = atp2.cod_tipo
                        where apag2.numeracao = parcela_paga_reemissao.consultacarnepagoreemissao
                        order by apag2.ocorrencia_pagamento DESC
                        limit 1
                        )::varchar
                else
                    case when apr.cod_parcela is not null and accon.numeracao is null then
                        case
                            when par.vencimento < \'\'\'||dtDataBase||\'\'\' then \'\'Vencida(R)\'\'::varchar
                            else \'\'Em Aberto(R)\'\'::varchar
                        end
                    else
                        case when par.vencimento < \'\'\'||dtDataBase||\'\'\' then
                            case when accon.numeracao is not null then
                                \'\'Vencida (C)\'\'::varchar
                            else
                                case when par.nr_parcela = 0 and baixa_manual_unica.valor = \'\'nao\'\' then
                                    \'\'Cancelada\'\'::varchar
                                else
                                    \'\'Vencida\'\'::varchar
                                end
                            end
                        else
                            case when accon.numeracao is not null then
                                \'\'Em Aberto (C)\'\'::varchar
                            else
                                \'\'Em Aberto\'\'::varchar
                            end
                        end
                    end
                end
            end
        end as situacao_resumida,

        acm.numeracao_migracao,
        acm.prefixo,
        (case when apr.cod_parcela is not null then
            (to_char( arrecadacao.fn_atualiza_data_vencimento(apr.vencimento),\'\'dd/mm/YYYY\'\'))::varchar
        else
            (to_char( arrecadacao.fn_atualiza_data_vencimento(par.vencimento),\'\'dd/mm/YYYY\'\'))::varchar
        end) as vencimento_original,

        ( case when parcela_paga_reemissao.consultacarnepagoreemissao is not null then
            ( select
                data_pagamento
              from
                arrecadacao.pagamento
              where
                numeracao = parcela_paga_reemissao.consultacarnepagoreemissao
              order by
                ocorrencia_pagamento desc
              limit 1
            )
          else
            ap.data_pagamento
          end
        ) as data_pagamento,

        ( case when parcela_paga_reemissao.consultacarnepagoreemissao is not null then
              ( select ocorrencia_pagamento from arrecadacao.pagamento where numeracao = parcela_paga_reemissao.consultacarnepagoreemissao order by ocorrencia_pagamento desc limit 1)
          else
              ap.ocorrencia_pagamento
          end
        ) as ocorrencia_pagamento

    FROM
        arrecadacao.carne ac

        LEFT JOIN  (
            select
                exercicio
                , valor
            from
                administracao.configuracao
            where parametro = \'\'baixa_manual_unica\'\'
        ) as baixa_manual_unica
        ON baixa_manual_unica.exercicio = ac.exercicio

        INNER JOIN (
            SELECT
                par2.cod_parcela,
                par2.cod_lancamento,
                par2.valor,
                par2.nr_parcela,
                arrecadacao.fn_atualiza_data_vencimento(par2.vencimento) as vencimento
            FROM
                (
                    select * from arrecadacao.parcela as par
                    where cod_parcela = \'||inCodParcela||\'
                ) as par2
        ) as par  ON par.cod_parcela = ac.cod_parcela

        LEFT JOIN
        (
            select apr.cod_parcela, vencimento, valor
            from arrecadacao.parcela_reemissao apr
            inner join (
                select cod_parcela, min(timestamp) as timestamp
                from arrecadacao.parcela_reemissao
                group by cod_parcela
                limit 1
                ) as apr2
                ON apr2.cod_parcela = apr.cod_parcela AND
                apr2.timestamp = apr.timestamp
                limit 1
            ) as apr
        ON apr.cod_parcela = par.cod_parcela

        LEFT JOIN (
            select
                numeracao
                , cod_convenio
                , numeracao_consolidacao
            from
                arrecadacao.carne_consolidacao
            order by
                numeracao_consolidacao DESC
            limit 1
        ) as accon
        ON accon.numeracao = ac.numeracao
        AND accon.cod_convenio = ac.cod_convenio

        LEFT JOIN (
            select
                ap.*
                , atp.pagamento
                , atp.nom_resumido
                , atp.nom_tipo
            from
                arrecadacao.pagamento ap
                INNER JOIN arrecadacao.tipo_pagamento as atp ON atp.cod_tipo = ap.cod_tipo
                AND ap.numeracao in (
                    select
                        numeracao
                    from
                        arrecadacao.carne as c
                        INNER JOIN arrecadacao.parcela as p
                        ON c.cod_parcela = p.cod_parcela
                    where
                        p.cod_parcela = \'||inCodParcela||\'
                    order by
                        c.numeracao DESC
                    --limit 1 --comentado dia 09_06_2008
                )
                order by ap.ocorrencia_pagamento desc
            limit 1
        ) as ap
        ON ap.numeracao = ac.numeracao
        AND ap.cod_convenio = ac.cod_convenio


        LEFT JOIN arrecadacao.carne_devolucao acd
        ON acd.numeracao = ac.numeracao and acd.cod_convenio = ac.cod_convenio,

        (   select * from arrecadacao.carne where cod_parcela = \'||inCodParcela||\'
            order by timestamp limit 1 ) as cantes

        LEFT JOIN arrecadacao.carne_migracao acm
            ON acm.numeracao = cantes.numeracao and acm.cod_convenio =cantes.cod_convenio

        , ( select coalesce (arrecadacao.consultaCarnePagoReemissao(  \'||inCodParcela||\' ) , null) as consultacarnepagoreemissao ) as parcela_paga_reemissao


    WHERE par.cod_parcela = \'||inCodParcela||\'

    order by
        ap.numeracao, ap.data_pagamento DESC, ap.ocorrencia_pagamento DESC, ac.timestamp DESC , acd.timestamp desc

    limit 1

        \';

    FOR reRecord IN EXECUTE stSql LOOP
        return next reRecord;
    END LOOP;

    RETURN ;
END;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.consultacarnepagoreemissao(integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
DECLARE
    stCodParcela      ALIAS FOR $1;
    stNumeracaoPaga  varchar := null;
    stRetorno        varchar := null;

BEGIN

    SELECT
        coalesce ( apag.numeracao, null )
    INTO
        stNumeracaoPaga
    FROM  (
        SELECT
            numeracao
        FROM
        arrecadacao.fn_lista_reemissoes( stCodParcela ) as
        (   cod_parcela integer,
            numeracao   varchar,
            vencimento  varchar,
            data_pagamento date,
            ocorrencia_pagamento integer
        )
    ) as carnes
    INNER JOIN arrecadacao.pagamento as apag
    ON carnes.numeracao = apag.numeracao
    ORDER BY carnes.numeracao DESC
    LIMIT 1
    ;

    IF stNumeracaoPaga IS NULL THEN
        stRetorno := null;
    ELSE
        stRetorno := stNumeracaoPaga;
    END IF;

    RETURN stRetorno;

END;
$function$
            ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.verificapagunica(integer, date)
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
DECLARE
    inCodParcela    ALIAS FOR $1;
    dtDataBase      ALIAS FOR $2;
    inCodLancamento integer;
    stNumeracao     varchar;
BEGIN
    -- lancamento da parcela
        select cod_lancamento
          into inCodLancamento
          from arrecadacao.parcela
         where cod_parcela=inCodParcela;

    -- recupera todas as parcelas unicas, e verifica se estao pagas
    select numeracao
      into stNumeracao
      from arrecadacao.pagamento
      JOIN arrecadacao.tipo_pagamento
        ON tipo_pagamento.cod_tipo  = pagamento.cod_tipo
       AND tipo_pagamento.pagamento = true
     where numeracao in (   select numeracao
                              from arrecadacao.carne
                             where cod_parcela in (     select cod_parcela
                                                          from arrecadacao.parcela
                                                         where nr_parcela = 0
                                                           and cod_lancamento = inCodLancamento
                                                  )
                        )
       and data_pagamento < dtDataBase;
    if stNumeracao is not null then
        return true;
    else
        return false;
    end if ;
END;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_lista_reemissoes(integer)
 RETURNS SETOF record
 LANGUAGE plpgsql
AS $function$
DECLARE
   inCodParcela         ALIAS FOR $1;
   stSql                VARCHAR;
   reRecord1            RECORD;
BEGIN

    stSql := \'
               SELECT c.cod_parcela
                    , c.numeracao
                    , r.vencimento
                    , ( select data_pagamento from arrecadacao.pagamento
                        where numeracao = c.numeracao
                        order by ocorrencia_pagamento desc
                        limit 1
                    ) as data_pagamento
                    , ( select ocorrencia_pagamento from arrecadacao.pagamento
                        where numeracao = c.numeracao
                        order by ocorrencia_pagamento desc
                        limit 1
                    )::integer as ocorrencia_pagamento
                 from (    select (to_char(vencimento,\'\'dd/mm/YYYY\'\'))::varchar as vencimento
                                , timestamp
                             from arrecadacao.parcela_reemissao
                            where cod_parcela= \'||inCodParcela||\'
                         order by timestamp desc
                      ) as r
                    , (    select cod_parcela
                                , numeracao
                                , timestamp
                             from arrecadacao.carne
                            where cod_parcela=\'||inCodParcela||\'
                         order by timestamp desc
                                , numeracao desc
                           offset 1
                      ) as c
               UNION
               SELECT p.cod_parcela
                    , c.numeracao
                    , p.vencimento
                    , ( select data_pagamento from arrecadacao.pagamento
                        where numeracao = c.numeracao
                        order by ocorrencia_pagamento desc
                        limit 1
                    ) as data_pagamento
                    , ( select ocorrencia_pagamento from arrecadacao.pagamento
                        where numeracao = c.numeracao
                        order by ocorrencia_pagamento desc
                        limit 1
                    )::integer as ocorrencia_pagamento
                 from ( select (to_char(vencimento,\'\'dd/mm/YYYY\'\'))::varchar as vencimento
                                , cod_parcela
                             from arrecadacao.parcela
                            where cod_parcela=\'||inCodParcela||\'
                      ) as p
                    , (    select cod_parcela
                                , numeracao
                                , timestamp
                             from arrecadacao.carne
                            where cod_parcela=\'||inCodParcela||\'
                         order by timestamp desc
                                , numeracao desc
                            limit 1
                           offset 0
                      ) as c

        \';


    FOR reRecord1 IN EXECUTE stSql LOOP
      return next reRecord1;
    END LOOP;

    return;
END;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.buscavalororiginalparcela(character varying)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$

DECLARE
    inNumeracao     ALIAS FOR $1;
    nuValor         numeric;

BEGIN
    -- Verifica se a parcela possui desconto
nuValor := null;

    SELECT
        apd.valor
    INTO
        nuValor
    FROM
        arrecadacao.parcela_desconto as apd
        INNER JOIN arrecadacao.carne as ac
        ON ac.cod_parcela = apd.cod_parcela
    WHERE
        apd.cod_parcela is not null and
        ac.numeracao = inNumeracao;


    IF ( nuValor IS NULL ) THEN
        SELECT
            case when apr.valor is not null then
                apr.valor
            else
                ap.valor
            end
        INTO
            nuValor
        FROM
            arrecadacao.parcela as ap
            INNER JOIN arrecadacao.carne as ac
            ON ac.cod_parcela = ap.cod_parcela
            LEFT JOIN
            (
                select apr.cod_parcela, valor
                from arrecadacao.parcela_reemissao apr
                inner join (
                    select cod_parcela, min(timestamp) as timestamp
                    from arrecadacao.parcela_reemissao
                    group by cod_parcela
                    ) as apr2
                    ON apr2.cod_parcela = apr.cod_parcela AND
                    apr2.timestamp = apr.timestamp
                ) as apr
            ON apr.cod_parcela = ap.cod_parcela
        WHERE
            ac.numeracao = inNumeracao;
    END IF;

    return nuValor;
end;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_percentual_desconto_parcela(integer, date, integer)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$
declare
    inCodParcela    ALIAS FOR $1;
    dtDataCalculo   ALIAS FOR $2;
    inExercicio        ALIAS FOR $3;
    nuRetorno       numeric;
    nuOriginal      numeric;
    nuDesconto      numeric;
    nuDescontoO     numeric;
begin
-- Valor Original
select valor into nuOriginal  from arrecadacao.parcela where cod_parcela = inCodParcela;
select valor into nuDescontoO from arrecadacao.parcela_desconto where cod_parcela = inCodParcela;
-- Valor Desconto

    SELECT
        sum(alc.valor)
    INTO
        nuDesconto
    FROM
        arrecadacao.lancamento_calculo alc
        INNER JOIN arrecadacao.calculo as calc ON calc.cod_calculo = alc.cod_calculo
        INNER JOIN arrecadacao.calculo_grupo_credito cgc ON cgc.cod_calculo = alc.cod_calculo
        INNER JOIN arrecadacao.credito_grupo cg ON cg.cod_credito = calc.cod_credito
                                                                                AND cgc.cod_grupo = cg.cod_grupo
                                                                                AND cgc.ano_exercicio = cg.ano_exercicio
    WHERE
        alc.cod_lancamento in (  select cod_lancamento
                                                from arrecadacao.parcela
                                                where cod_parcela = inCodParcela )
       and cg.desconto = true
       and cg.ano_exercicio = quote_literal(inExercicio);


if ( nuOriginal > nuDescontoO ) and (nuDesconto > 0) and (nuOriginal > 0)then
    nuRetorno := arrecadacao.fn_juro_multa_aplicado_reemissao(nuDesconto,nuDesconto+(nuOriginal-nuDescontoO));
else
    nuRetorno := NULL;
end if;

    return coalesce(nuRetorno,0.00);
    --
end;
$function$
        ');

        $this->addSql('CREATE OR REPLACE FUNCTION public.fn_multa_2_porcento_mariana(date, date, numeric, integer, integer)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$

    DECLARE
        dtVencimento    ALIAS FOR $1;
        dtDataCalculo   ALIAS FOR $2;
        flCorrigido     ALIAS FOR $3;
        inCodAcrescimo  ALIAS FOR $4;
        inCodTipo       ALIAS FOR $5;
        flCorrecao      NUMERIC;
        flMulta         NUMERIC;
        inDiff          INTEGER;
        inDiffMes       INTEGER;
    BEGIN

        flCorrecao:=fn_correcao_mariana(dtVencimento,dtDataCalculo,flCorrigido,5,1);
        -- recupera diferença em dias das datas
        inDiffMes := diff_datas_em_meses(dtVencimento,dtDataCalculo);
        IF ( inDiffMes = 0 ) THEN
            inDiffMes := inDiffMes + 0;
        ELSE
            inDiffMes := inDiffMes + 1;
        END IF;

--caso o vencimento seja anterior a 2004 a multa passa a ser de 2 por cento ao mes até o fonal de 2003
        IF (dtVencimento < \'2004-01-01\'::date) THEN
           --inDiffMes := inDiffMes*2;
           inDiffMes := (diff_datas_em_meses(dtVencimento,\'2003-12-31\'::date)*2) + diff_datas_em_meses(\'2003-12-31\'::date,dtDataCalculo);
        END IF;

        inDiff := diff_datas_em_dias( dtVencimento, dtDataCalculo );
        flMulta := 0.00;

        IF dtVencimento <= dtDataCalculo::date  THEN
            IF ( inDiff > 0 ) THEN
                flMulta := ( (flCorrigido + flCorrecao) * inDiffMes ) / 100;
            END IF;
        END IF;

        RETURN flMulta::numeric(14,2);
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
