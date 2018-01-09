CREATE OR REPLACE FUNCTION contabilidade.encerramentoanuallancamentosvariacoespatrimoniais2013(varexercicio character varying, intcodentidade integer)
 RETURNS void
 LANGUAGE plpgsql
AS $function$
DECLARE
   recLancamento        Record;
   varAux               VARCHAR;
   intCodLote           INTEGER;
   intCodHistorico      INTEGER;
   bolCriouLote         BOOLEAN := FALSE;

   intSeqIns            INTEGER := 0;
   numSaldo             NUMERIC(14,2);
   intCodPlanoDeb       INTEGER;
   intCodPlanoCre       INTEGER;

   intCodPlano2371101     INTEGER := 0;

   bolEncerramentoVariacoesPatri   BOOLEAN;
BEGIN

   --utiliza a mesma função de validação pois não muda o parâmetro na configuração
   IF NOT contabilidade.fezEncerramentoAnualLancamentosVariacoesPatri( varExercicio, intCodEntidade) THEN

      IF bolEncerramentoVariacoesPatri THEN
         RAISE EXCEPTION 'Encerramento já realizado......';
      END IF;

      --Insere histórico 801 para as contas do grupo 3
      INSERT INTO contabilidade.historico_contabil( cod_historico
                                                , exercicio
                                                , nom_historico
                                                , complemento)
                                             SELECT 801
                                                , varExercicio
                                                , 'Encerramento do exercício – Despesa.'
                                                , 'f'
                                             WHERE 0  = ( SELECT Count(1)
                                                            FROM contabilidade.historico_contabil
                                                            WHERE cod_historico = 801
                                                            AND exercicio     = varExercicio);

      --Insere histórico 802 para as contas do grupo 4
      INSERT INTO contabilidade.historico_contabil( cod_historico
                                                , exercicio
                                                , nom_historico
                                                , complemento)
                                             SELECT 802
                                                , varExercicio
                                                , 'Encerramento do exercício – Receita.'
                                                , 'f'
                                             WHERE 0  = ( SELECT Count(1)
                                                            FROM contabilidade.historico_contabil
                                                            WHERE cod_historico = 802
                                                            AND exercicio     = varExercicio);

      SELECT plano_analitica.cod_plano
      INTO intCodPlano2371101
      FROM contabilidade.plano_conta
         , contabilidade.plano_analitica
      WHERE plano_conta.exercicio = plano_analitica.exercicio
         AND plano_conta.cod_conta = plano_analitica.cod_conta
         AND plano_conta.exercicio = varExercicio
         AND plano_conta.cod_estrutural = '2.3.7.1.1.01.00.00.00.00';

      For recLancamento IN SELECT plano_conta.cod_estrutural
                                , plano_analitica.cod_plano
                                , coalesce(total_credito.valor,0.00)            AS valor_cre
                                , coalesce(total_debito.valor,0.00)             AS valor_deb
                                , coalesce(( COALESCE(abs(-(total_credito.valor)),0) - COALESCE(total_debito.valor,0) ),0.00) AS saldo
                             FROM contabilidade.plano_conta
                                , contabilidade.plano_analitica
                        LEFT JOIN ( SELECT cod_plano, conta_debito.exercicio, SUM(vl_lancamento) AS valor
                                      FROM contabilidade.valor_lancamento
                                         , contabilidade.conta_debito
                                     WHERE conta_debito.cod_lote     = valor_lancamento.cod_lote
                                       AND conta_debito.tipo         = valor_lancamento.tipo
                                       AND conta_debito.sequencia    = valor_lancamento.sequencia
                                       AND conta_debito.exercicio    = valor_lancamento.exercicio
                                       AND conta_debito.tipo_valor   = valor_lancamento.tipo_valor
                                       AND conta_debito.cod_entidade = valor_lancamento.cod_entidade
                                       AND conta_debito.cod_entidade = intCodEntidade
                                  GROUP BY cod_plano,conta_debito.exercicio
                                ) AS total_debito
                               ON contabilidade.plano_analitica.cod_plano = total_debito.cod_plano
                              AND contabilidade.plano_analitica.exercicio = total_debito.exercicio
                        LEFT JOIN ( SELECT cod_plano, conta_credito.exercicio, SUM(vl_lancamento) AS valor
                                      FROM contabilidade.valor_lancamento
                                         , contabilidade.conta_credito
                                     WHERE conta_credito.cod_lote     = valor_lancamento.cod_lote
                                       AND conta_credito.tipo         = valor_lancamento.tipo
                                       AND conta_credito.sequencia    = valor_lancamento.sequencia
                                       AND conta_credito.exercicio    = valor_lancamento.exercicio
                                       AND conta_credito.tipo_valor   = valor_lancamento.tipo_valor
                                       AND conta_credito.cod_entidade = valor_lancamento.cod_entidade
                                       AND conta_credito.cod_entidade = intCodEntidade
                                  GROUP BY cod_plano,conta_credito.exercicio
                                ) AS total_credito
                               ON contabilidade.plano_analitica.cod_plano = total_credito.cod_plano
                              AND contabilidade.plano_analitica.exercicio = total_credito.exercicio
                            WHERE plano_conta.cod_conta     = plano_analitica.cod_conta
                              AND plano_conta.exercicio     = plano_analitica.exercicio
                              AND plano_conta.cod_sistema   = 1
                              AND plano_conta.exercicio     = varExercicio
                              AND SUBSTR(cod_estrutural,01,01) IN ('3','4')
                          AND NOT ( total_debito.valor IS NULL AND total_credito.valor IS NULL )
                         ORDER BY plano_conta.cod_estrutural
      LOOP

         IF recLancamento.saldo != 0 THEN
            IF NOT bolCriouLote  THEN
               intCodLote  := contabilidade.fn_insere_lote( varExercicio
                                                         , intCodEntidade
                                                         , 'M'
                                                         , 'Variações Patrimoniais/' || varExercicio
                                                         , '31-12-' || varExercicio
                                                            );
               bolCriouLote := TRUE;
            END IF;


            varAux            := RecLancamento.cod_estrutural || ' Codigo plano => ' ||recLancamento.cod_plano;
            intCodPlanoDeb    := 0;
            intCodPlanoCre    := 0;
            intSeqIns         := intSeqIns  + 1;

            IF substr(recLancamento.cod_estrutural,1,1) = '3' THEN
               IF recLancamento.saldo < 0 THEN
                  numSaldo        := ABS(recLancamento.saldo);
                  intCodPlanoDeb  := intCodPlano2371101;
                  intCodPlanoCre  := recLancamento.cod_plano;
                  intCodHistorico := 801;
               ELSE
                  numSaldo        := recLancamento.saldo;
                  intCodPlanoDeb  := recLancamento.cod_plano;
                  intCodPlanoCre  := intCodPlano2371101;
                  intCodHistorico := 801;
               END IF;
            END IF;

            IF substr(recLancamento.cod_estrutural,1,1) = '4' THEN
               IF recLancamento.saldo > 0 THEN
                  numSaldo        := recLancamento.saldo;
                  intCodPlanoDeb  := recLancamento.cod_plano;
                  intCodPlanoCre  := intCodPlano2371101;
                  intCodHistorico := 802;
               ELSE
                  numSaldo        := ABS(recLancamento.saldo);
                  intCodPlanoDeb  := intCodPlano2371101;
                  intCodPlanoCre  := recLancamento.cod_plano;
                  intCodHistorico := 802;
               END IF;
            END IF;

            PERFORM contabilidade.encerramentoAnualLancamentos( varExercicio
                                                               , intSeqIns
                                                               , intCodlote
                                                               , intCodEntidade
                                                               , intCodHistorico
                                                               , numSaldo
                                                               , intCodPlanoDeb
                                                               , intCodPlanoCre
                                                               );
         END IF;
      END LOOP;

      /**
       * Alteração feita neste insert pois administracao.configuracao tem id sequencial
       */
--        Insert Into administracao.configuracao ( exercicio
--                                              , cod_modulo
--                                              , parametro
--                                              , valor)
--                                       Values ( varExercicio
--                                               , 9
--                                               , 'encer_var_patri_' || BTRIM(TO_CHAR(intCodEntidade, '9'))
--                                               , 'TRUE');
      Insert Into administracao.configuracao (id
                                              ,exercicio
                                             , cod_modulo
                                             , parametro
                                             , valor)
                                      Values ( nextval('administracao.configuracao_id_seq')
                                              , varExercicio
                                              , 9
                                              , 'encer_var_patri_' || BTRIM(TO_CHAR(intCodEntidade, '9'))
                                              , 'TRUE');

   END IF;

   RETURN;

END;  $function$
