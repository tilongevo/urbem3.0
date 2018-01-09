<?php

namespace Urbem\CoreBundle\Model\Monetario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Monetario\EspecieCredito;

class EspecieCreditoModel extends AbstractModel
{
    /**
     * EspecieModel constructor.
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(EspecieCredito::class);
    }

    /**
     * @param EspecieCredito $especieCredito
     *
     * @return boolean
     */
    public function canRemove($especieCredito)
    {
        return $this->canRemoveWithAssociation($especieCredito);
    }
}
