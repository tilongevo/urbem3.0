SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = empenho, pg_catalog;

INSERT INTO empenho.nota_liquidacao
(exercicio, cod_nota, cod_entidade, exercicio_empenho, cod_empenho, dt_vencimento, dt_liquidacao, observacao, hora)
VALUES ('2016', 1, 2, '2016', 5, TO_DATE('2016-12-31','YYYY-MM-DD'), TO_DATE('2016-06-28','YYYY-MM-DD'), 'Liquidação que se faz conforme comprovante em anexo.', '08:57:32');

INSERT INTO empenho.nota_liquidacao
(exercicio, cod_nota, cod_entidade, exercicio_empenho, cod_empenho, dt_vencimento, dt_liquidacao, observacao, hora)
VALUES('2016', 964, 2, '2016', 1095, TO_DATE('2016-12-31','YYYY-MM-DD'), TO_DATE('2016-03-02','YYYY-MM-DD'), 'Liquidação que se faz conforme comprovante em anexo.','08:57:32');

INSERT INTO empenho.nota_liquidacao
(cod_nota, exercicio, cod_entidade, cod_empenho, exercicio_empenho, dt_vencimento, dt_liquidacao, observacao, hora)
VALUES (2, '2016', 2, 1095, '2016', '2016-12-31', '2016-12-20', 'Liquidação que se faz conforme comprovante em anexo.', '08:57:32');
