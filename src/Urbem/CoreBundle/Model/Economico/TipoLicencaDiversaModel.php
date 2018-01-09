<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\TipoLicencaDiversa;

/**
 * Class TipoLicencaDiversasModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class TipoLicencaDiversasModel extends AbstractModel
{

    protected $entityManager;
    protected $repository;

    /**
     * TipoLicencaDiversasModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TipoLicencaDiversa::class);
    }
}
