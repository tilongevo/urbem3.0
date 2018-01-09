SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = empenho, pg_catalog;

INSERT INTO empenho.nota_liquidacao_conta_pagadora
(exercicio_liquidacao, cod_entidade, cod_nota, timestamp, exercicio, cod_plano)
VALUES ('2016', 2, 2, TO_TIMESTAMP('2016-04-20 16:34:17.111', 'yyyy-mm-dd hh24:mi:ss.US'), '2016', 2529);
