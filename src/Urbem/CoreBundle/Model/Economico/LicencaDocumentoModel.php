<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\LicencaDocumento;

/**
 * Class LicencaDocumentoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class LicencaDocumentoModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * LicencaDocumentoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LicencaDocumento::class);
    }
}
