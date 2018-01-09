<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class NaturezaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class NaturezaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * NaturezaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\Natureza::class);
    }

    /**
     * @param $codNatureza
     * @param $tipoNatureza
     * @return null|Almoxarifado\Natureza
     */
    public function getOneNaturezaByCodNaturezaAndTipoNatureza($codNatureza, $tipoNatureza)
    {
        return $this->entityManager->getRepository(Almoxarifado\Natureza::class)
            ->findOneBy([
                'codNatureza' => $codNatureza,
                'tipoNatureza' => $tipoNatureza
            ]);
    }
}
