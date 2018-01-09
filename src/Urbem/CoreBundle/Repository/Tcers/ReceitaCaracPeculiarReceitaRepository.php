<?php

namespace Urbem\CoreBundle\Repository\Tcers;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ReceitaCaracPeculiarReceitaRepository
 * @package Urbem\CoreBundle\Repository\Tcers
 */
class ReceitaCaracPeculiarReceitaRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return array
     */
    public function findReceitaCaracPeculiarReceitaByExercicio($exercicio)
    {
        $sql = sprintf("select
                O.exercicio,
                 trim(CR.descricao) as descricao,                            
                 receita_carac_peculiar_receita.cod_receita,                                              
                 carac_peculiar_receita.cod_caracteristica,					
                 carac_peculiar_receita.descricao as caracteristica			
             FROM                                                            
                 orcamento.vw_classificacao_receita AS CR,                   
                 orcamento.recurso('%s') AS R,  
                 orcamento.receita        AS O                               
                 INNER JOIN tcers.receita_carac_peculiar_receita              
                 ON (receita_carac_peculiar_receita.exercicio = o.exercicio 
                    AND receita_carac_peculiar_receita.cod_receita = o.cod_receita ) 
                 INNER JOIN tcers.carac_peculiar_receita 						
                 ON (carac_peculiar_receita.cod_caracteristica = receita_carac_peculiar_receita.cod_caracteristica ) 
             WHERE                                                           
                     CR.exercicio IS NOT NULL                                
                 AND O.cod_conta   = CR.cod_conta                            
                 AND O.exercicio   = CR.exercicio                            
                 AND O.cod_recurso = R.cod_recurso                           
                 AND O.exercicio   = R.exercicio
             ORDER BY receita_carac_peculiar_receita.cod_receita", $exercicio);

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findExerciciosListQueryBuilder()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select('e.exercicio');
        $qb->groupBy('e.exercicio');
        $qb->orderBy('e.exercicio', 'DESC');

        return $qb;
    }

    /**
     * @return mixed
     */
    public function findExerciciosList()
    {
        $qb = $this->findExerciciosListQueryBuilder();
        return $qb->getQuery()->execute();
    }
}
