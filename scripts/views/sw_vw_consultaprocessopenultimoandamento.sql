CREATE VIEW sw_vw_consultaprocessopenultimoandamento AS
    SELECT p.cod_processo                                       AS codprocesso
         , p.ano_exercicio                                      AS exercicio
         , p.cod_situacao                                       AS codsituacao
         , sw_situacao_processo.nom_situacao                    AS nomsituacao
         , p.cp_timestamp                                        AS datainclusao
         , p.cod_usuario                                        AS codusuarioinclusao
         , sw_usuario_inclusao.username                         AS usuarioinclusao
         , p.numcgm                                             AS codinteressado
         , sw_cgm.nom_cgm                                       AS nominteressado
         , p.cod_classificacao                                  AS codclassificacao
         , sw_classificacao.nom_classificacao                   AS nomclassificacao
         , p.cod_assunto                                        AS codassunto
         , sw_assunto.nom_assunto                               AS nomassunto
         , CASE
               WHEN sw_assinatura_digital.cod_andamento IS NULL THEN 'Off-Line'::character varying
               ELSE sw_usuario_assinatura_digital.username
           END                                                  AS usuariorecebimento
         , CASE
               WHEN sw_assinatura_digital.cod_usuario IS NULL THEN 0
               ELSE sw_assinatura_digital.cod_usuario
           END                                                  AS codusuariorecebimento
         , sw_recebimento.cp_timestamp                           AS datarecebimento
         , CASE
               WHEN sw_recebimento.cp_timestamp IS NULL THEN 'f'::text
               ELSE 't'::text
           END                                                  AS recebido
         , sw_penultimo_andamento.cod_andamento                 AS codpenultimoandamento
         , sw_penultimo_andamento.cod_usuario                   AS codusuariopenultimoandamento
         , sw_usuario_penultimo_andamento.username              AS usuariopenultimoandamento
         , sw_penultimo_andamento.cod_orgao                     AS codpenultimoorgao
--       , sw_penultimo_andamento.cod_unidade                   AS codpenultimounidade
--       , sw_penultimo_andamento.cod_departamento              AS codpenultimodepartamento
--       , sw_penultimo_andamento.cod_setor                     AS codpenultimosetor
--       , sw_setor_penultimo_andamento.nom_setor               AS nompenultimosetor
         , sw_penultimo_andamento.cp_timestamp                   AS datapenultimoandamento
         , sw_processo_apensado.cod_processo_pai                AS codprocessoapensado
         , sw_processo_apensado.exercicio_pai                   AS exercicioprocessoapensado
         , CASE
               WHEN sw_processo_apensado.cod_processo_filho IS NULL THEN 'f'::text
               ELSE 't'::text
           END                                                  AS apensado
         , CASE
               WHEN sw_processo_arquivado.cod_processo IS NULL THEN 'f'::text
               ELSE 't'::text
           END                                                  AS arquivado
         , sw_historico_arquivamento.nom_historico              AS nomhistoricoarquivamento
         , sw_recibo_impresso.cod_recibo                        AS numreciboimpresso
      FROM sw_processo p
 LEFT JOIN (
               SELECT max(sw_andamento.cod_andamento) - 1       AS cod_andamento
                    , sw_andamento.cod_processo
                    , sw_andamento.ano_exercicio
                 FROM sw_andamento
             GROUP BY sw_andamento.cod_processo
                    , sw_andamento.ano_exercicio
           )                                                    AS sw_codigo_penultimo_andamento
        ON sw_codigo_penultimo_andamento.cod_processo    = p.cod_processo
       AND sw_codigo_penultimo_andamento.ano_exercicio   = p.ano_exercicio
 LEFT JOIN sw_andamento                                         AS sw_penultimo_andamento
        ON sw_penultimo_andamento.cod_andamento          = sw_codigo_penultimo_andamento.cod_andamento
       AND sw_penultimo_andamento.cod_processo           = p.cod_processo
       AND sw_penultimo_andamento.ano_exercicio          = p.ano_exercicio
 LEFT JOIN administracao.usuario                                AS sw_usuario_penultimo_andamento
        ON sw_usuario_penultimo_andamento.numcgm         = sw_penultimo_andamento.cod_usuario
-- LEFT JOIN administracao.setor                                  AS sw_setor_penultimo_andamento
--        ON sw_setor_penultimo_andamento.cod_setor        = sw_penultimo_andamento.cod_setor
--       AND sw_setor_penultimo_andamento.cod_departamento = sw_penultimo_andamento.cod_departamento
--       AND sw_setor_penultimo_andamento.cod_unidade      = sw_penultimo_andamento.cod_unidade
--       AND sw_setor_penultimo_andamento.cod_orgao        = sw_penultimo_andamento.cod_orgao
--       AND sw_setor_penultimo_andamento.ano_exercicio    = sw_penultimo_andamento.ano_exercicio_setor
 LEFT JOIN sw_cgm
        ON sw_cgm.numcgm = p.numcgm
 LEFT JOIN sw_classificacao
        ON sw_classificacao.cod_classificacao            = p.cod_classificacao
 LEFT JOIN sw_assunto
        ON sw_assunto.cod_assunto                        = p.cod_assunto
       AND sw_assunto.cod_classificacao                  = p.cod_classificacao
 LEFT JOIN sw_situacao_processo
        ON sw_situacao_processo.cod_situacao             = p.cod_situacao
 LEFT JOIN administracao.usuario                                AS sw_usuario_inclusao
        ON sw_usuario_inclusao.numcgm                    = p.cod_usuario
 LEFT JOIN sw_recebimento
        ON sw_recebimento.cod_andamento                  = sw_penultimo_andamento.cod_andamento
       AND sw_recebimento.cod_processo                   = p.cod_processo
       AND sw_recebimento.ano_exercicio                  = p.ano_exercicio
 LEFT JOIN sw_recibo_impresso
        ON sw_recibo_impresso.cod_andamento              = sw_penultimo_andamento.cod_andamento
       AND sw_recibo_impresso.cod_processo               = p.cod_processo
       AND sw_recibo_impresso.ano_exercicio              = p.ano_exercicio
 LEFT JOIN sw_assinatura_digital
        ON sw_assinatura_digital.cod_andamento           = sw_penultimo_andamento.cod_andamento
       AND sw_assinatura_digital.cod_processo            = p.cod_processo
       AND sw_assinatura_digital.ano_exercicio           = p.ano_exercicio
 LEFT JOIN administracao.usuario                                AS sw_usuario_assinatura_digital
        ON sw_usuario_assinatura_digital.numcgm          = sw_assinatura_digital.cod_usuario
 LEFT JOIN sw_processo_apensado
        ON sw_processo_apensado.cod_processo_filho       = p.cod_processo
       AND sw_processo_apensado.exercicio_filho          = p.ano_exercicio
       AND sw_processo_apensado.timestamp_desapensamento IS NULL
 LEFT JOIN sw_processo_arquivado
        ON sw_processo_arquivado.cod_processo            = p.cod_processo
       AND sw_processo_arquivado.ano_exercicio           = p.ano_exercicio
 LEFT JOIN sw_historico_arquivamento
        ON sw_historico_arquivamento.cod_historico       = sw_processo_arquivado.cod_historico
         ;
