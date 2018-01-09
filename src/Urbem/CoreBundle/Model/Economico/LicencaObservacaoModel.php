<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\LicencaObservacao;

/**
 * Class LicencaObservacaoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class LicencaObservacaoModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * LicencaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LicencaObservacao::class);
    }

    /**
     * @param $codLicenca
     * @param $exercicio
     * @return null|object
     */
    public function getLicencaObservacaoCodLicencaExercicio($codLicenca, $exercicio)
    {
        return $this->repository->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
    }
}
