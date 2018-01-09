<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM\EntityRepository;

/**
 * Class PedidoTransferenciaRepository
 */
class PedidoTransferenciaRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getPedidosSaidaPorTransferencia()
    {
        $sql = <<<SQL
SELECT
  pedido_transferencia.exercicio,
  pedido_transferencia.cod_transferencia,
  pedido_transferencia.cod_almoxarifado_origem,
  sw_cgm_origem.nom_cgm  AS nom_almoxarifado_origem,
  pedido_transferencia.cod_almoxarifado_destino,
  sw_cgm_destino.nom_cgm AS nom_almoxarifado_destino,
  pedido_transferencia.observacao
FROM
  almoxarifado.pedido_transferencia
  JOIN almoxarifado.almoxarifado AS almoxarifado_origem
    ON almoxarifado_origem.cod_almoxarifado = pedido_transferencia.cod_almoxarifado_origem
  JOIN sw_cgm AS sw_cgm_origem
    ON sw_cgm_origem.numcgm = almoxarifado_origem.cgm_almoxarifado
  JOIN almoxarifado.almoxarifado AS almoxarifado_destino
    ON almoxarifado_destino.cod_almoxarifado = pedido_transferencia.cod_almoxarifado_destino
  JOIN sw_cgm AS sw_cgm_destino
    ON sw_cgm_destino.numcgm = almoxarifado_destino.cgm_almoxarifado
  JOIN almoxarifado.pedido_transferencia_item
    ON pedido_transferencia_item.cod_transferencia = pedido_transferencia.cod_transferencia
       AND pedido_transferencia_item.exercicio = pedido_transferencia.exercicio
  LEFT JOIN almoxarifado.pedido_transferencia_anulacao
    ON pedido_transferencia_anulacao.cod_transferencia = pedido_transferencia.cod_transferencia
       AND pedido_transferencia_anulacao.exercicio = pedido_transferencia.exercicio
  LEFT JOIN almoxarifado.transferencia_almoxarifado_item
    ON transferencia_almoxarifado_item.exercicio = pedido_transferencia.exercicio
       AND transferencia_almoxarifado_item.cod_transferencia = pedido_transferencia.cod_transferencia
       AND transferencia_almoxarifado_item.cod_item = pedido_transferencia_item.cod_item
       AND transferencia_almoxarifado_item.cod_marca = pedido_transferencia_item.cod_marca
       AND transferencia_almoxarifado_item.cod_centro = pedido_transferencia_item.cod_centro
       AND transferencia_almoxarifado_item.cod_almoxarifado = pedido_transferencia.cod_almoxarifado_origem
WHERE
  pedido_transferencia_anulacao.cod_transferencia IS NULL
  AND transferencia_almoxarifado_item.cod_transferencia IS NULL
GROUP BY
  pedido_transferencia.exercicio,
  pedido_transferencia.cod_transferencia,
  pedido_transferencia.cod_almoxarifado_origem,
  sw_cgm_origem.nom_cgm,
  pedido_transferencia.cod_almoxarifado_destino,
  sw_cgm_destino.nom_cgm,
  pedido_transferencia.observacao;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return array
     */
    public function getPedidosEntradaPorTransferencia()
    {
        $sql = <<<SQL
SELECT pedido_transferencia.*
FROM almoxarifado.pedido_transferencia pedido_transferencia
  JOIN almoxarifado.pedido_transferencia_item pedido_transferencia_item
    ON pedido_transferencia.cod_transferencia = pedido_transferencia_item.cod_transferencia AND
       pedido_transferencia.exercicio = pedido_transferencia_item.exercicio
  JOIN almoxarifado.transferencia_almoxarifado_item transferencia_almoxarifado_item_origem
    ON pedido_transferencia_item.exercicio = transferencia_almoxarifado_item_origem.exercicio AND
       pedido_transferencia_item.cod_transferencia = transferencia_almoxarifado_item_origem.cod_transferencia AND
       pedido_transferencia_item.cod_item = transferencia_almoxarifado_item_origem.cod_item AND
       pedido_transferencia_item.cod_marca = transferencia_almoxarifado_item_origem.cod_marca AND
       pedido_transferencia_item.cod_centro = transferencia_almoxarifado_item_origem.cod_centro
WHERE CONCAT(pedido_transferencia.cod_transferencia, '/', pedido_transferencia.exercicio) NOT IN
      (SELECT CONCAT(pedido_transferencia_anulacao.cod_transferencia, '/', pedido_transferencia_anulacao.exercicio)
       FROM almoxarifado.pedido_transferencia_anulacao pedido_transferencia_anulacao)
      AND pedido_transferencia_item.cod_transferencia NOT IN (
  SELECT transferencia_almoxarifado_item.cod_transferencia
  FROM almoxarifado.transferencia_almoxarifado_item transferencia_almoxarifado_item
    JOIN almoxarifado.lancamento_material lancamento_material
      ON lancamento_material.cod_lancamento = transferencia_almoxarifado_item.cod_lancamento
         AND lancamento_material.cod_item = transferencia_almoxarifado_item.cod_item
         AND lancamento_material.cod_centro = transferencia_almoxarifado_item.cod_centro
         AND lancamento_material.cod_marca = transferencia_almoxarifado_item.cod_marca
         AND lancamento_material.cod_almoxarifado = transferencia_almoxarifado_item.cod_almoxarifado
    JOIN almoxarifado.natureza_lancamento natureza_lancamento
      ON lancamento_material.exercicio_lancamento = natureza_lancamento.exercicio_lancamento AND
         lancamento_material.num_lancamento = natureza_lancamento.num_lancamento AND
         lancamento_material.cod_natureza = natureza_lancamento.cod_natureza AND
         lancamento_material.tipo_natureza = natureza_lancamento.tipo_natureza
  WHERE natureza_lancamento.tipo_natureza = 'E'
) AND NOT EXISTS(SELECT pedido_transferencia.cod_transferencia
                 FROM almoxarifado.transferencia_almoxarifado_item_destino transferencia_almoxarifado_item_destino
                 WHERE transferencia_almoxarifado_item_destino.cod_transferencia =
                       transferencia_almoxarifado_item_origem.cod_transferencia);
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Retorna um codigo de transferencia para uso.
     *
     * @return array|null
     */
    public function recuperaUltimoCodigoTransferencia()
    {
        $sql = <<<SQL
SELECT COALESCE(MAX(cod_transferencia), 0) + 1 AS cod_transferencia 
FROM almoxarifado.pedido_transferencia
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        return $stmt->fetch();
    }
}
