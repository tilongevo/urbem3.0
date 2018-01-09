<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;

class EspecialidadeModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Especialidade::class);
    }

    /**
     * Retorna a lista de de especialidades por cargo e subdivisao
     *
     * @param integer $codSubDivisao
     * @param integer $codCargo
     * @param bool    $sonata
     *
     * @return array
     */
    public function consultaEspecialidadeCargoSubDivisao($codSubDivisao, $codCargo, $sonata = false)
    {
        $params = [];

        $params['cod_sub_divisao'] = $codSubDivisao;
        $params['cod_cargo'] = $codCargo;

        $especialidades = $this->repository->findEspecialidadeCargoSubDivisao($params);

        $results = [];
        foreach ($especialidades as $especialidade) {
            if (!$sonata) {
                $results[] = [
                    'cod_especialidade' => $especialidade->cod_especialidade,
                    'descricao_especialidade' => $especialidade->cod_especialidade . " - " . $especialidade->descricao_especialidade
                ];
            } else {
                $results[$especialidade->cod_especialidade . " - " . $especialidade->descricao_especialidade] = $especialidade->cod_especialidade;
            }
        }

        return $results;
    }

    /**
     * @param      $stFiltro
     * @param bool $sonata
     * @param bool $somenteEspecialidade
     *
     * @return array
     */
    public function consultaEspecialidadeCargo($stFiltro, $sonata = false, $somenteEspecialidade = false)
    {
        $especialidades = $this->repository->findEspecialidadeCargo($stFiltro);

        $results = [];

        foreach ($especialidades as $especialidade) {
            if (!$somenteEspecialidade) {
                if (!$sonata) {
                    $results[] = [
                        'cod_cargo' => $especialidade['cod_cargo'],
                        'descricao' => $especialidade['cod_cargo'] . "-" . $especialidade['descricao'] . " - " . $especialidade['nom_sub_divisao'] . " - " . $especialidade['nom_regime']
                    ];
                } else {
                    $results[$especialidade['descricao'] . " - " . $especialidade['nom_sub_divisao'] . " - " . $especialidade['nom_regime']] = $especialidade['cod_cargo'];
                }
            } else {
                if (!$sonata) {
                    $results[] = [
                        'cod_especialidade' => $especialidade['cod_especialidade'],
                        'descricao' => $especialidade['cod_especialidade'] . " - " . $especialidade['descricao_especialidade']
                    ];
                } else {
                    $results[$especialidade['descricao_especialidade']] = $especialidade['cod_especialidade'];
                }
            }
        }

        return $results;
    }

    /**
     * @param $filter
     * @param bool $somenteEspecialidade
     *
     * @return array
     */
    public function consultaCargoSubDivisaoRegime($filter, $somenteEspecialidade = false)
    {
        $cargos = $this->repository->findCargoSubDivisaoRegime($filter);

        $results = array();

        foreach ($cargos as $cargo) {
            if (!$somenteEspecialidade) {
                $results[sprintf('%s~%s~%s', $cargo['cod_regime'], $cargo['cod_sub_divisao'], $cargo['cod_cargo'])] = sprintf('%s - %s - %s - %s', $cargo['cod_cargo'], $cargo['descricao'], $cargo['regime_descricao'], $cargo['sub_divisao_descricao']);
            } else {
                if ($cargo['especialidade'] == true) {
                    $results[sprintf('%s~%s~%s', $cargo['cod_regime'], $cargo['cod_sub_divisao'], $cargo['cod_cargo'])] = sprintf('%s - %s - %s - %s', $cargo['cod_cargo'], $cargo['descricao'], $cargo['regime_descricao'], $cargo['sub_divisao_descricao']);
                }
            }
        }

        return $results;
    }
}
