<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170519203335 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN insc_estadual DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN cod_orgao_registro DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN num_registro DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN dt_registro DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN num_registro_cvm DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN dt_registro_cvm DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN objeto_social DROP NOT NULL;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN insc_estadual SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN cod_orgao_registro SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN num_registro SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN dt_registro SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN num_registro_cvm SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN dt_registro_cvm SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm_pessoa_juridica ALTER COLUMN objeto_social SET NOT NULL;');
    }
}
