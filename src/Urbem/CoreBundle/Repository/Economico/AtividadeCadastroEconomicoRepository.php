<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Doctrine\ORM\EntityRepository;

/**
 * Class AtividadeCadastroEconomicoRepository
 * @package Urbem\CoreBundle\Repository\Economico
 */
class AtividadeCadastroEconomicoRepository extends EntityRepository
{
    /**
     * @param $params
     * @return array
     */
    public function getAtividadeCadastroEconomicoReport($params)
    {
        $sql = sprintf(
            "SELECT
                ace.inscricao_economica,
                A.cod_atividade,
                A.cod_estrutural,
                A.nom_atividade,
                A.cod_nivel,
                ace.ocorrencia_atividade,
                economico.fn_busca_modalidade_atividade(
                    ace.inscricao_economica,
                    A.cod_atividade,
                    ace.ocorrencia_atividade
                ) AS modalidade,
                SA.cod_servico,
                S.cod_estrutural AS cod_estrutural_servico,
                S.nom_servico,
                TO_CHAR(
                    V.dt_inicio,
                    'DD/MM/YYYY'
                ) AS dt_inicio,
                AL.valor AS aliquota_atividade,
                ALS.valor AS aliquota_servico,
                elic.cod_licenca,
                elic.exercicio,
                economico.fn_consulta_situacao_licenca(
                    elic.cod_licenca,
                    elic.exercicio
                ) AS situacao
            FROM
                economico.atividade_cadastro_economico ace INNER JOIN(
                    SELECT
                        COALESCE (
                            licenca_atividade.cod_licenca,
                            licenca_especial.cod_licenca
                        ) AS cod_licenca,
                        COALESCE (
                            licenca_atividade.exercicio,
                            licenca_especial.exercicio
                        ) AS exercicio,
                        atividade_cadastro_economico.cod_atividade,
                        atividade_cadastro_economico.ocorrencia_atividade,
                        atividade_cadastro_economico.inscricao_economica
                    FROM
                        economico.atividade_cadastro_economico LEFT JOIN economico.licenca_atividade ON
                        licenca_atividade.cod_atividade = atividade_cadastro_economico.cod_atividade
                        AND licenca_atividade.ocorrencia_atividade = atividade_cadastro_economico.ocorrencia_atividade
                        AND licenca_atividade.inscricao_economica = atividade_cadastro_economico.inscricao_economica LEFT JOIN economico.licenca_especial ON
                        licenca_especial.cod_atividade = atividade_cadastro_economico.cod_atividade
                        AND licenca_especial.ocorrencia_atividade = atividade_cadastro_economico.ocorrencia_atividade
                        AND licenca_especial.inscricao_economica = atividade_cadastro_economico.inscricao_economica
                ) AS elic ON
                elic.cod_atividade = ace.cod_atividade
                AND elic.ocorrencia_atividade = ace.ocorrencia_atividade
                AND elic.inscricao_economica = ace.inscricao_economica INNER JOIN(
                    SELECT
                        tmp1.*
                    FROM
                        economico.atividade AS tmp1 INNER JOIN(
                            SELECT
                                max( timestamp ) AS timestamp,
                                cod_atividade,
                                cod_vigencia
                            FROM
                                economico.atividade
                            GROUP BY
                                cod_atividade,
                                cod_vigencia
                        ) AS tmp2 ON
                        tmp1.cod_atividade = tmp2.cod_atividade
                        AND tmp1.cod_vigencia = tmp2.cod_vigencia
                        AND tmp1.timestamp = tmp2.timestamp
                    WHERE
                        tmp1.cod_vigencia =(
                            SELECT
                                cod_vigencia
                            FROM
                                economico.vigencia_atividade
                            WHERE
                                dt_inicio <= now()::date
                            ORDER BY
                                timestamp desc limit 1
                        )
                ) AS A ON
                A.cod_atividade = ace.cod_atividade INNER JOIN economico.vigencia_atividade AS V ON
                V.cod_vigencia = A.cod_vigencia LEFT JOIN economico.aliquota_atividade AL ON
                AL.cod_atividade = A.cod_atividade LEFT JOIN economico.servico_atividade SA ON
                A.cod_atividade = SA.cod_atividade LEFT JOIN economico.servico S ON
                SA.cod_servico = S.cod_servico LEFT JOIN economico.aliquota_servico ALS ON
                ALS.cod_servico = SA.cod_servico LEFT JOIN(
                    SELECT
                        cod_atividade,
                        max( timestamp ) AS timestamp
                    FROM
                        economico.aliquota_atividade
                    GROUP BY
                        cod_atividade
                ) AS MAL ON
                MAL.cod_atividade = AL.cod_atividade
                AND MAL.timestamp = AL.timestamp
            WHERE
                ace.inscricao_economica = %d
            ORDER BY
                A.cod_atividade",
            $params['inscricao_economica']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $inscricaoEconomica
     * @return array
     */
    public function getAtividadeBySwcgmAction($inscricaoEconomica)
    {
        $sql = "SELECT                                                                  
	         c.cod_atividade,                                                    
	         c.cod_estrutural,                                                   
	         c.nom_atividade,                                                    
	         b.inscricao_economica,                                              
	         b.principal                                                         
	     FROM                                                                    
	         economico.cadastro_economico a                                      
	         INNER JOIN economico.atividade_cadastro_economico b                 
	         ON a.inscricao_economica = b.inscricao_economica                    
	         INNER JOIN (                                                        
	             select                                                          
	                 ace.inscricao_economica                                     
	                 , max( ace.ocorrencia_atividade) as ocorrencia_atividade    
	             FROM                                                            
	                 economico.atividade_cadastro_economico as ace               
	             GROUP BY                                                        
	                 ace.inscricao_economica                                     
	         ) AS max                                                            
	         ON max.ocorrencia_atividade = b.ocorrencia_atividade                
	         AND max.inscricao_economica = b.inscricao_economica                 
	         INNER JOIN economico.atividade c                                    
	         ON c.cod_atividade = b.cod_atividade                                
	 WHERE  b.inscricao_economica = :inscricao_economica  ORDER BY c.cod_estrutural;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':inscricao_economica', $inscricaoEconomica, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
