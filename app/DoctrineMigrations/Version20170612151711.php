<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170612151711 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(ImovelVVenal::class, 'timestamp');
        $this->insertRoute('tributario_arrecadacao_movimentacoes_home', 'Arrecadação - Movimentações', 'tributario');
        $this->insertRoute('urbem_tributario_arrecadacao_movimentacoes_avaliacao_imobiliaria_list', 'Avaliação Imobiliária', 'tributario_arrecadacao_movimentacoes_home');
        $this->insertRoute('urbem_tributario_arrecadacao_movimentacoes_avaliacao_imobiliaria_edit', 'Incluir', 'urbem_tributario_arrecadacao_movimentacoes_avaliacao_imobiliaria_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
