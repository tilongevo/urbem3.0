<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento;

/**
 * Class BorderoRepository
 * @package Urbem\CoreBundle\Repository\Financeiro\Tesouraria
 */
class BorderoRepository extends ORM\EntityRepository
{
    /**
     * @param array $params
     * @return mixed
     */
    public function ultimoCodigo(array $params)
    {
        $sql = <<<SQL
SELECT COALESCE(MAX(cod_bordero), 0) AS codigo 
FROM tesouraria.bordero 
WHERE exercicio = :exercicio 
  AND cod_entidade = :cod_entidade
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }

    /**
     * @param $entidade
     * @param $exercicio
     * @return array
     */
    public function findByContaPorEntidadeAndExercicio($entidade, $exercicio)
    {
        $sql = 'SELECT                                                                
                 pa.cod_plano                                                    
                ,pa.exercicio                                                    
                ,pc.cod_estrutural                                               
                ,pc.nom_conta                                                    
                ,pc.cod_conta                                                    
                , publico.fn_mascarareduzida(pc.cod_estrutural) as cod_reduzido  
                , pc.cod_classificacao,pc.cod_sistema                            
                , oe.cod_entidade                                               
                , pa.natureza_saldo,                                    
            CASE WHEN                                                            
                publico.fn_nivel(cod_estrutural) > 4 THEN 5                      
            ELSE                                                                 
                publico.fn_nivel(cod_estrutural)                                 
            END as nivel                                                         
            FROM                                                                 
                contabilidade.plano_conta as pc                                  
               ,contabilidade.plano_analitica as pa                              
               ,contabilidade.plano_banco as pb                                  
               ,orcamento.entidade as oe                                         
            WHERE                                                                
                pc.exercicio = pa.exercicio                                      
            AND pc.cod_conta = pa.cod_conta                                      
            AND pa.exercicio = pb.exercicio                                      
            AND pa.cod_plano = pb.cod_plano                                      
            AND pb.exercicio = oe.exercicio                                      
            AND pb.cod_entidade = oe.cod_entidade                                
         AND  pc.exercicio = :exercicio AND  pb.cod_entidade IN (:cod_entidade)                                                                          
            order by pc.cod_estrutural';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $entidade);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $entidade
     * @param $exercicio
     * @param $codRecurso
     * @param $codOrdem
     * @return array
     */
    public function findAllOrdemPagamento($entidade, $exercicio, $codRecurso, $codOrdem = null)
    {
        $sql = 'SELECT * FROM                                                                                                                        
	         (    SELECT                                                                                                                          
	                     EOP.COD_ORDEM,                                                                                                           
	                     EMP.EXERCICIO_EMPENHO,                                                                                                   
	                     EOP.EXERCICIO,                                                                                                           
	                     EOP.COD_ENTIDADE,                                                                                                        
	                     TO_CHAR(EOP.DT_VENCIMENTO, \'dd/mm/yyyy\') AS DT_VENCIMENTO,                                                               
	                     TO_CHAR(EOP.DT_EMISSAO, \'dd/mm/yyyy\') AS DT_EMISSAO,                                                                     
	                     CGMEMP.NOM_CGM AS BENEFICIARIO ,                                                                                            
	                     EMPENHO.fn_consultar_valor_pagamento_ordem(eop.EXERCICIO,eop.COD_ORDEM,eop.COD_ENTIDADE) AS VALOR_PAGAMENTO,             
	                     coalesce(eopa.vl_anulado,0.00) as vl_anulado,                                                                            
	                     EMP.CGM_BENEFICIARIO,                                                                                                    
	                     coalesce(sum(emp.vl_pago_nota),0.00) as vl_pago_nota,                                                                    
	                     replace(empenho.retorna_notas_empenhos(eop.exercicio,eop.cod_ordem,eop.cod_entidade),\'\',\'<br>\') as nota_empenho,         
	                     EMP.implantado                                                                                                           
	                FROM                                                                                                                          
	                     EMPENHO.ORDEM_PAGAMENTO AS EOP                                                                                           
	                     LEFT JOIN (                                                                                                              
	                             SELECT opa.cod_ordem                                                                                             
	                                   ,opa.exercicio                                                                                             
	                                   ,opa.cod_entidade                                                                                          
	                                   ,coalesce(sum(opla.vl_anulado),0.00) as vl_anulado                                                         
	                             FROM  EMPENHO.ORDEM_PAGAMENTO_ANULADA AS OPA                                                                     
	                                   JOIN empenho.ordem_pagamento_liquidacao_anulada as opla                                                    
	                                   ON (    opa.exercicio    = opla.exercicio                                                                  
	                                       AND opa.cod_ordem    = opla.cod_ordem                                                                  
	                                       AND opa.cod_entidade = opla.cod_entidade                                                               
	                                       AND opa.timestamp    = opla.timestamp                                                                  
	                                   )                                                                                                          
	                          GROUP BY opa.cod_ordem, opa.exercicio, opa.cod_entidade                                                             
	                     ) as EOPA ON (  eopa.cod_ordem = eop.cod_ordem                                                                           
	                                 AND eopa.exercicio = eop.exercicio                                                                           
	                                 AND eopa.cod_entidade = eop.cod_entidade                                                                     
	                     )                                                                                                                        
	                 LEFT JOIN                                                                                                                    
	                     (                                                                                                                        
	                     SELECT                                                                                                                   
	                         PL.COD_ORDEM,                                                                                                        
	                         PL.EXERCICIO,                                                                                                        
	                         PL.COD_ENTIDADE,                                                                                                     
	                         PE.CGM_BENEFICIARIO,                                                                                                 
	                         PE.IMPLANTADO,                                                                                                       
	                         NL.EXERCICIO_EMPENHO,                                                                                                
	                         NL.COD_EMPENHO,                                                                                                      
	                         NL.COD_NOTA,
	                         PE.cod_pre_empenho,                                                                                                         
	                         sum(NLP.vl_pago) as vl_pago_nota                                                                                     
	                     FROM                                                                                                                     
	                         EMPENHO.PAGAMENTO_LIQUIDACAO    as PL,                                                                               
	                         EMPENHO.NOTA_LIQUIDACAO         as NL                                                                                
	                         LEFT JOIN (                                                                                                          
	                                  SELECT nlp.exercicio                                                                                        
	                                        ,nlp.cod_entidade                                                                                     
	                                        ,nlp.cod_nota                                                                                         
	                                        ,nlp.timestamp                                                                                        
	                                        ,coalesce(sum(nlp.vl_pago),0.00) - coalesce(sum(nlp.vl_anulado),0.00) as vl_pago                      
	                                    FROM (SELECT  cod_nota                                                                                    
	                                                 ,cod_entidade                                                                                
	                                                 ,exercicio                                                                                   
	                                                 ,timestamp                                                                                   
	                                                 ,sum(vl_pago) as vl_pago                                                                     
	                                                 ,0.00 as vl_anulado                                                                          
	                                          FROM empenho.nota_liquidacao_paga                                                                   
	                                         GROUP BY cod_nota, timestamp, cod_entidade, exercicio, vl_anulado                                    
	                                                                                                                                              
	                                    UNION                                                                                                     
	                                                                                                                                              
	                                          SELECT cod_nota                                                                                     
	                                                ,cod_entidade                                                                                 
	                                                ,exercicio                                                                                    
	                                                ,timestamp                                                                                    
	                                                ,0.00 as vl_pago                                                                              
	                                                ,sum(vl_anulado) as vl_anulado                                                                
	                                          FROM  empenho.nota_liquidacao_paga_anulada                                                          
	                                         GROUP BY cod_nota, timestamp, cod_entidade, exercicio, vl_pago                                       
	                                        ) as NLP                                                                                              
	                                 GROUP BY nlp.exercicio, nlp.timestamp, nlp.cod_entidade, nlp.cod_nota                                        
	                         ) as NLP ON (   nlp.cod_nota = nl.cod_nota                                                                           
	                                     AND nlp.exercicio = nl.exercicio                                                                         
	                                     AND nlp.cod_entidade = nl.cod_entidade                                                                   
	                         ),                                                                                                                   
	                         EMPENHO.EMPENHO                 as E,                                                                                
	                         EMPENHO.PRE_EMPENHO             as PE                                                                               
	                     WHERE                                                                                                                    
	                         PL.COD_NOTA             = NL.COD_NOTA       AND                                                                      
	                         PL.EXERCICIO_LIQUIDACAO = NL.EXERCICIO      AND                                                                      
	                         PL.COD_ENTIDADE         = NL.COD_ENTIDADE   AND     
	                     pl.exercicio = :exercicio AND              pl.cod_entidade = :cod_entidade AND                                                                                                                                       
	                         NL.COD_EMPENHO          = E.COD_EMPENHO     AND                                                                      
	                         NL.EXERCICIO_EMPENHO    = E.EXERCICIO       AND                                                                      
	                         NL.COD_ENTIDADE         = E.COD_ENTIDADE    AND                                                                      
	                                                                                                                                              
	                         E.COD_PRE_EMPENHO       = PE.COD_PRE_EMPENHO    AND                                                                  
	                         E.EXERCICIO             = PE.EXERCICIO                                                                            
	                                                                                                                                              
	                 GROUP BY                                                                                                                     
	                         PL.COD_ORDEM,                                                                                                        
	                         PL.EXERCICIO,                                                                                                        
	                         PL.COD_ENTIDADE,                                                                                                     
	                         PE.CGM_BENEFICIARIO,                                                                                                 
	                         PE.IMPLANTADO,                                                                                                       
	                         NL.EXERCICIO_EMPENHO,                                                                                                
	                         NL.COD_EMPENHO,                                                                                                      
	                         NL.COD_NOTA,
	                         PE.cod_pre_empenho                                                                                                          
	                                                                                                                                              
	                 ) AS EMP ON (                                                                                                                
	                     EOP.COD_ORDEM       = EMP.COD_ORDEM AND                                                                                  
	                     EOP.EXERCICIO       = EMP.EXERCICIO AND                                                                                  
	                     EOP.COD_ENTIDADE    = EMP.COD_ENTIDADE                                                                                   
	                 )                                                                                                                            
	                 LEFT JOIN                                                                                                                    
	                     ORCAMENTO.ENTIDADE AS OE                                                                                                 
	                 ON                                                                                                                           
	                   ( OE.COD_ENTIDADE = EOP.COD_ENTIDADE                                                                                       
	                 AND OE.EXERCICIO    = EOP.EXERCICIO    )                                                                                     
	                 
	                LEFT JOIN SW_CGM as CGMEMP 
	                    ON CGMEMP.NUMCGM = EMP.CGM_BENEFICIARIO                                                          
	                
	                JOIN empenho.pre_empenho_despesa
	                    ON pre_empenho_despesa.exercicio = EMP.exercicio
	                    AND pre_empenho_despesa.cod_pre_empenho = EMP.cod_pre_empenho
	                
	                JOIN orcamento.despesa
	                    ON despesa.exercicio        = pre_empenho_despesa.exercicio
	                    AND despesa.cod_despesa     = pre_empenho_despesa.cod_despesa
	
	             WHERE eop.cod_ordem is not null   
	             AND eop.exercicio = :exercicio     AND eop.cod_entidade = :cod_entidade   and despesa.cod_recurso = :cod_recurso                                                                                                                                      
	            ';

        if (!empty($codOrdem)) {
            $sql .= " AND EOP.cod_ordem = :cod_ordem ";
        }

        $sql .= " GROUP BY eop.exercicio,eop.dt_vencimento,eop.dt_emissao,emp.exercicio_empenho,eop.COD_ORDEM,eop.COD_ENTIDADE,EMP.CGM_BENEFICIARIO,CGMEMP.nom_cgm,VALOR_PAGAMENTO,EMP.implantado,eopa.vl_anulado 
	                                                                                                                                              
	             ORDER BY eop.cod_ordem                                                                                                           
	         ) as tbl                                                                                                                             
	                                                                                                                                              
	         where (valor_pagamento - vl_anulado ) > vl_pago_nota ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $entidade);
        $query->bindValue('cod_recurso', $codRecurso);

        if (!empty($codOrdem)) {
            $query->bindValue('cod_ordem', $codOrdem);
        }

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codOrdem
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function findCodNota($codOrdem, $exercicio, $codEntidade)
    {
        $sql = '
        SELECT * FROM ( 
            SELECT             
            
                 eem.cod_empenho,                                        
                 eem.exercicio as ex_empenho,                            
                 to_char(eem.dt_empenho,\'dd/mm/yyyy\') as dt_empenho,     
                 enl.cod_nota,                                           
                 enl.exercicio as ex_nota,                               
                 to_char(enl.dt_liquidacao,\'dd/mm/yyyy\') as dt_nota,     
                 enl.cod_entidade,                                       
                 coalesce(sum(pag.vl_pago),0.00) as vl_pago, 
                 coalesce( (epl.vl_pagamento - coalesce(opla.vl_anulado,0.00))- coalesce(sum(pag.vl_pago),0.00), 0.00 ) as vl_pagamento, 
                 CASE WHEN ode.cod_recurso IS NOT NULL THEN ode.cod_recurso  
                  ELSE     rpe.recurso                                   
                 END as cod_recurso,                                     
                 ece.conta_contrapartida                                 
            FROM                                                        
                 empenho.pagamento_liquidacao as epl                   
            
                 left join (
                            select  opla.cod_nota             
                                   ,opla.exercicio_liquidacao 
                                   ,opla.cod_entidade         
                                   ,opla.cod_ordem            
                                   ,opla.exercicio           
                                   ,sum(opla.vl_anulado) as vl_anulado
            
                            from empenho.ordem_pagamento_liquidacao_anulada as opla 
                            group by opla.cod_nota             
                                    ,opla.exercicio_liquidacao 
                                    ,opla.cod_entidade         
                                    ,opla.cod_ordem            
                                    ,opla.exercicio           
                     ) as opla
                     on (
                              opla.cod_nota             = epl.cod_nota
                          AND opla.exercicio_liquidacao = epl.exercicio_liquidacao
                          AND opla.cod_entidade         = epl.cod_entidade
                          AND opla.cod_ordem            = epl.cod_ordem
                          AND opla.exercicio            = epl.exercicio
                        )
                 
                   left join 
                        ( 
                          select plnlp.exercicio 
                                ,plnlp.cod_entidade 
                                ,plnlp.cod_ordem 
                                ,plnlp.timestamp 
                                ,plnlp.cod_nota
                                ,plnlp.exercicio_liquidacao
                                ,coalesce(sum(tnlp.vl_pago),0.00) as vl_pago 
                          from empenho.pagamento_liquidacao_nota_liquidacao_paga as plnlp 
                          left join ( 
                          
                                     select  nlp.exercicio 
                                            ,nlp.cod_entidade 
                                            ,nlp.cod_nota 
                                            ,nlp.timestamp                                 
                                            ,coalesce( coalesce(vl_pago, 0.00)-coalesce(vl_pago_anulado,0.00), 0.00 ) as vl_pago 
                                     from empenho.nota_liquidacao_paga as nlp 
                                          left join ( 
                                                     select  nlpa.exercicio 
                                                            ,nlpa.cod_nota 
                                                            ,nlpa.cod_entidade 
                                                            ,nlpa.timestamp 
                                                            ,coalesce(sum(vl_anulado),0.00) as vl_pago_anulado 
                                                     from empenho.nota_liquidacao_paga_anulada as nlpa 
                                                     group by  nlpa.exercicio 
                                                              ,nlpa.cod_nota 
                                                              ,nlpa.cod_entidade 
                                                              ,nlpa.timestamp 
                                                    ) as nlpa 
                                                    on (     nlpa.exercicio    = nlp.exercicio 
                                                         and nlpa.cod_nota     = nlp.cod_nota 
                                                         and nlpa.cod_entidade = nlp.cod_entidade 
                                                         and nlpa.timestamp    = nlp.timestamp 
                                                       ) 
                                                     
                                                      
                                   ) as tnlp 
                                   on (     tnlp.exercicio    = plnlp.exercicio_liquidacao 
                                        and tnlp.cod_nota     = plnlp.cod_nota 
                                        and tnlp.cod_entidade = plnlp.cod_entidade 
                                        and tnlp.timestamp    = plnlp.timestamp 
                                      ) 
            
                          group by plnlp.exercicio 
                                  ,plnlp.cod_entidade 
                                  ,plnlp.cod_ordem 
                                  ,plnlp.timestamp 
                                  ,plnlp.cod_nota
                                  ,plnlp.exercicio_liquidacao
                                  
                        ) as pag 
            
                        on (     pag.exercicio    = epl.exercicio 
                             and pag.cod_entidade = epl.cod_entidade 
                             and pag.cod_ordem    = epl.cod_ordem 
                             and pag.cod_nota     = epl.cod_nota
                             and pag.exercicio_liquidacao = epl.exercicio_liquidacao
            
                           ) 
                 join empenho.nota_liquidacao as enl
                      on (
                               epl.exercicio_liquidacao = enl.exercicio            
                           AND epl.cod_nota = enl.cod_nota                         
                           AND epl.cod_entidade = enl.cod_entidade                 
                         )
            
                 join empenho.empenho as eem
                      on (
                               enl.exercicio_empenho = eem.exercicio               
                           AND enl.cod_entidade = eem.cod_entidade                 
                           AND enl.cod_empenho = eem.cod_empenho                   
                         )
                 join empenho.pre_empenho as epe                              
                      on (
                               eem.exercicio = epe.exercicio                       
                           AND eem.cod_pre_empenho = epe.cod_pre_empenho           
                         )
                 LEFT JOIN empenho.contrapartida_empenho as ece                    
                     ON (                                                          
                               eem.exercicio    = ece.exercicio                    
                           AND eem.cod_entidade = ece.cod_entidade                 
                           AND eem.cod_empenho  = ece.cod_empenho                  
                        )                                                          
                LEFT JOIN                                                
                 empenho.pre_empenho_despesa as epd                      
                ON  (                                                    
                             epe.exercicio = epd.exercicio               
                     AND     epe.cod_pre_empenho = epd.cod_pre_empenho   
                    )                                                    
                LEFT JOIN                                                
                 orcamento.despesa as ode                                
                ON  (                                                    
                             epd.exercicio = ode.exercicio               
                     AND     epd.cod_despesa = ode.cod_despesa           
                    )                                                    
                LEFT JOIN                                                
                 empenho.restos_pre_empenho as rpe                       
                ON   (                                                   
                             epe.exercicio = rpe.exercicio               
                     AND     epe.cod_pre_empenho = rpe.cod_pre_empenho   
                     )                                                   
             Where 1=1 
             AND epl.cod_ordem = :cod_ordem AND epl.exercicio = :exercicio AND epl.cod_entidade = (:cod_entidade)
            group by 
                eem.cod_empenho, 
                eem.exercicio, 
                to_char(eem.dt_empenho,\'dd/mm/yyyy\'), 
                enl.cod_nota, 
                enl.exercicio, 
                to_char(enl.dt_liquidacao,\'dd/mm/yyyy\'), 
                enl.cod_entidade, 
                epl.vl_pagamento, 
                opla.vl_anulado, 
                ode.cod_recurso, 
                rpe.recurso, 
                ece.conta_contrapartida 
             
             ORDER BY enl.cod_nota 
            
             ) as tbl ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->bindValue('cod_ordem', $codOrdem);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @param $codOrdem
     * @param $codNota
     * @return array
     */
    public function findValoresPorOrdemDePagamento($codEntidade, $exercicio, $codOrdem, $codNota)
    {
        $sql = 'select  liq.cod_entidade
               ,coalesce(tot_op.valor_op          ,0.00) as vl_total_op
               ,coalesce(ntpg.vl_pagamento        ,0.00) as vl_total_por_liquidacao  
               ,coalesce(ntpg.vl_pago_liq         ,0.00) as vl_pago 
               ,coalesce(ntpg.vl_pago_anulado_liq ,0.00) as vl_pago_anulado 
               ,ntpg.cod_ordem 
               ,coalesce(ntpg.vl_pagamento,0.00)-(coalesce(ntpg.vl_pago_liq,0.00)-coalesce(ntpg.vl_pago_anulado_liq ,0.00)) as vl_a_pagar
        
        from empenho.nota_liquidacao as liq 
            join (
                  select  pl.vl_pagamento
                         ,pl.cod_entidade
                         ,pl.cod_ordem
                         ,pl.exercicio
                         ,pl.cod_nota
                         ,pl.exercicio_liquidacao
                         ,plnlp.timestamp
                         ,nlp_nlpa.vl_pago    as vl_pago_liq
                         ,nlp_nlpa.vl_anulado as vl_pago_anulado_liq
                          
                  from empenho.pagamento_liquidacao as pl
                       left join empenho.pagamento_liquidacao_nota_liquidacao_paga as plnlp
                            on (    plnlp.cod_ordem    = pl.cod_ordem
                                and plnlp.exercicio    = pl.exercicio
                                and plnlp.cod_entidade = pl.cod_entidade
                                and plnlp.cod_nota = :cod_nota 
                               )
                       left join (
                                   select  nlp.cod_nota
                                          ,nlp.exercicio
                                          ,nlp.cod_entidade
                                          ,nlp.vl_pago
                                          ,nlpa.vl_anulado
                                          ,nlp.timestamp
                                          
                                   from empenho.nota_liquidacao_paga as nlp
                                        left join empenho.nota_liquidacao_paga_anulada as nlpa
                                             on (     nlp.cod_nota     = nlpa.cod_nota
                                                  and nlp.cod_entidade = nlpa.cod_entidade
                                                  and nlp.exercicio    = nlpa.exercicio
                                                  and nlp.timestamp    = nlpa.timestamp
                                                )
                                 ) as nlp_nlpa on (    nlp_nlpa.cod_nota     = plnlp.cod_nota
                                                   and nlp_nlpa.exercicio    = plnlp.exercicio_liquidacao
                                                   and nlp_nlpa.cod_entidade = plnlp.cod_entidade
                                                   and nlp_nlpa.timestamp    = plnlp.timestamp
                                                  )
                           
                 ) as ntpg on (     liq.cod_nota     = ntpg.cod_nota 
                                and liq.cod_entidade = ntpg.cod_entidade 
                                and liq.exercicio    = ntpg.exercicio_liquidacao
                              ) 
        
            join (
                  select  sum(vl_pagamento) as valor_op
                         ,cod_ordem
                         ,exercicio
                         ,cod_entidade
                         ,exercicio_liquidacao
                  from empenho.pagamento_liquidacao
                  group by  cod_ordem
                           ,exercicio
                           ,cod_entidade
                           ,exercicio_liquidacao
                 ) as tot_op on (     tot_op.cod_ordem    = ntpg.cod_ordem
                                  and tot_op.exercicio    = ntpg.exercicio
                                  and tot_op.cod_entidade = ntpg.cod_entidade
                                  and tot_op.exercicio_liquidacao = ntpg.exercicio_liquidacao
                                )
          
        
         WHERE  ntpg.cod_entidade IN (:cod_entidade)  AND ntpg.exercicio_liquidacao = :exercicio  AND ntpg.cod_nota = :cod_nota  AND ntpg.cod_ordem = :cod_ordem ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->bindValue('cod_ordem', $codOrdem);
        $query->bindValue('cod_nota', $codNota);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codbanco
     * @return array
     */
    public function findAllAgenciasPorBanco($codbanco)
    {
        return $this->getEntityManager()
            ->getRepository(Agencia::class)
            ->createQueryBuilder('a')
            ->select('a.codAgencia', 'a.numAgencia', 'a.nomAgencia')
            ->where('a.codBanco = :codBanco')
            ->setParameter('codBanco', $codbanco)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @return array
     */
    public function findAllOrdemPagamentoJaEfetuado($codEntidade, $exercicio)
    {
        return $this->getEntityManager()
            ->getRepository(TransacoesPagamento::class)
            ->createQueryBuilder('a')
            ->select('DISTINCT a.codOrdem')
            ->where('a.exercicio = :exercicio')
            ->andWhere('a.codEntidade = :codEntidade')
            ->setParameter('codEntidade', $codEntidade)
            ->setParameter('exercicio', $exercicio)
            ->getQuery()
            ->getResult();
    }
}
