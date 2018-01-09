<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento;

/**
 * Class GrupoVencimentoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class GrupoVencimentoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * GrupoVencimentoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(GrupoVencimento::class);
    }

    /**
     * @param $exercicio
     * @param $codGrupo
     * @return mixed
     */
    public function getNextVal($exercicio, $codGrupo)
    {
        return $this->repository->getNextVal($exercicio, $codGrupo);
    }
}
