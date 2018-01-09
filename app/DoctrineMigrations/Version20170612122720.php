<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170612122720 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if (in_array($this->container->getParameter("kernel.environment"), ['dev', 'test'])) {
            $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

            $sql = "select * from administracao.configuracao where cod_modulo = 25 and exercicio = '2017';";

            $conn = $this->connection;

            $sth = $conn->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_CLASS);

            if (!$result) {
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'nota_avulsa', 'sim');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'super_simples', '{{1, \"2017\"},{3, \"2017\"}}');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'tipo_avaliacao', 'absoluto');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'valor_maximo', '100');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'vias_nota_avulsa', '2');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'ativar_suspencao ', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'baixa_manual', 'aceita');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'baixa_manual_divida_vencida', '60');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'baixa_manual_unica', 'sim');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'carne_dam', '.');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'carne_departamento', '.');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'carne_secretaria', '.');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'convenio_parcelamento', '345');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'emissao_cpf', 'emitir');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'escrituracao_receita', '1/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_diferenca_acrescimo_geral', '1/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_diferenca_acrescimo_imob', '1/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_diferenca_econ', '1/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_diferenca_geral', '1/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_diferenca_imob', '1/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'minimo_lancamento_automatico', '100');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'imprimir_carne_isento', '');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_nota_avulsa', '1/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_credito_iptu', '1/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'FEBRABAN', '9999');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'fundamentacao_legal', '007198/2016 ');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_credito_itbi', '3/2016');");
                $this->addSql("INSERT INTO administracao.configuracao (exercicio, cod_modulo, parametro, valor) VALUES('2017', 25, 'grupo_diferenca_acrescimo_econ', '1/2016');");
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $sql = "delete from administracao.configuracao where cod_modulo = 25 and exercicio = '2017';";

        $conn = $this->connection;

        $sth = $conn->prepare($sql);
        $sth->execute();
    }
}
