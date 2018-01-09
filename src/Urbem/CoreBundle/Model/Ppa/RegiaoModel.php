<?php

namespace Urbem\CoreBundle\Model\Ppa;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class RegiaoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * AcaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Ppa\\Regiao");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        return ($object->getFkPpaAcaoDados()->count()) ? false : true;
    }
}
