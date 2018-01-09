<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwAssuntoAtributo;
use Urbem\CoreBundle\Entity\SwAssuntoAtributoValor;
use Urbem\CoreBundle\Entity\SwProcesso;

/**
 * Class SwAssuntoAtributoValorModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwAssuntoAtributoValorModel extends AbstractModel implements InterfaceModel
{
    /** @var \Doctrine\ORM\EntityRepository  */
    protected $repository;

    /**
     * InterfaceModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SwAssuntoAtributoValor::class);
    }

    /**
     * @param object $object
     *
     * @return boolean
     */
    public function canRemove($object)
    {
        return false;
    }

    /**
     * @param SwAssuntoAtributo $swAssuntoAtributo
     * @param SwProcesso        $swProcesso
     * @param string|integer    $valor
     *
     * @return SwAssuntoAtributoValor
     */
    public function buildOne(SwAssuntoAtributo $swAssuntoAtributo, SwProcesso $swProcesso, $valor)
    {
        $swAssuntoAtributoValor = new SwAssuntoAtributoValor();
        $swAssuntoAtributoValor
            ->setFkSwAssuntoAtributo($swAssuntoAtributo)
            ->setFkSwProcesso($swProcesso)
            ->setValor($valor);

        $this->entityManager->persist($swAssuntoAtributoValor);

        return $swAssuntoAtributoValor;
    }
}
