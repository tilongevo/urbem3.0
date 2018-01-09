<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\Yaml\Yaml;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170807135649 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $modulesList = $this->container->get('kernel')->getRootDir() . "/config/common/modules.yml";
        $modulesList = Yaml::parse(file_get_contents($modulesList));

        $module = new ModuloModel($this->container->get('doctrine.orm.entity_manager'));
        $module->saveMenuModule($modulesList['parameters']['modules']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
