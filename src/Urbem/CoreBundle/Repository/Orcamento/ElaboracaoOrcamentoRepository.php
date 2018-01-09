<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Helper\ArrayHelper;

class ElaboracaoOrcamentoRepository extends ORM\EntityRepository
{
    public function findListaMetasArrecadacaoReceita($exercicio, $codEntidade)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.exercicio = :exercicio AND p.codEntidade = :codEntidade');
        $qb->setParameter('exercicio', $exercicio);
        $qb->setParameter('codEntidade', $codEntidade);

        return $qb->getQuery()->execute();
    }
}
