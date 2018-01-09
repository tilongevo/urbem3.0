<?php

namespace Urbem\CoreBundle\Model\Normas;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Normas\AtributoNormaValor;
use Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma;
use Urbem\CoreBundle\Entity\Normas\Norma;

/**
 * Class AtributoNormaValorModel
 *
 * @package Urbem\CoreBundle\Model\Normas
 */
class AtributoNormaValorModel extends AbstractModel
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * AtributoNormaValor constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(AtributoNormaValor::class);
    }

    /**
     * @param Norma                $norma
     * @param AtributoTipoNorma    $atributoTipoNorma
     * @param string|integer|float $valor
     *
     * @return AtributoNormaValor
     */
    public function buildOne(Norma $norma, AtributoTipoNorma $atributoTipoNorma, $valor)
    {
        $atributoNormaValor = new AtributoNormaValor();
        $atributoNormaValor->setFkNormasNorma($norma);
        $atributoNormaValor->setFkNormasAtributoTipoNorma($atributoTipoNorma);
        $atributoNormaValor->setValor($valor);

        $this->save($atributoNormaValor);

        return $atributoNormaValor;
    }

    /**
     * @param AtributoNormaValor   $atributoNormaValor
     * @param string|integer|float $valor
     *
     * @return AtributoNormaValor
     */
    public function updateOne(AtributoNormaValor $atributoNormaValor, $valor)
    {
        $atributoNormaValor->setValor($valor);

        $this->save($atributoNormaValor);

        return $atributoNormaValor;
    }
}
