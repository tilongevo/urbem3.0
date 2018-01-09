<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoPerc;

/**
 * Class ConfiguracaoPercModel
 * @package Urbem\CoreBundle\Model\Tcemg
 */
class ConfiguracaoPercModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var ConfiguracaoPerc $repository
     */
    protected $repository = null;

    /**
     * AcaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConfiguracaoPerc::class);
    }

    /**
     * @param $exercicio
     * @return array|ConfiguracaoPerc
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
