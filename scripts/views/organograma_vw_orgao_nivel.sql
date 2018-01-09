CREATE OR REPLACE VIEW organograma.vw_orgao_nivel AS
  SELECT
    o.cod_orgao,
    o.num_cgm_pf,
    o.cod_calendar,
    o.cod_norma,
    o.criacao,
    o.inativacao,
    o.sigla_orgao,
    od.descricao,
    orn.cod_organograma,
    organograma.fn_consulta_orgao(orn.cod_organograma, o.cod_orgao)                             AS orgao,
    publico.fn_mascarareduzida(organograma.fn_consulta_orgao(orn.cod_organograma, o.cod_orgao)) AS orgao_reduzido,
    publico.fn_nivel(organograma.fn_consulta_orgao(orn.cod_organograma, o.cod_orgao))           AS nivel
  FROM organograma.orgao o
    INNER JOIN organograma.orgao_nivel orn ON o.cod_orgao = orn.cod_orgao
    INNER JOIN organograma.orgao_descricao od ON o.cod_orgao = od.cod_orgao
  GROUP BY orn.cod_organograma, o.cod_orgao, o.num_cgm_pf, o.cod_calendar, o.cod_norma, o.criacao, o.inativacao,
    o.sigla_orgao, od.descricao
  ORDER BY o.cod_orgao;
