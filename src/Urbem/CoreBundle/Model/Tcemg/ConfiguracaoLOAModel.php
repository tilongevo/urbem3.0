<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoLoa;

class ConfiguracaoLOAModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager = null;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConfiguracaoLoa::class);
    }

    /**
     * @param $exercicio
     * @return null|object|ConfiguracaoLoa
     */
    public function getCurrentConfig($exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
        ]);
    }
}
