<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

/**
 * Class TipoTransferenciaModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class TipoTransferenciaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const TYPE_REABRIR_CREDITO_EXTRAORDINARIO = 'Reabrir Crédito Extraordinário';
    const TYPE_REABRIR_CREDITO_ESPECIAL = 'Reabrir Crédito Especial';

    /**
     * TipoTransferenciaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\\TipoTransferencia');
    }

    /**
     * @param array $params['codTipo']
     * @return Entity\Tesouraria\TipoTransferencia
     */
    public function findOneBy($params)
    {
        return $this->repository->findOneBy($params);
    }
}
