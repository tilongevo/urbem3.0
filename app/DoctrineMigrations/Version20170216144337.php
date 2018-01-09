<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170216144337 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) 
                        VALUES (nextval(\'administracao.rota_cod_rota_seq\'), \'urbem_recursos_humanos_pessoal_assentamento_movsefipsaida_create\', \'Adicionar Recolhimento FGTS\', \'urbem_recursos_humanos_pessoal_assentamento_sefip_list\');');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
