CREATE VIEW orcamento.vw_classificacao_receita AS
    SELECT c.exercicio,
        c.cod_conta,
        c.descricao,
        c.cod_estrutural AS mascara_classificacao
    FROM orcamento.conta_receita c;