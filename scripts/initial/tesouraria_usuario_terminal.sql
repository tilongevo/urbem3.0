SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = tesouraria, pg_catalog;

INSERT INTO tesouraria.usuario_terminal
(cod_terminal, timestamp_terminal, cgm_usuario, timestamp_usuario, responsavel)
VALUES (3, '2016-11-07 16:27:00', 6, '2016-08-17 00:00:00', true);
