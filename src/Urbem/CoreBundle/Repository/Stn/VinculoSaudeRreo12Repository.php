<?php

namespace Urbem\CoreBundle\Repository\Stn;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class VinculoSaudeRreo12Repository
 * @package Urbem\CoreBundle\Repository\Stn
 */
class VinculoSaudeRreo12Repository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByExercicio($exercicio)
    {
        $qb = $this->createQueryBuilder('VinculoSaudeRreo12');
        $qb->innerJoin('\Urbem\CoreBundle\Entity\Orcamento\Receita', 'Receita', 'WITH', 'VinculoSaudeRreo12.codReceita = Receita.codReceita AND VinculoSaudeRreo12.exercicio = Receita.exercicio');
        $qb->innerJoin('Urbem\CoreBundle\Entity\Orcamento\ContaReceita', 'ContaReceita', 'WITH','Receita.codConta = ContaReceita.codConta AND ContaReceita.exercicio = Receita.exercicio');
        $qb->where('VinculoSaudeRreo12.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        return $qb;
    }
}