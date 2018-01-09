<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * @ORM\Entity(repositoryClass="Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento")
 */
class NaturezaLancamentoRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @return array
     */
    public function getNaturezaLancamento($exercicio)
    {

        $sql = "
            SELECT *
            FROM Almoxarifado.Natureza_Lancamento
            WHERE cod_natureza = :cod_natureza
            AND tipo_natureza = :tipo_natureza
            AND exercicio_lancamento = :exercicio

";
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'cod_natureza' => 6,
            'tipo_natureza' => 'E',
            'exercicio' => $exercicio,
        ]);

        $result = $stmt->fetchAll();

        return $result;
    }

    /**
     * @param string|int $exercicio
     * @param null|int   $numLancamento
     * @return array
     */
    public function findListaEntradasValidasEstorno($exercicio, $numLancamento = null)
    {
        $sql = <<<SQL
SELECT
  natureza_lancamento.exercicio_lancamento,
  natureza_lancamento.num_lancamento,
  to_char(natureza_lancamento.timestamp, 'dd/mm/yyyy')                                    AS dt_lancamento,
  natureza_lancamento.cod_natureza,
  natureza_lancamento.tipo_natureza,
  natureza_lancamento.cgm_almoxarife,
  almoxarifado.cod_almoxarifado,
  almoxarifado.cgm_almoxarifado,
  nota_fiscal_fornecedor_ordem.exercicio,
  nota_fiscal_fornecedor_ordem.cod_entidade,
  nota_fiscal_fornecedor_ordem.cod_ordem,
  ordem.exercicio_empenho,
  ordem.cod_empenho,
  nota_fiscal_fornecedor_ordem.cod_ordem || '/' || nota_fiscal_fornecedor_ordem.exercicio AS cod_exercicio_ordem,
  ordem.cod_empenho || '/' || ordem.exercicio_empenho                                     AS cod_exercicio_empenho

FROM almoxarifado.natureza_lancamento

  INNER JOIN compras.nota_fiscal_fornecedor
    ON natureza_lancamento.exercicio_lancamento = nota_fiscal_fornecedor.exercicio_lancamento
       AND natureza_lancamento.num_lancamento = nota_fiscal_fornecedor.num_lancamento
       AND natureza_lancamento.cod_natureza = nota_fiscal_fornecedor.cod_natureza
       AND natureza_lancamento.tipo_natureza = nota_fiscal_fornecedor.tipo_natureza

  LEFT JOIN compras.nota_fiscal_fornecedor_ordem
    ON nota_fiscal_fornecedor_ordem.cgm_fornecedor = nota_fiscal_fornecedor.cgm_fornecedor
       AND nota_fiscal_fornecedor_ordem.cod_nota = nota_fiscal_fornecedor.cod_nota

  LEFT JOIN compras.ordem
    ON nota_fiscal_fornecedor_ordem.exercicio = ordem.exercicio
       AND nota_fiscal_fornecedor_ordem.cod_entidade = ordem.cod_entidade
       AND nota_fiscal_fornecedor_ordem.cod_ordem = ordem.cod_ordem
       AND nota_fiscal_fornecedor_ordem.tipo = ordem.tipo
       AND nota_fiscal_fornecedor_ordem.tipo = 'C'

  INNER JOIN almoxarifado.lancamento_material
    ON lancamento_material.exercicio_lancamento = natureza_lancamento.exercicio_lancamento
       AND lancamento_material.num_lancamento = natureza_lancamento.num_lancamento
       AND lancamento_material.cod_natureza = natureza_lancamento.cod_natureza
       AND lancamento_material.tipo_natureza = natureza_lancamento.tipo_natureza

  INNER JOIN almoxarifado.almoxarifado
    ON almoxarifado.cod_almoxarifado = lancamento_material.cod_almoxarifado
       AND natureza_lancamento.exercicio_lancamento = :exercicio::VARCHAR
       AND natureza_lancamento.cod_natureza IN (9, 1)
       AND natureza_lancamento.tipo_natureza = 'E'
WHERE (
        (
          SELECT abs(sum(lancamento_material2.quantidade)) AS soma
          FROM almoxarifado.lancamento_material_estorno
            , almoxarifado.lancamento_material AS lancamento_material2
          WHERE lancamento_material2.cod_lancamento = lancamento_material_estorno.cod_lancamento_estorno
                AND lancamento_material2.cod_almoxarifado = lancamento_material_estorno.cod_almoxarifado
                AND lancamento_material2.cod_item = lancamento_material_estorno.cod_item
                AND lancamento_material2.cod_marca = lancamento_material_estorno.cod_marca
                AND lancamento_material2.cod_centro = lancamento_material_estorno.cod_centro
                AND lancamento_material.cod_lancamento = lancamento_material_estorno.cod_lancamento
                AND lancamento_material.cod_almoxarifado = lancamento_material_estorno.cod_almoxarifado
                AND lancamento_material.cod_item = lancamento_material_estorno.cod_item
                AND lancamento_material.cod_marca = lancamento_material_estorno.cod_marca
                AND lancamento_material.cod_centro = lancamento_material_estorno.cod_centro
        ) < lancamento_material.quantidade
        OR
        NOT EXISTS(
            SELECT 1
            FROM almoxarifado.lancamento_material_estorno
            WHERE lancamento_material.cod_lancamento = lancamento_material_estorno.cod_lancamento
                  AND lancamento_material.cod_almoxarifado = lancamento_material_estorno.cod_almoxarifado
                  AND lancamento_material.cod_item = lancamento_material_estorno.cod_item
                  AND lancamento_material.cod_marca = lancamento_material_estorno.cod_marca
                  AND lancamento_material.cod_centro = lancamento_material_estorno.cod_centro
        )
      )
      AND
      (
        SELECT sum(lancamento_material2.quantidade)
        FROM almoxarifado.lancamento_material AS lancamento_material2
        WHERE lancamento_material.cod_almoxarifado = lancamento_material2.cod_almoxarifado
              AND lancamento_material.cod_item = lancamento_material2.cod_item
              AND lancamento_material.cod_marca = lancamento_material2.cod_marca
              AND lancamento_material.cod_centro = lancamento_material2.cod_centro
      ) > 0
SQL;

        $params['exercicio'] = $exercicio;

        if (false == is_null($numLancamento)) {
            $params['num_lancamento'] = $numLancamento;
            $sql .= " AND lancamento_material.num_lancamento = :num_lancamento ";
        }

        $sql .= <<<SQL
GROUP BY
  natureza_lancamento.exercicio_lancamento
  , natureza_lancamento.num_lancamento
  , to_char(natureza_lancamento.timestamp, 'dd/mm/yyyy')
  , natureza_lancamento.cod_natureza
  , natureza_lancamento.tipo_natureza
  , natureza_lancamento.cgm_almoxarife
  , almoxarifado.cod_almoxarifado
  , almoxarifado.cgm_almoxarifado
  , nota_fiscal_fornecedor_ordem.exercicio
  , nota_fiscal_fornecedor_ordem.cod_entidade
  , nota_fiscal_fornecedor_ordem.cod_ordem
  , ordem.exercicio_empenho
  , ordem.cod_empenho
ORDER BY to_char(natureza_lancamento.timestamp, 'dd/mm/yyyy') DESC
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll();

        return $result;
    }

    /**
     * Pega a listagem de itens da entrada selecionada para a Saída por Estorno de Entrada
     *
     * @param array $params ['exercicio', 'numLancamento', 'codNatureza', 'tipoNatureza'(, 'codItem')]
     * @return array
     */
    public function getListaItensEntrada($params)
    {
        $sql = "
            SELECT
              lm.cod_almoxarifado,
              lm.cod_item,
              lm.cod_marca,
              lm.cod_centro,
              ci.descricao_resumida,
              CASE WHEN ci.cod_tipo = 2
                THEN TRUE
              ELSE FALSE END                                     AS perecivel,
              um.nom_unidade,
              sum(lm.quantidade)                                 AS quantidade,
              lm.quantidade * (lm.valor_mercado / lm.quantidade) AS valor,
              lm.valor_mercado / lm.quantidade                   AS valor_unitario,
              (
                SELECT sum(lm2.quantidade)
                FROM almoxarifado.lancamento_material AS lm2
                WHERE lm.cod_item = lm2.cod_item
                      AND lm.cod_almoxarifado = lm2.cod_almoxarifado
                      AND lm.cod_marca = lm2.cod_marca
                      AND lm.cod_centro = lm2.cod_centro
                      AND lm2.exercicio_lancamento = :exercicio
              ) AS saldo,
              (
                SELECT sum(lm2.quantidade)
                FROM almoxarifado.lancamento_material AS lm2
                WHERE lm.cod_item = lm2.cod_item
                      AND lm.cod_almoxarifado = lm2.cod_almoxarifado
                      AND lm.cod_marca = lm2.cod_marca
                      AND lm.cod_centro = lm2.cod_centro
                      AND lm2.exercicio_lancamento = :exercicio
                      AND
                      (
                        (lm2.cod_natureza = 9
                         AND lm2.tipo_natureza = 'E'
                        )
                        OR
                        (lm2.cod_natureza = 10
                         AND lm2.tipo_natureza = 'S'
                        )
                      )
              ) AS saldo_lancamento
            FROM almoxarifado.lancamento_material AS lm
              , almoxarifado.catalogo_item AS ci
              , administracao.unidade_medida AS um
            WHERE lm.cod_item = ci.cod_item
                  AND ci.cod_grandeza = um.cod_grandeza
                  AND ci.cod_unidade = um.cod_unidade
                  AND lm.exercicio_lancamento = :exercicio
                  AND lm.num_lancamento = :numLancamento
                  AND lm.cod_natureza = :codNatureza
                  AND lm.tipo_natureza = :tipoNatureza
                  " . (isset($params['codItem']) ? 'AND lm.cod_item = ' . $params['codItem'] : '') . "
            GROUP BY lm.cod_almoxarifado
              , lm.cod_item
              , ci.descricao_resumida
              , ci.cod_tipo
              , um.nom_unidade
              , lm.quantidade
              , lm.valor_mercado
              , lm.cod_marca
              , lm.cod_centro
            HAVING
              (
                SELECT sum(lm2.quantidade)
                FROM almoxarifado.lancamento_material AS lm2
                WHERE lm.cod_almoxarifado = lm2.cod_almoxarifado
                      AND lm.cod_item = lm2.cod_item
                      AND lm.cod_marca = lm2.cod_marca
                      AND lm.cod_centro = lm2.cod_centro
              ) > 0
            ORDER BY lm.cod_item
        ";
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'exercicio' => $params['exercicio'],
            'numLancamento' => $params['numLancamento'],
            'codNatureza' => $params['codNatureza'],
            'tipoNatureza' => $params['tipoNatureza']
        ]);

        $result = $stmt->fetchAll();

        return $result;
    }

    /**
     * Pega os detalhes dos itens da entrada selecionada para a Saída por Estorno de Entrada
     *
     * @param array $params ['codItem', 'codMarca', 'codCentro', 'numLancamento', 'exercicio']
     * @return array
     */
    public function getDetalhesItensEntrada($params)
    {
        $sql = <<<SQL
SELECT SUM(lm.quantidade * -1) AS saldo_estornado
  FROM almoxarifado.lancamento_material lm
    JOIN almoxarifado.lancamento_material_estorno lme ON lm.cod_lancamento = lme.cod_lancamento
                                                         AND lm.cod_item = lme.cod_item
                                                         AND lm.cod_marca = lme.cod_marca
                                                         AND lm.cod_almoxarifado = lme.cod_almoxarifado
                                                         AND lm.cod_centro = lme.cod_centro
  WHERE lm.cod_item = :codItem
    AND lm.cod_marca = :codMarca
    AND lm.cod_centro = :codCentro 
    AND lm.tipo_natureza = 'S'
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'codItem' => $params['codItem'],
            'codMarca' => $params['codMarca'],
            'codCentro' => $params['codCentro']
        ]);

        $result = $stmt->fetchAll();

        return $result;
    }

    /**
     * @param array $params
     * @return integer
     */
    public function getNextNumLancamento(array $params)
    {
        return $this->nextVal('num_lancamento', $params);
    }
}
