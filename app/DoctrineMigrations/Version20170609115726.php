<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170609115726 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (in_array($this->container->getParameter("kernel.environment"), ['dev', 'test'])) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

            $sql = "select * from administracao.configuracao where cod_modulo = 14 and exercicio = '2017';";

            $conn = $this->connection;

            $sth = $conn->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_CLASS);

            if (!$result) {
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'numero_licenca', 'Exercicio');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'mascara_licenca', '999999');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'numero_inscricao_economica', 'Automatico');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'mascara_inscricao_economica', '9999');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'cnae_fiscal', 'Vincular');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'certidao_baixa', 'sim');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'nro_alvara_licenca', 'Exercicio');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'diretor_tributos', '5525');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'sanit_secretaria', 'Secretaria Municipal de Saúde');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 14, 'sanit_departamento', 'Vigilância Sanitária');");
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $sql = "delete from administracao.configuracao where cod_modulo = 14 and exercicio = '2017';";

        $conn = $this->connection;

        $sth = $conn->prepare($sql);
        $sth->execute();
    }
}
