<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Doctrine\ORM;
use Urbem\CoreBundle\Model\Economico\CadastroEconomicoModel;

/**
 * Class CadastroEconomicoRepository
 * @package Urbem\CoreBundle\Repository\Economico
 */
class CadastroEconomicoRepository extends ORM\EntityRepository
{
    /**
     * @param $params
     * @return array
     */
    public function findCadastrosEconomico($params)
    {
        $sql = "
            SELECT
                DISTINCT coalesce(
                    ef.numcgm,
                    ed.numcgm,
                    au.numcgm
                ) AS numcgm,
                ce.inscricao_economica,
                ce.timestamp,
                TO_CHAR(
                    ce.dt_abertura,
                    'dd/mm/yyyy'
                ) AS dt_abertura,
                cgm.nom_cgm,
                CASE
                    WHEN cast(
                        ef.numcgm AS VARCHAR
                    ) IS NOT NULL THEN '1'
                    WHEN cast(
                        au.numcgm AS VARCHAR
                    ) IS NOT NULL THEN '3'
                    WHEN cast(
                        ed.numcgm AS VARCHAR
                    ) IS NOT NULL THEN '2'
                END AS enquadramento,
                economico.fn_busca_sociedade(ce.inscricao_economica) AS sociedade
            FROM
                economico.cadastro_economico AS ce 
                LEFT JOIN economico.cadastro_economico_empresa_fato AS ef ON ce.inscricao_economica = ef.inscricao_economica
                LEFT JOIN economico.cadastro_economico_autonomo AS au ON ce.inscricao_economica = au.inscricao_economica
                LEFT JOIN economico.cadastro_economico_empresa_direito AS ed ON ce.inscricao_economica = ed.inscricao_economica
                LEFT JOIN (
                    SELECT
                        baixa_cadastro_economico.*
                    FROM economico.baixa_cadastro_economico INNER JOIN (
                        SELECT
                            max( timestamp ) AS timestamp,
                            inscricao_economica
                        FROM
                            economico.baixa_cadastro_economico
                        GROUP BY
                            inscricao_economica
                    ) AS tmp ON tmp.inscricao_economica = baixa_cadastro_economico.inscricao_economica
                    and tmp.timestamp = baixa_cadastro_economico.timestamp
                ) AS ba ON ce.inscricao_economica = ba.inscricao_economica,
                sw_cgm AS cgm
            WHERE
                COALESCE (
                    ef.numcgm,
                    ed.numcgm,
                    au.numcgm
                )= cgm.numcgm
                AND CASE
                    WHEN ba.inscricao_economica IS NOT NULL THEN CASE
                        WHEN ba.dt_termino IS NOT NULL THEN true
                        ELSE false
                    END
                    ELSE true
                END";

        if (is_array($params) and count($params) > 0) {
            $sql .= " AND cgm.numcgm = :numcgm";
        }

        $sql .= " ORDER BY ce.inscricao_economica";

        $query = $this->_em->getConnection()->prepare($sql);

        if (is_array($params) and count($params) > 0) {
            $query->bindValue('numcgm', $params['numcgm'], \PDO::PARAM_INT);
        }

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $params
     * @return array|void
     */
    public function getCadastroEconomicoReport($params)
    {
        if (!is_array($params) and !count($params)) {
            return;
        }

        $sql = " SELECT DISTINCT ";
        $sql .= "     ce.inscricao_economica, ";

        if (!isset($params['tipoInscricao'])) {
            $sql .= "  coalesce ( ef.numcgm, ed.numcgm, au.numcgm ) as numcgm_empresa, ";
        } else {
            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_AUTONOMO_TYPE) {
                $sql .= "  au.numcgm as numcgm_empresa,                         ";
            }

            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_DIREITO_TYPE) {
                $sql .= "  ed.numcgm as numcgm_empresa,                         ";
            }

            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_FATO_TYPE) {
                $sql .= "  ef.numcgm as numcgm_empresa,                         ";
            }
        }

        $sql .= "     CASE WHEN ba.dt_inicio IS NOT NULL THEN
                        CASE WHEN ba.dt_termino IS NOT NULL THEN
                            'Ativo'
                        ELSE
                            'Baixado'
                        END
                    ELSE
                        'Ativo'
                    END AS situacao_cadastro,                                                       ";
        $sql .= "     cgm.nom_cgm as nome,                                                            ";
        $sql .= "     cgmf.cpf,                                                                       ";
        $sql .= "     cgmj.cnpj,                                                                      ";
        $sql .= "     cerc.numcgm as cgm_contador,                                                    ";
        $sql .= "     cerc.nom_cgm as nom_contador,                                                   ";
        $sql .= "     ce.dt_abertura as inicio,                                                       ";
        $sql .= "     TO_CHAR( ce.dt_abertura, 'DD/MM/YYYY') as inicio_br,                            ";
        $sql .= "     arrecadacao.fn_consulta_endereco_empresa( ce.inscricao_economica) as endereco   ";
        $sql .= "     , cerc.numcgm                                                                   ";

        if (!isset($params['tipoInscricao'])) {
            $sql .= " ,case                                                                           ";
            $sql .= " when                                                                            ";
            $sql .= "     cast( ef.numcgm as varchar) is not null                                     ";
            $sql .= "     then 'Empresa de Fato'                                                      ";
            $sql .= " when                                                                            ";
            $sql .= "     cast( ed.numcgm as varchar) is not null                                     ";
            $sql .= "     then 'Empresa de Direito'                                                   ";
            $sql .= " when                                                                            ";
            $sql .= "     cast( au.numcgm as varchar) is not null                                     ";
            $sql .= "     then 'Autonomo'                                                             ";
            $sql .= " end as tipoEmpresa                                                              ";
            $sql .= " , coalesce ( ed.nom_categoria, null ) as nom_categoria                          ";
        } else {
            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_AUTONOMO_TYPE) {
                $sql .= " ,'Autonomo' as tipoEmpresa            ";
            }

            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_DIREITO_TYPE) {
                $sql .= "  ,'Empresa de Direito' as tipoEmpresa ,coalesce ( ed.nom_categoria, null ) as nom_categoria ";
            }

            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_FATO_TYPE) {
                $sql .= "  ,'Empresa de Fato' as tipoEmpresa        ";
            }
        }

        $sql .= " , economico.fn_busca_sociedade(ce.inscricao_economica) as sociedade                 ";

        $sql .= " FROM                                                                                ";
        $sql .= "     economico.cadastro_economico as ce                                              ";

        $sql .= " LEFT JOIN
                   (
                    SELECT
                        T.*,
                        COALESCE( confrontacao_trecho.cod_logradouro, di.cod_logradouro ) AS cod_logradouro
                    FROM
                        (
                            SELECT
                                max(tmp.timestamp) AS timestamp,
                                tmp.inscricao_economica
                            FROM
                                (
                                    SELECT
                                        timestamp,
                                        inscricao_economica

                                    FROM
                                        economico.domicilio_fiscal

                                UNION
                                    SELECT
                                        timestamp,
                                        inscricao_economica

                                    FROM
                                        economico.domicilio_informado
                                )AS tmp
                            GROUP BY
                                tmp.inscricao_economica
                        )AS T

                    LEFT JOIN
                        economico.domicilio_informado AS di
                    ON
                        T.inscricao_economica = di.inscricao_economica
                        AND T.timestamp = di.timestamp

                    LEFT JOIN
                        economico.domicilio_fiscal AS df
                    ON
                        T.inscricao_economica = df.inscricao_economica
                        AND T.timestamp = df.timestamp

                    LEFT JOIN
                        imobiliario.imovel_confrontacao
                    ON
                        imovel_confrontacao.inscricao_municipal = df.inscricao_municipal

                    LEFT JOIN
                        imobiliario.confrontacao_trecho
                    ON
                        confrontacao_trecho.cod_lote = imovel_confrontacao.cod_lote
                        AND confrontacao_trecho.cod_confrontacao = imovel_confrontacao.cod_confrontacao
                   )AS logradouro
            ON
                logradouro.inscricao_economica = ce.inscricao_economica
    ";

        if (isset($params['socio'])) {
            $sql .= " INNER JOIN economico.sociedade as cesocio ON cesocio.inscricao_economica = ce.inscricao_economica   ";
        }

        if (isset($params['atividadeDe']) || isset($params['atividadeAte']) || isset($params['numeroLicencaDe']) || isset($params['numeroLicencaAte'])) {
            $sql .= " INNER JOIN economico.atividade_cadastro_economico as eace ON eace.inscricao_economica = ce.inscricao_economica

        INNER JOIN
            (
                SELECT
                    tmp1.*
                FROM
                    economico.atividade AS tmp1

                INNER JOIN
                    (
                        SELECT
                            max(timestamp) AS timestamp,
                            cod_atividade,
                            cod_vigencia
                        FROM
                            economico.atividade
                        GROUP BY
                            cod_atividade,
                            cod_vigencia
                    )AS tmp2
                ON
                    tmp1.cod_atividade = tmp2.cod_atividade
                    AND tmp1.cod_vigencia = tmp2.cod_vigencia
                    AND tmp1.timestamp = tmp2.timestamp

                WHERE
                    tmp1.cod_vigencia = (
                        SELECT
                            cod_vigencia
                        FROM
                            economico.vigencia_atividade
                        WHERE
                            dt_inicio <= now()::date
                        ORDER BY
                            timestamp DESC
                        LIMIT 1
                    )
            )AS atividade
        ON
            atividade.cod_atividade = eace.cod_atividade
        ";

            if (isset($params['numeroLicencaDe']) || isset($params['numeroLicencaAte'])) {
                $sql .= "
                INNER JOIN (
                    SELECT
                        COALESCE( licenca_atividade.cod_licenca, licenca_especial.cod_licenca ) AS cod_licenca,
                        COALESCE( licenca_atividade.exercicio, licenca_especial.exercicio ) AS exercicio,
                        atividade_cadastro_economico.cod_atividade,
                        atividade_cadastro_economico.ocorrencia_atividade,
                        atividade_cadastro_economico.inscricao_economica

                    FROM
                        economico.atividade_cadastro_economico

                    LEFT JOIN
                        economico.licenca_atividade
                    ON
                        licenca_atividade.cod_atividade = atividade_cadastro_economico.cod_atividade
                        AND licenca_atividade.ocorrencia_atividade = atividade_cadastro_economico.ocorrencia_atividade
                        AND licenca_atividade.inscricao_economica = atividade_cadastro_economico.inscricao_economica

                    LEFT JOIN
                        economico.licenca_especial
                    ON
                        licenca_especial.cod_atividade = atividade_cadastro_economico.cod_atividade
                        AND licenca_especial.ocorrencia_atividade = atividade_cadastro_economico.ocorrencia_atividade
                        AND licenca_especial.inscricao_economica = atividade_cadastro_economico.inscricao_economica

                    WHERE
                        ( licenca_especial.cod_atividade IS NOT NULL OR licenca_atividade.cod_atividade IS NOT NULL )

                )AS elic
                ON
                    elic.cod_atividade = eace.cod_atividade
                    AND elic.ocorrencia_atividade = eace.ocorrencia_atividade
                    AND elic.inscricao_economica = eace.inscricao_economica ";
            }
        }

        $sql .= " LEFT JOIN                                                                          ";
        $sql .= " ( SELECT                                                                            ";
        $sql .= "     cerc.*, cgm.nom_cgm                                                             ";
        $sql .= "   FROM                                                                              ";
        $sql .= "     economico.cadastro_econ_resp_contabil as cerc                                   ";
        $sql .= "     INNER JOIN sw_cgm as cgm ON cerc.numcgm = cgm.numcgm                            ";
        $sql .= " ) as cerc ON cerc.inscricao_economica = ce.inscricao_economica                      ";

        if (!isset($params['tipoInscricao'])) {
            $sql .= " LEFT JOIN economico.cadastro_economico_empresa_fato as ef                       ";
            $sql .= " ON ce.inscricao_economica = ef.inscricao_economica                              ";

            $sql .= " LEFT JOIN economico.cadastro_economico_autonomo as au                           ";
            $sql .= " ON ce.inscricao_economica = au.inscricao_economica                              ";

            $sql .= " LEFT JOIN                                                                       ";
            $sql .= " ( select ed.inscricao_economica, ed.numcgm, cat.nom_categoria                   ";
            $sql .= "   from                                                                          ";
            $sql .= "   economico.cadastro_economico_empresa_direito as ed                            ";
            $sql .= "   INNER JOIN economico.categoria as cat ON cat.cod_categoria = ed.cod_categoria ";
            $sql .= " ) as ed  ON ce.inscricao_economica = ed.inscricao_economica                     ";
        } else {
            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_AUTONOMO_TYPE) {
                $sql .= " INNER JOIN economico.cadastro_economico_autonomo as au  ON au.inscricao_economica = ce.inscricao_economica ";
            } elseif ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_FATO_TYPE) {
                $sql .= " INNER JOIN economico.cadastro_economico_empresa_fato as ef ON ef.inscricao_economica = ce.inscricao_economica ";
            } elseif ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_DIREITO_TYPE) {
                $sql .= " INNER JOIN                                                                      ";
                $sql .= " ( select ed.inscricao_economica, ed.numcgm, cat.nom_categoria                   ";
                $sql .= " from                                                                            ";
                $sql .= " economico.cadastro_economico_empresa_direito as ed                              ";
                $sql .= " INNER JOIN economico.categoria as cat ON cat.cod_categoria = ed.cod_categoria   ";
                $sql .= " ) as ed  ON ce.inscricao_economica = ed.inscricao_economica                     ";
            }
        }

        $sql .= " LEFT JOIN (        SELECT
                            tmp2.*
                        FROM
                            economico.baixa_cadastro_economico AS tmp2
                        INNER JOIN
                            (
                                SELECT
                                    max(tmp.timestamp) AS timestamp,
                                    tmp.inscricao_economica
                                FROM
                                    economico.baixa_cadastro_economico AS tmp
                                GROUP BY
                                    inscricao_economica
                            )AS tmp
                        ON
                            tmp.timestamp = tmp2.timestamp
                            AND tmp.inscricao_economica = tmp2.inscricao_economica) as ba                 ";
        $sql .= " ON ce.inscricao_economica = ba.inscricao_economica                                      ";
        $sql .= " , sw_cgm as cgm                                                                         ";
        $sql .= " LEFT JOIN sw_cgm_pessoa_fisica as cgmf ON cgm.numcgm = cgmf.numcgm                      ";
        $sql .= " LEFT JOIN sw_cgm_pessoa_juridica as cgmj ON cgm.numcgm = cgmj.numcgm                    ";

        $where = '';
        if (!isset($params['tipoInscricao'])) {
            $where .= "  WHERE   coalesce ( ef.numcgm, ed.numcgm, au.numcgm ) = cgm.numcgm                 ";
        } else {
            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_AUTONOMO_TYPE) {
                $where .= "  WHERE   au.numcgm = cgm.numcgm                           ";
            }

            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_DIREITO_TYPE) {
                $where .= "  WHERE   ed.numcgm = cgm.numcgm                            ";
            }

            if ($params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_FATO_TYPE) {
                $where .= "  WHERE   ef.numcgm = cgm.numcgm                            ";
            }
        }

        if (isset($params['tipoInscricao']) && $params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_FATO_TYPE) {
            $where .= " AND ef.numcgm is not null ";
        } elseif (isset($params['tipoInscricao']) && $params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_DIREITO_TYPE) {
            $where .= " AND ed.numcgm is not null ";
        } elseif (isset($params['tipoInscricao']) && $params['tipoInscricao'] == CadastroEconomicoModel::INSCRICAO_AUTONOMO_TYPE) {
            $where .= " AND au.numcgm is not null ";
        }

        if (isset($params['socio'])) {
            $where .= sprintf(" AND cesocio.numcgm  = %d", $params['socio']);
        }

        if (isset($params['codigoLogradouroDe']) && isset($params['codigoLogradouroAte'])) {
            $where .= sprintf(" AND logradouro.cod_logradouro BETWEEN %d AND %d ", $params['codigoLogradouroDe'], $params['codigoLogradouroAte']);
        } elseif (isset($params['codigoLogradouroDe'])) {
            $where .= sprintf(" AND logradouro.cod_logradouro = %d ", $params['codigoLogradouroDe']);
        } elseif (isset($params['codigoLogradouroAte'])) {
            $where .= sprintf(" AND logradouro.cod_logradouro = %d ", $params['codigoLogradouroAte']);
        }

        if (isset($params['inscricaoEconomicaDe']) && isset($params['inscricaoEconomicaAte'])) {
            $where .= sprintf(" AND ce.inscricao_economica BETWEEN %d AND %d ", $params['inscricaoEconomicaDe'], $params['inscricaoEconomicaAte']);
        } elseif (isset($params['inscricaoEconomicaDe'])) {
            $where .= sprintf(" AND ce.inscricao_economica = %d ", $params['inscricaoEconomicaDe']);
        } elseif (isset($params['inscricaoEconomicaAte'])) {
            $where .= sprintf(" AND ce.inscricao_economica = %d ", $params['inscricaoEconomicaAte']);
        }

        if (isset($params['atividadeDe']) && isset($params['atividadeAte'])) {
            $where .= sprintf(" AND atividade.cod_estrutural BETWEEN '%s' AND '%s' ", $params['atividadeDe'], $params['atividadeAte']);
        } elseif (isset($params['atividadeDe'])) {
            $where .= sprintf(" AND atividade.cod_estrutural = '%s' ", $params['atividadeDe']);
        } elseif (isset($params['atividadeAte'])) {
            $where .= sprintf(" AND atividade.cod_estrutural = '%s' ", $params['atividadeAte']);
        }

        if (isset($params['numeroLicencaDe']) && isset($params['numeroLicencaAte'])) {
            $where .= sprintf(" AND elic.cod_licenca BETWEEN %d AND %d ", $params['numeroLicencaDe'], $params['numeroLicencaAte']);
        } elseif (isset($params['numeroLicencaDe'])) {
            $where .= sprintf(" AND elic.cod_licenca = %d ", $params['numeroLicencaDe']);
        } elseif (isset($params['numeroLicencaAte'])) {
            $where .= sprintf(" AND elic.cod_licenca = %d ", $params['numeroLicencaAte']);
        }

        if (isset($params['dtInicio'])) {
            $where .= sprintf(" AND ce.dt_abertura = '%s'", $params['dtInicio']);
        }

        $sql .= $where . " ORDER BY ce.inscricao_economica, ce.dt_abertura";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
