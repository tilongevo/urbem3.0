SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = contabilidade, pg_catalog;

INSERT INTO contabilidade.pagamento
(exercicio, sequencia, tipo, cod_lote, cod_entidade, cod_nota, timestamp, exercicio_liquidacao)
VALUES ('2016', 2, 'P', 56, 2, 2, TO_TIMESTAMP('2016-04-20 16:34:17.111', 'yyyy-mm-dd hh24:mi:ss.US'), '2016');
