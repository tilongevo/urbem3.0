<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;

class SuplementacaoRepository extends ORM\EntityRepository
{
    public function getNewCodSuplementacao($exercicio)
    {
        $sql = sprintf(
            "SELECT COALESCE(MAX(cod_suplementacao), 0) + 1 AS CODIGO FROM orcamento.suplementacao where exercicio = '%s'",
            $exercicio
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll()[0]['codigo'];
    }

    public function getSuplementacaoDados($suplementacao)
    {
        $sql = sprintf(
            " SELECT
                  S.cod_suplementacao,
                  S.exercicio,
                  S.cod_norma,
                  S.cod_tipo,
                  S.dt_suplementacao AS dt_suplementacao,
                  SE.dt_suplementacao AS dt_anulacao,
                  S.motivo,
                  orcamento.fn_totaliza_suplementacao( S.exercicio, S.cod_suplementacao ) AS vl_suplementacao
              FROM
                  orcamento.suplementacao S
                  LEFT JOIN orcamento.suplementacao_anulada SA ON
                  ( S.exercicio = SA.exercicio AND S.cod_suplementacao = SA.cod_suplementacao  )
                  LEFT JOIN orcamento.suplementacao SE ON
                  ( SE.exercicio = SA.exercicio AND SA.cod_suplementacao_anulacao = SE.cod_suplementacao )
              WHERE S.cod_suplementacao IS NOT NULL
                AND S.cod_suplementacao = %d AND S.exercicio = '%s'",
            $suplementacao->getCodSuplementacao(),
            $suplementacao->getExercicio()
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function orcamentoSuplementacoesCreditoSuplementar($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
         $sql = sprintf(
             "SELECT OrcamentoSuplementacoesCreditoSuplementar(
                '%s'
                , %d
                , '%s'
                , %d
                , '%s'
                , %d
                , '%s')
             as sequencia",
             $exercicio,
             $valor,
             $decreto,
             $codLote,
             $tipoLote,
             $entidade,
             $creditoSuplementar
         );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }

    public function orcamentoSuplementacoesCreditoEspecial($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
         $sql = sprintf(
             "SELECT OrcamentoSuplementacoesCreditoEspecial(
                '%s'
                , %d
                , '%s'
                , %d
                , '%s'
                , %d
                , '%s')
             as sequencia",
             $exercicio,
             $valor,
             $decreto,
             $codLote,
             $tipoLote,
             $entidade,
             $creditoSuplementar
         );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }

    public function orcamentoSuplementacoesTransferencia($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $codHistorico)
    {
        $sql = sprintf(
            "SELECT OrcamentoSuplementacoesTransferencia(
                '%s'
                , %d
                , '%s'
                , %d
                , '%s'
                , %d
                , %d)
             as sequencia",
            $exercicio,
            $valor,
            $decreto,
            $codLote,
            $tipoLote,
            $entidade,
            $codHistorico
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }

    public function orcamentoSuplementacoesCreditoExtraordinario($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        $sql = sprintf(
            "SELECT OrcamentoSuplementacoesCreditoExtraordinario(
                '%s'
                , %d
                , '%s'
                , %d
                , '%s'
                , %d
                , '%s')
             as sequencia",
            $exercicio,
            $valor,
            $decreto,
            $codLote,
            $tipoLote,
            $entidade,
            $creditoSuplementar
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }

    public function orcamentoAnulacaoSuplementacoesCreditoEspecial($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        $sql = sprintf(
            "SELECT OrcamentoAnulacaoSuplementacoesCreditoEspecial(
                '%s'
                , %d
                , '%s'
                , %d
                , '%s'
                , %d
                , '%s')
             as sequencia",
            $exercicio,
            $valor,
            $decreto,
            $codLote,
            $tipoLote,
            $entidade,
            $creditoSuplementar
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }

    public function orcamentoAnulacaoSuplementacoesCreditoSuplementar($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        $sql = sprintf(
            "SELECT OrcamentoAnulacaoSuplementacoesCreditoSuplementar(
                '%s'
                , %d
                , '%s'
                , %d
                , '%s'
                , %d
                , '%s')
             as sequencia",
            $exercicio,
            $valor,
            $decreto,
            $codLote,
            $tipoLote,
            $entidade,
            $creditoSuplementar
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }

    public function orcamentoAnulacaoSuplementacoesCreditoExtraordinario($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        $sql = sprintf(
            "SELECT OrcamentoAnulacaoSuplementacoesCreditoExtraordinario(
                '%s'
                , %d
                , '%s'
                , %d
                , '%s'
                , %d
                , '%s')
             as sequencia",
            $exercicio,
            $valor,
            $decreto,
            $codLote,
            $tipoLote,
            $entidade,
            $creditoSuplementar
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }

    public function orcamentoAnulacaoSuplementacoesTransferencia($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $codHistorico)
    {
        $sql = sprintf(
            "SELECT OrcamentoAnulacaoSuplementacoesTransferencia(
                '%s'
                , %d
                , '%s'
                , %d
                , '%s'
                , %d
                , %d)
             as sequencia",
            $exercicio,
            $valor,
            $decreto,
            $codLote,
            $tipoLote,
            $entidade,
            $codHistorico
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $result = $result->fetchAll();

        if ($result) {
            $sequencia = array_shift($result);
            return $sequencia['sequencia'];
        }

        return false;
    }
}
