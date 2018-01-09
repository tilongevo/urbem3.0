<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para processar o sequence da tabela licitacao.documento
 */
class Version20161215104715 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP SEQUENCE IF EXISTS licitacao.cod_documento_seq");
        $this->createSequence('licitacao.cod_documento_seq', 'licitacao', 'documento', 'cod_documento');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->dropSequence('licitacao.cod_documento_seq', 'licitacao', 'documento', 'cod_documento');
    }
}
