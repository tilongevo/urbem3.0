<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161128122734 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("CREATE OR REPLACE FUNCTION public.adiciona_coluna(schemaname VARCHAR, tablename VARCHAR, colname VARCHAR, coltype VARCHAR)
              RETURNS VARCHAR
            LANGUAGE plpgsql
            AS \$function$
            DECLARE
              col_name VARCHAR;
            BEGIN
              EXECUTE 'SELECT column_name FROM information_schema.columns WHERE table_schema = ' || quote_literal(schemaname) ||
                      ' AND table_name=' || quote_literal(tablename) || ' AND column_name= ' || quote_literal(colname)
              INTO col_name;
            
              RAISE INFO ' the val : % ', col_name;
              IF (col_name IS NULL)
              THEN
                col_name := colname;
                EXECUTE 'ALTER TABLE ' || schemaname || '.' || tablename || ' ADD COLUMN ' || colname || '  ' || coltype;
              ELSE
                col_name := colname || ' already exist';
              END IF;
              RETURN col_name;
            END; \$function$");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP FUNCTION public.adiciona_coluna(schemaname VARCHAR, tablename VARCHAR, colname VARCHAR, coltype VARCHAR)');
    }
}
