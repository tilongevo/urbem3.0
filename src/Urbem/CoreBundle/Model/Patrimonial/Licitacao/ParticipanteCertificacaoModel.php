<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class ParticipanteCertificacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class ParticipanteCertificacaoModel extends AbstractModel
{
    /** @var ORM\EntityManager entityManager */
    protected $entityManager = null;
    /** @var ORM\EntityRepository repository */
    protected $repository = null;

    /**
     * MarcaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Entity\Licitacao\ParticipanteCertificacao::class);
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        // Implements canRemove
    }

    /**
     * Pega o próximo identificador disponível
     *
     * @param string $exercicio
     * @param int $cgmFornecedor
     * @return int identifier
     */
    public function getAvailableIdentifier($exercicio, $cgmFornecedor)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select(
                $queryBuilder->expr()->max("o.numCertificacao") . " AS identifier"
            )
            ->from(Entity\Licitacao\ParticipanteCertificacao::class, 'o')
            ->where("o.exercicio = '{$exercicio}'")
            ->andWhere("o.cgmFornecedor  = {$cgmFornecedor}");
        $result = $queryBuilder->getQuery()->getSingleScalarResult();
        return $result + 1;
    }
}
