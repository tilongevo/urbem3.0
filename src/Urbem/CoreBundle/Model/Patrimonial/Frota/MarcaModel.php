<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Frota\Marca;
use Urbem\CoreBundle\Model;

/**
 * Class MarcaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class MarcaModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    /**
     * MarcaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\Marca");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        $modeloRepository = $this->entityManager->getRepository("CoreBundle:Frota\Modelo");
        $res = $modeloRepository->findOneByCodMarca($object->getCodMarca());

        return is_null($res);
    }

    /**
     * @param $id
     * @return ORM\QueryBuilder
     */
    public function getMarcasDisponiveis($id)
    {
        return $this->repository->getMarcasDisponiveis($id);
    }
}
