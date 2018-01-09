SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = empenho, pg_catalog;

INSERT INTO empenho.pagamento_liquidacao_nota_liquidacao_paga
(cod_nota, exercicio_liquidacao, cod_entidade, exercicio, cod_ordem, timestamp)
VALUES (2, '2016', 2, '2016', 1094, TO_TIMESTAMP('2016-04-20 16:34:17.111', 'yyyy-mm-dd hh24:mi:ss.US'));
