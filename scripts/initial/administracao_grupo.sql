TRUNCATE administracao.grupo CASCADE;

INSERT INTO administracao.grupo
(cod_grupo, nom_grupo, desc_grupo, ativo)
VALUES(nextval('administracao.grupo_seq'), 'Patrimonial', 'Usuários com acesso somente ao Patrimonial', true);
INSERT INTO administracao.grupo
(cod_grupo, nom_grupo, desc_grupo, ativo)
VALUES(nextval('administracao.grupo_seq'), 'Recursos Humanos', 'Usuários somente com acesso a recursos humanos', true);

INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 430);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 757);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 758);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 427);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 761);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 759);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 428);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 429);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 11);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 756);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 785);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 426);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 431);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 13);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 749);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 436);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 12);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 765);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 750);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 425);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 697);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 762);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 18);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 422);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 421);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 440);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 760);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 17);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 708);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 15);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 763);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 423);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 747);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 784);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 159);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 160);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 746);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 424);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 16);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 115);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 781);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 647);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 416);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 779);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 113);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 415);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 659);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 783);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 111);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 782);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 648);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 112);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 764);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 419);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 34);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 778);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 417);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 694);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 108);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 693);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 420);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 780);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 660);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 110);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 418);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 766);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 661);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 109);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(1, 786);
INSERT INTO administracao.grupo_permissao
(cod_grupo, cod_rota)
VALUES(2, 10);
