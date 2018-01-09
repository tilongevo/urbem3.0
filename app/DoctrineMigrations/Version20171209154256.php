<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171209154256 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("
            INSERT INTO administracao.modulo 
                        (cod_modulo, cod_responsavel, nom_modulo, nom_diretorio, ordem, cod_gestao, ativo) 
                 VALUES ((SELECT MAX(cod_modulo)+1 FROM administracao.modulo), 0, 'TCE - PR', 'TCEPR/', 99, 6, true)");

        $this->addSql("
            INSERT INTO administracao.configuracao
                        (exercicio, cod_modulo, parametro, valor)
                 VALUES (
                          2016,
                          (SELECT cod_modulo FROM administracao.modulo WHERE nom_diretorio = 'TCEPR/' LIMIT 1),
                          'entidade_gestao_cod_entidade',
                          0
                        )
        ");

        $this->addSql("
            INSERT INTO administracao.configuracao
                        (exercicio, cod_modulo, parametro, valor)
                 VALUES (
                          2016,
                          (SELECT cod_modulo FROM administracao.modulo WHERE nom_diretorio = 'TCEPR/' LIMIT 1),
                          'entidade_gestao_exercicio',
                          0
                        )
        ");

        $this->addSql("
            INSERT INTO administracao.configuracao
                        (exercicio, cod_modulo, parametro, valor)
                 VALUES (
                          2016,
                          (SELECT cod_modulo FROM administracao.modulo WHERE nom_diretorio = 'TCEPR/' LIMIT 1),
                          'id_entidade_tce',
                          0
                        )
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("DELETE FROM administracao.configuracao WHERE cod_modulo = (SELECT cod_modulo FROM administracao.modulo WHERE nom_diretorio = 'TCEPR/' LIMIT 1)");
        $this->addSql("DELETE FROM administracao.modulo WHERE nom_diretorio = 'TCEPR/' LIMIT 1");
    }
}
