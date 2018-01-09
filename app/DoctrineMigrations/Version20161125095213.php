<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161125095213 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('
        CREATE OR REPLACE FUNCTION patrimonio.fn_carga_inventario_patrimonio(character varying, integer, integer)
             RETURNS integer
             LANGUAGE plpgsql
            AS $function$
            DECLARE

                stExercicio   ALIAS FOR $1;
                idInventario  ALIAS FOR $2;
                idNumCgm      ALIAS FOR $3;

            BEGIN

                INSERT INTO  patrimonio.inventario_historico_bem
                        (
                              exercicio
                           ,  id_inventario
                           ,  cod_bem
                           ,  timestamp_historico
                           ,  timestamp
                           ,  cod_situacao
                           ,  cod_local
                           ,  cod_orgao
                           ,  descricao
                        )

                   SELECT  stExercicio
                        ,  idInventario
                        ,  historico_bem.cod_bem
                        ,  historico_bem.timestamp
                        ,  NOW()::timestamp(3)
                        ,  historico_bem.cod_situacao
                        ,  historico_bem.cod_local
                        ,  historico_bem.cod_orgao
                        ,  \'\'

                     FROM  patrimonio.historico_bem

               INNER JOIN  patrimonio.bem
                       ON  bem.cod_bem = historico_bem.cod_bem

               INNER JOIN  (
                               SELECT  cod_bem
                                    ,  MAX(timestamp) AS timestamp
                                 FROM  patrimonio.historico_bem
                             GROUP BY  cod_bem
                           ) as resumo
                   ON  resumo.cod_bem   = historico_bem.cod_bem
                  AND  resumo.timestamp = historico_bem.timestamp

                    WHERE  1=1

                      AND  NOT EXISTS
                           (
                                SELECT  1
                                  FROM  patrimonio.bem_baixado
                                 WHERE  bem_baixado.cod_bem = bem.cod_bem
                           )  ORDER BY  historico_bem.cod_bem;

              RETURN 1;

            END
            $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP FUNCTION patrimonio.fn_carga_inventario_patrimonio(character varying, integer, integer);');
    }
}
