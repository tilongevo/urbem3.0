<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class MovSefipSaidaMovSefipRetornoRepository extends ORM\EntityRepository
{
    /**
     * @param $codSefipSaida
     * @return array
     */
    public function buscarPorCodSefipRetorno($codSefipSaida)
    {
        $qb = $this->createQueryBuilder("m")
            ->where('m.codSefipSaida = :cod')
            ->setParameter('cod', $codSefipSaida)
            ->orderBy('m.codSefipSaida', 'DESC')
            ->setMaxResults(1);
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param $filtro
     *
     * @return array
     */
    public function recuperaMovSefipRetorno($filtro)
    {
        $sql = <<<SQL
SELECT sefip.*                                                                              
         , cod_sefip_retorno                                                                    
      FROM pessoal.mov_sefip_saida_mov_sefip_retorno                                            
         , pessoal.sefip                                                                        
     WHERE mov_sefip_saida_mov_sefip_retorno.cod_sefip_retorno = sefip.cod_sefip 
SQL;

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
