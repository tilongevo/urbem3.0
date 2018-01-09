SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = empenho, pg_catalog;

INSERT INTO empenho.pagamento_liquidacao
(cod_ordem, exercicio, cod_entidade, exercicio_liquidacao, cod_nota, vl_pagamento)
VALUES(1, '2016', 2, '2016', 1, 379.83);

INSERT INTO empenho.pagamento_liquidacao
(cod_ordem, exercicio, cod_entidade, exercicio_liquidacao, cod_nota, vl_pagamento)
VALUES (1094, '2016', 2, '2016', 964, 200.00);

INSERT INTO empenho.pagamento_liquidacao
(cod_ordem, exercicio, cod_entidade, exercicio_liquidacao, cod_nota, vl_pagamento)
VALUES (1094, '2016', 2, '2016', '2', 1650.00);
