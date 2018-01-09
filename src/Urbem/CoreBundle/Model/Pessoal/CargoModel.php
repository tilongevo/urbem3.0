<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFuncao;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\InterfaceModel;

class CargoModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Cargo::class);
    }

    public function canRemove($object)
    {
        $contratoServidorFuncao = $this->entityManager->getRepository(ContratoServidorFuncao::class);
        $contratoServidorFuncaoExists = $contratoServidorFuncao->findOneByCodCargo($object->getCodCargo());

        $contratoServidor = $this->entityManager->getRepository(ContratoServidor::class);
        $contratoServidorExists = $contratoServidor->findOneByCodCargo($object->getCodCargo());

        $res = $this->repository->findCargosComEspecialidadeEmContratoServidor()->getFirstResult();

        return empty($contratoServidorFuncaoExists) && empty($contratoServidorExists) && empty($res);
    }

    /**
     * Retorna lista de cargos por subdivisao
     *
     * @param integer|array $codSubDivisao
     * @param bool          $sonata
     *
     * @return array
     */
    public function consultaCargoSubDivisao($codSubDivisao, $sonata = false)
    {
        $periodoMovimentacao = new PeriodoMovimentacaoModel($this->entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $params = [];
        $params['dt_inicial'] = $periodoFinal->getDtInicial()->format('d/m/Y');
        $params['dt_final'] = $periodoFinal->getDtFinal()->format('d/m/Y');
        $params['cod_sub_divisao'] = $codSubDivisao;

        $cargos = $this->repository->findCargoSubDivisao($params);

        $results = [];
        foreach ($cargos as $cargo) {
            if (!$sonata) {
                $results[] = [
                    'cod_cargo' => $cargo->cod_cargo,
                    'descricao' => $cargo->cod_cargo . " - " . $cargo->descricao
                ];
            } else {
                $results[$cargo->cod_cargo . " - " . $cargo->descricao] = $cargo->cod_cargo;
            }
        }

        return $results;
    }

    public function consultaInformacoesSalariais($params)
    {
        return $this->repository->consultaInformacoesSalariais($params);
    }

    /**
     * @param array $codSubDivisao
     *
     * @return array
     */
    public function consultaCargoSubDivisoes($codSubDivisao)
    {
        $cargos = $this->repository->findCargoBySubdivisoes($codSubDivisao);

        $results = [];
        foreach ($cargos as $cargo) {
            $results[$cargo->cod_cargo . " - " . $cargo->descr_cargo] = $cargo->cod_cargo;
        }

        return $results;
    }

    /**
     * @param $codCargo
     * @return mixed
     */
    public function findInformacoesCargo($codCargo)
    {
        return $this->repository->findInformacoesCargo($codCargo);
    }
}
