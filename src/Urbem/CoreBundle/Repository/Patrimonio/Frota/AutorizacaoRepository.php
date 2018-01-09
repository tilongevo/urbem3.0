<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Frota;

use Doctrine\ORM;

class AutorizacaoRepository extends ORM\EntityRepository
{

    /**
     * Pega o próximo identificador disponível
     *
     * @param  string $exercicio
     * @return int $result identifier
     */
    public function getAvailableIdentifier($exercicio)
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT COALESCE(MAX(cod_autorizacao), 0) AS CODIGO 
             FROM frota.autorizacao
             WHERE exercicio = '{$exercicio}'"
        );

        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->codigo + 1;
    }

    /**
     * @param string|null $exercicio
     * @param string|null $codAutorizacao
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getAutorizacaoSaidaAbastecimento($exercicio = null, $codAutorizacao = null)
    {
        $sql = <<<SQL
SELECT
  frota_autorizacao.*,
  (SELECT CASE WHEN frota_utilizacao_retorno.cod_veiculo IS NOT NULL
    THEN frota_utilizacao_retorno.km_retorno
          ELSE frota_utilizacao.km_saida END AS km
   FROM frota.utilizacao frota_utilizacao LEFT JOIN frota.utilizacao_retorno frota_utilizacao_retorno
       ON frota_utilizacao.cod_veiculo = frota_utilizacao_retorno.cod_veiculo
          AND frota_utilizacao.dt_saida = frota_utilizacao_retorno.dt_saida
          AND frota_utilizacao.hr_saida = frota_utilizacao_retorno.hr_saida
   WHERE frota_utilizacao.cod_veiculo = frota_veiculo.cod_veiculo
   ORDER BY
     frota_utilizacao_retorno.dt_retorno DESC,
     frota_utilizacao_retorno.hr_retorno DESC,
     frota_utilizacao.dt_saida DESC,
     frota_utilizacao.hr_saida DESC,
     frota_utilizacao.cod_veiculo DESC
   LIMIT 1) AS km
FROM frota.autorizacao frota_autorizacao
  JOIN frota.veiculo frota_veiculo ON frota_autorizacao.cod_veiculo = frota_veiculo.cod_veiculo
  JOIN frota.posto frota_posto ON frota_autorizacao.cgm_fornecedor = frota_posto.cgm_posto
  JOIN frota.modelo frota_modelo ON frota_veiculo.cod_modelo = frota_modelo.cod_modelo
                                    AND frota_veiculo.cod_marca = frota_modelo.cod_marca
  JOIN frota.marca frota_marca ON frota_modelo.cod_marca = frota_marca.cod_marca
  JOIN frota.item frota_item ON frota_autorizacao.cod_item = frota_item.cod_item
  JOIN frota.tipo_item frota_tipo_item ON frota_item.cod_tipo = frota_tipo_item.cod_tipo
  JOIN almoxarifado.catalogo_item almoxarifado_catalogo_item ON frota_item.cod_item = almoxarifado_catalogo_item.cod_item
  JOIN administracao.unidade_medida administracao_unidade_medida ON almoxarifado_catalogo_item.cod_grandeza = administracao_unidade_medida.cod_grandeza
                                                                    AND almoxarifado_catalogo_item.cod_unidade = administracao_unidade_medida.cod_unidade
WHERE frota_posto.interno IS TRUE
      AND NOT EXISTS
( SELECT 1
  FROM almoxarifado.lancamento_autorizacao almoxarifado_lancamento_autorizacao
  WHERE almoxarifado_lancamento_autorizacao.exercicio = frota_autorizacao.exercicio
        AND almoxarifado_lancamento_autorizacao.cod_autorizacao = frota_autorizacao.cod_autorizacao
        AND NOT EXISTS
  (SELECT 1
   FROM frota.efetivacao frota_efetivacao
     JOIN frota.manutencao frota_manutencao ON frota_efetivacao.cod_manutencao = frota_manutencao.cod_manutencao
                                               AND frota_efetivacao.exercicio_manutencao = frota_manutencao.exercicio))
SQL;

        $conn = $this->_em->getConnection();

        $params = [];
        if (false == is_null($exercicio)) {
            $params['exercicio'] = $exercicio;
            $sql .= " AND frota_autorizacao.exercicio = :exercicio";
        }

        if (false == is_null($codAutorizacao)) {
            $params['cod_autorizacao'] = $codAutorizacao;
            $sql .= " AND frota_autorizacao.cod_autorizacao = :cod_autorizacao";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll();

        return (false == is_null($codAutorizacao)) ? reset($result) : $result ;
    }
}
