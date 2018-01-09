<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 05/10/16
 * Time: 14:09
 */

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM\EntityRepository;

class InventarioItensRepository extends EntityRepository
{
    /**
     * @param array $params {
     *      [description]
     *
     *      @option string  "exercicio"        Exericio
     *      @option string  "cod_item"         Codigo do Item
     *      @option string  "cod_marca"        Codigo da Marca
     *      @option string  "cod_centro"       Codigo do Centro
     *      @option string  "cod_centro"       Codigo do Almoxarifado
     * }
     */
    public function getItemSaldo(array $params)
    {
        $sql = <<<SQL
SELECT
  COALESCE(lancamento.saldo, 0) AS saldo
FROM
  almoxarifado.inventario_itens AS inventario_itens
  LEFT JOIN (
              SELECT
                lancamento_material.cod_almoxarifado,
                lancamento_material.cod_item,
                lancamento_material.cod_marca,
                lancamento_material.cod_centro,
                sum(lancamento_material.quantidade) AS saldo
              FROM almoxarifado.lancamento_material
              GROUP BY lancamento_material.cod_almoxarifado
                , lancamento_material.cod_item
                , lancamento_material.cod_marca
                , lancamento_material.cod_centro
            ) AS lancamento
    ON lancamento.cod_almoxarifado = inventario_itens.cod_almoxarifado
       AND lancamento.cod_item = inventario_itens.cod_item
       AND lancamento.cod_marca = inventario_itens.cod_marca
       AND lancamento.cod_centro = inventario_itens.cod_centro
WHERE inventario_itens.cod_almoxarifado = :cod_almoxarifado
      AND inventario_itens.cod_item = :cod_item
      AND inventario_itens.cod_marca = :cod_marca
      AND inventario_itens.cod_centro = :cod_centro
      AND inventario_itens.exercicio = :exercicio;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    /**
     * @param $cod_item
     * @param $cod_marca
     * @param $cod_almoxarifado
     * @param $cod_centro
     * @param $exercicio
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaVerificaItensInventarioNaoProcessado($cod_item, $cod_marca, $cod_almoxarifado, $cod_centro, $exercicio)
    {
        $stSql = "
          SELECT catalogo_item.cod_item, catalogo_item.descricao
          FROM almoxarifado.inventario_itens
          INNER JOIN almoxarifado.inventario
                  ON (     inventario_itens.cod_inventario = inventario.cod_inventario
                       AND inventario_itens.exercicio = inventario.exercicio
                       AND inventario_itens.cod_almoxarifado = inventario.cod_almoxarifado
                      )
          INNER JOIN almoxarifado.catalogo_item
                  ON (     inventario_itens.cod_item = catalogo_item.cod_item   )
          WHERE inventario.processado = 'f'
          AND inventario_itens.cod_item =".$cod_item."
          AND inventario_itens.cod_marca =".$cod_marca."
          AND inventario_itens.cod_almoxarifado =".$cod_almoxarifado."
          AND inventario_itens.exercicio ='".$exercicio."'
          AND inventario_itens.cod_centro =".$cod_centro;

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
