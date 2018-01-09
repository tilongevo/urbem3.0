<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class ConciliacaoRepository extends ORM\EntityRepository
{
    /**
     * @param array $params
     * @return \Doctrine\DBAL\Driver\Statement
     * @throws \Doctrine\DBAL\DBALException
     */
    public function recuperaMovimentacao(array $params)
    {
        /**
         * SELECT * FROM tesouraria.fn_conciliacao_movimentacao_corrente( '2016'
        ,'2'
        ,''
        ,'01/01/2016'
        ,' WHERE  exercicio = '||quote_literal('2016')||' AND  TO_CHAR(dt_lancamento,'||quote_literal('mm')||') = TO_CHAR(TO_DATE( '||quote_literal('01/01/2016')||'::varchar,'||quote_literal('dd/mm/yyyy')||'),'||quote_literal('mm')||') AND  cod_plano = 2529  AND  ((mes >= '||quote_literal('01')||' AND exercicio_conciliacao = '||quote_literal('2016')||') OR conciliar != '||quote_literal('true')||') '
        ,' AND TB.exercicio = '||quote_literal('2016')||'  AND TO_CHAR(TB.dt_boletim,'||quote_literal('mm')||') = TO_CHAR(TO_DATE( '||quote_literal('01/01/2016')||'::varchar, '||quote_literal('dd/mm/yyyy')||'),'||quote_literal('mm')||') '
        ,2529
        ,'1'
        ) AS
        retorno

        (
        ordem                 VARCHAR,
        dt_lancamento         VARCHAR,
        dt_conciliacao        VARCHAR,
        descricao             VARCHAR,
        vl_lancamento         DECIMAL,
        vl_original           DECIMAL,
        tipo_valor            VARCHAR,
        conciliar             VARCHAR,
        cod_lote              INTEGER,
        tipo                  VARCHAR,
        sequencia             INTEGER,
        cod_entidade          INTEGER,
        tipo_movimentacao     VARCHAR,
        cod_plano             INTEGER,
        cod_arrecadacao       INTEGER,
        cod_receita           INTEGER,
        cod_bordero           INTEGER,
        timestamp_arrecadacao VARCHAR,
        timestamp_estornada   VARCHAR,
        tipo_arrecadacao      VARCHAR,
        mes                   VARCHAR,
        id                    VARCHAR,
        exercicio_conciliacao VARCHAR
        )
         */
        $sql = "
            select
                *
            from
                tesouraria.fn_conciliacao_movimentacao_corrente(
                    '" . $params['exercicio'] . "',
                    '" . $params['inCodEntidade'] . "',
                    '" . $params['stDtInicial'] . "',
                    '" . $params['stDtFinal'] . "',
                    '" . $params['stFiltro'] . "',
                    '" . $params['stFiltroArrecadacao'] . "',
                    " . $params['inCodPlano'] . ",
                    '" . $params['inMes'] . "'
                ) as retorno(
                    ordem varchar,
                    dt_lancamento varchar,
                    dt_conciliacao varchar,
                    descricao varchar,
                    vl_lancamento decimal,
                    vl_original decimal,
                    tipo_valor varchar,
                    conciliar varchar,
                    cod_lote integer,
                    tipo varchar,
                    sequencia integer,
                    cod_entidade integer,
                    tipo_movimentacao varchar,
                    cod_plano integer,
                    cod_arrecadacao integer,
                    cod_receita integer,
                    cod_bordero integer,
                    timestamp_arrecadacao varchar,
                    timestamp_estornada varchar,
                    tipo_arrecadacao varchar,
                    mes varchar,
                    id varchar,
                    exercicio_conciliacao varchar
                );
        ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param array $params
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function recuperaMovimentacaoPendente(array $params)
    {
        /**
         * SELECT * FROM tesouraria.fn_conciliacao_movimentacao_pendente( '2016'
        ,'2'
        ,'01/01/2016'
        ,''
        ,' WHERE  exercicio <= '||quote_literal('2016')||' AND  dt_lancamento < TO_DATE( '||quote_literal('01/01/2016')||', '||quote_literal('dd/mm/yyyy')||' ) AND  cod_plano = 2506  AND  ((CASE WHEN mes = '||quote_literal('')||' THEN false ELSE mes::integer >= 1 END AND exercicio_conciliacao = '||quote_literal('2016')||') OR conciliar != '||quote_literal('true')||') '
        ,' AND TB.exercicio <= '||quote_literal('2016')||'  AND TB.dt_boletim <= TO_DATE( '||quote_literal('01/01/2016')||'::varchar, '||quote_literal('dd/mm/yyyy')||' ) '
        ,2506
        ,'01'
        ) AS
        retorno

        (
        ordem                 VARCHAR,
        dt_lancamento         VARCHAR,
        dt_conciliacao        VARCHAR,
        descricao             VARCHAR,
        vl_lancamento         DECIMAL,
        vl_original           DECIMAL,
        tipo_valor            VARCHAR,
        conciliar             VARCHAR,
        cod_lote              INTEGER,
        tipo                  VARCHAR,
        sequencia             INTEGER,
        cod_entidade          INTEGER,
        tipo_movimentacao     VARCHAR,
        cod_plano             INTEGER,
        cod_arrecadacao       INTEGER,
        cod_receita           INTEGER,
        cod_bordero           INTEGER,
        timestamp_arrecadacao VARCHAR,
        timestamp_estornada   VARCHAR,
        tipo_arrecadacao      VARCHAR,
        mes                   VARCHAR,
        id                    VARCHAR,
        exercicio_conciliacao VARCHAR
        );

         */
        $sql = "
        SELECT * FROM tesouraria.fn_conciliacao_movimentacao_pendente( '".$params['exercicio']."'
                                                                            ,'".$params['inCodEntidade']."'
                                                                            ,'".$params['stDtInicial']."'
                                                                            ,'".$params['stDtFinal']."'
                                                                            ,'".$params['stFiltro']."'
                                                                            ,'".$params['stFiltroArrecadacao']."'
                                                                            ,".$params['inCodPlano']."
                                                                            ,'".$params['inMes']."'
                                                                           ) AS
                                                                     retorno
               (
                      ordem                 VARCHAR,
                      dt_lancamento         VARCHAR,
                      dt_conciliacao        VARCHAR,
                      descricao             VARCHAR,
                      vl_lancamento         DECIMAL,
                      vl_original           DECIMAL,
                      tipo_valor            VARCHAR,
                      conciliar             VARCHAR,
                      cod_lote              INTEGER,
                      tipo                  VARCHAR,
                      sequencia             INTEGER,
                      cod_entidade          INTEGER,
                      tipo_movimentacao     VARCHAR,
                      cod_plano             INTEGER,
                      cod_arrecadacao       INTEGER,
                      cod_receita           INTEGER,
                      cod_bordero           INTEGER,
                      timestamp_arrecadacao VARCHAR,
                      timestamp_estornada   VARCHAR,
                      tipo_arrecadacao      VARCHAR,
                      mes                   VARCHAR,
                      id                    VARCHAR,
                      exercicio_conciliacao VARCHAR
               )
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $cod_plano
     * @param $exercicio
     * @param $mes
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaCabecalhoConciliacao($cod_plano, $exercicio, $mes)
    {
        $stSql = "SELECT
           CO.cod_plano,
           CONTA.nom_conta,
           ENT.cod_entidade,
           ENT.nom_cgm as nom_entidade,
           CO.exercicio,
           CO.mes,
           to_char(CO.dt_extrato,'dd/mm/yyyy') as dt_extrato,
           CO.vl_extrato
       FROM
           tesouraria.conciliacao  as CO,
           contabilidade.plano_banco  as PB
               LEFT OUTER JOIN (
                   SELECT
                       CGM.nom_cgm,
                       OE.cod_entidade,
                       OE.exercicio
                   FROM
                       orcamento.entidade  as OE,
                       sw_cgm              as CGM
                   WHERE
                       OE.numcgm = CGM.numcgm
               ) as ENT ON (
                   PB.cod_entidade = ENT.cod_entidade   AND
                   PB.exercicio    = ENT.exercicio
               )
               LEFT OUTER JOIN (
                   SELECT
                       PC.nom_conta,
                       PB.cod_plano,
                       PB.exercicio
                   FROM
                       contabilidade.plano_banco       as PB,
                       contabilidade.plano_analitica   as PA,
                       contabilidade.plano_conta       as PC
                   WHERE
                       PB.cod_plano    = PA.cod_plano  AND
                       PB.exercicio    = PA.exercicio  AND

                       PA.cod_conta    = PC.cod_conta  AND
                       PA.exercicio    = PC.exercicio
               ) as CONTA ON (
                   PB.cod_plano    = CONTA.cod_plano   AND
                   PB.exercicio    = CONTA.exercicio
               )
       WHERE
           CO.cod_plano    = PB.cod_plano  AND
           CO.exercicio    = PB.exercicio  AND
           CO.cod_plano    = " . $cod_plano . "  AND
           CO.exercicio    = '" . $exercicio . "'  AND
           CO.mes          = " . $mes . ";";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return array_shift($result);
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return mixed
     * @throws \Doctrine\DBAL\DBALException
     */
    public function listLancamentosManuais($codPlano, $exercicio, $mes)
    {
        $stSql = "
            SELECT cod_plano
                 , exercicio
                 , mes
                 , sequencia
                 , TO_CHAR(dt_lancamento,'dd/mm/yyyy') AS dt_lancamento
                 , vl_lancamento
                 , tipo_valor
                 , descricao
                 , conciliado
                 , CAST(CASE WHEN conciliado IS TRUE
                             THEN TO_CHAR(dt_conciliacao,'dd/mm/yyyy')
                             ELSE ''
                        END AS VARCHAR) AS dt_conciliacao
             FROM tesouraria.conciliacao_lancamento_manual
             WHERE  exercicio = '".$exercicio."' AND
             cod_plano = ".$codPlano." AND
             mes::integer = ".$mes." AND
             TO_CHAR( dt_lancamento, 'mm' )::integer = ".$mes.";
        ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $cod_plano
     * @param $dt_inicial
     * @param $dt_final
     * @param $exercicio
     * @param $movimentacao
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function recuperaSaldoContaTesouraria($cod_plano, $dt_inicial, $dt_final, $exercicio, $movimentacao = false)
    {
        $stSql  = "SELECT tesouraria.fn_saldo_conta_tesouraria( '".$exercicio."' \n";
        $stSql .= "                                            , ".$cod_plano."  \n";
        $stSql .= "                                            ,'".$dt_inicial."' \n";
        $stSql .= "                                            ,'".$dt_final."' \n";
        $stSql .= "                                            ,'$movimentacao' \n";
        $stSql .= ") as valor\n";
        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetch();
        return $result['valor'];
    }


    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removeConciliacaoLancamentoManual($codPlano, $exercicio, $mes)
    {
        $sql = 'DELETE FROM tesouraria.conciliacao_lancamento_manual WHERE cod_plano = :codPlano AND exercicio = :exercicio AND mes = :mes';
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codPlano', $codPlano, \PDO::PARAM_INT);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('mes', $mes, \PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removeConciliacaoLancamentoArrecadacao($codPlano, $exercicio, $mes)
    {
        $sql = 'DELETE FROM tesouraria.conciliacao_lancamento_arrecadacao WHERE cod_plano = :codPlano AND exercicio = :exercicio AND mes = :mes';
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codPlano', $codPlano, \PDO::PARAM_INT);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('mes', $mes, \PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $mes
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removeConciliacaoLancamentoArrecadacaoEstornada($codPlano, $exercicio, $mes)
    {
        $sql = 'DELETE FROM tesouraria.conciliacao_lancamento_arrecadacao_estornada WHERE cod_plano = :codPlano AND exercicio = :exercicio AND mes = :mes';
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codPlano', $codPlano, \PDO::PARAM_INT);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('mes', $mes, \PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @param $exercicioConciliacao
     * @param $mes
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removeConciliacaoLancamentoContabil($codPlano, $exercicio, $exercicioConciliacao, $mes)
    {
        $sql = 'DELETE FROM tesouraria.conciliacao_lancamento_contabil WHERE cod_plano = :codPlano AND exercicio = :exercicio AND exercicio_conciliacao = :exercicioConciliacao AND mes = :mes';
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codPlano', $codPlano, \PDO::PARAM_INT);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('exercicioConciliacao', $exercicioConciliacao, \PDO::PARAM_STR);
        $query->bindValue('mes', $mes, \PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @param $tipo
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removeAssinatura($codEntidade, $exercicio, $tipo)
    {
        $sql = 'DELETE FROM tesouraria.assinatura WHERE cod_entidade = :codEntidade AND exercicio = :exercicio AND tipo = :tipo';
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codEntidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('tipo', $tipo, \PDO::PARAM_STR);

        return $query->execute();
    }
}
