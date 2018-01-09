<?php

namespace Urbem\CoreBundle\Model\Normas;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;

/**
 * Class TipoNormaModel
 *
 * @package Urbem\CoreBundle\Model\Normas
 */
class TipoNormaModel extends AbstractModel
{
    /**
     * @var EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var EntityRepository|null
     */
    protected $repository = null;

    const VALOR_INICIAL = 1;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TipoNorma::class);
    }

    /**
     * @param TipoNorma $tipoNorma
     *
     * @return bool
     */
    public function canRemove($tipoNorma)
    {
        if (!$tipoNorma->getFkNormasNormas()->isEmpty()) {
            return false;
        }

        /** @var AtributoTipoNorma $atributoTipoNorma */
        foreach ($tipoNorma->getFkNormasAtributoTipoNormas() as $atributoTipoNorma) {
            if (!$atributoTipoNorma->getFkNormasAtributoNormaValores()->isEmpty()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return int
     */
    public function getProximoCodTipoNorma()
    {
        $em = $this->entityManager;
        $repository = $em->getRepository('CoreBundle:Normas\TipoNorma');
        $tipoNorma = $repository->findOneBy([], ['codTipoNorma' => 'DESC']);
        $codTipoNorma = self::VALOR_INICIAL;
        if ($tipoNorma) {
            $codTipoNorma = $tipoNorma->getCodTipoNorma() + 1;
        }
        return $codTipoNorma;
    }
}
