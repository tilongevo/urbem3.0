<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class TcemgEntidadeRequisitosCargoRepository
 * @package Urbem\CoreBundle\Repository\Folhapagamento
 */
class TcemgEntidadeRequisitosCargoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $folhaPagamento
     * @param $pessoal
     * @return array
     */
    public function getRequisitoCargo($exercicio, $folhaPagamento, $pessoal)
    {
        $sql = <<<SQL
              SELECT 
	                tcemg_entidade_requisitos_cargo.cod_tipo
	                ,tcemg_entidade_requisitos_cargo.cod_cargo
	                ,cargo.cod_cargo||' - '||cargo.descricao as nom_cargo
	            FROM {$folhaPagamento}.tcemg_entidade_requisitos_cargo
	            INNER JOIN {$pessoal}.cargo
	                ON cargo.cod_cargo = tcemg_entidade_requisitos_cargo.cod_cargo
	            
	             WHERE tcemg_entidade_requisitos_cargo.exercicio = '{$exercicio}' 
 
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $folhaPagamento
     * @param $requisito
     * @param $codCargo
     * @return bool|string
     */
    public function save($exercicio, $folhaPagamento, $requisito, $codCargo)
    {
        $conn = $this->_em->getConnection();
        $conn->beginTransaction();
        try {
            $sql = " INSERT INTO {$folhaPagamento}.tcemg_entidade_requisitos_cargo (exercicio,cod_tipo,cod_cargo) VALUES('{$exercicio}',{$requisito},{$codCargo})";
            $conn->executeQuery($sql);

            $conn->commit();

            return true;
        } catch (\Exception $e) {
            $conn->rollBack();

            return $e->getMessage();
        }
    }

    /**
     * @param $exercicio
     * @param $folhaPagamento
     * @return bool|string
     */
    public function deleteRequisitosCargo($exercicio, $folhaPagamento)
    {
        $conn = $this->_em->getConnection();
        $conn->beginTransaction();
        try {
            $sqlEntidadeCargoServidor = "DELETE FROM {$folhaPagamento}.tcemg_entidade_requisitos_cargo WHERE exercicio = '{$exercicio}'";

            $conn->executeQuery($sqlEntidadeCargoServidor);

            $conn->commit();

            return true;
        } catch (\Exception $e) {
            $conn->rollBack();

            return $e->getMessage();
        }
    }
}
