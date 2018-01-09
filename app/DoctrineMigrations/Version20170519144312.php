<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Divida\Modalidade;
use Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170519144312 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(Modalidade::class, 'ultimo_timestamp');
        $this->addSql('DROP TRIGGER tr_atualiza_ultima_modalidade_divida ON divida.modalidade_vigencia');
        $this->changeColumnToDateTimeMicrosecondType(ModalidadeVigencia::class, 'timestamp');
        $this->addSql('create
                        trigger tr_atualiza_ultima_modalidade_divida before insert
                            or update
                                on
                                divida.modalidade_vigencia for each row execute procedure divida.fn_atualiza_ultima_modalidade_divida()');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
