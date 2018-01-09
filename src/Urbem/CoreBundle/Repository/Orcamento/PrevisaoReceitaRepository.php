<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;

class PrevisaoReceitaRepository extends ORM\EntityRepository
{
    public function findPrevisaoReceita(array $codReceitas, $exercicio)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->where(sprintf("p.exercicio = '%s' and p.codReceita IN (%s)", $exercicio, implode(",", $codReceitas)));
        $qb->addOrderBy('p.codReceita', 'ASC');
        $qb->addOrderBy('p.periodo', 'ASC');
        return $qb->getQuery()->execute();
    }
}
