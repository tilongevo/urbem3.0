<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\Calculo;

/**
 * Class CalculoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class CalculoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * CalculoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Calculo::class);
    }

    /**
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->repository->getCodCalculo();
    }

    /**
     * @param $inscricaoEconomica
     * @return bool|string
     */
    public function getNumCgmByInscricaoEconomica($inscricaoEconomica)
    {
        return $this->repository->getNumCgmByInscricaoEconomica($inscricaoEconomica);
    }
}
