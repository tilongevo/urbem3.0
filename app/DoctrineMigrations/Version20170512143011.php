<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170512143011 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("ALTER TABLE ONLY administracao.auditoria ALTER COLUMN id SET DEFAULT nextval('administracao.auditoria_seq'::regclass)");

        $sql = "select tc.constraint_name, tc.table_schema, tc.table_name
                    from information_schema.table_constraints tc
                      join information_schema.key_column_usage kc 
                        on kc.table_name = tc.table_name and kc.table_schema = tc.table_schema
                    where 
                        tc.constraint_type = 'FOREIGN KEY'
                      and 
                      kc.position_in_unique_constraint is not null and tc.table_name = 'auditoria_detalhe'
                      group by tc.constraint_name, tc.table_schema, tc.table_name;";

        // Se tabela existir com mesmo número de colunas ignora
        $conn = $this->connection;

        $sth = $conn->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_CLASS);

        foreach ($result as $item) {
            $this->addSql("ALTER TABLE {$item->table_schema}.{$item->table_name} DROP CONSTRAINT {$item->constraint_name};");
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
