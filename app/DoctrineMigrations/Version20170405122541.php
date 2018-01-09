<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170405122541 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->createSequence('imobiliario.localizacao_seq', 'imobiliario', 'localizacao', 'cod_localizacao');

        $this->addSql("
            CREATE OR REPLACE function public.fn_add_col(_tbl regclass, _col  text, _type regtype)
              RETURNS bool AS
            \$func$
            BEGIN
               IF EXISTS (SELECT 1 FROM pg_attribute
                          WHERE  attrelid = _tbl
                          AND    attname = _col
                          AND    NOT attisdropped) THEN
                  RETURN FALSE;
               ELSE
                  EXECUTE format('ALTER TABLE %s ADD COLUMN %I %s', _tbl, _col, _type);
                  RETURN TRUE;
               END IF;
            END
            \$func$  LANGUAGE plpgsql;
        ");
        $this->addSql("SELECT public.fn_add_col('imobiliario.lote_localizacao', 'localizacao', 'text');");
        $this->addSql("DROP FUNCTION public.fn_add_col(_tbl regclass, _col  text, _type regtype);");

        $this->insertRoute('urbem_tributario_imobiliario_localizacao_list', 'Cadastro Imobiliário - Localização', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_create', 'Incluir', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_edit', 'Alterar', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_delete', 'Excluir', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_show', 'Detalhe', 'urbem_tributario_imobiliario_localizacao_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
