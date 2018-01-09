<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class RequisicaoRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado
 */
class RequisicaoRepository extends AbstractRepository
{
    /**
     * @return array|null
     */
    public function getTodasRequisicoesSemDevolucao()
    {
        $sql = <<<SQL
SELECT tot_requisicao_item.exercicio ,
       tot_requisicao_item.cod_almoxarifado ,
       tot_requisicao_item.cod_requisicao ,
       to_char(requisicao.dt_requisicao,'dd/mm/yyyy') AS dt_requisicao ,
       sw_cgm.nom_cgm
FROM
  (SELECT exercicio ,
          cod_almoxarifado ,
          cod_requisicao ,
          SUM(quantidade) AS tot_qtd_item
   FROM almoxarifado.requisicao_item
   GROUP BY exercicio ,
            cod_almoxarifado ,
            cod_requisicao) AS tot_requisicao_item
LEFT JOIN
  (SELECT exercicio ,
          cod_almoxarifado ,
          cod_requisicao ,
          SUM(quantidade) AS tot_qtd_item_anu
   FROM almoxarifado.requisicao_itens_anulacao
   GROUP BY exercicio ,
            cod_almoxarifado ,
            cod_requisicao) AS requisicao_itens_anulacao ON tot_requisicao_item.exercicio = requisicao_itens_anulacao.exercicio
AND tot_requisicao_item.cod_almoxarifado = requisicao_itens_anulacao.cod_almoxarifado
AND tot_requisicao_item.cod_requisicao = requisicao_itens_anulacao.cod_requisicao
LEFT JOIN
  (SELECT lancamento_requisicao.exercicio ,
          lancamento_requisicao.cod_almoxarifado ,
          lancamento_requisicao.cod_requisicao ,
          SUM(lancamento_material.quantidade) AS tot_qtd
   FROM almoxarifado.lancamento_material ,
        almoxarifado.natureza_lancamento ,
        almoxarifado.natureza ,
        almoxarifado.lancamento_requisicao
   WHERE natureza_lancamento.cod_natureza = natureza.cod_natureza
     AND natureza_lancamento.tipo_natureza = natureza.tipo_natureza
     AND lancamento_material.num_lancamento = natureza_lancamento.num_lancamento
     AND lancamento_material.exercicio_lancamento = natureza_lancamento.exercicio_lancamento
     AND lancamento_material.cod_natureza = natureza_lancamento.cod_natureza
     AND lancamento_material.tipo_natureza = natureza_lancamento.tipo_natureza
     AND lancamento_material.cod_lancamento = lancamento_requisicao.cod_lancamento
     AND lancamento_material.cod_item = lancamento_requisicao.cod_item
     AND lancamento_material.cod_marca = lancamento_requisicao.cod_marca
     AND lancamento_material.cod_almoxarifado = lancamento_requisicao.cod_almoxarifado
   GROUP BY lancamento_requisicao.exercicio ,
            lancamento_requisicao.cod_almoxarifado ,
            lancamento_requisicao.cod_requisicao) AS lancamento_requisicao_entrada ON tot_requisicao_item.exercicio = lancamento_requisicao_entrada.exercicio
AND tot_requisicao_item.cod_almoxarifado = lancamento_requisicao_entrada.cod_almoxarifado
AND tot_requisicao_item.cod_requisicao = lancamento_requisicao_entrada.cod_requisicao ,
    sw_cgm ,
    almoxarifado.almoxarifado ,
    almoxarifado.requisicao ,
    almoxarifado.requisicao_item
WHERE tot_requisicao_item.tot_qtd_item > COALESCE(requisicao_itens_anulacao.tot_qtd_item_anu, 0)
  AND COALESCE(lancamento_requisicao_entrada.tot_qtd , 0) < 0
  AND sw_cgm.numcgm = almoxarifado.cgm_almoxarifado
  AND almoxarifado.cod_almoxarifado = tot_requisicao_item.cod_almoxarifado
  AND requisicao.exercicio = tot_requisicao_item.exercicio
  AND requisicao.cod_requisicao = tot_requisicao_item.cod_requisicao
  AND requisicao.cod_almoxarifado = tot_requisicao_item.cod_almoxarifado
  AND requisicao.exercicio = requisicao_item.exercicio
  AND requisicao.cod_requisicao = requisicao_item.cod_requisicao
  AND requisicao.cod_almoxarifado = requisicao_item.cod_almoxarifado
GROUP BY 1, 2, 3, 4, 5
ORDER BY exercicio DESC,
         cod_requisicao DESC
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return array
     */
    public function getTodasRequisicoesParaDevolucao()
    {
        $sql = <<<SQL
SELECT tot_requisicao_item.exercicio ,
       tot_requisicao_item.cod_almoxarifado ,
       tot_requisicao_item.cod_requisicao ,
       sw_cgm.nom_cgm ,
       requisicao.dt_requisicao AS dt_data_requisicao ,
       to_char(requisicao.dt_requisicao,'dd/mm/yyyy') AS dt_requisicao
FROM
  (SELECT exercicio ,
          cod_almoxarifado ,
          cod_requisicao ,
          SUM(quantidade) AS tot_qtd_item
   FROM almoxarifado.requisicao_item
   GROUP BY exercicio ,
            cod_almoxarifado ,
            cod_requisicao) AS tot_requisicao_item
LEFT JOIN
  (SELECT exercicio ,
          cod_almoxarifado ,
          cod_requisicao ,
          SUM(quantidade) AS tot_qtd_item_anu
   FROM almoxarifado.requisicao_itens_anulacao
   GROUP BY exercicio ,
            cod_almoxarifado ,
            cod_requisicao) AS requisicao_itens_anulacao ON tot_requisicao_item.exercicio = requisicao_itens_anulacao.exercicio
AND tot_requisicao_item.cod_almoxarifado = requisicao_itens_anulacao.cod_almoxarifado
AND tot_requisicao_item.cod_requisicao = requisicao_itens_anulacao.cod_requisicao
LEFT JOIN
  (SELECT lancamento_requisicao.exercicio ,
          lancamento_requisicao.cod_almoxarifado ,
          lancamento_requisicao.cod_requisicao ,
          SUM(lancamento_material.quantidade) AS tot_qtd_saida
   FROM almoxarifado.lancamento_material ,
        almoxarifado.natureza_lancamento ,
        almoxarifado.natureza ,
        almoxarifado.lancamento_requisicao
   WHERE natureza.tipo_natureza = 'S'
     AND natureza_lancamento.cod_natureza = natureza.cod_natureza
     AND natureza_lancamento.tipo_natureza = natureza.tipo_natureza
     AND lancamento_material.num_lancamento = natureza_lancamento.num_lancamento
     AND lancamento_material.exercicio_lancamento = natureza_lancamento.exercicio_lancamento
     AND lancamento_material.cod_natureza = natureza_lancamento.cod_natureza
     AND lancamento_material.tipo_natureza = natureza_lancamento.tipo_natureza
     AND lancamento_material.cod_lancamento = lancamento_requisicao.cod_lancamento
     AND lancamento_material.cod_item = lancamento_requisicao.cod_item
     AND lancamento_material.cod_marca = lancamento_requisicao.cod_marca
     AND lancamento_material.cod_almoxarifado = lancamento_requisicao.cod_almoxarifado
   GROUP BY lancamento_requisicao.exercicio ,
            lancamento_requisicao.cod_almoxarifado ,
            lancamento_requisicao.cod_requisicao) AS lancamento_requisicao_saida ON tot_requisicao_item.exercicio = lancamento_requisicao_saida.exercicio
AND tot_requisicao_item.cod_almoxarifado = lancamento_requisicao_saida.cod_almoxarifado
AND tot_requisicao_item.cod_requisicao = lancamento_requisicao_saida.cod_requisicao
LEFT JOIN
  (SELECT lancamento_material_devolvido.cod_almoxarifado ,
          lancamento_material_devolvido.exercicio_lancamento AS exercicio ,
          lancamento_requisicao_devolvido.cod_requisicao ,
          sum(lancamento_material_devolvido.quantidade) AS tot_qtd_item_devol
   FROM almoxarifado.lancamento_material AS lancamento_material_devolvido
   JOIN almoxarifado.lancamento_requisicao AS lancamento_requisicao_devolvido ON (lancamento_material_devolvido.cod_lancamento = lancamento_requisicao_devolvido.cod_lancamento
                                                                                  AND lancamento_material_devolvido.cod_item = lancamento_requisicao_devolvido.cod_item
                                                                                  AND lancamento_material_devolvido.cod_marca = lancamento_requisicao_devolvido.cod_marca
                                                                                  AND lancamento_material_devolvido.cod_almoxarifado = lancamento_requisicao_devolvido.cod_almoxarifado
                                                                                  AND lancamento_material_devolvido.cod_centro = lancamento_requisicao_devolvido.cod_centro)
   WHERE lancamento_material_devolvido.cod_natureza = 7
     AND lancamento_material_devolvido.tipo_natureza = 'E'
   GROUP BY lancamento_material_devolvido.cod_almoxarifado ,
            lancamento_material_devolvido.exercicio_lancamento ,
            lancamento_requisicao_devolvido.cod_requisicao) AS lancamento_requisicao_devolvida ON tot_requisicao_item.exercicio = lancamento_requisicao_devolvida.exercicio
AND tot_requisicao_item.cod_almoxarifado = lancamento_requisicao_devolvida.cod_almoxarifado
AND tot_requisicao_item.cod_requisicao = lancamento_requisicao_devolvida.cod_requisicao ,
    sw_cgm ,
    almoxarifado.almoxarifado ,
    almoxarifado.requisicao
INNER JOIN almoxarifado.requisicao_homologada ON requisicao.exercicio = requisicao_homologada.exercicio
AND requisicao.cod_almoxarifado = requisicao_homologada.cod_almoxarifado
AND requisicao.cod_requisicao = requisicao_homologada.cod_requisicao ,
    almoxarifado.requisicao_item
WHERE tot_requisicao_item.tot_qtd_item > COALESCE(requisicao_itens_anulacao.tot_qtd_item_anu, 0)
  AND tot_requisicao_item.tot_qtd_item - COALESCE(requisicao_itens_anulacao.tot_qtd_item_anu, 0) > COALESCE(abs(lancamento_requisicao_saida.tot_qtd_saida), 0) - COALESCE(lancamento_requisicao_devolvida.tot_qtd_item_devol, 0)
  AND sw_cgm.numcgm = almoxarifado.cgm_almoxarifado
  AND almoxarifado.cod_almoxarifado = tot_requisicao_item.cod_almoxarifado
  AND requisicao.exercicio = tot_requisicao_item.exercicio
  AND requisicao.cod_requisicao = tot_requisicao_item.cod_requisicao
  AND requisicao.cod_almoxarifado = tot_requisicao_item.cod_almoxarifado
  AND requisicao.exercicio = requisicao_item.exercicio
  AND requisicao.cod_requisicao = requisicao_item.cod_requisicao
  AND requisicao.cod_almoxarifado = requisicao_item.cod_almoxarifado
  AND requisicao_homologada.timestamp =
    (SELECT MAX(TIMESTAMP)
     FROM almoxarifado.requisicao_homologada requisicao_homologada2
     WHERE requisicao_homologada.exercicio = requisicao_homologada2.exercicio
       AND requisicao_homologada.cod_almoxarifado = requisicao_homologada2.cod_almoxarifado
       AND requisicao_homologada.cod_requisicao = requisicao_homologada2.cod_requisicao)
  AND requisicao_homologada.homologada = 't'
GROUP BY 1, 2, 3, 4, 5, 6
ORDER BY exercicio DESC,
         cod_requisicao DESC,
         dt_data_requisicao DESC
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param int $exercicio
     * @param int $cod_requisicao
     * @param int $cod_almoxarifado
     * @return array|null
     */
    public function getIfRequisicaoPassivelHomologacao($exercicio, $cod_requisicao, $cod_almoxarifado)
    {
        $sql = <<<SQL
SELECT req.exercicio ,
       req.cod_almoxarifado ,
       req.cod_requisicao ,
       req.cgm_requisitante ,
       req.cgm_solicitante ,
       to_char(req.dt_requisicao, 'dd/mm/yyyy') AS dt_requisicao ,
       req.observacao ,
       cgm.nom_cgm ,
       cgm.numcgm ,
       cgm2.nom_cgm AS nom_solicitante ,
       cgm2.numcgm AS num_solicitante
FROM almoxarifado.requisicao AS req ,
     almoxarifado.requisicao_item AS reqi
LEFT JOIN almoxarifado.requisicao_itens_anulacao AS aria ON reqi.exercicio = aria.exercicio
AND reqi.cod_almoxarifado = aria.cod_almoxarifado
AND reqi.cod_requisicao = aria.cod_requisicao
AND reqi.cod_item = aria.cod_item
AND reqi.cod_marca = aria.cod_marca
AND reqi.cod_centro = aria.cod_centro
LEFT JOIN almoxarifado.lancamento_requisicao AS alr ON reqi.exercicio = alr.exercicio
AND reqi.cod_almoxarifado = alr.cod_almoxarifado
AND reqi.cod_requisicao = alr.cod_requisicao
AND reqi.cod_item = alr.cod_item
AND reqi.cod_marca = alr.cod_marca
AND reqi.cod_centro = alr.cod_centro ,
    sw_cgm AS cgm ,
    sw_cgm AS cgm2 ,
    almoxarifado.almoxarifado
WHERE req.exercicio = reqi.exercicio
  AND req.cod_almoxarifado = reqi.cod_almoxarifado
  AND req.cod_requisicao = reqi.cod_requisicao
  AND req.cgm_requisitante = cgm2.numcgm
  AND req.cod_almoxarifado = almoxarifado.cod_almoxarifado
  AND almoxarifado.cgm_almoxarifado = cgm.numcgm
  AND aria.cod_item IS NULL
  AND alr.cod_item IS NULL
  AND req.exercicio = :exercicio
  AND req.cod_requisicao = :cod_requisicao
  AND req.cod_almoxarifado = :cod_almoxarifado
GROUP BY req.exercicio ,
         req.cod_almoxarifado ,
         req.cod_requisicao ,
         req.cgm_requisitante ,
         req.cgm_solicitante ,
         req.dt_requisicao ,
         req.observacao ,
         cgm.nom_cgm ,
         cgm.numcgm ,
         cgm2.nom_cgm ,
         cgm2.numcgm
ORDER BY cod_requisicao DESC,
         req.dt_requisicao DESC
SQL;

        $conn = $this->_em->getConnection();

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'exercicio' => $exercicio,
            'cod_requisicao' => $cod_requisicao,
            'cod_almoxarifado' => $cod_almoxarifado
        ]);

        return $stmt->fetchAll();
    }



    /**
     * @param string $exercicio
     * @param int $codAlmoxarifado
     * @return int
     */
    public function getNextCodRequisicao($exercicio, $codAlmoxarifado)
    {
        $params = [
            'exercicio' => $exercicio,
            'cod_almoxarifado' => $codAlmoxarifado
        ];

        return $this->nextVal('cod_requisicao', $params);
    }
}
