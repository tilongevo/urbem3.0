<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Doctrine\ORM\Query;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\UltimoRegistroEventoDecimoRepository;

class UltimoRegistroEventoDecimoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var UltimoRegistroEventoDecimoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\UltimoRegistroEventoDecimo");
    }

    public function recuperaRegistrosDeEventoSemCalculo($filtro)
    {
        return $this->repository->recuperaRegistrosDeEventoSemCalculo($filtro);
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @return mixed
     */
    public function montaRecuperaRegistrosEventoDecimoDoContrato($codContrato, $codPeriodoMovimentacao)
    {
        return $this->repository->montaRecuperaRegistrosEventoDecimoDoContrato($codContrato, $codPeriodoMovimentacao);
    }

    /**
     * @param $codRegistro
     * @param $codEvento
     * @param $desdobramento
     * @param $timestamp
     * @param $entidade
     * @return mixed
     */
    public function montaDeletarUltimoRegistro($codRegistro, $codEvento, $desdobramento, $timestamp, $entidade)
    {
        return $this->repository->montaDeletarUltimoRegistro($codRegistro, $codEvento, $desdobramento, $timestamp, $entidade);
    }

    /**
     * @param $codRegistro
     * @param $codEvento
     * @param $desdobramento
     * @param $timestamp
     * @param $entidade
     * @return mixed
     */
    public function montaDeletarUltimoRegistroEvento($codRegistro, $codEvento, $desdobramento, $timestamp, $entidade)
    {
        return $this->repository->montaDeletarUltimoRegistroEvento($codRegistro, $codEvento, $desdobramento, $timestamp, $entidade);
    }

    /**
     * @param bool $filtro
     * @return mixed
     */
    public function montaRecuperaRegistrosDeEventoSemCalculo($filtro = false)
    {
        return $this->repository->montaRecuperaRegistrosDeEventoSemCalculo($filtro);
    }
}
