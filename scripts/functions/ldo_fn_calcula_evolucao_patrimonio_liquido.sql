CREATE OR REPLACE FUNCTION ldo.fn_calcula_evolucao_patrimonio_liquido(character varying, character, boolean)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$
DECLARE
    stCodReduzido       ALIAS FOR $1;
    stExercicio         ALIAS FOR $2;
    boRPPS              ALIAS FOR $3;

    stSql               VARCHAR;
    stSqlAux            VARCHAR;
    stFiltro            VARCHAR;
    inCodEntidadeRPPS   INTEGER;

    nuTotal             NUMERIC(14,2);
    inIdentificador     INTEGER;

    reRecord            RECORD;
BEGIN

    ----------------------------------------
    -- adiciona o filtro do cod. reduzido --
    ----------------------------------------
    stFiltro := ' cod_estrutural LIKE ''' || stCodReduzido || '%' || ''' ';

    -----------------------------
    -- procura a entidade RPPS --
    -----------------------------
    SELECT valor
      INTO inCodEntidadeRPPS
      FROM administracao.configuracao
INNER JOIN ( SELECT MAX(exercicio) AS exercicio 
                  , cod_modulo
                  , parametro
               FROM administracao.configuracao
              WHERE parametro =  'cod_entidade_rpps'
           GROUP BY cod_modulo
                  , parametro
           ) AS configuracao_max
        ON configuracao_max.exercicio  = configuracao.exercicio
       AND configuracao_max.cod_modulo = configuracao.cod_modulo
       AND configuracao_max.parametro  = configuracao.parametro
     WHERE configuracao.parametro = 'cod_entidade_rpps';

    ----------------------------------------------------------------------------------
    -- se a entidade for RPPS traz somente ela caso contrario traz todas exceto ela --
    ----------------------------------------------------------------------------------
    IF(boRPPS IS TRUE) 
    THEN
        stFiltro := stFiltro || ' AND cod_entidade IN (' || inCodEntidadeRPPS || ')';
    ELSE
        stFiltro := stFiltro || '  AND cod_entidade NOT IN (' || inCodEntidadeRPPS || ')';
    END IF;
    
    --------------------------------------------------------------------
    -- verifica se a sequence calcula_evolucao_patrimonio_liquido existe --
    --------------------------------------------------------------------
    IF((SELECT 1 FROM pg_catalog.pg_statio_user_sequences WHERE relname='calcula_evolucao_patrimonio_liquido') IS NOT NULL)
    THEN
        SELECT NEXTVAL('ldo.calcula_evolucao_patrimonio_liquido')
          INTO inIdentificador;
    ELSE
        CREATE SEQUENCE ldo.calcula_evolucao_patrimonio_liquido START 1;
        SELECT NEXTVAL('ldo.calcula_evolucao_patrimonio_liquido')
          INTO inIdentificador;
    END IF;


    ------------------------------------------------------
    -- cria a tabela temporaria para guardar os valores --
    ------------------------------------------------------
    stSql := '
    CREATE TEMPORARY TABLE tmp_valores_' || inIdentificador || ' AS
        SELECT *
          FROM ( SELECT plano_conta.cod_estrutural
                      , valor_lancamento.tipo_valor
                      , valor_lancamento.vl_lancamento
                      , valor_lancamento.cod_entidade
                      , lote.exercicio
                      , lote.tipo
                   FROM contabilidade.plano_conta
             INNER JOIN contabilidade.plano_analitica
                     ON plano_conta.cod_conta = plano_analitica.cod_conta
                    AND plano_conta.exercicio = plano_analitica.exercicio
                    AND plano_analitica.exercicio = ''' || stExercicio || '''
             INNER JOIN contabilidade.conta_debito
                     ON plano_analitica.cod_plano = conta_debito.cod_plano
                    AND plano_analitica.exercicio = conta_debito.exercicio
             INNER JOIN contabilidade.valor_lancamento
                     ON conta_debito.cod_lote     = valor_lancamento.cod_lote
                    AND conta_debito.tipo         = valor_lancamento.tipo
                    AND conta_debito.sequencia    = valor_lancamento.sequencia
                    AND conta_debito.exercicio    = valor_lancamento.exercicio
                    AND conta_debito.tipo_valor   = valor_lancamento.tipo_valor
                    AND conta_debito.cod_entidade = valor_lancamento.cod_entidade
             INNER JOIN contabilidade.lancamento
                     ON valor_lancamento.cod_lote     = lancamento.cod_lote
                    AND valor_lancamento.tipo         = lancamento.tipo
                    AND valor_lancamento.sequencia    = lancamento.sequencia
                    AND valor_lancamento.exercicio    = lancamento.exercicio
                    AND valor_lancamento.cod_entidade = lancamento.cod_entidade
                    AND valor_lancamento.tipo_valor   = ''D''
             INNER JOIN contabilidade.lote
                     ON lancamento.cod_lote     = lote.cod_lote
                    AND lancamento.exercicio    = lote.exercicio
                    AND lancamento.tipo         = lote.tipo
                    AND lancamento.cod_entidade = lote.cod_entidade

               ORDER BY plano_conta.cod_estrutural
               ) AS tabela
         WHERE ' || stFiltro || '

         UNION

        SELECT *
          FROM ( SELECT plano_conta.cod_estrutural
                      , valor_lancamento.tipo_valor
                      , valor_lancamento.vl_lancamento
                      , valor_lancamento.cod_entidade
                      , lote.exercicio
                      , lote.tipo
                   FROM contabilidade.plano_conta
             INNER JOIN contabilidade.plano_analitica
                     ON plano_conta.cod_conta = plano_analitica.cod_conta
                    AND plano_conta.exercicio = plano_analitica.exercicio
                    AND plano_analitica.exercicio = ''' || stExercicio || '''
             INNER JOIN contabilidade.conta_credito
                     ON plano_analitica.cod_plano = conta_credito.cod_plano
                    AND plano_analitica.exercicio = conta_credito.exercicio
             INNER JOIN contabilidade.valor_lancamento
                     ON conta_credito.cod_lote     = valor_lancamento.cod_lote
                    AND conta_credito.tipo         = valor_lancamento.tipo
                    AND conta_credito.sequencia    = valor_lancamento.sequencia
                    AND conta_credito.exercicio    = valor_lancamento.exercicio
                    AND conta_credito.tipo_valor   = valor_lancamento.tipo_valor
                    AND conta_credito.cod_entidade = valor_lancamento.cod_entidade
             INNER JOIN contabilidade.lancamento
                     ON valor_lancamento.cod_lote     = lancamento.cod_lote
                    AND valor_lancamento.tipo         = lancamento.tipo
                    AND valor_lancamento.sequencia    = lancamento.sequencia
                    AND valor_lancamento.exercicio    = lancamento.exercicio
                    AND valor_lancamento.cod_entidade = lancamento.cod_entidade
                    AND valor_lancamento.tipo_valor   = ''C''
             INNER JOIN contabilidade.lote
                     ON lancamento.cod_lote     = lote.cod_lote
                    AND lancamento.exercicio    = lote.exercicio
                    AND lancamento.tipo         = lote.tipo
                    AND lancamento.cod_entidade = lote.cod_entidade

               ORDER BY plano_conta.cod_estrutural
               ) AS tabela
         WHERE ' || stFiltro;

    EXECUTE stSql;

    --------------------------------------------------------------
    -- calcula o valor total (saldo inicial) + debito - credito --
    --------------------------------------------------------------
    stSql := '
    SELECT COALESCE(( SELECT SUM(vl_lancamento)
               FROM tmp_valores_' || inIdentificador || '
              WHERE tipo = ''I'' ),0)
          +COALESCE(( SELECT SUM(vl_lancamento)
               FROM tmp_valores_' || inIdentificador || '
              WHERE tipo_valor = ''D'' AND tipo <> ''I'' ),0)
          -COALESCE(( SELECT SUM(vl_lancamento)
               FROM tmp_valores_' || inIdentificador || '
              WHERE tipo_valor = ''C'' AND tipo <> ''I''),0)';

    EXECUTE stSql INTO nuTotal;
           
    EXECUTE 'DROP TABLE tmp_valores_' || inIdentificador;

    RETURN nuTotal;

END;

$function$
