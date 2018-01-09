CREATE OR REPLACE FUNCTION orcamento.fn_reserva_saldo(pcod_reserva integer, pexercicio character, pcod_despesa integer, pdt_validade_inicial date, pdt_validade_final date, pvl_reserva numeric, ptipo character, pmotivo character varying)
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
DECLARE

    flSaldoDotacao numeric( 14,2 ) ;
    boRetorno boolean;

Begin

    boRetorno = false;

    lock table  orcamento.reserva_saldos in access exclusive mode;
    lock table  orcamento.reserva_saldos_anulada in access exclusive mode;

    select coalesce( fn_saldo_dotacao, 0 )  into flSaldoDotacao from empenho.fn_saldo_dotacao( pexercicio, pcod_despesa );
   
    if ( flSaldoDotacao >= pvl_reserva ) then 
     
            ----- incluindo a reserva
             insert into orcamento.reserva_saldos ( cod_reserva
                                                  , exercicio
                                                  , cod_despesa
                                                  , dt_validade_inicial
                                                  , dt_validade_final
                                                  , dt_inclusao
                                                  , vl_reserva
                                                  , tipo
                                                  , motivo )
                values (   pcod_reserva        
                         , pexercicio          
                         , pcod_despesa        
                         , pdt_validade_inicial
                         , pdt_validade_final  
                         , pdt_validade_inicial 
                         , pvl_reserva
                         , ptipo      
                         , pmotivo   );  



            boRetorno = true;
    end if; 
    

 RETURN boRetorno;

END;

$function$
