<?php

namespace Urbem\CoreBundle\Model\Divida;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Divida\DividaCgm;

/**
 * Class DevedoresReportModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class DevedoresReportModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * DevedoresReportModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(DividaCgm::class);
    }

    /**
     * @param $filter
     * @return array
     */
    public function getListaDevedoresCredito($filter)
    {
        list($cod_credito, $cod_especie, $cod_genero, $cod_natura) = explode(".", $filter['codigo']);

        $sql = "SELECT final.*
	                FROM (
	                    SELECT cgm.numcgm 
	                         , cgm.nom_cgm
	                         , divida_ativa.cod_inscricao
	                         , divida_ativa.inscricao
	                         , divida_ativa.descricao
	                         , '{$filter['codigo']}' AS codigo
	                         , divida_ativa.ano_exercicio
	                         , SUM(valor) AS valor
	                                
	                    FROM sw_cgm AS cgm
	                    
	              INNER JOIN ( SELECT divida_ativa.cod_inscricao
	                                , divida_ativa.exercicio
	                                , divida_cgm.numcgm
	                                , divida_parcelamento_minimo.num_parcelamento AS MINparc
	                                , divida_parcelamento_maximo.num_parcelamento AS MAXparc
	                                , SUM(divida_parcela_origem.valor)            AS valor
	                                , origem.descricao	
	                                , origem.ano_exercicio
	                                , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica ) AS inscricao
	                             FROM divida.divida_ativa
	                               
	                       INNER JOIN divida.divida_cgm
	                               ON divida_cgm.cod_inscricao  = divida_ativa.cod_inscricao
	                              AND divida_cgm.exercicio      = divida_ativa.exercicio
	                                  
	                       INNER JOIN ( SELECT cod_inscricao
	                                         , exercicio
	                                         , MIN(num_parcelamento) AS num_parcelamento
	                                      FROM divida.divida_parcelamento
	                                  GROUP BY cod_inscricao
	                                         , exercicio
	                                   ) AS divida_parcelamento_minimo
	                                ON divida_parcelamento_minimo.cod_inscricao = divida_ativa.cod_inscricao
	                               AND divida_parcelamento_minimo.exercicio     = divida_ativa.exercicio
	     
	                        INNER JOIN ( SELECT num_parcelamento
	                                          , cod_parcela
	                                          , valor
	                                       FROM divida.parcela_origem
	                                   ) AS divida_parcela_origem
	                                ON divida_parcela_origem.num_parcelamento = divida_parcelamento_minimo.num_parcelamento
	     
	                        INNER JOIN ( SELECT cod_inscricao
	                                          , exercicio
	                                          , MAX(num_parcelamento) AS num_parcelamento
	                                       FROM divida.divida_parcelamento
	                                   GROUP BY cod_inscricao
	                                          , exercicio
	                                      ) AS divida_parcelamento_maximo
	                                ON divida_parcelamento_maximo.cod_inscricao = divida_ativa.cod_inscricao
	                               AND divida_parcelamento_maximo.exercicio     = divida_ativa.exercicio
	                               
	                        LEFT JOIN divida.divida_imovel AS ddi
	                               ON ddi.cod_inscricao = divida_ativa.cod_inscricao
	                              AND ddi.exercicio = divida_ativa.exercicio
	
	                          LEFT JOIN divida.divida_empresa AS dde
	                                 ON dde.cod_inscricao = divida_ativa.cod_inscricao
	                                AND dde.exercicio = divida_ativa.exercicio         
	                        
	                        INNER JOIN ( SELECT parcela.cod_parcela
	                                          , credito.descricao_credito AS descricao
	                                          , '{$filter['exercicio']}'::VARCHAR AS ano_exercicio
	                                       FROM arrecadacao.parcela
	                                       
	                                 INNER JOIN arrecadacao.lancamento_calculo
	                                         ON lancamento_calculo.cod_lancamento = parcela.cod_lancamento
	                                
	                                 INNER JOIN arrecadacao.calculo_grupo_credito
	                                         ON calculo_grupo_credito.cod_calculo   = lancamento_calculo.cod_calculo
	     
	                                 INNER JOIN arrecadacao.calculo 
	                                         ON calculo.cod_calculo  = lancamento_calculo.cod_calculo
	                       
	                                 INNER JOIN monetario.credito
	                                         ON credito.cod_credito  = calculo.cod_credito  
	                                        AND credito.cod_especie  = calculo.cod_especie  
	                                        AND credito.cod_genero   = calculo.cod_genero   
	                                        AND credito.cod_natureza = calculo.cod_natureza 
	                       
	                                      WHERE calculo.cod_credito  = ".$cod_credito."
	                                        AND calculo.cod_especie  = ".$cod_especie."
	                                        AND calculo.cod_genero   = ".$cod_genero."
	                                        AND calculo.cod_natureza = ".$cod_natura."
	                                        AND calculo.exercicio    = '{$filter['exercicio']}'
	     
	                                    ) AS origem
	                                ON origem.cod_parcela = divida_parcela_origem.cod_parcela
	                             WHERE 1 = 1
	                             
	                               AND NOT EXISTS ( SELECT 1
	                                                  FROM divida.parcela
	                                                 WHERE divida_parcelamento_maximo.num_parcelamento = parcela.num_parcelamento
	                                                   AND paga = TRUE
	                                               )
	                                               
	                         GROUP BY divida_ativa.cod_inscricao
	                                , divida_ativa.exercicio
	                                , divida_cgm.numcgm
	                                , divida_parcelamento_minimo.num_parcelamento
	                                , divida_parcelamento_maximo.num_parcelamento
	                                , origem.descricao
	                                , origem.ano_exercicio
	                                , inscricao
	                      ) AS divida_ativa
	                      ON divida_ativa.numcgm = cgm.numcgm
	                       
	                   WHERE 1 = 1
	                     AND NOT EXISTS ( SELECT 1
	                                        FROM divida.divida_cancelada
	                                       WHERE cod_inscricao = divida_ativa.cod_inscricao
	                                         AND exercicio     = divida_ativa.exercicio )
	                                         
	                     AND NOT EXISTS ( SELECT 1
	                                        FROM divida.divida_estorno
	                                       WHERE cod_inscricao = divida_ativa.cod_inscricao
	                                         AND exercicio     = divida_ativa.exercicio )
	                                           
	                     AND NOT EXISTS ( SELECT 1
	                                        FROM divida.divida_remissao
	                                       WHERE cod_inscricao = divida_ativa.cod_inscricao
	                                         AND exercicio     = divida_ativa.exercicio
	                                    )   
	                                                
	                         GROUP BY cgm.numcgm
	                                , cgm.nom_cgm
	                                , divida_ativa.cod_inscricao
	                                , divida_ativa.descricao
	                                , codigo
	                                , divida_ativa.ano_exercicio
	                                , divida_ativa.inscricao
	                     ) AS final
	                     
	            ORDER BY final.inscricao desc";

        $sql .= (is_numeric($filter['limite'])) ? " LIMIT {$filter['limite']};" : ";";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $filter
     * @return array
     */
    public function getListaDevedoresGrupoCredito($filter)
    {
        list($cod_grupo, $ano_exercicio) = explode("/", $filter['codigo']);

        $sql = "SELECT final.*
	                FROM (
                        SELECT cgm.numcgm
	                         , cgm.nom_cgm
	                         , divida_ativa.inscricao as cod_inscricao
	                         , divida_ativa.descricao
	                         , '{$filter['codigo']}' AS codigo
	                         , divida_ativa.ano_exercicio
	                         , SUM(valor) AS valor

	                      FROM sw_cgm AS cgm
	                INNER JOIN ( SELECT divida_ativa.cod_inscricao
	                                  , divida_ativa.exercicio
	                                  , divida_cgm.numcgm
	                                  , divida_parcelamento_minimo.num_parcelamento AS MINparc
	                                  , divida_parcelamento_maximo.num_parcelamento AS MAXparc
	                                  , SUM(divida_parcela_origem.valor)            AS valor
	                                  , origem.descricao
	                                  , origem.ano_exercicio
	                                  , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica ) AS inscricao
	                               FROM divida.divida_ativa

	                         INNER JOIN divida.divida_cgm
	                                 ON divida_cgm.cod_inscricao  = divida_ativa.cod_inscricao
    AND divida_cgm.exercicio      = divida_ativa.exercicio

	                         INNER JOIN ( SELECT cod_inscricao
	                                           , exercicio
	                                           , MIN(num_parcelamento) AS num_parcelamento
	                                        FROM divida.divida_parcelamento
	                                    GROUP BY cod_inscricao
	                                           , exercicio
	                                     ) AS divida_parcelamento_minimo
	                                  ON divida_parcelamento_minimo.cod_inscricao = divida_ativa.cod_inscricao
    AND divida_parcelamento_minimo.exercicio     = divida_ativa.exercicio

	                          INNER JOIN ( SELECT num_parcelamento
	                                            , cod_parcela
	                                            , valor
	                                         FROM divida.parcela_origem
	                                     ) AS divida_parcela_origem
	                                  ON divida_parcela_origem.num_parcelamento = divida_parcelamento_minimo.num_parcelamento

	                          INNER JOIN ( SELECT cod_inscricao
	                                            , exercicio
	                                            , MAX(num_parcelamento) AS num_parcelamento
	                                         FROM divida.divida_parcelamento
	                                     GROUP BY cod_inscricao
	                                            , exercicio
	                                        ) AS divida_parcelamento_maximo
	                                  ON divida_parcelamento_maximo.cod_inscricao = divida_ativa.cod_inscricao
    AND divida_parcelamento_maximo.exercicio     = divida_ativa.exercicio

	                           LEFT JOIN divida.divida_imovel AS ddi
	                                  ON ddi.cod_inscricao = divida_ativa.cod_inscricao
    AND ddi.exercicio = divida_ativa.exercicio

	                           LEFT JOIN divida.divida_empresa AS dde
	                                  ON dde.cod_inscricao = divida_ativa.cod_inscricao
    AND dde.exercicio = divida_ativa.exercicio

	                          INNER JOIN ( SELECT parcela.cod_parcela
	                                            , grupo_credito.descricao
	                                            , grupo_credito.ano_exercicio
	                                         FROM arrecadacao.parcela

	                                   INNER JOIN arrecadacao.lancamento_calculo
	                                           ON lancamento_calculo.cod_lancamento = parcela.cod_lancamento

	                                   INNER JOIN arrecadacao.calculo_grupo_credito
	                                           ON calculo_grupo_credito.cod_calculo   = lancamento_calculo.cod_calculo

	                                   INNER JOIN arrecadacao.grupo_credito
	                                           ON grupo_credito.cod_grupo     = calculo_grupo_credito.cod_grupo
    AND grupo_credito.ano_exercicio = calculo_grupo_credito.ano_exercicio

	                                        WHERE calculo_grupo_credito.cod_grupo     = ".$cod_grupo."
    AND calculo_grupo_credito.ano_exercicio = '".$ano_exercicio."'


	                                     GROUP BY parcela.cod_parcela
	                                            , grupo_credito.descricao
	                                            , grupo_credito.ano_exercicio

	                                     ) AS origem
	                                  ON origem.cod_parcela = divida_parcela_origem.cod_parcela
	                               WHERE 1 = 1

    AND NOT EXISTS ( SELECT 1
	                                                    FROM divida.parcela
	                                                   WHERE divida_parcelamento_maximo.num_parcelamento = parcela.num_parcelamento
    AND paga = TRUE
	                                                )

	                           GROUP BY divida_ativa.cod_inscricao
	                                  , divida_ativa.exercicio
	                                  , divida_cgm.numcgm
	                                  , divida_parcelamento_minimo.num_parcelamento
	                                  , divida_parcelamento_maximo.num_parcelamento
	                                  , origem.descricao
	                                  , origem.ano_exercicio
	                                  , inscricao
	                        ) AS divida_ativa
	                      ON divida_ativa.numcgm = cgm.numcgm

	                     WHERE 1 = 1
    AND NOT EXISTS ( SELECT 1
	                                          FROM divida.divida_cancelada
	                                         WHERE cod_inscricao = divida_ativa.cod_inscricao
    AND exercicio     = divida_ativa.exercicio )

	                       AND NOT EXISTS ( SELECT 1
	                                          FROM divida.divida_estorno
	                                         WHERE cod_inscricao = divida_ativa.cod_inscricao
    AND exercicio     = divida_ativa.exercicio )

	                       AND NOT EXISTS ( SELECT 1
	                                          FROM divida.divida_remissao
	                                         WHERE cod_inscricao = divida_ativa.cod_inscricao
    AND exercicio     = divida_ativa.exercicio
	                                      )

	                  GROUP BY cgm.numcgm
	                         , cgm.nom_cgm
	                         , divida_ativa.descricao
	                         , codigo
	                         , divida_ativa.ano_exercicio
	                         , divida_ativa.inscricao
	              ) AS final ORDER BY final.cod_inscricao";

        $sql .= (is_numeric($filter['limite'])) ? " LIMIT {$filter['limite']};" : ";";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
