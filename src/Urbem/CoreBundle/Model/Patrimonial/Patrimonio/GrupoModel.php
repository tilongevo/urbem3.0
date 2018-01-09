<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Patrimonio\Grupo;
use Urbem\CoreBundle\Model;

class GrupoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\Grupo");
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    public function findOneByCodGrupo($codGrupo)
    {
        return $this->repository->findOneByCodGrupo($codGrupo);
    }

    /**
     * @param $codNatureza
     * @return mixed
     */
    public function getProximoCodGrupo($codNatureza)
    {
        return $this->repository->getProximoCodGrupo($codNatureza);
    }

    /**
     * @param array $params
     * @return Grupo
     */
    public function findOneBy($params)
    {
        return $this->repository->findOneBy($params);
    }

    /**
     * @param array $params
     * @return Grupo
     */
    public function findBy($params,$order=[])
    {
        return $this->repository->findBy($params,$order);
    }
}
