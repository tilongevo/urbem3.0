<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170629140338 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (in_array($this->container->getParameter("kernel.environment"), ['dev', 'test'])) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

            $sql = "select * from administracao.configuracao where cod_modulo = 25 and exercicio = '2017' and parametro = 'super_simples';";

            $conn = $this->connection;

            $sth = $conn->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_CLASS);

            if (!$result) {
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'super_simples', '{{, \"\"},{2, \"2000\"}}');");
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
