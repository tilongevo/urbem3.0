<?php
namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado;
use Urbem\CoreBundle\Repository\Pessoal\AssentamentoGeradoRepository;

class AssentamentoGeradoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var AssentamentoGeradoRepository|null */
    protected $repository = null;

    /**
     * AssentamentoGeradoModel constructor.
     * @param $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(AssentamentoGerado::class);
    }

    /**
     * @return array
     */
    public function recuperaEventosAssentamento($filtro = false)
    {
        return $this->repository->recuperaEventosAssentamento($filtro);
    }

    /**
     * @param $params
     * @param $filtros
     *
     * @return array
     */
    public function recuperaAssentamentoSEFIP($params, $filtros)
    {
        return $this->repository->recuperaAssentamentoSEFIP($params, $filtros);
    }

    /**
     * @param      $params
     * @param bool $filtro
     *
     * @return mixed
     */
    public function recuperaAssentamentoTemporario($params, $filtro = false)
    {
        return $this->repository->recuperaAssentamentoTemporario($params, $filtro);
    }

    /**
     * @param $filtro
     * @param $ordem
     * @return object
     */
    public function recuperaAssentamentoGerado($filtro, $ordem)
    {
        return $this->repository->recuperaAssentamentoGerado($filtro, $ordem);
    }

    /**
     * @param $timestamp
     * @param $codAssentamentoGerado
     * @return null|AssentamentoGerado|AssentamentoGerado
     */
    public function recuperaAssentamentoGeradoPorCod($timestamp, $codAssentamentoGerado)
    {
        return $this->repository->findOneBy([
            'timestamp' => $timestamp,
            'codAssentamentoGerado' => $codAssentamentoGerado
        ]);
    }

    /**
     * @param $filtro
     * @return mixed
     */
    public function getAssentamentoGeradoByCodContratoAndExercicio($filtro)
    {
        return $this->repository->getAssentamentoGeradoByCodContratoAndExercicio($filtro);
    }
}
