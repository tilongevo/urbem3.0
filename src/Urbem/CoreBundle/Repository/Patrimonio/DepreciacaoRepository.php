<?php

namespace Urbem\CoreBundle\Repository\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem;

class DepreciacaoRepository extends ORM\EntityRepository
{

    public function getDepreciacao($exercicio, $competencia)
    {
        $sql = "
            SELECT
                  depreciacao.cod_depreciacao
                , depreciacao.cod_bem
                , depreciacao.timestamp
                , depreciacao.vl_depreciado
                , depreciacao.dt_depreciacao
                , depreciacao.competencia
                , depreciacao.motivo
                , depreciacao.acelerada
                , depreciacao.quota_utilizada
                , CASE WHEN bem_plano_depreciacao.exercicio IS NOT NULL
                       THEN bem_plano_depreciacao.exercicio
                       ELSE grupo_plano_depreciacao.exercicio
                  END AS exercicio
                , CASE WHEN bem_plano_depreciacao.cod_plano IS NOT NULL
                       THEN bem_plano_depreciacao.cod_plano
                       ELSE grupo_plano_depreciacao.cod_plano
                  END AS cod_plano
                , (SELECT valor
                     FROM administracao.configuracao
                    WHERE exercicio  = :exercicio
                      AND cod_modulo = 6
                      AND parametro  = 'competencia_depreciacao'
                   ) AS tipoCompetencia
                   
             FROM patrimonio.depreciacao          
        
        LEFT JOIN (
                    SELECT bem_plano_depreciacao.cod_bem
                         , bem_plano_depreciacao.cod_plano 
                         , bem_plano_depreciacao.exercicio
                         , MAX(bem_plano_depreciacao.timestamp::timestamp) AS timestamp
			 , plano_conta.cod_estrutural
                         , plano_conta.nom_conta AS nom_conta_depreciacao
                         
                      FROM patrimonio.bem_plano_depreciacao 

                 LEFT JOIN contabilidade.plano_analitica
                        ON plano_analitica.cod_plano = bem_plano_depreciacao.cod_plano
                       AND plano_analitica.exercicio = bem_plano_depreciacao.exercicio

                 LEFT JOIN contabilidade.plano_conta
                        ON plano_conta.cod_conta = plano_analitica.cod_conta
                       AND plano_conta.exercicio = plano_analitica.exercicio
                         
                     WHERE bem_plano_depreciacao.timestamp::timestamp = ( SELECT MAX(bem_plano.timestamp::timestamp) AS timestamp 
									    FROM patrimonio.bem_plano_depreciacao AS bem_plano
									   
                                                                           WHERE bem_plano_depreciacao.cod_bem   = bem_plano.cod_bem
									     AND bem_plano_depreciacao.exercicio = bem_plano.exercicio
							        
                                                                        GROUP BY bem_plano.cod_bem
                                                                               , bem_plano.exercicio )
                  GROUP BY bem_plano_depreciacao.cod_bem
                         , bem_plano_depreciacao.cod_plano
                         , bem_plano_depreciacao.exercicio
                         , plano_conta.cod_estrutural
                         , plano_conta.nom_conta 
                  
                  ORDER BY timestamp DESC
                  
                )AS bem_plano_depreciacao
                 ON bem_plano_depreciacao.cod_bem = depreciacao.cod_bem
        
         LEFT JOIN ( SELECT cod_plano
	                  , cod_bem
                          , exercicio
	             
		     FROM patrimonio.grupo_plano_depreciacao
        
               INNER JOIN patrimonio.grupo
                       ON grupo.cod_natureza = grupo_plano_depreciacao.cod_natureza
                      AND grupo.cod_grupo    = grupo_plano_depreciacao.cod_grupo
               
               INNER JOIN patrimonio.especie
                       ON especie.cod_grupo    = grupo.cod_grupo
                      AND especie.cod_natureza = grupo.cod_natureza
               
               INNER JOIN patrimonio.bem
                       ON bem.cod_especie  = especie.cod_especie
                      AND bem.cod_grupo    = especie.cod_grupo
                      AND bem.cod_natureza = especie.cod_natureza
                      
                 ) AS grupo_plano_depreciacao
                   ON grupo_plano_depreciacao.cod_bem = depreciacao.cod_bem

            WHERE 1 = 1
              AND NOT EXISTS ( SELECT 1 
                                 FROM patrimonio.depreciacao_anulada
                                WHERE depreciacao_anulada.cod_depreciacao = depreciacao.cod_depreciacao
                                  AND depreciacao_anulada.cod_bem         = depreciacao.cod_bem
                                  AND depreciacao_anulada.timestamp       = depreciacao.timestamp
                             ) 
              AND depreciacao.competencia = :competencia";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("competencia", $competencia, \PDO::PARAM_STR);
        $query->bindValue("exercicio", $exercicio, \PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getReavaliacao($exercicio, $competencia, $motivo = 'Depreciação Automática')
    {
        $sql = "SELECT * FROM patrimonio.fn_reavaliacao_depreciacao_automatica(
:exercicio, :competencia, null, null, null, :motivo);";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("exercicio", $exercicio, \PDO::PARAM_STR);
        $query->bindValue("competencia", $competencia, \PDO::PARAM_STR);
        $query->bindValue("motivo", $motivo, \PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function executaDepreciacao($exercicio, $competencia, $motivo = 'Depreciação Automática')
    {
        $sql = "SELECT * FROM patrimonio.fn_depreciacao_automatica(
:exercicio, :competencia, null, null, null, :motivo);";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("exercicio", $exercicio, \PDO::PARAM_STR);
        $query->bindValue("competencia", $competencia, \PDO::PARAM_STR);
        $query->bindValue("motivo", $motivo, \PDO::PARAM_STR);
        try {
            $query->execute();
        } catch (\Exception $e) {
            throw new \Exception($query->errorInfo()[2]);
        }

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function executaDepreciacaoAnulada($competencia, $motivo = 'Depreciação Automática')
    {
        $sql = "SELECT patrimonio.fn_depreciacao_anulacao(:competencia, :motivo) AS valor;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("competencia", $competencia, \PDO::PARAM_STR);
        $query->bindValue("motivo", $motivo, \PDO::PARAM_STR);
        $query->execute();
        try {
            $query->execute();
        } catch (\Exception $e) {
            throw new \Exception($query->errorInfo()[2]);
        }

        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
