CREATE VIEW orcamento.vw_classificacao_despesa AS
    SELECT c.exercicio
    , c.cod_conta
    , c.descricao
    , orcamento.fn_consulta_class_despesa(c.cod_conta, c.exercicio::VARCHAR, (
      (
        SELECT configuracao.valor
        FROM administracao.configuracao
        WHERE configuracao.cod_modulo = 8
          AND configuracao.parametro::TEXT = 'masc_class_despesa'::TEXT
          AND configuracao.exercicio = c.exercicio
        )
      )::VARCHAR) AS mascara_classificacao
    FROM orcamento.conta_despesa c;
