<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;

/**
 * Class CargoPadraoRepository
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class CargoPadraoRepository extends ORM\EntityRepository
{
    /**
     * Retorna os últimos padroes cadastrados de acordo com o timestamp
     * @return array
     */
    public function getPadraoByTimestamp()
    {
        $sql = "
        SELECT                                                   
	    FP.cod_padrao,                                        
	    FP.descricao,                                         
	    to_char(FPP.vigencia,'dd/mm/yyyy') as vigencia,       
	    FPP.cod_norma,                                        
	    FP.horas_mensais,                                     
	    FP.horas_semanais,                                    
	    FPP.valor,                                            
	    MAXTFPP.timestamp                                     
	 FROM                                                     
	    folhapagamento.padrao FP,                             
	    folhapagamento.padrao_padrao FPP,                     
	    (SELECT                                               
	        MAXFPP.cod_padrao,                                
	        MAX(timestamp) as timestamp                       
	        FROM folhapagamento.padrao_padrao MAXFPP          
	                   GROUP BY MAXFPP.cod_padrao) as MAXTFPP 
	 WHERE FP.cod_padrao = MAXTFPP.cod_padrao                 
	       AND FPP.cod_padrao = MAXTFPP.cod_padrao            
	       AND FPP.timestamp  = MAXTFPP.timestamp             
	ORDER BY descricao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
