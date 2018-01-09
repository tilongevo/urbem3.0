<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class RescisaoContratoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class RescisaoContratoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * LicitacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\RescisaoContrato");
    }

    /**
     * @param $exercicio
     * @param $numContrato
     * @return mixed
     */
    public function getProximoNumRescisao($exercicio, $numContrato)
    {
        return $this->repository->getProximoNumRescisao($exercicio, $numContrato);
    }
}
