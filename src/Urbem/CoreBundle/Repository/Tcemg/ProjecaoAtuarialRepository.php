<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ProjecaoAtuarialRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class ProjecaoAtuarialRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function findToArray($exercicio, $codEntidade)
    {
        $data = $this->createQueryBuilder('p')
            ->where('p.exercicioEntidade = :exercicio')
            ->andWhere('p.codEntidade = :codEntidade')
            ->setParameters([
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
            ])
            ->getQuery()
            ->getArrayResult();

        return $data;
    }
}