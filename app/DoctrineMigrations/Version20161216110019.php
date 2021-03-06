<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration para criar a view public.vw_pessoa_fisica_juridica
 */
class Version20161216110019 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("CREATE OR REPLACE VIEW public.vw_pessoa_fisica_juridica AS
              SELECT
                  CGM.numcgm,
                  CGM.nom_cgm,
                  PF.cpf,
                  PJ.cnpj,
                  CASE WHEN PF.cpf IS NOT NULL THEN PF.cpf ELSE PJ.cnpj END AS documento,
                  row_number() OVER () as rnum
              FROM
                 SW_CGM AS CGM
              LEFT JOIN
                 sw_cgm_pessoa_fisica AS PF
              ON
                 CGM.numcgm = PF.numcgm
              LEFT JOIN
                 sw_cgm_pessoa_juridica AS PJ
              ON
                 CGM.numcgm = PJ.numcgm
              WHERE
                 CGM.numcgm <> 0
              order by lower(cgm.nom_cgm)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DROP VIEW public.vw_pessoa_fisica_juridica");
    }
}
