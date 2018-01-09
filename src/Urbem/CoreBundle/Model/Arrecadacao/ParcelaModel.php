<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\Parcela;
use Urbem\CoreBundle\Repository\Arrecadacao\ParcelaRepository;

/**
 * Class ParcelaModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class ParcelaModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var ParcelaRepository
     */
    protected $repository = null;

    /**
     * ParcelaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Parcela::class);
    }

    /**
     * @return int
     */
    public function getCodParcela()
    {
        return $this->repository->getCodParcela();
    }

    /**
     * @param $params
     * @return array
     */
    public function getFnPeriodicoArrecadacaoSintetico($params)
    {
        return $this->repository->getFnPeriodicoArrecadacaoSintetico($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getFnPeriodicoArrecadacaoAnalitico($params)
    {
        return $this->repository->getFnPeriodicoArrecadacaoAnalitico($params);
    }
}
