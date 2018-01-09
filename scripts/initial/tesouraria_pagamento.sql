SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = tesouraria, pg_catalog;

INSERT INTO
tesouraria.pagamento (exercicio, cod_entidade, cod_nota, timestamp, exercicio_boletim, cod_autenticacao, dt_autenticacao, cod_boletim, cod_terminal, timestamp_terminal, cgm_usuario, timestamp_usuario, cod_plano, exercicio_plano)
VALUES ('2016', 2, 2, TO_TIMESTAMP('2016-04-20 16:34:17.111', 'yyyy-mm-dd hh24:mi:ss.US'), '2016', 10, TO_DATE('20/05/2016', 'dd/mm/yyyy'), 75, 3, '2016-11-07 16:27:00', 6, '2016-08-17 00:00:00', 2529, '2016');
