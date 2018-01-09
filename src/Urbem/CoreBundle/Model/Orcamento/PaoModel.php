<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;

class PaoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var Repository\Orcamento\PaoRepository|null */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\Pao");
    }

    public function getListaOrcamentoPao($exercicio)
    {
        return $this->repository->getListaOrcamentoPao($exercicio);
    }

    /**
     * @param $stCondicao
     * @param $stGroupBy
     * @param $stOrdem
     *
     * @return mixed
     */
    public function recuperaPorNumPAODotacao($stCondicao, $stGroupBy, $stOrdem)
    {
        return $this->repository->recuperaPorNumPAODotacao($stCondicao, $stGroupBy, $stOrdem);
    }
}
