<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;

/**
 * Class CotacaoFornecedorItemDesclassificacaoRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio\Compras
 */
class CotacaoFornecedorItemDesclassificacaoRepository extends ORM\EntityRepository
{
    /**
     * @param $codCotacao
     * @param $exercicio
     * @param $codItem
     * @param $cgmFornecedor
     * @param $lote
     * @return array
     */
    public function removeCotacaoFornecedorItemDesclassificacao($codCotacao, $exercicio, $codItem, $cgmFornecedor, $lote)
    {
        $sql = "
            DELETE
            FROM compras.cotacao_fornecedor_item_desclassificacao
            WHERE cod_cotacao = $codCotacao
            AND exercicio = '{$exercicio}'
            AND cod_item = {$codItem}
            AND cgm_fornecedor = {$cgmFornecedor}
            AND lote = {$lote}";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
