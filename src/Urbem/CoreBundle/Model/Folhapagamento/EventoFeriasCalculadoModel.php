<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoCalculadoRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\EventoFeriasCalculadoRepository;

class EventoFeriasCalculadoModel
{
    private $entityManager = null;
    /** @var EventoFeriasCalculadoRepository|null  */
    private $eventoRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventoRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\EventoFeriasCalculado");
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
}
