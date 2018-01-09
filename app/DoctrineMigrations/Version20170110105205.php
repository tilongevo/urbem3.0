<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170110105205 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('DROP FUNCTION IF EXISTS stn.pl_saldo_contas(character varying, character varying, character varying, character varying, character varying)');

        $this->addSql('
            CREATE OR REPLACE FUNCTION stn.pl_saldo_contas(character varying, character varying, character varying, character varying, character varying)
             RETURNS numeric
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                exercicio alias for $1;
                data_ini  alias for $2;
                data_fim  alias for $3;
                condicao  alias for $4;
                stEntidades alias for $5;
                reRegistro RECORD;
                nuSaldo Numeric;
                stSql   varchar := \'\';
                stCondEntidades varchar;
            BEGIN
            
            stCondEntidades := \' \' ;
            
            if ( stEntidades <> \'\' ) then
                stCondEntidades := \' and valor_lancamento.cod_entidade in ( \' || stEntidades || \' ) \';
            end if; 
            
            
            stSql = \'select coalesce( 
                                        (  select sum ( valor_lancamento.vl_lancamento )
                                             from contabilidade.plano_conta
                                             join contabilidade.plano_analitica
                                               on ( plano_conta.exercicio = plano_analitica.exercicio 
                                              and   plano_conta.cod_conta = plano_analitica.cod_conta ) 
                                             join contabilidade.conta_credito
                                               on ( plano_analitica.exercicio = conta_credito.exercicio
                                              and   plano_analitica.cod_plano = conta_credito.cod_plano )
                                             join contabilidade.valor_lancamento 
                                               on ( conta_credito.exercicio    = valor_lancamento.exercicio 
                                              and   conta_credito.cod_entidade = valor_lancamento.cod_entidade 
                                              and   conta_credito.tipo         = valor_lancamento.tipo         
                                              and   conta_credito.cod_lote     = valor_lancamento.cod_lote     
                                              and   conta_credito.sequencia    = valor_lancamento.sequencia    
                                              and   conta_credito.tipo_valor   = valor_lancamento.tipo_valor )
                                             join contabilidade.lote 
                                               on ( valor_lancamento.exercicio    = lote.exercicio     
                                              and   valor_lancamento.cod_entidade = lote.cod_entidade  
                                              and   valor_lancamento.tipo         = lote.tipo          
                                              and   valor_lancamento.cod_lote     = lote.cod_lote )
                                            where  plano_conta.exercicio =  \'\'\' ||   exercicio || \'\'\' and  \' ||  condicao || \'
                                              and lote.dt_lote between to_date( \'\'\'|| data_ini ||\'\'\' , \'\'dd/mm/yyyy\'\' ) 
                                                                 and   to_date( \'\'\'|| data_fim ||\'\'\' , \'\'dd/mm/yyyy\'\' )  
                                              \' || stCondEntidades || \' ) , 0 )
                          + 
                          coalesce (
                           ( select sum (  
                                     valor_lancamento.vl_lancamento )
                                from contabilidade.plano_conta plano_conta
                                join contabilidade.plano_analitica
                                  on ( plano_conta.exercicio = plano_analitica.exercicio 
                                 and   plano_conta.cod_conta = plano_analitica.cod_conta ) 
                                join contabilidade.conta_debito
                                  on ( plano_analitica.exercicio = conta_debito.exercicio
                                 and   plano_analitica.cod_plano = conta_debito.cod_plano )
                                join contabilidade.valor_lancamento 
                                  on ( conta_debito.exercicio    = valor_lancamento.exercicio 
                                 and   conta_debito.cod_entidade = valor_lancamento.cod_entidade 
                                 and   conta_debito.tipo         = valor_lancamento.tipo         
                                 and   conta_debito.cod_lote     = valor_lancamento.cod_lote     
                                 and   conta_debito.sequencia    = valor_lancamento.sequencia    
                                 and   conta_debito.tipo_valor   = valor_lancamento.tipo_valor )
                                join contabilidade.lote 
                                  on ( valor_lancamento.exercicio    = lote.exercicio     
                                 and   valor_lancamento.cod_entidade = lote.cod_entidade  
                                 and   valor_lancamento.tipo         = lote.tipo          
                                 and   valor_lancamento.cod_lote     = lote.cod_lote )
                               where plano_conta.exercicio =  \'\'\' ||   exercicio || \'\'\' and  \' ||  condicao || \'
                                 and lote.dt_lote between to_date( \'\'\'|| data_ini ||\'\'\' , \'\'dd/mm/yyyy\'\' ) 
                                                    and   to_date( \'\'\'|| data_fim ||\'\'\' , \'\'dd/mm/yyyy\'\' ) 
                                 \' || stCondEntidades || \' ) , 0 )
                               as saldo \'; 
            
            FOR reRegistro IN EXECUTE stSql
            LOOP
                nuSaldo := reRegistro.saldo;
            END LOOP;
            
            
            return nuSaldo;
            end;
            $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP FUNCTION stn.pl_saldo_contas(character varying, character varying, character varying, character varying, character varying);');
    }
}
