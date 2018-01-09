<?php

namespace Urbem\CoreBundle\Model\Monetario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Repository\Monetario\CreditoRepository;

class CreditoModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var CreditoRepository $repository
     */
    protected $repository = null;

    /**
     * CreditoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Credito::class);
    }

    /**
     * @param $paramsWhere
     * @return mixed
     */
    public function getCreditosJson($paramsWhere)
    {
        return $this->repository->getCreditosJson($paramsWhere);
    }
}
