<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170627151305 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (in_array($this->container->getParameter("kernel.environment"), ['dev', 'test'])) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
            $date = new \DateTime();

            $sql = "select * from administracao.configuracao where cod_modulo = 43 and parametro = 'fontes_recurso' and exercicio = '{$date->format('Y')}';";

            $conn = $this->connection;

            $sth = $conn->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_CLASS);

            if (empty($result)) {
                $this->addSql("INSERT INTO administracao.configuracao (cod_modulo, parametro, valor, exercicio) VALUES(43, 'fontes_recurso', 'true', '{$date->format('Y')}');");
            } else {
                $this->addSql("UPDATE administracao.configuracao SET valor = 'true' WHERE exercicio = '{$date->format('Y')}' AND cod_modulo=43 AND parametro='fontes_recurso';");
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
