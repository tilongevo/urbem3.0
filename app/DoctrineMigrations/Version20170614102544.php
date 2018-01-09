<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170614102544 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (in_array($this->container->getParameter("kernel.environment"), ['dev', 'test'])) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

            $conn = $this->connection;

            $sql = "SELECT * FROM administracao.configuracao where cod_modulo = 2 and parametro = 'cod_uf' and exercicio = '2017';";

            $sth = $conn->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_CLASS);

            if (!$result) {
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 2, 'cod_uf', '11');");
            }

            $sql2 = "SELECT * FROM administracao.configuracao where cod_modulo = 2 and parametro = 'cod_municipio' and exercicio = '2017';";

            $sth2 = $conn->prepare($sql2);
            $sth2->execute();
            $result2 = $sth2->fetchAll(\PDO::FETCH_CLASS);

            if (!$result2) {
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 2, 'cod_municipio', '79');");
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
