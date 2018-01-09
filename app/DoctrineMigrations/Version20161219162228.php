<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20161219162228 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS administracao.acao_cod_acao_seq");
        $this->addSql("CREATE SEQUENCE administracao.acao_cod_acao_seq START 1");

        $this->addSql("UPDATE pg_attribute SET atttypmod = 55+100 WHERE attrelid = 'administracao.acao'::regclass AND attname = 'nom_acao';");
        $this->addSql("UPDATE pg_attribute SET atttypmod = 85+150 WHERE attrelid = 'administracao.acao'::regclass AND attname = 'nom_arquivo';");

        $this->addSql("SELECT setval(
            'administracao.acao_cod_acao_seq',
            COALESCE((SELECT MAX(cod_acao) + 1
                      FROM administracao.acao), 1),
            FALSE
        );");

        $this->addSql("insert into administracao.acao (cod_acao, cod_funcionalidade, nom_arquivo, parametro, ordem, complemento_acao, nom_acao, ativo)
                        select nextval('administracao.acao_cod_acao_seq') as cod_acao, 1 as cod_funcionalidade, r1.descricao_rota nom_arquivo, 'route_new_urbem' parametro,
                            CASE WHEN strpos(lower(r1.descricao_rota), 'administrativo') > 0 THEN 1
                                WHEN strpos(lower(r1.descricao_rota), 'recursos_humanos') > 0 THEN 2
                                WHEN strpos(lower(r1.descricao_rota), 'patrimonial') > 0 THEN 3
                                WHEN strpos(lower(r1.descricao_rota), 'financeiro') > 0 THEN 4
                                WHEN strpos(lower(r1.descricao_rota), 'prestacao_contas') > 0 THEN 5
                                ELSE 9
                            end as ordem,
                            r1.cod_rota as complemento_acao,
                            concat(r2.traducao_rota, ' > ' , r1.traducao_rota) AS nom_acao, true as ativo
                                FROM administracao.rota r1 JOIN administracao.rota r2 ON (r1.rota_superior = r2.descricao_rota)
                                where r2.traducao_rota <> '' and lower(r1.descricao_rota) like lower('%create%')
                                and (select complemento_acao from administracao.acao where complemento_acao::character = r1.cod_rota::character limit 1) is null
                        order by ordem, nom_acao;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
    }
}
