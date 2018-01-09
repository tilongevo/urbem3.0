-- Function: orcamento.fn_totaliza_suplementacao(character varying, integer)

-- DROP FUNCTION orcamento.fn_totaliza_suplementacao(character varying, integer);

CREATE OR REPLACE FUNCTION orcamento.fn_totaliza_suplementacao(
    character varying,
    integer)
  RETURNS numeric AS
$BODY$
DECLARE
    stExercicio         ALIAS FOR $1;
    inCodSuplementacao  ALIAS FOR $2;
    stSql               VARCHAR := '''';
    nuSoma              NUMERIC := 0;
    reRegistro          RECORD;
    crCursor            REFCURSOR;

BEGIN
    stSql := '
            SELECT
                (SELECT
                    sum(SS.valor) as suplementado
                FROM
                    orcamento.suplementacao S
                    LEFT JOIN orcamento.suplementacao_suplementada SS ON
                        SS.cod_suplementacao = S.cod_suplementacao AND
                        SS.exercicio = S.exercicio
                WHERE
                    S.cod_tipo <> 16 AND
                    S.exercicio = ' || quote_literal(stExercicio) || ' AND
                    S.cod_suplementacao = ' || inCodSuplementacao || '
                ) as suplementado --,
--                (SELECT
--                    sum(SR.valor) as reduzido
--                FROM
--                    orcamento.suplementacao S
--                    LEFT JOIN orcamento.suplementacao_reducao SR ON
--                        SR.cod_suplementacao = S.cod_suplementacao AND
--                        SR.exercicio = S.exercicio
--                WHERE
--                    S.cod_tipo <> 16 AND
--                    S.exercicio = '' || stExercicio || '' AND
--                    S.cod_suplementacao = '' || inCodSuplementacao || ''
--                ) as reduzido
                ';

    OPEN crCursor FOR EXECUTE stSql;
    FETCH crCursor INTO reRegistro;
    CLOSE crCursor;

--    nuSoma := coalesce(reRegistro.suplementado,0.00) - coalesce(reRegistro.reduzido,0.00);
    nuSoma := coalesce(reRegistro.suplementado,0.00);

    RETURN nuSoma;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION orcamento.fn_totaliza_suplementacao(character varying, integer)
  OWNER TO postgres;
GRANT EXECUTE ON FUNCTION orcamento.fn_totaliza_suplementacao(character varying, integer) TO postgres;
GRANT EXECUTE ON FUNCTION orcamento.fn_totaliza_suplementacao(character varying, integer) TO public;
