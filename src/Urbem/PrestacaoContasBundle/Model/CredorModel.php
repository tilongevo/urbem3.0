<?php

namespace Urbem\PrestacaoContasBundle\Model;

/**
 * Class CredorModel
 *
 * @package Urbem\PrestacaoContasBundle\Model\Empenho
 */
class CredorModel extends AbstractTransparenciaModel
{
    /**
     * @param string|integer $exercicio
     *
     * @return array
     */
    public function getDadosExportacao($exercicio)
    {
        $sql = <<<SQL
SELECT
  LPAD(CAST(pre_empenho.cgm_beneficiario AS TEXT), 10, '0') AS cod_credor,
  RPAD(sw_cgm.nom_cgm, 60, ' ')                             AS credor,
  RPAD(CAST(CASE WHEN sw_cgm_pessoa_fisica.cpf <> ''
    THEN sw_cgm_pessoa_fisica.cpf
            ELSE sw_cgm_pessoa_juridica.cnpj
            END AS TEXT), 14, ' ')                          AS cpf_cnpj_credor
FROM empenho.pre_empenho
  JOIN sw_cgm
    ON sw_cgm.numcgm = pre_empenho.cgm_beneficiario
  LEFT JOIN sw_cgm_pessoa_fisica
    ON sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm
  LEFT JOIN sw_cgm_pessoa_juridica
    ON sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm
WHERE empenho.pre_empenho.exercicio = :exercicio
GROUP BY cod_credor, credor, cpf_cnpj_credor
SQL;

        return $this->getQueryResults($sql, ['exercicio' => $exercicio]);
    }
}
