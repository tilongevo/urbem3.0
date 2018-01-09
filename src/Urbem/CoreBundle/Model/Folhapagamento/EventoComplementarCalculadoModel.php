<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoCalculadoRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoComplementarCalculadoRepository;

class EventoComplementarCalculadoModel
{
    private $entityManager = null;
    /** @var EventoComplementarCalculadoRepository|null  */
    private $eventoRepository = null;

    /**
     * EventoComplementarCalculadoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventoRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\EventoComplementarCalculado");
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
     * @param bool   $filtro
     * @param string $entidade
     *
     * @return array
     */
    public function montaRecuperaEventosCalculados($filtro = false, $entidade = '')
    {
        return $this->eventoRepository->montaRecuperaEventosCalculados($filtro, $entidade);
    }

    /**
     * @param bool $filtro
     *
     * @return array
     */
    public function recuperaEventoComplementarCalculadoParaRelatorio($filtro = false)
    {
        return $this->eventoRepository->recuperaEventoComplementarCalculadoParaRelatorio($filtro);
    }

    /**
     * @param $filtro
     * @return object
     */
    public function recuperaEventoCalculdado($filtro)
    {
        return $this->eventoRepository->recuperaEventoComplementarCalculado($filtro);
    }
}
