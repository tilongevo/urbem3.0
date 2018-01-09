SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = contabilidade, pg_catalog;

INSERT INTO
contabilidade.lancamento_empenho (cod_lote, tipo, sequencia, exercicio, cod_entidade, estorno)
VALUES (56, 'P', 2, '2016', 2, 'false');
