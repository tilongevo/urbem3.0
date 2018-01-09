<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170427181020 extends AbstractMigration
{
    /**
     * Refatorando corretamente aonde a constraint de cod_usuario dentro de administracao.grupo_usuario deve ser
     * referenciada. Obs.: Já há uma migration onde é criada a tabela administracao.grupo_usuario e adicionada essa
     * constraint, porém la esta da forma incorreta.
     *
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE ONLY administracao.grupo_usuario DROP CONSTRAINT IF EXISTS fk_fcc5b1f3b0dd40c9;');
        $this->addSql('ALTER TABLE ONLY administracao.grupo_usuario ADD CONSTRAINT fk_fcc5b1f3b0dd40c9 FOREIGN KEY (cod_usuario) REFERENCES administracao.usuario(numcgm);');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE ONLY administracao.grupo_usuario DROP CONSTRAINT IF EXISTS fk_fcc5b1f3b0dd40c9;');
        $this->addSql('ALTER TABLE ONLY administracao.grupo_usuario ADD CONSTRAINT fk_fcc5b1f3b0dd40c9 FOREIGN KEY (cod_usuario) REFERENCES administracao.usuario(id);');
    }
}
