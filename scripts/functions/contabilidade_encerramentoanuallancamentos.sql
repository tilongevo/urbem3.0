CREATE OR REPLACE FUNCTION contabilidade.encerramentoanuallancamentos(varexercicio character varying, intseqins integer, intcodlote integer, intcodentidade integer, intcodhistorico integer, numsaldo numeric, intcodplanodeb integer, intcodplanocre integer)
 RETURNS void
 LANGUAGE plpgsql
AS $function$
BEGIN
   INSERT INTO contabilidade.lancamento( sequencia
                                       , cod_lote
                                       , tipo
                                       , exercicio
                                       , cod_entidade
                                       , cod_historico
                                       , complemento)
                                VALUES ( intSeqIns
                                       , intCodlote
                                       , 'M'
                                       , varExercicio
                                       , intCodEntidade
                                       , intCodHistorico
                                       , '');

   INSERT INTO contabilidade.valor_lancamento( cod_lote
                                             , tipo
                                             , sequencia
                                             , exercicio
                                             , tipo_valor
                                             , cod_entidade
                                             , vl_lancamento)
                                      VALUES ( intCodlote
                                             , 'M'
                                             , intSeqIns
                                             , varExercicio
                                             , 'C'
                                             , intCodEntidade
                                             , -(numSaldo));

   INSERT INTO contabilidade.valor_lancamento( cod_lote
                                             , tipo
                                             , sequencia
                                             , exercicio
                                             , tipo_valor
                                             , cod_entidade
                                             , vl_lancamento)
                                       VALUES( intCodlote
                                             , 'M'
                                             , intSeqIns
                                             , varExercicio
                                             , 'D'
                                             , intCodEntidade
                                             , numSaldo );


   INSERT INTO contabilidade.conta_debito( cod_lote
                                         , tipo
                                         , sequencia
                                         , exercicio
                                         , tipo_valor
                                         , cod_entidade
                                         , cod_plano)
                                  VALUES ( intCodlote
                                         , 'M'
                                         , intSeqIns
                                         , varExercicio
                                         , 'D'
                                         , intCodEntidade
                                         , intCodPlanoDeb);

   INSERT INTO contabilidade.conta_credito( cod_lote
                                          , tipo
                                          , sequencia
                                          , exercicio
                                          , tipo_valor
                                          , cod_entidade
                                          , cod_plano)
                                   VALUES ( intCodlote
                                          , 'M'
                                          , intSeqIns
                                          , varExercicio
                                          , 'C'
                                          , intCodEntidade
                                          , intCodPlanoCre);
   RETURN;

END;  $function$
