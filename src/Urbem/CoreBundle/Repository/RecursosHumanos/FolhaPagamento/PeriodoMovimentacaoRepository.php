<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;
use \DateTime;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * Class PeriodoMovimentacaoRepository
 * @package Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento
 */
class PeriodoMovimentacaoRepository extends ORM\EntityRepository
{
    /**
     * @param string $dtInicial
     * @param string $dtFinal
     * @return boolean
     */
    public function verificaPeriodo($dtInicial, $dtFinal)
    {
        $sql = <<<SQL
SELECT
    count(*)
FROM
    folhapagamento.periodo_movimentacao
WHERE
    dt_inicial = :dtInicial
    AND dt_final = :dtFinal
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':dtInicial', $dtInicial, \PDO::PARAM_STR);
        $query->bindValue(':dtFinal', $dtFinal, \PDO::PARAM_STR);

        return $query->rowCount() > 1;
    }

    /**
     * @param string $dtinicial
     * @param string $dtfinal
     * @param string $exercicio
     * @param string $entidade
     * @return array
     */
    public function abrirPeriodoMovimentacao($dtinicial, $dtfinal, $exercicio, $entidade)
    {
        $sql = sprintf(
            "SELECT abrirPeriodoMovimentacao('%s','%s','%s','%s')",
            $dtinicial,
            $dtfinal,
            $exercicio,
            $entidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param string $entidade
     * @return mixed
     */
    public function cancelarPeriodoMovimentacao($entidade)
    {
        $sql = sprintf(
            "SELECT public.cancelarPeriodoMovimentacao('%s')",
            $entidade
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $query = current($query->fetchAll());
        $result = array_shift($query);

        return $result;
    }

    /**
     * Retorna o ultimo periodo de movimentaçao ativo
     * @return array
     */
    public function listPeriodoMovimentacao()
    {
        $sql = <<<SQL
SELECT
    FPM.cod_periodo_movimentacao,
    to_char(FPM.dt_inicial,
        'dd/mm/yyyy') AS dt_inicial,
    to_char(FPM.dt_final,
        'dd/mm/yyyy') AS dt_final,
    FPMS.situacao
FROM
    folhapagamento.periodo_movimentacao FPM,
    folhapagamento.periodo_movimentacao_situacao FPMS, (
        SELECT
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            folhapagamento.periodo_movimentacao_situacao
        WHERE
            situacao = 'a') AS MAX_TIMESTAMP
    WHERE
        FPM.cod_periodo_movimentacao = FPMS.cod_periodo_movimentacao
        AND FPMS.timestamp = MAX_TIMESTAMP.timestamp
        AND FPMS.situacao = 'a'
SQL;

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * Retorna o periodo de movimentaçao de acordo com competencia
     * @param $dtFinal formato (mm/yyyy)
     * @return array
     */
    public function consultaPeriodoMovimentacaoCompetencia($dtFinal)
    {
        $sql = <<<SQL
SELECT
    FPM.cod_periodo_movimentacao,
    to_char(FPM.dt_inicial,
        'dd/mm/yyyy') AS dt_inicial,
    to_char(FPM.dt_final,
        'dd/mm/yyyy') AS dt_final,
    FPMS.situacao,
    to_char(FPMS.timestamp,
        'dd/mm/yyyy') AS timestamp_situacao
FROM
    folhapagamento.periodo_movimentacao FPM,
    folhapagamento.periodo_movimentacao_situacao FPMS, (
        SELECT
            cod_periodo_movimentacao,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            folhapagamento.periodo_movimentacao_situacao
        GROUP BY
            cod_periodo_movimentacao) AS MAX_FPMS
    WHERE
        FPM.cod_periodo_movimentacao = FPMS.cod_periodo_movimentacao
        AND FPM.cod_periodo_movimentacao = MAX_FPMS.cod_periodo_movimentacao
        AND FPMS.timestamp = MAX_FPMS.timestamp
        AND to_char(dt_final, 'mm/yyyy') = :dtFinal
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':dtFinal', $dtFinal);
        $query->execute();

        $query = $query->fetchAll();
        return array_shift($query);
    }

    /**
     * @deprecated Usar Repository\Organograma\OrganogramaRepository
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getCodPeriodoMovimentacao()
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT pessoalOrganogramaVigentePorTimestamp('',now()::varchar) AS cod_organograma,
                (coalesce( (SELECT max(cod_periodo_movimentacao) FROM folhapagamento.periodo_movimentacao_situacao
                WHERE timestamp <= now()), 0)) AS cod_periodo_movimentacao, (coalesce((    SELECT periodo_movimentacao.dt_final::varchar
              FROM folhapagamento.periodo_movimentacao
              INNER JOIN folhapagamento.periodo_movimentacao_situacao
                ON periodo_movimentacao.cod_periodo_movimentacao = periodo_movimentacao_situacao.cod_periodo_movimentacao
              WHERE periodo_movimentacao_situacao.timestamp <= now()
              ORDER BY periodo_movimentacao.cod_periodo_movimentacao desc LIMIT 0) ,'1900-01-01'::varchar)) AS dt_final"
        );

        $query->execute();
        $query = $query->fetchAll();
        return array_shift($query);
    }

    /**
     * @param string $entidade
     * @return mixed
     */
    public function montaRecuperaUltimaMovimentacao($entidade = "")
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT
        FPM.cod_periodo_movimentacao,
        to_char(FPM.dt_inicial, 'dd/mm/yyyy') as dt_inicial,
        to_char(FPM.dt_final, 'dd/mm/yyyy') as dt_final,
        FPMS.situacao
        FROM
        folhapagamento".$entidade.".periodo_movimentacao FPM,
        folhapagamento".$entidade.".periodo_movimentacao_situacao FPMS,
        (SELECT
        MAX(timestamp) as timestamp
        FROM folhapagamento".$entidade.".periodo_movimentacao_situacao
        WHERE situacao = 'a') as MAX_TIMESTAMP
        WHERE FPM.cod_periodo_movimentacao = FPMS.cod_periodo_movimentacao
        AND   FPMS.timestamp               = MAX_TIMESTAMP.timestamp
        AND   FPMS.situacao                = 'a'"
        );

        $query->execute();
        $query = $query->fetchAll();
        return array_shift($query);
    }

    /**
     * @param $filtro
     * @param $order
     * @return array
     */
    public function montaPeriodoMovimentacaoWhitParamns($filtro, $order)
    {
        $stSql =
            "SELECT * FROM folhapagamento.periodo_movimentacao";

        if ($filtro) {
            $stSql .= $filtro;
        }

        if ($order) {
            $stSql .= $order;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param null $dtCompetenciaInicial
     * @param null $dtCompetenciaFinal
     * @param null $codPeriodoMovimentacao
     * @return mixed
     */
    public function recuperaPeriodoMovimentacao($dtCompetenciaInicial = null, $dtCompetenciaFinal = null, $codPeriodoMovimentacao = null)
    {
        $stFiltroPeriodo = '';
        if ($dtCompetenciaInicial) {
            $stFiltroPeriodo = " AND to_char(dt_inicial,'mm/yyyy') = '".$dtCompetenciaInicial."'";
        }

        if ($dtCompetenciaFinal) {
            $stFiltroPeriodo = " AND to_char(dt_final,'mm/yyyy') = '".$dtCompetenciaFinal."'";
        }

        if ($codPeriodoMovimentacao) {
            $stFiltroPeriodo = " AND FPM.cod_periodo_movimentacao = {$codPeriodoMovimentacao}";
        }

        $stSql = "SELECT                                                                 \n ";
        $stSql.= "  FPM.cod_periodo_movimentacao,                                        \n ";
        $stSql.= "  to_char(FPM.dt_inicial, 'dd/mm/yyyy') as dt_inicial,                 \n ";
        $stSql.= "  to_char(FPM.dt_final, 'dd/mm/yyyy') as dt_final,                     \n ";
        $stSql.= "  FPMS.situacao,                                                       \n ";
        $stSql.= "  to_char(FPMS.timestamp, 'dd/mm/yyyy') as timestamp_situacao          \n ";
        $stSql.= "FROM                                                                   \n ";
        $stSql.= "    folhapagamento.periodo_movimentacao FPM,                \n ";
        $stSql.= "    folhapagamento.periodo_movimentacao_situacao FPMS,      \n ";
        $stSql.= "    (SELECT                                                            \n ";
        $stSql.= "        cod_periodo_movimentacao,                                      \n ";
        $stSql.= "        MAX(timestamp) as timestamp                                    \n ";
        $stSql.= "    FROM folhapagamento.periodo_movimentacao_situacao       \n ";
        $stSql.= "    GROUP BY cod_periodo_movimentacao) as MAX_FPMS                     \n ";
        $stSql.= "WHERE FPM.cod_periodo_movimentacao = FPMS.cod_periodo_movimentacao     \n ";
        $stSql.= "AND   FPM.cod_periodo_movimentacao = MAX_FPMS.cod_periodo_movimentacao \n ";
        $stSql.= "AND   FPMS.timestamp               = MAX_FPMS.timestamp                \n ";

        $stSql .= $stFiltroPeriodo;

        $query = $this->_em->getConnection()->prepare($stSql);

        $query->execute();
        $query = $query->fetchAll();
        return array_shift($query);
    }

    /**
     * @return mixed
     */
    public function recuperaUltimaFolhaSituacao()
    {
        $query = $this->_em->getConnection()->prepare("
        SELECT ffs.cod_periodo_movimentacao
        , ffs.situacao
        , to_char(ffs.timestamp, 'dd/mm/yyyy - HH24:MI:SS ') as data_hora
        , timestamp
     FROM folhapagamento.folha_situacao ffs
     JOIN ( SELECT MAX(ffs2.timestamp) as max_timestamp
              FROM folhapagamento.folha_situacao ffs2
          ) max_ffs
       ON max_ffs.max_timestamp = ffs.timestamp;");

        $query->execute();
        $query = $query->fetchAll();
        return array_shift($query);
    }

    /**
     * Recupera o periodo de movimentaçao por ano e mes de competencia
     * @param string $ano
     * @param string $mes
     * @return array
     */
    public function recuperaPeriodoMovimentacaoPorCompetencia($ano, $mes)
    {
        $mes = str_pad($mes, 2, "0", STR_PAD_LEFT);

        $sql = <<<SQL
SELECT
    FPM.cod_periodo_movimentacao,
    to_char(FPM.dt_inicial,
        'dd/mm/yyyy') AS dt_inicial,
    to_char(FPM.dt_final,
        'dd/mm/yyyy') AS dt_final,
    FPMS.situacao,
    to_char(FPMS.timestamp,
        'dd/mm/yyyy') AS timestamp_situacao
FROM
    folhapagamento.periodo_movimentacao FPM,
    folhapagamento.periodo_movimentacao_situacao FPMS, (
        SELECT
            cod_periodo_movimentacao,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            folhapagamento.periodo_movimentacao_situacao
        GROUP BY
            cod_periodo_movimentacao) AS MAX_FPMS
    WHERE
        FPM.cod_periodo_movimentacao = FPMS.cod_periodo_movimentacao
        AND FPM.cod_periodo_movimentacao = MAX_FPMS.cod_periodo_movimentacao
        AND FPMS.timestamp = MAX_FPMS.timestamp
        AND to_char(FPM.dt_final, 'yyyy-mm-dd')
        LIKE :dt_final
SQL;
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":dt_final", "{$ano}-{$mes}%", \PDO::PARAM_STR);
        $query->execute();
        return $query->fetch();
    }

    /**
     * @param $filtro
     *
     * @return \Doctrine\DBAL\Driver\Statement|mixed
     */
    public function recuperaPeriodoMovimentacaoDaCompetencia($filtro)
    {
        $sql = <<<SQL
SELECT                                                                 
      FPM.cod_periodo_movimentacao,                                        
      to_char(FPM.dt_inicial, 'dd/mm/yyyy') as dt_inicial,                 
      to_char(FPM.dt_final, 'dd/mm/yyyy') as dt_final,                     
      FPMS.situacao,                                                       
      to_char(FPMS.timestamp, 'dd/mm/yyyy') as timestamp_situacao          
    FROM                                                                   
        folhapagamento.periodo_movimentacao FPM,                
        folhapagamento.periodo_movimentacao_situacao FPMS,      
        (SELECT                                                            
            cod_periodo_movimentacao,                                      
            MAX(timestamp) as timestamp                                    
        FROM folhapagamento.periodo_movimentacao_situacao       
        GROUP BY cod_periodo_movimentacao) as MAX_FPMS                     
    WHERE FPM.cod_periodo_movimentacao = FPMS.cod_periodo_movimentacao     
    AND   FPM.cod_periodo_movimentacao = MAX_FPMS.cod_periodo_movimentacao 
    AND   FPMS.timestamp               = MAX_FPMS.timestamp
SQL;
        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        $query = $query->fetch();
        return $query;
    }

    /**
     * @param DateTime $initialDate
     * @param DateTime $finalDate
     * @return array
     */
    public function findCodPeriodoByInitialAndFinalDate(DateTime $initialDate, DateTime $finalDate)
    {
        $sql = "SELECT
	              FPM.cod_periodo_movimentacao,
	              FPM.dt_inicial,
	              FPM.dt_final
	            FROM
	              folhapagamento.periodo_movimentacao FPM,
	              folhapagamento.periodo_movimentacao_situacao FPMS,
	              (SELECT
	                cod_periodo_movimentacao,
	                MAX(timestamp) as timestamp
	                FROM folhapagamento.periodo_movimentacao_situacao
	                GROUP BY cod_periodo_movimentacao) as MAX_FPMS
	            WHERE FPM.cod_periodo_movimentacao = FPMS.cod_periodo_movimentacao
	            AND   FPM.cod_periodo_movimentacao = MAX_FPMS.cod_periodo_movimentacao
	            AND   FPMS.timestamp               = MAX_FPMS.timestamp
	            AND dt_final BETWEEN TO_DATE(:inicialDate, 'dd/mm/yyyy') AND TO_DATE(:finalDate, 'dd/mm/yyyy')";

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao', 'FPM');

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $query->setParameter('inicialDate', $initialDate->format('d/m/Y'));
        $query->setParameter('finalDate', $finalDate->format('d/m/Y'));
        $result = $query->getResult();

        return $result;
    }
    
    /**
     * @return array
     */
    public function fetchFolhaComplementar($codPeriodoMovimentacao)
    {
        $sql = "
            SELECT
              complementar.cod_complementar,
              complementar.cod_complementar
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
                      max(timestamp) as timestamp
                    FROM
                      folhapagamento.complementar_situacao
                    GROUP BY
                      cod_periodo_movimentacao,
                      cod_complementar
                  ) as max_fcs ON max_fcs.cod_periodo_movimentacao = fcs.cod_periodo_movimentacao
                  AND max_fcs.cod_complementar = fcs.cod_complementar
                  AND max_fcs.timestamp = fcs.timestamp
              ) as complementar_situacao ON complementar_situacao.cod_periodo_movimentacao = complementar.cod_periodo_movimentacao
              AND complementar_situacao.cod_complementar = complementar.cod_complementar
              AND complementar.cod_periodo_movimentacao = :codPeriodoMovimentacao;
        ";
        
        $query = $this->getEntityManager()->getConnection()->prepare($sql);
        
        $query->bindValue('codPeriodoMovimentacao', $codPeriodoMovimentacao);
        $query->execute();
        
        return $query->fetchAll();
    }
}
