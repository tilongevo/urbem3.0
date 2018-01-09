<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161202094407 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE OR REPLACE FUNCTION contabilidade.excluiencerramentoanuallancamentoscontrole2013(varexercicio character varying, intcodentidade integer)
             RETURNS void
             LANGUAGE plpgsql
            AS $function$
            DECLARE
               intCodLote INTEGER;
            BEGIN
            
                SELECT lote.cod_lote
                  INTO intCodLote
                  FROM contabilidade.lote
                     , contabilidade.lancamento
                 WHERE lote.exercicio           = varExercicio
                   AND lote.cod_entidade        = intCodEntidade
                   AND lote.tipo                = \'M\'
                   AND lote.dt_lote             = to_date(BTRIM(varExercicio::text) || \'-12-31\', \'yyyy-mm-dd\')
                   AND BTRIM(lote.nom_lote)     = \'Controle/\' || varExercicio
                   AND lote.exercicio           = lancamento.exercicio
                   AND lote.cod_entidade        = lancamento.cod_entidade
                   AND lote.tipo                = lancamento.tipo
                   AND lote.cod_lote            = lancamento.cod_lote
                   AND lancamento.cod_historico = 804
                 LIMIT 1
               ;
            
               IF FOUND THEN
                  Delete From contabilidade.empenhamento       where cod_lote = intCodlote And exercicio = varExercicio AND cod_entidade = intCodEntidade And tipo = \'M\';
                  Delete From contabilidade.lancamento_empenho where cod_lote = intCodlote And exercicio = varExercicio AND cod_entidade = intCodEntidade And tipo = \'M\';
                  Delete From contabilidade.conta_credito      where cod_lote = intCodlote And exercicio = varExercicio AND cod_entidade = intCodEntidade And tipo = \'M\';
                  Delete From contabilidade.conta_debito       where cod_lote = intCodlote And exercicio = varExercicio AND cod_entidade = intCodEntidade And tipo = \'M\';
                  Delete from contabilidade.valor_lancamento   where cod_lote = intCodlote And exercicio = varExercicio AND cod_entidade = intCodEntidade And tipo = \'M\';
                  Delete from contabilidade.lancamento         where cod_lote = intCodlote And exercicio = varExercicio AND cod_entidade = intCodEntidade And tipo = \'M\';
                  Delete from contabilidade.lote               where cod_lote = intCodlote And exercicio = varExercicio AND cod_entidade = intCodEntidade And tipo = \'M\';
               END IF;
            
               DELETE
                 FROM administracao.configuracao
                WHERE exercicio  =  varExercicio
                  AND cod_modulo = 9
                  AND parametro  = \'encer_ctrl_\' || BTRIM(TO_CHAR(intCodEntidade, \'9\'));
            
               RETURN;
            END;  $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP FUNCTION contabilidade.excluiencerramentoanuallancamentoscontrole2013(varexercicio character varying, intcodentidade integer)');
    }
}
