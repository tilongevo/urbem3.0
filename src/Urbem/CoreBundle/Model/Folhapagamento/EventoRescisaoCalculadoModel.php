<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository\Folhapagamento\EventoDecimoCalculadoRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoCalculadoRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoFeriasCalculadoRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoRescisaoCalculadoRepository;

class EventoRescisaoCalculadoModel
{
    private $entityManager = null;
    /** @var EventoRescisaoCalculadoRepository|null  */
    private $eventoRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventoRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\EventoRescisaoCalculado");
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     * @return mixed
     */
    public function montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        return $this->eventoRepository->montaRecuperaValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade);
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $numCgm
     * @param $natureza
     * @param $entidade
     * @return mixed
     */
    public function montaRecuperaRotuloValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade)
    {
        return $this->eventoRepository->montaRecuperaRotuloValoresAcumuladosCalculo($codContrato, $codPeriodoMovimentacao, $numCgm, $natureza, $entidade);
    }

    /**
     * @param $filtroEvento
     * @param $ordemEvento
     * @return array
     */
    public function recuperaEventoRescisaoCalculado($filtroEvento, $ordemEvento = false)
    {
        return $this->eventoRepository->recuperaEventoRescisaoCalculado($filtroEvento, $ordemEvento);
    }
}
