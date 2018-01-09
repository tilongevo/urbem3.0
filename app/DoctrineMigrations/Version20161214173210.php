<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161214173210 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('BEGIN;');
        $this->addSql('ALTER TABLE compras.homologacao ALTER exercicio_compra_direta TYPE VARCHAR(4);');
        $this->addSql('ALTER TABLE compras.homologacao ALTER exercicio_cotacao TYPE VARCHAR(4);');
        $this->addSql('ALTER TABLE compras.homologacao ALTER exercicio TYPE VARCHAR(4);');
        $this->addSql('ALTER TABLE compras.homologacao ALTER "timestamp" DROP DEFAULT;');
        $this->addSql('COMMIT;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
