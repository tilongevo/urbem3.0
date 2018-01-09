<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao;

class CarneDevolucaoModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var \Doctrine\ORM\EntityRepository|null
     */
    protected $repository = null;

    /**
     * CarneDevolucaoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(CarneDevolucao::class);
    }

    /**
     * @param CarneDevolucao $carneDevolucao
     * @return mixed
     */
    public function getConvenio(CarneDevolucao $carneDevolucao)
    {

        $res = $this->entityManager->getRepository(CarneDevolucao::class)
            ->getConvenio($carneDevolucao);

        return $res;
    }
}
