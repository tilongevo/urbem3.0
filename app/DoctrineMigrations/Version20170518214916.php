<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170518214916 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN cod_pais_corresp DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN cod_municipio_corresp DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN cod_uf_corresp DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN logradouro_corresp DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN numero_corresp DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN complemento_corresp DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN bairro_corresp DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN cep_corresp DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN fone_residencial DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN ramal_residencial DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN fone_comercial DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN ramal_comercial DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN fone_celular DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN e_mail DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN e_mail_adcional DROP NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN site DROP NOT NULL;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN cod_pais_corresp SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN cod_municipio_corresp SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN cod_uf_corresp SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN logradouro_corresp SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN numero_corresp SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN complemento_corresp SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN bairro_corresp SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN cep_corresp SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN fone_residencial SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN ramal_residencial SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN fone_comercial SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN ramal_comercial SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN fone_celular SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN e_mail SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN e_mail_adcional SET NOT NULL;');
        $this->addSql('ALTER TABLE public.sw_cgm ALTER COLUMN site SET NOT NULL;');
    }
}
