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

class RegistroEventoDecimoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var RegistroEventoDecimoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\RegistroEventoDecimo");
    }

    /**
     * @param      $exercicio
     * @param      $entidade
     * @param bool $autocomplete
     * @param bool $stFiltro
     *
     * @return array
     */
    public function recuperaContratosDoFiltro($exercicio, $entidade, $autocomplete = false, $stFiltro = false, $ativo = false)
    {
        return $this->repository->recuperaContratosDoFiltro($exercicio, $entidade, $autocomplete, $stFiltro, $ativo);
    }

    /**
     * @param bool $stFiltro
     * @param bool $orderBy
     *
     * @return array
     */
    public function montaRecuperaRelacionamento($stFiltro = false, $orderBy = false)
    {
        return $this->repository->montaRecuperaRelacionamento($stFiltro, $orderBy);
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
     * @param $params
     *
     * @return array
     */
    public function montaParametrosRecuperaRelacionamento($params)
    {
        $stFiltro = " AND cod_contrato =  " . $params['codContrato'] . "
         AND cod_periodo_movimentacao = " . $params['codPeriodoMovimentacao'] . " 
         AND registro_evento_decimo.cod_evento = " . $params['codEvento'] . " AND 
         registro_evento_decimo.desdobramento = '" . $params['desdobramento'] . "'
          AND evento.natureza != '". $params['natureza']. "'";

        return $this->repository->montaRecuperaRelacionamento($stFiltro, false);
    }
}
