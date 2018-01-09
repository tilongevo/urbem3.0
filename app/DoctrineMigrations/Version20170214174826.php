<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170214174826 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("delete from administracao.configuracao where exercicio = '2017' and cod_modulo = 6;");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'grupo_contas_permanente', '1.4.0.0.0.00.00.00.00.00');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'placa_alfanumerica', 'false');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'texto_ficha_transferencia', '');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'atualizacao_valor', 'current_date');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'mascara_placa_bem', '');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'xml_rodape_patrimonial', 'patrimonio/relatorios/rodape.xml');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'substituir_depreciacao', '');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'alterar_bens_exercicio_anterior', 't');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'coletora_digitos_local', '');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'coletora_digitos_placa', '');");
        $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 6, 'coletora_separador', '');");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
