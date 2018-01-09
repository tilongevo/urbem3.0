<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\ProcessoLicenca;

/**
 * Class ProcessoLicencaModel
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class ProcessoLicencaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * ProcessoLicencaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(ProcessoLicenca::class);
    }

    /**
     * @param $codLicenca
     * @return mixed
     */
    public function getProcessoLicencaByLicenca($codLicenca)
    {
        return $this->repository->findOneByCodLicenca($codLicenca);
    }

    /**
     * @param $codLicenca
     * @param $exercicio
     * @return null|object
     */
    public function getProcessoLicencaByLicencaAndExercicio($codLicenca, $exercicio)
    {
        return $this->repository->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
    }
}
