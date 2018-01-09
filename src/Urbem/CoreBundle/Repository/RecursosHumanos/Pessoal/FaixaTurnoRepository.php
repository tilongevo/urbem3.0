<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

class FaixaTurnoRepository extends AbstractRepository
{
    public function getNextCodTurno()
    {
        return $this->nextVal('cod_turno');
    }

    public function getFaixaTurno($codGrade)
    {
        $sql = '
                SELECT pt.cod_turno                                          
                     , pt.cod_grade                                          
                     , to_char(pt.hora_entrada,\'hh24:mi\') as hora_entrada    
                     , to_char(pt.hora_saida,\'hh24:mi\') as hora_saida        
                     , (CASE WHEN pt.hora_entrada_2 is null                  
                               THEN \'\'                                       
                               ELSE to_char(pt.hora_entrada_2,\'hh24:mi\')     
                         end) as hora_entrada_2                              
                     , (CASE WHEN pt.hora_saida_2 is null                    
                               THEN \'\'                                       
                               ELSE to_char(pt.hora_saida_2,\'hh24:mi\')       
                         end) as hora_saida_2                                
                     , pt.cod_dia                                            
                     , dt.nom_dia                                            
                FROM                                                         
                  pessoal.faixa_turno as pt,        
                  (SELECT cod_grade                                          
                        , MAX(timestamp) as timestamp                        
                    FROM pessoal.faixa_turno        
                GROUP BY cod_grade) as pt_ult,                               
                  pessoal.dias_turno as dt          
                WHERE pt.cod_grade = pt_ult.cod_grade                        
                  AND pt.timestamp = pt_ult.timestamp                        
                  AND pt.cod_dia = dt.cod_dia                                
                 AND pt.cod_grade = '.$codGrade.' ORDER BY dt.cod_dia;    
                    ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
