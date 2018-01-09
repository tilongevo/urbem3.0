<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Tcemg\OperacaoCreditoAro;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Tcemg\OperacaoCreditoAroRepository;

/**
 * Class OperacaoCreditoAroModel
 * @package Urbem\CoreBundle\Model\Tcemg
 */
class OperacaoCreditoAroModel extends AbstractModel
{
    const FIELD_ENTIDADE = 'codEntidade';

    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var OperacaoCreditoAroRepository $repository
     */
    protected $repository = null;

    /**
     * OperacaoCreditoAroModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(OperacaoCreditoAro::class);
    }

    /**
     * @param string $exercicio
     * @param string $entidade
     * @return array
     */
    public function findByExercicioEntidade($exercicio, $entidade)
    {
        $filter[self::FIELD_EXERCICIO] = $exercicio;
        $filter[self::FIELD_ENTIDADE] = $entidade;

        $qb = $this->repository->searchBy($filter);
        $result = $qb->getQuery()->getArrayResult();
        if (count($result)) {

            return array_shift($result);
        }

        return [];
    }
}
