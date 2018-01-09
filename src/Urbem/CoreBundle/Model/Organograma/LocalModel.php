<?php

namespace Urbem\CoreBundle\Model\Organograma;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Repository\Organograma\LocalRepository;

/**
 * Class LocalModel
 * @package Urbem\CoreBundle\Model\Organograma
 */
class LocalModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var LocalRepository  */
    protected $repository = null;

    /**
     * LocalModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Local::class);
    }

    /**
     * @param Orgao $orgao
     * @param $exercicio
     * @param $idInventario
     * @return array
     */
    public function getLocalInHistoricoBem(Orgao $orgao, $exercicio, $idInventario)
    {
        return $this->repository->getLocalInHistoricoBem($orgao->getCodOrgao(), $exercicio, $idInventario);
    }
}
