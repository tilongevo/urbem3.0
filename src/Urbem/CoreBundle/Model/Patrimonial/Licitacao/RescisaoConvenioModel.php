<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class RescisaoConvenioModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class RescisaoConvenioModel extends AbstractModel
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
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\RescisaoConvenio");
    }

    /**
     * @param $exercicio
     * @param $numConvenio
     * @return mixed
     */
    public function getProximoNumRescisao($exercicio, $numConvenio)
    {
        return $this->repository->getProximoNumRescisao($exercicio, $numConvenio);
    }
}
