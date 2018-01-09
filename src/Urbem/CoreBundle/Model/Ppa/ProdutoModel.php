<?php

namespace Urbem\CoreBundle\Model\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Ppa\AcaoDados;
use Urbem\CoreBundle\Entity\Ppa\Produto;
use Urbem\CoreBundle\Model\InterfaceModel;

class ProdutoModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * ProdutoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Produto::class);
    }

    /**
     * @param $entity
     */
    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        $result = $this->entityManager->getRepository(AcaoDados::class)
            ->findByCodProduto($object->getCodProduto());

        if (count($result)) {
            return false;
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getProximoCodProduto()
    {
        return $this->repository->getProximoCodProduto();
    }
}
