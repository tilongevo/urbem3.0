<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Complementar;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;

/**
 * Class FolhaComplementarModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class FolhaComplementarModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ORM\EntityRepository|null|\Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\ComplementarRepository  */
    protected $repository = null;

    /**
     * FolhaComplementarModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Complementar::class);
    }

    /**
     * @param $timestamp
     * @param $codPeriodoMovimentacao
     * @return array
     */
    public function recuperaFolhaComplementarFechadaAnteriorFolhaSalario($timestamp, $codPeriodoMovimentacao)
    {
        return $this->repository->recuperaFolhaComplementarFechadaAnteriorFolhaSalario($timestamp, $codPeriodoMovimentacao);
    }

    /**
     * @param $timestamp
     * @param $codPeriodoMovimentacao
     * @return array
     */
    public function recuperaFolhaComplementarFechada($timestamp, $codPeriodoMovimentacao)
    {
        return $this->repository->recuperaFolhaComplementarFechada($timestamp, $codPeriodoMovimentacao);
    }

    /**
     * @param $codPeriodoMovimentacao
     * @return mixed
     */
    public function consultaFolhaComplementar($codPeriodoMovimentacao)
    {
        return $this->repository->consultaFolhaComplementar($codPeriodoMovimentacao);
    }

    /**
     * @param $codPeriodoMovimentacao
     * @return mixed
     */
    public function getFolhaComplementar($codPeriodoMovimentacao)
    {
        return $this->repository->getFolhaComplementar($codPeriodoMovimentacao);
    }

    /**
     * @param $codPeriodoMovimentacao
     * @param $timestamp
     * @return mixed
     */
    public function recuperaRelacionamentoFechadaPosteriorSalario($codPeriodoMovimentacao, $timestamp)
    {
        return $this->repository->recuperaRelacionamentoFechadaPosteriorSalario($codPeriodoMovimentacao, $timestamp);
    }

    /**
     * @param $codPeriodoMovimentacao
     * @return int
     */
    public function getNextCodComplementar($codPeriodoMovimentacao)
    {
        return $this->repository->getNextCodComplementar($codPeriodoMovimentacao);
    }

    /**
     * @param $codPeriodoMovimentacao
     * @return mixed
     */
    public function consultaFolhaComplementarStatus($codPeriodoMovimentacao)
    {
        return $this->repository->consultaFolhaComplementarStatus($codPeriodoMovimentacao);
    }

    /**
     * Retorna a lista de folha complementar
     * @param string $ano
     * @param string $mes
     * @param boolean $sonata
     * @return array
     */
    public function listaFolhaPagamentoComplementar($ano, $mes, $sonata = false)
    {
        $periodoMovimentacao = $this->entityManager->getRepository(PeriodoMovimentacao::class)
        ->recuperaPeriodoMovimentacaoPorCompetencia($ano, $mes);

        $complementares = $this->repository->listaFolhaPagamentoComplementar($periodoMovimentacao['cod_periodo_movimentacao']);

        $options = [];
        foreach ($complementares as $complementar) {
            if ($sonata) {
                $options[$complementar['cod_complementar']] = $complementar['cod_complementar'];
            } else {
                $options[] = [
                    'id' => $complementar['cod_complementar'],
                    'label' => $complementar['cod_complementar']
                ];
            }
        }

        return $options;
    }

    /**
     * @param null $filtro
     * @param null $ordem
     * @return mixed
     */
    public function recuperaRelacionamento($filtro = null, $ordem = null)
    {
        return $this->repository->recuperaRelacionamento($filtro, $ordem);
    }
}
