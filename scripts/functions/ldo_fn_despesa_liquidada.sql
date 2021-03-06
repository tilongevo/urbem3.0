CREATE OR REPLACE FUNCTION ldo.fn_despesa_liquidada(
    character varying,
    character varying,
    boolean,
    character varying)
  RETURNS numeric
  LANGUAGE plpgsql
 AS $BODY$
DECLARE
    stMascRed   ALIAS FOR $1;
    stExercicio ALIAS FOR $2;
    boRPPS      ALIAS FOR $3;
    stFiltro    ALIAS FOR $4;

	stSQL 		VARCHAR;
	reReg 		RECORD;
	nuLiquidado NUMERIC(14,2);
	nuEstornado	NUMERIC(14,2);
	nuTotal     NUMERIC(14,2);
    crCursor 	REFCURSOR;

BEGIN

    stSql := '
	    SELECT SUM(COALESCE(vl_total,0)) AS vl_total
          FROM empenho.pre_empenho
     LEFT JOIN ( SELECT pre_empenho_despesa.exercicio
                      , pre_empenho_despesa.cod_pre_empenho
                      , conta_despesa.cod_estrutural
                   FROM orcamento.conta_despesa
             INNER JOIN empenho.pre_empenho_despesa
                     ON pre_empenho_despesa.cod_conta   = conta_despesa.cod_conta
                    AND pre_empenho_despesa.exercicio   = conta_despesa.exercicio
             INNER JOIN orcamento.despesa
                     ON pre_empenho_despesa.cod_despesa = despesa.cod_despesa
                    AND pre_empenho_despesa.exercicio   = despesa.exercicio
                  WHERE pre_empenho_despesa.exercicio = ''' || stExercicio || '''';
    IF boRPPS = TRUE THEN
        stSql := stSql || ' AND despesa.cod_recurso = 50 ';
    ELSE
        stSql := stSql || ' AND despesa.cod_recurso <> 50 ';
    END IF;
    stSql := stSql || '
               ) AS pre_empenho_despesa
            ON pre_empenho.exercicio       = pre_empenho_despesa.exercicio
           AND pre_empenho.cod_pre_empenho = pre_empenho_despesa.cod_pre_empenho
	INNER JOIN empenho.empenho
	        ON empenho.exercicio = pre_empenho.exercicio
	       AND empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
	INNER JOIN empenho.nota_liquidacao
	        ON nota_liquidacao.exercicio_empenho = empenho.exercicio
	       AND nota_liquidacao.cod_entidade      = empenho.cod_entidade
	       AND nota_liquidacao.cod_empenho       = empenho.cod_empenho
	INNER JOIN empenho.nota_liquidacao_item
	        ON nota_liquidacao_item.exercicio    = nota_liquidacao.exercicio
	       AND nota_liquidacao_item.cod_entidade = nota_liquidacao.cod_entidade
	       AND nota_liquidacao_item.cod_nota     = nota_liquidacao.cod_nota
         WHERE empenho.exercicio = ''' || stExercicio || '''
           AND TO_CHAR(nota_liquidacao.dt_liquidacao,''yyyy'') = ''' || stExercicio || '''
           AND pre_empenho_despesa.cod_estrutural LIKE ''' || stMascRed || '%''
           ' || stFiltro || ' ';


    OPEN crCursor FOR EXECUTE stSql;
    	FETCH crCursor INTO nuLiquidado;
    CLOSE crCursor;

    stSql := '
	    SELECT SUM(COALESCE(vl_anulado,0)) AS valor
          FROM empenho.pre_empenho
     LEFT JOIN ( SELECT pre_empenho_despesa.exercicio
                      , pre_empenho_despesa.cod_pre_empenho
                      , conta_despesa.cod_estrutural
                   FROM orcamento.conta_despesa
             INNER JOIN empenho.pre_empenho_despesa
                     ON pre_empenho_despesa.cod_conta   = conta_despesa.cod_conta
                    AND pre_empenho_despesa.exercicio   = conta_despesa.exercicio
             INNER JOIN orcamento.despesa
                     ON pre_empenho_despesa.cod_despesa = despesa.cod_despesa
                    AND pre_empenho_despesa.exercicio   = despesa.exercicio
                  WHERE pre_empenho_despesa.exercicio = ''' || stExercicio || '''';
    IF boRPPS = TRUE THEN
        stSql := stSql || ' AND despesa.cod_recurso = 50 ';
    ELSE
        stSql := stSql || ' AND despesa.cod_recurso <> 50 ';
    END IF;
    stSql := stSql || '
               ) AS pre_empenho_despesa
            ON pre_empenho.exercicio       = pre_empenho_despesa.exercicio
           AND pre_empenho.cod_pre_empenho = pre_empenho_despesa.cod_pre_empenho
	INNER JOIN empenho.empenho
	        ON empenho.exercicio = pre_empenho.exercicio
	       AND empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho
	INNER JOIN empenho.nota_liquidacao
	        ON nota_liquidacao.exercicio_empenho = empenho.exercicio
	       AND nota_liquidacao.cod_entidade      = empenho.cod_entidade
	       AND nota_liquidacao.cod_empenho       = empenho.cod_empenho
	INNER JOIN empenho.nota_liquidacao_item
	        ON nota_liquidacao_item.exercicio    = nota_liquidacao.exercicio
	       AND nota_liquidacao_item.cod_entidade = nota_liquidacao.cod_entidade
	       AND nota_liquidacao_item.cod_nota     = nota_liquidacao.cod_nota
    INNER JOIN empenho.nota_liquidacao_item_anulado
            ON nota_liquidacao_item.exercicio       = nota_liquidacao_item_anulado.exercicio
           AND nota_liquidacao_item.cod_nota        = nota_liquidacao_item_anulado.cod_nota
           AND nota_liquidacao_item.cod_entidade    = nota_liquidacao_item_anulado.cod_entidade
           AND nota_liquidacao_item.num_item        = nota_liquidacao_item_anulado.num_item
           AND nota_liquidacao_item.cod_pre_empenho = nota_liquidacao_item_anulado.cod_pre_empenho
           AND nota_liquidacao_item.exercicio_item  = nota_liquidacao_item_anulado.exercicio_item
         WHERE empenho.exercicio = ''' || stExercicio || '''
           AND TO_CHAR(nota_liquidacao_item_anulado.timestamp,''yyyy'') = ''' || stExercicio || '''
           AND pre_empenho_despesa.cod_estrutural LIKE ''' || stMascRed || '%''
           ' || stFiltro || ' ';

    OPEN crCursor FOR EXECUTE stSql;
    	FETCH crCursor INTO nuEstornado;
    CLOSE crCursor;

	nuTotal := COALESCE(nuLiquidado,0) - COALESCE(nuEstornado,0);

	if (nuTotal is null) then
		nuTotal := 0.00;
	end if;

    RETURN nuTotal;

END;

$BODY$
