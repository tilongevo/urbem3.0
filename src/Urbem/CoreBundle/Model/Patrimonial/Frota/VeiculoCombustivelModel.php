<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model;

/**
 * Class VeiculoCombustivelModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class VeiculoCombustivelModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    /**
     * MarcaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {

        /** @var ORM\EntityManager entityManager */
        $this->entityManager = $entityManager;
        /** @var ORM\EntityRepository repository */
        $this->repository = $this->entityManager->getRepository(Entity\Frota\VeiculoCombustivel::class);
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
     * Retorna um único registro de acordo com os dados informados
     *
     * @param array $params['codVeiculo'(, 'codCombustivel')]
     * @return Entity\Frota\VeiculoCombustivel
     */
    public function findOneBy($params)
    {
        return $this->repository
            ->findOneBy($params);
    }

    /**
     * Retorna todos os registros de acordo com os dados informados
     *
     * @param array $params['codVeiculo'(, 'codCombustivel')]
     * @return Entity\Frota\VeiculoCombustivel
     */
    public function findBy($params)
    {
        return $this->repository
            ->findBy($params);
    }
}
