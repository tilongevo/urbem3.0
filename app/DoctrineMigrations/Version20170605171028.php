<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170605171028 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql(<<<SQL
CREATE TABLE IF NOT EXISTS pessoal.tipo_documento_digital (
    cod_tipo int4 NOT NULL,
    descricao varchar(100) NOT NULL,
    CONSTRAINT pk_tipo_documento_digital PRIMARY KEY (cod_tipo))
WITH (OIDS = FALSE);
SQL
        );

        $this->addSql(<<<SQL
CREATE TABLE IF NOT EXISTS pessoal.servidor_documento_digital (
    cod_servidor int4 NOT NULL,
    cod_tipo int4 NOT NULL,
    nome_arquivo varchar(100) NOT NULL,
    arquivo_digital varchar(250) NOT NULL,
    CONSTRAINT pk_servidor_documento_digital PRIMARY KEY (cod_servidor,
        cod_tipo),
    CONSTRAINT fk_servidor_documento_digital_1 FOREIGN KEY (cod_servidor) REFERENCES pessoal.servidor (cod_servidor),
    CONSTRAINT fk_servidor_documento_digital_2 FOREIGN KEY (cod_tipo) REFERENCES pessoal.tipo_documento_digital (cod_tipo))
WITH (OIDS = FALSE);
SQL
        );

        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_documento_digital_create', 'Documentos Digitais - Novo', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_documento_digital_edit', 'Documentos Digitais - Editar', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_documento_digital_delete', 'Documentos Digitais - Apagar', 'urbem_recursos_humanos_pessoal_servidor_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

    }
}
