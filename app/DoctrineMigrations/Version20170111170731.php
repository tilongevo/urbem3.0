<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170111170731 extends AbstractMigration
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

        $schema = 'almoxarifado';
        $column = 'alias';
        $table = 'tipo_item';

        if (false == $this->hasColumn($schema, $table, $column)) {
            $this->addSql('ALTER TABLE almoxarifado.tipo_item ADD alias VARCHAR CONSTRAINT uk_tipo_item UNIQUE;');

            $conn = $this->connection;
            $stmt = $conn->prepare('SELECT * FROM almoxarifado.tipo_item;');
            $stmt->execute();

            $items = $stmt->fetchAll();

            foreach ($items as $item) {
                $descricaoWSpecialChars = iconv('utf-8', 'ascii//TRANSLIT', $item['descricao']);
                $descricaoWSpace = str_replace(' ', '_', $descricaoWSpecialChars);
                $machineName = strtolower($descricaoWSpace);

                $this->addSql(
                    'UPDATE almoxarifado.tipo_item SET alias = :alias WHERE cod_tipo = :cod_tipo',
                    array_merge([
                        'alias' => $machineName,
                        'cod_tipo' => $item['cod_tipo']
                    ])
                );
            }

            $this->addSql('ALTER TABLE almoxarifado.tipo_item ALTER COLUMN alias SET NOT NULL;');
        }
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

        $this->addSql('ALTER TABLE almoxarifado.tipo_item DROP COLUMN IF EXISTS alias VARCHAR;');
    }
}
