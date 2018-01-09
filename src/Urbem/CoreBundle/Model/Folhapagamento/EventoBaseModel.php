<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoBaseRepository;

class EventoBaseModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var EventoBaseRepository|null  */
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\EventoBase");
    }

    /**
     * @param $eventos | array
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @return array
     */
    public function recuperaEventoBaseDesdobramento($eventos, $codContrato, $codPeriodoMovimentacao)
    {
        return $this->repository->recuperaEventoBaseDesdobramento($eventos, $codContrato, $codPeriodoMovimentacao);
    }
}
