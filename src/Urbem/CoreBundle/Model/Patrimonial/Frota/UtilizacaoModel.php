<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Frota;

/**
 * Class UtilizacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class UtilizacaoModel extends AbstractModel
{

    protected $entityManager = null;
    protected $repository = null;

    /**
     * UtilizacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Frota\Utilizacao::class);
    }

    /**
     * @param array $params['codVeiculo', 'dtSaida', 'hrSaida']
     * @return Frota\Utilizacao
     */
    public function getUtilizacao($params)
    {
        return $this->repository->findOneBy(
            $params
        );
    }
}
