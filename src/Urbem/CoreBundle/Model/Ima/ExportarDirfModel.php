<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\Ima\ExportarDirfRepository;

/**
 * Class ExportarDirfModel
 */
class ExportarDirfModel extends AbstractModel
{

    protected $entityManager = null;
    protected $repository;

    /**
     * ExportarPagamentoBanrisulModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = new ExportarDirfRepository($this->entityManager);
    }

    /**
     * @param array $where
     * @param array $param
     * @return mixed
     */
    public function getRelacionamento(Array $where = [], Array $params = [])
    {
        return $this->repository->getRelacionamento($where, $params);
    }
    
    /**
     * @param array $where
     * @param array $params
     * @return mixed
     */
    public function getRelacionamentoPlanos(Array $where = [], Array $params = [])
    {
        return $this->repository->getRelacionamentoPlanos($where, $params);
    }
    
    /**
     * @param array $where
     * @param array $param
     * @return mixed
     */
    public function getTodosPlanos(Array $where = [], Array $params = [])
    {
        return $this->repository->getTodosPlanos($where, $params);
    }
    
    /**
     * @param string $entidade
     * @param int $anoExercicio
     * @param string $tipoFiltro
     * @param string $codigos
     * @return mixed
     */
    public function exportarDirf($entidade, $anoExercicio, $tipoFiltro, $codigos){
        return $this->repository->exportarDirf($entidade, $anoExercicio, $tipoFiltro, $codigos);
    }
    
    /**
     * @param string $entidade
     * @param int $anoExercicio
     * @param int $anoExercicioAnterior
     * @param string $tipoFiltro
     * @param string $codigos
     * @return mixed
     */
    public function exportarDirfPagamento($entidade, $anoExercicio, $anoExercicioAnterior, $tipoFiltro, $codigos)
    {
        return $this->repository->exportarDirfPagamento($entidade, $anoExercicio, $anoExercicioAnterior, $tipoFiltro, $codigos);
    }
    
    /**
     * @param string $entidade
     * @param int $codEntidade
     * @param int $anoCompetencia
     * @return mixed
     */
    public function exportarDirfPrestadores($entidade, $codEntidade, $anoCompetencia, $anoCompetenciaAnterior)
    {
        return $this->repository->exportarDirfPrestadores($entidade, $codEntidade, $anoCompetencia, $anoCompetenciaAnterior);
    }
    
    /**
     * @param string $entidade
     * @param int $codEntidade
     * @param int $anoCompetencia
     * @return mixed
     */
    public function exportarPorFuncao($funcao, $entidade, $codEntidade, $anoCompetencia)
    {
        return $this->repository->exportarPorFuncao($funcao, $entidade, $codEntidade, $anoCompetencia);
    }
    
    /**
     * @param string $entidade
     * @param string $tipoFiltro
     * @param string $valores
     * @param int $anoExercicio
     * @param int $codEvento
     * @param int $anoAnterior
     * @return array
     */
    public function getPlanoSaudeDirfPlano($entidade, $tipoFiltro, $valores, $anoExercicio, $codEvento, $anoAnterior = '', Array $where = [])
    {
        return $this->repository->getPlanoSaudeDirfPlano($entidade, $tipoFiltro, $valores, $anoExercicio, $codEvento, $anoAnterior, $where);
    }
    
}
