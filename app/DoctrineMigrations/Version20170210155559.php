<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170210155559 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql("UPDATE public.sw_cgm_pessoa_juridica
SET dt_registro   = (SELECT TIMESTAMP '2009-01-01 00:00:00' +
                            random() * (TIMESTAMP '2017-01-01 00:00:00' -
                                        TIMESTAMP '2009-02-10 00:00:00')),
  dt_registro_cvm = (SELECT TIMESTAMP '2009-01-01 00:00:00' +
                            random() * (TIMESTAMP '2017-01-01 00:00:00' -
                                        TIMESTAMP '2009-02-10 00:00:00'));");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() != 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );
    }
}
