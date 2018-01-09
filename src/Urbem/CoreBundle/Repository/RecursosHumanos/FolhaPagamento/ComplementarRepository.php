<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class ComplementarRepository
 * @package Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento
 */
class ComplementarRepository extends AbstractRepository
{
    /**
     * @param $timestamp
     * @param $codPeriodoMovimentacao
     * @return array
     */
    public function recuperaFolhaComplementarFechadaAnteriorFolhaSalario($timestamp, $codPeriodoMovimentacao)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT complementar_situacao.cod_complementar
     , CASE complementar_situacao.situacao
       WHEN 'a' THEN 'Aberto'
       WHEN 'f' THEN 'Fechado'
        END AS situacao
     , CASE folha_situacao.situacao
       WHEN 'a' THEN 'Aberto'
       WHEN 'f' THEN 'Fechado'
        END || ' em ' || to_char(complementar_situacao_fechada.timestamp_folha,'dd/mm/yyyy - HH24:MI:SS') AS situacao_folha
     , to_char(complementar_situacao.timestamp,'dd/mm/yyyy HH24:MI:SS') as data_fechamento
     , to_char(complementar_situacao_fechada.timestamp_folha,'dd/mm/yyyy - HH24:MI:SS') as timestamp_folha
     , complementar_situacao_abertura.data_abertura
  FROM folhapagamento.complementar_situacao
     , (  SELECT cod_complementar
               , max(timestamp) as timestamp
            FROM folhapagamento.complementar_situacao
        GROUP BY cod_complementar) as max_complementar_situacao
     , (SELECT complementar_situacao.cod_periodo_movimentacao
             , complementar_situacao.cod_complementar
             , to_char(complementar_situacao.timestamp,'dd/mm/yyyy HH24:MI:SS') as data_abertura
          FROM folhapagamento.complementar_situacao
             , (  SELECT cod_complementar
                       , max(timestamp) as timestamp
                    FROM folhapagamento.complementar_situacao
                   WHERE situacao = 'a'
                GROUP BY cod_complementar) as max_complementar_situacao
         WHERE situacao = 'a'
           AND complementar_situacao.cod_complementar = max_complementar_situacao.cod_complementar
           AND complementar_situacao.timestamp = max_complementar_situacao.timestamp) as complementar_situacao_abertura
     , folhapagamento.complementar_situacao_fechada
     , folhapagamento.folha_situacao
 WHERE complementar_situacao.cod_complementar= max_complementar_situacao.cod_complementar
   AND complementar_situacao.timestamp       = max_complementar_situacao.timestamp
   AND complementar_situacao.cod_periodo_movimentacao= complementar_situacao_abertura.cod_periodo_movimentacao
   AND complementar_situacao.cod_complementar        = complementar_situacao_abertura.cod_complementar
   AND complementar_situacao.cod_periodo_movimentacao= complementar_situacao_fechada.cod_periodo_movimentacao
   AND complementar_situacao.cod_complementar        = complementar_situacao_fechada.cod_complementar
   AND complementar_situacao.timestamp               = complementar_situacao_fechada.timestamp
   AND complementar_situacao_fechada.cod_periodo_movimentacao_folha = folha_situacao.cod_periodo_movimentacao
   AND complementar_situacao_fechada.timestamp_folha                = folha_situacao.timestamp
 AND complementar_situacao.situacao = 'f' AND complementar_situacao.timestamp  < '" . $timestamp . "' AND complementar_situacao.cod_periodo_movimentacao = " . $codPeriodoMovimentacao . " ORDER BY  cod_complementar"
        );

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $timestamp
     * @param $codPeriodoMovimentacao
     * @return array
     */
    public function recuperaFolhaComplementarFechada($timestamp, $codPeriodoMovimentacao)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT complementar_situacao.id,complementar_situacao.cod_complementar
     , to_char(complementar_situacao.timestamp,'dd/mm/yyyy') as data_fechamento
     , complementar_situacao_abertura.data_abertura
  FROM folhapagamento.complementar_situacao
     , (  SELECT cod_complementar
               , max(timestamp) as timestamp
            FROM folhapagamento.complementar_situacao
        GROUP BY cod_complementar) as max_complementar_situacao
     , (SELECT complementar_situacao.cod_periodo_movimentacao
             , complementar_situacao.cod_complementar
             , to_char(complementar_situacao.timestamp,'dd/mm/yyyy') as data_abertura
          FROM folhapagamento.complementar_situacao
             , (  SELECT cod_complementar
                       , max(timestamp) as timestamp
                    FROM folhapagamento.complementar_situacao
                   WHERE situacao = 'a'
                GROUP BY cod_complementar) as max_complementar_situacao
         WHERE situacao = 'a'
           AND complementar_situacao.cod_complementar = max_complementar_situacao.cod_complementar
           AND complementar_situacao.timestamp = max_complementar_situacao.timestamp) as complementar_situacao_abertura
 WHERE complementar_situacao.cod_complementar= max_complementar_situacao.cod_complementar
   AND complementar_situacao.timestamp       = max_complementar_situacao.timestamp
   AND complementar_situacao.cod_periodo_movimentacao= complementar_situacao_abertura.cod_periodo_movimentacao
   AND complementar_situacao.cod_complementar        = complementar_situacao_abertura.cod_complementar
 AND complementar_situacao.situacao = 'f' AND complementar_situacao.timestamp  >  '" . $timestamp . "'  AND complementar_situacao.cod_periodo_movimentacao = " . $codPeriodoMovimentacao . " ORDER BY  cod_complementar"
        );

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codPeriodoMovimentacao
     * @return mixed
     */
    public function consultaFolhaComplementar($codPeriodoMovimentacao)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT *
   FROM folhapagamento.complementar complementar
   JOIN ( SELECT fcs.*
            FROM folhapagamento.complementar_situacao fcs
            JOIN (   SELECT cod_periodo_movimentacao
                          , cod_complementar
                          , max(timestamp) as timestamp
                       FROM folhapagamento.complementar_situacao
                   GROUP BY cod_periodo_movimentacao, cod_complementar
                 ) as max_fcs
              ON max_fcs.cod_periodo_movimentacao = fcs.cod_periodo_movimentacao
             AND max_fcs.cod_complementar         = fcs.cod_complementar
             AND max_fcs.timestamp                = fcs.timestamp
        ) as complementar_situacao
     ON complementar_situacao.cod_periodo_movimentacao = complementar.cod_periodo_movimentacao
    AND complementar_situacao.cod_complementar         = complementar.cod_complementar
 AND complementar_situacao.cod_periodo_movimentacao = " . $codPeriodoMovimentacao . " AND complementar_situacao.situacao = 'a'"
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
    public function consultaFolhaComplementarStatus($codPeriodoMovimentacao)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT *
   FROM folhapagamento.complementar complementar
   JOIN ( SELECT fcs.*
            FROM folhapagamento.complementar_situacao fcs
            JOIN (   SELECT cod_periodo_movimentacao
                          , cod_complementar
                          , max(timestamp) as timestamp
                       FROM folhapagamento.complementar_situacao
                   GROUP BY cod_periodo_movimentacao, cod_complementar
                 ) as max_fcs
              ON max_fcs.cod_periodo_movimentacao = fcs.cod_periodo_movimentacao
             AND max_fcs.cod_complementar         = fcs.cod_complementar
             AND max_fcs.timestamp                = fcs.timestamp
        ) as complementar_situacao
     ON complementar_situacao.cod_periodo_movimentacao = complementar.cod_periodo_movimentacao
    AND complementar_situacao.cod_complementar         = complementar.cod_complementar
 AND complementar_situacao.cod_periodo_movimentacao = $codPeriodoMovimentacao"
        );

        $query->execute();
        $queryResult = array_shift($query->fetchAll());
        $result = $queryResult;
        return $result;
    }

    /**
     * @param $cod_periodo_movimentacao
     * @return mixed
     */
    public function getFolhaComplementar($cod_periodo_movimentacao)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT *
   FROM folhapagamento.complementar complementar
   where complementar.cod_periodo_movimentacao = " . $cod_periodo_movimentacao
        );

        $query->execute();
        $queryResult = array_shift($query->fetchAll());
        $result = $queryResult;
        return $result;
    }


    /**
     * @param $codPeriodoMovimentacao
     * @param $timestamp
     * @return array
     */
    public function recuperaRelacionamentoFechadaPosteriorSalario($codPeriodoMovimentacao, $timestamp)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT complementar_situacao.cod_complementar
         , to_char(complementar_situacao.timestamp,'dd/mm/yyyy') as data_fechamento
         , complementar_situacao_abertura.data_abertura
      FROM folhapagamento.complementar_situacao
         , (  SELECT cod_complementar
                   , max(timestamp) as timestamp
                FROM folhapagamento.complementar_situacao
            GROUP BY cod_complementar) as max_complementar_situacao
         , (SELECT complementar_situacao.cod_periodo_movimentacao
                 , complementar_situacao.cod_complementar
                 , to_char(complementar_situacao.timestamp,'dd/mm/yyyy') as data_abertura
              FROM folhapagamento.complementar_situacao
                 , (  SELECT cod_complementar
                           , max(timestamp) as timestamp
                        FROM folhapagamento.complementar_situacao
                       WHERE situacao = 'a'
                    GROUP BY cod_complementar) as max_complementar_situacao
             WHERE situacao = 'a'
               AND complementar_situacao.cod_complementar = max_complementar_situacao.cod_complementar
               AND complementar_situacao.timestamp = max_complementar_situacao.timestamp) as complementar_situacao_abertura WHERE complementar_situacao.cod_complementar= max_complementar_situacao.cod_complementar
       AND complementar_situacao.timestamp       = max_complementar_situacao.timestamp
       AND complementar_situacao.cod_periodo_movimentacao= complementar_situacao_abertura.cod_periodo_movimentacao
       AND complementar_situacao.cod_complementar        = complementar_situacao_abertura.cod_complementar
       AND complementar_situacao.situacao = 'f' AND complementar_situacao.timestamp  >  '" . $timestamp . "'  AND complementar_situacao.cod_periodo_movimentacao = $codPeriodoMovimentacao ORDER BY  cod_complementar"
        );

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codPeriodoMovimentacao
     * @return int
     */
    public function getNextCodComplementar($codPeriodoMovimentacao)
    {
        return $this->nextVal('cod_complementar', ['cod_periodo_movimentacao' => $codPeriodoMovimentacao]);
    }

    public function listaFolhaPagamentoComplementar($codPeriodoMovimentacao)
    {
        $sql = <<<SQL
SELECT
    *
FROM
    folhapagamento.complementar complementar
    JOIN (
        SELECT
            fcs.*
        FROM
            folhapagamento.complementar_situacao fcs
            JOIN (
                SELECT
                    cod_periodo_movimentacao,
                    cod_complementar,
                    max(TIMESTAMP) AS TIMESTAMP
                FROM
                    folhapagamento.complementar_situacao
                GROUP BY
                    cod_periodo_movimentacao,
                    cod_complementar) AS max_fcs ON max_fcs.cod_periodo_movimentacao = fcs.cod_periodo_movimentacao
                AND max_fcs.cod_complementar = fcs.cod_complementar
                AND max_fcs.timestamp = fcs.timestamp) AS complementar_situacao ON complementar_situacao.cod_periodo_movimentacao = complementar.cod_periodo_movimentacao
            AND complementar_situacao.cod_complementar = complementar.cod_complementar
            AND complementar_situacao.cod_periodo_movimentacao = :cod_periodo_movimentacao
        ORDER BY
            complementar.cod_complementar
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":cod_periodo_movimentacao", $codPeriodoMovimentacao, \PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param null $filtro
     * @param null $ordem
     * @return array
     */
    public function recuperaRelacionamento($filtro = null, $ordem = null)
    {
        $sql = "SELECT *                                                                                      
       FROM folhapagamento.complementar complementar                                               
       JOIN ( SELECT fcs.*                                                                         
                FROM folhapagamento.complementar_situacao fcs                                      
                JOIN (   SELECT cod_periodo_movimentacao                                           
                              , cod_complementar                                                   
                              , max(timestamp) as timestamp                                        
                           FROM folhapagamento.complementar_situacao                               
                       GROUP BY cod_periodo_movimentacao, cod_complementar                         
                     ) as max_fcs                                                                  
                  ON max_fcs.cod_periodo_movimentacao = fcs.cod_periodo_movimentacao               
                 AND max_fcs.cod_complementar         = fcs.cod_complementar                       
                 AND max_fcs.timestamp                = fcs.timestamp                              
            ) as complementar_situacao                                                             
         ON complementar_situacao.cod_periodo_movimentacao = complementar.cod_periodo_movimentacao 
        AND complementar_situacao.cod_complementar         = complementar.cod_complementar";

       if ($filtro) {
            $sql .= $filtro;
       }

       if ($ordem) {
           $sql .= $ordem;
       }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
