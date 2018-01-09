<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\Atividade;

/**
 * Class AtividadeModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class AtividadeModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * AtividadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Atividade::class);
    }

    /**
     * @param $codAtividade
     * @return mixed
     */
    public function getAtividade($codAtividade)
    {
        return $this->repository->findByCodAtividade($codAtividade);
    }

    /**
     * @param $codAtividade
     * @return mixed
     */
    public function getOneAtividade($codAtividade)
    {
        return $this->repository->findOneByCodAtividade($codAtividade);
    }
}
