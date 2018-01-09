<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Beneficio\Beneficiario;
use Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170724122946 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Beneficiario::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BeneficiarioLancamento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BeneficiarioLancamento::class, 'timestamp_lancamento');
        $this->insertRoute('urbem_recursos_humanos_beneficio_beneficiario_importacao_mensal_create', 'Manter Importação Mensal', 'beneficio_plano_saude_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Beneficiario::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BeneficiarioLancamento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BeneficiarioLancamento::class, 'timestamp_lancamento');
        $this->insertRoute('urbem_recursos_humanos_beneficio_beneficiario_importacao_mensal_create', 'Manter Importação Mensal', 'beneficio_plano_saude_home');
    }
}
