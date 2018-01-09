<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Repository\Economico\CadastroEconomicoRepository;

/**
 * Class CadastroEconomicoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class CadastroEconomicoModel extends AbstractModel
{
    protected $entityManager;

    /** @var CadastroEconomicoRepository */
    protected $repository;

    const INSCRICAO_FATO_TYPE = 'fato';
    const INSCRICAO_DIREITO_TYPE = 'direito';
    const INSCRICAO_AUTONOMO_TYPE = 'autonomo';

    /**
     * CadastroEconomicoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(CadastroEconomico::class);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function findCadastrosEconomico($params)
    {
        return $this->repository->findCadastrosEconomico($params);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getCadastroEconomicoReport($params)
    {
        return $this->repository->getCadastroEconomicoReport($params);
    }
}
