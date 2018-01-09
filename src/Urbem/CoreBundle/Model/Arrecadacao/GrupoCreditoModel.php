<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;

class GrupoCreditoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * GrupoCreditoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(GrupoCredito::class);
    }

    /**
     * @return mixed
     */
    public function getNextVal($exercicio)
    {
        return $this->repository->getNextVal($exercicio);
    }

    /**
     * @return mixed
     */
    public function getGrupoCredito()
    {
        return $this->repository->getGrupoCredito();
    }
}
