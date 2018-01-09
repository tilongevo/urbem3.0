<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161207113952 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_baixa TYPE timestamp USING timestamp_baixa::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_baixa SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_baixa DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_baixa TYPE timestamp USING timestamp_baixa::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_baixa SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_baixa DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_ordem_pagamento ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_ordem_pagamento ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_ordem_pagamento ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_recibo_extra ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_recibo_extra ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_recibo_extra ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_transferencia ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_transferencia ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_transferencia ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_impressora_terminal ALTER COLUMN timestamp_terminal TYPE timestamp USING timestamp_terminal::timestamp;");
        $this->addSql("ALTER TABLE tesouraria.cheque_impressora_terminal ALTER COLUMN timestamp_terminal SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_impressora_terminal ALTER COLUMN timestamp_terminal DROP DEFAULT;");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_anulada ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_baixa TYPE timestamp USING timestamp_baixa::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_baixa SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa ALTER COLUMN timestamp_baixa DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_baixa TYPE timestamp USING timestamp_baixa::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_baixa SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_baixa_anulada ALTER COLUMN timestamp_baixa DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_ordem_pagamento ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_ordem_pagamento ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_ordem_pagamento ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_recibo_extra ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_recibo_extra ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_recibo_extra ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_transferencia ALTER COLUMN timestamp_emissao TYPE timestamp USING timestamp_emissao::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_transferencia ALTER COLUMN timestamp_emissao SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_emissao_transferencia ALTER COLUMN timestamp_emissao DROP DEFAULT;");

        $this->addSql("ALTER TABLE tesouraria.cheque_impressora_terminal ALTER COLUMN timestamp_terminal TYPE timestamp USING timestamp_terminal::date;");
        $this->addSql("ALTER TABLE tesouraria.cheque_impressora_terminal ALTER COLUMN timestamp_terminal SET NOT NULL;");
        $this->addSql("ALTER TABLE tesouraria.cheque_impressora_terminal ALTER COLUMN timestamp_terminal DROP DEFAULT;");
    }
}
