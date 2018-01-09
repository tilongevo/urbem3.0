<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170210123147 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("ALTER TABLE  contabilidade.nota_explicativa
                       DROP CONSTRAINT IF EXISTS fk_nota_explicativa_1,
                       DROP CONSTRAINT IF EXISTS fk_b76e20cc77e925b,
                       ADD CONSTRAINT fk_nota_explicativa_1  FOREIGN KEY (cod_acao)
                       REFERENCES administracao.rota (cod_rota) DEFERRABLE INITIALLY DEFERRED;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
