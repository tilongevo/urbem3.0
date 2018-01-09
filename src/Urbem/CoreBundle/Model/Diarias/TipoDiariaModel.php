<?php

namespace Urbem\CoreBundle\Model\Diarias;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class TipoDiariaModel
 * @package Urbem\CoreBundle\Model\Diarias
 */
class TipoDiariaModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ORM\EntityRepository|null */
    protected $repository = null;

    /**
     * AutorizacaoEmpenhoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        /** @var AutorizacaoEmpenhoRepository repository */
        $this->repository = $this->entityManager->getRepository("CoreBundle:Diarias\TipoDiaria");
    }

    /**
     * @return mixed
     */
    public function getProximoCod()
    {
        return $this->repository->getProximoCod();
    }

    /**
     * @param $numcgm
     * @param $exercicio
     * @param $filter
     * @return mixed
     */
    public function filterAutorizacaoEmpenho($numcgm, $exercicio, $filter)
    {
        $filterAutorizacaoEmpenho = $this->entityManager
            ->getRepository('CoreBundle:Empenho\AutorizacaoEmpenho')
            ->getAutorizacaoEmpenho($numcgm, $exercicio, $filter);

        return $filterAutorizacaoEmpenho;
    }
}
