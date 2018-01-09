<?php

namespace Urbem\CoreBundle\Model\Monetario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Monetario\Acrescimo;

class AcrescimoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const BIBLIOTECA_ORIGEM = 2;

    /**
     * AcrescimoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Acrescimo::class);
    }

    /**
     * @return mixed
     */
    public function getNextVal()
    {
        return $this->repository->getNextVal();
    }
}
