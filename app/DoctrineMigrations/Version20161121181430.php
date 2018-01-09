<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Class Version20161121181430
 * @package Application\Migrations
 */
class Version20161121181430 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // fkFrotaMarca
        $this->addSql('ALTER TABLE frota.veiculo DROP CONSTRAINT IF EXISTS FK_DE363A05C9253F02');
        $this->addSql('ALTER TABLE frota.veiculo ADD CONSTRAINT FK_DE363A05C9253F02 FOREIGN KEY (cod_marca)
            REFERENCES frota.marca (cod_marca) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('DROP INDEX IF EXISTS frota.idx_5833559bb16c0');
        $this->addSql('CREATE INDEX idx_5833559bb16c0 ON frota.veiculo (cod_marca)');

        // Sequence Veiculo
        $this->addSql("DROP SEQUENCE IF EXISTS frota.veiculo_seq");
        $this->addSql("CREATE SEQUENCE frota.veiculo_seq START 1");
        $this->addSql("SELECT setval(
            'frota.veiculo_seq',
            COALESCE((SELECT MAX(cod_veiculo)+1 FROM frota.veiculo), 1),
            false
        );");

        // Corrigindo validação de NULL dos campos prefixo e placa
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN prefixo DROP NOT NULL;');
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN prefixo SET DEFAULT \'\'::character varying;');

        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN placa DROP NOT NULL;');
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN placa SET DEFAULT \'\'::character varying;');

        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN chassi DROP NOT NULL;');
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN chassi SET DEFAULT \'\'::character varying;');

        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN categoria DROP NOT NULL;');
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN categoria SET DEFAULT \'\'::character varying;');

        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN cor DROP NOT NULL;');
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN cor SET DEFAULT \'\'::character varying;');

        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN capacidade DROP NOT NULL;');
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN capacidade SET DEFAULT \'\'::character varying;');

        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN potencia DROP NOT NULL;');
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN potencia SET DEFAULT \'\'::character varying;');

        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN cilindrada DROP NOT NULL;');
        $this->addSql('ALTER TABLE frota.veiculo ALTER COLUMN cilindrada SET DEFAULT \'\'::character varying;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // fkFrotaMarca
        $this->addSql('ALTER TABLE frota.veiculo DROP CONSTRAINT IF EXISTS FK_DE363A05C9253F02');
        $this->addSql('DROP INDEX IF EXISTS frota.idx_5833559bb16c0');

        // Sequence Veiculo
        $this->addSql("DROP SEQUENCE IF EXISTS frota.veiculo_seq");
    }
}
