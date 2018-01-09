<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Doctrine\ORM;

/**
 * Class CnaeFiscalRepository
 * @package Urbem\CoreBundle\Repository\Economico
 */
class CnaeFiscalRepository extends ORM\EntityRepository
{
    /**
     * @return array
     */
    public function findCnaeFiscal($codCnae = false)
    {
        $sql = <<<SQL
SELECT * FROM                                             
	                 (                                                         
	                 SELECT                                                    
	                     LN.*,                                                 
	                     LO.nom_atividade,                                     
	                     LO.cod_estrutural as valor_composto,                  
	                     publico.fn_mascarareduzida(LO.cod_estrutural) as valor_reduzido, 
	                     NI.mascara,                                           
	                     NI.nom_nivel                                          
	                 FROM                                                      
	                     (                                                     
	                      SELECT                                               
	                          LN.*,                                            
	                          LN2.valor                                        
	                      FROM (                                               
	                            SELECT                                         
	                                MAX(LN.cod_nivel) AS cod_nivel,            
	                                LN.cod_vigencia ,LN.cod_cnae               
	                            FROM                                           
	                                economico.nivel_cnae_valor AS LN             
	                            WHERE                                          
	                                LN.valor <> ''                             
	                            GROUP BY                                       
	                                LN.cod_vigencia,                           
	                                LN.cod_cnae) AS LN,                        
	                      economico.nivel_cnae_valor AS LN2                      
	                      WHERE                                                
	                          LN.cod_nivel       = LN2.cod_nivel AND           
	                          LN.cod_cnae        = LN2.cod_cnae  AND           
	                          LN.cod_vigencia    = LN2.cod_vigencia            
	                     ) AS LN,                                              
	                     economico.nivel_cnae AS NI,                             
	                     (                                                     
	                      SELECT                                               
	                          LOC.*                                            
	                      FROM                                                 
	                          economico.cnae_fiscal AS LOC                       
	                     ) AS LO                                               
	                 WHERE                                                     
	                     LN.cod_nivel       = NI.cod_nivel       AND           
	                     LN.cod_vigencia    = NI.cod_vigencia    AND           
	                     LN.cod_cnae        = LO.cod_cnae                      
	                 ) as tbl                       
SQL;

        if($codCnae) {
            $sql .= " WHERE cod_cnae = ".$codCnae;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
