<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\AtributoTipoLicencaDiversa;

/**
 * Class AtributoTipoLicencaDiversaModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class AtributoTipoLicencaDiversaModel extends AbstractModel
{

    protected $entityManager;
    protected $repository;

    /**
     * AtributoTipoLicencaDiversaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(AtributoTipoLicencaDiversa::class);
    }

    /**
     * @return array
     */
    public function getAtributoTipoLicencaDiversaAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $codAtributo
     * @return null|object
     */
    public function getAtributoTipoLicencaDiversa($codAtributo)
    {
        return $this->repository->findOneByCodAtributo($codAtributo);
    }

    /**
     * @param $codTipo
     * @return mixed
     */
    public function getAtributoTipoLicencaDiversaByTipo($codTipo)
    {
        return $this->repository->findByCodTipo($codTipo);
    }
}
