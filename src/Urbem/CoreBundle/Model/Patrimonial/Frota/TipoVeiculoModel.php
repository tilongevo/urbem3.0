<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

/**
 * Class TipoVeiculoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class TipoVeiculoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * TipoVeiculoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        /** @var ORM\EntityManager entityManager */
        $this->entityManager = $entityManager;
        /** @var ORM\EntityRepository repository */
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\TipoVeiculo");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        # Implements canRemove
    }

    /**
     * @param $codTipoVeiculo
     * @return mixed
     */
    public function getTipoVeiculoInfo($codTipoVeiculo)
    {
        $tipoVeiculo = $this->repository
            ->findOneByCodTipo($codTipoVeiculo);

        return $tipoVeiculo;
    }
}
