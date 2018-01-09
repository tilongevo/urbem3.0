<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;

/**
 * Class CargoSubDivisaoRepository
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class CargoSubDivisaoRepository extends ORM\EntityRepository
{
    /**
     * @param $info
     * @param $codCargo
     * @return array
     */
    public function getCargoSubDivisaoPorTimestamp($info, $codCargo)
    {
        $sql = "
        SELECT
            cargo_sub_divisao.cod_cargo,
            cargo_sub_divisao.cod_sub_divisao,
            cargo_sub_divisao.nro_vaga_criada,
            sub_divisao.cod_regime
        FROM
            pessoal.cargo_sub_divisao
        INNER JOIN
            pessoal.sub_divisao on sub_divisao.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao
        WHERE
            cod_cargo = ". $codCargo ."
        AND
            date_trunc('second', \"timestamp\") = '". $info->format('Y-m-d H:i:s') ."'
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param integer $inCodRegime
     * @param integer $inCodSubDivisao
     * @param integer $inCodCargo
     * @param integer $inCodPeriodoMovimentacao
     * @param boolean $boLiberaVagaMesRescisao
     * @param string $stEntidade
     * @return integer
     */
    public function getVagasOcupadasCargo(
        $inCodRegime,
        $inCodSubDivisao,
        $inCodCargo,
        $inCodPeriodoMovimentacao = 0,
        $boLiberaVagaMesRescisao = true,
        $stEntidade = ''
    ) {
        $sql = <<<SQL
SELECT
    getVagasOcupadasCargo (:inCodRegime,
        :inCodSubDivisao,
        :inCodCargo,
        :inCodPeriodoMovimentacao,
        :boLiberaVagaMesRescisao,
        :stEntidade) AS vagas
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('inCodRegime', $inCodRegime);
        $query->bindValue('inCodSubDivisao', $inCodSubDivisao);
        $query->bindValue('inCodCargo', $inCodCargo);
        $query->bindValue('inCodPeriodoMovimentacao', $inCodPeriodoMovimentacao);
        $query->bindValue('boLiberaVagaMesRescisao', $boLiberaVagaMesRescisao);
        $query->bindValue('stEntidade', $stEntidade);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->vagas;
    }
    
    /**
     * @param array $arrSubDivisoes
     * @param int $anoCompetencia
     * @return array
     */
    public function getCargosPorSubDivisaoPerioro(Array $arrSubDivisoes, $anoCompetencia)
    {
        array_walk($arrSubDivisoes, 'intval');
        $codSubDivisoes = implode(", ", $arrSubDivisoes);
        $dtMin = "01/01/".$anoCompetencia;
        $dtMax = "31/12/".$anoCompetencia;
        
        $sql = "
        SELECT
            cod_cargo,
	        descricao,
	        cargo_cc,
	        funcao_gratificada,
	        cod_escolaridade,
	        atribuicoes,
	        dt_termino
	    FROM (
            SELECT
                cargo.*,
        	    cargo_sub_divisao.cod_sub_divisao,
        	    norma.dt_publicacao,
        	    norma_data_termino.dt_termino
	        FROM
                pessoal.cargo
	        JOIN
                pessoal.cargo_sub_divisao
	           ON cargo_sub_divisao.cod_cargo = cargo.cod_cargo
	        JOIN (
                SELECT
                    cod_cargo,
    	            cod_sub_divisao,
    	            max(timestamp) as timestamp
	            FROM
                    pessoal.cargo_sub_divisao
	            GROUP BY
                    cod_cargo, cod_sub_divisao
            ) AS max_cargo_sub_divisao
	        ON max_cargo_sub_divisao.cod_cargo       = cargo_sub_divisao.cod_cargo
	        AND max_cargo_sub_divisao.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao
	        AND max_cargo_sub_divisao.timestamp       = cargo_sub_divisao.timestamp
	        JOIN
                normas.norma
	            ON norma.cod_norma = cargo_sub_divisao.cod_norma
	        LEFT JOIN
                normas.norma_data_termino
	            ON norma_data_termino.cod_norma = norma.cod_norma
	        UNION
	        SELECT
                cargo.*,
	            especialidade_sub_divisao.cod_sub_divisao,
	            norma.dt_publicacao,
	            norma_data_termino.dt_termino
	        FROM
                pessoal.cargo
	        JOIN
                pessoal.especialidade
	            ON especialidade.cod_cargo = cargo.cod_cargo
	        JOIN pessoal.especialidade_sub_divisao
	            ON especialidade_sub_divisao.cod_especialidade = especialidade.cod_especialidade
	        JOIN (
                SELECT
                    cod_especialidade,
	                cod_sub_divisao,
	                max(timestamp) as timestamp
	            FROM
                    pessoal.especialidade_sub_divisao
	            GROUP BY
                    cod_especialidade, cod_sub_divisao) AS max_especialidade_sub_divisao
	                ON max_especialidade_sub_divisao.cod_especialidade = especialidade_sub_divisao.cod_especialidade
	                AND max_especialidade_sub_divisao.cod_sub_divisao   = especialidade_sub_divisao.cod_sub_divisao 
	                AND max_especialidade_sub_divisao.timestamp         = especialidade_sub_divisao.timestamp
	            JOIN normas.norma
	                ON norma.cod_norma = especialidade_sub_divisao.cod_norma
	            LEFT JOIN normas.norma_data_termino
	                ON norma_data_termino.cod_norma = norma.cod_norma
	        ) AS tabela
	        WHERE true
	        AND ( dt_publicacao <= to_date('".$dtMax."', 'dd/mm/yyyy')
	        AND (
                dt_termino IS NULL
	            OR dt_termino >= to_date('".$dtMin."', 'dd/mm/yyyy'
                )
            )
	    )
        AND cod_sub_divisao IN (".$codSubDivisoes.")
        GROUP BY
            cod_cargo,
            descricao,
            cargo_cc,
            funcao_gratificada,
            cod_escolaridade,
            atribuicoes,
            dt_termino
        ORDER BY descricao
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}
