<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa;

/**
 * Class ResponsavelEmpresaModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class ResponsavelEmpresaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;


    /**
     * ResponsavelEmpresaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ResponsavelEmpresa::class);
    }

    /**
     * @param $numCgm
     * @return mixed
     */
    public function getResponsavelEmpresa($numCgm)
    {
        $repository = $this->entityManager->getRepository('CoreBundle:Economico\\Responsavel');
        return $repository->findBy(['numcgm' => $numCgm]);
    }
}
