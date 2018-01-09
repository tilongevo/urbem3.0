<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras;

class CotacaoAnuladaModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var Repository\Patrimonio\Compras\CotacaoAnulada $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\CotacaoAnulada::class);
    }
}
