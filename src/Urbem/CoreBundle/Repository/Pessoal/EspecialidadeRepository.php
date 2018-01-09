<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;

class EspecialidadeRepository extends ORM\EntityRepository
{
    /**
     * Retorna a lista de de especialidades por cargo e subdivisao
     *
     * @param array $params
     *
     * @return array
     */
    public function findEspecialidadeCargoSubDivisao(array $params = array())
    {
        $sql = <<<SQL
SELECT
    cargo.cod_cargo AS cod_cargo,
    cargo.descricao AS descricao,
    cargo.cargo_cc,
    cargo.funcao_gratificada,
    esp.cod_especialidade,
    esp.descricao AS descricao_especialidade, (
        SELECT
            codigo
        FROM
            pessoal.cbo
        WHERE
            cod_cbo = esp.cod_cbo) AS cbo_especialidade, esp.cod_cbo AS cod_cbo_especialidade, esp.cod_padrao AS cod_padrao_especialidade, esp.timestamp_padrao_padrao, esp.cod_sub_divisao, esp.vagas_ocupadas, esp.nro_vaga_criada, esp.cod_norma AS norma_maxima, esp.timestamp_especialidade_sub_divisao, esp.cod_tipo_norma AS cod_tipo_norma_especialidade, esp.cod_regime, esp.descricao_regime AS nom_regime, esp.descricao_sub_divisao AS nom_sub_divisao, (
            SELECT
                PESDMIN.cod_norma
            FROM
                pessoal.especialidade_sub_divisao PESDMIN, (
                    SELECT
                        min(TIMESTAMP) AS TIMESTAMP,
                        cod_especialidade,
                        cod_sub_divisao
                    FROM
                        pessoal.especialidade_sub_divisao
                    GROUP BY
                        cod_especialidade,
                        cod_sub_divisao) AS max_PESDMIN
                WHERE
                    PESDMIN.cod_especialidade = esp.cod_especialidade
                    AND PESDMIN.cod_sub_divisao = esp.cod_sub_divisao
                    AND PESDMIN.timestamp = max_PESDMIN.timestamp
                    AND PESDMIN.cod_especialidade = max_PESDMIN.cod_especialidade
                    AND PESDMIN.cod_sub_divisao = max_PESDMIN.cod_sub_divisao) AS norma_minima, esp.horas_mensais, esp.horas_semanais, esp.valor, esp.cod_padrao
            FROM
                pessoal.cargo AS cargo
            LEFT JOIN (
                SELECT
                    especialidade.cod_especialidade,
                    especialidade.cod_cargo,
                    especialidade.descricao,
                    cbo_especialidade.cod_cbo,
                    getVagasOcupadasEspecialidade (regime.cod_regime,
                        sub_divisao.cod_sub_divisao,
                        especialidade.cod_especialidade,
                        0,
                        TRUE,
                        '') AS vagas_ocupadas,
                    especialidade_sub_divisao.nro_vaga_criada,
                    especialidade_sub_divisao.timestamp AS timestamp_especialidade_sub_divisao,
                    padrao.cod_padrao,
                    padrao.horas_mensais,
                    padrao.horas_semanais,
                    padrao_padrao.timestamp AS timestamp_padrao_padrao,
                    padrao_padrao.valor,
                    norma.cod_norma,
                    norma.cod_tipo_norma,
                    sub_divisao.cod_sub_divisao,
                    sub_divisao.descricao AS descricao_sub_divisao,
                    regime.descricao AS descricao_regime,
                    regime.cod_regime
                FROM
                    pessoal.especialidade,
                    pessoal.especialidade_padrao, (
                        SELECT
                            cod_especialidade,
                            max(TIMESTAMP) AS TIMESTAMP
                        FROM
                            pessoal.especialidade_padrao
                        GROUP BY
                            cod_especialidade) AS max_espepecialidade_padrao,
                        pessoal.especialidade_sub_divisao, (
                            SELECT
                                cod_especialidade,
                                max(TIMESTAMP) AS TIMESTAMP
                            FROM
                                pessoal.especialidade_sub_divisao
                            GROUP BY
                                cod_especialidade) AS max_especialidade_subdivisao,
                            normas.norma,
                            pessoal.sub_divisao,
                            pessoal.regime,
                            folhapagamento.padrao,
                            folhapagamento.padrao_padrao, (
                                SELECT
                                    cod_padrao,
                                    max(TIMESTAMP) AS TIMESTAMP
                                FROM
                                    folhapagamento.padrao_padrao
                                GROUP BY
                                    cod_padrao) AS max_padrao_padrao,
                                pessoal.cbo_especialidade, (
                                    SELECT
                                        cod_especialidade,
                                        max(TIMESTAMP) AS TIMESTAMP
                                    FROM
                                        pessoal.cbo_especialidade
                                    GROUP BY
                                        cod_especialidade) AS max_cbo_especialidade
                                WHERE
                                    especialidade.cod_especialidade = especialidade_padrao.cod_especialidade
                                    AND especialidade_padrao.cod_especialidade = max_espepecialidade_padrao.cod_especialidade
                                    AND especialidade_padrao.timestamp = max_espepecialidade_padrao.timestamp
                                    AND especialidade.cod_especialidade = especialidade_sub_divisao.cod_especialidade
                                    AND especialidade_sub_divisao.cod_especialidade = max_especialidade_subdivisao.cod_especialidade
                                    AND especialidade_sub_divisao.timestamp = max_especialidade_subdivisao.timestamp
                                    AND especialidade_sub_divisao.cod_norma = norma.cod_norma
                                    AND especialidade_sub_divisao.cod_sub_divisao = sub_divisao.cod_sub_divisao
                                    AND sub_divisao.cod_regime = regime.cod_regime
                                    AND especialidade_padrao.cod_padrao = padrao.cod_padrao
                                    AND padrao.cod_padrao = padrao_padrao.cod_padrao
                                    AND padrao_padrao.cod_padrao = max_padrao_padrao.cod_padrao
                                    AND padrao_padrao.timestamp = max_padrao_padrao.timestamp
                                    AND especialidade.cod_especialidade = cbo_especialidade.cod_especialidade
                                    AND cbo_especialidade.cod_especialidade = max_cbo_especialidade.cod_especialidade
                                    AND cbo_especialidade.timestamp = max_cbo_especialidade.timestamp
                                    AND sub_divisao.cod_sub_divisao = :cod_sub_divisao) AS esp ON esp.cod_cargo = cargo.cod_cargo
                            WHERE
                                cargo.cod_cargo = :cod_cargo
                                AND esp.cod_especialidade IS NOT NULL
                            ORDER BY
                                descricao_especialidade, cod_cargo, esp.cod_especialidade, esp.cod_sub_divisao
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param  integer $inCodRegime
     * @param  integer $inCodSubDivisao
     * @param  integer $inCodEspecialidade
     * @param  integer $inCodPeriodoMovimentacao
     * @param  boolean $boLiberaVagaMesRescisao
     * @param  string  $stEntidade
     *
     * @return integer
     */
    public function getVagasDisponiveisEspecialidade($inCodRegime, $inCodSubDivisao, $inCodEspecialidade, $inCodPeriodoMovimentacao = 0, $boLiberaVagaMesRescisao = true, $stEntidade = '')
    {
        $sql = <<<SQL
SELECT
    getVagasDisponiveisEspecialidade (:inCodRegime,
        :inCodSubDivisao,
        :inCodEspecialidade,
        :inCodPeriodoMovimentacao,
        :boLiberaVagaMesRescisao,
        :stEntidade) AS vagas
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('inCodRegime', $inCodRegime);
        $query->bindValue('inCodSubDivisao', $inCodSubDivisao);
        $query->bindValue('inCodEspecialidade', $inCodEspecialidade);
        $query->bindValue('inCodPeriodoMovimentacao', $inCodPeriodoMovimentacao);
        $query->bindValue('boLiberaVagaMesRescisao', $boLiberaVagaMesRescisao);
        $query->bindValue('stEntidade', $stEntidade);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->vagas;
    }

    /**
     * @param $stFiltro
     *
     * @return array
     */
    public function findEspecialidadeCargo($stFiltro)
    {
        $sql = "
SELECT
    cargo.cod_cargo AS cod_cargo,
    cargo.descricao AS descricao,
    cargo.cargo_cc,
    cargo.funcao_gratificada,
    esp.cod_especialidade,
    esp.descricao AS descricao_especialidade, (
        SELECT
            codigo
        FROM
            pessoal.cbo
        WHERE
            cod_cbo = esp.cod_cbo) AS cbo_especialidade, esp.cod_cbo AS cod_cbo_especialidade, esp.cod_padrao AS cod_padrao_especialidade, esp.timestamp_padrao_padrao, esp.cod_sub_divisao, esp.vagas_ocupadas, esp.nro_vaga_criada, esp.cod_norma AS norma_maxima, esp.timestamp_especialidade_sub_divisao, esp.cod_tipo_norma AS cod_tipo_norma_especialidade, esp.cod_regime, esp.descricao_regime AS nom_regime, esp.descricao_sub_divisao AS nom_sub_divisao, (
            SELECT
                PESDMIN.cod_norma
            FROM
                pessoal.especialidade_sub_divisao PESDMIN, (
                    SELECT
                        min(TIMESTAMP) AS TIMESTAMP,
                        cod_especialidade,
                        cod_sub_divisao
                    FROM
                        pessoal.especialidade_sub_divisao
                    GROUP BY
                        cod_especialidade,
                        cod_sub_divisao) AS max_PESDMIN
                WHERE
                    PESDMIN.cod_especialidade = esp.cod_especialidade
                    AND PESDMIN.cod_sub_divisao = esp.cod_sub_divisao
                    AND PESDMIN.timestamp = max_PESDMIN.timestamp
                    AND PESDMIN.cod_especialidade = max_PESDMIN.cod_especialidade
                    AND PESDMIN.cod_sub_divisao = max_PESDMIN.cod_sub_divisao) AS norma_minima, esp.horas_mensais, esp.horas_semanais, esp.valor, esp.cod_padrao
            FROM
                pessoal.cargo AS cargo
            LEFT JOIN (
                SELECT
                    especialidade.cod_especialidade,
                    especialidade.cod_cargo,
                    especialidade.descricao,
                    cbo_especialidade.cod_cbo,
                    getVagasOcupadasEspecialidade (regime.cod_regime,
                        sub_divisao.cod_sub_divisao,
                        especialidade.cod_especialidade,
                        0,
                        TRUE,
                        '') AS vagas_ocupadas,
                    especialidade_sub_divisao.nro_vaga_criada,
                    especialidade_sub_divisao.timestamp AS timestamp_especialidade_sub_divisao,
                    padrao.cod_padrao,
                    padrao.horas_mensais,
                    padrao.horas_semanais,
                    padrao_padrao.timestamp AS timestamp_padrao_padrao,
                    padrao_padrao.valor,
                    norma.cod_norma,
                    norma.cod_tipo_norma,
                    sub_divisao.cod_sub_divisao,
                    sub_divisao.descricao AS descricao_sub_divisao,
                    regime.descricao AS descricao_regime,
                    regime.cod_regime
                FROM
                    pessoal.especialidade,
                    pessoal.especialidade_padrao, (
                        SELECT
                            cod_especialidade,
                            max(TIMESTAMP) AS TIMESTAMP
                        FROM
                            pessoal.especialidade_padrao
                        GROUP BY
                            cod_especialidade) AS max_espepecialidade_padrao,
                        pessoal.especialidade_sub_divisao, (
                            SELECT
                                cod_especialidade,
                                max(TIMESTAMP) AS TIMESTAMP
                            FROM
                                pessoal.especialidade_sub_divisao
                            GROUP BY
                                cod_especialidade) AS max_especialidade_subdivisao,
                            normas.norma,
                            pessoal.sub_divisao,
                            pessoal.regime,
                            folhapagamento.padrao,
                            folhapagamento.padrao_padrao, (
                                SELECT
                                    cod_padrao,
                                    max(TIMESTAMP) AS TIMESTAMP
                                FROM
                                    folhapagamento.padrao_padrao
                                GROUP BY
                                    cod_padrao) AS max_padrao_padrao,
                                pessoal.cbo_especialidade, (
                                    SELECT
                                        cod_especialidade,
                                        max(TIMESTAMP) AS TIMESTAMP
                                    FROM
                                        pessoal.cbo_especialidade
                                    GROUP BY
                                        cod_especialidade) AS max_cbo_especialidade
                                WHERE
                                    especialidade.cod_especialidade = especialidade_padrao.cod_especialidade
                                    AND especialidade_padrao.cod_especialidade = max_espepecialidade_padrao.cod_especialidade
                                    AND especialidade_padrao.timestamp = max_espepecialidade_padrao.timestamp
                                    AND especialidade.cod_especialidade = especialidade_sub_divisao.cod_especialidade
                                    AND especialidade_sub_divisao.cod_especialidade = max_especialidade_subdivisao.cod_especialidade
                                    AND especialidade_sub_divisao.timestamp = max_especialidade_subdivisao.timestamp
                                    AND especialidade_sub_divisao.cod_norma = norma.cod_norma
                                    AND especialidade_sub_divisao.cod_sub_divisao = sub_divisao.cod_sub_divisao
                                    AND sub_divisao.cod_regime = regime.cod_regime
                                    AND especialidade_padrao.cod_padrao = padrao.cod_padrao
                                    AND padrao.cod_padrao = padrao_padrao.cod_padrao
                                    AND padrao_padrao.cod_padrao = max_padrao_padrao.cod_padrao
                                    AND padrao_padrao.timestamp = max_padrao_padrao.timestamp
                                    AND especialidade.cod_especialidade = cbo_especialidade.cod_especialidade
                                    AND cbo_especialidade.cod_especialidade = max_cbo_especialidade.cod_especialidade
                                    AND cbo_especialidade.timestamp = max_cbo_especialidade.timestamp
                                   ) AS esp ON esp.cod_cargo = cargo.cod_cargo
                            WHERE 1 = 1 ";

        if (is_numeric($stFiltro)) {
            $sql .= "
             AND cargo.cod_cargo = :cod_cargo AND esp.cod_especialidade IS NOT NULL
            ";
        } else {
            $sql .= "
            AND lower (cargo.descricao)
            LIKE lower (:filtro)
            || '%'
            ";
        }
        $sql .= "ORDER BY
                    descricao_especialidade, cod_cargo, esp.cod_especialidade, esp.cod_sub_divisao";

        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($stFiltro)) {
            $query->bindValue(":cod_cargo", $stFiltro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . $stFiltro . "%", \PDO::PARAM_STR);
        }

        $query->execute();

        return $query->fetchAll();
    }

    public function findCargoSubDivisaoRegime($filter)
    {
        $sql = "
            SELECT *
            FROM (
                  SELECT
                       PC.cod_cargo,
                       PC.descricao,
                       PS.cod_sub_divisao,
                       PR.descricao as sub_divisao_descricao,
                       PR.cod_regime,
                       PI.descricao as regime_descricao,
                       false as especialidade
                  FROM pessoal.cargo as PC,
                       pessoal.cargo_sub_divisao as PS,
                       pessoal.sub_divisao as PR,
                       pessoal.regime as PI,
                       (
                         SELECT cod_cargo,
                                cod_sub_divisao,
                                max(timestamp) as timestamp
                         FROM pessoal.cargo_sub_divisao
                         GROUP BY cod_cargo, cod_sub_divisao
                       ) as max_PS
                  WHERE PC.cod_cargo = PS.cod_cargo
                       AND PS.cod_cargo = max_PS.cod_cargo
                       AND PS.cod_sub_divisao = max_PS.cod_sub_divisao
                       AND PS.timestamp = max_PS.timestamp
                       AND PR.cod_sub_divisao = max_PS.cod_sub_divisao
                       AND PI.cod_regime = PR.cod_regime
                  UNION
                  SELECT
                       PC.cod_cargo,
                       PC.descricao,
                       PES.cod_sub_divisao,
                       PR.descricao as sub_divisao_descricao,
                       PR.cod_regime,
                       PI.descricao as regime_descricao,
                       true as especialidade
                  FROM pessoal.cargo as PC,
                       pessoal.especialidade_sub_divisao as PES,
                       pessoal.sub_divisao as PR,
                       pessoal.regime as PI,
                       (
                         SELECT cod_especialidade,
                                cod_sub_divisao,
                                max(timestamp) as timestamp
                         FROM pessoal.especialidade_sub_divisao
                         GROUP BY cod_especialidade, cod_sub_divisao
                       ) as max_PES,
                       pessoal.especialidade as PE
                  WHERE PC.cod_cargo = PE.cod_cargo
                        AND PE.cod_especialidade = PES.cod_especialidade
                        AND PES.cod_especialidade = max_PES.cod_especialidade
                        AND PES.cod_sub_divisao = max_PES.cod_sub_divisao
                        AND PES.timestamp = max_PES.timestamp
                        AND PR.cod_sub_divisao = max_PES.cod_sub_divisao
                        AND PI.cod_regime = PR.cod_regime
            ) as tabela
            WHERE 1 = 1
        ";

        if (is_numeric($filter)) {
            $sql .= " AND cod_cargo = :cod_cargo";
        } else {
            $sql .= " AND LOWER(descricao) LIKE LOWER(:descricao) || '%'";
        }

        $sql .= " ORDER BY descricao";

        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($filter)) {
            $query->bindValue(":cod_cargo", $filter, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":descricao", "%" . $filter . "%", \PDO::PARAM_STR);
        }

        $query->execute();

        return $query->fetchAll();
    }
}
