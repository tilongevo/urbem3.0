<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170511144707 extends AbstractMigration
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

        $this->addSql('ALTER TABLE public.sw_cep_logradouro ALTER COLUMN num_final DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cep_logradouro ALTER COLUMN num_inicial DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cep ALTER COLUMN cep_anterior DROP NOT NULL;');
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

        $this->addSql('ALTER TABLE public.sw_cep_logradouro ALTER COLUMN num_final SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cep_logradouro ALTER COLUMN num_inicial SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cep ALTER COLUMN cep_anterior SET NOT NULL;');
    }
}
