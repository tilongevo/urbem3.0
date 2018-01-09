<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity\Tcemg\MetasFiscais;
use Urbem\CoreBundle\Repository\Tcemg\MetasFiscaisRepository;

/**
 * Class MetasFiscaisModel
 * @package Urbem\CoreBundle\Model\Tcemg
 */
class MetasFiscaisModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var MetasFiscaisRepository $repository
     */
    protected $repository = null;

    /**
     * MetasFiscaisModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(MetasFiscais::class);
    }

    /**
     * @param $exercicio
     * @return array|MetasFiscais
     */
    public function findByExercicio($exercicio)
    {
        $result = $this->repository->findByExercicio($exercicio);
        if (!empty($result)) {

            return array_shift($result);
        }

        return $result;
    }
}
