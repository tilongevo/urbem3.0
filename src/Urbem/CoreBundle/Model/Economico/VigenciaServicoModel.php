<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class VigenciaServicoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class VigenciaServicoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * VigenciaServicoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Economico\\VigenciaServico");
    }

    /**
     * @param $dtInicio
     * @return bool
     */
    public function isDataInicioMaior($dtInicio)
    {
        $result = $this->repository->findAll();
        if (empty($result)) {
            $result = true;
        } else {
            $result = $this->repository->isDataInicioMaior($dtInicio);
        }
        return $result;
    }

    /**
     * @param $codVigencia
     * @return mixed
     */
    public function findOneByCodVigencia($codVigencia)
    {
        return $this->repository->findOneByCodVigencia($codVigencia);
    }
}
