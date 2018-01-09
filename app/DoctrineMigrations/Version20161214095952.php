<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Administracao\AssinaturaCrc;
use Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161214095952 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('BEGIN;');

        $this->changeColumnToDateTimeMicrosecondType(Assinatura::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AssinaturaModulo::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AssinaturaCrc::class, 'timestamp');

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
