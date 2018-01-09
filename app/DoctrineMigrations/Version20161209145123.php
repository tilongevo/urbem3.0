<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161209145123 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("UPDATE contabilidade.tipo_transferencia SET nom_tipo = 'Transferência de Recursos - Remanejamento'
          WHERE exercicio = '2016' AND nom_tipo = 'Tranferencia de Recursos - Remanejamento';");

        $this->addSql("UPDATE contabilidade.tipo_transferencia SET nom_tipo = 'Transferência de Recursos - Transferência'
          WHERE exercicio = '2016' AND nom_tipo = 'Tranferencia de Recursos - Transferência';");

        $this->addSql("UPDATE contabilidade.tipo_transferencia SET nom_tipo = 'Transferência de Recursos - Transposição'
          WHERE exercicio = '2016' AND nom_tipo = 'Tranferencia de Recursos - Transposição';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("UPDATE contabilidade.tipo_transferencia SET nom_tipo = 'Tranferencia de Recursos - Remanejamento'
          WHERE exercicio = '2016' AND nom_tipo = 'Transferência de Recursos - Remanejamento';");

        $this->addSql("UPDATE contabilidade.tipo_transferencia SET nom_tipo = 'Tranferencia de Recursos - Transferência'
          WHERE exercicio = '2016' AND nom_tipo = 'Transferência de Recursos - Transferência';");

        $this->addSql("UPDATE contabilidade.tipo_transferencia SET nom_tipo = 'Tranferencia de Recursos - Transposição'
          WHERE exercicio = '2016' AND nom_tipo = 'Transferência de Recursos - Transposição';");
    }
}
