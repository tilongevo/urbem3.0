<?php

namespace Urbem\CoreBundle\Repository\Almoxarifado;

use Doctrine\ORM;

class CatalogoItemRepository extends ORM\EntityRepository
{
    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('CatalogoItem');

        $orx = $qb->expr()->orX();
        $orx->add($qb->expr()->like('string(CatalogoItem.descricaoResumida)', ':term'));
        $orx->add($qb->expr()->like('string(CatalogoItem.descricao)', ':term'));

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', $term));

        $qb->orderBy('CatalogoItem.codItem');
        $qb->setMaxResults(10);

        return $qb;
    }
}
