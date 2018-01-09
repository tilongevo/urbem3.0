<?php

namespace Urbem\CoreBundle\Model\Normas;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;

/**
 * Class AtributoTipoNormaModel
 *
 * @package Urbem\CoreBundle\Model\Normas
 */
class AtributoTipoNormaModel extends AbstractModel
{
    /** @var EntityRepository $repository */
    protected $repository;

    /**
     * AtributoTipoNormaModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(AtributoTipoNorma::class);
    }

    /**
     * @param AtributoDinamico $atributoDinamico
     * @param TipoNorma        $tipoNorma
     *
     * @return AtributoTipoNorma
     */
    public function buildOneUsingAtributoDinamicoAndTipoNorma(AtributoDinamico $atributoDinamico, TipoNorma $tipoNorma)
    {
        $atributoTipoNorma = new AtributoTipoNorma();
        $atributoTipoNorma->setFkAdministracaoAtributoDinamico($atributoDinamico);
        $atributoTipoNorma->setFkNormasTipoNorma($tipoNorma);
        $atributoTipoNorma->setAtivo(1);

        $this->save($atributoTipoNorma);

        return $atributoTipoNorma;
    }
}
