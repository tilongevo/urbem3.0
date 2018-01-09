<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento;
use Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamentoExcluido;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170410140023 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(CondicaoAssentamento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CondicaoAssentamentoExcluido::class, 'timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
