<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171212165553 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        
        $this->addSql('CREATE EXTENSION IF NOT EXISTS "pg_trgm";');
        $this->addSql("
            DO $$
                BEGIN
                IF (SELECT indexname FROM pg_indexes WHERE tablename = 'sw_nome_logradouro' and indexname = 'idx_gin_trgm_swnomelogradouro_nomlogradouro') IS NULL THEN
                    CREATE INDEX idx_gin_trgm_swnomelogradouro_nomlogradouro ON public.sw_nome_logradouro USING gin (nom_logradouro gin_trgm_ops);
                END IF;
            END$$;
        ");
        $this->addSql("
            DO $$
                BEGIN
                IF (SELECT indexname FROM pg_indexes WHERE tablename = 'sw_municipio' and indexname = 'idx_gin_trgm_swmunicipio_nommunicipio') IS NULL THEN
                    CREATE INDEX idx_gin_trgm_swmunicipio_nommunicipio ON public.sw_municipio USING gin (nom_municipio gin_trgm_ops);
                END IF;
            END$$;
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        
        $this->addSql("
            DO $$
                BEGIN
                IF (SELECT indexname FROM pg_indexes WHERE tablename = 'sw_nome_logradouro' and indexname = 'idx_gin_trgm_swnomelogradouro_nomlogradouro') IS NOT NULL THEN
                    DROP INDEX idx_gin_trgm_swnomelogradouro_nomlogradouro;
                END IF;
            END$$;
        ");
        $this->addSql("
            DO $$
                BEGIN
                IF (SELECT indexname FROM pg_indexes WHERE tablename = 'sw_municipio' and indexname = 'idx_gin_trgm_swmunicipio_nommunicipio') IS NOT NULL THEN
                    DROP INDEX idx_gin_trgm_swmunicipio_nommunicipio;
                END IF;
            END$$;
        ");
        $this->addSql('DROP EXTENSION IF EXISTS "pg_trgm";');
    }
}
