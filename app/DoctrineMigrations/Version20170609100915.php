<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170609100915 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (in_array($this->container->getParameter("kernel.environment"), ['dev', 'test'])) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

            $conn = $this->connection;

            $sql = "SELECT * FROM administracao.configuracao WHERE cod_modulo = 12 and parametro IN ('codigo_localizacao', 'atrib_edificacao', 'atrib_imovel', 'atrib_lote_rural', 'atrib_lote_urbano') and exercicio = '2016';";

            $sth = $conn->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_CLASS);

            if (!$result) {
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2016', 12, 'atrib_edificacao', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2016', 12, 'atrib_imovel', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2016', 12, 'atrib_lote_rural', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2016', 12, 'atrib_lote_urbano', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2016', 12, 'codigo_localizacao', 'true');");
            }

            $sql2 = "SELECT * FROM administracao.configuracao WHERE cod_modulo = 12 and exercicio = '2017';";

            $sth2 = $conn->prepare($sql2);
            $sth2->execute();
            $result2 = $sth2->fetchAll(\PDO::FETCH_CLASS);

            if (!$result2) {
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'aliquotas', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'atrib_edificacao', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'atrib_imovel', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'atrib_lote_rural', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'atrib_lote_urbano', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'codigo_localizacao', 'true');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'mascara_inscricao', '9999');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'mascara_lote', '999XX');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'navegacao_automatica', 'ativo');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'numero_inscricao', 'true');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'ordem_entrega', '{{3, \"Endereço do imóvel\"},{1, \"Endereço do proprietário\"},{4, \"Endereço de entrega do imóvel\"},{2, \"Endereço do promitente\"}}');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES ('2017', 12, 'valor_md', '');");
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
