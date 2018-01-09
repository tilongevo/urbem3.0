<?php

namespace Urbem\CoreBundle\Repository\Stn;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class RiscosFiscaisRepository
 * @package Urbem\CoreBundle\Repository\Stn
 */
class RiscosFiscaisRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAll($exercicio)
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.exercicio = :exercicio')
            ->setParameter('exercicio', $exercicio)
            ->orderBy('r.codRisco');

        return $qb;
    }

    /**
     * @return mixed
     */
    public function getLastCodRisco()
    {
        $sql = "SELECT COALESCE(MAX(cod_risco), 0) AS cod_risco FROM stn.riscos_fiscais";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetch();
    }
}
