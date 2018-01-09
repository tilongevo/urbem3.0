<?php
namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;

class JulgamentoItemRepository extends ORM\EntityRepository
{
    public function montaRecuperaClassificacaoItens($exercicio = false, $codCotacao = false, $codItem = false, $cgmFornecedor = false)
    {
        $sql = "
            select julgamento_item.exercicio
             , julgamento_item.cod_cotacao
             , julgamento_item.lote
             , julgamento_item.cod_item
             , julgamento_item.ordem
             , julgamento_item.cgm_fornecedor
             , sw_cgm.nom_cgm
             , publico.fn_numeric_br(cotacao_fornecedor_item.vl_cotacao) as vl_cotacao
             , case when sw_cgm_pessoa_fisica.numcgm   is not null then sw_cgm_pessoa_fisica.cpf
                    when sw_cgm_pessoa_juridica.numcgm is not null then sw_cgm_pessoa_juridica.cnpj
                    else null
               end as cnpj_cpf
          from compras.julgamento_item
          join compras.cotacao_fornecedor_item
            on cotacao_fornecedor_item.exercicio      = julgamento_item.exercicio
           and cotacao_fornecedor_item.cod_cotacao    = julgamento_item.cod_cotacao
           and cotacao_fornecedor_item.cod_item       = julgamento_item.cod_item
           and cotacao_fornecedor_item.cgm_fornecedor = julgamento_item.cgm_fornecedor
           and cotacao_fornecedor_item.lote           = julgamento_item.lote
          join sw_cgm
            on sw_cgm.numcgm = julgamento_item.cgm_fornecedor
     left join sw_cgm_pessoa_fisica
            on sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm
     left join sw_cgm_pessoa_juridica
            on sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm
            WHERE 1 = 1
        ";

        if ($exercicio) {
            $sql .= " AND julgamento_item.exercicio = '" . $exercicio . "'";
        }
        if ($codCotacao) {
            $sql .= "AND julgamento_item.cod_cotacao = $codCotacao";
        }
        if ($codItem) {
            $sql .= " AND julgamento_item.cod_item = $codItem";
        }
        if ($cgmFornecedor) {
            $sql .= " AND julgamento_item.cgm_fornecedor = $cgmFornecedor";
        }

        $sql .= " order by julgamento_item.ordem";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getItensDeFonecedoresQueGanharam($params)
    {
        $sql = <<<SQL
SELECT
  julgamento_item.cod_item
  , cotacao_item.quantidade
  , cast (( cotacao_fornecedor_item.vl_cotacao / cotacao_item.quantidade ) as numeric(14,2)) as vl_unitario
  , cotacao_fornecedor_item.vl_cotacao as vl_total
  , julgamento_item.cgm_fornecedor
  , catalogo_item.descricao_resumida
  , catalogo_item.descricao
  , julgamento_item.lote
  , sw_cgm.nom_cgm
  , (     SELECT  complemento
          FROM  compras.solicitacao_item
            INNER JOIN  compras.mapa_item
              ON  solicitacao_item.exercicio       = mapa_item.exercicio
                  AND  solicitacao_item.cod_entidade    = mapa_item.cod_entidade
                  AND  solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
                  AND  solicitacao_item.cod_centro      = mapa_item.cod_centro
                  AND  solicitacao_item.cod_item        = mapa_item.cod_item
            INNER JOIN  compras.cotacao
              ON  cotacao_item.cod_cotacao = cotacao.cod_cotacao
                  AND  cotacao_item.exercicio = cotacao.exercicio
            INNER JOIN  compras.mapa_cotacao
              ON  mapa_cotacao.cod_cotacao = cotacao.cod_cotacao
                  AND  mapa_cotacao.exercicio_cotacao = cotacao.exercicio
            INNER JOIN  compras.mapa
              ON  mapa_cotacao.cod_mapa = mapa.cod_mapa
                  AND  mapa_cotacao.exercicio_cotacao = mapa.exercicio
          WHERE  mapa_item.cod_mapa  = mapa.cod_mapa
                 AND  mapa_item.exercicio = mapa.exercicio
                 AND  solicitacao_item.complemento <> ''
          ORDER BY  solicitacao_item.cod_solicitacao DESC
          LIMIT  1
    ) as complemento
  , marca.descricao as marca
FROM  compras.julgamento
  INNER JOIN  compras.julgamento_item
    ON  julgamento_item.cod_cotacao = julgamento.cod_cotacao
        AND  julgamento_item.exercicio   = julgamento.exercicio
  INNER JOIN  almoxarifado.catalogo_item
    ON  catalogo_item.cod_item = julgamento_item.cod_item
  INNER JOIN  compras.cotacao_fornecedor_item
    ON  cotacao_fornecedor_item.cod_item = julgamento_item.cod_item
        AND  cotacao_fornecedor_item.exercicio = julgamento_item.exercicio
        AND  cotacao_fornecedor_item.cod_cotacao = julgamento_item.cod_cotacao
        AND  cotacao_fornecedor_item.cgm_fornecedor = julgamento_item.cgm_fornecedor
        AND  cotacao_fornecedor_item.lote = julgamento_item.lote
  INNER JOIN  compras.cotacao_item
    ON  cotacao_item.cod_cotacao = julgamento_item.cod_cotacao
        AND  cotacao_item.exercicio = julgamento_item.exercicio
        AND  cotacao_item.cod_item = julgamento_item.cod_item
        AND  cotacao_item.lote = julgamento_item.lote
  INNER JOIN  almoxarifado.marca
    ON  marca.cod_marca = cotacao_fornecedor_item.cod_marca
  INNER JOIN  sw_cgm
    ON  sw_cgm.numcgm = julgamento_item.cgm_fornecedor
WHERE  julgamento_item.ordem = 1
  AND julgamento_item.cod_cotacao = :cod_cotacao 
  AND julgamento_item.exercicio = :exercicio
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /**
     * @param $codCotacao
     * @param $exercicio
     * @param $codItem
     * @param $cgmFornecedor
     * @param $lote
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function removeJulgamentoItem($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote)
    {
        $ssql = "SELECT * FROM compras.homologacao WHERE exercicio_cotacao = '{$exercicio}' AND cod_cotacao = $codCotacao AND cod_item = $codItem AND cgm_fornecedor = $cgmFornecedor AND lote = $lote ;";
        $query = $this->_em->getConnection()->prepare($ssql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        if (count($result) > 0) {
            $sql = "DELETE FROM compras.homologacao WHERE exercicio_cotacao = '{$exercicio}' AND cod_cotacao = $codCotacao AND cod_item = $codItem AND cgm_fornecedor = $cgmFornecedor AND lote = $lote ;";
            $query = $this->_em->getConnection()->prepare($sql);
            $query->execute();
        }

        $sql = "DELETE FROM empenho.item_pre_empenho_julgamento WHERE exercicio = '{$exercicio}' AND cod_cotacao = $codCotacao AND cod_item = $codItem AND cgm_fornecedor = $cgmFornecedor AND lote = $lote ;";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $sql = "DELETE FROM compras.julgamento_item WHERE exercicio = '{$exercicio}' AND cod_cotacao = $codCotacao AND cod_item = $codItem AND cgm_fornecedor = $cgmFornecedor AND lote = $lote ;";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
