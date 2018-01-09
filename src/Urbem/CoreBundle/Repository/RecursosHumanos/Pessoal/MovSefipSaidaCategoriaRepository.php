<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class MovSefipSaidaCategoriaRepository extends ORM\EntityRepository
{
    public function consulta($codigo, $delete = false)
    {
        $sql = sprintf("select * from pessoal.mov_sefip_saida_categoria where cod_sefip_saida= %d", $codigo);
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($result > 0 && $delete){
            $this->deleteMovSefipRetorno($codigo);
        }

        return $result;
    }

    public function deleteMovSefipRetorno($codigo)
    {
        $sql = sprintf("DELETE FROM pessoal.mov_sefip_saida_categoria WHERE cod_sefip_saida = %d", $codigo);

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function buscarComCategorias($codigo)
    {
        $qb = $this->createQueryBuilder("c")
            ->where('c.codSefipSaida = :cod')
            ->setParameter('cod', $codigo)
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }
}
