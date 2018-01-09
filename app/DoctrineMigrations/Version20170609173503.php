<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170609173503 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $sql = "SELECT * FROM information_schema.columns
                WHERE table_schema = 'monetario'
                AND table_name = 'credito'
                AND column_name = 'i_receitas';";

        $conn = $this->connection;

        $sth = $conn->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_CLASS);

        if (!$result) {
            $this->addSql('ALTER TABLE monetario.credito ADD COLUMN i_receitas int4 NULL DEFAULT NULL;');
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('ALTER TABLE monetario.credito DROP COLUMN i_receitas;');
    }
}
