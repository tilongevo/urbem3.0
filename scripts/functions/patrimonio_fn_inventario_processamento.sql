CREATE OR REPLACE FUNCTION patrimonio.fn_inventario_processamento(character varying, integer)
 RETURNS integer
 LANGUAGE plpgsql
AS $_$
DECLARE

    stExercicio   ALIAS FOR $1;
    idInventario  ALIAS FOR $2;

BEGIN

  INSERT INTO  patrimonio.historico_bem
  
       SELECT
               inventario_historico_bem.cod_orgao
            ,  inventario_historico_bem.cod_local
            ,  inventario_historico_bem.cod_situacao
            ,  inventario_historico_bem.cod_bem
            ,  NOW()::timestamp(3)
            ,  inventario_historico_bem.descricao
            
         FROM  patrimonio.inventario_historico_bem
         
   INNER JOIN  patrimonio.bem
           ON  bem.cod_bem = inventario_historico_bem.cod_bem
   
        WHERE  1=1
  
          AND  inventario_historico_bem.id_inventario = idInventario
          AND  inventario_historico_bem.exercicio     = stExercicio;

  RETURN 1;
 
END
$_$;
