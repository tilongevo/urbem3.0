<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171205125705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql(
            sprintf(
                "INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor)
                VALUES ('%s', %s, 'ppa_diversos_orgaos', 'N');",
                date('Y'),
                Modulo::MODULO_PLANO_PLURIANUAL
            )
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
