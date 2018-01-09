<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\EmissaoDocumento;

/**
 * Class EmissaoDocumentoModel
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class EmissaoDocumentoModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * EmissaoDocumentoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(EmissaoDocumento::class);
    }

    /**
     * @param $codLicenca
     * @return mixed
     */
    public function getNumEmissao($codLicenca)
    {
        $result = $this->repository->getNumEmissao($codLicenca);
        if ($result) {
            $val = $result['valor'];
            $valor = ++$val;
        }

        return $valor;
    }
}
