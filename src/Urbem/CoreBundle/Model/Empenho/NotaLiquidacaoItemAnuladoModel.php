<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItemAnulado;
use Urbem\CoreBundle\Model;

class NotaLiquidacaoItemAnuladoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * NotaLiquidacaoItemAnuladoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(NotaLiquidacaoItemAnulado::class);
    }

    /**
     * @param $codPreEmpenho
     * @param $exercicio
     * @return mixed
     */
    public function getItensAnulados($codPreEmpenho, $exercicio)
    {
        $queryBuilder = $this->repository->getItensAnulados($codPreEmpenho, $exercicio);

        return $queryBuilder->getQuery()->getResult();
    }
}
