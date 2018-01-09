<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

/**
 * Class CidModel
 * @package Urbem\CoreBundle\Model\Pessoal
 */
class CidModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var ORM\EntityRepository|null
     */
    protected $repository = null;

    /**
     * CidModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Entity\Pessoal\Cid::class);
    }

    /**
     * @param $string
     * @return array
     */
    public function getCidByNameOrDescricao($string)
    {
        $queryBuilder = $this->repository->createQueryBuilder('c');
        $queryBuilder
            ->where(
            $queryBuilder->expr()->like('LOWER(c.sigla)', ':sigla')
        )
            ->andWhere(
                $queryBuilder->expr()->like('LOWER(c.descricao)', ':descricao')
            )
            ->setParameter('csigla', sprintf('%%%s%%', strtolower($string)))
            ->setParameter('cdescricao', sprintf('%%%s%%', strtolower($string)))
        ;
        $queryBuilder->orderBy('c.sigla', 'ASC');
        return $queryBuilder->getQuery()->getResult();
    }
}
