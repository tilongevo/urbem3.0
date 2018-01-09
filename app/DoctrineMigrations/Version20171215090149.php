<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171215090149 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP VIEW IF EXISTS tcepr.view_pessoa_am");
        $this->addSql("CREATE VIEW tcepr.view_pessoa_am AS SELECT
cgm.numcgm,
CASE WHEN COALESCE(fisica.rg, '') <> '' THEN 1 ELSE 2 END AS tp_documento, -- tipo_documento_pessoa
TRIM(CASE WHEN COALESCE(fisica.rg, '') <> '' THEN fisica.rg ELSE fisica.cpf END) AS nr_documento,
TRIM(cgm.nom_cgm) AS nm_pessoa,
TRIM(cgm.logradouro) || ', ' || TRIM(cgm.numero) AS ds_endereco,
TRIM(cgm.cep) AS cd_cep,
municipio.cod_ibge AS cd_ibge,
uf.sigla_uf AS sg_uf
FROM sw_cgm_pessoa_fisica AS fisica
JOIN sw_cgm cgm ON (fisica.numcgm = cgm.numcgm)
JOIN sw_municipio municipio ON (cgm.cod_municipio = municipio.cod_municipio AND cgm.cod_uf = municipio.cod_uf)
JOIN sw_uf uf ON (municipio.cod_uf = uf.cod_uf)
WHERE (COALESCE(TRIM(fisica.rg, '')) <> '' OR COALESCE(TRIM(fisica.cpf, '')) <> '')
AND COALESCE(TRIM(cgm.logradouro, '')) <> ''
AND COALESCE(TRIM(cgm.cep), '') <> ''
UNION ALL
SELECT
cgm.numcgm,
3 AS tp_documento, -- tcepr.tipo_documento_pessoa
TRIM(juridica.cnpj) AS nr_documento,
TRIM(cgm.nom_cgm) AS nm_pessoa,
TRIM(cgm.logradouro) || ', ' || TRIM(cgm.numero) AS ds_endereco,
TRIM(cgm.cep) AS cd_cep,
municipio.cod_ibge AS cd_ibge,
uf.sigla_uf AS sg_uf
FROM sw_cgm_pessoa_juridica AS juridica
JOIN sw_cgm cgm ON (juridica.numcgm = cgm.numcgm)
JOIN sw_municipio municipio ON (cgm.cod_municipio = municipio.cod_municipio AND cgm.cod_uf = municipio.cod_uf)
JOIN sw_uf uf ON (municipio.cod_uf = uf.cod_uf)
WHERE COALESCE(TRIM(juridica.cnpj), '') <> '' AND COALESCE(TRIM(cgm.logradouro), '') <> '' AND COALESCE(TRIM(cgm.cep), '') <> '';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("DROP VIEW IF EXISTS tcepr.view_pessoa_am");
    }
}
