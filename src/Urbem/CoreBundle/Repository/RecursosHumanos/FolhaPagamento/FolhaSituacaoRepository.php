<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class FolhaSituacaoRepository extends ORM\EntityRepository
{
    public function getFolhaSituacaoByMaxTimestapAndCodPeriodoMovimentacao($cod_periodo_movimentacao)
    {
        $query = $this->_em->getConnection()->prepare(
            "
            SELECT * FROM folhapagamento.folha_situacao WHERE cod_periodo_movimentacao = " . $cod_periodo_movimentacao . "
            ORDER BY TIMESTAMP DESC;
            "
        );

        $query->execute();
        $queryResult = $query->fetchAll();
        $result = array_shift($queryResult);
        return $result;
    }

    /**
     * @param $codPeriodoMovimentacao
     * @return mixed
     */
    public function montaRecuperaRelacionamento($codPeriodoMovimentacao, $situacao)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT folha_situacao.*                                                  
            , max_folha_situacao.count                                          
            , max_folha_situacao_fechada.timestamp as timestamp_fechado         
         FROM folhapagamento.folha_situacao                                     
            , (  SELECT cod_periodo_movimentacao                                
                      , count(cod_periodo_movimentacao)                         
                      , max(timestamp) as timestamp                             
                   FROM folhapagamento.folha_situacao                           
               GROUP BY cod_periodo_movimentacao) AS max_folha_situacao         
            , (  SELECT cod_periodo_movimentacao                                
                      , max(timestamp) as timestamp                             
                   FROM folhapagamento.folha_situacao                           
                  WHERE situacao = '".$situacao."'
               GROUP BY cod_periodo_movimentacao) AS max_folha_situacao_fechada 
        WHERE folha_situacao.cod_periodo_movimentacao = max_folha_situacao.cod_periodo_movimentacao 
          AND folha_situacao.timestamp                = max_folha_situacao.timestamp                
          AND folha_situacao.cod_periodo_movimentacao = max_folha_situacao_fechada.cod_periodo_movimentacao
          AND folha_situacao.cod_periodo_movimentacao = $codPeriodoMovimentacao
            "
        );

        $query->execute();
        $queryResult = $query->fetchAll();
        $result = array_shift($queryResult);
        return $result;
    }


    /**
     * @param $codPeriodoMovimentacao
     * @param $situacao
     * @return mixed
     */
    public function montaRecuperaVezesFecharAbrirFolhaPagamento($codPeriodoMovimentacao, $situacao)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT count(folha_situacao.cod_periodo_movimentacao) as contador
    FROM folhapagamento.folha_situacao                                                           
    , (  SELECT cod_periodo_movimentacao                                                      
    , max(timestamp) as timestamp                                                   
    FROM folhapagamento.folha_situacao                                                 
    GROUP BY cod_periodo_movimentacao) as max_folha_situacao                               
    WHERE folha_situacao.cod_periodo_movimentacao = max_folha_situacao.cod_periodo_movimentacao   
    AND folha_situacao.timestamp                = max_folha_situacao.timestamp                  
    AND folha_situacao.cod_periodo_movimentacao = $codPeriodoMovimentacao AND folha_situacao.situacao = '" . $situacao . "'"
        );

        $query->execute();
        $query = $query->fetchAll();
        return array_shift($query);
    }

    /**
     * @param null $filtro
     * @return object
     */
    public function recuperaUltimaFolhaSituacao($filtro = null)
    {
        $sql = "SELECT ffs.cod_periodo_movimentacao                                     
             , ffs.situacao                                                     
             , to_char(ffs.timestamp, 'dd/mm/yyyy - HH24:MI:SS ') as data_hora  
             , timestamp                                                        
          FROM folhapagamento.folha_situacao ffs                                
          JOIN ( SELECT MAX(ffs2.timestamp) as max_timestamp                        
                   FROM folhapagamento.folha_situacao ffs2                      
               ) max_ffs                                                        
            ON max_ffs.max_timestamp = ffs.timestamp";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param integer $codPeriodoMovimentacao
     * @return array
     */
    public function getComplementarSituacaoAFechar($codPeriodoMovimentacao)
    {
        $sql = "
            SELECT
              fcs.cod_periodo_movimentacao,
              fcs.cod_complementar,
              fcs.timestamp,
              fcs.situacao
            FROM folhapagamento.complementar_situacao fcs
              JOIN (SELECT
                      mfcs.cod_periodo_movimentacao,
                      mfcs.cod_complementar,
                      MAX(mfcs.timestamp) AS timestamp
                    FROM folhapagamento.complementar_situacao mfcs
                    GROUP BY mfcs.cod_periodo_movimentacao
                      , mfcs.cod_complementar
                   ) AS max_fcs
                ON max_fcs.cod_periodo_movimentacao = fcs.cod_periodo_movimentacao
                   AND max_fcs.cod_complementar = fcs.cod_complementar
                   AND max_fcs.timestamp = fcs.timestamp
            WHERE fcs.cod_periodo_movimentacao :: VARCHAR || fcs.cod_complementar || fcs.timestamp
                  NOT IN (SELECT fcsf.cod_periodo_movimentacao :: VARCHAR || fcsf.cod_complementar || fcsf.timestamp
                          FROM folhapagamento.complementar_situacao_fechada fcsf
                  )
                  AND fcs.situacao = 'f'
                  AND fcs.cod_periodo_movimentacao = :codPeriodoMovimentacao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codPeriodoMovimentacao', $codPeriodoMovimentacao, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
