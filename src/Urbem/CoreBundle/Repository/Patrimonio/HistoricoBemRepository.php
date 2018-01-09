<?php

namespace Urbem\CoreBundle\Repository\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;

/**
 * Class HistoricoBemRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio
 */
class HistoricoBemRepository extends ORM\EntityRepository
{
    /**
     * Busca todos os Patrimonio\HistoricoBem usando os códigos de
     *  Organograma\Orgao e Organograma\Local
     *
     * @param int $codOrgao
     * @param int $codLocal
     *
     * @return array
     */
    public function getHistoricoBemWithLocalAndOrgao($codOrgao, $codLocal)
    {
        $sql = <<<SQL
SELECT DISTINCT historico_bem.cod_bem,
                Trim(bem.descricao) AS nom_bem,
                Recuperadescricaoorgao(historico_bem.cod_orgao, 'NOW()') AS nom_orgao,

  (SELECT local.descricao
   FROM organograma.local
   WHERE local.cod_local = historico_bem.cod_local) AS nom_local,

  (SELECT situacao_bem.nom_situacao
   FROM patrimonio.situacao_bem
   WHERE situacao_bem.cod_situacao = historico_bem.cod_situacao) AS nom_situacao,
                Recuperadescricaoorgao(inventario_historico_bem.cod_orgao, 'NOW()') AS nom_orgao_novo,

  (SELECT local.descricao
   FROM organograma.local
   WHERE local.cod_local = inventario_historico_bem.cod_local) AS nom_local_novo,

  (SELECT situacao_bem.nom_situacao
   FROM patrimonio.situacao_bem
   WHERE situacao_bem.cod_situacao = inventario_historico_bem.cod_situacao) AS nom_situacao_novo,
                CASE
                    WHEN (inventario_historico_bem.cod_orgao <> historico_bem.cod_orgao)
                         OR (inventario_historico_bem.cod_local <> historico_bem.cod_local)
                         OR (inventario_historico_bem.descricao <> '')
                         OR (inventario_historico_bem.cod_situacao <> historico_bem.cod_situacao) THEN 'Sim'
                    ELSE 'Não'
                END AS modificado
FROM patrimonio.historico_bem
INNER JOIN patrimonio.bem ON bem.cod_bem = historico_bem.cod_bem
INNER JOIN
  (SELECT cod_bem,
          Max(TIMESTAMP) AS TIMESTAMP
   FROM patrimonio.historico_bem
   GROUP BY cod_bem) AS resumo ON resumo.cod_bem = historico_bem.cod_bem
INNER JOIN patrimonio.inventario_historico_bem ON inventario_historico_bem.cod_bem = resumo.cod_bem
WHERE 1 = 1
  AND NOT EXISTS
    (SELECT 1
     FROM patrimonio.bem_baixado
     WHERE bem_baixado.cod_bem = bem.cod_bem)
  AND inventario_historico_bem.exercicio = '2016'
  AND historico_bem.cod_orgao = :cod_orgao
  AND historico_bem.cod_local = :cod_local;
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'cod_orgao' => $codOrgao,
            'cod_local' => $codLocal
        ]);

        return $stmt->fetchAll();
    }
}
