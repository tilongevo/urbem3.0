<?php

namespace Urbem\CoreBundle\Model\Tcemg;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Acao;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Tcemg\ConfigurarIdeRepository;
use Urbem\CoreBundle\Entity\Tcemg\ConfigurarIde;
use Urbem\CoreBundle\Exception\Error;

/**
 * Class ConfigurarIdeModel
 * @package Urbem\CoreBundle\Model\Tcemg
 */
class ConfigurarIdeModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var ConfigurarIdeRepository $repository
     */
    protected $repository = null;

    /**
     * AcaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ConfigurarIde::class);
    }

    /**
     * @param $exercicio
     * @return array|Acao
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
