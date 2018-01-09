<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161206100403 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS folhapagamento.regime_previdencia_cod_regime_previdencia_seq");
        $this->addSql("CREATE SEQUENCE folhapagamento.regime_previdencia_cod_regime_previdencia_seq START 1");

        $this->addSql("SELECT setval(
            'folhapagamento.regime_previdencia_cod_regime_previdencia_seq',
            COALESCE((SELECT MAX(cod_regime_previdencia) + 1
                      FROM folhapagamento.regime_previdencia), 1),
            FALSE
        );");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP SEQUENCE IF EXISTS folhapagamento.regime_previdencia_cod_regime_previdencia_seq");
    }
}
