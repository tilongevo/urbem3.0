<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM\EntityManager;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Auditoria;

/**
 * Class AuditoriaModel
 *
 * @package Urbem\CoreBundle\Model\Administracao
 */
class AuditoriaModel extends AbstractModel
{
    /** @var \Doctrine\ORM\EntityRepository  */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Auditoria::class);
    }

    /**
     * @param string $columnName
     *
     * @return array
     */
    public function getValuesGroupedBy($columnName)
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('a')
            ->select("a.{$columnName}")
            ->groupBy("a.{$columnName}");

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
