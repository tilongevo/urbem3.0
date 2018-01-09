<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161101101939 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('
            CREATE or REPLACE VIEW empenho.vw_liquidacao_empenho_item AS
                SELECT
                      EE.cod_empenho
                     ,PE.cod_pre_empenho 
                     ,IE.num_item
                     ,IE.nom_item
                     ,IE.vl_total
                     ,empenho.fn_consultar_valor_empenhado_anulado_item(
                          EE.exercicio
                         ,EE.cod_empenho
                         ,EE.cod_entidade
                         ,IE.num_item
                       ) as vl_item_anulado
                     ,empenho.fn_consultar_valor_liquidado_item (
                          EE.exercicio
                         ,EE.cod_empenho
                         ,EE.cod_entidade
                         ,IE.num_item
                        ) as vl_item_liquidado
                     ,empenho.fn_consultar_valor_liquidado_anulado_item (
                          EE.exercicio
                         ,EE.cod_empenho
                         ,EE.cod_entidade
                         ,IE.num_item
                        ) as vl_item_liquidado_anulado
                FROM
                   empenho.pre_empenho      AS PE
                  ,empenho.item_pre_empenho AS IE
                  ,empenho.empenho          AS EE
                WHERE
                     PE.exercicio       = EE.exercicio
                AND  PE.cod_pre_empenho = EE.cod_pre_empenho
                AND  IE.cod_pre_empenho = PE.cod_pre_empenho
                AND  IE.exercicio       = PE.exercicio
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP VIEW empenho.liquidacao_empenho_item;');
    }
}
