<?php
namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ObjetoRepository extends AbstractRepository
{
    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('Objeto');

        $orx = $qb->expr()->orX();

        $like = $qb->expr()->like('string(Objeto.codObjeto)', ':term');
        $orx->add($like);

        $like = $qb->expr()->like('Objeto.descricao', ':term');
        $orx->add($like);

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', $term));

        $qb->orderBy('Objeto.codObjeto');
        $qb->setMaxResults(10);

        return $qb;
    }
}
