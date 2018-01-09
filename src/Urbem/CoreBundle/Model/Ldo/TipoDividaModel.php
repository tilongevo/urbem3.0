<?php

namespace Urbem\CoreBundle\Model\Ldo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Ldo\TipoIndicadores;

class TipoDividaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const PASSIVOS_RECONHECIDOS_TYPE = 'Passivos Reconhecidos';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TipoIndicadores::class);
    }
}
