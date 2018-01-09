<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 25/07/16
 * Time: 11:42
 */

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;

class RequisicaoItemRepository extends ORM\EntityRepository
{
    /**
     * @param int $codAlmoxarifado
     * @return array
     */
    public function getItemByCodAlmoxarfidado($codAlmoxarifado)
    {
        $codAlmoxarifado = is_null($codAlmoxarifado) ? 1 : $codAlmoxarifado;

        $sql = "
            SELECT ac.cod_catalogo
	         , ac.descricao as desc_catalogo
	         , aci.cod_item
	         , aci.descricao
	         , acc.cod_estrutural
	         , aum.nom_unidade
	         , ati.descricao as desc_tipo
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
	      WHERE spfc.saldo > 0
	 AND spfc.cod_almoxarifado = ".$codAlmoxarifado."
	 AND aci.cod_tipo <> 3  AND aci.cod_tipo <> 0  ORDER BY aci.descricao;
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param string        $codItem
     * @param null|string   $codAlmoxarifado
     * @return array
     */
    public function getMarcaCatalogo($codItem, $codAlmoxarifado = null)
    {
        $sql = <<<SQL
SELECT DISTINCT
  almoxarifado_marca.descricao,
  almoxarifado_marca.cod_marca
FROM
  almoxarifado.marca AS almoxarifado_marca,
  almoxarifado.catalogo_item_marca AS almoxarifado_catalogo_item_marca,
  (SELECT
     almoxarifado_lancamento_material.cod_item,
     almoxarifado_lancamento_material.cod_marca,
     sum(almoxarifado_lancamento_material.quantidade) AS saldo,
     almoxarifado_lancamento_material.cod_almoxarifado,
     almoxarifado_lancamento_material.cod_centro
   FROM
     almoxarifado.lancamento_material AS almoxarifado_lancamento_material
   GROUP BY
     almoxarifado_lancamento_material.cod_item,
     almoxarifado_lancamento_material.cod_marca,
     almoxarifado_lancamento_material.cod_almoxarifado,
     almoxarifado_lancamento_material.cod_centro
  ) AS almoxarifado_lancamento_material
WHERE
  almoxarifado_marca.cod_marca = almoxarifado_catalogo_item_marca.cod_marca
  AND almoxarifado_catalogo_item_marca.cod_item = almoxarifado_lancamento_material.cod_item
  AND almoxarifado_catalogo_item_marca.cod_marca = almoxarifado_lancamento_material.cod_marca
  AND almoxarifado_lancamento_material.saldo > 0
  AND almoxarifado_catalogo_item_marca.cod_item = :cod_item
SQL;
        $params['cod_item'] = $codItem;

        if (false == is_null($codAlmoxarifado)) {
            $sql .= " AND almoxarifado_lancamento_material.cod_almoxarifado = :cod_almoxarifado;";
            $params['cod_almoxarifado'] = $codAlmoxarifado;
        }

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getCentroCustoCatalogo($codMarca, $codItem, $codAlmoxarifado, $numCgm)
    {
        $sql = "SELECT
	    DISTINCT  acc.descricao,
	     acc.cod_centro
	     FROM
	     ( SELECT
	         alm.cod_item,
	         alm.cod_marca,
	         alm.cod_centro,
	         sum(alm.quantidade) as saldo
	       from
	         almoxarifado.lancamento_material as alm
	       group by
	         alm.cod_item,
	         alm.cod_marca,
	         alm.cod_centro
	     ) as spfc,
	     almoxarifado.almoxarifado as aa,
	     almoxarifado.permissao_almoxarifados as apa,
	     almoxarifado.marca as am,
	     almoxarifado.catalogo_item as aci,
	     almoxarifado.catalogo_item_marca as acim,
	     almoxarifado.estoque_material as aem,
	     almoxarifado.centro_custo as acc,
	     almoxarifado.centro_custo_permissao as accp
	 WHERE
	     aem.cod_marca = am.cod_marca               and
	     aem.cod_item  = aci.cod_item               and
	     aem.cod_almoxarifado = aa.cod_almoxarifado and
	     aem.cod_centro = acc.cod_centro            and
	     am.cod_marca = acim.cod_marca              and
	     aci.cod_item = acim.cod_item               and
	     acc.cod_centro = accp.cod_centro           and
	     aa.cod_almoxarifado = apa.cod_almoxarifado and
	     acim.cod_item = spfc.cod_item and
	     acim.cod_marca = spfc.cod_marca and
	     acc.cod_centro = spfc.cod_centro and
	     spfc.saldo > 0
	 and am.cod_marca = $codMarca and aem.cod_item = $codItem and aem.cod_almoxarifado = $codAlmoxarifado and accp.numcgm  = $numCgm";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getCentroCustoCatalogoGeral($codMarca, $codItem, $codAlmoxarifado)
    {
        $sql = "SELECT
	    DISTINCT  acc.descricao,
	     acc.cod_centro
	     FROM
	     ( SELECT
	         alm.cod_item,
	         alm.cod_marca,
	         alm.cod_centro,
	         sum(alm.quantidade) as saldo
	       from
	         almoxarifado.lancamento_material as alm
	       group by
	         alm.cod_item,
	         alm.cod_marca,
	         alm.cod_centro
	     ) as spfc,
	     almoxarifado.almoxarifado as aa,
	     almoxarifado.permissao_almoxarifados as apa,
	     almoxarifado.marca as am,
	     almoxarifado.catalogo_item as aci,
	     almoxarifado.catalogo_item_marca as acim,
	     almoxarifado.estoque_material as aem,
	     almoxarifado.centro_custo as acc,
	     almoxarifado.centro_custo_permissao as accp
	 WHERE
	     aem.cod_marca = am.cod_marca               and
	     aem.cod_item  = aci.cod_item               and
	     aem.cod_almoxarifado = aa.cod_almoxarifado and
	     aem.cod_centro = acc.cod_centro            and
	     am.cod_marca = acim.cod_marca              and
	     aci.cod_item = acim.cod_item               and
	     acc.cod_centro = accp.cod_centro           and
	     aa.cod_almoxarifado = apa.cod_almoxarifado and
	     acim.cod_item = spfc.cod_item and
	     acim.cod_marca = spfc.cod_marca and
	     acc.cod_centro = spfc.cod_centro and
	     spfc.saldo > 0
	 and am.cod_marca = $codMarca and aem.cod_item = $codItem and aem.cod_almoxarifado = $codAlmoxarifado";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getSaldoEstoque($codMarca, $codItem, $codAlmoxarifado, $codCentro)
    {
        $sql = <<<SQL
SELECT
  coalesce(sum(alm.quantidade),0) AS saldo_estoque
FROM
  almoxarifado.lancamento_material AS alm
  LEFT JOIN almoxarifado.estoque_material AS aem ON
    aem.cod_item  = alm.cod_item  AND
    aem.cod_marca = alm.cod_marca AND
    aem.cod_almoxarifado = alm.cod_almoxarifado AND
    aem.cod_centro = alm.cod_centro
WHERE alm.cod_centro = ? AND 
  alm.cod_marca = ? AND 
  alm.cod_item = ? AND 
  alm.cod_almoxarifado = ?
SQL;

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute([$codCentro, $codMarca, $codItem, $codAlmoxarifado]);

        return $query->fetchAll();
    }

    /**
     * @param integer $exercicio
     * @param integer $codAlmoxarifado
     * @param integer $codRequisicao
     * @param integer $codItem
     * @param integer $codMarca
     * @param integer $codCentro
     * @return float
     */
    public function getSaldoRequisitado($exercicio, $codAlmoxarifado, $codRequisicao, $codItem, $codMarca, $codCentro)
    {
        $sql = <<<SQL
SELECT (ari.quantidade - coalesce(aria.tot_quantidade_anulacao, 0)) AS saldo_requisitado
  FROM
    almoxarifado.requisicao_item AS ari
    LEFT OUTER JOIN (
                      SELECT
                        exercicio,
                        cod_requisicao,
                        cod_almoxarifado,
                        cod_item,
                        cod_marca,
                        cod_centro,
                        SUM(quantidade) AS tot_quantidade_anulacao
                      FROM
                        almoxarifado.requisicao_itens_anulacao
                      GROUP BY exercicio, cod_almoxarifado, cod_requisicao, cod_item, cod_marca, cod_centro) AS aria
      ON
        ari.exercicio = aria.exercicio AND
        ari.cod_almoxarifado = aria.cod_almoxarifado AND
        ari.cod_requisicao = aria.cod_requisicao AND
        ari.cod_item = aria.cod_item AND
        ari.cod_marca = aria.cod_marca AND
        ari.cod_centro = aria.cod_centro
  WHERE
    ari.exercicio = ? AND
    ari.cod_almoxarifado = ? AND
    ari.cod_requisicao = ? AND
    ari.cod_item = ? AND
    ari.cod_marca = ? AND
    ari.cod_centro = ?;
SQL;

        $connection = $this->_em->getConnection();
        $stmt = $connection->prepare($sql);

        $stmt->execute([
            $exercicio,
            $codAlmoxarifado,
            $codRequisicao,
            $codItem,
            $codMarca,
            $codCentro
        ]);

        $result = $stmt->fetch();

        return number_format($result['saldo_requisitado'], 4);
    }

    /**
     * @param integer $exercicio
     * @param integer $codAlmoxarifado
     * @param integer $codRequisicao
     * @param integer $codItem
     * @param integer $codMarca
     * @param integer $codCentro
     * @return float
     */
    public function getSaldoAtendido($exercicio, $codAlmoxarifado, $codRequisicao, $codItem, $codMarca, $codCentro)
    {
        $sql = <<<SQL
SELECT
    sum(alm.quantidade) AS saldo_atendido
  FROM
    almoxarifado.lancamento_material AS alm
    JOIN
    almoxarifado.lancamento_requisicao AS alr
      ON (
      alm.cod_lancamento = alr.cod_lancamento AND
      alm.cod_item = alr.cod_item AND
      alm.cod_marca = alr.cod_marca AND
      alm.cod_almoxarifado = alr.cod_almoxarifado AND
      alm.cod_centro = alr.cod_centro )
  WHERE
    alr.exercicio = ? AND
    alm.cod_almoxarifado = ? AND
    alr.cod_requisicao = ? AND
    alm.cod_item = ? AND
    alm.cod_marca = ? AND
    alm.cod_centro = ?;
SQL;

        $connection = $this->_em->getConnection();
        $stmt = $connection->prepare($sql);

        $stmt->execute([
            $exercicio,
            $codAlmoxarifado,
            $codRequisicao,
            $codItem,
            $codMarca,
            $codCentro
        ]);

        $result = $stmt->fetch();

        return $result['saldo_atendido'];
    }

    /**
     * @param integer $exercicio
     * @param integer $codAlmoxarifado
     * @param integer $codRequisicao
     * @param integer $codItem
     * @param integer $codMarca
     * @param integer $codCentro
     * @return float
     */
    public function getSaldoDevolvido($exercicio, $codAlmoxarifado, $codRequisicao, $codItem, $codMarca, $codCentro)
    {
        $sql = <<<SQL
SELECT
    sum(alm.quantidade) AS saldo_devolvido
  FROM
    almoxarifado.lancamento_material AS alm
    JOIN
    almoxarifado.lancamento_requisicao AS alr
      ON (
      alm.cod_lancamento = alr.cod_lancamento AND
      alm.cod_item = alr.cod_item AND
      alm.cod_marca = alr.cod_marca AND
      alm.cod_almoxarifado = alr.cod_almoxarifado AND
      alm.cod_centro = alr.cod_centro )
  WHERE
    alr.exercicio = ? AND
    alm.cod_almoxarifado = ? AND
    alr.cod_requisicao = ? AND
    alm.cod_item = ? AND
    alm.cod_marca = ? AND
    alm.cod_centro = ? AND 
    alm.tipo_natureza = ?;
SQL;

        $connection = $this->_em->getConnection();
        $stmt = $connection->prepare($sql);

        $stmt->execute([
            $exercicio,
            $codAlmoxarifado,
            $codRequisicao,
            $codItem,
            $codMarca,
            $codCentro,
            "E"
        ]);

        $result = $stmt->fetch();

        return number_format($result['saldo_devolvido'], 4);
    }

    /**
     * @param int       $codAlmoxarifado
     * @param int       $codRequisicao
     * @param string    $exercicio
     * @param null|int  $codItem
     * @return array|mixed
     */
    public function getSaldosParaAnulacao($codAlmoxarifado, $codRequisicao, $exercicio, $codItem = null)
    {
        $sql = <<<SQL
SELECT
   ari.cod_item,
   (
      SELECT
         SUM(quantidade) 
      FROM
         almoxarifado.requisicao_itens_anulacao AS ra 
      WHERE
         ra.cod_requisicao = ari.cod_requisicao 
         AND ra.cod_almoxarifado = ari.cod_almoxarifado 
         AND ra .exercicio = ari.exercicio 
         AND ra.cod_item = ari.cod_item 
         AND ra.cod_marca = ari.cod_marca 
         AND ra.cod_centro = ari.cod_centro
   )
   AS qtd_anulada,
   (
      SELECT (SUM(quantidade)* - 1) 
      FROM
         almoxarifado.lancamento_requisicao AS lr 
         INNER JOIN
            almoxarifado.lancamento_material AS lm 
            ON lm.cod_lancamento = lr.cod_lancamento 
            AND lm .cod_item = lr.cod_item 
            AND lm.cod_almoxarifado = lr.cod_almoxarifado 
            AND lm.cod_marca = lr.cod_marca 
            AND lm.cod_centro = lr.cod_centro 
      WHERE
         lr.cod_requisicao = ari.cod_requisicao 
         AND lr.cod_item = ari.cod_item 
         AND lr.cod_marca = ari.cod_marca 
         AND lr.cod_centro = ari.cod_centro 
         AND lr.cod_almoxarifado = ari.cod_almoxarifado 
         AND lr.exercicio = ari.exercicio
   )
   AS qtd_atendida,
   ari.quantidade AS qtd_requisitada 
FROM
   almoxarifado.requisicao_item AS ari,
   almoxarifado.catalogo_item AS aci,
   almoxarifado.marca AS am,
   almoxarifado.centro_custo AS acc 
WHERE
   aci.cod_item = ari.cod_item 
   AND ari.cod_marca = am.cod_marca 
   AND ari.cod_centro = acc.cod_centro 
   AND ari.quantidade > (COALESCE( (
   SELECT
      SUM(quantidade) 
   FROM
      almoxarifado.requisicao_itens_anulacao AS ra 
   WHERE
      ra.cod_requisicao = ari.cod_requisicao 
      AND ra.cod_almoxarifado = ari.cod_almoxarifado 
      AND ra.exercicio = ari.exercicio 
      AND ra.cod_item = ari.cod_item 
      AND ra.cod_marca = ari.cod_marca 
      AND ra.cod_centro = ari.cod_centro), 0) + COALESCE( (
      SELECT (SUM(quantidade)* - 1) 
      FROM
         almoxarifado.lancamento_requisicao AS lr 
         INNER JOIN
            almoxarifado.lancamento_material AS lm 
            ON lm.cod_lancamento = lr.cod_lancamento 
            AND lm.cod_item = lr.cod_item 
            AND lm.cod_almoxarifado = lr.cod_almoxarifado 
            AND lm.cod_marca = lr.cod_marca 
            AND lm.cod_centro = lr.cod_centro 
      WHERE
         lr.cod_requisicao = ari.cod_requisicao 
         AND lr.cod_item = ari.cod_item 
         AND lr.cod_marca = ari.cod_marca 
         AND lr.cod_centro = ari.cod_centro 
         AND lr.cod_almoxarifado = ari.cod_almoxarifado 
         AND lr.exercicio = ari.exercicio), 0)) 
         AND ari.cod_almoxarifado = :cod_almoxarifado 
         AND ari.cod_requisicao = :cod_requisicao 
         AND ari.exercicio = :exercicio::VARCHAR
SQL;

        $params = [
            'cod_almoxarifado' => $codAlmoxarifado,
            'cod_requisicao' => $codRequisicao,
            'exercicio' => $exercicio
        ];

        if (false == is_null($codItem)) {
            $params['cod_item'] = $codItem;

            $sql .= ' AND ari.cod_item = :cod_item';
            $sql .= ' GROUP BY ari.cod_requisicao, ari.cod_almoxarifado, ari.exercicio, ari.cod_centro, ari.cod_item,';
            $sql .= ' ari.cod_marca, aci.descricao, am.descricao, acc.descricao, ari.quantidade;';
        }

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        $result = $stmt->fetchAll();

        return count($result) == 1 ? reset($result) : $result ;
    }
}
