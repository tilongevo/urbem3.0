<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class SolicitacaoRepository extends AbstractRepository
{
    public function getProximoCodSolicitacao($exercicio, $codEntidade)
    {
        return $this->nextVal('cod_solicitacao', ['exercicio' => $exercicio, 'cod_entidade' => $codEntidade]);
    }

    public function getSolicitacoesComEntidade($exercicio)
    {
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder->select(
            's.codSolicitacao',
            'e.codEntidade',
            $queryBuilder->expr()->concat(
                $queryBuilder->expr()->concat(
                    $queryBuilder->expr()->concat(
                        $queryBuilder->expr()->concat('s.codSolicitacao', "'/'"),
                        's.exercicio'
                    ),
                    "' - '"
                ),
                'c.nomCgm'
            ) . 'AS descricao'
        );
        $queryBuilder->innerJoin(
            'Urbem\CoreBundle\Entity\Orcamento\Entidade',
            'e',
            'WITH',
            'e.codEntidade = s.codEntidade'
        );
        $queryBuilder->innerJoin(
            'Urbem\CoreBundle\Entity\SwCgm',
            'c',
            'WITH',
            'c.numcgm = e.numcgm'
        );
        $queryBuilder->where("s.exercicio = :exercicio");
        $queryBuilder->setParameter('exercicio', $exercicio);

        return $queryBuilder;
    }

    /**
     * @param int        $codEntidade
     * @param string|int $exercicio
     * @param bool       $registroPrecos
     *
     * @return mixed
     */
    public function getSolicitacoesMapaCompra($codEntidade, $exercicio, $registroPrecos)
    {
        $sql = <<<SQL
SELECT
  solicitacao.exercicio,
  solicitacao.cod_solicitacao,
  TO_CHAR(solicitacao.timestamp, 'dd/mm/yyyy') AS data,
  solicitacao.cod_objeto,
  solicitacao.cod_entidade,
  sw_cgm.nom_cgm

FROM compras.solicitacao
  INNER JOIN compras.solicitacao_homologada ON solicitacao_homologada.exercicio = solicitacao.exercicio
                                               AND solicitacao_homologada.cod_entidade = solicitacao.cod_entidade
                                               AND solicitacao_homologada.cod_solicitacao = solicitacao.cod_solicitacao
  INNER JOIN sw_cgm ON solicitacao.cgm_solicitante = sw_cgm.numcgm
  LEFT JOIN (SELECT
               solicitacao.exercicio,
               solicitacao.cod_entidade,
               solicitacao.cod_solicitacao,
               COALESCE(total_solicitacao_item.vl_total_solicitacao, 0.00) AS vl_total_solicitacao,
               COALESCE(total_mapa_item.vl_total_mapa, 0.00)               AS vl_total_mapa,
               COALESCE(total_anulado_mapa.vl_total_mapa_anulado, 0.00)    AS vl_total_mapa_anulado
             FROM compras.solicitacao
               LEFT JOIN (SELECT
                            COALESCE(SUM(solicitacao_item.vl_total), 0.00) -
                            COALESCE(SUM(solicitacao_item_anulacao.vl_total), 0.00) AS vl_total_solicitacao,
                            solicitacao_item.exercicio,
                            solicitacao_item.cod_entidade,
                            solicitacao_item.cod_solicitacao
                          FROM compras.solicitacao_item
                            LEFT JOIN compras.solicitacao_item_anulacao
                              ON solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
                                 AND solicitacao_item_anulacao.cod_entidade = solicitacao_item.cod_entidade
                                 AND solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                                 AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
                                 AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item
                          GROUP BY solicitacao_item.exercicio, solicitacao_item.cod_entidade,
                            solicitacao_item.cod_solicitacao) AS total_solicitacao_item
                 ON total_solicitacao_item.exercicio = solicitacao.exercicio
                    AND
                    total_solicitacao_item.cod_entidade = solicitacao.cod_entidade
                    AND total_solicitacao_item.cod_solicitacao =
                        solicitacao.cod_solicitacao
               LEFT JOIN (SELECT
                            COALESCE(SUM(mapa_item.vl_total), 0.00) -
                            COALESCE(SUM(mapa_item_anulacao.vl_total), 0.00) AS vl_total_mapa,
                            mapa_item.exercicio,
                            mapa_item.cod_entidade,
                            mapa_item.cod_solicitacao
                          FROM compras.mapa_item
                            LEFT JOIN compras.mapa_item_anulacao ON mapa_item_anulacao.exercicio = mapa_item.exercicio
                                                                    AND mapa_item_anulacao.cod_entidade =
                                                                        mapa_item.cod_entidade
                                                                    AND mapa_item_anulacao.cod_solicitacao =
                                                                        mapa_item.cod_solicitacao
                                                                    AND
                                                                    mapa_item_anulacao.cod_mapa = mapa_item.cod_mapa
                                                                    AND mapa_item_anulacao.cod_centro =
                                                                        mapa_item.cod_centro
                                                                    AND
                                                                    mapa_item_anulacao.cod_item = mapa_item.cod_item
                                                                    AND mapa_item_anulacao.exercicio_solicitacao =
                                                                        mapa_item.exercicio_solicitacao
                                                                    AND mapa_item_anulacao.lote = mapa_item.lote
                          GROUP BY mapa_item.exercicio, mapa_item.cod_entidade,
                            mapa_item.cod_solicitacao) AS total_mapa_item
                 ON total_mapa_item.exercicio = solicitacao.exercicio
                    AND total_mapa_item.cod_entidade = solicitacao.cod_entidade
                    AND total_mapa_item.cod_solicitacao = solicitacao.cod_solicitacao
               LEFT JOIN (SELECT
                            COALESCE(SUM(mapa_item_anulacao.vl_total), 0.00) AS vl_total_mapa_anulado,
                            mapa_item_anulacao.exercicio_solicitacao,
                            mapa_item_anulacao.cod_solicitacao,
                            mapa_item_anulacao.cod_entidade
                          FROM compras.solicitacao
                            LEFT JOIN compras.mapa_item_anulacao
                              ON mapa_item_anulacao.exercicio_solicitacao = solicitacao.exercicio
                                 AND mapa_item_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                                 AND mapa_item_anulacao.cod_entidade = solicitacao.cod_entidade
                          GROUP BY mapa_item_anulacao.exercicio_solicitacao, mapa_item_anulacao.cod_entidade,
                            mapa_item_anulacao.cod_solicitacao) AS total_anulado_mapa
                 ON total_anulado_mapa.exercicio_solicitacao = solicitacao.exercicio
                    AND total_anulado_mapa.cod_entidade = solicitacao.cod_entidade
                    AND total_anulado_mapa.cod_solicitacao =
                        solicitacao.cod_solicitacao) AS totais ON totais.exercicio = solicitacao.exercicio
                                                                  AND totais.cod_entidade = solicitacao.cod_entidade
                                                                  AND
                                                                  totais.cod_solicitacao = solicitacao.cod_solicitacao
WHERE 1 = 1
      -- se os valores forem iguias é pq já foram utilizados totalemnte e nao parcialmente, entao nao deve trazer.
      AND totais.vl_total_solicitacao <> totais.vl_total_mapa
      AND ((totais.vl_total_mapa > 0.00 AND totais.vl_total_mapa <> totais.vl_total_mapa_anulado)
           OR
           (totais.vl_total_mapa = 0.00))
      -- A SOLICITAÇÃO NÃO PODE ESTAR ANULADA.
      AND NOT EXISTS(SELECT 1
                     FROM compras.solicitacao_homologada_anulacao
                     WHERE solicitacao_homologada_anulacao.exercicio = solicitacao.exercicio
                           AND solicitacao_homologada_anulacao.cod_entidade = solicitacao.cod_entidade
                           AND solicitacao_homologada_anulacao.cod_solicitacao = solicitacao.cod_solicitacao) AND
      solicitacao.cod_entidade = :cod_entidade
      AND solicitacao.exercicio = :exercicio
      AND solicitacao.registro_precos = :registro_precos
ORDER BY solicitacao.timestamp DESC;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'registro_precos' => $registroPrecos,
            'cod_entidade'    => $codEntidade,
            'exercicio'       => $exercicio,
        ]);

        return $stmt->fetchAll();
    }

    public function getSolicitacaoNotHomologadoAndNotAnulada($exercicio, $codSolicitacao = false)
    {
        $sql = "
        SELECT solicitacao.exercicio
	               , solicitacao.cod_entidade
	               , solicitacao.cod_solicitacao
	               , TO_CHAR(solicitacao.timestamp,'dd/mm/yyyy') AS data
	               , solicitacao.timestamp
	               , solicitacao.cod_objeto
	               , sw_cgm.nom_cgm
	               , total_itens.quantidade
	               , total_itens.vl_total
	               , total_anulacoes.quantidade as quantidade_anulada
	               , total_anulacoes.vl_total  as vl_anulado
	             FROM compras.solicitacao
	             join orcamento.entidade
	               on ( solicitacao.cod_entidade = entidade.cod_entidade
	              and   solicitacao.exercicio    = entidade.exercicio )
	             join sw_cgm
	               on (entidade.numcgm = sw_cgm.numcgm )
	             ---- consulta para totalizar os itens
	             join (
	                   select solicitacao_item.exercicio
	                        , solicitacao_item.cod_entidade
	                        , solicitacao_item.cod_solicitacao
	                        , sum (solicitacao_item.quantidade ) as quantidade
	                        , sum (solicitacao_item.vl_total   ) as vl_total
	                     from compras.solicitacao_item
	                   group by solicitacao_item.exercicio
	                        , solicitacao_item.cod_entidade
	                        , solicitacao_item.cod_solicitacao) as total_itens
	               on ( solicitacao.exercicio       = total_itens.exercicio
	              and   solicitacao.cod_entidade    = total_itens.cod_entidade
	              and   solicitacao.cod_solicitacao = total_itens.cod_solicitacao  )
	             ---- consulta para totalizar as anulações
	          left join (
	                     select solicitacao_item_anulacao.cod_solicitacao
	                         , sum (solicitacao_item_anulacao.quantidade ) as quantidade
	                         , sum (solicitacao_item_anulacao.vl_total   ) as vl_total
	                      from compras.solicitacao_item_anulacao
	                    group by solicitacao_item_anulacao.cod_solicitacao ) as total_anulacoes
	               on (  solicitacao.cod_solicitacao = total_anulacoes.cod_solicitacao  )
	          where 1 = 1
	                   AND solicitacao.exercicio = '" . $exercicio . "'
	AND (NOT EXISTS ( SELECT 1
	                                          FROM compras.solicitacao_homologada
	                                         WHERE solicitacao_homologada.cod_entidade = solicitacao.cod_entidade
	                                           AND solicitacao_homologada.cod_solicitacao = solicitacao.cod_solicitacao
	                                           AND solicitacao_homologada.exercicio = solicitacao.exercicio
	                                      )
	                            OR EXISTS ( SELECT 1
	                                 FROM compras.solicitacao_homologada_anulacao
	                                WHERE solicitacao_homologada_anulacao.cod_entidade = solicitacao.cod_entidade
	                                  AND solicitacao_homologada_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
	                                  AND solicitacao_homologada_anulacao.exercicio = solicitacao.exercicio
	                          ))";
        if ($codSolicitacao) {
            $sql .= " AND solicitacao.cod_solicitacao = $codSolicitacao ";
        }
        $sql .= " ORDER BY cod_solicitacao DESC, timestamp, cod_entidade ASC";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function insertIntoSolicitacaoDotacao($codSolicitacao, $codDespesa, $exercicio)
    {
        $sql = "
            INSERT INTO patrimonio.solicitacao_dotacao
            VALUES($codSolicitacao, $codDespesa, $exercicio);";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function montaincluiReservaSaldo($cod_reserva, $exercicio, $cod_despesa, $dt_validade_inicial, $dt_validade_final, $vl_reserva, $tipo, $motivo)
    {
        $sql = "select orcamento.fn_reserva_saldo (" . $cod_reserva . ", '" . $exercicio . "', " . $cod_despesa . ", '" . $dt_validade_inicial->format('Y-m-d H:m:i') . "', '" . $dt_validade_final->format('Y-m-d H:m:i') . "', " . $vl_reserva . ", '" . $tipo . "', '" . $motivo . "') ; ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function getProximaCodReservaSaldo($complemento = '')
    {
        $query = $this->_em->getConnection()->prepare("SELECT MAX(cod_reserva) AS CODIGO FROM orcamento.reserva_saldos" . $complemento);
        $query->execute();
        $result = current($query->fetchAll());
        $result = array_shift($result);

        if ($result) {
            return $result + 1;
        }

        return false;
    }

    public function getPatrimonioSolicitacaoDotacao($exercicio, $cod_solicitacao)
    {
        $query = $this->_em->getConnection()->prepare("SELECT * FROM patrimonio.solicitacao_dotacao WHERE exercicio = '" . $exercicio . "' and cod_solicitacao = " . $cod_solicitacao . ";");
        $query->execute();
        $result = current($query->fetchAll());

        if ($result) {
            return $result;
        }

        return null;
    }

    public function montaRecuperaPermissaoAnularHomologacao($cod_solicitcao, $cod_entidade, $exericio)
    {
        $sql = "SELECT  CASE WHEN COUNT(1) > 0 THEN 'true'
                              ELSE 'false'
                         END as permissao_excluir
                   FROM  compras.solicitacao
                  WHERE  solicitacao.cod_solicitacao = " . $cod_solicitcao . "
                    AND  solicitacao.cod_entidade    = " . $cod_entidade . "
                    AND  solicitacao.exercicio       ='" . $exericio . "'
                    AND
                     (
                         NOT EXISTS
                             (
                                 SELECT  1
                                   FROM  compras.mapa_solicitacao
                                  WHERE  mapa_solicitacao.cod_entidade    = solicitacao.cod_entidade
                                    AND  mapa_solicitacao.exercicio       = solicitacao.exercicio
                                    AND  mapa_solicitacao.cod_solicitacao = solicitacao.cod_solicitacao
                             )
                         OR
                         (
                             (
                                 SELECT  coalesce(SUM(mapa_item_anulacao.quantidade),0)
                                   FROM  compras.mapa_item_anulacao
                                  WHERE  mapa_item_anulacao.exercicio       = solicitacao.exercicio
                                    AND  mapa_item_anulacao.cod_entidade    = solicitacao.cod_entidade
                                    AND  mapa_item_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                             )
                             -
                             (
                                 SELECT  coalesce(SUM(mapa_item.quantidade),0)
                                   FROM  compras.mapa_item
                                  WHERE  mapa_item.exercicio       = solicitacao.exercicio
                                    AND  mapa_item.cod_entidade    = solicitacao.cod_entidade
                                    AND  mapa_item.cod_solicitacao = solicitacao.cod_solicitacao
                             )
                         ) = 0
                     )
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        $result = $query->fetchAll();
        return array_shift($result);
    }

    public function montaRecuperaTodosNomEntidade($exercicio, $cod_entidade, $cod_solicitacao)
    {
        $sql = "SELECT  solicitacao_homologada_reserva.exercicio
                       ,  solicitacao_homologada_reserva.cod_entidade
                       ,  sw_cgm.nom_cgm AS nom_entidade
                       ,  cod_solicitacao
                       ,  cod_centro
                       ,  cod_item
                       ,  cod_reserva
                       ,  cod_conta
                       ,  cod_despesa

                    FROM  compras.solicitacao_homologada_reserva

              INNER JOIN  orcamento.entidade
                      ON  solicitacao_homologada_reserva.cod_entidade = entidade.cod_entidade
        AND  solicitacao_homologada_reserva.exercicio    = entidade.exercicio

              INNER JOIN  sw_cgm
                      ON  entidade.numcgm = sw_cgm.numcgm
                WHERE  solicitacao_homologada_reserva.exercicio       = '" . $exercicio . "'
                  AND  solicitacao_homologada_reserva.cod_entidade    =  " . $cod_entidade . "
                  AND  solicitacao_homologada_reserva.cod_solicitacao =  " . $cod_solicitacao . ";
                      ";
        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function montaRecuperaSolicitacaoAgrupadaNaoAnulada($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade)
    {
        $stSql = "select solicitacao.cod_solicitacao
                     , solicitacao.observacao
                     , solicitacao.exercicio
                     , solicitacao.cod_almoxarifado
                     , solicitacao.cod_entidade
                     , solicitacao.cgm_solicitante
                     , solicitacao.cgm_requisitante
                     , solicitacao.cod_objeto
                     , solicitacao.prazo_entrega
                     , solicitacao.timestamp
                  from compras.compra_direta
            inner join compras.mapa_cotacao
                    on mapa_cotacao.cod_mapa = compra_direta.cod_mapa
                   and mapa_cotacao.exercicio_mapa = compra_direta.exercicio_mapa
            inner join compras.cotacao
                    on cotacao.cod_cotacao    = mapa_cotacao.cod_cotacao
                   and cotacao.exercicio      = mapa_cotacao.exercicio_cotacao
            inner join compras.cotacao_item
                    on cotacao_item.cod_cotacao   = cotacao.cod_cotacao
                   and cotacao_item.exercicio     = cotacao.exercicio
            inner join compras.cotacao_fornecedor_item
                    on cotacao_item.cod_cotacao          = cotacao_fornecedor_item.cod_cotacao
                   and cotacao_item.exercicio            = cotacao_fornecedor_item.exercicio
                   and cotacao_item.cod_item             = cotacao_fornecedor_item.cod_item
                   and cotacao_item.lote                 = cotacao_fornecedor_item.lote
            inner join compras.julgamento_item
                    on julgamento_item.exercicio = cotacao_fornecedor_item.exercicio
                   and julgamento_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                   and julgamento_item.cod_item = cotacao_fornecedor_item.cod_item
                   and julgamento_item.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
                   and julgamento_item.lote = cotacao_fornecedor_item.lote
            inner join compras.mapa_item
                    on mapa_cotacao.cod_mapa      = mapa_item.cod_mapa
                   and mapa_cotacao.exercicio_mapa= mapa_item.exercicio
                   and mapa_item.cod_item      = cotacao_fornecedor_item.cod_item
                   and mapa_item.lote          = cotacao_fornecedor_item.lote
            inner join compras.mapa_item_dotacao
                    on mapa_item_dotacao.exercicio             = mapa_item.exercicio
                   and mapa_item_dotacao.cod_mapa              = mapa_item.cod_mapa
                   and mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                   and mapa_item_dotacao.cod_entidade          = mapa_item.cod_entidade
                   and mapa_item_dotacao.cod_solicitacao       = mapa_item.cod_solicitacao
                   and mapa_item_dotacao.cod_centro            = mapa_item.cod_centro
                   and mapa_item_dotacao.cod_item              = mapa_item.cod_item
                   and mapa_item_dotacao.lote                  = mapa_item.lote
            inner join compras.mapa_solicitacao
                    on mapa_solicitacao.exercicio             = mapa_item.exercicio
                   and mapa_solicitacao.cod_entidade          = mapa_item.cod_entidade
                   and mapa_solicitacao.cod_solicitacao       = mapa_item.cod_solicitacao
                   and mapa_solicitacao.cod_mapa              = mapa_item.cod_mapa
                   and mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
            inner join compras.solicitacao_homologada
                    on solicitacao_homologada.exercicio       = mapa_solicitacao.exercicio_solicitacao
                   and solicitacao_homologada.cod_entidade    = mapa_solicitacao.cod_entidade
                   and solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
            inner join compras.solicitacao
                    on solicitacao.exercicio       = solicitacao_homologada.exercicio
                   and solicitacao.cod_entidade    = solicitacao_homologada.cod_entidade
                   and solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
            inner join compras.solicitacao_item
                    on solicitacao_item.exercicio          = mapa_item.exercicio
                   and solicitacao_item.cod_entidade       = mapa_item.cod_entidade
                   and solicitacao_item.cod_solicitacao    = mapa_item.cod_solicitacao
                   and solicitacao_item.cod_centro         = mapa_item.cod_centro
                   and solicitacao_item.cod_item           = mapa_item.cod_item
                   and solicitacao_item.exercicio          = solicitacao.exercicio
                   and solicitacao_item.cod_entidade       = solicitacao.cod_entidade
                   and solicitacao_item.cod_solicitacao    = solicitacao.cod_solicitacao
            inner join compras.solicitacao_item_dotacao
                    on solicitacao_item.exercicio        = solicitacao_item_dotacao.exercicio
                   and solicitacao_item.cod_entidade     = solicitacao_item_dotacao.cod_entidade
                   and solicitacao_item.cod_solicitacao  = solicitacao_item_dotacao.cod_solicitacao
                   and solicitacao_item.cod_centro       = solicitacao_item_dotacao.cod_centro
                   and solicitacao_item.cod_item         = solicitacao_item_dotacao.cod_item
                   and mapa_item_dotacao.cod_despesa     = solicitacao_item_dotacao.cod_despesa
                 where compra_direta.cod_compra_direta is not null
                     AND  compra_direta.cod_compra_direta  = " . $codCompraDireta . "
                     AND  compra_direta.cod_modalidade     = " . $codModalidade . "
                     AND  compra_direta.cod_entidade       = " . $codEntidade . "
                     AND  compra_direta.exercicio_entidade = '" . $exercicioEntidade . "'
                AND NOT EXISTS (
                                 SELECT  1
                                   FROM  compras.cotacao_anulada
                                  WHERE  cotacao_anulada.cod_cotacao = cotacao.cod_cotacao
                                    AND  cotacao_anulada.exercicio   = cotacao.exercicio
                               )

                AND NOT EXISTS (
                                 SELECT 1
                                   FROM compras.solicitacao_anulacao
                                  WHERE solicitacao_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                                    AND solicitacao_anulacao.exercicio   = solicitacao.exercicio
                                    AND solicitacao_anulacao.cod_entidade   = solicitacao.cod_entidade
                                )

                      GROUP BY  solicitacao.cod_solicitacao
                             ,  solicitacao.observacao
                             ,  solicitacao.exercicio
                             ,  solicitacao.cod_almoxarifado
                             ,  solicitacao.cod_entidade
                             ,  solicitacao.cgm_solicitante
                             ,  solicitacao.cgm_requisitante
                             ,  solicitacao.cod_objeto
                             ,  solicitacao.prazo_entrega
                             ,  solicitacao.timestamp;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codEntidade
     * @param $codSolicitacao
     * @param $exercicio
     * @return array
     */
    public function recuperaRelacionamentoItemHomologacao($codEntidade, $codSolicitacao, $exercicio)
    {
        $stSql = "SELECT
                                   catalogo_item.descricao_resumida
                                ,  catalogo_item.descricao as descricao_completa
                                ,  unidade_medida.nom_unidade
                                ,  centro_custo.cod_centro
                                ,  centro_custo.descricao
                                ,  solicitacao_item.cod_item
                                ,  solicitacao_item.complemento
                                ,  solicitacao_item.exercicio
                                ,  despesa.cod_despesa
                                ,  conta_despesa.descricao AS nomdespesa
                                ,  conta_despesa.cod_conta
                                ,  conta_despesa.cod_estrutural as desdobramento
                                ,  empenho.fn_saldo_dotacao(solicitacao_item_dotacao.exercicio,
                                                          solicitacao_item_dotacao.cod_despesa) as saldo
                                -- SALDO DA SOLICITAÇÃO
                                , CASE WHEN solicitacao_item_dotacao.cod_conta is not null THEN
                                      (coalesce(sum(solicitacao_item_dotacao.vl_reserva), 0.00) - coalesce(sum(solicitacao_item_dotacao_anulacao.vl_anulacao), 0.00))
                                  ELSE
                                      (coalesce(sum(solicitacao_item.vl_total), 0.00) - coalesce(sum(solicitacao_item_anulacao.vl_total), 0.00))
                                  END AS vl_item_solicitacao
                                , CASE WHEN solicitacao_item_dotacao.cod_conta is not null THEN
                                      (coalesce(sum(solicitacao_item_dotacao.quantidade), 0.0000) - coalesce(sum(solicitacao_item_dotacao_anulacao.quantidade), 0.0000))
                                  ELSE
                                     (coalesce(sum(solicitacao_item.quantidade), 0.0000) - coalesce(sum(solicitacao_item_anulacao.quantidade), 0.0000))
                                  END AS qnt_item_solicitacao
                                -- RESERVA DE SALDOS
                                , coalesce(sum(reserva.vl_reserva), 0.00) as vl_reserva
                                , CASE WHEN reserva.cod_reserva is not null THEN reserva.cod_reserva ELSE null END AS cod_reserva
                             FROM compras.solicitacao
                       INNER JOIN  compras.solicitacao_item
                               ON  solicitacao_item.exercicio       = solicitacao.exercicio
                              AND  solicitacao_item.cod_entidade    = solicitacao.cod_entidade
                              AND  solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao
                       INNER JOIN  almoxarifado.catalogo_item
                               ON  catalogo_item.cod_item = solicitacao_item.cod_item
                       INNER JOIN  administracao.unidade_medida
                               ON  catalogo_item.cod_unidade  = unidade_medida.cod_unidade
                              AND  catalogo_item.cod_grandeza = unidade_medida.cod_grandeza
                       INNER JOIN  almoxarifado.centro_custo
                               ON  solicitacao_item.cod_centro   = centro_custo.cod_centro
                        LEFT JOIN  compras.solicitacao_item_dotacao
                               ON  solicitacao_item_dotacao.exercicio       = solicitacao_item.exercicio
                              AND  solicitacao_item_dotacao.cod_entidade    = solicitacao_item.cod_entidade
                              AND  solicitacao_item_dotacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                              AND  solicitacao_item_dotacao.cod_centro      = solicitacao_item.cod_centro
                              AND  solicitacao_item_dotacao.cod_item        = solicitacao_item.cod_item
                        --- pegando a dotação
                        LEFT JOIN  orcamento.despesa
                               ON  despesa.exercicio   = solicitacao_item_dotacao.exercicio
                              AND  despesa.cod_despesa = solicitacao_item_dotacao.cod_despesa
                           --- pegando o desdobramento
                        LEFT JOIN  orcamento.conta_despesa
                               ON  conta_despesa.exercicio = solicitacao_item_dotacao.exercicio
                              AND  conta_despesa.cod_conta = solicitacao_item_dotacao.cod_conta
                        LEFT JOIN( SELECT solicitacao_item_anulacao.cod_item
                                        , solicitacao_item_anulacao.exercicio
                                        , solicitacao_item_anulacao.cod_entidade
                                        , solicitacao_item_anulacao.cod_solicitacao
                                        , solicitacao_item_anulacao.cod_centro
                                        , sum(solicitacao_item_anulacao.vl_total) as vl_total
                                        , sum(solicitacao_item_anulacao.quantidade) as quantidade
                                     FROM compras.solicitacao_item_anulacao
                                 GROUP BY solicitacao_item_anulacao.cod_item
                                        , solicitacao_item_anulacao.exercicio
                                        , solicitacao_item_anulacao.cod_entidade
                                        , solicitacao_item_anulacao.cod_solicitacao
                                        , solicitacao_item_anulacao.cod_centro        ) as solicitacao_item_anulacao
                               ON solicitacao_item_anulacao.cod_item        = solicitacao_item.cod_item
                              AND solicitacao_item_anulacao.exercicio       = solicitacao_item.exercicio
                              AND solicitacao_item_anulacao.cod_entidade    = solicitacao_item.cod_entidade
                              AND solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                              AND solicitacao_item_anulacao.cod_centro      = solicitacao_item.cod_centro
                        LEFT JOIN( SELECT solicitacao_item_dotacao_anulacao.exercicio
                                        , solicitacao_item_dotacao_anulacao.cod_entidade
                                        , solicitacao_item_dotacao_anulacao.cod_solicitacao
                                        , solicitacao_item_dotacao_anulacao.cod_centro
                                        , solicitacao_item_dotacao_anulacao.cod_item
                                        , solicitacao_item_dotacao_anulacao.cod_conta
                                        , solicitacao_item_dotacao_anulacao.cod_despesa
                                        , sum(solicitacao_item_dotacao_anulacao.vl_anulacao) as vl_anulacao
                                        , sum(solicitacao_item_dotacao_anulacao.quantidade) as quantidade
                                     FROM compras.solicitacao_item_dotacao_anulacao
                                 GROUP BY solicitacao_item_dotacao_anulacao.exercicio
                                        , solicitacao_item_dotacao_anulacao.cod_entidade
                                        , solicitacao_item_dotacao_anulacao.cod_solicitacao
                                        , solicitacao_item_dotacao_anulacao.cod_centro
                                        , solicitacao_item_dotacao_anulacao.cod_item
                                        , solicitacao_item_dotacao_anulacao.cod_conta
                                        , solicitacao_item_dotacao_anulacao.cod_despesa ) as solicitacao_item_dotacao_anulacao
                               ON solicitacao_item_dotacao_anulacao.exercicio        = solicitacao_item_dotacao.exercicio
                              AND solicitacao_item_dotacao_anulacao.cod_entidade     = solicitacao_item_dotacao.cod_entidade
                              AND solicitacao_item_dotacao_anulacao.cod_solicitacao  = solicitacao_item_dotacao.cod_solicitacao
                              AND solicitacao_item_dotacao_anulacao.cod_centro       = solicitacao_item_dotacao.cod_centro
                              AND solicitacao_item_dotacao_anulacao.cod_item         = solicitacao_item_dotacao.cod_item
                              AND solicitacao_item_dotacao_anulacao.cod_conta        = solicitacao_item_dotacao.cod_conta
                              AND solicitacao_item_dotacao_anulacao.cod_despesa      = solicitacao_item_dotacao.cod_despesa
                        LEFT JOIN compras.solicitacao_homologada ON solicitacao_homologada.exercicio       = solicitacao.exercicio
                              AND solicitacao_homologada.cod_entidade    = solicitacao.cod_entidade
                              AND solicitacao_homologada.cod_solicitacao = solicitacao.cod_solicitacao
                        LEFT JOIN compras.solicitacao_homologada_reserva
                               ON solicitacao_homologada_reserva.cod_solicitacao = solicitacao_homologada.cod_solicitacao
                              AND solicitacao_homologada_reserva.cod_entidade    = solicitacao_homologada.cod_entidade
                              AND solicitacao_homologada_reserva.exercicio       = solicitacao_homologada.exercicio
                              AND solicitacao_homologada_reserva.exercicio       = solicitacao_item_dotacao.exercicio
                              AND solicitacao_homologada_reserva.cod_entidade    = solicitacao_item_dotacao.cod_entidade
                              AND solicitacao_homologada_reserva.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                              AND solicitacao_homologada_reserva.cod_centro      = solicitacao_item_dotacao.cod_centro
                              AND solicitacao_homologada_reserva.cod_item        = solicitacao_item_dotacao.cod_item
                              AND solicitacao_homologada_reserva.cod_conta       = solicitacao_item_dotacao.cod_conta
                              AND solicitacao_homologada_reserva.cod_despesa     = solicitacao_item_dotacao.cod_despesa
                        LEFT JOIN( SELECT cod_reserva
                                        , exercicio
                                        , vl_reserva
                                     FROM
                                          orcamento.reserva_saldos
                                    WHERE
                                          not exists( SELECT 1
                                                        FROM orcamento.reserva_saldos_anulada
                                                       WHERE reserva_saldos_anulada.cod_reserva = reserva_saldos.cod_reserva
                                                         AND reserva_saldos_anulada.exercicio   = reserva_saldos.exercicio    ) ) as reserva
                               ON(     reserva.cod_reserva = solicitacao_homologada_reserva.cod_reserva
                                   AND reserva.exercicio   = solicitacao_homologada_reserva.exercicio   )
                            WHERE  solicitacao.exercicio       = '" . $exercicio . "'
                              AND  solicitacao.cod_entidade    = " . $codEntidade . "
                              AND  solicitacao.cod_solicitacao = " . $codSolicitacao . "
                         GROUP BY
                                   catalogo_item.descricao_resumida
                                ,  catalogo_item.descricao
                                ,  unidade_medida.nom_unidade
                                ,  centro_custo.cod_centro
                                ,  centro_custo.descricao
                                ,  solicitacao_item.cod_item
                                ,  solicitacao_item.complemento
                                ,  solicitacao_item.exercicio
                                ,  despesa.cod_despesa
                                ,  conta_despesa.descricao
                                ,  conta_despesa.cod_conta
                                ,  conta_despesa.cod_estrutural
                                ,  solicitacao_item_dotacao.cod_despesa
                                ,  solicitacao_item_dotacao.cod_conta
                                ,  solicitacao_item_dotacao.exercicio
                                ,  reserva.cod_reserva
       ";
        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }





    public function recuperaSolicitacaoItensAnulacao($codSolicitacao, $codEntidade, $exercicio)
    {
        $sql = "
           SELECT
               solicitacao_item_dotacao.cod_despesa
             , solicitacao_item_dotacao.cod_conta

             , CASE WHEN solicitacao_item_dotacao.cod_conta is not null THEN
                   solicitacao_item_dotacao.cod_item
               ELSE
                   solicitacao_item.cod_item
               END as cod_item

             , catalogo_item.descricao_resumida
             , unidade_medida.nom_unidade
             , centro_custo.cod_centro
             , solicitacao_homologada_reserva.cod_reserva
             , centro_custo.descricao
             , CASE WHEN solicitacao_item_dotacao.cod_conta is not null THEN
                  (coalesce(solicitacao_item_dotacao.vl_reserva, 0.00) - coalesce(solicitacao_item_dotacao_anulacao.vl_anulacao, 0.00))
               ELSE
                   (coalesce(solicitacao_item.vl_total, 0.00) - coalesce(solicitacao_item_anulacao.vl_total, 0.00))
               END AS vl_dotacao_solicitacao

             , CASE WHEN solicitacao_item_dotacao.cod_conta is not null THEN
                   (coalesce(solicitacao_item_dotacao.quantidade, 0.0000) - coalesce(solicitacao_item_dotacao_anulacao.quantidade, 0.0000))
               ELSE
                  (coalesce(solicitacao_item.quantidade, 0.0000) - coalesce(solicitacao_item_anulacao.quantidade, 0.0000))
               END AS qnt_dotacao_solicitacao

             , CASE WHEN solicitacao_item_dotacao.cod_conta is not null THEN
                  (coalesce(mapa_item_dotacao.vl_dotacao, 0.00) - coalesce(mapa_item_anulacao.vl_total,0.00)  )
               ELSE
                  (coalesce(mapa_item.vl_total, 0.00) - coalesce(mapa_item_anulacao.vl_total,0.00))
               END AS vl_dotacao_mapa

             , CASE WHEN solicitacao_item_dotacao.cod_conta is not null THEN
                  (coalesce(mapa_item_dotacao.quantidade, 0.0000) - coalesce(mapa_item_anulacao.quantidade, 0.0000))
               ELSE
                  (coalesce(mapa_item.quantidade, 0.0000) - coalesce(mapa_item_anulacao.quantidade, 0.0000))
               END as qnt_dotacao_mapa

          FROM compras.solicitacao
               JOIN compras.solicitacao_item
                 ON solicitacao_item.exercicio        = solicitacao.exercicio
                AND solicitacao_item.cod_entidade     = solicitacao.cod_entidade
                AND solicitacao_item.cod_solicitacao  = solicitacao.cod_solicitacao

               LEFT JOIN( SELECT solicitacao_item_anulacao.exercicio
                               , solicitacao_item_anulacao.cod_entidade
                               , solicitacao_item_anulacao.cod_solicitacao
                               , solicitacao_item_anulacao.cod_centro
                               , solicitacao_item_anulacao.cod_item
                               , sum(solicitacao_item_anulacao.quantidade) as quantidade
                               , sum(solicitacao_item_anulacao.vl_total)   as vl_total
                            FROM compras.solicitacao_item_anulacao
                        GROUP BY solicitacao_item_anulacao.exercicio
                               , solicitacao_item_anulacao.cod_entidade
                               , solicitacao_item_anulacao.cod_solicitacao
                               , solicitacao_item_anulacao.cod_centro
                               , solicitacao_item_anulacao.cod_item ) as solicitacao_item_anulacao
                      ON(     solicitacao_item_anulacao.exercicio        = solicitacao_item.exercicio
                          AND solicitacao_item_anulacao.cod_entidade     = solicitacao_item.cod_entidade
                          AND solicitacao_item_anulacao.cod_solicitacao  = solicitacao_item.cod_solicitacao
                          AND solicitacao_item_anulacao.cod_centro       = solicitacao_item.cod_centro
                          AND solicitacao_item_anulacao.cod_item         = solicitacao_item.cod_item  )

               -- INICIO DE VALORES E QUANTIDADES
               LEFT JOIN( SELECT solicitacao_item_dotacao.exercicio
                               , solicitacao_item_dotacao.cod_entidade
                               , solicitacao_item_dotacao.cod_solicitacao
                               , solicitacao_item_dotacao.cod_centro
                               , solicitacao_item_dotacao.cod_item
                               , solicitacao_item_dotacao.cod_conta
                               , solicitacao_item_dotacao.cod_despesa
                               , sum(solicitacao_item_dotacao.vl_reserva) as vl_reserva
                               , sum(solicitacao_item_dotacao.quantidade) as quantidade
                            FROM compras.solicitacao_item_dotacao
                        GROUP BY solicitacao_item_dotacao.exercicio
                               , solicitacao_item_dotacao.cod_entidade
                               , solicitacao_item_dotacao.cod_solicitacao
                               , solicitacao_item_dotacao.cod_centro
                               , solicitacao_item_dotacao.cod_item
                               , solicitacao_item_dotacao.cod_conta
                               , solicitacao_item_dotacao.cod_despesa ) as solicitacao_item_dotacao
                      ON(     solicitacao_item_dotacao.exercicio       = solicitacao_item.exercicio
                          AND solicitacao_item_dotacao.cod_entidade    = solicitacao_item.cod_entidade
                          AND solicitacao_item_dotacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                          AND solicitacao_item_dotacao.cod_centro      = solicitacao_item.cod_centro
                          AND solicitacao_item_dotacao.cod_item        = solicitacao_item.cod_item )

               LEFT JOIN( SELECT solicitacao_item_dotacao_anulacao.exercicio
                               , solicitacao_item_dotacao_anulacao.cod_entidade
                               , solicitacao_item_dotacao_anulacao.cod_solicitacao
                               , solicitacao_item_dotacao_anulacao.cod_centro
                               , solicitacao_item_dotacao_anulacao.cod_item
                               , solicitacao_item_dotacao_anulacao.cod_conta
                               , solicitacao_item_dotacao_anulacao.cod_despesa
                               , sum(solicitacao_item_dotacao_anulacao.quantidade)    as quantidade
                               , sum(solicitacao_item_dotacao_anulacao.vl_anulacao)   as vl_anulacao
                            FROM compras.solicitacao_item_dotacao_anulacao
                        GROUP BY solicitacao_item_dotacao_anulacao.exercicio
                               , solicitacao_item_dotacao_anulacao.cod_entidade
                               , solicitacao_item_dotacao_anulacao.cod_solicitacao
                               , solicitacao_item_dotacao_anulacao.cod_centro
                               , solicitacao_item_dotacao_anulacao.cod_item
                               , solicitacao_item_dotacao_anulacao.cod_conta
                               , solicitacao_item_dotacao_anulacao.cod_despesa ) as solicitacao_item_dotacao_anulacao
                      ON(     solicitacao_item_dotacao_anulacao.exercicio       = solicitacao_item_dotacao.exercicio
                          AND solicitacao_item_dotacao_anulacao.cod_entidade    = solicitacao_item_dotacao.cod_entidade
                          AND solicitacao_item_dotacao_anulacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                          AND solicitacao_item_dotacao_anulacao.cod_centro      = solicitacao_item_dotacao.cod_centro
                          AND solicitacao_item_dotacao_anulacao.cod_item        = solicitacao_item_dotacao.cod_item
                          AND solicitacao_item_dotacao_anulacao.cod_conta       = solicitacao_item_dotacao.cod_conta
                          AND solicitacao_item_dotacao_anulacao.cod_despesa     = solicitacao_item_dotacao.cod_despesa )

               LEFT JOIN( SELECT mapa_item_dotacao.exercicio_solicitacao
                               , mapa_item_dotacao.cod_entidade
                               , mapa_item_dotacao.cod_solicitacao
                               , mapa_item_dotacao.cod_centro
                               , mapa_item_dotacao.cod_item
                               , mapa_item_dotacao.cod_conta
                               , mapa_item_dotacao.cod_despesa
                               , sum(mapa_item_dotacao.quantidade)    as quantidade
                               , sum(mapa_item_dotacao.vl_dotacao)    as vl_dotacao
                            FROM compras.mapa_item_dotacao
                        GROUP BY mapa_item_dotacao.exercicio_solicitacao
                               , mapa_item_dotacao.cod_entidade
                               , mapa_item_dotacao.cod_solicitacao
                               , mapa_item_dotacao.cod_centro
                               , mapa_item_dotacao.cod_item
                               , mapa_item_dotacao.cod_conta
                               , mapa_item_dotacao.cod_despesa ) as mapa_item_dotacao
                      ON(     mapa_item_dotacao.exercicio_solicitacao = solicitacao_item_dotacao.exercicio
                          AND mapa_item_dotacao.cod_entidade          = solicitacao_item_dotacao.cod_entidade
                          AND mapa_item_dotacao.cod_solicitacao       = solicitacao_item_dotacao.cod_solicitacao
                          AND mapa_item_dotacao.cod_centro            = solicitacao_item_dotacao.cod_centro
                          AND mapa_item_dotacao.cod_item              = solicitacao_item_dotacao.cod_item
                          AND mapa_item_dotacao.cod_conta             = solicitacao_item_dotacao.cod_conta
                          AND mapa_item_dotacao.cod_despesa           = solicitacao_item_dotacao.cod_despesa )

               LEFT JOIN( SELECT mapa_item_anulacao.exercicio_solicitacao
                               , mapa_item_anulacao.cod_entidade
                               , mapa_item_anulacao.cod_solicitacao
                               , mapa_item_anulacao.cod_centro
                               , mapa_item_anulacao.cod_item
                               , mapa_item_anulacao.cod_conta
                               , mapa_item_anulacao.cod_despesa
                               , sum(mapa_item_anulacao.quantidade)  as quantidade
                               , sum(mapa_item_anulacao.vl_total)    as vl_total
                            FROM compras.mapa_item_anulacao
                        GROUP BY mapa_item_anulacao.exercicio_solicitacao
                               , mapa_item_anulacao.cod_entidade
                               , mapa_item_anulacao.cod_solicitacao
                               , mapa_item_anulacao.cod_centro
                               , mapa_item_anulacao.cod_item
                               , mapa_item_anulacao.cod_conta
                               , mapa_item_anulacao.cod_despesa ) as mapa_item_anulacao
                      ON(     mapa_item_anulacao.exercicio_solicitacao  = mapa_item_dotacao.exercicio_solicitacao
                          AND mapa_item_anulacao.cod_entidade           = mapa_item_dotacao.cod_entidade
                          AND mapa_item_anulacao.cod_solicitacao        = mapa_item_dotacao.cod_solicitacao
                          AND mapa_item_anulacao.cod_centro             = mapa_item_dotacao.cod_centro
                          AND mapa_item_anulacao.cod_item               = mapa_item_dotacao.cod_item
                          AND mapa_item_anulacao.cod_conta              = mapa_item_dotacao.cod_conta
                          AND mapa_item_anulacao.cod_despesa            = mapa_item_dotacao.cod_despesa )

               LEFT JOIN( SELECT mapa_item.exercicio_solicitacao
                               , mapa_item.cod_entidade
                               , mapa_item.cod_solicitacao
                               , mapa_item.cod_centro
                               , mapa_item.cod_item
                               , sum(mapa_item.quantidade) as quantidade
                               , sum(mapa_item.vl_total)   as vl_total
                            FROM compras.mapa_item
                        GROUP BY mapa_item.exercicio_solicitacao
                               , mapa_item.cod_entidade
                               , mapa_item.cod_solicitacao
                               , mapa_item.cod_centro
                               , mapa_item.cod_item ) as mapa_item
                      ON(     mapa_item.exercicio_solicitacao = solicitacao_item.exercicio
                          AND mapa_item.cod_entidade          = solicitacao_item.cod_entidade
                          AND mapa_item.cod_solicitacao       = solicitacao_item.cod_solicitacao
                          AND mapa_item.cod_centro            = solicitacao_item.cod_centro
                          AND mapa_item.cod_item              = solicitacao_item.cod_item  )

               -- INICIO DA ENCHE??O DE LINGUI?A
              INNER JOIN  almoxarifado.catalogo_item
                      ON  catalogo_item.cod_item = solicitacao_item.cod_item
              INNER JOIN  administracao.unidade_medida
                      ON  catalogo_item.cod_unidade  = unidade_medida.cod_unidade
                     AND  catalogo_item.cod_grandeza = unidade_medida.cod_grandeza
              INNER JOIN  almoxarifado.centro_custo
                      ON  solicitacao_item.cod_centro = centro_custo.cod_centro

               LEFT JOIN compras.solicitacao_homologada
                      ON solicitacao_homologada.exercicio       = solicitacao.exercicio
                     AND solicitacao_homologada.cod_entidade    = solicitacao.cod_entidade
                     AND solicitacao_homologada.cod_solicitacao = solicitacao.cod_solicitacao

               LEFT JOIN compras.solicitacao_homologada_reserva
                      ON solicitacao_homologada_reserva.cod_solicitacao = solicitacao_homologada.cod_solicitacao
                     AND solicitacao_homologada_reserva.cod_entidade    = solicitacao_homologada.cod_entidade
                     AND solicitacao_homologada_reserva.exercicio       = solicitacao_homologada.exercicio

                     AND solicitacao_homologada_reserva.exercicio       = solicitacao_item_dotacao.exercicio
                     AND solicitacao_homologada_reserva.cod_entidade    = solicitacao_item_dotacao.cod_entidade
                     AND solicitacao_homologada_reserva.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                     AND solicitacao_homologada_reserva.cod_centro      = solicitacao_item_dotacao.cod_centro
                     AND solicitacao_homologada_reserva.cod_item        = solicitacao_item_dotacao.cod_item
                     AND solicitacao_homologada_reserva.cod_conta       = solicitacao_item_dotacao.cod_conta
                     AND solicitacao_homologada_reserva.cod_despesa     = solicitacao_item_dotacao.cod_despesa
         WHERE
               solicitacao.exercicio       = '".$exercicio."'
           AND solicitacao.cod_entidade    =  ".$codEntidade."
           AND solicitacao.cod_solicitacao =  ".$codSolicitacao."
           ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }





    /**
     * @param $codSolicitacao
     * @param $codEntidade
     * @param $exercicio
     * @return array
     */
    public function montaRecuperaItensConsulta($codSolicitacao, $codEntidade, $exercicio)
    {
        $sql = "
           SELECT
                   solicitacao_item.cod_item
                ,  catalogo_item.descricao_resumida
                ,  unidade_medida.nom_unidade
                ,  centro_custo.cod_centro
                ,  centro_custo.descricao
                ,  CASE WHEN solicitacao_item_dotacao.cod_conta IS NOT NULL THEN
                      coalesce(solicitacao_item_dotacao.quantidade, 0.0000)
                   ELSE
                      coalesce(solicitacao_item.quantidade, 0.0000)
                   END                                                                                                     AS qnt_solicitada
                ,  CASE WHEN solicitacao_item_dotacao.cod_conta IS NOT NULL THEN
                      coalesce(solicitacao_item_dotacao_anulacao.quantidade, 0.0000)
                   ELSE
                      coalesce(solicitacao_item_anulacao.quantidade, 0.0000)
                   END                                                                                                     AS qnt_anulada
                ,  CASE WHEN solicitacao_item_dotacao.cod_conta IS NOT NULL THEN
                      coalesce(mapa_item_dotacao.quantidade, 0.0000) - coalesce(mapa_item_anulacao.quantidade, 0.0000)
                   ELSE
                      coalesce(mapa_item.quantidade, 0.0000) - coalesce(mapa_item_anulacao.quantidade, 0.0000)
                   END                                                                                                     AS qnt_mapa
                ,  CASE WHEN solicitacao_item_dotacao.cod_conta IS NOT NULL THEN
                      coalesce(solicitacao_item_dotacao.vl_reserva, 0.00)
                   ELSE
                      coalesce(solicitacao_item.vl_total, 0.00)
                   END                                                                                                     AS vl_solicitado
                ,  CASE WHEN solicitacao_item_dotacao.cod_conta IS NOT NULL THEN
                      coalesce(solicitacao_item_dotacao_anulacao.vl_anulacao, 0.00)
                   ELSE
                      coalesce(solicitacao_item_anulacao.vl_total, 0.00)
                   END                                                                                                     AS vl_anulado
                ,  CASE WHEN solicitacao_item_dotacao.cod_conta IS NOT NULL THEN
                      coalesce(mapa_item_dotacao.vl_dotacao, 0.00) - coalesce(mapa_item_anulacao.vl_total, 0.00)
                   ELSE
                      coalesce(mapa_item.vl_total, 0.00) - coalesce(mapa_item_anulacao.vl_total, 0.00)
                   END                                                                                                     AS vl_mapa
                ,  despesa.cod_despesa           as hint_cod_despesa
                ,  conta_despesa.descricao       as hint_nom_despesa
                ,  conta_despesa.cod_estrutural  as hint_cod_estrutural
                ,  ppa.acao.num_acao             as hint_num_pao
                ,  pao.nom_pao                   as hint_nom_pao
                ,  recurso.cod_recurso           as hint_cod_recurso
                ,  recurso.nom_recurso           as hint_nom_recurso

                , CASE WHEN mapa_item_dotacao.vl_dotacao > 0.00 THEN
                      CASE WHEN (coalesce(mapa_item_dotacao.vl_dotacao, 0.00) - coalesce(mapa_item_anulacao.vl_total, 0.00)) = 0.00 THEN
                         'false'
                      ELSE
                         'true'
                      END
                  ELSE
                     'true'
                  END AS bo_totalizar
             FROM  compras.solicitacao_item
                   JOIN almoxarifado.catalogo_item
                     ON solicitacao_item.cod_item = catalogo_item.cod_item
                   JOIN almoxarifado.centro_custo
                     ON centro_custo.cod_centro = solicitacao_item.cod_centro
                   JOIN administracao.unidade_medida
                     ON catalogo_item.cod_unidade  = unidade_medida.cod_unidade
                    AND catalogo_item.cod_grandeza = unidade_medida.cod_grandeza
                   -- VALORES DOTACAO
                   LEFT JOIN( SELECT solicitacao_item_dotacao.exercicio
                                   , solicitacao_item_dotacao.cod_entidade
                                   , solicitacao_item_dotacao.cod_solicitacao
                                   , solicitacao_item_dotacao.cod_centro
                                   , solicitacao_item_dotacao.cod_item
                                   , solicitacao_item_dotacao.cod_conta
                                   , solicitacao_item_dotacao.cod_despesa
                                   , sum(solicitacao_item_dotacao.vl_reserva) as vl_reserva
                                   , sum(solicitacao_item_dotacao.quantidade) as quantidade
                                FROM compras.solicitacao_item_dotacao
                            GROUP BY solicitacao_item_dotacao.exercicio
                                   , solicitacao_item_dotacao.cod_entidade
                                   , solicitacao_item_dotacao.cod_solicitacao
                                   , solicitacao_item_dotacao.cod_centro
                                   , solicitacao_item_dotacao.cod_item
                                   , solicitacao_item_dotacao.cod_conta
                                   , solicitacao_item_dotacao.cod_despesa ) as solicitacao_item_dotacao
                          ON(     solicitacao_item_dotacao.exercicio       = solicitacao_item.exercicio
                              AND solicitacao_item_dotacao.cod_entidade    = solicitacao_item.cod_entidade
                              AND solicitacao_item_dotacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                              AND solicitacao_item_dotacao.cod_centro      = solicitacao_item.cod_centro
                              AND solicitacao_item_dotacao.cod_item        = solicitacao_item.cod_item )
                   LEFT JOIN( SELECT solicitacao_item_dotacao_anulacao.exercicio
                                   , solicitacao_item_dotacao_anulacao.cod_entidade
                                   , solicitacao_item_dotacao_anulacao.cod_solicitacao
                                   , solicitacao_item_dotacao_anulacao.cod_centro
                                   , solicitacao_item_dotacao_anulacao.cod_item
                                   , solicitacao_item_dotacao_anulacao.cod_conta
                                   , solicitacao_item_dotacao_anulacao.cod_despesa
                                   , sum(solicitacao_item_dotacao_anulacao.quantidade)    as quantidade
                                   , sum(solicitacao_item_dotacao_anulacao.vl_anulacao)   as vl_anulacao
                                FROM compras.solicitacao_item_dotacao_anulacao
                            GROUP BY solicitacao_item_dotacao_anulacao.exercicio
                                   , solicitacao_item_dotacao_anulacao.cod_entidade
                                   , solicitacao_item_dotacao_anulacao.cod_solicitacao
                                   , solicitacao_item_dotacao_anulacao.cod_centro
                                   , solicitacao_item_dotacao_anulacao.cod_item
                                   , solicitacao_item_dotacao_anulacao.cod_conta
                                   , solicitacao_item_dotacao_anulacao.cod_despesa ) as solicitacao_item_dotacao_anulacao
                          ON(     solicitacao_item_dotacao_anulacao.exercicio       = solicitacao_item_dotacao.exercicio
                              AND solicitacao_item_dotacao_anulacao.cod_entidade    = solicitacao_item_dotacao.cod_entidade
                              AND solicitacao_item_dotacao_anulacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                              AND solicitacao_item_dotacao_anulacao.cod_centro      = solicitacao_item_dotacao.cod_centro
                              AND solicitacao_item_dotacao_anulacao.cod_item        = solicitacao_item_dotacao.cod_item
                              AND solicitacao_item_dotacao_anulacao.cod_conta       = solicitacao_item_dotacao.cod_conta
                              AND solicitacao_item_dotacao_anulacao.cod_despesa     = solicitacao_item_dotacao.cod_despesa )
                   LEFT JOIN( SELECT
                                     mapa_item_dotacao.exercicio_solicitacao
                                   , mapa_item_dotacao.cod_entidade
                                   , mapa_item_dotacao.cod_solicitacao
                                   , mapa_item_dotacao.cod_centro
                                   , mapa_item_dotacao.cod_item
                                   , mapa_item_dotacao.cod_conta
                                   , mapa_item_dotacao.cod_despesa
                                   , sum(mapa_item_dotacao.quantidade)    as quantidade
                                   , sum(mapa_item_dotacao.vl_dotacao)    as vl_dotacao
                                FROM compras.mapa_item_dotacao
                            GROUP BY
                                     mapa_item_dotacao.exercicio_solicitacao
                                   , mapa_item_dotacao.cod_entidade
                                   , mapa_item_dotacao.cod_solicitacao
                                   , mapa_item_dotacao.cod_centro
                                   , mapa_item_dotacao.cod_item
                                   , mapa_item_dotacao.cod_conta
                                   , mapa_item_dotacao.cod_despesa ) as mapa_item_dotacao
                          ON(     mapa_item_dotacao.exercicio_solicitacao = solicitacao_item_dotacao.exercicio
                              AND mapa_item_dotacao.cod_entidade          = solicitacao_item_dotacao.cod_entidade
                              AND mapa_item_dotacao.cod_solicitacao       = solicitacao_item_dotacao.cod_solicitacao
                              AND mapa_item_dotacao.cod_centro            = solicitacao_item_dotacao.cod_centro
                              AND mapa_item_dotacao.cod_item              = solicitacao_item_dotacao.cod_item
                              AND mapa_item_dotacao.cod_conta             = solicitacao_item_dotacao.cod_conta
                              AND mapa_item_dotacao.cod_despesa           = solicitacao_item_dotacao.cod_despesa )
                   LEFT JOIN( SELECT
                                     mapa_item_anulacao.exercicio_solicitacao
                                   , mapa_item_anulacao.cod_entidade
                                   , mapa_item_anulacao.cod_solicitacao
                                   , mapa_item_anulacao.cod_centro
                                   , mapa_item_anulacao.cod_item
                                   , mapa_item_anulacao.cod_conta
                                   , mapa_item_anulacao.cod_despesa
                                   , sum(mapa_item_anulacao.quantidade)  as quantidade
                                   , sum(mapa_item_anulacao.vl_total)    as vl_total
                                FROM compras.mapa_item_anulacao
                            GROUP BY
                                     mapa_item_anulacao.exercicio_solicitacao
                                   , mapa_item_anulacao.cod_entidade
                                   , mapa_item_anulacao.cod_solicitacao
                                   , mapa_item_anulacao.cod_centro
                                   , mapa_item_anulacao.cod_item
                                   , mapa_item_anulacao.cod_conta
                                   , mapa_item_anulacao.cod_despesa ) as mapa_item_anulacao
                          ON(
                                  mapa_item_anulacao.exercicio_solicitacao  = mapa_item_dotacao.exercicio_solicitacao
                              AND mapa_item_anulacao.cod_entidade           = mapa_item_dotacao.cod_entidade
                              AND mapa_item_anulacao.cod_solicitacao        = mapa_item_dotacao.cod_solicitacao
                              AND mapa_item_anulacao.cod_centro             = mapa_item_dotacao.cod_centro
                              AND mapa_item_anulacao.cod_item               = mapa_item_dotacao.cod_item
                              AND mapa_item_anulacao.cod_conta              = mapa_item_dotacao.cod_conta
                              AND mapa_item_anulacao.cod_despesa            = mapa_item_dotacao.cod_despesa )
                   -- FIM VALORES DOTACAO
                   -- VALORES SEM DOTACAO
                   LEFT JOIN( SELECT solicitacao_item_anulacao.exercicio
                                   , solicitacao_item_anulacao.cod_entidade
                                   , solicitacao_item_anulacao.cod_solicitacao
                                   , solicitacao_item_anulacao.cod_centro
                                   , solicitacao_item_anulacao.cod_item
                                   , sum(solicitacao_item_anulacao.quantidade) as quantidade
                                   , sum(solicitacao_item_anulacao.vl_total)   as vl_total
                                FROM compras.solicitacao_item_anulacao
                            GROUP BY solicitacao_item_anulacao.exercicio
                                   , solicitacao_item_anulacao.cod_entidade
                                   , solicitacao_item_anulacao.cod_solicitacao
                                   , solicitacao_item_anulacao.cod_centro
                                   , solicitacao_item_anulacao.cod_item ) as solicitacao_item_anulacao
                          ON(     solicitacao_item_anulacao.exercicio        = solicitacao_item.exercicio
                              AND solicitacao_item_anulacao.cod_entidade     = solicitacao_item.cod_entidade
                              AND solicitacao_item_anulacao.cod_solicitacao  = solicitacao_item.cod_solicitacao
                              AND solicitacao_item_anulacao.cod_centro       = solicitacao_item.cod_centro
                              AND solicitacao_item_anulacao.cod_item         = solicitacao_item.cod_item  )
                   LEFT JOIN( SELECT mapa_item.exercicio_solicitacao
                                   , mapa_item.cod_entidade
                                   , mapa_item.cod_solicitacao
                                   , mapa_item.cod_centro
                                   , mapa_item.cod_item
                                   , sum(mapa_item.quantidade) as quantidade
                                   , sum(mapa_item.vl_total)   as vl_total
                                FROM compras.mapa_item
                            GROUP BY mapa_item.exercicio_solicitacao
                                   , mapa_item.cod_entidade
                                   , mapa_item.cod_solicitacao
                                   , mapa_item.cod_centro
                                   , mapa_item.cod_item ) as mapa_item
                          ON(     mapa_item.exercicio_solicitacao = solicitacao_item.exercicio
                              AND mapa_item.cod_entidade          = solicitacao_item.cod_entidade
                              AND mapa_item.cod_solicitacao       = solicitacao_item.cod_solicitacao
                              AND mapa_item.cod_centro            = solicitacao_item.cod_centro
                              AND mapa_item.cod_item              = solicitacao_item.cod_item  )
                   -- FIM VALORES SEM DOTACAO
                   -- HINTS
                   LEFT JOIN  orcamento.despesa
                          ON  despesa.exercicio   = solicitacao_item_dotacao.exercicio
                         AND  despesa.cod_despesa = solicitacao_item_dotacao.cod_despesa
                   LEFT JOIN  orcamento.conta_despesa
                          ON  conta_despesa.exercicio = solicitacao_item_dotacao.exercicio
                         AND  conta_despesa.cod_conta = solicitacao_item_dotacao.cod_conta
                   LEFT JOIN  orcamento.recurso
                          ON  recurso.exercicio   = despesa.exercicio
                         AND  recurso.cod_recurso = despesa.cod_recurso
                   LEFT JOIN  orcamento.pao
                          ON  pao.exercicio = despesa.exercicio
                         AND  pao.num_pao   = despesa.num_pao
                   LEFT JOIN  orcamento.pao_ppa_acao
              ON  pao_ppa_acao.num_pao = orcamento.pao.num_pao
             AND  pao_ppa_acao.exercicio = orcamento.pao.exercicio
       LEFT JOIN  ppa.acao
              ON  ppa.acao.cod_acao = pao_ppa_acao.cod_acao
                   -- FIM HINTS
            WHERE  solicitacao_item.cod_solicitacao = " . $codSolicitacao . "
              AND  solicitacao_item.cod_entidade    = " . $codEntidade . "
              AND  solicitacao_item.exercicio       = '" . $exercicio . "'";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codSolicitacao
     * @param $codEntidade
     * @param $exercicio
     * @return array
     */
    public function montaRecuperaItemSolicitacao($codSolicitacao, $codEntidade, $exercicio)
    {
        $stSql = "
           SELECT
                   solicitacao_item.cod_item
                ,  solicitacao_item.complemento
                ,  catalogo_item.descricao_resumida
                ,  unidade_medida.nom_unidade
                ,  centro_custo.cod_centro
                ,  centro_custo.descricao
                ,  COALESCE(solicitacao_item.quantidade, 0.00)                                                                 AS quantidade_item
                ,  COALESCE(solicitacao_item.vl_total,0.00) - COALESCE(solicitacao_item_anulacao.vl_total,0.00)::numeric(14,2) AS vl_total_item
                ,  CASE WHEN solicitacao_item_dotacao.quantidade IS NULL THEN
                        COALESCE(solicitacao_item.quantidade,0.00) - COALESCE(solicitacao_item_anulacao.quantidade,0.00)
                   ELSE
                        COALESCE(solicitacao_item_dotacao.quantidade,0.00) - COALESCE(solicitacao_item_dotacao_anulacao.quantidade,0.00)
                   END AS quantidade
                ,  CASE WHEN conta_despesa.cod_conta IS NOT NULL THEN
                        COALESCE(solicitacao_item_dotacao.vl_reserva,0.00) - COALESCE(solicitacao_item_dotacao_anulacao.vl_anulacao,0.00)
                    ELSE
                        COALESCE(solicitacao_item.vl_total,0.00) - COALESCE(solicitacao_item_anulacao.vl_total,0.00)
                   END::numeric(14,2) AS vl_total
                ,  CASE WHEN solicitacao_item_dotacao.cod_conta IS NOT NULL THEN
                        COALESCE(solicitacao_item_dotacao_anulacao.quantidade,0.00)
                   ELSE
                        COALESCE(solicitacao_item_anulacao.quantidade,0.00)
                   END::numeric(14,4) AS quantidade_anulada
                ,  CASE WHEN solicitacao_item_dotacao.cod_conta IS NOT NULL THEN
                        COALESCE(solicitacao_item_dotacao_anulacao.vl_anulacao,0.00)
                   ELSE
                        COALESCE(solicitacao_item_anulacao.vl_total,0.00)
                   END::numeric(14,2) AS vl_anulado
                ,  CASE WHEN conta_despesa.cod_conta IS NOT NULL THEN
                        COALESCE((solicitacao_item_dotacao.vl_reserva/solicitacao_item_dotacao.quantidade),0.00)
                   ELSE
                        COALESCE((solicitacao_item.vl_total/solicitacao_item.quantidade),0.00)
                   END::numeric(14,2) AS vl_unitario
                ,  despesa.cod_despesa
                ,  conta_despesa.descricao AS nomdespesa
                ,  conta_despesa.cod_conta
                ,  conta_despesa.cod_estrutural AS desdobramento
                ,  empenho.fn_saldo_dotacao(solicitacao_item_dotacao.exercicio, solicitacao_item_dotacao.cod_despesa) AS saldo
                ,  solicitacao_item_dotacao.vl_reserva
                ,  solicitacao_item_dotacao.exercicio
                ,  solicitacao_item.cod_solicitacao
                ,  solicitacao_item.cod_entidade
                ,  solicitacao_item.exercicio as exercicio_solicitacao
             FROM  compras.solicitacao_item
       INNER JOIN  almoxarifado.catalogo_item
               ON  catalogo_item.cod_item = solicitacao_item.cod_item
       INNER JOIN  administracao.unidade_medida
               ON  catalogo_item.cod_unidade  = unidade_medida.cod_unidade
              AND  catalogo_item.cod_grandeza = unidade_medida.cod_grandeza
       INNER JOIN  almoxarifado.centro_custo
               ON  solicitacao_item.cod_centro = centro_custo.cod_centro
        LEFT JOIN  compras.solicitacao_item_dotacao
               ON  solicitacao_item_dotacao.exercicio       = solicitacao_item.exercicio
              AND  solicitacao_item_dotacao.cod_entidade    = solicitacao_item.cod_entidade
              AND  solicitacao_item_dotacao.cod_solicitacao = solicitacao_item.cod_solicitacao
              AND  solicitacao_item_dotacao.cod_centro      = solicitacao_item.cod_centro
              AND  solicitacao_item_dotacao.cod_item        = solicitacao_item.cod_item
        LEFT JOIN  (SELECT SUM(solicitacao_item_anulacao.quantidade ) AS quantidade
                         , SUM(solicitacao_item_anulacao.vl_total ) AS vl_total
                         , solicitacao_item_anulacao.cod_item
                         , solicitacao_item_anulacao.exercicio 
                         , solicitacao_item_anulacao.cod_entidade
                         , solicitacao_item_anulacao.cod_solicitacao
                         , solicitacao_item_anulacao.cod_centro
                      FROM compras.solicitacao_item_anulacao
                  GROUP BY solicitacao_item_anulacao.cod_item
                         , solicitacao_item_anulacao.exercicio
                         , solicitacao_item_anulacao.cod_entidade
                         , solicitacao_item_anulacao.cod_solicitacao
                         , solicitacao_item_anulacao.cod_centro
                   ) AS solicitacao_item_anulacao
               ON  solicitacao_item_anulacao.cod_item        = solicitacao_item.cod_item
              AND  solicitacao_item_anulacao.exercicio       = solicitacao_item.exercicio
              AND  solicitacao_item_anulacao.cod_entidade    = solicitacao_item.cod_entidade
              AND  solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
              AND  solicitacao_item_anulacao.cod_centro      = solicitacao_item.cod_centro
        LEFT JOIN  (SELECT SUM(solicitacao_item_dotacao_anulacao.quantidade ) AS quantidade
                         , SUM(solicitacao_item_dotacao_anulacao.vl_anulacao ) AS vl_anulacao
                         , solicitacao_item_dotacao_anulacao.cod_item 
                         , solicitacao_item_dotacao_anulacao.exercicio 
                         , solicitacao_item_dotacao_anulacao.cod_entidade
                         , solicitacao_item_dotacao_anulacao.cod_solicitacao
                         , solicitacao_item_dotacao_anulacao.cod_centro 
                         , solicitacao_item_dotacao_anulacao.cod_despesa
                      FROM compras.solicitacao_item_dotacao_anulacao
                  GROUP BY solicitacao_item_dotacao_anulacao.cod_item 
                         , solicitacao_item_dotacao_anulacao.exercicio 
                         , solicitacao_item_dotacao_anulacao.cod_entidade
                         , solicitacao_item_dotacao_anulacao.cod_solicitacao
                         , solicitacao_item_dotacao_anulacao.cod_centro 
                         , solicitacao_item_dotacao_anulacao.cod_despesa
                   ) AS solicitacao_item_dotacao_anulacao      
               ON  solicitacao_item_dotacao_anulacao.cod_item        = solicitacao_item_dotacao.cod_item
              AND  solicitacao_item_dotacao_anulacao.exercicio       = solicitacao_item_dotacao.exercicio
              AND  solicitacao_item_dotacao_anulacao.cod_entidade    = solicitacao_item_dotacao.cod_entidade
              AND  solicitacao_item_dotacao_anulacao.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
              AND  solicitacao_item_dotacao_anulacao.cod_centro      = solicitacao_item_dotacao.cod_centro
              AND  solicitacao_item_dotacao_anulacao.cod_despesa     = solicitacao_item_dotacao.cod_despesa           
        -- RECUPERA A DOTAÇÃO
        LEFT JOIN  orcamento.despesa
               ON  despesa.exercicio   = solicitacao_item_dotacao.exercicio
              AND  despesa.cod_despesa = solicitacao_item_dotacao.cod_despesa
        -- RECUPERA O DESDOBRAMENTO
        LEFT JOIN  orcamento.conta_despesa
               ON  conta_despesa.exercicio = solicitacao_item_dotacao.exercicio
              AND  conta_despesa.cod_conta = solicitacao_item_dotacao.cod_conta
            WHERE  solicitacao_item.cod_solicitacao = " . $codSolicitacao . "
              AND  solicitacao_item.cod_entidade    = " . $codEntidade . "
              AND  solicitacao_item.exercicio       = '" . $exercicio . "'";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }


    /**
     * @param $find
     * @return array
     */
    public function getItensDescricao($find)
    {
        $sql = "
            select item,* from almoxarifado.catalogo_item item
            join compras.solicitacao_item solicitacao
            on solicitacao.cod_item = item.cod_item
            where item.ativo = true";

        if (is_numeric($find)) {
            $sql .= " and item.cod_item = " . $find;
        } else {
            $sql .= " and LOWER(item.descricao) like LOWER('%" . $find . "%')";
        }
        $sql .= " order by item.descricao ASC;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
