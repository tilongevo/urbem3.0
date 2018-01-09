<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class ChequeEmissaoRepository extends ORM\EntityRepository
{

    /**
     * @return array
     */
    public function findAllEntidadesPorExercicioUsuario($exercicio, $codUsuario)
    {
        $sql = "SELECT                                   
                     E.cod_entidade,                      
                     C.nom_cgm                            
                FROM                                     
                     orcamento.entidade      as   E,      
                     sw_cgm                  as   C       
                WHERE                                    
                     E.numcgm = C.numcgm AND              
                 ( E.cod_entidade || '-' || exercicio in (
                     SELECT cod_entidade || '-' || exercicio  
                     FROM orcamento.usuario_entidade 
                     WHERE numcgm = :codUsuario 
                     AND exercicio = :exercicio)  
                     OR E.exercicio < (
                        SELECT substring(valor,7,4) 
                        from administracao.configuracao 
                        where parametro ='data_implantacao' 
                        and exercicio=:exercicio
                        and cod_modulo=9))  
                  AND E.exercicio = :exercicio  
                  ORDER BY cod_entidade";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codUsuario', $codUsuario);
        $query->execute();
        return $query->fetchAll();
    }
}
