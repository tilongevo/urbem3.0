<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Ima;

use Doctrine\ORM;

class PrevidenciaRegimeRatRepository extends ORM\EntityRepository
{

    /**
     * @return array
     */
    public function recuperaAliquotaSefip()
    {
        $sql = <<<SQL
SELECT previdencia_regime_rat.*                                                                 
    FROM folhapagamento.previdencia_regime_rat                                                    
       , (SELECT cod_previdencia                                                                  
               , max(previdencia_regime_rat.timestamp) as timestamp                               
            FROM folhapagamento.previdencia_regime_rat                                            
          GROUP BY cod_previdencia) as max_previdencia_regime_rat                                 
       , folhapagamento.previdencia                                                               
       , folhapagamento.previdencia_previdencia                                                   
       , (SELECT cod_previdencia                                                                  
               , max(previdencia_previdencia.timestamp) as timestamp                              
            FROM folhapagamento.previdencia_previdencia                                           
          GROUP BY cod_previdencia) as max_previdencia_previdencia                                
   WHERE previdencia_regime_rat.cod_previdencia = max_previdencia_regime_rat.cod_previdencia      
     AND previdencia_regime_rat.timestamp = max_previdencia_regime_rat.timestamp                  
     AND previdencia_regime_rat.cod_previdencia = previdencia.cod_previdencia                     
     AND previdencia.cod_previdencia = previdencia_previdencia.cod_previdencia                    
     AND previdencia_previdencia.cod_previdencia = max_previdencia_previdencia.cod_previdencia    
     AND previdencia_previdencia.timestamp = max_previdencia_previdencia.timestamp                
     AND previdencia.cod_regime_previdencia = 1                                                   
    ORDER BY vigencia desc limit 1 
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return array_shift($result);
    }
}
