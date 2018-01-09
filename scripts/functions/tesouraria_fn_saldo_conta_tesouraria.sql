CREATE OR REPLACE FUNCTION tesouraria.fn_saldo_conta_tesouraria(varexercicio character varying, intcodplano integer, vardtinicial character varying, vardtfinal character varying, bolmovimentacao boolean)
 RETURNS numeric
 LANGUAGE plpgsql
AS $function$
DECLARE
   datInicial                DATE      := TO_DATE( varDtInicial::text, 'dd/mm/yyyy' );
   datDtFinal                DATE      := TO_DATE( varDtFinal::text  , 'dd/mm/yyyy' );
   timInicial                TIMESTAMP := TO_TIMESTAMP( datInicial::text  , 'YYYY-MM-DD');
   tmpDt                     VARCHAR   := datDtFinal+1;
   timDtFinal                TIMESTAMP := TO_TIMESTAMP( tmpDt, 'YYYY-MM-DD');
   timInicial2               DATE := TO_DATE( datInicial::text, 'YYYY-MM-DD');
   timDtFinal2               DATE := TO_DATE( datDtFinal::text, 'YYYY-MM-DD');

   numValorImplantado        NUMERIC   := 0.00;
   numVlTransferencia        NUMERIC   := 0.00;
   numVlTransferenciaDeb     NUMERIC   := 0.00;
   numVlTransferenciaCred    NUMERIC   := 0.00;
   numVlPago                 NUMERIC   := 0.00;
   numVlPagoEstornado        NUMERIC   := 0.00;
   numValorTesouraria        NUMERIC   := 0.00;
   numVlArrecadacao          NUMERIC   := 0.00;
   numVlArrecadacaoEstornada NUMERIC   := 0.00;

   -- Variaveis calculo Arrecadacao.
   recArrecadacao            RECORD;
   numArrecadVlr             NUMERIC   := 0.00;
   numArrecadVlrDesconto     NUMERIC   := 0.00;
   numArrecadVlrJuros        NUMERIC   := 0.00;
   numArrecadVlrMulta        NUMERIC   := 0.00;

   -- Variaveis Arrecadacao estornada.
   numArrecadVlrEstornada         NUMERIC   := 0.00;
   numArrecadVlrDescontoEstornada NUMERIC   := 0.00;
   numArrecadVlrJurosEstornada    NUMERIC   := 0.00;
   numArrecadVlrMultaEstornada    NUMERIC   := 0.00;

   -- Variaveis Calculo de Valores de multa e juros
   recMultaJuRos             RECORD;
   numVlJuros                NUMERIC   := 0.00;
   numVlMulta                NUMERIC   := 0.00;
   recAux                    RECORD;
   numAux                    NUMERIC   := 0.00;
   varAux                    VARCHAR   := '';
   stSql                     VARCHAR   := '';
   stNomePrefeitura          VARCHAR   := '';

BEGIN

   SELECT vl_saldo
     INTO numValorImplantado
     FROM tesouraria.saldo_tesouraria
    WHERE cod_plano = intCodPlano
      AND exercicio = varExercicio
   ;

   SELECT valor
     INTO stNomePrefeitura
     FROM administracao.configuracao
    WHERE parametro = 'nom_prefeitura'
	  AND exercicio = varExercicio
   ;

   --
   -- Contabiliza valores da movimentaçao se a data final 01/01 e o bolMovimentacao está como true
   --
   IF (datDtFinal != TO_DATE( '01/01/'||varExercicio, 'dd/mm/yyyy') OR bolMovimentacao) THEN

      --
      -- Valores da tabela tesouraria.arrecadacao_receita.
      --
	  stSql := ' SELECT DISTINCT * FROM (
                            SELECT arrecadacao.exercicio
                                 , arrecadacao.cod_arrecadacao
                                 , arrecadacao.timestamp_arrecadacao
                                 , arrecadacao_receita.vl_arrecadacao AS valor
                              FROM tesouraria.boletim
                                 , tesouraria.arrecadacao
                                 , tesouraria.arrecadacao_receita
                                 , orcamento.receita
                                 , orcamento.conta_receita
                                 , contabilidade.plano_conta
                                 , contabilidade.plano_analitica ';
                IF varExercicio::integer > 2012 THEN
					stSql := stSql || ', contabilidade.configuracao_lancamento_receita ';
				END IF;

                    stSql := stSql || ' WHERE boletim.exercicio   = arrecadacao.exercicio
                               AND boletim.cod_boletim = arrecadacao.cod_boletim
                               AND boletim.cod_entidade= arrecadacao.cod_entidade
                               AND arrecadacao.exercicio             = arrecadacao_receita.exercicio
                               AND arrecadacao.cod_arrecadacao       = arrecadacao_receita.cod_arrecadacao
                               AND arrecadacao.timestamp_arrecadacao = arrecadacao_receita.timestamp_arrecadacao

                               AND arrecadacao_receita.exercicio            = receita.exercicio
                               AND arrecadacao_receita.cod_receita          = receita.cod_receita
                               -- Join com orcamento.conta_receita
                               AND receita.exercicio            = conta_receita.exercicio
                               AND receita.cod_conta            = conta_receita.cod_conta ';

                IF varExercicio::integer > 2012 THEN
					stSql := stSql || '
							   AND conta_receita.exercicio = configuracao_lancamento_receita.exercicio
							   AND conta_receita.cod_conta = configuracao_lancamento_receita.cod_conta_receita

							   AND configuracao_lancamento_receita.exercicio = plano_conta.exercicio
 							   AND configuracao_lancamento_receita.cod_conta = plano_conta.cod_conta
							 ';
				ELSE

					stSql := stSql || '
                               -- Join com contabilidade.conta_plano
                               AND conta_receita.exercicio            = plano_conta.exercicio
                               AND  (''4.''||conta_receita.cod_estrutural = plano_conta.cod_estrutural
                                     OR conta_receita.cod_estrutural = plano_conta.cod_estrutural)
							 ';
				END IF;

					stSql := stSql || '
                               -- Join com contabilidade.conta_analitica
                               AND plano_conta.exercicio           = plano_analitica.exercicio
                               AND plano_conta.cod_conta           = plano_analitica.cod_conta

                               -- Filtros
                               AND boletim.exercicio     = '|| quote_literal(varExercicio) ||'
                               AND boletim.dt_boletim    BETWEEN '''|| datInicial ||''' AND '''|| datDtFinal ||'''
                               AND arrecadacao.cod_plano = '|| intCodPlano ||'
                               AND arrecadacao.devolucao is false ';
                    IF varExercicio::integer > 2012 THEN
						       stSql := stSql || ' AND configuracao_lancamento_receita.estorno is false ';
					END IF;

                        stSql := stSql || ' UNION ALL

                            SELECT
                                   arrecadacao.exercicio
                                 , arrecadacao.cod_arrecadacao
                                 , arrecadacao_estornada.timestamp_estornada
                                 , arrecadacao_receita_dedutora_estornada.vl_estornado AS valor
                              FROM tesouraria.boletim
                                 , tesouraria.arrecadacao
                                   INNER JOIN tesouraria.arrecadacao_estornada ON (
                                            tesouraria.arrecadacao_estornada.exercicio              = tesouraria.arrecadacao.exercicio
                                        AND tesouraria.arrecadacao_estornada.cod_arrecadacao        = tesouraria.arrecadacao.cod_arrecadacao
                                        AND tesouraria.arrecadacao_estornada.timestamp_arrecadacao  = tesouraria.arrecadacao.timestamp_arrecadacao
                                        AND tesouraria.arrecadacao.devolucao                        = false
                                   )
                                 , tesouraria.arrecadacao_receita
                                 , tesouraria.arrecadacao_receita_dedutora
                                 , tesouraria.arrecadacao_receita_dedutora_estornada
                                 , orcamento.receita
                                 , orcamento.conta_receita
                                 , contabilidade.plano_conta
                                 , contabilidade.plano_analitica';
                    IF varExercicio::integer > 2012 THEN
						stSql := stSql || ', contabilidade.configuracao_lancamento_receita ';
					END IF;

                        stSql := stSql || ' WHERE boletim.exercicio   = arrecadacao.exercicio
                                 AND boletim.cod_boletim = arrecadacao.cod_boletim
                                 AND boletim.cod_entidade= arrecadacao.cod_entidade
                                 AND arrecadacao.exercicio             = arrecadacao_receita.exercicio
                                 AND arrecadacao.cod_arrecadacao       = arrecadacao_receita.cod_arrecadacao
                                 AND arrecadacao.timestamp_arrecadacao = arrecadacao_receita.timestamp_arrecadacao

                                 AND arrecadacao_receita.cod_arrecadacao       = arrecadacao_receita_dedutora.cod_arrecadacao
                                 AND arrecadacao_receita.cod_receita           = arrecadacao_receita_dedutora.cod_receita
                                 AND arrecadacao_receita.exercicio             = arrecadacao_receita_dedutora.exercicio
                                 AND arrecadacao_receita.timestamp_arrecadacao = arrecadacao_receita_dedutora.timestamp_arrecadacao

                                 AND arrecadacao_receita_dedutora.cod_arrecadacao        = arrecadacao_receita_dedutora_estornada.cod_arrecadacao
                                 AND arrecadacao_receita_dedutora.cod_receita            = arrecadacao_receita_dedutora_estornada.cod_receita
                                 AND arrecadacao_receita_dedutora.exercicio              = arrecadacao_receita_dedutora_estornada.exercicio
                                 AND arrecadacao_receita_dedutora.timestamp_arrecadacao  = arrecadacao_receita_dedutora_estornada.timestamp_arrecadacao
                                 AND arrecadacao_receita_dedutora.cod_receita_dedutora   = arrecadacao_receita_dedutora_estornada.cod_receita_dedutora

                                 AND arrecadacao_receita_dedutora_estornada.cod_arrecadacao       = arrecadacao_estornada.cod_arrecadacao
                                 AND arrecadacao_receita_dedutora_estornada.exercicio             = arrecadacao_estornada.exercicio
                                 AND arrecadacao_receita_dedutora_estornada.timestamp_arrecadacao = arrecadacao_estornada.timestamp_arrecadacao
                                 AND arrecadacao_receita_dedutora_estornada.timestamp_estornada   = arrecadacao_estornada.timestamp_estornada

                                 AND arrecadacao_receita_dedutora.exercicio            = receita.exercicio
                                 AND arrecadacao_receita_dedutora.cod_receita          = receita.cod_receita
                                 -- Join com orcamento.conta_receita
                                 AND receita.exercicio            = conta_receita.exercicio
                                 AND receita.cod_conta            = conta_receita.cod_conta ';

                    IF varExercicio::integer > 2012 THEN
							stSql := stSql || '

								 AND conta_receita.exercicio = configuracao_lancamento_receita.exercicio
							     AND conta_receita.cod_conta = configuracao_lancamento_receita.cod_conta_receita

							     AND configuracao_lancamento_receita.exercicio = plano_conta.exercicio
							     AND configuracao_lancamento_receita.cod_conta = plano_conta.cod_conta
							 ';

					ELSE

							stSql := stSql || '

                                 -- Join com contabilidade.conta_plano
                                 AND conta_receita.exercicio            = plano_conta.exercicio
                                 AND  (''4.''||conta_receita.cod_estrutural = plano_conta.cod_estrutural
                                     OR conta_receita.cod_estrutural = plano_conta.cod_estrutural)
							 ';

					END IF;

							stSql := stSql || '
                                 -- Join com contabilidade.conta_analitica
                                 AND plano_conta.exercicio           = plano_analitica.exercicio
                                 AND plano_conta.cod_conta           = plano_analitica.cod_conta

                                 -- Filtros
                                 AND boletim.exercicio     =  '|| quote_literal(varExercicio)||'
                                 AND to_date(arrecadacao_receita_dedutora_estornada.timestamp_dedutora_estornada::text, ''yyyy-mm-dd'') BETWEEN '''|| timInicial2 ||''' AND '''|| timDtFinal2 ||'''
                                 AND arrecadacao.cod_plano = '|| intCodPlano;

      stSql := stSql || ' ) AS tabela ';

	  FOR recArrecadacao IN
      EXECUTE stSql
      LOOP
         numArrecadVlr := numArrecadVlr + recArrecadacao.valor;
      END LOOP;

      --
      -- Arrecadacao estornada
      --

      --FOR recArrecadacao IN SELECT arrecadacao_estornada.exercicio
      stSql := 'SELECT DISTINCT * FROM (
                           SELECT arrecadacao_estornada.exercicio
                                 , arrecadacao_estornada.cod_arrecadacao
                                 , arrecadacao_estornada.timestamp_estornada
                                 , arrecadacao_estornada_receita.vl_estornado AS valor
                              FROM tesouraria.boletim
                                 , tesouraria.arrecadacao
                                   INNER JOIN tesouraria.arrecadacao_estornada ON (
                                            arrecadacao_estornada.exercicio             = arrecadacao.exercicio
                                        AND arrecadacao_estornada.cod_arrecadacao       = arrecadacao.cod_arrecadacao
                                        AND arrecadacao_estornada.timestamp_arrecadacao = arrecadacao.timestamp_arrecadacao
                                        AND arrecadacao.devolucao                       = false
                                   )
                                   INNER JOIN tesouraria.arrecadacao_estornada_receita ON (
                                          arrecadacao_estornada_receita.exercicio             = arrecadacao_estornada.exercicio
                                      AND arrecadacao_estornada_receita.cod_arrecadacao       = arrecadacao_estornada.cod_arrecadacao
                                      AND arrecadacao_estornada_receita.timestamp_arrecadacao = arrecadacao_estornada.timestamp_arrecadacao
                                      AND arrecadacao_estornada_receita.timestamp_estornada   = arrecadacao_estornada.timestamp_estornada
                                   )
                                 , tesouraria.arrecadacao_receita
                                 , orcamento.receita
                                 , orcamento.conta_receita
                                 , contabilidade.plano_conta
                                 , contabilidade.plano_analitica ';
                IF varExercicio::integer > 2012 THEN
					stSql := stSql || ', contabilidade.configuracao_lancamento_receita ';
				END IF;

                    stSql := stSql ||' WHERE arrecadacao_estornada.cod_arrecadacao IS NOT NULL
                               AND boletim.exercicio   = arrecadacao_estornada.exercicio
                               AND boletim.cod_boletim = arrecadacao_estornada.cod_boletim
                               AND boletim.cod_entidade= arrecadacao_estornada.cod_entidade

                               AND arrecadacao_estornada.exercicio             = arrecadacao_receita.exercicio
                               AND arrecadacao_estornada.cod_arrecadacao       = arrecadacao_receita.cod_arrecadacao
                               AND arrecadacao_estornada.timestamp_arrecadacao = arrecadacao_receita.timestamp_arrecadacao

                               AND arrecadacao_receita.exercicio            = receita.exercicio
                               AND arrecadacao_receita.cod_receita          = receita.cod_receita
                               -- Join com orcamento.conta_receita
                               AND receita.exercicio            = conta_receita.exercicio
                               AND receita.cod_conta            = conta_receita.cod_conta ';

                IF varExercicio::integer > 2012 THEN
					stSql := stSql || '
							   AND conta_receita.exercicio = configuracao_lancamento_receita.exercicio
							   AND conta_receita.cod_conta = configuracao_lancamento_receita.cod_conta_receita

							   AND configuracao_lancamento_receita.exercicio = plano_conta.exercicio
						       AND configuracao_lancamento_receita.cod_conta = plano_conta.cod_conta
							 ';

				ELSE

					stSql := stSql || '
                               -- Join com contabilidade.conta_plano
                               AND conta_receita.exercicio            = plano_conta.exercicio
                               AND  (''4.''||conta_receita.cod_estrutural = plano_conta.cod_estrutural
                                     OR conta_receita.cod_estrutural = plano_conta.cod_estrutural)
						 ';
				END IF;

					stSql := stSql || '
                               -- Join com contabilidade.conta_analitica
                               AND plano_conta.exercicio           = plano_analitica.exercicio
                               AND plano_conta.cod_conta           = plano_analitica.cod_conta

                               -- Filtros
                               AND boletim.exercicio     = '|| quote_literal(varExercicio) ||'
                               AND boletim.dt_boletim    BETWEEN '''|| datInicial ||''' AND '''|| datDtFinal ||'''
                               AND arrecadacao.cod_plano = '|| intCodPlano;
                    IF varExercicio::integer > 2012 THEN
							   stSql := stSql || ' AND configuracao_lancamento_receita.estorno is true ';
					END IF;

      stSql := stSql || ' ) AS arrecadacao ';

	  FOR recArrecadacao IN
	  EXECUTE stSql
      LOOP
         numArrecadVlrEstornada         := numArrecadVlrEstornada + recArrecadacao.valor;
      END LOOP;

      --
      -- Valores tesouraria.arrecadacao_receita_dedutora.
      --

               stSql := 'SELECT DISTINCT
                                 arrecadacao.exercicio
                                 , arrecadacao.cod_arrecadacao
                                 , arrecadacao.timestamp_arrecadacao
                                 , arrecadacao_receita_dedutora.vl_deducao   AS valor
                              FROM tesouraria.boletim
                                 , tesouraria.arrecadacao
                                 , tesouraria.arrecadacao_receita
                                 , tesouraria.arrecadacao_receita_dedutora
                                 , orcamento.receita
                                 , orcamento.conta_receita
                                 , contabilidade.plano_conta
                                 , contabilidade.plano_analitica ';
                IF varExercicio::integer > 2012 THEN
					stSql := stSql || ', contabilidade.configuracao_lancamento_receita ';
				END IF;

                    stSql := stSql || ' WHERE boletim.exercicio   = arrecadacao.exercicio
                               AND boletim.cod_boletim = arrecadacao.cod_boletim
                               AND boletim.cod_entidade= arrecadacao.cod_entidade
                               -- Join com arrecadacao_receita
                               AND arrecadacao.exercicio              = arrecadacao_receita.exercicio
                               AND arrecadacao.cod_arrecadacao        = arrecadacao_receita.cod_arrecadacao
                               AND arrecadacao.timestamp_arrecadacao  = arrecadacao_receita.timestamp_arrecadacao
                               -- Join com arrecadacao_receita_dedutora
                               AND arrecadacao_receita.cod_arrecadacao       = arrecadacao_receita_dedutora.cod_arrecadacao
                               AND arrecadacao_receita.cod_receita           = arrecadacao_receita_dedutora.cod_receita
                               AND arrecadacao_receita.exercicio             = arrecadacao_receita_dedutora.exercicio
                               AND arrecadacao_receita.timestamp_arrecadacao = arrecadacao_receita_dedutora.timestamp_arrecadacao
                               -- Join com orcamento.receita
                               AND arrecadacao_receita_dedutora.exercicio             = receita.exercicio
                               AND arrecadacao_receita_dedutora.cod_receita_dedutora  = receita.cod_receita
                               -- Join com orcamento.conta_receita
                               AND receita.exercicio             = conta_receita.exercicio
                               AND receita.cod_conta             = conta_receita.cod_conta
                               -- Join com contabilidade.conta_plano
                               ';

                    IF NOT ( stNomePrefeitura = 'Tribunal de Contas Estado de Mato Grosso do Sul' ) THEN
                    stSql := stSql || ' AND conta_receita.exercicio            = plano_conta.exercicio ';
                    END IF;

                    IF (varExercicio < '2008') THEN
                         stSql := stSql || ' AND ''''4.''''||conta_receita.cod_estrutural = plano_conta.cod_estrutural ';
                    ELSE
                        IF varExercicio::integer > 2012 THEN
	    				 	stSql := stSql || '
							   AND conta_receita.exercicio = configuracao_lancamento_receita.exercicio
							   AND conta_receita.cod_conta = configuracao_lancamento_receita.cod_conta_receita

							   AND configuracao_lancamento_receita.exercicio = plano_conta.exercicio
							   AND configuracao_lancamento_receita.cod_conta = plano_conta.cod_conta
							 ';

						ELSE
                         	stSql := stSql || ' AND conta_receita.cod_estrutural = plano_conta.cod_estrutural ';
						END IF;
                    END IF;
               stSql := stSql || '           -- Join com contabilidade.conta_analitica
                               AND plano_conta.exercicio             = plano_analitica.exercicio
                               AND plano_conta.cod_conta             = plano_analitica.cod_conta

                               AND boletim.exercicio     = '''||varExercicio||'''
                               AND boletim.dt_boletim BETWEEN '''||timInicial2||''' AND '''||timDtFinal2||'''

                               AND arrecadacao.cod_plano = '||intCodPlano||' ';

            IF varExercicio::integer > 2012 THEN
	    stSql := stSql || ' AND configuracao_lancamento_receita.estorno is true ';
            END IF;

      FOR recArrecadacao IN
      EXECUTE  stSql
      LOOP
         numArrecadVlrEstornada := numArrecadVlrEstornada + recArrecadacao.valor;
      END LOOP;

      -- Devolução de Receitas
      --FOR recArrecadacao IN SELECT arrecadacao.exercicio
      stSql := ' SELECT DISTINCT * FROM (
                            SELECT arrecadacao.exercicio
                                 , arrecadacao.cod_arrecadacao
                                 , arrecadacao.timestamp_arrecadacao
                                 , arrecadacao_receita.vl_arrecadacao   AS valor
                              FROM tesouraria.boletim
                                 , tesouraria.arrecadacao
                                 , tesouraria.arrecadacao_receita
                                 , orcamento.receita
                                 , orcamento.conta_receita
                                 , contabilidade.plano_conta
                                 , contabilidade.plano_analitica ';
                IF varExercicio::integer > 2012 THEN
					stSql := stSql || ', contabilidade.configuracao_lancamento_receita ';
				END IF;

                    stSql := stSql || ' WHERE boletim.exercicio   = arrecadacao.exercicio
                               AND boletim.cod_boletim = arrecadacao.cod_boletim
                               AND boletim.cod_entidade= arrecadacao.cod_entidade
                               -- Join com arrecadacao_receita
                               AND arrecadacao.exercicio              = arrecadacao_receita.exercicio
                               AND arrecadacao.cod_arrecadacao        = arrecadacao_receita.cod_arrecadacao
                               AND arrecadacao.timestamp_arrecadacao  = arrecadacao_receita.timestamp_arrecadacao
                               -- Join com orcamento.receita
                               AND arrecadacao_receita.exercicio    = receita.exercicio
                               AND arrecadacao_receita.cod_receita  = receita.cod_receita
                               -- Join com orcamento.conta_receita
                               AND receita.exercicio             = conta_receita.exercicio
                               AND receita.cod_conta             = conta_receita.cod_conta ';

                    IF varExercicio::integer > 2012 THEN
						stSql := stSql || '

							   AND conta_receita.exercicio = configuracao_lancamento_receita.exercicio
							   AND conta_receita.cod_conta = configuracao_lancamento_receita.cod_conta_receita

							   AND configuracao_lancamento_receita.exercicio = plano_conta.exercicio
							   AND configuracao_lancamento_receita.cod_conta = plano_conta.cod_conta
							 ';

					ELSE

						stSql := stSql || '

                               -- Join com contabilidade.conta_plano
                               AND conta_receita.exercicio            = plano_conta.exercicio
                               AND ((''4.''||conta_receita.cod_estrutural = plano_conta.cod_estrutural) OR (conta_receita.cod_estrutural = plano_conta.cod_estrutural))
						 ';

					END IF;

				     stSql := stSql || '
                               -- Join com contabilidade.conta_analitica
                               AND plano_conta.exercicio             = plano_analitica.exercicio
                               AND plano_conta.cod_conta             = plano_analitica.cod_conta

                               AND boletim.exercicio     = '|| quote_literal(varExercicio) ||'
                               AND boletim.dt_boletim    BETWEEN '''|| datInicial ||''' AND '''|| datDtFinal ||'''
                               AND arrecadacao.cod_plano = '|| intCodPlano ||'
                               AND arrecadacao.devolucao = true ';
                        IF varExercicio::integer > 2012 THEN
							   stSql := stSql || ' AND configuracao_lancamento_receita.estorno is true ';
						END IF;

      stSql := stSql || ' ) AS devolucao_receita ';

	  FOR recArrecadacao IN
	  EXECUTE stSql
      LOOP
         numArrecadVlrEstornada := numArrecadVlrEstornada + recArrecadacao.valor;
      END LOOP;

      --
      -- Calcula Valor Transferencia Debito
      --
      SELECT ( coalesce( sum( transferencia.valor ) , 0.00 ) - coalesce( sum(transferencia.valor_estornado)   ,0.00) )
        INTO numVlTransferenciaDeb
        FROM ( SELECT ( coalesce( sum( transferencia.valor ) , 0.00 ) ) AS valor
                    , 0 AS valor_estornado
                 FROM tesouraria.transferencia
                WHERE transferencia.exercicio               = varexercicio
                  AND transferencia.timestamp_transferencia BETWEEN timinicial AND timdtfinal
                  AND transferencia.cod_plano_debito        = intcodplano

            UNION ALL

               SELECT 0 AS valor
                    , ( coalesce( sum( transferencia_estornada.valor ) , 0.00 ) ) AS valor_estornado
                 FROM tesouraria.transferencia
                 JOIN tesouraria.transferencia_estornada
                   ON transferencia_estornada.exercicio     = transferencia.exercicio
                  AND transferencia_estornada.cod_entidade  = transferencia.cod_entidade
                  AND transferencia_estornada.cod_lote      = transferencia.cod_lote
                  AND transferencia_estornada.tipo          = transferencia.tipo
                WHERE transferencia.exercicio               = varexercicio
                  AND transferencia.timestamp_transferencia BETWEEN timinicial AND timdtfinal
                  AND transferencia_estornada.timestamp_estornada BETWEEN timInicial AND timDtFinal
                  AND transferencia.cod_plano_debito        = intcodplano

            ) AS transferencia;

      --
      -- Calcula Valor Transferencia Credito.
      --
      SELECT ( coalesce( sum( transferencia.valor ) , 0.00 ) - coalesce( sum(transferencia.valor_estornado)   ,0.00) )
        INTO numVlTransferenciaCred
        FROM ( SELECT ( coalesce( sum( transferencia.valor ) , 0.00 ) ) AS valor
                    , 0 AS valor_estornado
                 FROM tesouraria.transferencia
                WHERE transferencia.exercicio               = varexercicio
                  AND transferencia.timestamp_transferencia BETWEEN timinicial AND timdtfinal
                  AND transferencia.cod_plano_credito       = intcodplano

            UNION ALL

               SELECT 0 AS valor
                    , ( coalesce( sum( transferencia_estornada.valor ) , 0.00 ) ) AS valor_estornado
                 FROM tesouraria.transferencia
                 JOIN tesouraria.transferencia_estornada
                   ON transferencia_estornada.exercicio     = transferencia.exercicio
                  AND transferencia_estornada.cod_entidade  = transferencia.cod_entidade
                  AND transferencia_estornada.cod_lote      = transferencia.cod_lote
                  AND transferencia_estornada.tipo          = transferencia.tipo
                WHERE transferencia.exercicio               = varexercicio
                  AND transferencia.timestamp_transferencia BETWEEN timinicial AND timdtfinal
                  AND transferencia_estornada.timestamp_estornada BETWEEN timInicial AND timDtFinal
                  AND transferencia.cod_plano_credito       = intcodplano

            ) AS transferencia;

      --
      -- pagamento Credito
      --
      SELECT SUM(coalesce(empenho.nota_liquidacao_paga.vl_pago, 0.00))
        INTO numVlPago
        FROM tesouraria.pagamento
           , empenho.nota_liquidacao_paga
       WHERE
             tesouraria.pagamento.exercicio    = empenho.nota_liquidacao_paga.exercicio
         AND tesouraria.pagamento.cod_entidade = empenho.nota_liquidacao_paga.cod_entidade
         AND tesouraria.pagamento.timestamp    = empenho.nota_liquidacao_paga.timestamp
         AND tesouraria.pagamento.cod_nota     = empenho.nota_liquidacao_paga.cod_nota

         AND tesouraria.pagamento.timestamp BETWEEN timInicial AND timDtFinal
         AND tesouraria.pagamento.exercicio_boletim = varExercicio
         AND tesouraria.pagamento.cod_plano   = intCodPlano
      ;

      --
      -- pagamento Debito
      --

    SELECT SUM(coalesce(ENLPA.vl_anulado, 0.00))
        INTO numVlPagoEstornado
    FROM
        tesouraria.boletim             as BOLETIM,
        tesouraria.pagamento_estornado as PE,
        tesouraria.pagamento           as P,
        empenho.pagamento_liquidacao as EPL,
        empenho.pagamento_liquidacao_nota_liquidacao_paga as EPLNLP,
        empenho.nota_liquidacao_paga                      as ENLP,
        empenho.nota_liquidacao_paga_anulada              as ENLPA,
        empenho.nota_liquidacao                           as ENL
    WHERE
            BOLETIM.cod_boletim         = PE.cod_boletim
        AND BOLETIM.exercicio           = PE.exercicio_boletim
        AND BOLETIM.cod_entidade        = PE.cod_entidade

        AND PE.cod_nota                 = P.cod_nota
        AND PE.exercicio                = P.exercicio
        AND PE.cod_entidade             = P.cod_entidade
        AND PE.timestamp                = P.timestamp

        AND PE.cod_nota                 = ENLPA.cod_nota
        AND PE.exercicio                = ENLPA.exercicio
        AND PE.cod_entidade             = ENLPA.cod_entidade
        AND PE.timestamp_anulado        = ENLPA.timestamp_anulada
        AND PE.timestamp                = ENLPA.timestamp

        AND ENLPA.cod_nota               = ENLP.cod_nota
        AND ENLPA.exercicio              = ENLP.exercicio
        AND ENLPA.cod_entidade           = ENLP.cod_entidade
        AND ENLPA.timestamp              = ENLP.timestamp

        AND ENLP.cod_nota               = ENL.cod_nota
        AND ENLP.exercicio              = ENL.exercicio
        AND ENLP.cod_entidade           = ENL.cod_entidade

        AND EPL.cod_ordem               = EPLNLP.cod_ordem
        AND EPL.exercicio               = EPLNLP.exercicio
        AND EPL.cod_entidade            = EPLNLP.cod_entidade
        AND EPL.exercicio_liquidacao    = EPLNLP.exercicio_liquidacao
        AND EPL.cod_nota                = EPLNLP.cod_nota

        AND EPLNLP.exercicio_liquidacao = ENLP.exercicio
        AND EPLNLP.cod_nota             = ENLP.cod_nota
        AND EPLNLP.cod_entidade         = ENLP.cod_entidade
        AND EPLNLP.timestamp            = ENLP.timestamp

        AND P.cod_plano       =   intCodPlano
        AND to_char(PE.timestamp_anulado,'yyyy')   = ''||varExercicio||''
        AND BOLETIM.dt_boletim BETWEEN timInicial2  AND timDtFinal2
      ;

   END IF;

   numVlArrecadacao          := ( numArrecadVlr - numArrecadVlrDesconto + numArrecadVlrJuros + numArrecadVlrMulta);

   numVlArrecadacaoEstornada := ( numArrecadVlrEstornada - numArrecadVlrDescontoEstornada + numArrecadVlrJurosEstornada + numArrecadVlrMultaEstornada );

   numVlTransferencia := coalesce( abs(numVlTransferenciaCred), 0.00 ) - coalesce( numVlTransferenciaDeb      , 0.00 );

   numVlPago          := coalesce( numVlPago                  , 0.00 ) - coalesce( numVlPagoEstornado         , 0.00 );

   numVlArrecadacao   := coalesce( numVlArrecadacao           , 0.00 ) - coalesce( numVlArrecadacaoEstornada  , 0.00 );

   numValorTesouraria := numVlArrecadacao - numVlTransferencia - numVlPago;

   RETURN coalesce( numValorImplantado, 0.00 ) + numValorTesouraria;

END;

$function$
