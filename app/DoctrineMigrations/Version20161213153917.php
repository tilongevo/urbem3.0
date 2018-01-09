<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161213153917 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("
            CREATE OR REPLACE FUNCTION public.recupera_foreign_key_name(relatedschema_name VARCHAR, relatedtable_name VARCHAR, schema_name VARCHAR, table_name VARCHAR) RETURNS VARCHAR LANGUAGE plpgsql AS \$function$
            DECLARE
              fk_name VARCHAR;
            BEGIN
              EXECUTE 'SELECT pg_constraint.conname AS fk_name ' ||
                      'FROM pg_class class_1, pg_class class_2, pg_constraint, pg_attribute attr_1, ' ||
                        'pg_attribute attr_2, pg_namespace namespace_1, pg_namespace namespace_2 ' ||
                      'WHERE pg_constraint.conrelid = class_1.oid ' ||
                        'AND class_2.oid = pg_constraint.confrelid ' ||
                        'AND attr_1.attnum = pg_constraint.confkey [1] ' ||
                        'AND attr_1.attrelid = class_2.oid ' ||
                        'AND attr_2.attnum = pg_constraint.conkey [1] ' ||
                        'AND attr_2.attrelid = class_1.oid ' ||
                        'AND namespace_1.oid = class_1.relnamespace ' ||
                        'AND class_1.relname = ' || quote_literal(table_name) || '::VARCHAR ' ||
                        'AND class_2.relname = ' || quote_literal(relatedtable_name) || '::VARCHAR ' ||
                        'AND class_2.relkind = ' || quote_literal('r') || '::VARCHAR ' ||
                        'AND namespace_1.nspname = ' || quote_literal(schema_name) || '::VARCHAR ' ||
                        'AND namespace_2.nspname = ' || quote_literal(relatedschema_name) || '::VARCHAR '
              INTO fk_name;
              RETURN fk_name;
            END; \$function$
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP FUNCTION public.recupera_foreign_key_name(relatedschema_name VARCHAR, relatedtable_name VARCHAR, schema_name VARCHAR, table_name VARCHAR);');
    }
}
