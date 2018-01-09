<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Folhapagamento\UltimoRegistroEventoFeriasRepository;

class UltimoRegistroEventoFeriasModel extends AbstractModel
{
    /** @var EntityManager|null  */
    protected $em = null;

    /** @var UltimoRegistroEventoFeriasRepository|null  */
    protected $repository = null;

    /**
     * UltimoRegistroEventoFeriasModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository('CoreBundle:Folhapagamento\UltimoRegistroEventoFerias');
    }

    /**
     * @param $filtro
     * @param $ordem
     * @return object
     */
    public function recuperaRegistrosEventoFeriasDoContrato($filtro, $ordem)
    {
        return $this->repository->recuperaRegistrosEventoFeriasDoContrato($filtro, $ordem);
    }

    /**
     * @param $codEvento
     * @param $timestamp
     * @param $codRegistro
     * @param $desdobramento
     * @return null|object|\Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias
     */
    public function getRegistrosEventoFeriasDoContrato($codEvento, $timestamp, $codRegistro, $desdobramento)
    {
        return $this->repository->findOneBy([
            'codEvento' =>  $codEvento,
            'timestamp' => $timestamp,
            'codRegistro' => $codRegistro,
            'desdobramento' => $desdobramento
        ]);
    }
}
