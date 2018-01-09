<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170109144658 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("CREATE TABLE IF NOT EXISTS almoxarifado.lancamento_ordem (
          cod_lancamento integer NOT NULL,
          cod_item integer NOT NULL,
          cod_marca integer NOT NULL,
          cod_almoxarifado integer NOT NULL,
          cod_centro integer NOT NULL,
          exercicio character(4) NOT NULL,
          cod_entidade integer NOT NULL,
          cod_ordem integer NOT NULL,
          tipo character(1) NOT NULL,
          cod_pre_empenho integer NOT NULL,
          exercicio_pre_empenho character(4) NOT NULL,
          num_item integer NOT NULL,
          CONSTRAINT pk_lancamento_ordem PRIMARY KEY (cod_lancamento, cod_item, cod_marca, cod_almoxarifado, cod_centro, exercicio, cod_entidade, cod_ordem, tipo, cod_pre_empenho, exercicio_pre_empenho, num_item),
          CONSTRAINT fk_lancamento_ordem_1 FOREIGN KEY (cod_lancamento, cod_item, cod_marca, cod_almoxarifado, cod_centro)
          REFERENCES almoxarifado.lancamento_material (cod_lancamento, cod_item, cod_marca, cod_almoxarifado, cod_centro),
          CONSTRAINT fk_lancamento_ordem_2 FOREIGN KEY (exercicio, cod_entidade, cod_ordem, tipo, cod_pre_empenho, exercicio_pre_empenho, num_item)
          REFERENCES compras.ordem_item (exercicio, cod_entidade, cod_ordem, tipo, cod_pre_empenho, exercicio_pre_empenho, num_item)
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
