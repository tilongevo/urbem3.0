<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Tcemg\ExecucaoVariacao;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Tcemg\ExecucaoVariacaoRepository;

/**
 * Class ExecucaoVariacaoModel
 * @package Urbem\CoreBundle\Model\Tcemg
 */
class ExecucaoVariacaoModel extends AbstractModel
{
    const FIELD_COD_MES = 'codMes';

    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var ExecucaoVariacaoRepository $repository
     */
    protected $repository = null;

    /**
     * ExecucaoVariacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ExecucaoVariacao::class);
    }

    /**
     * @param $exercicio
     * @param $mes
     * @return ORM\QueryBuilder
     */
    public function findByExercicioAndMes($exercicio, $mes)
    {
        $filter[self::FIELD_EXERCICIO] = $exercicio;
        $filter[self::FIELD_COD_MES] = $mes;

        $qb = $this->repository->searchBy($filter);

        return $qb;
    }
}
