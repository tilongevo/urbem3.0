<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Patrimonio\Natureza;
use Urbem\CoreBundle\Model;

class NaturezaModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\Natureza");
    }

    public function canRemove($object)
    {
        $grupoRepository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\Grupo");
        $res = $grupoRepository->findOneByCodNatureza($object->getCodNatureza());

        return is_null($res);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @return int
     * @throws ORM\NoResultException
     * @throws ORM\NonUniqueResultException
     */
    public function buildCodNatureza()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select(
                $queryBuilder->expr()->max("natureza.codNatureza") . " AS codNatureza"
            )
            ->from(Natureza::class, "natureza")
        ;

        $res = $queryBuilder->getQuery()->getSingleResult();

        $lastCodNatureza = $res['codNatureza'] + 1;

        return (int) $lastCodNatureza;
    }
}
