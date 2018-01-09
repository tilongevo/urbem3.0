<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Patrimonio;
use Urbem\CoreBundle\Repository;

/**
 * Class ManutencaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Patrimonio
 */
class ManutencaoModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null  */
    protected $repository = null;

    /**
     * ManutencaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Patrimonio\Manutencao::class);
    }
}
