<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class TcemgEntidadeRemuneracaoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $folhaPagamento
     * @return mixed
     */
    public function getRemuneracao($exercicio, $folhaPagamento)
    {
        $sql = <<<SQL
                SELECT 
	                tcemg_entidade_remuneracao.cod_tipo
	                ,tcemg_entidade_remuneracao.cod_evento
	                ,evento.codigo||' - '||evento.descricao as nom_evento
	            FROM {$folhaPagamento}.tcemg_entidade_remuneracao
	            INNER JOIN {$folhaPagamento}.evento
	                ON evento.cod_evento = tcemg_entidade_remuneracao.cod_evento
	                        
	             WHERE tcemg_entidade_remuneracao.exercicio = '{$exercicio}'
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codTipo
     * @param $folhaPagamento
     * @param $codEvento
     * @return string
     */
    public function save($exercicio, $folhaPagamento, $codTipo, $codEvento)
    {
        $conn = $this->_em->getConnection();
        $conn->beginTransaction();
        try {
            $sql = " INSERT INTO {$folhaPagamento}.tcemg_entidade_remuneracao (exercicio,cod_tipo,cod_evento) VALUES('{$exercicio}',{$codTipo},{$codEvento})";
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
    public function deleteRemuneracao($exercicio, $folhaPagamento)
    {
        $conn = $this->_em->getConnection();
        $conn->beginTransaction();
        try {
            $sql = "DELETE FROM {$folhaPagamento}.tcemg_entidade_remuneracao WHERE exercicio = '{$exercicio}'";

            $conn->executeQuery($sql);

            $conn->commit();

            return true;
        } catch (\Exception $e) {
            $conn->rollBack();

            return $e->getMessage();
        }
    }
}


