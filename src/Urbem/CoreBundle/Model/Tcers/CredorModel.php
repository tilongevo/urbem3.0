<?php

namespace Urbem\CoreBundle\Model\Tcers;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Tcers\Credor;
use Urbem\CoreBundle\Model\InterfaceModel;

/**
 * Class CredorModel
 * @package Urbem\CoreBundle\Model\Tcers
 */
class CredorModel extends AbstractModel implements InterfaceModel
{
    /**
     * @var \Doctrine\ORM\EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var \Doctrine\ORM\EntityRepository|null
     */
    protected $repository = null;

    /**
     * ReportModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Credor::class);
    }

    /**
     * @param object $object
     */
    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * @param $exercicio
     * @param null $ano
     * @return string
     */
    public function getRecuperaDadosCredorConversao($exercicio, $ano = null)
    {
        return $this->repository->findRecuperaDadosCredorConversao($exercicio, $ano);
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $usuario
     * @param $exercicio
     * @return mixed
     */
    public function getRecuperaDadosCredor(Usuario $usuario, $exercicio)
    {
        return $this->repository->findRecuperaDadosCredor($usuario, $exercicio);
    }
}
