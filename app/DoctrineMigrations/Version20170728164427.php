<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170728164427 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('update pessoal.dependente set dt_inicio_sal_familia = now() where dt_inicio_sal_familia = \'0001-01-01\';');
        $this->addSql('update pessoal.dependente set dt_inicio_sal_familia = now() where dt_inicio_sal_familia = \'0001-01-01 BC\';');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('update pessoal.dependente set dt_inicio_sal_familia = now() where dt_inicio_sal_familia = \'0001-01-01\';');
        $this->addSql('update pessoal.dependente set dt_inicio_sal_familia = now() where dt_inicio_sal_familia = \'0001-01-01 BC\';');
    }
}
