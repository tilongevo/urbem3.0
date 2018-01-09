<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Patrimonio\Especie;

class EspecieModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\Especie");
    }

    /**
     * @param $codGrupo
     * @param $codNatureza
     * @return int
     * @throws ORM\NoResultException
     * @throws ORM\NonUniqueResultException
     */
    public function buildCodEspecie($codGrupo)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select(
                $queryBuilder->expr()->max("especie.codEspecie") . " AS codEspecie"
            )
            ->from(Especie::class, "especie")
            ->where('especie.codGrupo = :codGrupo')
            ->andWhere('especie.codNatureza = :codNatureza')
            ->setParameter('codGrupo', $codGrupo->getCodGrupo())
            ->setParameter('codNatureza', $codGrupo->getCodNatureza())
        ;

        $res = $queryBuilder->getQuery()->getSingleResult();

        $lastCodEspecie = $res['codEspecie'] + 1;
        return (int) $lastCodEspecie;
    }
}
