<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana;

/**
 * Class LicencaDiasSemanaModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class LicencaDiasSemanaModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * LicencaDiasSemanaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LicencaDiasSemana::class);
    }

    /**
     * @param $codLicenca
     * @param $exercicio
     * @return array
     */
    public function getLicencaDiasByCodLicencaAndExercicio($codLicenca, $exercicio)
    {
        return $this->repository->findBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
    }

    /**
     * @param $arr
     */
    public function updateLicenca($arr)
    {
        foreach ($arr as $entity) {
            $this->entityManager->persist($entity);
        }
        $this->entityManager->flush();
    }
}
