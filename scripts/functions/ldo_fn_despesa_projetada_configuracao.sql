CREATE OR REPLACE FUNCTION ldo.fn_despesa_projetada_configuracao(
    integer,
    character)
  RETURNS SETOF record
  LANGUAGE plpgsql
 AS $BODY$
DECLARE
    inCodPPA            ALIAS FOR $1;
    stExercicio         ALIAS FOR $2;

    stExercicioInicial  VARCHAR;
    stSql               VARCHAR;
    stSqlAux            VARCHAR;

    reRecord            RECORD;

    flValor_1           NUMERIC(14,2) := 0;
    flValor_2           NUMERIC(14,2) := 0;
    flValor_3           NUMERIC(14,2) := 0;
    flValor_4           NUMERIC(14,2) := 0;

    boOrcamento_1       NUMERIC(1) := 0;
    boOrcamento_2       NUMERIC(1) := 0;
    boOrcamento_3       NUMERIC(1) := 0;
    boOrcamento_4       NUMERIC(1) := 0;

BEGIN
    stExercicioInicial := TRIM(TO_CHAR((TO_NUMBER(stExercicio,'9999') - 4),'9999'));

    -----------------------------------------
    -- cria a tabela temporaria de retorno --
    -----------------------------------------
    CREATE TEMPORARY TABLE tmp_retorno (
        cod_tipo         INTEGER,
        exercicio        VARCHAR(4),
        cod_estrutural   VARCHAR,
        descricao        VARCHAR,
        tipo             CHAR(1),
        nivel            NUMERIC(1),
        rpps             NUMERIC(1),
        orcamento_1      NUMERIC(1),
        orcamento_2      NUMERIC(1),
        orcamento_3      NUMERIC(1),
        orcamento_4      NUMERIC(1),
        valor_1          NUMERIC(14,2),
        valor_2          NUMERIC(14,2),
        valor_3          NUMERIC(14,2),
        valor_4          NUMERIC(14,2)
    );


    --------------------------------------------------------
    -- recupera os tipos de despesas que vao no relatorio --
    --------------------------------------------------------
    stSql := 'SELECT *
                   , publico.fn_mascarareduzida(cod_estrutural) AS estrutural_reduzido
                FROM ldo.tipo_receita_despesa
               WHERE tipo = ''D''
                 AND nivel = 1
            ORDER BY cod_tipo ';

    FOR reRecord IN EXECUTE stSql
    LOOP
        SELECT SUM(vl_projetado)
          INTO flValor_1
          FROM ldo.configuracao_receita_despesa
         WHERE configuracao_receita_despesa.cod_ppa   = inCodPPA
           AND configuracao_receita_despesa.cod_tipo  = reRecord.cod_tipo
           AND configuracao_receita_despesa.tipo      = reRecord.tipo
           AND configuracao_receita_despesa.exercicio = TO_NUMBER(stExercicio,'9999')::varchar;

        SELECT SUM(vl_projetado)
          INTO flValor_2
          FROM ldo.configuracao_receita_despesa
         WHERE configuracao_receita_despesa.cod_ppa   = inCodPPA
           AND configuracao_receita_despesa.cod_tipo  = reRecord.cod_tipo
           AND configuracao_receita_despesa.tipo      = reRecord.tipo
           AND configuracao_receita_despesa.exercicio = (TO_NUMBER(stExercicio,'9999') + 1)::varchar;

        SELECT SUM(vl_projetado)
          INTO flValor_3
          FROM ldo.configuracao_receita_despesa
         WHERE configuracao_receita_despesa.cod_ppa   = inCodPPA
           AND configuracao_receita_despesa.cod_tipo  = reRecord.cod_tipo
           AND configuracao_receita_despesa.tipo      = reRecord.tipo
           AND configuracao_receita_despesa.exercicio = (TO_NUMBER(stExercicio,'9999') + 2)::varchar;

        SELECT SUM(vl_projetado)
          INTO flValor_4
          FROM ldo.configuracao_receita_despesa
         WHERE configuracao_receita_despesa.cod_ppa   = inCodPPA
           AND configuracao_receita_despesa.cod_tipo  = reRecord.cod_tipo
           AND configuracao_receita_despesa.tipo      = reRecord.tipo
           AND configuracao_receita_despesa.exercicio = (TO_NUMBER(stExercicio,'9999') + 3)::varchar;

        -------------------------------------------------------------------------------------
        -- insere na tabela de retorno o somatorio do valor dos estruturais para os 4 anos --
        -------------------------------------------------------------------------------------
        INSERT INTO tmp_retorno VALUES( reRecord.cod_tipo
                                       ,stExercicio
                                       ,reRecord.cod_estrutural
                                       ,reRecord.descricao
                                       ,reRecord.tipo
                                       ,reRecord.nivel
                                       ,CASE WHEN (reRecord.rpps IS TRUE)
                                             THEN 1
                                             ELSE 0
                                        END
                                       ,boOrcamento_1
                                       ,boOrcamento_2
                                       ,boOrcamento_3
                                       ,boOrcamento_4
                                       ,flValor_1
                                       ,flValor_2
                                       ,flValor_3
                                       ,flValor_4);


    END LOOP;

    ----------------------------------------------------------
    -- insere na tabela de retorno o somatorio dos niveis 0 --
    ----------------------------------------------------------
    stSql := ' SELECT publico.fn_mascarareduzida(cod_estrutural) AS estrutural_reduzido
                    , *
                 FROM ldo.tipo_receita_despesa
                WHERE nivel = 0
                  AND tipo = ''D''
             ORDER BY cod_tipo';

    FOR reRecord IN EXECUTE stSql
    LOOP
        SELECT SUM(COALESCE(valor_1,0))
          INTO flValor_1
          FROM tmp_retorno
         WHERE cod_estrutural LIKE reRecord.estrutural_reduzido || '%'
           AND nivel = 1;

        SELECT SUM(COALESCE(valor_2,0))
          INTO flValor_2
          FROM tmp_retorno
         WHERE cod_estrutural LIKE reRecord.estrutural_reduzido || '%'
           AND nivel = 1;

        SELECT SUM(COALESCE(valor_3,0))
          INTO flValor_3
          FROM tmp_retorno
         WHERE cod_estrutural LIKE reRecord.estrutural_reduzido || '%'
           AND nivel = 1;

        SELECT SUM(COALESCE(valor_4,0))
          INTO flValor_4
          FROM tmp_retorno
         WHERE cod_estrutural LIKE reRecord.estrutural_reduzido || '%'
           AND nivel = 1;

        INSERT INTO tmp_retorno ( SELECT reRecord.cod_tipo
                                       , stExercicio
                                       , reRecord.cod_estrutural
                                       , reRecord.descricao
                                       , reRecord.tipo
                                       , reRecord.nivel
                                       , CASE WHEN (reRecord.rpps IS TRUE)
                                             THEN 1
                                             ELSE 0
                                         END
                                       , boOrcamento_1
                                       , boOrcamento_2
                                       , boOrcamento_3
                                       , boOrcamento_4
                                       , flValor_1
                                       , flValor_2
                                       , flValor_3
                                       , flValor_4);
    END LOOP;

    ------------------------
    -- retorna os valores --
    ------------------------

    stSql := ' SELECT cod_tipo
                    , exercicio
                    , cod_estrutural
                    , descricao
                    , tipo
                    , nivel
                    , rpps
                    , orcamento_1
                    , orcamento_2
                    , orcamento_3
                    , orcamento_4
                    , COALESCE(valor_1,0)
                    , COALESCE(valor_2,0)
                    , COALESCE(valor_3,0)
                    , COALESCE(valor_4,0)
                 FROM tmp_retorno
             ORDER BY cod_tipo';

    FOR reRecord IN EXECUTE stSql
    LOOP
        RETURN NEXT reRecord;
    END LOOP;

    DROP TABLE tmp_retorno;

END;

$BODY$
