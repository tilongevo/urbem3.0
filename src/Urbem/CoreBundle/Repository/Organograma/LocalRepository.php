<?php

namespace Urbem\CoreBundle\Repository\Organograma;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class LocalRepository
 * @package Urbem\CoreBundle\Repository\Organograma
 */
class LocalRepository extends AbstractRepository
{
    /**
     *
     * Busca todos os Organograma\Local usando o codigo do Organograma\Orgao
     *
     * @param $codOrgao
     * @param $exercicio
     * @param $idInventario
     * @return array
     */
    public function getLocalInHistoricoBem($codOrgao, $exercicio, $idInventario)
    {
        $sql = <<<SQL
SELECT DISTINCT
  historico_bem.cod_orgao,
  local.cod_local,
  cod_logradouro,
  numero,
  fone,
  ramal,
  dificil_acesso,
  insalubre,
  local.descricao,
  COUNT(historico_bem.cod_bem) AS total
FROM organograma.local
  INNER JOIN (SELECT MAX(TIMESTAMP) AS TIMESTAMP, cod_bem, cod_local, cod_orgao
              FROM patrimonio.historico_bem
              GROUP BY cod_bem, cod_local, cod_orgao) AS historico_bem
    ON historico_bem.cod_local = local.cod_local
  INNER JOIN patrimonio.bem
    ON bem.cod_bem = historico_bem.cod_bem
  LEFT JOIN patrimonio.bem_baixado
    ON bem_baixado.cod_bem = bem.cod_bem
  LEFT JOIN patrimonio.inventario_historico_bem
    ON inventario_historico_bem.cod_bem     = historico_bem.cod_bem
WHERE historico_bem.cod_orgao = :cod_orgao
      AND inventario_historico_bem.id_inventario = :id_inventario
      AND inventario_historico_bem.exercicio = :exercicio
      AND  historico_bem.cod_local = local.cod_local
      AND bem_baixado.cod_bem IS NULL
GROUP BY historico_bem.cod_orgao
  , local.cod_local
  , cod_logradouro
  , numero
  , fone
  , ramal
  , dificil_acesso
  , insalubre
  , local.descricao
ORDER BY local.descricao;
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute(['cod_orgao' => $codOrgao, 'exercicio' => $exercicio, 'id_inventario' => $idInventario]);

        return $stmt->fetchAll();
    }
}
