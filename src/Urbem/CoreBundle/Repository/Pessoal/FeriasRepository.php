<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class FeriasRepository
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class FeriasRepository extends AbstractRepository
{
    /**
     * Filtro do sistema legado que retorna a lista de ferias para serem cedidas
     * @param string $stTipoFiltro
     * @param string $stValoresFiltro
     * @param integer $inCodPeriodoMovimentacao
     * @param string $stExercicio
     * @param string $stAcao
     * @param string $stEntidade
     * @param boolean $boFeriasVencidas
     * @param integer $inCodLote
     * @param integer $inCodRegime
     * @return array
     */
    public function consultaFerias($stTipoFiltro, $stValoresFiltro, $inCodPeriodoMovimentacao, $stExercicio, $stAcao, $stEntidade = '', $boFeriasVencidas = false, $inCodLote = 0, $inCodRegime = 0)
    {
        $sql = <<<SQL
SELECT
    concederFerias.*,
    CASE WHEN trim(concederFerias.mes_competencia) <> '' THEN
        CASE WHEN trim(concederFerias.mes_competencia)::INTEGER > 0 THEN
            concederFerias.mes_competencia || '/' || concederFerias.ano_competencia
        END
    END AS competencia,
    to_char(concederFerias.dt_inicial_aquisitivo,
        'dd/mm/yyyy') AS dt_inicial_aquisitivo_formatado,
    to_char(concederFerias.dt_final_aquisitivo,
        'dd/mm/yyyy') AS dt_final_aquisitivo_formatado,
    to_char(concederFerias.dt_admissao,
        'dd/mm/yyyy') AS dt_admissao_formatado,
    sum(COALESCE (ferias.dias_ferias,
            0)) + sum(COALESCE (ferias.dias_abono,
            0)) AS ferias_tiradas
FROM
    concederFerias(:stTipoFiltro,
        :stValoresFiltro,
        :inCodPeriodoMovimentacao,
        :boFeriasVencidas,
        :stEntidade,
        :stExercicio,
        :stAcao,
        :inCodLote,
        :inCodRegime) AS concederFerias
    LEFT JOIN pessoal.ferias ON ferias.dt_inicial_aquisitivo = concederFerias.dt_inicial_aquisitivo
    AND ferias.dt_final_aquisitivo = concederFerias.dt_final_aquisitivo
    AND ferias.cod_contrato = concederFerias.cod_contrato
WHERE ((ferias.cod_forma IS NOT NULL
        AND ferias.cod_forma NOT IN (1, 2)
        AND ferias.cod_forma IN (3, 4))
    OR ferias.cod_forma IS NULL)
AND recuperarSituacaoDoContrato(concederFerias.cod_contrato, :inCodPeriodoMovimentacao, :stEntidade) = 'A'
GROUP BY
    concederFerias.cod_ferias,
    concederFerias.numcgm,
    concederFerias.nom_cgm,
    concederFerias.registro,
    concederFerias.cod_contrato,
    concederFerias.desc_local,
    concederFerias.desc_orgao,
    concederFerias.orgao,
    concederFerias.dt_posse,
    concederFerias.dt_admissao,
    concederFerias.dt_nomeacao,
    concederFerias.desc_funcao,
    concederFerias.desc_regime_funcao,
    concederFerias.cod_regime_funcao,
    concederFerias.cod_funcao,
    concederFerias.cod_local,
    concederFerias.cod_orgao,
    concederFerias.bo_cadastradas,
    concederFerias.situacao,
    concederFerias.dt_inicial_aquisitivo,
    concederFerias.dt_final_aquisitivo,
    concederFerias.dt_inicio,
    concederFerias.dt_fim,
    concederFerias.mes_competencia,
    concederFerias.ano_competencia
HAVING
    CASE WHEN 'incluir' = 'incluir' THEN
        CASE WHEN sum(COALESCE (ferias.dias_ferias,
                    0)) + sum(COALESCE (ferias.dias_abono,
                    0)) < 30 THEN
            TRUE
        ELSE
            FALSE
        END
    ELSE
        TRUE
END
ORDER BY
    concederFerias.nom_cgm,
    concederFerias.dt_inicial_aquisitivo,
    concederFerias.dt_final_aquisitivo
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('stTipoFiltro', $stTipoFiltro);
        $query->bindValue('stValoresFiltro', $stValoresFiltro);
        $query->bindValue('inCodPeriodoMovimentacao', $inCodPeriodoMovimentacao);
        $query->bindValue('boFeriasVencidas', $boFeriasVencidas, \PDO::PARAM_BOOL);
        $query->bindValue('stEntidade', $stEntidade);
        $query->bindValue('stExercicio', $stExercicio);
        $query->bindValue('stAcao', $stAcao);
        $query->bindValue('inCodLote', $inCodLote);
        $query->bindValue('inCodRegime', $inCodRegime);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $stTipoFiltro
     * @param $stValoresFiltro
     * @param $inCodPeriodoMovimentacao
     * @param $stExercicio
     * @param $stAcao
     * @param string $stEntidade
     * @param bool $boFeriasVencidas
     * @param int $inCodLote
     * @param int $inCodRegime
     * @return array
     */
    public function concederFerias($stTipoFiltro, $stValoresFiltro, $inCodPeriodoMovimentacao, $stExercicio, $stAcao, $stEntidade = '', $boFeriasVencidas = false, $inCodLote = 0, $inCodRegime = 0)
    {
        $sql = <<<SQL
SELECT
    *
FROM
    concederFerias (:stTipoFiltro,
        :stValoresFiltro,
        :inCodPeriodoMovimentacao,
        :boFeriasVencidas,
        :stEntidade,
        :stExercicio,
        :stAcao,
        :inCodLote,
        :inCodRegime) AS concederFerias
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('stTipoFiltro', $stTipoFiltro);
        $query->bindValue('stValoresFiltro', $stValoresFiltro);
        $query->bindValue('inCodPeriodoMovimentacao', $inCodPeriodoMovimentacao);
        $query->bindValue('boFeriasVencidas', $boFeriasVencidas, \PDO::PARAM_BOOL);
        $query->bindValue('stEntidade', $stEntidade);
        $query->bindValue('stExercicio', $stExercicio);
        $query->bindValue('stAcao', $stAcao);
        $query->bindValue('inCodLote', $inCodLote);
        $query->bindValue('inCodRegime', $inCodRegime);

        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * Remove todos os buffers
     */
    public function removerTodosBuffers()
    {
        $sql = <<<SQL
SELECT
    removerTodosBuffers();
SQL;
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
    }

    /**
     * @param $inCodContrato
     * @param $inCodPeriodoMovimentacaoParametro
     * @param $stExercicioAtual
     * @param string $stEntidadeParametro
     * @return array
     */
    public function geraRegistroFerias($inCodContrato, $inCodPeriodoMovimentacaoParametro, $stExercicioAtual, $stEntidadeParametro = '')
    {
        $this->removerTodosBuffers();

        $sql = <<<SQL
SELECT
    geraRegistroFerias(:inCodContrato,
        :inCodPeriodoMovimentacaoParametro,
        :stExercicioAtual,
        :stEntidadeParametro) AS retorno;
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('inCodContrato', $inCodContrato, \PDO::PARAM_INT);
        $query->bindValue('inCodPeriodoMovimentacaoParametro', $inCodPeriodoMovimentacaoParametro, \PDO::PARAM_INT);
        $query->bindValue('stExercicioAtual', $stExercicioAtual, \PDO::PARAM_STR);
        $query->bindValue('stEntidadeParametro', $stEntidadeParametro, \PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getDadosRelatorioServidor(array $params)
    {
        $sql = "select
                    TO_CHAR(
                        dt_inicial_aquisitivo,
                        'dd/mm/yyyy'
                    ) as dt_inicial_aquisitivo,
                    TO_CHAR(
                        dt_final_aquisitivo,
                        'dd/mm/yyyy'
                    ) as dt_final_aquisitivo,
                    TO_CHAR(
                        dt_inicial_gozo,
                        'dd/mm/yyyy'
                    ) as dt_inicial_gozo,
                    TO_CHAR(
                        dt_final_gozo,
                        'dd/mm/yyyy'
                    ) as dt_final_gozo,
                    faltas,
                    dias_ferias as ferias,
                    dias_abono as abono,
                    mes_pagamento,
                    folha,
                    pagar_13
                from
                    relatorioHistoricoFerias(
                        '".$params['cod_entidade']."',
                        '".$params['exercicio']."',
                        '".$params['dataHoje']."',
                        '".$params['tipo']."',
                        '".$params['codContrato']."'
                    )";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
