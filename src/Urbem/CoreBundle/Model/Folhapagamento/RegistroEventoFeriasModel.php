<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoFeriasRepository;

class RegistroEventoFeriasModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var RegistroEventoFeriasRepository|null  */
    protected $repository = null;

    /**
     * RegistroEventoFeriasModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\RegistroEventoFerias");
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $anoMesCompetencia
     * @param $stFiltro
     * @return mixed
     */
    public function recuperaContratosDoFiltro($exercicio, $entidade, $anoMesCompetencia, $stFiltro = false)
    {
        return $this->repository->recuperaContratosDoFiltro($exercicio, $entidade, $anoMesCompetencia, $stFiltro);
    }

    /**
     * @param $codContrato
     * @param $periodoMovimentacao
     * @return array
     */
    public function montaRecuperaRelacionamento($filtro = null, $ordem = null)
    {
        return $this->repository->montaRecuperaRelacionamento($filtro, $ordem);
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
     * @param $codContrato
     * @return array
     */
    public function recuperaRegistrosEventosDoContrato($codContrato)
    {
        return $this->repository->recuperaRegistrosEventosDoContrato($codContrato);
    }

    /**
     * @param $filtro
     * @return array
     */
    public function recuperaRegistrosEventosFerias($filtro)
    {
        return $this->repository->recuperaRegistrosEventosFerias($filtro);
    }
}
