<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170125135604 extends AbstractMigration
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

        $this->addSql('ALTER TABLE licitacao.adjudicacao
            ADD FOREIGN KEY (cod_entidade, cod_modalidade, cod_licitacao, exercicio_licitacao) REFERENCES licitacao.licitacao (cod_entidade, cod_modalidade, cod_licitacao, exercicio) ON UPDATE NO ACTION ON DELETE NO ACTION;
        ');
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
        $this->addSql('ALTER TABLE licitacao.adjudicacao
            DROP CONSTRAINT adjudicacao_cod_entidade_fkey;
        ');
    }
}
