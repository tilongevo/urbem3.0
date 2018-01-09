<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161027165102 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        
        $this->addSql('
        CREATE OR REPLACE VIEW orcamento.reserva AS
            SELECT rs.cod_reserva,
            rs.exercicio,
            rs.cod_despesa,
            rs.dt_validade_inicial,
            rs.dt_validade_final,
            rs.dt_inclusao,
            rs.vl_reserva,
               CASE
                   WHEN rsa.cod_reserva > 0 THEN true
                   ELSE false
               END AS anulada
            FROM orcamento.reserva_saldos rs
            LEFT JOIN orcamento.reserva_saldos_anulada rsa ON rs.cod_reserva = rsa.cod_reserva AND rs.exercicio = rsa.exercicio;
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP VIEW orcamento.reserva;');
    }
}
