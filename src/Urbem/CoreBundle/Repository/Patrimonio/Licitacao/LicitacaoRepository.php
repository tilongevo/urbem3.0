<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Urbem\CoreBundle\Entity\Compras\Modalidade;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ResponsavelLicitacaoFilter;

class LicitacaoRepository extends AbstractRepository
{
    /**
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicio
     * @return int
     */
    public function getNextCodLicitacao($codModalidade, $codEntidade, $exercicio)
    {
        return $this->nextVal('cod_licitacao', ['cod_modalidade' => $codModalidade, 'cod_entidade' => $codModalidade, 'exercicio' => $exercicio]);
    }

    /*
     * Recebe como paramentros $filtros que pode ser: cod_entidade,cod_processo,exercicio_processo,cod_modalidade,exercicio,cod_licitacao,cod_mapa,exercicio_mapa,cod_tipo_licitacao,cod_criterio,cod_objeto,cod_tipo_objeto,cod_homologada
     */
    public function getLicitacaoByFiltros($filtros)
    {
        $stSql = "
            SELECT ll.cod_entidade
                  , ll.cod_licitacao
                  , ll.cod_processo||'/'||ll.exercicio_processo AS processo
                  , cm.descricao
                  , cm.cod_modalidade
                  , ll.cod_modalidade
                  , ll.cod_mapa||'/'||ll.exercicio_mapa AS mapa_compra
                  , ll.cod_entidade||' - '||cgm.nom_cgm AS entidade
                  , ll.cod_modalidade||' - '||cm.descricao AS modalidade
                  , ll.cod_objeto
                  , ll.cod_regime
                  , ll.timestamp
                  , ll.cod_tipo_objeto
                  , ll.cod_tipo_licitacao
                  , ll.cod_criterio
                  , ll.vl_cotado
                  , ll.exercicio
                  , to_char(ll.timestamp::date, 'dd/mm/yyyy') AS dt_licitacao
                  , LPAD(ll.num_orgao::VARCHAR, 2, '0') || '.' || LPAD(ll.num_unidade::VARCHAR, 2, '0') AS unidade_orcamentaria
                  , homologadas.dt_homologacao
                  , ll.tipo_chamada_publica

               FROM licitacao.licitacao AS ll

            LEFT JOIN licitacao.licitacao_anulada AS la
                 ON ll.cod_licitacao  = la.cod_licitacao
                AND ll.cod_modalidade = la.cod_modalidade
                AND ll.cod_entidade   = la.cod_entidade
                AND ll.exercicio      = la.exercicio

            LEFT JOIN (   SELECT cotacao_licitacao.cod_licitacao
                             , cotacao_licitacao.cod_modalidade
                             , cotacao_licitacao.cod_entidade
                             , cotacao_licitacao.exercicio_licitacao
                             , homologacao.homologado
                             , to_char(homologacao.timestamp::date, 'dd/mm/yyyy') AS dt_homologacao

                          FROM licitacao.cotacao_licitacao

                    INNER JOIN compras.mapa_cotacao
                            ON mapa_cotacao.cod_cotacao         = cotacao_licitacao.cod_cotacao
                           AND mapa_cotacao.exercicio_cotacao   = cotacao_licitacao.exercicio_cotacao

                    INNER JOIN compras.cotacao
                            ON cotacao.exercicio    = mapa_cotacao.exercicio_cotacao
                           AND cotacao.cod_cotacao  = mapa_cotacao.cod_cotacao
                           AND cotacao.cod_cotacao  = (SELECT MAX(MC.cod_cotacao)
                                                         FROM compras.mapa_cotacao AS MC
                                                        WHERE MC.exercicio_mapa = mapa_cotacao.exercicio_mapa
                                                          AND MC.cod_mapa = mapa_cotacao.cod_mapa)

                    INNER JOIN licitacao.adjudicacao
                            ON adjudicacao.cod_licitacao       = cotacao_licitacao.cod_licitacao
                           AND adjudicacao.cod_modalidade      = cotacao_licitacao.cod_modalidade
                           AND adjudicacao.cod_entidade        = cotacao_licitacao.cod_entidade
                           AND adjudicacao.exercicio_licitacao = cotacao_licitacao.exercicio_licitacao
                           AND adjudicacao.lote                = cotacao_licitacao.lote
                           AND adjudicacao.cod_cotacao         = cotacao_licitacao.cod_cotacao
                           AND adjudicacao.cod_item            = cotacao_licitacao.cod_item
                           AND adjudicacao.exercicio_cotacao   = cotacao_licitacao.exercicio_cotacao
                           AND adjudicacao.cgm_fornecedor      = cotacao_licitacao.cgm_fornecedor

                   INNER JOIN licitacao.homologacao
                           ON homologacao.num_adjudicacao     = adjudicacao.num_adjudicacao
                          AND homologacao.cod_entidade        = adjudicacao.cod_entidade
                          AND homologacao.cod_modalidade      = adjudicacao.cod_modalidade
                          AND homologacao.cod_licitacao       = adjudicacao.cod_licitacao
                          AND homologacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
                          AND homologacao.cod_item            = adjudicacao.cod_item
                          AND homologacao.cod_cotacao         = adjudicacao.cod_cotacao
                          AND homologacao.lote                = adjudicacao.lote
                          AND homologacao.exercicio_cotacao   = adjudicacao.exercicio_cotacao
                          AND homologacao.cgm_fornecedor      = adjudicacao.cgm_fornecedor

                     GROUP BY cotacao_licitacao.cod_licitacao
                            , cotacao_licitacao.cod_modalidade
                            , cotacao_licitacao.cod_entidade
                            , cotacao_licitacao.exercicio_licitacao
                            , homologacao.homologado
                            , homologacao.timestamp
            ) AS homologadas
            ON homologadas.cod_licitacao       = ll.cod_licitacao
            AND homologadas.cod_modalidade      = ll.cod_modalidade
            AND homologadas.cod_entidade        = ll.cod_entidade
            AND homologadas.exercicio_licitacao = ll.exercicio

            INNER JOIN compras.modalidade AS cm
            ON ll.cod_modalidade = cm.cod_modalidade

            INNER JOIN orcamento.entidade AS oe
            ON ll.cod_entidade = oe.cod_entidade
            AND ll.exercicio    = oe.exercicio

            INNER JOIN sw_cgm AS cgm
            ON oe.numcgm = cgm.numcgm

            WHERE 1 = 1
        ";

        if (isset($filtros['cod_homologada']) && $filtros['cod_homologada'] == 2) {
            $stSql .= " AND homologadas.homologado = 't'             \n";
        } elseif (isset($filtros['cod_homologada']) && $filtros['cod_homologada'] == 3) {
            $stSql .= " AND ( homologadas.homologado = 'f'
                                OR NOT EXISTS (
                                        SELECT 1
                                          FROM licitacao.homologacao
                                         WHERE ll.cod_licitacao    = homologacao.cod_licitacao
                                             AND ll.cod_modalidade = homologacao.cod_modalidade
                                             AND ll.cod_entidade   = homologacao.cod_entidade
                                             AND ll.exercicio      = homologacao.exercicio_licitacao
                                        )
                                      )       \n";
        }

        if (isset($filtros['cod_entidade'])) {
            $stSql .= "AND ll.cod_entidade in (" . $filtros['cod_entidade'] . ")             \n";
        }

        if (isset($filtros['cod_processo'])) {
            $stSql .= "AND ll.cod_processo in (" . $filtros['cod_processo'] . ")             \n";
        }

        if (isset($filtros['exercicio_processo'])) {
            $stSql .= "AND ll.exercicio_processo = '" . $filtros['exercicio_processo'] . "'  \n";
        }

        if (isset($filtros['cod_modalidade'])) {
            $stSql .= "AND ll.cod_modalidade IN (" . $filtros['cod_modalidade'] . ") \n";
        }
        if (isset($filtros['exercicio'])) {
            $stSql .= "AND ll.exercicio = '" . $filtros['exercicio'] . "'                     \n";
        }

        if (isset($filtros['cod_licitacao'])) {
            $stSql .= "AND ll.cod_licitacao = '" . $filtros['cod_licitacao'] . "'             \n";
        }

        if (isset($filtros['cod_mapa'])) {
            $stSql .= "AND ll.cod_mapa = '" . $filtros['cod_mapa'] . "'             \n";
        }

        if (isset($filtros['exercicio_mapa'])) {
            $stSql .= "AND ll.exercicio_mapa = '" . $filtros['exercicio_mapa'] . "'             \n";
        }

        if (isset($filtros['cod_tipo_licitacao'])) {
            $stSql .= "AND ll.cod_tipo_licitacao = '" . $filtros['cod_tipo_licitacao'] . "'             \n";
        }

        if (isset($filtros['cod_criterio'])) {
            $stSql .= "AND ll.cod_criterio = '" . $filtros['cod_criterio'] . "'             \n";
        }

        if (isset($filtros['cod_objeto'])) {
            $stSql .= "AND ll.cod_objeto = '" . $filtros['cod_objeto'] . "'             \n";
        }

        if (isset($filtros['cod_tipo_objeto'])) {
            $stSql .= "AND ll.cod_tipo_objeto = '" . $filtros['cod_tipo_objeto'] . "'             \n";
        }


        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getRecuperaTodos($codMapa, $exercicio)
    {
        $sql = "
          SELECT  * FROM licitacao.licitacao
               WHERE
                NOT EXISTS ( SELECT 1
                               FROM licitacao.licitacao_anulada
                              WHERE licitacao_anulada.cod_licitacao  = licitacao.cod_licitacao
                                AND licitacao_anulada.cod_modalidade = licitacao.cod_modalidade
                                AND licitacao_anulada.cod_entidade   = licitacao.cod_entidade
                                AND licitacao_anulada.exercicio      = licitacao.exercicio)
            AND licitacao.cod_mapa       =  " . $codMapa . "
            AND licitacao.exercicio_mapa = '" . $exercicio . "'";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function montaRecuperaEditalSuspender($cod_licitacao, $cod_modalidade, $cod_entidade, $num_edital, $exercicio)
    {
        $sql = "
           SELECT licitacao.cod_entidade
         , edital.num_edital
         , sw_cgm.nom_cgm AS nom_entidade
         , licitacao.cod_modalidade
         , modalidade.descricao AS nom_modalidade
         , licitacao.exercicio
         , edital.cod_licitacao
         , licitacao.cod_objeto
         , CASE WHEN (edital_suspenso.justificativa <> '') THEN
                    'Suspenso'
                ELSE 'Ativo'
           END AS situacao
         , edital_suspenso.justificativa
      FROM licitacao.licitacao
 LEFT JOIN licitacao.edital
        ON licitacao.cod_licitacao = edital.cod_licitacao
       AND licitacao.cod_modalidade = edital.cod_modalidade
       AND licitacao.cod_entidade = edital.cod_entidade
       AND licitacao.exercicio = edital.exercicio_licitacao
 LEFT JOIN licitacao.edital_suspenso
        ON edital_suspenso.num_edital = edital.num_edital
       AND edital_suspenso.exercicio = edital.exercicio
INNER JOIN compras.modalidade
        ON modalidade.cod_modalidade = licitacao.cod_modalidade
INNER JOIN orcamento.entidade
        ON entidade.exercicio = licitacao.exercicio
       AND entidade.cod_entidade = licitacao.cod_entidade
INNER JOIN sw_cgm
        ON sw_cgm.numcgm = entidade.numcgm
 LEFT JOIN compras.mapa_cotacao
        ON licitacao.cod_mapa = mapa_cotacao.cod_mapa
       AND licitacao.exercicio_mapa = mapa_cotacao.exercicio_mapa
       AND mapa_cotacao.cod_cotacao
    NOT IN ( SELECT cotacao_anulada.cod_cotacao
               FROM compras.cotacao_anulada
              WHERE cotacao_anulada.exercicio = licitacao.exercicio
           )
     WHERE NOT EXISTS ( SELECT 1
                          FROM empenho.item_pre_empenho_julgamento
                         WHERE item_pre_empenho_julgamento.exercicio = mapa_cotacao.exercicio_cotacao
                           AND item_pre_empenho_julgamento.cod_cotacao = mapa_cotacao.cod_cotacao
                      )
       AND NOT EXISTS ( SELECT 1
                          FROM licitacao.edital_anulado
                         WHERE edital_anulado.num_edital = edital.num_edital
                           AND edital_anulado.exercicio = edital.exercicio
                      )

    ";
        if ($cod_licitacao) {
            $sql .= "  and edital.cod_licitacao = " . $cod_licitacao . "\n";
        }

        if ($cod_modalidade) {
            $sql .= "  and licitacao.cod_modalidade = " . $cod_modalidade . "\n";
        }

        if ($cod_entidade) {
            $sql .= " and licitacao.cod_entidade = " . $cod_entidade . "\n";
        }

        if ($num_edital) {
            $sql .= "    AND edital.num_edital = " . $num_edital . "      \n";
        }
        if ($exercicio) {
            $sql .= "    AND edital.exercicio = '" . $exercicio . "'        \n";
        };

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getLicitacaoManutencaoPropostas($exercicio)
    {
        $sql = "
        SELECT  le.num_edital,
	                            cp.descricao,
	                            ll.exercicio,
	                            ll.cod_entidade,
	                            ll.cod_licitacao||'/'||ll.exercicio AS num_licitacao,
	                            ll.cod_entidade,
	                            cgm.nom_cgm AS entidade,
	                            ll.cod_modalidade,
	                            ll.cod_licitacao AS codLicitacao,
	                            LPAD((ll.cod_processo::VARCHAR), 5, '0') AS cod_processo,
	                            ll.exercicio_processo,
	                            ll.cod_modalidade,
	                            le.exercicio AS exercicio_edital,
	                            ll.cod_mapa,
	                            ll.exercicio_mapa,
	                            mapa.cod_tipo_licitacao,
	                            le.num_edital || '/' || le.exercicio AS num_edital_lista
	                      FROM  licitacao.licitacao AS ll
	                 LEFT JOIN  licitacao.edital AS le
	                        ON  ll.cod_licitacao  = le.cod_licitacao
	                       AND  ll.cod_modalidade = le.cod_modalidade
	                       AND  ll.cod_entidade   = le.cod_entidade
	                       AND  ll.exercicio      = le.exercicio
	                INNER JOIN  compras.mapa
	                        ON  mapa.cod_mapa = ll.cod_mapa
	                       AND  mapa.exercicio = ll.exercicio_mapa INNER JOIN  compras.modalidade AS cp
	                        ON  cp.cod_modalidade = ll.cod_modalidade
	                INNER JOIN  orcamento.entidade AS oe
	                        ON  oe.cod_entidade = ll.cod_entidade
	                       AND  oe.exercicio = ll.exercicio
	                INNER JOIN  sw_cgm AS cgm
	                        ON  cgm.numcgm = oe.numcgm
	                INNER JOIN  licitacao.comissao_licitacao
	                        ON  comissao_licitacao.exercicio      = ll.exercicio
	                       AND  comissao_licitacao.cod_entidade   = ll.cod_entidade
	                       AND  comissao_licitacao.cod_modalidade = ll.cod_modalidade
	                       AND  comissao_licitacao.cod_licitacao  = ll.cod_licitacao
	                     WHERE
	                            ( EXISTS  (   SELECT  1
	                                          FROM  licitacao.participante_documentos
	                                    INNER JOIN  licitacao.participante
	                                            ON  participante.cod_licitacao = participante_documentos.cod_licitacao
	                                           AND  participante.cgm_fornecedor = participante_documentos.cgm_fornecedor
	                                           AND  participante.cod_modalidade = participante_documentos.cod_modalidade
	                                           AND  participante.cod_entidade = participante_documentos.cod_entidade
	                                           AND  participante.exercicio = participante_documentos.exercicio
	                                    INNER JOIN  licitacao.licitacao_documentos
	                                            ON  licitacao_documentos.cod_documento = participante_documentos.cod_documento
	                                           AND  licitacao_documentos.cod_licitacao = participante_documentos.cod_licitacao
	                                           AND  licitacao_documentos.cod_modalidade = participante_documentos.cod_modalidade
	                                           AND  licitacao_documentos.cod_entidade = participante_documentos.cod_entidade
	                                           AND  licitacao_documentos.exercicio = participante_documentos.exercicio
	                                         WHERE  participante_documentos.cod_licitacao = ll.cod_licitacao
	                                           AND  participante_documentos.cod_modalidade = ll.cod_modalidade
	                                           AND  participante_documentos.cod_entidade = ll.cod_entidade
	                                           AND  participante_documentos.exercicio = ll.exercicio
	                                    ) OR ll.cod_modalidade IN (6,7)
	                ) AND
	          EXISTS ( --- esta condição serve para excluir da listagem os mapas que foram totalmente anulados
	            select mapa_itens.cod_mapa
	                 , mapa_itens.exercicio
	                 , mapa_itens.quantidade - coalesce ( mapa_item_anulacao.quantidade, 0 ) AS quantidade
	                 , mapa_itens.vl_total   - coalesce ( mapa_item_anulacao.vl_total  , 0 ) AS vl_total
	              FROM (select mapa_item.cod_mapa
	                         , mapa_item.exercicio
	                         , mapa_item.cod_item
	                         , mapa_item.lote
	                         , sum(mapa_item.quantidade) AS quantidade
	                         , sum(mapa_item.vl_total) AS vl_total
	                      FROM compras.mapa_item
	                     GROUP BY mapa_item.cod_mapa
	                            , mapa_item.exercicio
	                            , mapa_item.cod_item
	                            , mapa_item.lote) AS mapa_itens
	                ----- buscando AS possiveis anulações
	                LEFT JOIN ( select mapa_item_anulacao.cod_mapa
	                               , mapa_item_anulacao.exercicio
	                               , mapa_item_anulacao.cod_item
	                               , mapa_item_anulacao.lote
	                               , sum ( mapa_item_anulacao.vl_total   ) AS vl_total
	                               , sum ( mapa_item_anulacao.quantidade ) AS quantidade
	                            FROM compras.mapa_item_anulacao
	                          group by cod_mapa
	                                 , exercicio
	                                 , cod_item
	                                 , lote ) AS mapa_item_anulacao
	                     on ( mapa_itens.cod_mapa  = mapa_item_anulacao.cod_mapa
	                    and   mapa_itens.exercicio = mapa_item_anulacao.exercicio
	                    and   mapa_itens.cod_item  = mapa_item_anulacao.cod_item
	                    and   mapa_itens.lote      = mapa_item_anulacao.lote)
	            where mapa_itens.quantidade - coalesce ( mapa_item_anulacao.quantidade, 0 ) > 0
	              and mapa_itens.vl_total   - coalesce ( mapa_item_anulacao.vl_total  , 0 ) > 0
	              and mapa_itens.cod_mapa  = mapa.cod_mapa
	              and mapa_itens.exercicio = mapa.exercicio
	            ) and
	         ll.exercicio = '" . $exercicio . "' and  NOT EXISTS (   SELECT  1
	                                     FROM  licitacao.edital_anulado
	                                    WHERE  edital_anulado.num_edital = le.num_edital
	                                      AND  edital_anulado.exercicio  = le.exercicio
	                                    )
	                    -- Para AS modalidades 1,2,3,4,5,6,7,10,11 é obrigatório exister um edital
	                    AND CASE WHEN ll.cod_modalidade in (1,2,3,4,5,6,7,10,11) THEN
	                           le.cod_licitacao  IS NOT NULL
	                       AND le.cod_modalidade IS NOT NULL
	                       AND le.cod_entidade   IS NOT NULL
	                       AND le.exercicio      IS NOT NULL
	                      -- Para AS modalidades 8,9 é facultativo possuir um edital
	                      WHEN ll.cod_modalidade in (8,9) THEN
	                            le.cod_licitacao  IS NULL
	                         OR le.cod_modalidade IS NULL
	                         OR le.cod_entidade   IS NULL
	                         OR le.exercicio      IS NULL
	                         OR le.cod_licitacao  IS NOT NULL
	                         OR le.cod_modalidade IS NOT NULL
	                         OR le.cod_entidade   IS NOT NULL
	                         OR le.exercicio      IS NOT NULL
	                    END
	    AND (
	            NOT EXISTS  (
	                        SELECT  1
	                          FROM  compras.mapa_cotacao
	                    INNER JOIN  compras.julgamento
	                            ON  julgamento.exercicio = mapa_cotacao.exercicio_cotacao
	                           AND  julgamento.cod_cotacao = mapa_cotacao.cod_cotacao
	                         WHERE  mapa_cotacao.cod_mapa = ll.cod_mapa
	                           AND  mapa_cotacao.exercicio_mapa = ll.exercicio_mapa
	                           AND  NOT EXISTS (
	                                                SELECT  1
	                                                  FROM  compras.cotacao_anulada
	                                                 WHERE  cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
	                                                   AND  cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
	                                           )
	                        )
	        )

	    -- Retirando licitacoes que nao possuem participantes
	    AND (
	            EXISTS  (   SELECT  1
	                                          FROM  licitacao.participante
	                                         WHERE  licitacao.participante.cod_licitacao = ll.cod_licitacao
	                                           AND  licitacao.participante.cod_modalidade = ll.cod_modalidade
	                                           AND  licitacao.participante.cod_entidade = ll.cod_entidade
	                                           AND  licitacao.participante.exercicio = ll.exercicio
	            )
	    )
	    -- Retirando licitacoes que ja foram anuladas da listagem de manutencoes de proposta
	    AND NOT EXISTS ( SELECT 1
	                       FROM licitacao.licitacao_anulada
	                      WHERE ll.cod_licitacao = licitacao_anulada.cod_licitacao
	                        AND ll.cod_modalidade = licitacao_anulada.cod_modalidade
	                        AND ll.cod_entidade = licitacao_anulada.cod_entidade
	                        AND ll.exercicio = licitacao_anulada.exercicio
	                    )
	            ORDER BY
	                    le.exercicio DESC,
	                    le.num_edital,
	                    ll.exercicio DESC,
	                    ll.cod_entidade,
	                    ll.cod_licitacao,
	                    ll.cod_modalidade;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param integer $cod_licitacao
     * @param integer $cod_modalidade
     * @param integer $cod_entidade
     * @param bool $num_edital
     * @param string $exercicio
     * @return array $result
     */
    public function montaRecuperaParticipanteLicitacaoManutencaoPropostas($cod_licitacao, $cod_modalidade, $cod_entidade, $exercicio, $num_edital = false)
    {
        $sql = "
         SELECT ll.cod_entidade
             ,  entidade.nom_cgm AS nom_entidade
             ,  ll.cod_modalidade
             ,  modalidade.descricao AS nom_modalidade
             ,  ll.exercicio
             ,  le.cod_licitacao
             ,  ll.cod_objeto
             --,  cgm.numcgm
             --,  cgm.nom_cgm
             ,  lp.cgm_fornecedor
             ,  cgm_fornecedor.nom_cgm AS fornecedor
             ,  lp.numcgm_representante
             ,  cgm_representante.nom_cgm AS representante
             ,  cgm_consorcio.nom_cgm AS consorc
             ,  lp.dt_inclusao
          FROM  licitacao.licitacao AS ll
     LEFT JOIN  licitacao.edital AS le
            ON  ll.cod_licitacao = le.cod_licitacao
           AND  ll.cod_modalidade = le.cod_modalidade
           AND  ll.cod_entidade = le.cod_entidade
           AND  ll.exercicio = le.exercicio
    INNER JOIN  licitacao.participante AS lp
            ON  lp.cod_licitacao = ll.cod_licitacao
           AND  lp.cod_modalidade = ll.cod_modalidade
           AND  lp.cod_entidade = ll.cod_entidade
           AND  lp.exercicio = ll.exercicio
    INNER JOIN  sw_cgm AS cgm_fornecedor
            ON  cgm_fornecedor.numcgm = lp.cgm_fornecedor
    INNER JOIN  sw_cgm AS cgm_representante
            ON  cgm_representante.numcgm = lp.numcgm_representante
     LEFT JOIN  licitacao.participante_consorcio lpc
            ON  lp.cod_licitacao  = lpc.cod_licitacao
           AND  lp.cod_modalidade = lpc.cod_modalidade
           AND  lp.cod_entidade   = lpc.cod_entidade
           AND  lp.exercicio      = lpc.exercicio
     LEFT JOIN  sw_cgm AS cgm_consorcio
            ON  cgm_consorcio.numcgm = lpc.numcgm
    INNER JOIN  compras.modalidade
            ON  modalidade.cod_modalidade = ll.cod_modalidade
    INNER JOIN  orcamento.entidade AS oe
            ON  oe.exercicio = ll.exercicio
           AND  oe.cod_entidade = ll.cod_entidade
    INNER JOIN  sw_cgm AS entidade
            ON  entidade.numcgm = oe.numcgm
         WHERE  NOT EXISTS (  SELECT  1
                    FROM  licitacao.edital_anulado
                       WHERE  edital_anulado.num_edital = le.num_edital
                     AND  edital_anulado.exercicio = le.exercicio
                   )
           --a quantidade de documentos deve ser a mesma da quantidade de documentos preenchidos para o participante
           AND  ((  SELECT  count(1)
                FROM  licitacao.licitacao_documentos
               WHERE  licitacao_documentos.cod_licitacao = lp.cod_licitacao
                 AND  licitacao_documentos.cod_modalidade = lp.cod_modalidade
                 AND  licitacao_documentos.cod_entidade = lp.cod_entidade
                 AND  licitacao_documentos.exercicio = lp.exercicio
               ) = (
              SELECT  count(1)
                FROM  licitacao.participante_documentos
               WHERE  participante_documentos.cod_licitacao = lp.cod_licitacao
                 AND  participante_documentos.cod_modalidade = lp.cod_modalidade
                 AND  participante_documentos.cgm_fornecedor = lp.cgm_fornecedor
                 AND  participante_documentos.cod_entidade = lp.cod_entidade
                 AND  participante_documentos.exercicio = lp.exercicio
               ) OR lp.cod_modalidade IN (6,7))
    ";
        if ($cod_licitacao) {
            $sql .= "  and ll.cod_licitacao = " . $cod_licitacao . "\n";
        }

        if ($cod_modalidade) {
            $sql .= "  and ll.cod_modalidade = " . $cod_modalidade . "\n";
        }

        if ($cod_entidade) {
            $sql .= " and ll.cod_entidade = " . $cod_entidade . "\n";
        }

        if ($num_edital) {
            $sql .= "    AND le.num_edital = " . $num_edital . "      \n";
        }

        if ($exercicio) {
            $sql .= "    AND ll.exercicio = '" . $exercicio . "'        \n";
        }
        $sql .= "    order by cgm_fornecedor.numcgm \n";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function findAutorizacoesEmpenhoDisponiveis($exercicio)
    {
        $sql = "
                SELECT licitacao.cod_licitacao
                FROM licitacao.licitacao
                  JOIN compras.mapa_cotacao
                    ON (licitacao.cod_mapa = mapa_cotacao.cod_mapa
                        AND licitacao.exercicio_mapa = mapa_cotacao.exercicio_mapa)
                  JOIN compras.modalidade
                    ON (licitacao.cod_modalidade = modalidade.cod_modalidade)
                  JOIN orcamento.entidade
                    ON (licitacao.cod_entidade = entidade.cod_entidade
                        AND licitacao.exercicio = entidade.exercicio)
                  JOIN sw_cgm
                    ON (entidade.numcgm = sw_cgm.numcgm)
                WHERE exists(SELECT 1
                             FROM licitacao.homologacao
                             WHERE homologacao.homologado
                                   AND homologacao.cod_cotacao = mapa_cotacao.cod_cotacao
                                   AND homologacao.exercicio_cotacao = mapa_cotacao.exercicio_cotacao
                                   AND NOT exists(SELECT 1
                                                  FROM licitacao.homologacao_anulada
                                                  WHERE homologacao_anulada.num_homologacao = homologacao.num_homologacao
                                                        AND homologacao_anulada.cod_licitacao = homologacao.cod_licitacao
                                                        AND homologacao_anulada.cod_modalidade = homologacao.cod_modalidade
                                                        AND homologacao_anulada.cod_entidade = homologacao.cod_entidade
                                                        AND homologacao_anulada.num_adjudicacao = homologacao.num_adjudicacao
                                                        AND homologacao_anulada.exercicio_licitacao = homologacao.exercicio_licitacao
                                                        AND homologacao_anulada.lote = homologacao.lote
                                                        AND homologacao_anulada.cod_cotacao = homologacao.cod_cotacao
                                                        AND homologacao_anulada.cod_item = homologacao.cod_item
                                                        AND homologacao_anulada.exercicio_cotacao = homologacao.exercicio_cotacao
                                                        AND homologacao_anulada.cgm_fornecedor = homologacao.cgm_fornecedor)
                                   ---- deve existir ao menos um item que esteja homologado, não anulado e sem registro na tabela empenho.item_pre_empenho_julgamento
                                   ---- ou que tenha registro anulado nesta tabela
                                   AND NOT exists(SELECT 1
                                                  FROM empenho.item_pre_empenho_julgamento
                                                  WHERE item_pre_empenho_julgamento.exercicio_julgamento = homologacao.exercicio_cotacao
                                                        AND item_pre_empenho_julgamento.cod_cotacao = homologacao.cod_cotacao
                                                        AND item_pre_empenho_julgamento.cod_item = homologacao.cod_item
                                                        AND item_pre_empenho_julgamento.lote = homologacao.lote
                                                        AND item_pre_empenho_julgamento.cgm_fornecedor = homologacao.cgm_fornecedor
                             )
                      )
                      AND licitacao.exercicio = '{$exercicio}'
                      AND NOT EXISTS(SELECT 1
                                     FROM licitacao.homologacao
                                     WHERE NOT homologacao.homologado
                                           AND (NOT EXISTS(SELECT 1
                                                           FROM licitacao.homologacao_anulada
                                                           WHERE homologacao_anulada.num_homologacao = homologacao.num_homologacao
                                                                 AND homologacao_anulada.cod_licitacao = homologacao.cod_licitacao
                                                                 AND homologacao_anulada.cod_modalidade = homologacao.cod_modalidade
                                                                 AND homologacao_anulada.cod_entidade = homologacao.cod_entidade
                                                                 AND homologacao_anulada.num_adjudicacao = homologacao.num_adjudicacao
                                                                 AND homologacao_anulada.exercicio_licitacao =
                                                                     homologacao.exercicio_licitacao
                                                                 AND homologacao_anulada.lote = homologacao.lote
                                                                 AND homologacao_anulada.cod_cotacao = homologacao.cod_cotacao
                                                                 AND homologacao_anulada.cod_item = homologacao.cod_item
                                                                 AND
                                                                 homologacao_anulada.exercicio_cotacao = homologacao.exercicio_cotacao
                                                                 AND homologacao_anulada.cgm_fornecedor = homologacao.cgm_fornecedor)
                                           )
                                           AND homologacao.cod_cotacao = mapa_cotacao.cod_cotacao
                                           AND homologacao.exercicio_cotacao = mapa_cotacao.exercicio_cotacao)
                
                      -- A Licitação não pode estar anulada.
                      AND NOT EXISTS(SELECT 1
                                     FROM licitacao.licitacao_anulada
                                     WHERE licitacao_anulada.cod_licitacao = licitacao.cod_licitacao
                                           AND licitacao_anulada.cod_modalidade = licitacao.cod_modalidade
                                           AND licitacao_anulada.cod_entidade = licitacao.cod_entidade
                                           AND licitacao_anulada.exercicio = licitacao.exercicio
                )
                
                      -- Validação para não existir cotação anulada.
                      AND NOT EXISTS(SELECT 1
                                     FROM compras.cotacao_anulada
                                     WHERE cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                                           AND cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
                )
                
                      AND NOT EXISTS(SELECT 1
                                     FROM licitacao.edital_suspenso
                                       INNER JOIN licitacao.edital
                                         ON edital_suspenso.num_edital = edital.num_edital
                                            AND edital_suspenso.exercicio = edital.exercicio
                                       INNER JOIN licitacao.licitacao ll
                                         ON ll.cod_licitacao = edital.cod_licitacao
                                            AND ll.cod_modalidade = edital.cod_modalidade
                                            AND ll.cod_entidade = edital.cod_entidade
                                            AND ll.exercicio = edital.exercicio
                                     WHERE ll.cod_licitacao = licitacao.cod_licitacao
                                           AND ll.cod_modalidade = licitacao.cod_modalidade
                                           AND ll.cod_entidade = licitacao.cod_entidade
                                           AND ll.exercicio = licitacao.exercicio
                )
                
                      -- Para AS modalidades 1,2,3,4,5,6,7,10,11 é obrigatório exister um edital
                      AND CASE WHEN licitacao.cod_modalidade IN (1, 2, 3, 4, 5, 6, 7, 10, 11)
                  THEN EXISTS(SELECT 1
                              FROM licitacao.edital
                              WHERE edital.cod_licitacao = licitacao.cod_licitacao
                                    AND edital.cod_modalidade = licitacao.cod_modalidade
                                    AND edital.cod_entidade = licitacao.cod_entidade
                                    AND edital.exercicio = licitacao.exercicio
                  )
                          -- Para AS modalidades 8,9 é facultativo possuir um edital
                          WHEN licitacao.cod_modalidade IN (8, 9)
                            THEN EXISTS(SELECT 1
                                        FROM licitacao.edital
                                        WHERE edital.cod_licitacao = licitacao.cod_licitacao
                                              AND edital.cod_modalidade = licitacao.cod_modalidade
                                              AND edital.cod_entidade = licitacao.cod_entidade
                                              AND edital.exercicio = licitacao.exercicio
                                 )
                                 OR NOT EXISTS(SELECT 1
                                               FROM licitacao.edital
                                               WHERE edital.cod_licitacao = licitacao.cod_licitacao
                                                     AND edital.cod_modalidade = licitacao.cod_modalidade
                                                     AND edital.cod_entidade = licitacao.cod_entidade
                                                     AND edital.exercicio = licitacao.exercicio
                            )
                          END AND EXISTS(SELECT
                                           mp.exercicio,
                                           mp.cod_mapa,
                                           mp.cod_objeto,
                                           mp.timestamp,
                                           mp.cod_tipo_licitacao,
                                           solicitacao.registro_precos
                                         FROM compras.mapa AS mp
                                           INNER JOIN compras.mapa_solicitacao
                                             ON mapa_solicitacao.exercicio = mp.exercicio
                                                AND mapa_solicitacao.cod_mapa = mp.cod_mapa
                                           INNER JOIN compras.solicitacao_homologada
                                             ON solicitacao_homologada.exercicio = mapa_solicitacao.exercicio_solicitacao
                                                AND solicitacao_homologada.cod_entidade = mapa_solicitacao.cod_entidade
                                                AND solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
                                           INNER JOIN compras.solicitacao
                                             ON solicitacao.exercicio = solicitacao_homologada.exercicio
                                                AND solicitacao.cod_entidade = solicitacao_homologada.cod_entidade
                                                AND solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
                                         WHERE mp.cod_mapa = mapa_cotacao.cod_mapa
                                               AND mp.exercicio = mapa_cotacao.exercicio_mapa
                                         GROUP BY mp.exercicio
                                           , mp.cod_mapa
                                           , mp.cod_objeto
                                           , mp.timestamp
                                           , mp.cod_tipo_licitacao
                                           , solicitacao.registro_precos)
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /**
     * Pega a listagem dos Grupos de Autorizações do Empenho
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade']
     * @return array $result
     */
    public function montaRecuperaGrupoAutEmpenho($params)
    {
        $sql = "
        SELECT
          sum(reserva)    AS reserva,
          fornecedor,
          cod_conta,
          cod_entidade,
          cod_despesa,
          mascara_classificacao,
          cod_modalidade,
          num_orgao,
          num_unidade,
          cod_objeto,
          desc_objeto,
          historico,
          cod_tipo,
          implantado,
          count(cod_item) AS qtd_itens_homologados,
          vl_cotacao,
          quantidade, 
          exercicio,
          cod_centro,
          cod_item,
          cod_unidade,
          cod_grandeza
        FROM (
               SELECT
                 cotacao_fornecedor_item.cgm_fornecedor                AS fornecedor,
                 homologacao.cod_item,
                 solicitacao_item_dotacao.cod_despesa,
                 solicitacao_item_dotacao.cod_conta,
                 homologacao.cod_entidade,
                 vw_classificacao_despesa.mascara_classificacao,
                 licitacao.cod_modalidade,
                 despesa.num_orgao,
                 despesa.num_unidade,
                 objeto.cod_objeto,
                 objeto.descricao                                      AS desc_objeto,
                 0                                                     AS historico,
                 0                                                     AS cod_tipo,
                 FALSE                                                 AS implantado,
                 cotacao_fornecedor_item.vl_cotacao,
                 cotacao_item.quantidade,
                 licitacao.exercicio,
                 catalogo_item.cod_unidade,
                 catalogo_item.cod_grandeza,
                 solicitacao_item_dotacao.cod_centro,
                 ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
                  sum(mapa_item_dotacao.quantidade)) :: NUMERIC(14, 2) AS reserva
               FROM
                 licitacao.homologacao
                 LEFT JOIN licitacao.homologacao_anulada
                   ON homologacao.num_homologacao = homologacao_anulada.num_homologacao
                      AND homologacao.cod_licitacao = homologacao_anulada.cod_licitacao
                      AND homologacao.cod_modalidade = homologacao_anulada.cod_modalidade
                      AND homologacao.cod_entidade = homologacao_anulada.cod_entidade
                      AND homologacao.num_adjudicacao = homologacao_anulada.num_adjudicacao
                      AND homologacao.exercicio_licitacao = homologacao_anulada.exercicio_licitacao
                      AND homologacao.lote = homologacao_anulada.lote
                      AND homologacao.cod_cotacao = homologacao_anulada.cod_cotacao
                      AND homologacao.cod_item = homologacao_anulada.cod_item
                      AND homologacao.exercicio_cotacao = homologacao_anulada.exercicio_cotacao
                      AND homologacao.cgm_fornecedor = homologacao_anulada.cgm_fornecedor
                 INNER JOIN licitacao.adjudicacao
                   ON homologacao.cod_licitacao = adjudicacao.cod_licitacao
                      AND homologacao.cod_modalidade = adjudicacao.cod_modalidade
                      AND homologacao.cod_entidade = adjudicacao.cod_entidade
                      AND homologacao.num_adjudicacao = adjudicacao.num_adjudicacao
                      AND homologacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
                      AND homologacao.lote = adjudicacao.lote
                      AND homologacao.cod_cotacao = adjudicacao.cod_cotacao
                      AND homologacao.cod_item = adjudicacao.cod_item
                      AND homologacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
                      AND homologacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
                 LEFT JOIN licitacao.adjudicacao_anulada
                   ON adjudicacao.num_adjudicacao = adjudicacao_anulada.num_adjudicacao
                      AND adjudicacao.cod_licitacao = adjudicacao_anulada.cod_licitacao
                      AND adjudicacao.cod_modalidade = adjudicacao_anulada.cod_modalidade
                      AND adjudicacao.cod_entidade = adjudicacao_anulada.cod_entidade
                      AND adjudicacao.exercicio_licitacao = adjudicacao_anulada.exercicio_licitacao
                      AND adjudicacao.lote = adjudicacao_anulada.lote
                      AND adjudicacao.cod_cotacao = adjudicacao_anulada.cod_cotacao
                      AND adjudicacao.cod_item = adjudicacao_anulada.cod_item
                      AND adjudicacao.exercicio_cotacao = adjudicacao_anulada.exercicio_cotacao
                      AND adjudicacao.cgm_fornecedor = adjudicacao_anulada.cgm_fornecedor
                 INNER JOIN licitacao.cotacao_licitacao
                   ON cotacao_licitacao.cod_licitacao = adjudicacao.cod_licitacao
                      AND cotacao_licitacao.cod_modalidade = adjudicacao.cod_modalidade
                      AND cotacao_licitacao.cod_entidade = adjudicacao.cod_entidade
                      AND cotacao_licitacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
                      AND cotacao_licitacao.lote = adjudicacao.lote
                      AND cotacao_licitacao.cod_item = adjudicacao.cod_item
                      AND cotacao_licitacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
                      AND cotacao_licitacao.cod_cotacao = adjudicacao.cod_cotacao
                      AND cotacao_licitacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
                      AND cotacao_licitacao.cod_cotacao = adjudicacao.cod_cotacao
                 INNER JOIN licitacao.licitacao
                   ON licitacao.cod_licitacao = cotacao_licitacao.cod_licitacao
                      AND licitacao.cod_modalidade = cotacao_licitacao.cod_modalidade
                      AND licitacao.cod_entidade = cotacao_licitacao.cod_entidade
                      AND licitacao.exercicio = cotacao_licitacao.exercicio_licitacao
                 INNER JOIN compras.objeto
                   ON objeto.cod_objeto = licitacao.cod_objeto
                 INNER JOIN compras.cotacao_fornecedor_item
                   ON cotacao_licitacao.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                      AND cotacao_licitacao.exercicio_cotacao = cotacao_fornecedor_item.exercicio
                      AND cotacao_licitacao.cod_item = cotacao_fornecedor_item.cod_item
                      AND cotacao_licitacao.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
                      AND cotacao_licitacao.lote = cotacao_fornecedor_item.lote
                 INNER JOIN compras.cotacao_item
                   ON cotacao_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                      AND cotacao_item.exercicio = cotacao_fornecedor_item.exercicio
                      AND cotacao_item.lote = cotacao_fornecedor_item.lote
                      AND cotacao_item.cod_item = cotacao_fornecedor_item.cod_item
                 INNER JOIN compras.cotacao
                   ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
                      AND cotacao.exercicio = cotacao_item.exercicio
                 INNER JOIN compras.mapa_cotacao
                   ON cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
                      AND cotacao.exercicio = mapa_cotacao.exercicio_cotacao
                 INNER JOIN compras.mapa_item
                   ON mapa_cotacao.cod_mapa = mapa_item.cod_mapa
                      AND mapa_cotacao.exercicio_mapa = mapa_item.exercicio
                      AND mapa_item.cod_item = cotacao_licitacao.cod_item
                      AND mapa_item.lote = cotacao_licitacao.lote
                 INNER JOIN almoxarifado.catalogo_item
                    ON catalogo_item.cod_item = mapa_item.cod_item
                 LEFT JOIN compras.mapa_item_dotacao
                   ON mapa_item_dotacao.exercicio = mapa_item.exercicio
                      AND mapa_item_dotacao.cod_mapa = mapa_item.cod_mapa
                      AND mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                      AND mapa_item_dotacao.cod_entidade = mapa_item.cod_entidade
                      AND mapa_item_dotacao.cod_solicitacao = mapa_item.cod_solicitacao
                      AND mapa_item_dotacao.cod_centro = mapa_item.cod_centro
                      AND mapa_item_dotacao.cod_item = mapa_item.cod_item
                      AND mapa_item_dotacao.lote = mapa_item.lote
                 INNER JOIN compras.mapa_solicitacao
                   ON mapa_solicitacao.exercicio = mapa_item.exercicio
                      AND mapa_solicitacao.cod_entidade = mapa_item.cod_entidade
                      AND mapa_solicitacao.cod_solicitacao = mapa_item.cod_solicitacao
                      AND mapa_solicitacao.cod_mapa = mapa_item.cod_mapa
                      AND mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                 INNER JOIN compras.solicitacao_homologada
                   ON solicitacao_homologada.exercicio = mapa_solicitacao.exercicio_solicitacao
                      AND solicitacao_homologada.cod_entidade = mapa_solicitacao.cod_entidade
                      AND solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
                 INNER JOIN compras.solicitacao
                   ON solicitacao.exercicio = solicitacao_homologada.exercicio
                      AND solicitacao.cod_entidade = solicitacao_homologada.cod_entidade
                      AND solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
                 INNER JOIN compras.solicitacao_item
                   ON solicitacao_item.exercicio = mapa_item.exercicio
                      AND solicitacao_item.cod_entidade = mapa_item.cod_entidade
                      AND solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
                      AND solicitacao_item.cod_centro = mapa_item.cod_centro
                      AND solicitacao_item.cod_item = mapa_item.cod_item
                      AND solicitacao_item.exercicio = solicitacao.exercicio
                      AND solicitacao_item.cod_entidade = solicitacao.cod_entidade
                      AND solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao
                 LEFT JOIN compras.solicitacao_item_dotacao
                   ON solicitacao_item.exercicio = solicitacao_item_dotacao.exercicio
                      AND solicitacao_item.cod_entidade = solicitacao_item_dotacao.cod_entidade
                      AND solicitacao_item.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                      AND solicitacao_item.cod_centro = solicitacao_item_dotacao.cod_centro
                      AND solicitacao_item.cod_item = solicitacao_item_dotacao.cod_item
                      AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
                 LEFT JOIN orcamento.despesa
                   ON despesa.cod_despesa = solicitacao_item_dotacao.cod_despesa
                      AND despesa.exercicio = solicitacao_item_dotacao.exercicio
                 LEFT JOIN orcamento.vw_classificacao_despesa
                   ON solicitacao_item_dotacao.cod_conta = vw_classificacao_despesa.cod_conta
                      AND solicitacao_item_dotacao.exercicio = vw_classificacao_despesa.exercicio
               WHERE homologacao_anulada.cod_licitacao IS NULL
                     AND adjudicacao_anulada.cod_licitacao IS NULL
                     AND licitacao.cod_licitacao = {$params['codLicitacao']}
                     AND licitacao.exercicio = '{$params['exercicio']}'
                     AND licitacao.cod_entidade = {$params['codEntidade']}
                     AND licitacao.cod_modalidade = {$params['codModalidade']}
                     AND homologacao.homologado = TRUE
               GROUP BY cotacao_fornecedor_item.cgm_fornecedor
                 , homologacao.cod_item
                 , vw_classificacao_despesa.mascara_classificacao
                 , solicitacao_item_dotacao.cod_despesa
                 , solicitacao_item_dotacao.cod_conta
                 , homologacao.cod_entidade
                 , licitacao.cod_modalidade
                 , despesa.num_orgao
                 , despesa.num_unidade
                 , objeto.cod_objeto
                 , objeto.descricao
                 , cotacao_fornecedor_item.vl_cotacao
                 , cotacao_item.quantidade
                 , licitacao.exercicio
                 , solicitacao_item_dotacao.cod_centro
                 , catalogo_item.cod_unidade
                 , catalogo_item.cod_grandeza
             ) AS teste
        GROUP BY cod_despesa
          , fornecedor
          , cod_conta
          , cod_entidade
          , mascara_classificacao
          , cod_modalidade
          , num_orgao
          , num_unidade
          , cod_objeto
          , desc_objeto
          , historico
          , cod_tipo
          , implantado 
          , vl_cotacao
          , quantidade
          , exercicio
          , cod_centro
          , cod_item
          , cod_unidade
          , cod_grandeza
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Pega a listagem de Itens dos Grupos de Autorizações do Empenho
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade', 'cgmFornecedor',
     *                      'codDespesa', 'codConta']
     * @return array $result
     */
    public function montaRecuperaItensAgrupadosSolicitacaoLicitacao($params)
    {
        $sql = "
        SELECT
          cotacao_item.cod_cotacao,
          cotacao_item.exercicio,
          cotacao_item.cod_item,
          cotacao_item.lote,
          solicitacao_item.exercicio                            AS exercicio_solicitacao,
          cotacao_fornecedor_item.cgm_fornecedor                AS fornecedor,
          cotacao_fornecedor_item.lote,
          solicitacao_item_dotacao.cod_despesa,
          solicitacao_item_dotacao.cod_conta,
          solicitacao_item.exercicio                            AS exercicio_solicitacao,
          solicitacao_item_dotacao.cod_entidade,
          0                                                     AS historico,
          0                                                     AS cod_tipo,
          FALSE                                                 AS implantado,
          ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
           sum(mapa_item_dotacao.quantidade)) :: NUMERIC(14, 2) AS reserva,
          sum(mapa_item_dotacao.quantidade)                     AS qtd_cotacao,
          ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
           sum(mapa_item_dotacao.quantidade)) :: NUMERIC(14, 2) AS vl_cotacao,
          catalogo_item.descricao_resumida,
          catalogo_item.descricao                               AS descricao_completa,
          unidade_medida.cod_unidade,
          unidade_medida.cod_grandeza,
          unidade_medida.nom_unidade,
          unidade_medida.simbolo,
          mapa_item_reserva.cod_reserva,
          mapa.cod_mapa,
          mapa.exercicio                                        AS exercicio_mapa,
          mapa_solicitacao.cod_solicitacao,
          solicitacao_item.cod_centro
        FROM licitacao.homologacao
          LEFT JOIN licitacao.homologacao_anulada
            ON homologacao.num_homologacao = homologacao_anulada.num_homologacao
               AND homologacao.cod_licitacao = homologacao_anulada.cod_licitacao
               AND homologacao.cod_modalidade = homologacao_anulada.cod_modalidade
               AND homologacao.cod_entidade = homologacao_anulada.cod_entidade
               AND homologacao.num_adjudicacao = homologacao_anulada.num_adjudicacao
               AND homologacao.exercicio_licitacao = homologacao_anulada.exercicio_licitacao
               AND homologacao.lote = homologacao_anulada.lote
               AND homologacao.cod_cotacao = homologacao_anulada.cod_cotacao
               AND homologacao.cod_item = homologacao_anulada.cod_item
               AND homologacao.exercicio_cotacao = homologacao_anulada.exercicio_cotacao
               AND homologacao.cgm_fornecedor = homologacao_anulada.cgm_fornecedor
          INNER JOIN licitacao.adjudicacao
            ON homologacao.cod_licitacao = adjudicacao.cod_licitacao
               AND homologacao.cod_modalidade = adjudicacao.cod_modalidade
               AND homologacao.cod_entidade = adjudicacao.cod_entidade
               AND homologacao.num_adjudicacao = adjudicacao.num_adjudicacao
               AND homologacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
               AND homologacao.lote = adjudicacao.lote
               AND homologacao.cod_cotacao = adjudicacao.cod_cotacao
               AND homologacao.cod_item = adjudicacao.cod_item
               AND homologacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
               AND homologacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
          LEFT JOIN licitacao.adjudicacao_anulada
            ON adjudicacao.num_adjudicacao = adjudicacao_anulada.num_adjudicacao
               AND adjudicacao.cod_licitacao = adjudicacao_anulada.cod_licitacao
               AND adjudicacao.cod_modalidade = adjudicacao_anulada.cod_modalidade
               AND adjudicacao.cod_entidade = adjudicacao_anulada.cod_entidade
               AND adjudicacao.exercicio_licitacao = adjudicacao_anulada.exercicio_licitacao
               AND adjudicacao.lote = adjudicacao_anulada.lote
               AND adjudicacao.cod_cotacao = adjudicacao_anulada.cod_cotacao
               AND adjudicacao.cod_item = adjudicacao_anulada.cod_item
               AND adjudicacao.exercicio_cotacao = adjudicacao_anulada.exercicio_cotacao
               AND adjudicacao.cgm_fornecedor = adjudicacao_anulada.cgm_fornecedor
          INNER JOIN licitacao.cotacao_licitacao
            ON cotacao_licitacao.cod_licitacao = adjudicacao.cod_licitacao
               AND cotacao_licitacao.cod_modalidade = adjudicacao.cod_modalidade
               AND cotacao_licitacao.cod_entidade = adjudicacao.cod_entidade
               AND cotacao_licitacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
               AND cotacao_licitacao.lote = adjudicacao.lote
               AND cotacao_licitacao.cod_item = adjudicacao.cod_item
               AND cotacao_licitacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
               AND cotacao_licitacao.cod_cotacao = adjudicacao.cod_cotacao
               AND cotacao_licitacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
          INNER JOIN licitacao.licitacao
            ON licitacao.cod_licitacao = cotacao_licitacao.cod_licitacao
               AND licitacao.cod_modalidade = cotacao_licitacao.cod_modalidade
               AND licitacao.cod_entidade = cotacao_licitacao.cod_entidade
               AND licitacao.exercicio = cotacao_licitacao.exercicio_licitacao
          INNER JOIN compras.cotacao_fornecedor_item
            ON cotacao_licitacao.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
               AND cotacao_licitacao.exercicio_cotacao = cotacao_fornecedor_item.exercicio
               AND cotacao_licitacao.cod_item = cotacao_fornecedor_item.cod_item
               AND cotacao_licitacao.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
               AND cotacao_licitacao.lote = cotacao_fornecedor_item.lote
          INNER JOIN compras.cotacao_item
            ON cotacao_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
               AND cotacao_item.exercicio = cotacao_fornecedor_item.exercicio
               AND cotacao_item.lote = cotacao_fornecedor_item.lote
               AND cotacao_item.cod_item = cotacao_fornecedor_item.cod_item
          INNER JOIN compras.cotacao
            ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
               AND cotacao.exercicio = cotacao_item.exercicio
          INNER JOIN compras.mapa_cotacao
            ON cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
               AND cotacao.exercicio = mapa_cotacao.exercicio_cotacao
          INNER JOIN compras.mapa_item
            ON mapa_cotacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_cotacao.exercicio_mapa = mapa_item.exercicio
               AND mapa_item.cod_item = cotacao_licitacao.cod_item
               AND mapa_item.lote = cotacao_licitacao.lote
          INNER JOIN compras.mapa_item_dotacao
            ON mapa_item_dotacao.exercicio = mapa_item.exercicio
               AND mapa_item_dotacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
               AND mapa_item_dotacao.cod_entidade = mapa_item.cod_entidade
               AND mapa_item_dotacao.cod_solicitacao = mapa_item.cod_solicitacao
               AND mapa_item_dotacao.cod_centro = mapa_item.cod_centro
               AND mapa_item_dotacao.cod_item = mapa_item.cod_item
               AND mapa_item_dotacao.lote = mapa_item.lote
          INNER JOIN compras.mapa
            ON mapa.cod_mapa = mapa_item.cod_mapa
               AND mapa.exercicio = mapa_item.exercicio
          INNER JOIN compras.mapa_solicitacao
            ON mapa_solicitacao.exercicio = mapa_item.exercicio
               AND mapa_solicitacao.cod_entidade = mapa_item.cod_entidade
               AND mapa_solicitacao.cod_solicitacao = mapa_item.cod_solicitacao
               AND mapa_solicitacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
          INNER JOIN compras.solicitacao_homologada
            ON solicitacao_homologada.exercicio = mapa_solicitacao.exercicio_solicitacao
               AND solicitacao_homologada.cod_entidade = mapa_solicitacao.cod_entidade
               AND solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
          INNER JOIN compras.solicitacao
            ON solicitacao.exercicio = solicitacao_homologada.exercicio
               AND solicitacao.cod_entidade = solicitacao_homologada.cod_entidade
               AND solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
          INNER JOIN compras.solicitacao_item
            ON solicitacao_item.exercicio = mapa_item.exercicio
               AND solicitacao_item.cod_entidade = mapa_item.cod_entidade
               AND solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
               AND solicitacao_item.cod_centro = mapa_item.cod_centro
               AND solicitacao_item.cod_item = mapa_item.cod_item
               AND solicitacao_item.exercicio = solicitacao.exercicio
               AND solicitacao_item.cod_entidade = solicitacao.cod_entidade
               AND solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao
          LEFT JOIN compras.solicitacao_item_anulacao
            ON solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
               AND solicitacao_item_anulacao.cod_entidade = solicitacao_item.cod_entidade
               AND solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
               AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
               AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item
          INNER JOIN almoxarifado.catalogo_item
            ON catalogo_item.cod_item = solicitacao_item.cod_item
          INNER JOIN administracao.unidade_medida
            ON unidade_medida.cod_grandeza = catalogo_item.cod_grandeza
               AND unidade_medida.cod_unidade = catalogo_item.cod_unidade
          INNER JOIN compras.solicitacao_item_dotacao
            ON solicitacao_item.exercicio = solicitacao_item_dotacao.exercicio
               AND solicitacao_item.cod_entidade = solicitacao_item_dotacao.cod_entidade
               AND solicitacao_item.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
               AND solicitacao_item.cod_centro = solicitacao_item_dotacao.cod_centro
               AND solicitacao_item.cod_item = solicitacao_item_dotacao.cod_item
               AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
          INNER JOIN compras.mapa_item_reserva
            ON mapa_item_reserva.exercicio_mapa = mapa_item_dotacao.exercicio
               AND mapa_item_reserva.cod_mapa = mapa_item_dotacao.cod_mapa
               AND mapa_item_reserva.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
               AND mapa_item_reserva.cod_entidade = mapa_item_dotacao.cod_entidade
               AND mapa_item_reserva.cod_solicitacao = mapa_item_dotacao.cod_solicitacao
               AND mapa_item_reserva.cod_centro = mapa_item_dotacao.cod_centro
               AND mapa_item_reserva.cod_item = mapa_item_dotacao.cod_item
               AND mapa_item_reserva.lote = mapa_item_dotacao.lote
               AND mapa_item_reserva.cod_despesa = mapa_item_dotacao.cod_despesa
               AND mapa_item_reserva.cod_conta = mapa_item_dotacao.cod_conta
        WHERE homologacao_anulada.cod_licitacao IS NULL
              AND adjudicacao_anulada.cod_licitacao IS NULL
              AND licitacao.cod_licitacao = {$params['codLicitacao']}
              AND licitacao.exercicio = '{$params['exercicio']}'
              AND licitacao.cod_entidade = {$params['codEntidade']}
              AND licitacao.cod_modalidade = {$params['codModalidade']}
              AND homologacao.homologado = TRUE
              AND cotacao_fornecedor_item.cgm_fornecedor = {$params['cgmFornecedor']}
              AND solicitacao_item_dotacao.cod_despesa = {$params['codDespesa']}
              AND solicitacao_item_dotacao.cod_conta = {$params['codConta']}
              AND NOT EXISTS
        (
            SELECT 1
            FROM empenho.item_pre_empenho_julgamento
            WHERE item_pre_empenho_julgamento.exercicio_julgamento = cotacao_fornecedor_item.exercicio
                  AND item_pre_empenho_julgamento.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                  AND item_pre_empenho_julgamento.cod_item = cotacao_fornecedor_item.cod_item
                  AND item_pre_empenho_julgamento.lote = cotacao_fornecedor_item.lote
                  AND item_pre_empenho_julgamento.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
        )
              AND NOT EXISTS
        (
            SELECT 1
            FROM compras.cotacao_anulada
            WHERE cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                  AND cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
        )
        GROUP BY cotacao_fornecedor_item.cgm_fornecedor
          , cotacao_fornecedor_item.lote
          , solicitacao_item_dotacao.cod_despesa
          , solicitacao_item_dotacao.cod_conta
          , solicitacao_item_dotacao.cod_entidade
          , cotacao_item.cod_cotacao
          , cotacao_item.exercicio
          , cotacao_item.cod_item
          , cotacao_item.lote
          , mapa_item.quantidade
          , cotacao_fornecedor_item.vl_cotacao
          , catalogo_item.descricao_resumida
          , catalogo_item.descricao
          , unidade_medida.cod_unidade
          , unidade_medida.cod_grandeza
          , unidade_medida.nom_unidade
          , unidade_medida.simbolo
          , mapa.cod_mapa
          , mapa.exercicio
          , solicitacao_item.exercicio
          , cotacao_item.quantidade
          , solicitacao_item.quantidade
          , solicitacao_item.cod_solicitacao
          , solicitacao_item_dotacao.cod_centro
          , solicitacao_item_dotacao.vl_reserva
          , mapa_item_reserva.cod_reserva
          , solicitacao_item_anulacao.quantidade
          , solicitacao_item.cod_entidade
          , solicitacao_item.cod_centro
          , solicitacao_item.cod_item
          , mapa_solicitacao.cod_solicitacao
        ORDER BY catalogo_item.descricao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Pega a listagem de Itens dos Grupos de Autorizações do Empenho
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade', 'cgmFornecedor',
     *                      'codDespesa', 'codConta']
     * @return array $result
     */
    public function montaRecuperaItensAgrupadosSolicitacaoLicitacaoMapa($params)
    {
        $sql = "
        SELECT
            cotacao_item.cod_cotacao,
            cotacao_item.exercicio,
            cotacao_item.cod_item,
            solicitacao_item.cod_centro,
            cotacao_item.lote,
            solicitacao_item.cod_solicitacao,
            solicitacao_item.exercicio                            AS exercicio_solicitacao,
            cotacao_fornecedor_item.cgm_fornecedor                AS fornecedor,
            cotacao_fornecedor_item.lote,
            solicitacao_item_dotacao.cod_despesa,
            solicitacao_item_dotacao.cod_conta,
            solicitacao_item_dotacao.cod_entidade,
            sw_cgm.nom_cgm                                        AS nom_entidade,
            0                                                     AS historico,
            0                                                     AS cod_tipo,
            FALSE                                                 AS implantado,
            ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
            sum(mapa_item_dotacao.quantidade)) :: NUMERIC(14, 2) AS reserva,
            sum(mapa_item_dotacao.quantidade)                     AS qtd_cotacao,
            ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
            sum(mapa_item_dotacao.quantidade)) :: NUMERIC(14, 2) AS vl_cotacao,
            catalogo_item.descricao_resumida,
            catalogo_item.descricao                               AS descricao_completa,
            unidade_medida.cod_unidade,
            unidade_medida.cod_grandeza,
            unidade_medida.nom_unidade,
            unidade_medida.simbolo,
            mapa.cod_mapa,
            mapa.exercicio                                        AS exercicio_mapa
            FROM licitacao.homologacao
            LEFT JOIN licitacao.homologacao_anulada
            ON homologacao.num_homologacao = homologacao_anulada.num_homologacao
               AND homologacao.cod_licitacao = homologacao_anulada.cod_licitacao
               AND homologacao.cod_modalidade = homologacao_anulada.cod_modalidade
               AND homologacao.cod_entidade = homologacao_anulada.cod_entidade
               AND homologacao.num_adjudicacao = homologacao_anulada.num_adjudicacao
               AND homologacao.exercicio_licitacao = homologacao_anulada.exercicio_licitacao
               AND homologacao.lote = homologacao_anulada.lote
               AND homologacao.cod_cotacao = homologacao_anulada.cod_cotacao
               AND homologacao.cod_item = homologacao_anulada.cod_item
               AND homologacao.exercicio_cotacao = homologacao_anulada.exercicio_cotacao
               AND homologacao.cgm_fornecedor = homologacao_anulada.cgm_fornecedor
            INNER JOIN licitacao.adjudicacao
            ON homologacao.cod_licitacao = adjudicacao.cod_licitacao
               AND homologacao.cod_modalidade = adjudicacao.cod_modalidade
               AND homologacao.cod_entidade = adjudicacao.cod_entidade
               AND homologacao.num_adjudicacao = adjudicacao.num_adjudicacao
               AND homologacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
               AND homologacao.lote = adjudicacao.lote
               AND homologacao.cod_cotacao = adjudicacao.cod_cotacao
               AND homologacao.cod_item = adjudicacao.cod_item
               AND homologacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
               AND homologacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
            LEFT JOIN licitacao.adjudicacao_anulada
            ON adjudicacao.num_adjudicacao = adjudicacao_anulada.num_adjudicacao
               AND adjudicacao.cod_licitacao = adjudicacao_anulada.cod_licitacao
               AND adjudicacao.cod_modalidade = adjudicacao_anulada.cod_modalidade
               AND adjudicacao.cod_entidade = adjudicacao_anulada.cod_entidade
               AND adjudicacao.exercicio_licitacao = adjudicacao_anulada.exercicio_licitacao
               AND adjudicacao.lote = adjudicacao_anulada.lote
               AND adjudicacao.cod_cotacao = adjudicacao_anulada.cod_cotacao
               AND adjudicacao.cod_item = adjudicacao_anulada.cod_item
               AND adjudicacao.exercicio_cotacao = adjudicacao_anulada.exercicio_cotacao
               AND adjudicacao.cgm_fornecedor = adjudicacao_anulada.cgm_fornecedor
            INNER JOIN licitacao.cotacao_licitacao
            ON cotacao_licitacao.cod_licitacao = adjudicacao.cod_licitacao
               AND cotacao_licitacao.cod_modalidade = adjudicacao.cod_modalidade
               AND cotacao_licitacao.cod_entidade = adjudicacao.cod_entidade
               AND cotacao_licitacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
               AND cotacao_licitacao.cod_cotacao = adjudicacao.cod_cotacao
               AND cotacao_licitacao.lote = adjudicacao.lote
               AND cotacao_licitacao.cod_item = adjudicacao.cod_item
               AND cotacao_licitacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
               AND cotacao_licitacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
            INNER JOIN licitacao.licitacao
            ON licitacao.cod_licitacao = cotacao_licitacao.cod_licitacao
               AND licitacao.cod_modalidade = cotacao_licitacao.cod_modalidade
               AND licitacao.cod_entidade = cotacao_licitacao.cod_entidade
               AND licitacao.exercicio = cotacao_licitacao.exercicio_licitacao
            INNER JOIN compras.cotacao_fornecedor_item
            ON cotacao_licitacao.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
               AND cotacao_licitacao.exercicio_cotacao = cotacao_fornecedor_item.exercicio
               AND cotacao_licitacao.cod_item = cotacao_fornecedor_item.cod_item
               AND cotacao_licitacao.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
               AND cotacao_licitacao.lote = cotacao_fornecedor_item.lote
            INNER JOIN compras.cotacao_item
            ON cotacao_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
               AND cotacao_item.exercicio = cotacao_fornecedor_item.exercicio
               AND cotacao_item.lote = cotacao_fornecedor_item.lote
               AND cotacao_item.cod_item = cotacao_fornecedor_item.cod_item
            INNER JOIN compras.cotacao
            ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
               AND cotacao.exercicio = cotacao_item.exercicio
            INNER JOIN compras.mapa_cotacao
            ON cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
               AND cotacao.exercicio = mapa_cotacao.exercicio_cotacao
            INNER JOIN compras.mapa_item
            ON mapa_cotacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_cotacao.exercicio_mapa = mapa_item.exercicio
               AND mapa_item.cod_item = cotacao_licitacao.cod_item
               AND mapa_item.lote = cotacao_licitacao.lote
            INNER JOIN compras.mapa_item_dotacao
            ON mapa_item_dotacao.exercicio = mapa_item.exercicio
               AND mapa_item_dotacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
               AND mapa_item_dotacao.cod_entidade = mapa_item.cod_entidade
               AND mapa_item_dotacao.cod_solicitacao = mapa_item.cod_solicitacao
               AND mapa_item_dotacao.cod_centro = mapa_item.cod_centro
               AND mapa_item_dotacao.cod_item = mapa_item.cod_item
               AND mapa_item_dotacao.lote = mapa_item.lote
            INNER JOIN compras.mapa
            ON mapa.cod_mapa = mapa_item.cod_mapa
               AND mapa.exercicio = mapa_item.exercicio
            INNER JOIN compras.mapa_solicitacao
            ON mapa_solicitacao.exercicio = mapa_item.exercicio
               AND mapa_solicitacao.cod_entidade = mapa_item.cod_entidade
               AND mapa_solicitacao.cod_solicitacao = mapa_item.cod_solicitacao
               AND mapa_solicitacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
            INNER JOIN compras.solicitacao_homologada
            ON solicitacao_homologada.exercicio = mapa_solicitacao.exercicio_solicitacao
               AND solicitacao_homologada.cod_entidade = mapa_solicitacao.cod_entidade
               AND solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
            INNER JOIN compras.solicitacao
            ON solicitacao.exercicio = solicitacao_homologada.exercicio
               AND solicitacao.cod_entidade = solicitacao_homologada.cod_entidade
               AND solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
            INNER JOIN compras.solicitacao_item
            ON solicitacao_item.exercicio = mapa_item.exercicio
               AND solicitacao_item.cod_entidade = mapa_item.cod_entidade
               AND solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
               AND solicitacao_item.cod_centro = mapa_item.cod_centro
               AND solicitacao_item.cod_item = mapa_item.cod_item
               AND solicitacao_item.exercicio = solicitacao.exercicio
               AND solicitacao_item.cod_entidade = solicitacao.cod_entidade
               AND solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao
            LEFT JOIN compras.solicitacao_item_anulacao
            ON solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
               AND solicitacao_item_anulacao.cod_entidade = solicitacao_item.cod_entidade
               AND solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
               AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
               AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item
            INNER JOIN almoxarifado.catalogo_item
            ON catalogo_item.cod_item = solicitacao_item.cod_item
            INNER JOIN administracao.unidade_medida
            ON unidade_medida.cod_grandeza = catalogo_item.cod_grandeza
               AND unidade_medida.cod_unidade = catalogo_item.cod_unidade
            INNER JOIN compras.solicitacao_item_dotacao
            ON solicitacao_item.exercicio = solicitacao_item_dotacao.exercicio
               AND solicitacao_item.cod_entidade = solicitacao_item_dotacao.cod_entidade
               AND solicitacao_item.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
               AND solicitacao_item.cod_centro = solicitacao_item_dotacao.cod_centro
               AND solicitacao_item.cod_item = solicitacao_item_dotacao.cod_item
               AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
            INNER JOIN orcamento.entidade
            ON entidade.cod_entidade = solicitacao_item_dotacao.cod_entidade
               AND entidade.exercicio = solicitacao_item_dotacao.exercicio
            INNER JOIN sw_cgm
            ON sw_cgm.numcgm = entidade.numcgm
            WHERE homologacao_anulada.cod_licitacao IS NULL
              AND adjudicacao_anulada.cod_licitacao IS NULL
              AND licitacao.cod_licitacao = {$params['codLicitacao']}
              AND licitacao.exercicio = '{$params['exercicio']}'
              AND licitacao.cod_entidade = {$params['codEntidade']}
              AND licitacao.cod_modalidade = {$params['codModalidade']}
              AND homologacao.homologado = TRUE
              AND cotacao_fornecedor_item.cgm_fornecedor = {$params['cgmFornecedor']}
              AND solicitacao_item_dotacao.cod_despesa = {$params['codDespesa']}
              AND solicitacao_item_dotacao.cod_conta = {$params['codConta']}
              AND NOT EXISTS
            (
            SELECT 1
            FROM empenho.item_pre_empenho_julgamento
            WHERE item_pre_empenho_julgamento.exercicio_julgamento = cotacao_fornecedor_item.exercicio
                  AND item_pre_empenho_julgamento.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                  AND item_pre_empenho_julgamento.cod_item = cotacao_fornecedor_item.cod_item
                  AND item_pre_empenho_julgamento.lote = cotacao_fornecedor_item.lote
                  AND item_pre_empenho_julgamento.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
            )
            
              AND NOT EXISTS
            (
            SELECT 1
            FROM compras.cotacao_anulada
            WHERE cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                  AND cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
            )
            GROUP BY cotacao_fornecedor_item.cgm_fornecedor
            , cotacao_fornecedor_item.lote
            , solicitacao_item_dotacao.cod_despesa
            , solicitacao_item_dotacao.cod_conta
            , solicitacao_item_dotacao.cod_entidade
            , cotacao_item.cod_cotacao
            , cotacao_item.exercicio
            , cotacao_item.cod_item
            , cotacao_item.lote
            , mapa_item.quantidade
            , cotacao_fornecedor_item.vl_cotacao
            , catalogo_item.descricao_resumida
            , catalogo_item.descricao
            , unidade_medida.cod_unidade
            , unidade_medida.cod_grandeza
            , unidade_medida.nom_unidade
            , unidade_medida.simbolo
            , mapa.cod_mapa
            , mapa.exercicio
            , solicitacao_item.exercicio
            , cotacao_item.quantidade
            , solicitacao_item.quantidade
            , solicitacao_item.cod_solicitacao
            , solicitacao_item_dotacao.cod_centro
            , solicitacao_item_dotacao.vl_reserva
            , solicitacao_item_anulacao.quantidade
            , solicitacao_item.cod_entidade
            , solicitacao_item.cod_centro
            , solicitacao_item.cod_item
            , sw_cgm.nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Pega a listagem de Itens dos Grupos de Autorizações do Empenho 'Imp'
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade', 'cgmFornecedor',
     *                      'codDespesa', 'codConta']
     * @return array $result
     */
    public function montaRecuperaItensAgrupadosSolicitacaoLicitacaoImp($params)
    {
        $sql = "
            SELECT
                cotacao_item.cod_cotacao,
                cotacao_item.exercicio,
                cotacao_item.cod_item,
                cotacao_item.lote,
                solicitacao_item.exercicio             AS exercicio_solicitacao,
                cotacao_fornecedor_item.cgm_fornecedor AS fornecedor,
                cotacao_fornecedor_item.lote,
                solicitacao_item_dotacao.cod_despesa,
                solicitacao_item_dotacao.cod_conta,
                solicitacao_item.exercicio             AS exercicio_solicitacao,
                solicitacao_item.cod_entidade,
                0                                      AS historico,
                0                                      AS cod_tipo,
                FALSE                                  AS implantado,
                CASE WHEN solicitacao_item_dotacao.cod_despesa IS NOT NULL
                THEN ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
                      (sum(mapa_item_dotacao.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade), 0))) :: NUMERIC(14, 2)
                ELSE ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
                    (sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade), 0))) :: NUMERIC(14, 2)
                END                                    AS reserva,
                CASE WHEN solicitacao_item_dotacao.cod_despesa IS NOT NULL
                THEN sum(mapa_item_dotacao.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade), 0)
                ELSE sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade), 0)
                END                                    AS qtd_cotacao,
                CASE WHEN solicitacao_item_dotacao.cod_despesa IS NOT NULL
                THEN ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
                      (sum(mapa_item_dotacao.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade), 0))) :: NUMERIC(14, 2)
                ELSE ((sum(cotacao_fornecedor_item.vl_cotacao) / sum(cotacao_item.quantidade)) *
                    (sum(mapa_item.quantidade) - coalesce(sum(mapa_item_anulacao.quantidade), 0))) :: NUMERIC(14, 2)
                END                                    AS vl_cotacao,
                catalogo_item.descricao_resumida,
                catalogo_item.descricao                AS descricao_completa,
                unidade_medida.cod_unidade,
                unidade_medida.cod_grandeza,
                unidade_medida.nom_unidade,
                unidade_medida.simbolo,
                mapa.cod_mapa,
                mapa.exercicio                         AS exercicio_mapa,
                solicitacao_item.complemento,
                solicitacao_item.cod_centro
                
                FROM licitacao.homologacao
                LEFT JOIN licitacao.homologacao_anulada
                ON homologacao.num_homologacao = homologacao_anulada.num_homologacao
                   AND homologacao.cod_licitacao = homologacao_anulada.cod_licitacao
                   AND homologacao.cod_modalidade = homologacao_anulada.cod_modalidade
                   AND homologacao.cod_entidade = homologacao_anulada.cod_entidade
                   AND homologacao.num_adjudicacao = homologacao_anulada.num_adjudicacao
                   AND homologacao.exercicio_licitacao = homologacao_anulada.exercicio_licitacao
                   AND homologacao.lote = homologacao_anulada.lote
                   AND homologacao.cod_cotacao = homologacao_anulada.cod_cotacao
                   AND homologacao.cod_item = homologacao_anulada.cod_item
                   AND homologacao.exercicio_cotacao = homologacao_anulada.exercicio_cotacao
                   AND homologacao.cgm_fornecedor = homologacao_anulada.cgm_fornecedor
                INNER JOIN licitacao.adjudicacao
                ON homologacao.cod_licitacao = adjudicacao.cod_licitacao
                   AND homologacao.cod_modalidade = adjudicacao.cod_modalidade
                   AND homologacao.cod_entidade = adjudicacao.cod_entidade
                   AND homologacao.num_adjudicacao = adjudicacao.num_adjudicacao
                   AND homologacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
                   AND homologacao.lote = adjudicacao.lote
                   AND homologacao.cod_cotacao = adjudicacao.cod_cotacao
                   AND homologacao.cod_item = adjudicacao.cod_item
                   AND homologacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
                   AND homologacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
                LEFT JOIN licitacao.adjudicacao_anulada
                ON adjudicacao.num_adjudicacao = adjudicacao_anulada.num_adjudicacao
                   AND adjudicacao.cod_licitacao = adjudicacao_anulada.cod_licitacao
                   AND adjudicacao.cod_modalidade = adjudicacao_anulada.cod_modalidade
                   AND adjudicacao.cod_entidade = adjudicacao_anulada.cod_entidade
                   AND adjudicacao.exercicio_licitacao = adjudicacao_anulada.exercicio_licitacao
                   AND adjudicacao.lote = adjudicacao_anulada.lote
                   AND adjudicacao.cod_cotacao = adjudicacao_anulada.cod_cotacao
                   AND adjudicacao.cod_item = adjudicacao_anulada.cod_item
                   AND adjudicacao.exercicio_cotacao = adjudicacao_anulada.exercicio_cotacao
                   AND adjudicacao.cgm_fornecedor = adjudicacao_anulada.cgm_fornecedor
                INNER JOIN licitacao.cotacao_licitacao
                ON cotacao_licitacao.cod_licitacao = adjudicacao.cod_licitacao
                   AND cotacao_licitacao.cod_modalidade = adjudicacao.cod_modalidade
                   AND cotacao_licitacao.cod_entidade = adjudicacao.cod_entidade
                   AND cotacao_licitacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
                   AND cotacao_licitacao.lote = adjudicacao.lote
                   AND cotacao_licitacao.cod_item = adjudicacao.cod_item
                   AND cotacao_licitacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
                   AND cotacao_licitacao.cod_cotacao = adjudicacao.cod_cotacao
                   AND cotacao_licitacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
                INNER JOIN licitacao.licitacao
                ON licitacao.cod_licitacao = cotacao_licitacao.cod_licitacao
                   AND licitacao.cod_modalidade = cotacao_licitacao.cod_modalidade
                   AND licitacao.cod_entidade = cotacao_licitacao.cod_entidade
                   AND licitacao.exercicio = cotacao_licitacao.exercicio_licitacao
                INNER JOIN compras.cotacao_fornecedor_item
                ON cotacao_licitacao.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                   AND cotacao_licitacao.exercicio_cotacao = cotacao_fornecedor_item.exercicio
                   AND cotacao_licitacao.cod_item = cotacao_fornecedor_item.cod_item
                   AND cotacao_licitacao.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
                   AND cotacao_licitacao.lote = cotacao_fornecedor_item.lote
                INNER JOIN compras.cotacao_item
                ON cotacao_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                   AND cotacao_item.exercicio = cotacao_fornecedor_item.exercicio
                   AND cotacao_item.lote = cotacao_fornecedor_item.lote
                   AND cotacao_item.cod_item = cotacao_fornecedor_item.cod_item
                INNER JOIN compras.cotacao
                ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
                   AND cotacao.exercicio = cotacao_item.exercicio
                INNER JOIN compras.mapa_cotacao
                ON cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
                   AND cotacao.exercicio = mapa_cotacao.exercicio_cotacao
                INNER JOIN compras.mapa_item
                ON mapa_cotacao.cod_mapa = mapa_item.cod_mapa
                   AND mapa_cotacao.exercicio_mapa = mapa_item.exercicio
                   AND mapa_item.cod_item = cotacao_licitacao.cod_item
                   AND mapa_item.lote = cotacao_licitacao.lote
                LEFT JOIN compras.mapa_item_dotacao
                ON mapa_item_dotacao.exercicio = mapa_item.exercicio
                   AND mapa_item_dotacao.cod_mapa = mapa_item.cod_mapa
                   AND mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                   AND mapa_item_dotacao.cod_entidade = mapa_item.cod_entidade
                   AND mapa_item_dotacao.cod_solicitacao = mapa_item.cod_solicitacao
                   AND mapa_item_dotacao.cod_centro = mapa_item.cod_centro
                   AND mapa_item_dotacao.cod_item = mapa_item.cod_item
                   AND mapa_item_dotacao.lote = mapa_item.lote
                LEFT JOIN compras.mapa_item_anulacao
                ON mapa_item_anulacao.exercicio = mapa_item_dotacao.exercicio
                   AND mapa_item_anulacao.cod_mapa = mapa_item_dotacao.cod_mapa
                   AND mapa_item_anulacao.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
                   AND mapa_item_anulacao.cod_entidade = mapa_item_dotacao.cod_entidade
                   AND mapa_item_anulacao.cod_solicitacao = mapa_item_dotacao.cod_solicitacao
                   AND mapa_item_anulacao.cod_centro = mapa_item_dotacao.cod_centro
                   AND mapa_item_anulacao.cod_item = mapa_item_dotacao.cod_item
                   AND mapa_item_anulacao.lote = mapa_item_dotacao.lote
                   AND mapa_item_anulacao.cod_conta = mapa_item_dotacao.cod_conta
                   AND mapa_item_anulacao.cod_despesa = mapa_item_dotacao.cod_despesa
                INNER JOIN compras.mapa
                ON mapa.cod_mapa = mapa_item.cod_mapa
                   AND mapa.exercicio = mapa_item.exercicio
                INNER JOIN compras.mapa_solicitacao
                ON mapa_solicitacao.exercicio = mapa_item.exercicio
                   AND mapa_solicitacao.cod_entidade = mapa_item.cod_entidade
                   AND mapa_solicitacao.cod_solicitacao = mapa_item.cod_solicitacao
                   AND mapa_solicitacao.cod_mapa = mapa_item.cod_mapa
                   AND mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
                INNER JOIN compras.solicitacao_homologada
                ON solicitacao_homologada.exercicio = mapa_solicitacao.exercicio_solicitacao
                   AND solicitacao_homologada.cod_entidade = mapa_solicitacao.cod_entidade
                   AND solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
                INNER JOIN compras.solicitacao
                ON solicitacao.exercicio = solicitacao_homologada.exercicio
                   AND solicitacao.cod_entidade = solicitacao_homologada.cod_entidade
                   AND solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
                INNER JOIN compras.solicitacao_item
                ON solicitacao_item.exercicio = mapa_item.exercicio
                   AND solicitacao_item.cod_entidade = mapa_item.cod_entidade
                   AND solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
                   AND solicitacao_item.cod_centro = mapa_item.cod_centro
                   AND solicitacao_item.cod_item = mapa_item.cod_item
                   AND solicitacao_item.exercicio = solicitacao.exercicio
                   AND solicitacao_item.cod_entidade = solicitacao.cod_entidade
                   AND solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao
                LEFT JOIN compras.solicitacao_item_anulacao
                ON solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
                   AND solicitacao_item_anulacao.cod_entidade = solicitacao_item.cod_entidade
                   AND solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
                   AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
                   AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item
                INNER JOIN almoxarifado.catalogo_item
                ON catalogo_item.cod_item = solicitacao_item.cod_item
                INNER JOIN administracao.unidade_medida
                ON unidade_medida.cod_grandeza = catalogo_item.cod_grandeza
                   AND unidade_medida.cod_unidade = catalogo_item.cod_unidade
                LEFT JOIN compras.solicitacao_item_dotacao
                ON solicitacao_item.exercicio = solicitacao_item_dotacao.exercicio
                   AND solicitacao_item.cod_entidade = solicitacao_item_dotacao.cod_entidade
                   AND solicitacao_item.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
                   AND solicitacao_item.cod_centro = solicitacao_item_dotacao.cod_centro
                   AND solicitacao_item.cod_item = solicitacao_item_dotacao.cod_item
                   AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
                LEFT JOIN compras.mapa_item_reserva
                ON mapa_item_reserva.exercicio_mapa = mapa_item_dotacao.exercicio
                   AND mapa_item_reserva.cod_mapa = mapa_item_dotacao.cod_mapa
                   AND mapa_item_reserva.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
                   AND mapa_item_reserva.cod_entidade = mapa_item_dotacao.cod_entidade
                   AND mapa_item_reserva.cod_solicitacao = mapa_item_dotacao.cod_solicitacao
                   AND mapa_item_reserva.cod_centro = mapa_item_dotacao.cod_centro
                   AND mapa_item_reserva.cod_item = mapa_item_dotacao.cod_item
                   AND mapa_item_reserva.lote = mapa_item_dotacao.lote
                   AND mapa_item_reserva.cod_despesa = mapa_item_dotacao.cod_despesa
                   AND mapa_item_reserva.cod_conta = mapa_item_dotacao.cod_conta
                
                WHERE homologacao_anulada.cod_licitacao IS NULL
                  AND adjudicacao_anulada.cod_licitacao IS NULL
                  AND licitacao.cod_licitacao = {$params['codLicitacao']}
                AND licitacao.exercicio = '{$params['exercicio']}'
                AND licitacao.cod_entidade = {$params['codEntidade']}
                AND licitacao.cod_modalidade = {$params['codModalidade']}
                AND homologacao.homologado = TRUE
                AND cotacao_fornecedor_item.cgm_fornecedor = {$params['cgmFornecedor']}
                AND solicitacao_item_dotacao.cod_despesa = {$params['codDespesa']}
                AND solicitacao_item_dotacao.cod_conta = {$params['codConta']}
                AND NOT EXISTS
                (
                SELECT 1
                FROM empenho.item_pre_empenho_julgamento
                WHERE item_pre_empenho_julgamento.exercicio_julgamento = cotacao_fornecedor_item.exercicio
                AND item_pre_empenho_julgamento.cod_cotacao          = cotacao_fornecedor_item.cod_cotacao
                AND item_pre_empenho_julgamento.cod_item             = cotacao_fornecedor_item.cod_item
                AND item_pre_empenho_julgamento.lote                 = cotacao_fornecedor_item.lote
                AND item_pre_empenho_julgamento.cgm_fornecedor       = cotacao_fornecedor_item.cgm_fornecedor
                )
                AND NOT EXISTS
                (
                SELECT 1
                FROM compras.cotacao_anulada
                WHERE cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                AND cotacao_anulada.exercicio   = mapa_cotacao.exercicio_cotacao
                )
                GROUP BY cotacao_fornecedor_item.cgm_fornecedor
                , cotacao_fornecedor_item.lote
                , solicitacao_item_dotacao.cod_despesa
                , solicitacao_item_dotacao.cod_conta
                , solicitacao_item_dotacao.cod_entidade
                , cotacao_item.cod_cotacao
                , cotacao_item.exercicio
                , cotacao_item.cod_item
                , cotacao_item.lote
                , catalogo_item.descricao_resumida
                , catalogo_item.descricao
                , unidade_medida.cod_unidade
                , unidade_medida.cod_grandeza
                , unidade_medida.nom_unidade
                , unidade_medida.simbolo
                , mapa.cod_mapa
                , mapa.exercicio
                , solicitacao_item.exercicio
                , solicitacao_item.cod_solicitacao
                , solicitacao_item.cod_entidade
                , solicitacao_item.cod_item
                , solicitacao_item.complemento
                , solicitacao_item.cod_centro
                ORDER BY catalogo_item.descricao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * Pega a listagem de Licitacoes não Anuladas
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade']
     * @return array $result
     */
    public function montaRecuperaSolicitacaoLicitacaoNaoAnulada($params)
    {
        $sql = "
        SELECT
            solicitacao.cod_solicitacao,
            solicitacao.observacao,
            solicitacao.exercicio,
            solicitacao.cod_almoxarifado,
            solicitacao.cod_entidade,
            solicitacao.cgm_solicitante,
            solicitacao.cgm_requisitante,
            solicitacao.cod_objeto,
            solicitacao.prazo_entrega,
            solicitacao.timestamp
            
            FROM licitacao.homologacao
            LEFT JOIN licitacao.homologacao_anulada
            ON homologacao.num_homologacao = homologacao_anulada.num_homologacao
               AND homologacao.cod_licitacao = homologacao_anulada.cod_licitacao
               AND homologacao.cod_modalidade = homologacao_anulada.cod_modalidade
               AND homologacao.cod_entidade = homologacao_anulada.cod_entidade
               AND homologacao.num_adjudicacao = homologacao_anulada.num_adjudicacao
               AND homologacao.exercicio_licitacao = homologacao_anulada.exercicio_licitacao
               AND homologacao.lote = homologacao_anulada.lote
               AND homologacao.cod_cotacao = homologacao_anulada.cod_cotacao
               AND homologacao.cod_item = homologacao_anulada.cod_item
               AND homologacao.exercicio_cotacao = homologacao_anulada.exercicio_cotacao
               AND homologacao.cgm_fornecedor = homologacao_anulada.cgm_fornecedor
            INNER JOIN licitacao.adjudicacao
            ON homologacao.cod_licitacao = adjudicacao.cod_licitacao
               AND homologacao.cod_modalidade = adjudicacao.cod_modalidade
               AND homologacao.cod_entidade = adjudicacao.cod_entidade
               AND homologacao.num_adjudicacao = adjudicacao.num_adjudicacao
               AND homologacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
               AND homologacao.lote = adjudicacao.lote
               AND homologacao.cod_cotacao = adjudicacao.cod_cotacao
               AND homologacao.cod_item = adjudicacao.cod_item
               AND homologacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
               AND homologacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
            LEFT JOIN licitacao.adjudicacao_anulada
            ON adjudicacao.num_adjudicacao = adjudicacao_anulada.num_adjudicacao
               AND adjudicacao.cod_licitacao = adjudicacao_anulada.cod_licitacao
               AND adjudicacao.cod_modalidade = adjudicacao_anulada.cod_modalidade
               AND adjudicacao.cod_entidade = adjudicacao_anulada.cod_entidade
               AND adjudicacao.exercicio_licitacao = adjudicacao_anulada.exercicio_licitacao
               AND adjudicacao.lote = adjudicacao_anulada.lote
               AND adjudicacao.cod_cotacao = adjudicacao_anulada.cod_cotacao
               AND adjudicacao.cod_item = adjudicacao_anulada.cod_item
               AND adjudicacao.exercicio_cotacao = adjudicacao_anulada.exercicio_cotacao
               AND adjudicacao.cgm_fornecedor = adjudicacao_anulada.cgm_fornecedor
            INNER JOIN licitacao.cotacao_licitacao
            ON cotacao_licitacao.cod_licitacao = adjudicacao.cod_licitacao
               AND cotacao_licitacao.cod_modalidade = adjudicacao.cod_modalidade
               AND cotacao_licitacao.cod_entidade = adjudicacao.cod_entidade
               AND cotacao_licitacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
               AND cotacao_licitacao.lote = adjudicacao.lote
               AND cotacao_licitacao.cod_item = adjudicacao.cod_item
               AND cotacao_licitacao.exercicio_cotacao = adjudicacao.exercicio_cotacao
               AND cotacao_licitacao.cgm_fornecedor = adjudicacao.cgm_fornecedor
            INNER JOIN licitacao.licitacao
            ON licitacao.cod_licitacao = cotacao_licitacao.cod_licitacao
               AND licitacao.cod_modalidade = cotacao_licitacao.cod_modalidade
               AND licitacao.cod_entidade = cotacao_licitacao.cod_entidade
               AND licitacao.exercicio = cotacao_licitacao.exercicio_licitacao
            INNER JOIN compras.cotacao_fornecedor_item
            ON cotacao_licitacao.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
               AND cotacao_licitacao.exercicio_cotacao = cotacao_fornecedor_item.exercicio
               AND cotacao_licitacao.cod_item = cotacao_fornecedor_item.cod_item
               AND cotacao_licitacao.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor
               AND cotacao_licitacao.lote = cotacao_fornecedor_item.lote
            INNER JOIN compras.cotacao_item
            ON cotacao_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
               AND cotacao_item.exercicio = cotacao_fornecedor_item.exercicio
               AND cotacao_item.lote = cotacao_fornecedor_item.lote
               AND cotacao_item.cod_item = cotacao_fornecedor_item.cod_item
            INNER JOIN compras.cotacao
            ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
               AND cotacao.exercicio = cotacao_item.exercicio
            INNER JOIN compras.mapa_cotacao
            ON cotacao.cod_cotacao = mapa_cotacao.cod_cotacao
               AND cotacao.exercicio = mapa_cotacao.exercicio_cotacao
            INNER JOIN compras.mapa_item
            ON mapa_cotacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_cotacao.exercicio_mapa = mapa_item.exercicio
               AND mapa_item.cod_item = cotacao_licitacao.cod_item
               AND mapa_item.lote = cotacao_licitacao.lote
            INNER JOIN compras.mapa_item_dotacao
            ON mapa_item_dotacao.exercicio = mapa_item.exercicio
               AND mapa_item_dotacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_item_dotacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
               AND mapa_item_dotacao.cod_entidade = mapa_item.cod_entidade
               AND mapa_item_dotacao.cod_solicitacao = mapa_item.cod_solicitacao
               AND mapa_item_dotacao.cod_centro = mapa_item.cod_centro
               AND mapa_item_dotacao.cod_item = mapa_item.cod_item
               AND mapa_item_dotacao.lote = mapa_item.lote
            LEFT JOIN compras.mapa_item_anulacao
            ON mapa_item_anulacao.exercicio = mapa_item_dotacao.exercicio
               AND mapa_item_anulacao.cod_mapa = mapa_item_dotacao.cod_mapa
               AND mapa_item_anulacao.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
               AND mapa_item_anulacao.cod_entidade = mapa_item_dotacao.cod_entidade
               AND mapa_item_anulacao.cod_solicitacao = mapa_item_dotacao.cod_solicitacao
               AND mapa_item_anulacao.cod_centro = mapa_item_dotacao.cod_centro
               AND mapa_item_anulacao.cod_item = mapa_item_dotacao.cod_item
               AND mapa_item_anulacao.lote = mapa_item_dotacao.lote
               AND mapa_item_anulacao.cod_conta = mapa_item_dotacao.cod_conta
               AND mapa_item_anulacao.cod_despesa = mapa_item_dotacao.cod_despesa
            INNER JOIN compras.mapa
            ON mapa.cod_mapa = mapa_item.cod_mapa
               AND mapa.exercicio = mapa_item.exercicio
            INNER JOIN compras.mapa_solicitacao
            ON mapa_solicitacao.exercicio = mapa_item.exercicio
               AND mapa_solicitacao.cod_entidade = mapa_item.cod_entidade
               AND mapa_solicitacao.cod_solicitacao = mapa_item.cod_solicitacao
               AND mapa_solicitacao.cod_mapa = mapa_item.cod_mapa
               AND mapa_solicitacao.exercicio_solicitacao = mapa_item.exercicio_solicitacao
            INNER JOIN compras.solicitacao_homologada
            ON solicitacao_homologada.exercicio = mapa_solicitacao.exercicio_solicitacao
               AND solicitacao_homologada.cod_entidade = mapa_solicitacao.cod_entidade
               AND solicitacao_homologada.cod_solicitacao = mapa_solicitacao.cod_solicitacao
            INNER JOIN compras.solicitacao
            ON solicitacao.exercicio = solicitacao_homologada.exercicio
               AND solicitacao.cod_entidade = solicitacao_homologada.cod_entidade
               AND solicitacao.cod_solicitacao = solicitacao_homologada.cod_solicitacao
            INNER JOIN compras.solicitacao_item
            ON solicitacao_item.exercicio = mapa_item.exercicio
               AND solicitacao_item.cod_entidade = mapa_item.cod_entidade
               AND solicitacao_item.cod_solicitacao = mapa_item.cod_solicitacao
               AND solicitacao_item.cod_centro = mapa_item.cod_centro
               AND solicitacao_item.cod_item = mapa_item.cod_item
               AND solicitacao_item.exercicio = solicitacao.exercicio
               AND solicitacao_item.cod_entidade = solicitacao.cod_entidade
               AND solicitacao_item.cod_solicitacao = solicitacao.cod_solicitacao
            LEFT JOIN compras.solicitacao_item_anulacao
            ON solicitacao_item_anulacao.exercicio = solicitacao_item.exercicio
               AND solicitacao_item_anulacao.cod_entidade = solicitacao_item.cod_entidade
               AND solicitacao_item_anulacao.cod_solicitacao = solicitacao_item.cod_solicitacao
               AND solicitacao_item_anulacao.cod_centro = solicitacao_item.cod_centro
               AND solicitacao_item_anulacao.cod_item = solicitacao_item.cod_item
            INNER JOIN almoxarifado.catalogo_item
            ON catalogo_item.cod_item = solicitacao_item.cod_item
            INNER JOIN administracao.unidade_medida
            ON unidade_medida.cod_grandeza = catalogo_item.cod_grandeza
               AND unidade_medida.cod_unidade = catalogo_item.cod_unidade
            INNER JOIN compras.solicitacao_item_dotacao
            ON solicitacao_item.exercicio = solicitacao_item_dotacao.exercicio
               AND solicitacao_item.cod_entidade = solicitacao_item_dotacao.cod_entidade
               AND solicitacao_item.cod_solicitacao = solicitacao_item_dotacao.cod_solicitacao
               AND solicitacao_item.cod_centro = solicitacao_item_dotacao.cod_centro
               AND solicitacao_item.cod_item = solicitacao_item_dotacao.cod_item
               AND mapa_item_dotacao.cod_despesa = solicitacao_item_dotacao.cod_despesa
            INNER JOIN compras.mapa_item_reserva
            ON mapa_item_reserva.exercicio_mapa = mapa_item_dotacao.exercicio
               AND mapa_item_reserva.cod_mapa = mapa_item_dotacao.cod_mapa
               AND mapa_item_reserva.exercicio_solicitacao = mapa_item_dotacao.exercicio_solicitacao
               AND mapa_item_reserva.cod_entidade = mapa_item_dotacao.cod_entidade
               AND mapa_item_reserva.cod_solicitacao = mapa_item_dotacao.cod_solicitacao
               AND mapa_item_reserva.cod_centro = mapa_item_dotacao.cod_centro
               AND mapa_item_reserva.cod_item = mapa_item_dotacao.cod_item
               AND mapa_item_reserva.lote = mapa_item_dotacao.lote
               AND mapa_item_reserva.cod_despesa = mapa_item_dotacao.cod_despesa
               AND mapa_item_reserva.cod_conta = mapa_item_dotacao.cod_conta
            
            WHERE homologacao_anulada.cod_licitacao IS NULL
              AND adjudicacao_anulada.cod_licitacao IS NULL
              AND licitacao.cod_licitacao = {$params['codLicitacao']}
              AND licitacao.exercicio = '{$params['exercicio']}'
              AND licitacao.cod_entidade = {$params['codEntidade']}
              AND licitacao.cod_modalidade = {$params['codModalidade']}
              AND NOT EXISTS
            (
            SELECT 1
            FROM compras.cotacao_anulada
            WHERE cotacao_anulada.cod_cotacao = cotacao.cod_cotacao
                  AND cotacao_anulada.exercicio = cotacao.exercicio
            )
            
              AND NOT EXISTS
            (
            SELECT 1
            FROM compras.solicitacao_anulacao
            WHERE solicitacao_anulacao.cod_solicitacao = solicitacao.cod_solicitacao
                  AND solicitacao_anulacao.exercicio = solicitacao.exercicio
                  AND solicitacao_anulacao.cod_entidade = solicitacao.cod_entidade
            )
            
            GROUP BY solicitacao.cod_solicitacao
            , solicitacao.observacao
            , solicitacao.exercicio
            , solicitacao.cod_almoxarifado
            , solicitacao.cod_entidade
            , solicitacao.cgm_solicitante
            , solicitacao.cgm_requisitante
            , solicitacao.cod_objeto
            , solicitacao.prazo_entrega
            , solicitacao.timestamp
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function findLicitacaoSemJulgamentoPropostas($exercicio)
    {
        $sql = "SELECT
                        le.num_edital,
                        cp.descricao,
                        ll.exercicio,
                        ll.cod_entidade,
                        ll.cod_licitacao||'/'||ll.exercicio as num_licitacao,
                        ll.cod_entidade,
                        cgm.nom_cgm as entidade,
                        ll.cod_modalidade,
                        ll.cod_tipo_objeto,
                        ll.cod_licitacao,
                        ll.cod_processo,
                        ll.exercicio_processo,
                        ll.cod_modalidade,
                        ll.cod_mapa,
                        comissao.cod_comissao,
                        ll.exercicio_mapa,
                        mapa.cod_tipo_licitacao,
                        mapa_cotacao.exercicio_cotacao,
                        mapa_cotacao.cod_cotacao,
                        le.num_edital || '/' || le.exercicio as num_edital_lista
                  
                  FROM  licitacao.licitacao as ll
            
             LEFT JOIN  licitacao.edital as le
                    ON  ll.cod_licitacao  = le.cod_licitacao
                   AND  ll.cod_modalidade = le.cod_modalidade
                   AND  ll.cod_entidade   = le.cod_entidade
                   AND  ll.exercicio      = le.exercicio
            
            INNER JOIN  compras.mapa
                    ON  mapa.cod_mapa = ll.cod_mapa
                   AND  mapa.exercicio = ll.exercicio_mapa
                   
            INNER JOIN  compras.mapa_cotacao
                    ON  mapa_cotacao.cod_mapa = ll.cod_mapa
                   AND  mapa_cotacao.exercicio_mapa = ll.exercicio_mapa
            
            
            INNER JOIN  compras.julgamento
                    ON  mapa_cotacao.exercicio_cotacao  = julgamento.exercicio
                   AND  mapa_cotacao.cod_cotacao        = julgamento.cod_cotacao
            
            INNER JOIN  compras.modalidade as cp
                    ON  cp.cod_modalidade = ll.cod_modalidade
                    
            INNER JOIN  orcamento.entidade as oe
                    ON  oe.cod_entidade = ll.cod_entidade
                   AND  oe.exercicio = ll.exercicio
                   
             LEFT JOIN  licitacao.comissao_licitacao
                    ON  le.exercicio      = comissao_licitacao.exercicio
                   AND  le.cod_entidade   = comissao_licitacao.cod_entidade
                   AND  le.cod_modalidade = comissao_licitacao.cod_modalidade
                   AND  le.cod_licitacao  = comissao_licitacao.cod_licitacao
                   
             LEFT JOIN  licitacao.comissao
                    ON  comissao_licitacao.cod_comissao = comissao.cod_comissao
                    
            INNER JOIN  sw_cgm as cgm
                    ON  cgm.numcgm = oe.numcgm
                    
                 WHERE ( EXISTS  (   SELECT  1
                                      FROM  licitacao.participante_documentos
                                
                                INNER JOIN  licitacao.participante
                                        ON  participante.cod_licitacao = participante_documentos.cod_licitacao
                                       AND  participante.cgm_fornecedor = participante_documentos.cgm_fornecedor
                                       AND  participante.cod_modalidade = participante_documentos.cod_modalidade
                                       AND  participante.cod_entidade = participante_documentos.cod_entidade
                                       AND  participante.exercicio = participante_documentos.exercicio
                                
                                INNER JOIN  licitacao.licitacao_documentos
                                        ON  licitacao_documentos.cod_documento = participante_documentos.cod_documento
                                       AND  licitacao_documentos.cod_licitacao = participante_documentos.cod_licitacao
                                       AND  licitacao_documentos.cod_modalidade = participante_documentos.cod_modalidade
                                       AND  licitacao_documentos.cod_entidade = participante_documentos.cod_entidade
                                       AND  licitacao_documentos.exercicio = participante_documentos.exercicio
                                
                                     WHERE  participante_documentos.cod_licitacao = ll.cod_licitacao
                                       AND  participante_documentos.cod_modalidade = ll.cod_modalidade
                                       AND  participante_documentos.cod_entidade = ll.cod_entidade
                                       AND  participante_documentos.exercicio = ll.exercicio
                                 ) OR ll.cod_modalidade IN (6,7)
                  ) AND 
            ll.exercicio = '{$exercicio}' and  NOT EXISTS (   SELECT  1
                                 FROM  licitacao.edital_anulado
                                WHERE  edital_anulado.num_edital = le.num_edital
                                  AND  edital_anulado.exercicio = le.exercicio
                                )
            
            AND NOT EXISTS (   SELECT  1
                                 FROM  licitacao.edital_suspenso
                                WHERE  edital_suspenso.num_edital = le.num_edital
                                  AND  edital_suspenso.exercicio = le.exercicio
                                )
            
            -- Para as modalidades 1,2,3,4,5,6,7,10,11 é obrigatório exister um edital
            AND CASE WHEN ll.cod_modalidade in (1,2,3,4,5,6,7,10,11) THEN
                    
                   le.cod_licitacao  IS NOT NULL
               AND le.cod_modalidade IS NOT NULL
               AND le.cod_entidade   IS NOT NULL 
               AND le.exercicio      IS NOT NULL 
            
              -- Para as modalidades 8,9 é facultativo possuir um edital
              WHEN ll.cod_modalidade in (8,9) THEN
                    
                    le.cod_licitacao  IS NULL
                 OR le.cod_modalidade IS NULL
                 OR le.cod_entidade   IS NULL 
                 OR le.exercicio      IS NULL 
            
                 OR le.cod_licitacao  IS NOT NULL
                 OR le.cod_modalidade IS NOT NULL
                 OR le.cod_entidade   IS NOT NULL 
                 OR le.exercicio      IS NOT NULL 
            END   ----- este filtro serve para exlcuir da listagem os mapas que forem por lote ou global e tenha fornecedores que não cotaram todos os itens de um lote para o qual fizeram proposta
            
            
            and ( mapa.cod_tipo_licitacao = 1 or  not exists ( SELECT lotes.*
                                                               FROM ( SELECT cotacao_item.exercicio
                                                                           , cotacao_item.cod_cotacao
                                                                           , cotacao_item.lote
                                                                           , count ( cotacao_item.cod_item ) as qtd_itens
                                                                        FROM compras.cotacao_item
                                                                    GROUP BY cotacao_item.exercicio
                                                                           , cotacao_item.cod_cotacao
                                                                           , cotacao_item.lote
                                                                    ) AS lotes
                                                                 JOIN ( SELECT cotacao_fornecedor_item.exercicio
                                                                             , cotacao_fornecedor_item.cod_cotacao
                                                                             , cotacao_fornecedor_item.lote
                                                                             , cotacao_fornecedor_item.cgm_fornecedor
                                                                             , count ( cotacao_fornecedor_item.cod_item
                                                                      ) AS qtd_itens
                                                                   FROM compras.cotacao_fornecedor_item
                                                               GROUP BY cotacao_fornecedor_item.exercicio
                                                                      , cotacao_fornecedor_item.cod_cotacao
                                                                      , cotacao_fornecedor_item.lote
                                                                      , cotacao_fornecedor_item.cgm_fornecedor
                                                                ) AS fornecedor_lotes
                                                                 ON lotes.exercicio   = fornecedor_lotes.exercicio
                                                                AND lotes.cod_cotacao = fornecedor_lotes.cod_cotacao
                                                                AND lotes.lote        = fornecedor_lotes.lote 
                                                              WHERE lotes.qtd_itens > fornecedor_lotes.qtd_itens
                                                                AND lotes.cod_cotacao = mapa_cotacao.cod_cotacao
                                                                AND lotes.exercicio   = mapa_cotacao.exercicio_cotacao )  )    AND NOT EXISTS ( SELECT 1
                                    FROM licitacao.adjudicacao
                                   WHERE adjudicacao.cod_licitacao       = ll.cod_licitacao
                                     AND adjudicacao.exercicio_licitacao = ll.exercicio
                                     AND adjudicacao.cod_modalidade      = ll.cod_modalidade
                                     AND adjudicacao.cod_entidade        = ll.cod_entidade
                                     AND adjudicacao.adjudicado          = true
                                )AND NOT EXISTS
            (
                SELECT  1
                  FROM  compras.cotacao_anulada
                 WHERE  cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                   AND  cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
            )   AND NOT EXISTS (  SELECT 1
                                        FROM licitacao.licitacao_anulada
                                       WHERE ll.cod_licitacao = licitacao_anulada.cod_licitacao
                                         AND ll.cod_modalidade = licitacao_anulada.cod_modalidade
                                         AND ll.cod_entidade = licitacao_anulada.cod_entidade
                                         AND ll.exercicio = licitacao_anulada.exercicio
                                    )AND (
                    EXISTS  (
                                 SELECT  1
                                   FROM  compras.mapa_cotacao
                             INNER JOIN  compras.julgamento
                                     ON  julgamento.exercicio = mapa_cotacao.exercicio_cotacao
                                    AND  julgamento.cod_cotacao = mapa_cotacao.cod_cotacao
                                  WHERE  mapa_cotacao.cod_mapa = ll.cod_mapa
                                    AND  mapa_cotacao.exercicio_mapa = ll.exercicio_mapa                   AND  NOT EXISTS (
                                                         SELECT  1
                                                           FROM  compras.cotacao_anulada
                                                          WHERE  cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                                                            AND  cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
                                                        )               )
                )
            
                                    
            ORDER BY
                le.exercicio DESC,
                le.num_edital,
                ll.exercicio DESC,
                ll.cod_entidade,
                ll.cod_licitacao,
                ll.cod_modalidade";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getClass()
    {
        return $this->_class;
    }

    public function getLicitacaoJulgamentoProposta()
    {
        $sql = <<<SQL
SELECT
  le.num_edital,
  cp.descricao,
  ll.exercicio,
  ll.cod_entidade,
  ll.cod_licitacao || '/' || ll.exercicio AS num_licitacao,
  ll.cod_entidade,
  cgm.nom_cgm                             AS entidade,
  ll.cod_modalidade,
  ll.cod_tipo_objeto,
  ll.cod_licitacao,
  ll.cod_processo,
  ll.exercicio_processo,
  ll.cod_modalidade,
  ll.cod_mapa,
  comissao.cod_comissao,
  ll.exercicio_mapa,
  mapa.cod_tipo_licitacao,
  mapa_cotacao.exercicio_cotacao,
  mapa_cotacao.cod_cotacao,
  le.num_edital || '/' || le.exercicio    AS num_edital_lista

FROM licitacao.licitacao AS ll

  LEFT JOIN licitacao.edital AS le
    ON ll.cod_licitacao = le.cod_licitacao
       AND ll.cod_modalidade = le.cod_modalidade
       AND ll.cod_entidade = le.cod_entidade
       AND ll.exercicio = le.exercicio

  INNER JOIN compras.mapa
    ON mapa.cod_mapa = ll.cod_mapa
       AND mapa.exercicio = ll.exercicio_mapa

  INNER JOIN compras.mapa_cotacao
    ON mapa_cotacao.cod_mapa = ll.cod_mapa
       AND mapa_cotacao.exercicio_mapa = ll.exercicio_mapa


  INNER JOIN compras.modalidade AS cp
    ON cp.cod_modalidade = ll.cod_modalidade

  INNER JOIN orcamento.entidade AS oe
    ON oe.cod_entidade = ll.cod_entidade
       AND oe.exercicio = ll.exercicio

  LEFT JOIN licitacao.comissao_licitacao
    ON le.exercicio = comissao_licitacao.exercicio
       AND le.cod_entidade = comissao_licitacao.cod_entidade
       AND le.cod_modalidade = comissao_licitacao.cod_modalidade
       AND le.cod_licitacao = comissao_licitacao.cod_licitacao

  LEFT JOIN licitacao.comissao
    ON comissao_licitacao.cod_comissao = comissao.cod_comissao

  INNER JOIN sw_cgm AS cgm
    ON cgm.numcgm = oe.numcgm
WHERE (EXISTS(SELECT 1
              FROM licitacao.participante_documentos

                INNER JOIN licitacao.participante
                  ON participante.cod_licitacao = participante_documentos.cod_licitacao
                     AND participante.cgm_fornecedor = participante_documentos.cgm_fornecedor
                     AND participante.cod_modalidade = participante_documentos.cod_modalidade
                     AND participante.cod_entidade = participante_documentos.cod_entidade
                     AND participante.exercicio = participante_documentos.exercicio

                INNER JOIN licitacao.licitacao_documentos
                  ON licitacao_documentos.cod_documento = participante_documentos.cod_documento
                     AND licitacao_documentos.cod_licitacao = participante_documentos.cod_licitacao
                     AND licitacao_documentos.cod_modalidade = participante_documentos.cod_modalidade
                     AND licitacao_documentos.cod_entidade = participante_documentos.cod_entidade
                     AND licitacao_documentos.exercicio = participante_documentos.exercicio

              WHERE participante_documentos.cod_licitacao = ll.cod_licitacao
                    AND participante_documentos.cod_modalidade = ll.cod_modalidade
                    AND participante_documentos.cod_entidade = ll.cod_entidade
                    AND participante_documentos.exercicio = ll.exercicio
       ) OR ll.cod_modalidade IN (6, 7)
      ) AND NOT EXISTS(SELECT 1
                                           FROM licitacao.edital_anulado
                                           WHERE edital_anulado.num_edital = le.num_edital
                                                 AND edital_anulado.exercicio = le.exercicio
)

      AND NOT EXISTS(SELECT 1
                     FROM licitacao.edital_suspenso
                     WHERE edital_suspenso.num_edital = le.num_edital
                           AND edital_suspenso.exercicio = le.exercicio
)
      AND CASE WHEN ll.cod_modalidade IN (1, 2, 3, 4, 5, 6, 7, 10, 11)
  THEN

    le.cod_licitacao IS NOT NULL
    AND le.cod_modalidade IS NOT NULL
    AND le.cod_entidade IS NOT NULL
    AND le.exercicio IS NOT NULL
          WHEN ll.cod_modalidade IN (8, 9)
            THEN

              le.cod_licitacao IS NULL
              OR le.cod_modalidade IS NULL
              OR le.cod_entidade IS NULL
              OR le.exercicio IS NULL

              OR le.cod_licitacao IS NOT NULL
              OR le.cod_modalidade IS NOT NULL
              OR le.cod_entidade IS NOT NULL
              OR le.exercicio IS NOT NULL
          END
      AND (mapa.cod_tipo_licitacao = 1 OR NOT exists(SELECT lotes.*
                                                     FROM (SELECT
                                                             cotacao_item.exercicio,
                                                             cotacao_item.cod_cotacao,
                                                             cotacao_item.lote,
                                                             count(cotacao_item.cod_item) AS qtd_itens
                                                           FROM compras.cotacao_item
                                                           GROUP BY cotacao_item.exercicio
                                                             , cotacao_item.cod_cotacao
                                                             , cotacao_item.lote
                                                          ) AS lotes
                                                       JOIN (SELECT
                                                               cotacao_fornecedor_item.exercicio,
                                                               cotacao_fornecedor_item.cod_cotacao,
                                                               cotacao_fornecedor_item.lote,
                                                               cotacao_fornecedor_item.cgm_fornecedor,
                                                               count(cotacao_fornecedor_item.cod_item
                                                               ) AS qtd_itens
                                                             FROM compras.cotacao_fornecedor_item
                                                             GROUP BY cotacao_fornecedor_item.exercicio
                                                               , cotacao_fornecedor_item.cod_cotacao
                                                               , cotacao_fornecedor_item.lote
                                                               , cotacao_fornecedor_item.cgm_fornecedor
                                                            ) AS fornecedor_lotes
                                                         ON lotes.exercicio = fornecedor_lotes.exercicio
                                                            AND lotes.cod_cotacao = fornecedor_lotes.cod_cotacao
                                                            AND lotes.lote = fornecedor_lotes.lote
                                                     WHERE lotes.qtd_itens > fornecedor_lotes.qtd_itens
                                                           AND lotes.cod_cotacao = mapa_cotacao.cod_cotacao
                                                           AND lotes.exercicio = mapa_cotacao.exercicio_cotacao)) AND
      NOT EXISTS(SELECT 1
                 FROM licitacao.adjudicacao
                 WHERE adjudicacao.cod_licitacao = ll.cod_licitacao
                       AND adjudicacao.exercicio_licitacao = ll.exercicio
                       AND adjudicacao.cod_modalidade = ll.cod_modalidade
                       AND adjudicacao.cod_entidade = ll.cod_entidade
                       AND adjudicacao.adjudicado = TRUE
      ) AND NOT EXISTS
(
    SELECT 1
    FROM compras.cotacao_anulada
    WHERE cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
          AND cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
) AND NOT EXISTS(SELECT 1
                 FROM licitacao.licitacao_anulada
                 WHERE ll.cod_licitacao = licitacao_anulada.cod_licitacao
                       AND ll.cod_modalidade = licitacao_anulada.cod_modalidade
                       AND ll.cod_entidade = licitacao_anulada.cod_entidade
                       AND ll.exercicio = licitacao_anulada.exercicio
) AND (
        NOT EXISTS(
            SELECT 1
            FROM compras.mapa_cotacao
              INNER JOIN compras.julgamento
                ON julgamento.exercicio = mapa_cotacao.exercicio_cotacao
                   AND julgamento.cod_cotacao = mapa_cotacao.cod_cotacao
            WHERE mapa_cotacao.cod_mapa = ll.cod_mapa
                  AND mapa_cotacao.exercicio_mapa = ll.exercicio_mapa
                  AND NOT EXISTS(
                SELECT 1
                FROM compras.cotacao_anulada
                WHERE cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                      AND cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao
            )
        )
      )
ORDER BY
  le.exercicio DESC,
  le.num_edital,
  ll.exercicio DESC,
  ll.cod_entidade,
  ll.cod_licitacao,
  ll.cod_modalidade;
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $res = $stmt->fetchAll();

        return $res;
    }


    /**
     * @param ProxyQueryInterface $proxyQuery
     * @param $exercicio
     * @return ProxyQueryInterface
     */
    public function getJulgamento(ProxyQueryInterface $proxyQuery, $exercicio)
    {
        $proxyQuery
            ->join(
                'CoreBundle:Compras\Mapa',
                'm',
                'WITH',
                'm.codMapa = o.codMapa AND  m.exercicio = o.exercicioMapa'
            )
            ->join(
                'CoreBundle:Compras\MapaCotacao',
                'mc',
                'WITH',
                'mc.codMapa = m.codMapa AND  mc.exercicioMapa = m.exercicio'
            )
            ->where('NOT EXISTS (SELECT 1 FROM CoreBundle:Compras\CotacaoAnulada ca 
                WHERE mc.codCotacao = ca.codCotacao AND mc.exercicioCotacao = ca.exercicio)')
            ->orWhere(
                'm.codTipoLicitacao = \'1\'',
                'NOT EXISTS (SELECT 1
                            FROM CoreBundle:Compras\CotacaoItem ci
                            JOIN CoreBundle:Compras\CotacaoFornecedorItem cfi
                             WITH (ci.exercicio = cfi.exercicio AND ci.codCotacao = cfi.codCotacao AND ci.lote = cfi.lote)
                            WHERE ci.codCotacao = mc.codCotacao AND ci.exercicio   = mc.exercicioCotacao
                            HAVING COUNT(ci.codItem) > COUNT(cfi.codItem)                              
                            )'
            )
            ->andWhere('NOT EXISTS (SELECT 1
                      FROM CoreBundle:Compras\MapaCotacao mc1
                      JOIN CoreBundle:Compras\Cotacao c
                        WITH ( mc1.codCotacao = c.codCotacao AND mc1.exercicioCotacao = c.exercicio )
                      JOIN CoreBundle:Empenho\ItemPreEmpenhoJulgamento ipej
                        WITH ( c.exercicio = ipej.exercicioJulgamento AND c.codCotacao = ipej.codCotacao )
                      WHERE m.codMapa = mc1.codMapa
                        AND m.exercicio = mc1.exercicioMapa
                      )')
            ->andWhere('NOT EXISTS (SELECT  1
                      FROM  CoreBundle:Compras\CotacaoAnulada ca1
                     WHERE  mc.codCotacao = ca1.codCotacao
                       AND  mc.exercicioCotacao = ca1.exercicio
                     )')
            ->andWhere('o.exercicio = ?1')
            ->setParameter(1, $exercicio);

        return $proxyQuery;
    }

    /**
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicio
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function carregaLicitacaoContrato($codModalidade, $codEntidade, $exercicio)
    {
        $sql = "
        SELECT  licitacao.cod_licitacao
                  , licitacao.exercicio
                  , julgamento_item.cgm_fornecedor
	              ,  sw_cgm.nom_cgm
	            FROM  licitacao.licitacao
	      INNER JOIN  licitacao.cotacao_licitacao
	              ON  cotacao_licitacao.cod_licitacao = licitacao.cod_licitacao
	             AND  cotacao_licitacao.cod_modalidade = licitacao.cod_modalidade
	             AND  cotacao_licitacao.cod_entidade = licitacao.cod_entidade
	             AND  cotacao_licitacao.exercicio_licitacao = licitacao.exercicio
	      INNER JOIN  compras.julgamento_item
	              ON  julgamento_item.exercicio = cotacao_licitacao.exercicio_cotacao
	             AND  julgamento_item.cod_cotacao = cotacao_licitacao.cod_cotacao
	             AND  julgamento_item.cod_item = cotacao_licitacao.cod_item
	             AND  julgamento_item.cgm_fornecedor = cotacao_licitacao.cgm_fornecedor
	             AND  julgamento_item.lote = cotacao_licitacao.lote
	             AND  julgamento_item.ordem = 1
	      INNER JOIN  sw_cgm
	              ON  sw_cgm.numcgm = julgamento_item.cgm_fornecedor
	           WHERE  EXISTS (   SELECT  1
	                                  FROM  licitacao.homologacao
	                             LEFT JOIN  licitacao.homologacao_anulada
	                                    ON  homologacao_anulada.num_homologacao = homologacao.num_homologacao
	                                   AND  homologacao_anulada.num_adjudicacao = homologacao.num_adjudicacao
	                                   AND  homologacao_anulada.cod_entidade = homologacao.cod_entidade
	                                   AND  homologacao_anulada.cod_modalidade = homologacao.cod_modalidade
	                                   AND  homologacao_anulada.cod_licitacao = homologacao.cod_licitacao
	                                   AND  homologacao_anulada.exercicio_licitacao = homologacao.exercicio_licitacao
	                                   AND  homologacao_anulada.cod_item = homologacao.cod_item
	                                   AND  homologacao_anulada.cod_cotacao = homologacao.cod_cotacao
	                                   AND  homologacao_anulada.lote = homologacao.lote
	                                   AND  homologacao_anulada.exercicio_cotacao = homologacao.exercicio_cotacao
	                                   AND  homologacao_anulada.cgm_fornecedor = homologacao.cgm_fornecedor
	                                 WHERE  homologacao.cod_entidade = licitacao.cod_entidade
	                                   AND  homologacao.cod_modalidade = licitacao.cod_modalidade
	                                   AND  homologacao.cod_licitacao = licitacao.cod_licitacao
	                                   AND  homologacao.exercicio_licitacao = licitacao.exercicio
	                                   AND  homologacao.lote = julgamento_item.lote
	                                   AND  homologacao.cod_cotacao = julgamento_item.cod_cotacao
	                                   AND  homologacao.cod_item = julgamento_item.cod_item
	                                   AND  homologacao.cgm_fornecedor = julgamento_item.cgm_fornecedor
	                                   AND  julgamento_item.ordem = 1
	                                   AND  homologacao_anulada.num_homologacao is null
	                            )
	            AND NOT EXISTS  ( SELECT 1
	                                  FROM licitacao.contrato, licitacao.contrato_licitacao
	                                 WHERE contrato.num_contrato = contrato_licitacao.num_contrato
	                                   AND contrato.exercicio = contrato_licitacao.exercicio
	                                   AND contrato.cod_entidade = contrato_licitacao.cod_entidade
	                                 AND contrato_licitacao.cod_licitacao = licitacao.cod_licitacao
	                                 AND contrato_licitacao.cod_modalidade = licitacao.cod_modalidade
	                                 AND contrato_licitacao.cod_entidade = licitacao.cod_entidade
	                                 AND contrato_licitacao.exercicio = licitacao.exercicio
	                                   AND contrato.cgm_contratado = cotacao_licitacao.cgm_fornecedor
	                                 -- a condição abaixo serve para listar tb os fornedores que tiveram contratos anulados
	                                 AND not exists ( select 1
	                                                    from licitacao.contrato_anulado
	                                                   where contrato.num_contrato = contrato_anulado.num_contrato
	                                                     and contrato.exercicio    = contrato_anulado.exercicio
	                                                     and contrato.cod_entidade = contrato_anulado.cod_entidade )
	                               )
          AND licitacao.cod_modalidade = $codModalidade AND  licitacao.cod_entidade = $codEntidade AND  licitacao.exercicio = '$exercicio'
	      GROUP BY licitacao.cod_licitacao,licitacao.exercicio,julgamento_item.cgm_fornecedor,sw_cgm.nom_cgm
	      ORDER BY licitacao.exercicio,licitacao.cod_licitacao;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicio
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function carregaLicitacaoEdital($codModalidade, $codEntidade, $exercicio)
    {
        $sql = "
        SELECT ll.cod_entidade                                                    
	                      , ll.cod_licitacao                                                   
	                      , ll.cod_processo||'/'||ll.exercicio_processo as processo            
	                      , cm.descricao                                                       
	                      , cm.cod_modalidade                                                  
	                      , ll.cod_modalidade                                                  
	                      , ll.cod_mapa||'/'||ll.exercicio_mapa as mapa_compra                 
	                      , ll.cod_entidade||' - '||cgm.nom_cgm as entidade                    
	                      , ll.cod_modalidade||' - '||cm.descricao as modalidade               
	                      , ll.cod_objeto                                                      
	                      , ll.cod_regime                                                      
	                      , ll.timestamp                                                       
	                      , ll.cod_tipo_objeto                                                 
	                      , ll.cod_tipo_licitacao                                              
	                      , ll.cod_criterio                                                    
	                      , ll.vl_cotado                                                       
	                      , ll.exercicio                                                       
	                      , to_char(ll.timestamp::date, 'dd/mm/yyyy') as dt_licitacao          
	                      , LPAD(ll.num_orgao::VARCHAR, 2, '0') || '.' || LPAD(ll.num_unidade::VARCHAR, 2, '0') AS unidade_orcamentaria       
	                      , homologadas.dt_homologacao
	                      , ll.tipo_chamada_publica
	                      , cgm.nom_cgm
	                   FROM licitacao.licitacao as ll
	                
	              LEFT JOIN licitacao.licitacao_anulada as la                            
	                     ON ll.cod_licitacao  = la.cod_licitacao      
	                    AND ll.cod_modalidade = la.cod_modalidade    
	                    AND ll.cod_entidade   = la.cod_entidade                        		
	                    AND ll.exercicio      = la.exercicio
	                    
	              LEFT JOIN (   SELECT cotacao_licitacao.cod_licitacao 
	                                 , cotacao_licitacao.cod_modalidade 
	                                 , cotacao_licitacao.cod_entidade 
	                                 , cotacao_licitacao.exercicio_licitacao 
	                                 , homologacao.homologado          
	                                 , to_char(homologacao.timestamp::date, 'dd/mm/yyyy') as dt_homologacao    
	                              
	                              FROM licitacao.cotacao_licitacao
	
	                        INNER JOIN compras.mapa_cotacao
	                                ON mapa_cotacao.cod_cotacao         = cotacao_licitacao.cod_cotacao
	                               AND mapa_cotacao.exercicio_cotacao   = cotacao_licitacao.exercicio_cotacao
	
	                        INNER JOIN compras.cotacao
	                                ON cotacao.exercicio    = mapa_cotacao.exercicio_cotacao
	                               AND cotacao.cod_cotacao  = mapa_cotacao.cod_cotacao
	                               AND cotacao.cod_cotacao  = (SELECT MAX(MC.cod_cotacao)
	                                                             FROM compras.mapa_cotacao AS MC
	                                                            WHERE MC.exercicio_mapa = mapa_cotacao.exercicio_mapa
	                                                              AND MC.cod_mapa = mapa_cotacao.cod_mapa)
	  
	                        INNER JOIN licitacao.adjudicacao
	                                ON adjudicacao.cod_licitacao       = cotacao_licitacao.cod_licitacao
	                               AND adjudicacao.cod_modalidade      = cotacao_licitacao.cod_modalidade
	                               AND adjudicacao.cod_entidade        = cotacao_licitacao.cod_entidade
	                               AND adjudicacao.exercicio_licitacao = cotacao_licitacao.exercicio_licitacao
	                               AND adjudicacao.lote                = cotacao_licitacao.lote
	                               AND adjudicacao.cod_cotacao         = cotacao_licitacao.cod_cotacao
	                               AND adjudicacao.cod_item            = cotacao_licitacao.cod_item
	                               AND adjudicacao.exercicio_cotacao   = cotacao_licitacao.exercicio_cotacao
	                               AND adjudicacao.cgm_fornecedor      = cotacao_licitacao.cgm_fornecedor
	
	                       INNER JOIN licitacao.homologacao 
	                               ON homologacao.num_adjudicacao     = adjudicacao.num_adjudicacao
	                              AND homologacao.cod_entidade        = adjudicacao.cod_entidade
	                              AND homologacao.cod_modalidade      = adjudicacao.cod_modalidade
	                              AND homologacao.cod_licitacao       = adjudicacao.cod_licitacao
	                              AND homologacao.exercicio_licitacao = adjudicacao.exercicio_licitacao
	                              AND homologacao.cod_item            = adjudicacao.cod_item
	                              AND homologacao.cod_cotacao         = adjudicacao.cod_cotacao
	                              AND homologacao.lote                = adjudicacao.lote
	                              AND homologacao.exercicio_cotacao   = adjudicacao.exercicio_cotacao
	                              AND homologacao.cgm_fornecedor      = adjudicacao.cgm_fornecedor
	                              
	                         GROUP BY cotacao_licitacao.cod_licitacao 
	                                , cotacao_licitacao.cod_modalidade 
	                                , cotacao_licitacao.cod_entidade 
	                                , cotacao_licitacao.exercicio_licitacao 
	                                , homologacao.homologado
	                                , homologacao.timestamp
	                ) AS homologadas
	                ON homologadas.cod_licitacao       = ll.cod_licitacao 
	               AND homologadas.cod_modalidade      = ll.cod_modalidade
	               AND homologadas.cod_entidade        = ll.cod_entidade
	               AND homologadas.exercicio_licitacao = ll.exercicio
	        
	        INNER JOIN compras.modalidade as cm 
	                ON ll.cod_modalidade = cm.cod_modalidade
	               
	        INNER JOIN orcamento.entidade as oe
	                ON ll.cod_entidade = oe.cod_entidade                                  
	               AND ll.exercicio    = oe.exercicio               
	                
	        INNER JOIN sw_cgm as cgm
	                ON oe.numcgm = cgm.numcgm
	             WHERE 1 = 1 
	     AND la.cod_licitacao is NULL                    
	AND ll.cod_entidade in ($codEntidade)             
	AND ll.cod_modalidade IN ($codModalidade) 
	AND ll.exercicio = '$exercicio'                     
	 AND ( EXISTS (
	                                           SELECT 1
	                                             FROM licitacao.edital, licitacao.edital_anulado
	                                                , ( SELECT max(edital.num_edital) as num_edital
	                                             FROM licitacao.edital
	                                            WHERE edital.cod_licitacao  = ll.cod_licitacao
	                                              AND edital.cod_modalidade = ll.cod_modalidade
	                                              AND edital.cod_entidade   = ll.cod_entidade
	                                              AND edital.exercicio      = ll.exercicio
	                                                  ) AS maxEdital
	                                            WHERE edital_anulado.num_edital = maxEdital.num_edital
	                                           )
	                                    OR
	                                    NOT EXISTS(
	                                              SELECT 1
	                                                FROM licitacao.edital
	                                               WHERE edital.cod_licitacao  = ll.cod_licitacao
	                                                 AND edital.cod_modalidade = ll.cod_modalidade
	                                                 AND edital.cod_entidade   = ll.cod_entidade
	                                                 AND edital.exercicio      = ll.exercicio
	                                              )     ) ORDER BY  ll.cod_licitacao 
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getByTermAsQueryBuilder($term, Entidade $entidade = null, Modalidade $modalidade = null, $exercicio = null)
    {
        $qb = $this->createQueryBuilder('Licitacao');

        $orx = $qb->expr()->orX();
        $orx->add($qb->expr()->like('string(Licitacao.codLicitacao)', ':term'));
        $orx->add($qb->expr()->like("CONCAT(string(Licitacao.codLicitacao), '/', Licitacao.exercicio)", ':term'));

        $qb->andWhere($orx);

        if (null !== $entidade) {
            $qb->join('Licitacao.fkOrcamentoEntidade', 'fkOrcamentoEntidade');
            $qb->andWhere('fkOrcamentoEntidade.exercicio = :fkOrcamentoEntidade_exercicio');
            $qb->andWhere('fkOrcamentoEntidade.codEntidade = :fkOrcamentoEntidade_codEntidade');
            $qb->setParameter('fkOrcamentoEntidade_exercicio', $entidade->getExercicio());
            $qb->setParameter('fkOrcamentoEntidade_codEntidade', $entidade->getCodEntidade());
        }

        if (null !== $modalidade) {
            $qb->join('Licitacao.fkComprasModalidade', 'fkComprasModalidade');
            $qb->andWhere('fkComprasModalidade.codModalidade = :fkComprasModalidade_codModalidade');
            $qb->setParameter('fkComprasModalidade_codModalidade', $modalidade->getCodModalidade());
        }

        if (null !== $exercicio) {
            $qb->andWhere('Licitacao.exercicio = :exercicio');
            $qb->setParameter('exercicio', $exercicio);
        }

        $qb->setParameter('term', sprintf('%%%s%%', $term));

        $qb->orderBy('Licitacao.codLicitacao');
        $qb->setMaxResults(10);

        return $qb;
    }

    /**
     * @param ResponsavelLicitacaoFilter $filter
     * @return ORM\QueryBuilder
     */
    public function getByFilterAsQueryBuilder(ResponsavelLicitacaoFilter $filter)
    {
        $qb = $this->createQueryBuilder('Licitacao');

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterResponsavelLicitacao.php:116
        if (null !== $filter->getPeriodicidadeInicio()) {
            $qb->andWhere('Licitacao.timestamp >= :periodicidadeInicio');
            $qb->setParameter('periodicidadeInicio', $filter->getPeriodicidadeInicio());
        }

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterResponsavelLicitacao.php:116
        if (null !== $filter->getPeriodicidadeFim()) {
            $qb->andWhere('Licitacao.timestamp <= :periodicidadeFim');
            $qb->setParameter('periodicidadeFim', $filter->getPeriodicidadeFim());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1512
        if (0 < $filter->getEntidades()->count()) {
            $orx = $qb->expr()->orX();

            $count = 1;

            /** @var Entidade $entidade */
            foreach ($filter->getEntidades() as $entidade) {
                $parameter = sprintf('fkOrcamentoEntidade_codEntidade_%s', $count);

                $andX = $qb->expr()->andX();
                $andX->add(sprintf('Licitacao.codEntidade = :%s', $parameter));
                $qb->setParameter($parameter, $entidade->getCodEntidade());

                $count++;

                $orx->add($andX);
            }

            $qb->andWhere($orx);
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1516
        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1520
        if (null !== $filter->getSwProcesso()) {
            $qb->andWhere('Licitacao.codProcesso = :fkSwProcesso_codProcesso');
            $qb->andWhere('Licitacao.exercicioProcesso = :fkSwProcesso_AnoExercicio');

            $qb->setParameter('fkSwProcesso_codProcesso', $filter->getSwProcesso()->getCodProcesso());
            $qb->setParameter('fkSwProcesso_AnoExercicio', $filter->getSwProcesso()->getAnoExercicio());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1524
        if (null !== $filter->getModalidade()) {
            $qb->andWhere('Licitacao.codModalidade = :fkComprasModalidade_codModalidade');
            $qb->setParameter('fkComprasModalidade_codModalidade', $filter->getModalidade()->getCodModalidade());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1527
        if (null !== $filter->getExercicio()) {
            $qb->andWhere('Licitacao.exercicio = :exercicio');
            $qb->setParameter('exercicio', $filter->getExercicio());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1531
        if (null !== $filter->getLicitacao()) {
            $qb->andWhere('Licitacao.codLicitacao = :Licitacao_codLicitacao');
            $qb->setParameter('Licitacao_codLicitacao', $filter->getLicitacao()->getCodLicitacao());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1535
        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1539
        if (null !== $filter->getMapa()) {
            $qb->andWhere('Licitacao.codMapa = :fkComprasMapa_codMapa');
            $qb->setParameter('fkComprasMapa_codMapa', $filter->getMapa()->getCodMapa());

            $qb->andWhere('Licitacao.exercicioMapa = :fkComprasMapa_exercicioMapa');
            $qb->setParameter('fkComprasMapa_exercicioMapa', $filter->getMapa()->getExercicio());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1543
        if (null !== $filter->getTipoLicitacao()) {
            $qb->andWhere('Licitacao.codTipoLicitacao = :fkComprasTipoLicitacao_codTipoLicitacao');
            $qb->setParameter('fkComprasTipoLicitacao_codTipoLicitacao', $filter->getTipoLicitacao()->getCodTipoLicitacao());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1547
        if (null !== $filter->getCriterioJulgamento()) {
            $qb->andWhere('Licitacao.codCriterio = :fkLicitacaoCriterioJulgamento_codCriterio');
            $qb->setParameter('fkLicitacaoCriterioJulgamento_codCriterio', $filter->getCriterioJulgamento()->getCodCriterio());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1551
        if (null !== $filter->getObjeto()) {
            $qb->andWhere('Licitacao.codObjeto = :fkComprasObjeto_codObjeto');
            $qb->setParameter('fkComprasObjeto_codObjeto', $filter->getObjeto()->getCodObjeto());
        }

        // gestaoPatrimonial/fontes/PHP/licitacao/classes/mapeamento/TLicitacaoLicitacao.class.php:1555
        if (null !== $filter->getTipoObjeto()) {
            $qb->andWhere('Licitacao.codTipoObjeto = :fkComprasTipoObjeto_codTipoObjeto');
            $qb->setParameter('fkComprasTipoObjeto_codTipoObjeto', $filter->getTipoObjeto()->getCodTipoObjeto());
        }

        //gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterResponsavelLicitacao.php:149
        $qb->addOrderBy('Licitacao.exercicio', "DESC");
        $qb->addOrderBy('Licitacao.codEntidade');
        $qb->addOrderBy('Licitacao.codLicitacao');
        $qb->addOrderBy('Licitacao.codModalidade');

        return $qb;
    }

    /**
     * @param ResponsavelLicitacaoFilter $filter
     * @param $limit
     * @param $offset
     * @return array|Licitacao
     */
    public function getByFilter(ResponsavelLicitacaoFilter $filter, $limit, $offset)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ResponsavelLicitacaoFilter $filter
     * @return integer
     */
    public function getTotalByFilter(ResponsavelLicitacaoFilter $filter)
    {
        $qb = $this->getByFilterAsQueryBuilder($filter);
        $qb->select('COUNT(Licitacao)');
        $qb->resetDQLPart('orderBy');

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param $params
     * @return array
     */
    public function getOrcamentoDespesa($params)
    {
        $sql = "SELECT despesa.cod_despesa                                                  
                    , conta_despesa.cod_conta                                            
                    , conta_despesa.cod_estrutural                                       
                    , sum (reserva_saldos.vl_reserva) AS vl_reservado                    
                    , orcamento.orgao.num_orgao                                          
                    , orcamento.orgao.nom_orgao                                      
                    , despesa.num_pao                                                    
                    , pao.nom_pao                                                        
                                                                                         
               FROM licitacao.licitacao                                                  
                                                                                         
               JOIN compras.mapa_item_reserva                                            
                 ON mapa_item_reserva.exercicio_mapa = licitacao.exercicio_mapa          
                AND mapa_item_reserva.cod_mapa       = licitacao.cod_mapa                
                                                                                         
                 JOIN orcamento.reserva_saldos                                             
                 ON reserva_saldos.exercicio   = mapa_item_reserva.exercicio_reserva     
                AND reserva_saldos.cod_reserva = mapa_item_reserva.cod_reserva           
                                                                                         
               JOIN orcamento.despesa                                                    
                 ON despesa.exercicio   = reserva_saldos.exercicio                       
                AND despesa.cod_despesa = reserva_saldos.cod_despesa                     
                                                                                         
               JOIN orcamento.orgao                                                      
                 ON orcamento.orgao.exercicio = despesa.exercicio                        
                AND orcamento.orgao.num_orgao = despesa.num_orgao 
                                                                                                          
               JOIN orcamento.pao                                                        
                 ON pao.exercicio = despesa.exercicio                                    
                AND pao.num_pao   = despesa.num_pao                                      
                                                                                         
                JOIN orcamento.conta_despesa                                             
                  ON conta_despesa.exercicio = despesa.exercicio                         
                 AND conta_despesa.cod_conta = despesa.cod_conta                                                                                                      
        where
        licitacao.cod_licitacao = ".$params['codLicitacao']."
        and licitacao.exercicio = '".$params['exercicio']."'
        and licitacao.cod_entidade = ".$params['codEntidade']."
        and licitacao.cod_modalidade = ".$params['codModalidade']."
                                                                                         
               GROUP BY despesa.cod_despesa                                              
                  , conta_despesa.cod_conta                                              
                  , conta_despesa.cod_estrutural                                         
                  , orcamento.orgao.num_orgao                                            
                  , despesa.num_pao                                                      
                  , pao.nom_pao                                                          
                  , orcamento.orgao.nom_orgao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
