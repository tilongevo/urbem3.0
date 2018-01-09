<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 25/07/16
 * Time: 11:42
 */

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;

class CentroCustoRepository extends ORM\EntityRepository
{
    /**
     * @param int    $entidade
     * @param string $exercicio
     * @param int    $numCgm
     *
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getDotacaoByEntidade($entidade, $exercicio, $numCgm)
    {
        $sql = <<<SQL
SELECT
  CD.cod_estrutural                                                                                       AS mascara_classificacao,
  CD.descricao,
  O.*,
  publico.fn_mascara_dinamica((SELECT valor
                               FROM administracao.configuracao
                               WHERE parametro = 'masc_despesa'
                                     AND exercicio = :exercicio), O.num_orgao
                                                                  || '.' || O.num_unidade
                                                                  || '.' || O.cod_funcao
                                                                  || '.' || O.cod_subfuncao
                                                                  || '.' || PP.num_programa
                                                                  || '.' || PA.num_acao
                                                                  || '.' || replace(cd.cod_estrutural, '.', ''))
  || '.' || publico.fn_mascara_dinamica((SELECT valor
                                         FROM administracao.configuracao
                                         WHERE parametro = 'masc_recurso'
                                               AND exercicio = :exercicio), cast(cod_recurso AS VARCHAR)) AS dotacao
FROM
  orcamento.conta_despesa AS CD, orcamento.despesa AS O
  JOIN orcamento.programa AS OP ON OP.cod_programa = O.cod_programa
                                   AND OP.exercicio = O.exercicio
  JOIN ppa.programa AS PP ON PP.cod_programa = OP.cod_programa
  JOIN orcamento.despesa_acao ON despesa_acao.cod_despesa = O.cod_despesa
                                 AND despesa_acao.exercicio_despesa = O.exercicio
  JOIN ppa.acao AS PA ON PA.cod_acao = despesa_acao.cod_acao
WHERE
  CD.exercicio IS NOT NULL
  AND O.cod_conta = CD.cod_conta
  AND O.exercicio = CD.exercicio
  AND EXISTS(SELECT 1
             FROM empenho.permissao_autorizacao
             WHERE permissao_autorizacao.num_orgao = O.num_orgao
                   AND permissao_autorizacao.numcgm = :numcgm
                   AND permissao_autorizacao.num_unidade = O.num_unidade
                   AND permissao_autorizacao.exercicio = :exercicio
                   AND O.exercicio = :exercicio AND O.cod_entidade IN ($entidade))
             ORDER BY cod_despesa, publico.fn_mascarareduzida(CD.cod_estrutural)
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'exercicio' => $exercicio,
            'numcgm'    => $numCgm,
        ]);

        return $stmt->fetchAll();
    }

    public function getCentroCustoByUserPermission($params)
    {
        $sql = <<<SQL
SELECT
  centro_custo.cod_centro
FROM almoxarifado.centro_custo AS centro_custo
  JOIN almoxarifado.centro_custo_permissao AS responsavel
    ON responsavel.cod_centro = centro_custo.cod_centro
  JOIN almoxarifado.centro_custo_permissao AS permissao
    ON permissao.cod_centro = centro_custo.cod_centro
  JOIN public.sw_cgm AS cgm
    ON cgm.numcgm = responsavel.numcgm
  LEFT JOIN almoxarifado.centro_custo_entidade cce
    ON cce.cod_centro = centro_custo.cod_centro
  JOIN orcamento.entidade AS entidade
    ON entidade.cod_entidade = cce.cod_entidade
    AND entidade.exercicio = cce.exercicio
  JOIN public.sw_cgm AS cgm_entidade
    ON cgm_entidade.numcgm = entidade.numcgm
WHERE responsavel.responsavel = TRUE
      AND cce.cod_entidade = :cod_entidade
      AND permissao.numcgm = :numcgm
  GROUP BY centro_custo.cod_centro
ORDER BY centro_custo.descricao;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
