<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Repository\Economico\AtividadeCadastroEconomicoRepository;

/**
 * Class AtividadeCadastroEconomicoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class AtividadeCadastroEconomicoModel extends AbstractModel
{
    protected $entityManager;

    /** @var AtividadeCadastroEconomicoRepository */
    protected $repository;

    /**
     * AtividadeCadastroEconomicoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(AtividadeCadastroEconomico::class);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getAtividadeCadastroEconomicoReport($params)
    {
        return $this->repository->getAtividadeCadastroEconomicoReport($params);
    }

    /**
     * @param $params
     * @return array
     */
    public function getAtividadeBySwcgmAction($params)
    {
        return $this->repository->getAtividadeBySwcgmAction($params);
    }
}
