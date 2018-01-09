<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoComplementarRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoDecimoRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoFeriasRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoPeriodoRepository;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoRescisaoRepository;

class RegistroEventoRescisaoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var RegistroEventoRescisaoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\RegistroEventoRescisao");
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $anoMesCompetencia
     * @param $stFiltro
     * @return mixed
     */
    public function recuperaContratosDoFiltro($exercicio, $entidade, $anoMesCompetencia, $stFiltro = false, $status = false)
    {
        return $this->repository->recuperaContratosDoFiltro($exercicio, $entidade, $anoMesCompetencia, $stFiltro, $status);
    }

    /**
     * @param $codContrato
     * @param $periodoMovimentacao
     * @return array
     */
    public function montaRecuperaRelacionamento($codContrato, $periodoMovimentacao)
    {
        return $this->repository->montaRecuperaRelacionamento($codContrato, $periodoMovimentacao);
    }

    /**
     * @param $codContrato
     * @return array
     */
    public function recuperaRegistrosEventosDoContrato($codContrato)
    {
        return $this->repository->recuperaRegistrosEventosDoContrato($codContrato);
    }

    /**
     * @param $codEvento
     * @return mixed
     */
    public function getNextCodRegistro($codEvento)
    {
        return $this->repository->getNextCodRegistro($codEvento);
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $anoMesCompetencia
     * @param bool $stFiltro
     * @param bool $ativo
     * @return array
     */
    public function recuperaRescisaoContratoPensionista($exercicio, $entidade, $anoMesCompetencia, $stFiltro = false, $ativo = false)
    {
        return $this->repository->recuperaRescisaoContratoPensionista($exercicio, $entidade, $anoMesCompetencia, $stFiltro, $ativo);
    }

    /**
     * @param      $exercicio
     * @param bool $stFiltro
     *
     * @return mixed
     */
    public function recuperaRescisaoContrato($exercicio, $stFiltro = false)
    {
        return $this->repository->recuperaRescisaoContrato($exercicio, $stFiltro);
    }
}
