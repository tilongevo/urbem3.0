<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class TcemgEntidadeCargoServidorRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $folhaPagamento
     * @param $pessoal
     * @return mixed
     */
    public function getTipoCargoServidor($exercicio, $folhaPagamento, $pessoal)
    {
        $sql = <<<SQL
SELECT DISTINCT 
	                tcemg_entidade_cargo_servidor.cod_tipo
	                ,regime.cod_regime
	                ,sub_divisao.cod_sub_divisao
	                ,tcemg_entidade_cargo_servidor.cod_cargo
	                ,sub_divisao.descricao as nom_sub_divisao
	                ,regime.descricao as nom_regime        
	                ,tcemg_entidade_cargo_servidor.cod_cargo||' - '||cargo.descricao as nom_cargo
	            FROM {$folhaPagamento}.tcemg_entidade_cargo_servidor
	            INNER JOIN {$pessoal}.sub_divisao
	                ON sub_divisao.cod_sub_divisao = tcemg_entidade_cargo_servidor.cod_sub_divisao 
	            INNER JOIN {$pessoal}.regime
	                ON regime.cod_regime = sub_divisao.cod_regime
	            INNER JOIN {$pessoal}.cargo
	                ON cargo.cod_cargo = tcemg_entidade_cargo_servidor.cod_cargo
	            
	             WHERE tcemg_entidade_cargo_servidor.exercicio = '{$exercicio}' 
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codTipo
     * @param $folhaPagamento
     * @return string
     */
    public function saveTipoCargoServidor($exercicio, $folhaPagamento, $codTipo, $codSubDivisao, $codCargo)
    {
        $conn = $this->_em->getConnection();
        $conn->beginTransaction();
        try {
            $sql = " INSERT INTO {$folhaPagamento}.tcemg_entidade_cargo_servidor (exercicio,cod_tipo,cod_sub_divisao,cod_cargo) VALUES('{$exercicio}',{$codTipo},{$codSubDivisao},{$codCargo})";
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
    public function deleteEntidadeCargoServidor($exercicio, $folhaPagamento)
    {
        $conn = $this->_em->getConnection();
        $conn->beginTransaction();
        try {
            $sqlEntidadeCargoServidor = "DELETE FROM {$folhaPagamento}.tcemg_entidade_cargo_servidor WHERE exercicio = '{$exercicio}'";

            $conn->executeQuery($sqlEntidadeCargoServidor);

            $conn->commit();

            return true;
        } catch (\Exception $e) {
            $conn->rollBack();

            return $e->getMessage();
        }
    }
}


