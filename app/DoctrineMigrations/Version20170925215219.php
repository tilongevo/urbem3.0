<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170925215219 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION contabilidade.fn_recupera_conta_lancamento(character varying, integer, integer, character varying, integer, character varying)
                         RETURNS integer
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            stExercicio     ALIAS FOR $1;
                            inCodEntidade   ALIAS FOR $2;
                            inCodLote       ALIAS FOR $3;
                            stTipo          ALIAS FOR $4;
                            inSequencia     ALIAS FOR $5;
                            stTipoValor     ALIAS FOR $6;
                            inCodPlano      INTEGER;
                        
                        BEGIN
                        
                              SELECT CASE WHEN CVL.tipo_valor = \'D\'
                                          THEN CCD.cod_plano
                                          ELSE CCC.cod_plano
                                      END AS cod_plano
                                     INTO inCodPlano
                                FROM contabilidade.valor_lancamento  AS CVL
                           -- Join com conta_debito
                           LEFT JOIN contabilidade.conta_debito AS CCD
                                  ON CVL.exercicio    = CCD.exercicio
                                 AND CVL.cod_entidade = CCD.cod_entidade
                                 AND CVL.tipo         = CCD.tipo
                                 AND CVL.cod_lote     = CCD.cod_lote
                                 AND CVL.sequencia    = CCD.sequencia
                                 AND CVL.tipo_valor   = CCD.tipo_valor
                            -- join com conta_credito
                           LEFT JOIN contabilidade.conta_credito AS CCC
                                  ON CVL.exercicio    = CCC.exercicio
                                 AND CVL.cod_entidade = CCC.cod_entidade
                                 AND CVL.tipo         = CCC.tipo
                                 AND CVL.cod_lote     = CCC.cod_lote
                                 AND CVL.sequencia    = CCC.sequencia
                                 AND CVL.tipo_valor   = CCC.tipo_valor
                            -- Filtros
                               WHERE CVL.exercicio    = stExercicio
                                 AND CVL.cod_entidade = inCodEntidade
                                 AND CVL.tipo         = stTipo
                                 AND CVL.cod_lote     = inCodLote
                                 AND CVL.sequencia    = inSequencia
                                 AND CVL.tipo_valor   = stTipoValor
                            ;
                        
                            RETURN inCodPlano;
                        
                        END;
                        $function$;
                        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP FUNCTION IF EXISTS  contabilidade.fn_recupera_conta_lancamento(character varying, integer, integer, character varying, integer, character varying);');
    }
}
