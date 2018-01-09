CREATE OR REPLACE FUNCTION contabilidade.fezencerramentoanuallancamentosvariacoespatri(varexercicio character varying, intcodentidade integer)
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
DECLARE
   bolFezLancamto BOOLEAN := FALSE;
BEGIN

   PERFORM 1
      FROM administracao.configuracao
     WHERE exercicio =  varExercicio
      AND cod_modulo = 9
      AND parametro  =  'encer_var_patri_' || BTRIM(TO_CHAR(intCodEntidade, '9'));

   IF FOUND  THEN
      bolFezLancamto := TRUE;
   END IF;

   RETURN bolFezLancamto;

END;  $function$
