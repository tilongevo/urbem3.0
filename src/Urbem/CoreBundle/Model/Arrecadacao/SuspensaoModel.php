<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Entity\Arrecadacao\Suspensao;
use Urbem\CoreBundle\Repository\Arrecadacao\SuspensaoRepository;

class SuspensaoModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var SuspensaoRepository
     */
    protected $repository = null;

    /**
     * GrupoCreditoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Suspensao::class);
    }

    /**
     * @return mixed
     */
    public function getNextVal($lancamento)
    {
        return $this->repository->getNextVal($lancamento);
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function filterLancamento($filter)
    {
        $res = $this->entityManager->getRepository(Suspensao::class)
            ->filterLancamento($filter);

        return $res;
    }

    /**
     * @param $lancamento
     * @return mixed
     */
    public function getProprietario(Lancamento $lancamento)
    {
        $res = $this->entityManager->getRepository(Suspensao::class)
            ->getProprietario($lancamento);

        return $res;
    }

    /**
     * @param Lancamento $lancamento
     * @return mixed
     */
    public function getDadosLancamento(Lancamento $lancamento)
    {
        $res = $this->entityManager->getRepository(Suspensao::class)
            ->getDadosLancamento($lancamento);

        return $res;
    }
}
