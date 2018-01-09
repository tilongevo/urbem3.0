<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Economico\Utilizacao;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class UtilizacaoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class UtilizacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * UtilizacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Utilizacao::class);
    }

    /**
     * @param $codUtilizacao
     * @return mixed
     */
    public function getUtilizacao($codUtilizacao)
    {
        return $this->repository->findOneByCodUtilizacao($codUtilizacao);
    }
}
