<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class TipoAutenticacaoModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class TipoAutenticacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const TRANSFERENCIA = 'T';
    const ESTORNO_TRANSFERENCIA = 'E';

    /**
     * TipoAutenticacaoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Tesouraria\\TipoAutenticacao");
    }
}
