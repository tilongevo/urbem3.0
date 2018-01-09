<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;

class CatalogoItemRepository extends ORM\EntityRepository
{
    public function getCatalogoClassificacao($params)
    {
        $sql = "
        SELECT 
            catalogo_classificacao.cod_classificacao,
            catalogo_classificacao.cod_estrutural,
            catalogo_classificacao.descricao
        FROM 
            almoxarifado.catalogo_classificacao
        WHERE 
            publico.fn_nivel(catalogo_classificacao.cod_estrutural) = (
                SELECT MAX(publico.fn_nivel(cc.cod_estrutural))
                FROM almoxarifado.catalogo_classificacao cc
                WHERE cc.cod_catalogo = " . $params['codCatalogo'] . "
            )
            AND catalogo_classificacao.cod_catalogo = " . $params['codCatalogo'] . "
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param array $params
     * @return array
     */
    public function getCatalogoClassificacaoLike(array $params)
    {
        $sql = <<<SQL
SELECT
  catalogo_classificacao.cod_classificacao,
  catalogo_classificacao.cod_estrutural,
  catalogo_classificacao.cod_catalogo,
  catalogo_classificacao.descricao
FROM
  almoxarifado.catalogo_classificacao
WHERE
  publico.fn_nivel(catalogo_classificacao.cod_estrutural) = (
    SELECT MAX(publico.fn_nivel(cc.cod_estrutural))
    FROM almoxarifado.catalogo_classificacao cc
    WHERE cc.cod_catalogo = :cod_catalogo
  )
  AND catalogo_classificacao.cod_catalogo = :cod_catalogo
  AND (
    LOWER(descricao) LIKE LOWER(:descricao)
    OR cod_estrutural LIKE :estrutural
  )
ORDER BY descricao;
SQL;
        $params['descricao'] = "%{$params['descricao']}%";
        $params['estrutural'] = "%{$params['descricao']}%";

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function getAtributosClassificacao($params)
    {
        $sql = "
            SELECT                                                   
                AD.cod_atributo,                                              
                AD.nom_atributo                                         
            FROM                                                    
                almoxarifado.atributo_catalogo_classificacao    AS ACA,     
                administracao.atributo_dinamico                 AS AD,             
                administracao.tipo_atributo                     AS TA              
            WHERE 
                ACA.cod_atributo        = AD.cod_atributo  
                AND ACA.cod_cadastro    = AD.cod_cadastro 
                AND ACA.cod_modulo      = AD.cod_modulo   
                AND ACA.ativo           = true            
                AND TA.cod_tipo         = AD.cod_tipo                        
                AND AD.ativo            = true
                AND AD.cod_modulo           = 29   
                AND AD.cod_cadastro         = 26
                AND ACA.cod_catalogo        = " . $params['codCatalogo'] . "
                AND ACA.cod_classificacao   = " . $params['codClassificacao'] . "
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getCatalogoItemByClassificacao($params)
    {
        $sql = <<<SQL
SELECT
  ac.cod_catalogo,
  ac.descricao  AS desc_catalogo,
  acc.cod_estrutural,
  aci.cod_item,
  ati.cod_tipo,
  ati.descricao AS desc_tipo,
  aci.descricao,
  aum.cod_unidade,
  aum.cod_grandeza,
  aum.nom_unidade
FROM
  almoxarifado.catalogo ac
  JOIN almoxarifado.catalogo_item aci
    ON ac.cod_catalogo = aci.cod_catalogo
  JOIN administracao.unidade_medida aum
    ON aci.cod_unidade = aum.cod_unidade
       AND aci.cod_grandeza = aum.cod_grandeza
  JOIN almoxarifado.catalogo_classificacao acc
    ON aci.cod_classificacao = acc.cod_classificacao
       AND aci.cod_catalogo = acc.cod_catalogo
  JOIN almoxarifado.tipo_item ati
    ON aci.cod_tipo = ati.cod_tipo
WHERE
  aci.cod_catalogo = ?
  AND aci.cod_classificacao = ?
  AND acc.cod_estrutural LIKE ? || '%'
  AND exists(
      SELECT lancamento_material.cod_item
      FROM almoxarifado.lancamento_material
      WHERE lancamento_material.cod_item = aci.cod_item
  )
ORDER BY aci.descricao
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll();

        return $result;
    }


    public function getCatalogoItemByInventarioItens($codItem, $codMarca, $codAlmoxarifado, $codCentro, $exercicio)
    {

        $sql = "
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
               AND inventario_itens.cod_item = $codItem
               AND inventario_itens.cod_marca = $codMarca
               AND inventario_itens.cod_almoxarifado = $codAlmoxarifado
               AND inventario_itens.cod_centro = $codCentro 
               AND inventario_itens.exercicio = '$exercicio'                        
        ";

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getValorUltimaCompra(array $params)
    {
        $sql = <<<SQL
SELECT
   CAST (COALESCE((item_pre_empenho.vl_total / item_pre_empenho.quantidade), 0) 
   AS NUMERIC(14, 2)) AS vl_unitario_ultima_compra 
FROM
   empenho.item_pre_empenho_julgamento,
   empenho.item_pre_empenho,
   empenho.pre_empenho,
   empenho.empenho 
WHERE
   item_pre_empenho_julgamento.cod_item = :cod_item 
   AND item_pre_empenho_julgamento.exercicio = :exercicio 
   AND item_pre_empenho_julgamento.num_item = item_pre_empenho.num_item 
   AND item_pre_empenho_julgamento.exercicio = item_pre_empenho.exercicio 
   AND item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho 
   AND item_pre_empenho.exercicio = empenho.exercicio 
   AND item_pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho 
   AND pre_empenho.cod_pre_empenho = item_pre_empenho.cod_pre_empenho 
   AND pre_empenho.exercicio = item_pre_empenho.exercicio 
   AND empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho 
   AND empenho.exercicio = pre_empenho.exercicio 
   AND NOT EXISTS 
   (
      SELECT 1 
      FROM empenho.empenho_anulado_item 
      WHERE
         empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho 
         AND empenho_anulado_item.exercicio = item_pre_empenho.exercicio 
         AND empenho_anulado_item.num_item = item_pre_empenho.num_item 
   )
ORDER BY
   empenho.cod_empenho DESC LIMIT 1;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }

    /**
     * @param array $params
     * @return array
     */
    public function getValorUltimaCompraCatalogoItem(array $params)
    {
        $sql = <<<SQL
SELECT
   CAST (COALESCE((item_pre_empenho.vl_total / item_pre_empenho.quantidade), 0) 
   AS NUMERIC(14, 2)) AS vl_unitario_ultima_compra 
FROM
   empenho.item_pre_empenho_julgamento,
   empenho.item_pre_empenho,
   empenho.pre_empenho,
   empenho.empenho 
WHERE
   item_pre_empenho_julgamento.cod_item = :cod_item 
   AND item_pre_empenho_julgamento.num_item = item_pre_empenho.num_item 
   AND item_pre_empenho_julgamento.exercicio = item_pre_empenho.exercicio 
   AND item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho 
   AND item_pre_empenho.exercicio = empenho.exercicio 
   AND item_pre_empenho.cod_pre_empenho = empenho.cod_pre_empenho 
   AND pre_empenho.cod_pre_empenho = item_pre_empenho.cod_pre_empenho 
   AND pre_empenho.exercicio = item_pre_empenho.exercicio 
   AND empenho.cod_pre_empenho = pre_empenho.cod_pre_empenho 
   AND empenho.exercicio = pre_empenho.exercicio 
   AND NOT EXISTS 
   (
      SELECT 1 
      FROM empenho.empenho_anulado_item 
      WHERE
         empenho_anulado_item.cod_pre_empenho = item_pre_empenho.cod_pre_empenho 
         AND empenho_anulado_item.exercicio = item_pre_empenho.exercicio 
         AND empenho_anulado_item.num_item = item_pre_empenho.num_item 
   )
ORDER BY
   empenho.cod_empenho DESC LIMIT 1;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }

    public function getValorUnitario(array $params)
    {
        $sql = <<<SQL
SELECT
  cast((cotacao_fornecedor_item.vl_cotacao / cotacao_item.quantidade) AS NUMERIC(14, 2)) AS vl_unitario
FROM compras.cotacao
  JOIN compras.cotacao_item
    ON (cotacao.exercicio = cotacao_item.exercicio
        AND cotacao.cod_cotacao = cotacao_item.cod_cotacao)
        
  JOIN almoxarifado.catalogo_item
    ON (cotacao_item.cod_item = catalogo_item.cod_item)
    
  JOIN compras.cotacao_fornecedor_item
    ON (cotacao_item.exercicio = cotacao_fornecedor_item.exercicio
        AND cotacao_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
        AND cotacao_item.cod_item = cotacao_fornecedor_item.cod_item
        AND cotacao_item.lote = cotacao_fornecedor_item.lote)
  
  JOIN compras.mapa_cotacao
    ON (mapa_cotacao.exercicio_cotacao = cotacao.exercicio
        AND mapa_cotacao.cod_cotacao = cotacao.cod_cotacao)
  
WHERE mapa_cotacao.exercicio_mapa = :exercicio_mapa
      AND mapa_cotacao.cod_mapa = :cod_mapa
      AND cotacao_item.cod_item = :cod_item
      AND cotacao_item.lote = :lote;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetch();
    }

    /**
     * @param array $params
     * @param string $addWhere
     * @return array
     */
    public function getItensLancamentoMaterial(array $params = [], $addWhere = "")
    {
        $sql = <<<SQL
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
WHERE spfc.saldo > 0 
SQL;

        if (!empty($addWhere)) {
            $sql .= $addWhere;
        }

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * @param $paramsWhere
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function carregaAlmoxarifadoCatalogoItemQuery($paramsWhere)
    {
        $sql = sprintf(
            "
            select
                ac.cod_catalogo,
                ac.descricao as desc_catalogo,
                acc.cod_estrutural,
                aci.cod_item,
                ati.cod_tipo,
                ati.descricao as desc_tipo,
                aci.descricao,
                aum.cod_unidade,
                aum.cod_grandeza,
                aum.nom_unidade
            from
                almoxarifado.catalogo ac,
                almoxarifado.catalogo_classificacao acc,
                almoxarifado.tipo_item ati,
                administracao.unidade_medida as aum,
                almoxarifado.catalogo_item aci left outer join almoxarifado.atributo_catalogo_classificacao_item_valor aacciv on
                (
                    aacciv.cod_item = aci.cod_item
                    and aacciv.cod_classificacao = aci.cod_classificacao
                    and aacciv.cod_catalogo = aci.cod_catalogo
                )
            where
                aum.cod_unidade = aci.cod_unidade
                and ac.cod_catalogo = aci.cod_catalogo
                and acc.cod_classificacao = aci.cod_classificacao
                and acc.cod_catalogo = aci.cod_catalogo
                and ati.cod_tipo = aci.cod_tipo
                and aci.cod_grandeza = aum.cod_grandeza
                and aci.cod_tipo <> 0
                and %s",
            implode(" AND ", $paramsWhere)
        );
        $sql .= " order by
	    aci.descricao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $paramsWhere
     * @return string
     */
    public function carregaAlmoxarifadoCatalogoUnidadeQuery($codItem)
    {
        $sql = sprintf(

            "
            select
                uni.nom_unidade
            from
                almoxarifado.catalogo_item as item
            join administracao.unidade_medida as uni on
                (
                    uni.cod_unidade = item.cod_unidade
                    and uni.cod_grandeza = item.cod_grandeza
                )
            where item.cod_item = %s", $codItem
        );

        try {
            $query = $this->_em->getConnection()->prepare($sql);
            $query->execute();
            $return = $query->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            $return = null;
        }

        return $return;
    }


    /**
     * @param $paramsWhere
     * @return number
     */
    public function carregaAlmoxarifadoSaldoCentroCustoQuery($codCentro, $codItem)
    {
        $sql = sprintf(
            "
            select
                coalesce(sum(alm.quantidade),0) as saldo_estoque 
            from
                almoxarifado.lancamento_material as alm
            left join
                almoxarifado.estoque_material as aem on
                    aem.cod_item  = alm.cod_item  and
                    aem.cod_marca = alm.cod_marca and
                    aem.cod_almoxarifado = alm.cod_almoxarifado and
                    aem.cod_centro = alm.cod_centro
            where 
                alm.cod_centro = %d and
                alm.cod_item = %d", $codCentro, $codItem
        );

        try {
            $query = $this->_em->getConnection()->prepare($sql);
            $query->execute();
            $return = $query->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            $return = null;
        }

        return $return;
    }

}
