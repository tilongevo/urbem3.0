<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class PrevidenciaRepository extends AbstractRepository
{
    public function getNextPrevidenciaCode()
    {
        return $this->nextVal('cod_previdencia');
    }

    public function getPrevidencias()
    {
        $sql = <<<SQL
SELECT
    previdencia.*,
    previdencia_previdencia.*,
    CASE WHEN contrato_servidor_previdencia.cod_contrato IS NULL THEN
        ''
    ELSE
        'true'
    END AS booleano,
    CASE previdencia_previdencia.tipo_previdencia
    WHEN 'o' THEN
        'Oficial'
        WHEN 'p' THEN
        'Privada'
    END AS tipo_previdencia
FROM
    folhapagamento.previdencia_previdencia, (
        SELECT
            cod_previdencia,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            folhapagamento.previdencia_previdencia
        GROUP BY
            cod_previdencia) max_previdencia_previdencia,
        folhapagamento.previdencia
    LEFT JOIN (
        SELECT
            contrato_servidor_previdencia.cod_contrato,
            contrato_servidor_previdencia.cod_previdencia,
            contrato_servidor_previdencia.bo_excluido
        FROM
            pessoal.contrato_servidor_previdencia, (
                SELECT
                    cod_contrato,
                    max(TIMESTAMP) AS TIMESTAMP
                FROM
                    pessoal.contrato_servidor_previdencia
                GROUP BY
                    cod_contrato) max_contrato_servidor_previdencia
            WHERE
                contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato
                AND contrato_servidor_previdencia.timestamp = max_contrato_servidor_previdencia.timestamp
                AND contrato_servidor_previdencia.bo_excluido IS FALSE
                AND contrato_servidor_previdencia.cod_contrato IS NULL) AS contrato_servidor_previdencia ON previdencia.cod_previdencia = contrato_servidor_previdencia.cod_previdencia
        WHERE
            previdencia.cod_previdencia = previdencia_previdencia.cod_previdencia
            AND previdencia_previdencia.cod_previdencia = max_previdencia_previdencia.cod_previdencia
            AND previdencia_previdencia.timestamp = max_previdencia_previdencia.timestamp
        ORDER BY
            lower(previdencia_previdencia.descricao)
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param bool $filtro
     *
     * @return array
     */
    public function getPrevidenciaRat($filtro = false)
    {
        $sql = " 
SELECT previdencia_regime_rat.*                                                                 
     FROM folhapagamento.previdencia_regime_rat                                                    
        , (SELECT cod_previdencia                                                                  
                , max(timestamp) as timestamp                                                      
             FROM folhapagamento.previdencia_regime_rat                                            
           GROUP BY cod_previdencia) as max_previdencia_regime_rat                                 
        , folhapagamento.previdencia                                                               
    WHERE previdencia_regime_rat.cod_previdencia = max_previdencia_regime_rat.cod_previdencia      
      AND previdencia_regime_rat.timestamp = max_previdencia_regime_rat.timestamp                  
      AND previdencia_regime_rat.cod_previdencia = previdencia.cod_previdencia";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return array_shift($result);
    }

    /**
     * @param bool $filtro
     *
     * @return array
     */
    public function getPrevidenciaPrevidencia($filtro = false)
    {
        $sql = " 
SELECT cod_previdencia                                            
         , descricao                                                  
         , aliquota                                                   
         , TO_CHAR(timestamp,'yyyy-mm-dd hh24:mi:ss.us') AS timestamp 
         , tipo_previdencia                                           
         , vigencia AS vigencia_ordenacao                             
         , TO_CHAR(vigencia,'dd/mm/yyyy') AS vigencia                 
      FROM folhapagamento.previdencia_previdencia ";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return array_shift($result);
    }
}
