<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class LicencaRepository
 * @package Urbem\CoreBundle\Repository\Economico
 */
class LicencaRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return int
     */
    public function getLastLicencaByExercicio($exercicio)
    {
        $result = $this->nextVal('cod_Licenca', ['exercicio' => $exercicio]);
        return (!$result) ? 1 : $result;
    }

    /**
     * @param int $inscricaoEconomica
     * @return array
     */
    public function getLicencasByInscricaoEconomica($inscricaoEconomica)
    {
        $query = "
        	SELECT
				l.cod_licenca,
				TO_CHAR(l.dt_inicio,'DD/MM/YYYY') AS dt_inicio,
				TO_CHAR(l.dt_termino,'DD/MM/YYYY') AS dt_termino,
				economico.fn_consulta_situacao_licenca(l.cod_licenca, l.exercicio) AS situacao,
				economico.fn_consulta_processo_licenca(l.cod_licenca, l.exercicio) AS processo,
				TO_CHAR(bl.dt_inicio , 'DD/MM/YYYY') AS baixa_inicio,
				TO_CHAR(bl.dt_termino, 'DD/MM/YYYY') AS baixa_termino,
				bl.motivo,
				LPAD( l.exercicio, 4, '0')::varchar AS exercicio,
				CASE
					WHEN lca.inscricao_economica IS NOT NULL
						THEN
				    		'Atividade'::varchar
					WHEN lce.inscricao_economica IS NOT NULL
						THEN
				    	'Especial'::varchar
					ELSE
						NULL
				END AS especie_licenca,
				eld.cod_documento,
				eld.cod_tipo_documento,
				amd.nome_documento,
				amd.nome_arquivo_agt AS nome_arquivo_template,
				COALESCE(lca.ocorrencia_licenca, lce.ocorrencia_licenca) AS ocorrencia_licenca,
				MAX(eace.ocorrencia_atividade) AS ocorrencia_atividade
			FROM
				economico.licenca l
			LEFT JOIN
					economico.baixa_licenca bl
				ON
					bl.cod_licenca = l.cod_licenca
					AND bl.exercicio   = l.exercicio
					AND bl.dt_inicio <= NOW()::date
					AND
						CASE
							WHEN bl.dt_termino IS NOT NULL
								THEN
				     				bl.dt_termino >= NOW()::date
				 			ELSE
				 				true::boolean
				 		END
			LEFT JOIN
					economico.licenca_atividade lca
				ON
					lca.cod_licenca = l.cod_licenca
					AND lca.exercicio = l.exercicio
			LEFT JOIN
					economico.atividade_cadastro_economico AS eace
				ON
					eace.inscricao_economica = lca.inscricao_economica
					AND eace.cod_atividade = lca.cod_atividade
					AND eace.principal = true
			LEFT JOIN
					economico.licenca_especial lce
				ON
					lce.cod_licenca = l.cod_licenca
					AND lce.exercicio = l.exercicio
			LEFT JOIN
					economico.licenca_documento AS eld
				ON
					eld.cod_licenca = l.cod_licenca
					AND eld.exercicio = l.exercicio
			LEFT JOIN
					administracao.modelo_documento AS amd
				ON
					amd.cod_tipo_documento = eld.cod_tipo_documento
					AND amd.cod_documento = eld.cod_documento
			WHERE
				COALESCE(lca.inscricao_economica, lce.inscricao_economica) = ?
			GROUP BY
			    l.cod_licenca,
			    l.dt_inicio,
			    l.dt_termino,
			    l.exercicio,
			    bl.dt_inicio,
			    bl.dt_termino,
			    bl.motivo,
			    eld.cod_documento,
			    eld.cod_tipo_documento,
			    amd.nome_documento,
			    amd.nome_arquivo_agt,
			    lca.inscricao_economica,
			    lce.inscricao_economica,
			    lca.ocorrencia_licenca,
			    lce.ocorrencia_licenca,
			    eld.timestamp

			ORDER BY eld.timestamp DESC";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->execute([$inscricaoEconomica]);

        return $sth->fetchAll();
    }

    /**
     * @param $params
     * @return array
     */
    public function getLicencaAlvara($params)
    {
        $sql = "
            SELECT
                licenca.cod_licenca::VARCHAR || '/' || lpad(licenca.exercicio, 4, '0')::VARCHAR AS licenca,
                CASE
                    WHEN li_atividade.cod_licenca IS NOT NULL THEN li_atividade.inscricao_economica
                    WHEN li_especial.cod_licenca IS NOT NULL THEN li_especial.inscricao_economica
                END AS inscricao,
                TO_CHAR(licenca.dt_inicio, 'DD/MM/YYYY') AS dt_inicio,
                TO_CHAR(licenca.dt_termino, 'DD/MM/YYYY') AS dt_termino,
                licenca_situacao.situacao,
                lpad(licenca.exercicio, 4, '0')::VARCHAR AS exercicio,
                CASE
                    WHEN li_atividade.cod_licenca IS NOT NULL THEN li_atividade.nom_atividade
                    WHEN li_especial.cod_licenca IS NOT NULL THEN li_especial.nom_atividade
                END AS atividade,
                modelo_documento.nome_documento,
                licenca.cod_licenca
            FROM economico.licenca INNER JOIN (
                    SELECT
                        cod_licenca,
                        exercicio,
                        dt_termino,
                        CASE
                            WHEN economico.fn_consulta_situacao_licenca(cod_licenca, exercicio)= '' AND dt_termino < now()::DATE 
                            THEN 'Vencida'::VARCHAR
                            WHEN economico.fn_consulta_situacao_licenca(cod_licenca, exercicio)!= '' 
                            THEN economico.fn_consulta_situacao_licenca(cod_licenca, exercicio)
                        END AS situacao
                    FROM economico.licenca
                ) AS licenca_situacao ON licenca_situacao.cod_licenca = licenca.cod_licenca AND licenca_situacao.exercicio = licenca.exercicio 
            LEFT JOIN (
                SELECT
                    licenca_atividade.cod_licenca,
                    atividade_cadastro_economico.cod_atividade,
                    licenca_atividade.exercicio,
                    atividade_cadastro_economico.inscricao_economica,
                    atividade_cadastro_economico.ocorrencia_atividade,
                    atividade.nom_atividade
                FROM economico.licenca_atividade INNER JOIN economico.atividade_cadastro_economico ON licenca_atividade.inscricao_economica = atividade_cadastro_economico.inscricao_economica
                        AND licenca_atividade.cod_atividade = atividade_cadastro_economico.cod_atividade
                        AND licenca_atividade.ocorrencia_atividade = atividade_cadastro_economico.ocorrencia_atividade
                        AND atividade_cadastro_economico.principal = true 
                INNER JOIN economico.atividade ON atividade.cod_atividade = atividade_cadastro_economico.cod_atividade
            ) AS li_atividade ON li_atividade.cod_licenca = licenca.cod_licenca AND li_atividade.exercicio = licenca.exercicio 
            LEFT JOIN(
                SELECT
                    licenca_especial.cod_licenca,
                    atividade_cadastro_economico.cod_atividade,
                    licenca_especial.exercicio,
                    atividade_cadastro_economico.inscricao_economica,
                    atividade_cadastro_economico.ocorrencia_atividade,
                    atividade.nom_atividade
                FROM economico.licenca_especial INNER JOIN economico.atividade_cadastro_economico ON licenca_especial.inscricao_economica = atividade_cadastro_economico.inscricao_economica
                        AND licenca_especial.cod_atividade = atividade_cadastro_economico.cod_atividade
                        AND licenca_especial.ocorrencia_atividade = atividade_cadastro_economico.ocorrencia_atividade 
                INNER JOIN economico.atividade ON atividade.cod_atividade = atividade_cadastro_economico.cod_atividade
            ) AS li_especial ON li_especial.cod_licenca = licenca.cod_licenca AND li_especial.exercicio = licenca.exercicio 
            LEFT JOIN economico.licenca_documento ON licenca_documento.cod_licenca = licenca.cod_licenca AND licenca_documento.exercicio = licenca.exercicio 
            LEFT JOIN administracao.modelo_documento ON modelo_documento.cod_documento = licenca_documento.cod_documento AND modelo_documento.cod_tipo_documento = licenca_documento.cod_tipo_documento
        ";

        $where = ' WHERE 1 = 1 ';
        if (isset($params['situacao']) && $params['situacao'] != 'Todas') {
            $where .= sprintf(" AND situacao = '%s'", $params['situacao']);
        }

        if (isset($params['numeroLicenca']) && !is_null($params['numeroLicenca'])) {
            $where .= sprintf(" AND licenca.cod_licenca = '%d'", $params['numeroLicenca']);
        }

        if (isset($params['inscricaoEconomica']) && !is_null($params['inscricaoEconomica'])) {
            $where .= sprintf(" AND coalesce ( li_atividade.inscricao_economica, li_especial.inscricao_economica) = %d", $params['inscricaoEconomica']);
        }

        if (isset($params['periodicidade'])) {
            $where .= sprintf(" AND licenca.dt_inicio >= TO_DATE( '%s', 'dd/mm/yyyy' )  AND licenca.dt_termino <= TO_DATE( '%s', 'dd/mm/yyyy' )", $params['intervaloDe'], $params['intervaloAte']);
        }

        $groupBy = "
            GROUP BY
                licenca.cod_licenca,
                licenca,
                inscricao,
                licenca.dt_inicio,
                licenca.dt_termino,
                licenca.exercicio,
                situacao,
                atividade,
                modelo_documento.nome_documento
        ";

        $orderBy = "
            ORDER BY
                licenca.cod_licenca";

        $sql .= $where . $groupBy . $orderBy;

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }
}
