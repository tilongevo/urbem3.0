<?php

namespace Urbem\PrestacaoContasBundle\Model;

use DateTime;

/**
 * Class PublicacaoEditalModel
 *
 * @package Urbem\PrestacaoContasBundle\Model
 */
class PublicacaoEditalModel extends AbstractTransparenciaModel
{
    /**
     * @param string|integer $exercicio
     * @param array          $entidades
     * @param DateTime       $dataInicial
     * @param DateTime       $dataFinal
     *
     * @return mixed
     */
    public function getDadosExportacao($exercicio, array $entidades, Datetime $dataInicial, DateTime $dataFinal)
    {
        $entidades = implode(', ', $entidades);

        $sql = <<<SQL
SELECT
  edital.exercicio                                       AS exercicio_edital,
  LPAD(edital.num_edital :: VARCHAR, 8, '0')             AS num_edital,
  edital.exercicio_licitacao,
  LPAD(licitacao.cod_licitacao :: VARCHAR, 8, '0')       AS cod_licitacao,
  LPAD(licitacao.cod_entidade :: VARCHAR, 2, '0')        AS cod_entidade,
  RPAD(modalidade.descricao, 50, ' ')                    AS modalidade,
  RPAD(tipo_veiculos_publicidade.descricao, 80, ' ')     AS veiculo_publicacao,
  TO_CHAR(publicacao_edital.data_publicacao, 'ddmmyyyy') AS data_publicacao,
  RPAD(publicacao_edital.observacao, 50, ' ')            AS observacao
FROM licitacao.licitacao
  INNER JOIN compras.modalidade ON modalidade.cod_modalidade = licitacao.cod_modalidade
  INNER JOIN licitacao.edital ON edital.cod_licitacao = licitacao.cod_licitacao
                                 AND edital.cod_entidade = licitacao.cod_entidade
                                 AND edital.exercicio_licitacao = licitacao.exercicio
                                 AND edital.cod_modalidade = licitacao.cod_modalidade
  INNER JOIN licitacao.publicacao_edital ON publicacao_edital.num_edital = edital.num_edital
                                            AND publicacao_edital.exercicio = edital.exercicio
  INNER JOIN licitacao.veiculos_publicidade ON veiculos_publicidade.numcgm = publicacao_edital.numcgm
  INNER JOIN licitacao.tipo_veiculos_publicidade
    ON tipo_veiculos_publicidade.cod_tipo_veiculos_publicidade = veiculos_publicidade.cod_tipo_veiculos_publicidade
WHERE edital.exercicio = :exercicio
      AND licitacao.cod_entidade IN ($entidades)
      AND
      publicacao_edital.data_publicacao BETWEEN TO_DATE(:dtInicial, 'DD-MM-YYYY') AND TO_DATE(:dtFinal, 'DD-MM-YYYY');
SQL;

        return $this->getQueryResults($sql, [
            'exercicio' => $exercicio,
            'dtInicial' => $dataInicial->format('d/m/Y'),
            'dtFinal'   => $dataFinal->format('d/m/Y'),
        ]);
    }
}
