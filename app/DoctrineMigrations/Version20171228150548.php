<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171228150548 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("
            ALTER TABLE tcepr.cadastro_secretario 
            ADD COLUMN cod_norma_baixa INTEGER DEFAULT NULL,
            ADD COLUMN dt_baixa DATE DEFAULT NULL,
            ADD COLUMN descricao_baixa TEXT DEFAULT NULL
        ");

        $this->addSql('ALTER TABLE tcepr.cadastro_secretario ADD CONSTRAINT cadastro_secretario_cod_norma_baixa_fkey FOREIGN KEY (cod_norma_baixa) REFERENCES normas.norma(cod_norma)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE ONLY tcepr.cadastro_secretario DROP CONSTRAINT IF EXISTS cadastro_secretario_cod_norma_baixa_fkey;');

        $this->addSql("
            ALTER TABLE tcepr.cadastro_secretario
            DROP COLUMN cod_norma_baixa,
            DROP COLUMN dt_baixa, 
            DROP COLUMN descricao_baixa 
        ");
    }
}
