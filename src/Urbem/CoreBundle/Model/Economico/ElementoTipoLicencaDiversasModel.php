<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa;

/**
 * Class ElementoTipoLicencaDiversasModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class ElementoTipoLicencaDiversasModel extends AbstractModel
{

    protected $entityManager;
    protected $repository;

    /**
     * ElementoTipoLicencaDiversasModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ElementoTipoLicencaDiversa::class);
    }

    /**
     * @param $codElemento
     * @return mixed
     */
    public function getElementoTipoLicencaDiversas($codElemento)
    {
        return $this->repository->findOneByCodElemento($codElemento);
    }

    /**
     * @param $codTipo
     * @return mixed
     */
    public function getElementoTipoLicencaDiversasByTipo($codTipo)
    {
        return $this->repository->findByCodTipo($codTipo);
    }
}
