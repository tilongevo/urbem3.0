<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class NaturezaJuridicaModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class NaturezaJuridicaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * NaturezaJuridicaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Economico\\NaturezaJuridica");
    }

    /**
     * @param $codNatureza
     * @return mixed
     */
    public function getNaturezaJuridicaByCodNatureza($codNatureza)
    {
        return $this->repository->findOneByCodNatureza($codNatureza);
    }

    /**
     * @param $nomeNatureza
     * @return mixed
     */
    public function getNaturezaJuridicaByNomeNatureza($nomeNatureza)
    {
        return $this->repository->findOneByNomNatureza($nomeNatureza);
    }
}
