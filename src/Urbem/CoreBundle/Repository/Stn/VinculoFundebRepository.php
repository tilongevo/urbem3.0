<?php

namespace Urbem\CoreBundle\Repository\Stn;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class VinculoFundebRepository
 * @package Urbem\CoreBundle\Repository\Stn
 */
class VinculoFundebRepository extends AbstractRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByExercicio($exercicio)
    {
        $qb = $this->createQueryBuilder('VinculoFundeb');
        $qb->innerJoin('\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica', 'PlanoAnalitica', 'WITH', 'VinculoFundeb.codPlano = PlanoAnalitica.codPlano AND VinculoFundeb.exercicio = PlanoAnalitica.exercicio');
        $qb->innerJoin('Urbem\CoreBundle\Entity\Contabilidade\PlanoConta', 'PlanoConta', 'WITH','PlanoAnalitica.codConta = PlanoConta.codConta AND PlanoAnalitica.exercicio = PlanoConta.exercicio');
        $qb->where('VinculoFundeb.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);
        $qb->addOrderBy('VinculoFundeb.codPlano', 'ASC');

        return $qb;
    }
}
