<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\TipoLicencaModeloDocumento;

/**
 * Class TipoLicencaModeloDocumentosModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class TipoLicencaModeloDocumentosModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * TipoLicencaModeloDocumentosModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TipoLicencaModeloDocumento::class);
    }

    /**
     * @param $codTipoDocumento
     * @return mixed
     */
    public function getTipoLicencaModeloDocumento($codTipoDocumento)
    {
        return $this->repository->findOneByCodTipoDocumento($codTipoDocumento);
    }

    /**
     * @param $codTipo
     * @return mixed
     */
    public function getTipoLicencaModeloDocumentoByCodTipo($codTipo)
    {
        return $this->repository->findOneByCodTipo($codTipo);
    }
}
