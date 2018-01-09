<?php

namespace Urbem\CoreBundle\Model\Divida;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Divida\DividaCgm;

/**
 * Class PagadoresReportModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class PagadoresReportModel extends AbstractModel
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
    public function getListaPagadoresCredito($filter)
    {
        list($cod_credito, $cod_especie, $cod_genero, $cod_natura) = explode(".", $filter['codigo']);

        $sql = "SELECT  divida.numcgm
	                    , divida.nom_cgm
	                    , inscricao as cod_inscricao
	                    , descricao        
	                    , codigo
	                    , ano_exercicio
	                    , SUM(parcela.vlr_parcela) as valor
	             FROM divida.parcela
	             INNER JOIN (
	                       SELECT 
	                              divida_parcelamento.num_parcelamento
	                              , sw_cgm.numcgm
	                              , sw_cgm.nom_cgm 
	                              , COALESCE( divida_imovel.inscricao_municipal, divida_empresa.inscricao_economica ) AS inscricao
	                              , origem.descricao                   
	                              , origem.ano_exercicio                   
	                              , origem.cod_grupo||'/'||origem.ano_exercicio as codigo
	                         FROM divida.divida_parcelamento
	               
	                   INNER JOIN divida.divida_ativa
	                           ON divida_ativa.cod_inscricao = divida_parcelamento.cod_inscricao
	                          AND divida_ativa.exercicio     = divida_parcelamento.exercicio
	                    LEFT JOIN divida.divida_imovel
	                           ON divida_imovel.cod_inscricao = divida_ativa.cod_inscricao
	                          AND divida_imovel.exercicio     = divida_ativa.exercicio        
	                    LEFT JOIN divida.divida_empresa
	                           ON divida_empresa.cod_inscricao = divida_ativa.cod_inscricao
	                          AND divida_empresa.exercicio = divida_ativa.exercicio
	                   INNER JOIN divida.parcelamento
	                           ON parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento
	                   INNER JOIN divida.parcela
	                           ON parcela.num_parcelamento = parcelamento.num_parcelamento
	                   INNER JOIN divida.divida_cgm
	                           ON divida_cgm.cod_inscricao  = divida_ativa.cod_inscricao
	                          AND divida_cgm.exercicio      = divida_ativa.exercicio
	                   INNER JOIN sw_cgm 
	                           ON sw_cgm.numcgm = divida_cgm.numcgm
	                   INNER JOIN divida.parcela_origem
	                           ON parcela_origem.num_parcelamento = parcelamento.num_parcelamento
	                   INNER JOIN ( SELECT    parcela.cod_parcela
	                                          , credito.descricao_credito AS descricao
	                                          , calculo_grupo_credito.ano_exercicio
	                                          , calculo_grupo_credito.cod_grupo
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
	                        ON origem.cod_parcela = parcela_origem.cod_parcela
	                        
	                        WHERE parcela.paga = TRUE
	                        
	                        GROUP BY divida_parcelamento.num_parcelamento
	                                 , sw_cgm.numcgm
	                                 , sw_cgm.nom_cgm          
	                                 , divida_imovel.inscricao_municipal
	                                 , divida_empresa.inscricao_economica                 
	                                 , origem.descricao      
	                                 , origem.ano_exercicio
	                                 , origem.cod_grupo   
	            ) AS divida
	               ON divida.num_parcelamento = parcela.num_parcelamento
	            
	            WHERE parcela.paga = TRUE
	            
	            GROUP BY divida.numcgm
	                     , divida.nom_cgm
	                     , descricao
	                     , inscricao
	                     , codigo
	                     , ano_exercicio
	            ORDER BY inscricao";

        $sql .= (is_numeric($filter['limite'])) ? " LIMIT {$filter['limite']};" : ";";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $filter
     * @return array
     */
    public function getListaPagadoresGrupoCredito($filter)
    {
        list($cod_grupo, $ano_exercicio) = explode("/", $filter['codigo']);

        $sql = "SELECT  divida.numcgm
	                    , divida.nom_cgm
	                    , inscricao as cod_inscricao
	                    , descricao        
	                    , codigo
	                    , ano_exercicio
	                    , SUM(parcela.vlr_parcela) as valor
	             FROM divida.parcela
	             INNER JOIN (
	                       SELECT 
	                              divida_parcelamento.num_parcelamento
	                              , sw_cgm.numcgm
	                              , sw_cgm.nom_cgm 
	                              , COALESCE( divida_imovel.inscricao_municipal, divida_empresa.inscricao_economica ) AS inscricao
	                              , origem.descricao                   
	                              , origem.ano_exercicio                   
	                              , origem.cod_grupo||'/'||origem.ano_exercicio as codigo
	                         FROM divida.divida_parcelamento
	               
	                   INNER JOIN divida.divida_ativa
	                           ON divida_ativa.cod_inscricao = divida_parcelamento.cod_inscricao
	                          AND divida_ativa.exercicio     = divida_parcelamento.exercicio
	                    LEFT JOIN divida.divida_imovel
	                           ON divida_imovel.cod_inscricao = divida_ativa.cod_inscricao
	                          AND divida_imovel.exercicio     = divida_ativa.exercicio        
	                    LEFT JOIN divida.divida_empresa
	                           ON divida_empresa.cod_inscricao = divida_ativa.cod_inscricao
	                          AND divida_empresa.exercicio = divida_ativa.exercicio
	                   INNER JOIN divida.parcelamento
	                           ON parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento
	                   INNER JOIN divida.parcela
	                           ON parcela.num_parcelamento = parcelamento.num_parcelamento
	                   INNER JOIN divida.divida_cgm
	                           ON divida_cgm.cod_inscricao  = divida_ativa.cod_inscricao
	                          AND divida_cgm.exercicio      = divida_ativa.exercicio
	                   INNER JOIN sw_cgm 
	                           ON sw_cgm.numcgm = divida_cgm.numcgm
	                   INNER JOIN divida.parcela_origem
	                           ON parcela_origem.num_parcelamento = parcelamento.num_parcelamento
	                   INNER JOIN ( SELECT  parcela.cod_parcela
	                                        , grupo_credito.descricao
	                                        , grupo_credito.ano_exercicio
	                                        , grupo_credito.cod_grupo
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
	                                             ,grupo_credito.descricao
	                                             ,grupo_credito.ano_exercicio
	                                             ,grupo_credito.cod_grupo
	                        ) AS origem
	                        ON origem.cod_parcela = parcela_origem.cod_parcela
	                        
	                        WHERE parcela.paga = TRUE
	                        
	                        GROUP BY divida_parcelamento.num_parcelamento
	                                 , sw_cgm.numcgm
	                                 , sw_cgm.nom_cgm          
	                                 , divida_imovel.inscricao_municipal
	                                 , divida_empresa.inscricao_economica                 
	                                 , origem.descricao      
	                                 , origem.ano_exercicio
	                                 , origem.cod_grupo   
	            ) AS divida
	               ON divida.num_parcelamento = parcela.num_parcelamento
	            
	            WHERE parcela.paga = TRUE
	            
	            GROUP BY divida.numcgm
	                     , divida.nom_cgm
	                     , descricao
	                     , inscricao
	                     , codigo
	                     , ano_exercicio
	            ORDER BY inscricao";

        $sql .= (is_numeric($filter['limite'])) ? " LIMIT {$filter['limite']};" : ";";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
