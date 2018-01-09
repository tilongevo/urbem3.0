<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;

class PedidoTransferenciaItemRepository extends ORM\EntityRepository
{
    public function getItemByCodTransferencia($object, $params)
    {
        $object = is_null($object) ? 1 : $object;

        $sql = "
            SELECT ac.cod_catalogo
                 , ac.descricao as desc_catalogo
                 , aci.cod_item
                 , aci.descricao
                 , acc.cod_estrutural
                 , aum.nom_unidade
                 , ati.descricao as desc_tipo
                 , pt.cod_transferencia
            FROM ( SELECT lancamento_material.cod_item
                     , lancamento_material.cod_almoxarifado
                     , sum(lancamento_material.quantidade) as saldo
                  FROM almoxarifado.lancamento_material
              GROUP BY lancamento_material.cod_item
                           , lancamento_material.cod_almoxarifado) as spfc
            INNER JOIN almoxarifado.catalogo_item as aci
                   ON spfc.cod_item = aci.cod_item
            INNER JOIN administracao.unidade_medida as aum
                   ON aum.cod_grandeza = aci.cod_grandeza
                  AND aum.cod_unidade = aci.cod_unidade
            INNER JOIN almoxarifado.tipo_item as ati
                   ON ati.cod_tipo = aci.cod_tipo
            INNER JOIN almoxarifado.catalogo  as ac
                   ON ac.cod_catalogo = aci.cod_catalogo
            INNER JOIN almoxarifado.catalogo_classificacao  as acc
                   ON acc.cod_catalogo = aci.cod_catalogo
                  AND acc.cod_classificacao = aci.cod_classificacao
            LEFT JOIN almoxarifado.atributo_catalogo_classificacao_item_valor as aacciv
                   ON aacciv.cod_item = aci.cod_item
                  AND aacciv.cod_classificacao = aci.cod_classificacao
                  AND aacciv.cod_catalogo = aci.cod_catalogo
            left join almoxarifado.pedido_transferencia as pt
              on pt.cod_almoxarifado_origem = spfc.cod_almoxarifado
            WHERE spfc.saldo > 0
              AND pt.cod_transferencia = " . $object . "
              AND aci.cod_tipo NOT IN (0, 3) 
              {$params}
              ORDER BY aci.descricao;
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param int       $numCgm
     * @param int       $codItem
     * @param int|null  $codAlmoxarifado
     * @return array
     */
    public function getCentroCustoDestino($numCgm, $codItem, $codAlmoxarifado = null)
    {
        $sql = <<<SQL
SELECT
  DISTINCT
  almoxarifado_centro_custo.descricao,
  almoxarifado_centro_custo.cod_centro
FROM
  (SELECT
     alm.cod_item,
     alm.cod_marca,
     alm.cod_centro,
     sum(alm.quantidade) saldo
   FROM
     almoxarifado.lancamento_material AS alm
   GROUP BY
     alm.cod_item,
     alm.cod_marca,
     alm.cod_centro
  ) AS almoxarifado_lancamento_material
  JOIN almoxarifado.catalogo_item_marca almoxarifado_catalogo_item_marca
    ON almoxarifado_lancamento_material.cod_item = almoxarifado_catalogo_item_marca.cod_item
       AND almoxarifado_lancamento_material.cod_marca = almoxarifado_catalogo_item_marca.cod_marca
  JOIN almoxarifado.catalogo_item almoxarifado_catalogo_item
    ON almoxarifado_catalogo_item_marca.cod_item = almoxarifado_catalogo_item.cod_item
  JOIN almoxarifado.marca almoxarifado_marca
    ON almoxarifado_catalogo_item_marca.cod_marca = almoxarifado_marca.cod_marca
  JOIN almoxarifado.centro_custo almoxarifado_centro_custo
    ON almoxarifado_lancamento_material.cod_centro = almoxarifado_centro_custo.cod_centro
  JOIN almoxarifado.estoque_material almoxarifado_estoque_material
    ON almoxarifado_estoque_material.cod_marca = almoxarifado_marca.cod_marca
       AND almoxarifado_estoque_material.cod_item = almoxarifado_catalogo_item.cod_item
       AND almoxarifado_estoque_material.cod_centro = almoxarifado_centro_custo.cod_centro
  JOIN almoxarifado.almoxarifado almoxarifado_almoxarifado
    ON almoxarifado_estoque_material.cod_almoxarifado = almoxarifado_almoxarifado.cod_almoxarifado
  JOIN almoxarifado.centro_custo_permissao almoxarifado_centro_custo_permissao
      ON almoxarifado_centro_custo.cod_centro = almoxarifado_centro_custo_permissao.cod_centro
  JOIN almoxarifado.permissao_almoxarifados almoxarifado_permissao_almoxarifado
      ON almoxarifado_almoxarifado.cod_almoxarifado = almoxarifado_permissao_almoxarifado.cod_almoxarifado
WHERE
  almoxarifado_lancamento_material.saldo > 0
  AND almoxarifado_centro_custo_permissao.numcgm = :numcgm
  AND almoxarifado_estoque_material.cod_item = :cod_item
SQL;
        $params = [
            'numcgm' => $numCgm,
            'cod_item' => $codItem
        ];

        if (false == is_null($codAlmoxarifado)) {
            $sql = " AND almoxarifado_estoque_material.cod_almoxarifado = :cod_almoxarifado;";
            $params['cod_almoxarifado'] = $codAlmoxarifado;
        }

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * @param array $params
     * @return array
     */
    public function recuperaSaldoEmEstoque(array $params)
    {
        $sql = "SELECT
            coalesce(sum(alm.quantidade),0) AS saldo_estoque
        FROM almoxarifado.lancamento_material AS alm
        LEFT JOIN almoxarifado.estoque_material AS aem
          ON aem.cod_item  = alm.cod_item AND
          aem.cod_marca = alm.cod_marca AND
          aem.cod_almoxarifado = alm.cod_almoxarifado AND
          aem.cod_centro = alm.cod_centro
        WHERE aem.cod_item = :cod_item AND
          aem.cod_centro= :cod_centro AND
          aem.cod_almoxarifado = :cod_almoxarifado";

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }
}
