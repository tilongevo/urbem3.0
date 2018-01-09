<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Urbem\CoreBundle\Repository\AbstractRepository;

class PreEmpenhoRepository extends AbstractRepository
{
    public function getDotacaoOrcamentaria($exercicio, $numcgm, $codEntidade)
    {
        $sql = "
        SELECT CD.cod_estrutural AS mascara_classificacao
        	, CD.descricao
        	, O.*
        	, publico.fn_mascara_dinamica((
        			SELECT valor
        			FROM administracao.configuracao
        			WHERE parametro = 'masc_despesa'
        				AND exercicio = :exercicio
        			), O.num_orgao || '.' || O.num_unidade || '.' || O.cod_funcao || '.' || O.cod_subfuncao || '.' || PP.num_programa || '.' || PA.num_acao || '.' || replace(cd.cod_estrutural, '.', '')) || '.' || publico.fn_mascara_dinamica((
        			SELECT valor
        			FROM administracao.configuracao
        			WHERE parametro = 'masc_recurso'
        				AND exercicio = :exercicio
        			), cast(cod_recurso AS VARCHAR)) AS dotacao
        FROM orcamento.conta_despesa AS CD
        	, orcamento.despesa AS O
        INNER JOIN orcamento.programa AS OP ON OP.cod_programa = O.cod_programa
        	AND OP.exercicio = O.exercicio
        INNER JOIN ppa.programa AS PP ON PP.cod_programa = OP.cod_programa
        INNER JOIN orcamento.despesa_acao ON despesa_acao.cod_despesa = O.cod_despesa
        	AND despesa_acao.exercicio_despesa = O.exercicio
        INNER JOIN ppa.acao AS PA ON PA.cod_acao = despesa_acao.cod_acao
        WHERE CD.exercicio IS NOT NULL
        	AND O.cod_conta = CD.cod_conta
        	AND O.exercicio = CD.exercicio
        	AND EXISTS (
        		SELECT 1
        		FROM empenho.permissao_autorizacao
        		WHERE permissao_autorizacao.num_orgao = O.num_orgao
        			AND permissao_autorizacao.num_unidade = O.num_unidade
        			AND permissao_autorizacao.numcgm = :numcgm
        			AND permissao_autorizacao.exercicio = :exercicio
        		)
        	AND O.exercicio = :exercicio
            AND O.cod_entidade IN (:cod_entidade)
        ORDER BY cod_despesa
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('numcgm', $numcgm);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getSaldoDotacao($stExercicio, $inCodDespesa, $stDataEmpenho, $inEntidade)
    {
        $sql = "
        SELECT empenho.fn_saldo_dotacao_data_empenho(:stExercicio, :inCodDespesa, :stDataEmpenho, :inEntidade, 'R') AS saldo_anterior;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':stExercicio', $stExercicio);
        $query->bindValue(':inCodDespesa', $inCodDespesa, \PDO::PARAM_INT);
        $query->bindValue(':stDataEmpenho', $stDataEmpenho);
        $query->bindValue(':inEntidade', $inEntidade, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param string $exercicio
     * @param int $codDespesa
     * @param string $dataEmpenho
     * @param int $codEntidade
     * @return bool|string
     */
    public function getSaldoDotacaoDataAtual($exercicio, $codDespesa, $dataEmpenho, $codEntidade)
    {
        $sql = "SELECT empenho.fn_saldo_dotacao_data_atual_empenho(:exercicio, :codDespesa, :dataAtual, :dataEmpenho,  :codEntidade, 'R') AS saldo_anterior;";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue(':codDespesa', $codDespesa, \PDO::PARAM_INT);

        $dataAtual = new \DateTime("{$exercicio}-12-31");
        $query->bindValue(':dataAtual', $dataAtual->format("Y-m-d"), \PDO::PARAM_STR);

        $query->bindValue(':dataEmpenho', $dataEmpenho, \PDO::PARAM_STR);
        $query->bindValue(':codEntidade', $codEntidade, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchColumn(0);
    }

    public function getOrgaoOrcamentario($exercicio, $codEntidade, $numcgm)
    {
        $sql = "
        SELECT DISTINCT oo.num_orgao
        	, oo.nom_orgao
        	, ue.cod_entidade
        FROM orcamento.despesa AS de
        	, orcamento.entidade AS en
        	, orcamento.usuario_entidade AS ue
        	, orcamento.unidade AS ou
        	, empenho.permissao_autorizacao AS pa
        	, orcamento.orgao AS oo
        WHERE de.exercicio = en.exercicio
        	AND de.cod_entidade = en.cod_entidade
        	AND en.exercicio = ue.exercicio
        	AND en.cod_entidade = ue.cod_entidade
        	AND de.exercicio = ou.exercicio
        	AND de.num_orgao = ou.num_orgao
        	AND de.num_unidade = ou.num_unidade
        	AND ou.exercicio = pa.exercicio
        	AND ou.num_orgao = pa.num_orgao
        	AND ou.num_unidade = pa.num_unidade
        	AND ou.exercicio = oo.exercicio
        	AND ou.num_orgao = oo.num_orgao
        	AND ue.exercicio = :exercicio
        	AND ue.cod_entidade = :cod_entidade
        	AND pa.numcgm = :numcgm
        ORDER BY oo.num_orgao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':exercicio', $exercicio);
        $query->bindValue(':cod_entidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue(':numcgm', $numcgm, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $numcgm
     * @param $codDespesa
     * @return mixed
     */
    public function getOrgaoOrcamentarioDespesa($exercicio, $codEntidade, $numcgm, $codDespesa)
    {
        $sql = "
            SELECT
               CD.cod_estrutural as mascara_classificacao
              ,CD.descricao
              ,O.*
              ,publico.fn_mascara_dinamica( (
                                              SELECT valor
                                              FROM administracao.configuracao
                                              WHERE parametro = 'masc_despesa'
                                                    AND exercicio = :exercicio
                                            ),
                                            O.num_orgao
                                            ||'.'||O.num_unidade
                                            ||'.'||O.cod_funcao
                                            ||'.'||O.cod_subfuncao
                                            ||'.'||PP.num_programa
                                            ||'.'||PA.num_acao
                                            ||'.'||replace(cd.cod_estrutural,'.','')
               )
               ||'.'||publico.fn_mascara_dinamica( (
                                                     SELECT valor
                                                     FROM administracao.configuracao
                                                     WHERE parametro = 'masc_recurso'
                                                           AND exercicio = :exercicio
                                                   ),
                                                   cast(cod_recurso as VARCHAR)
               ) as dotacao
            FROM
              orcamento.conta_despesa  AS CD,
              orcamento.despesa        AS O
              JOIN orcamento.programa AS OP
                ON OP.cod_programa=O.cod_programa
                   AND OP.exercicio=O.exercicio
              JOIN ppa.programa AS PP
                ON PP.cod_programa=OP.cod_programa
              JOIN orcamento.despesa_acao
                ON despesa_acao.cod_despesa = O.cod_despesa
                   AND despesa_acao.exercicio_despesa = O.exercicio
              JOIN ppa.acao AS PA
                ON PA.cod_acao = despesa_acao.cod_acao
            WHERE
              CD.exercicio IS NOT NULL
              AND O.cod_conta     = CD.cod_conta
              AND O.exercicio     = CD.exercicio
              AND EXISTS (SELECT 1
                          FROM  empenho.permissao_autorizacao
                          WHERE  permissao_autorizacao.num_orgao   = O.num_orgao
                                 AND  permissao_autorizacao.num_unidade = O.num_unidade
                                 AND  permissao_autorizacao.numcgm      = :numcgm
                                 AND  permissao_autorizacao.exercicio   = :exercicio
              )
              AND  O.exercicio = :exercicio AND  O.cod_despesa = :cod_despesa AND  O.cod_entidade IN (:cod_entidade)  ORDER BY cod_estrutural,cod_conta
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue(':cod_entidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue(':numcgm', $numcgm, \PDO::PARAM_INT);
        $query->bindValue(':cod_despesa', $codDespesa, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    public function getUnidadeOrcamentaria($codEntidade, $numOrgao)
    {
        $sql = "
        SELECT DISTINCT ou.num_orgao
            , ou.num_unidade
            , ou.nom_unidade
            , ue.cod_entidade
        FROM orcamento.despesa AS de
            , orcamento.entidade AS en
            , orcamento.usuario_entidade AS ue
            , empenho.permissao_autorizacao AS pa
            , orcamento.unidade AS ou
        WHERE de.exercicio = en.exercicio
            AND de.cod_entidade = en.cod_entidade
            AND en.exercicio = ue.exercicio
            AND en.cod_entidade = ue.cod_entidade
            AND de.exercicio = ou.exercicio
            AND de.num_orgao = ou.num_orgao
            AND de.num_unidade = ou.num_unidade
            AND ou.exercicio = pa.exercicio
            AND ou.num_orgao = pa.num_orgao
            AND ou.num_unidade = pa.num_unidade
            AND ue.cod_entidade = :cod_entidade
            AND ou.num_orgao = :num_orgao
        ORDER BY ou.num_orgao
            , ou.num_unidade
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':cod_entidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue(':num_orgao', $numOrgao, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getContraPartida($exercicio, $numcgm)
    {
        $sql = "
        SELECT era.conta_contrapartida
        	, cpc.nom_conta
        	, era.numcgm
        FROM empenho.responsavel_adiantamento AS era
        INNER JOIN contabilidade.plano_analitica AS cpa ON (
        		era.exercicio = cpa.exercicio
        		AND era.conta_contrapartida = cpa.cod_plano
        		)
        INNER JOIN contabilidade.plano_conta AS cpc ON (
        		cpa.exercicio = cpc.exercicio
        		AND cpa.cod_conta = cpc.cod_conta
        		)
        WHERE ativo = true
        	AND era.exercicio = :exercicio
        	AND era.numcgm = :numcgm;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':exercicio', $exercicio);
        $query->bindValue(':numcgm', $numcgm, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public function getAtributosDinamicos()
    {
        $sql = "
        SELECT AD.cod_cadastro
        	, AD.cod_atributo
        	, AD.ativo
        	, AD.nao_nulo
        	, AD.nom_atributo
        	, administracao.valor_padrao(AD.cod_atributo, AD.cod_modulo, AD.cod_cadastro, '') AS valor_padrao
        	, CASE TA.cod_tipo
        		WHEN 3
        			THEN administracao.valor_padrao_desc(AD.cod_atributo, AD.cod_modulo, AD.cod_cadastro, administracao.valor_padrao(AD.cod_atributo, AD.cod_modulo, AD.cod_cadastro, ''))
        		WHEN 4
        			THEN administracao.valor_padrao_desc(AD.cod_atributo, AD.cod_modulo, AD.cod_cadastro, administracao.valor_padrao(AD.cod_atributo, AD.cod_modulo, AD.cod_cadastro, ''))
        		ELSE NULL
        		END AS valor_padrao_desc
        	, CASE TA.cod_tipo
        		WHEN 4
        			THEN administracao.valor_padrao_desc(AD.cod_atributo, AD.cod_modulo, AD.cod_cadastro, '')
        		ELSE NULL
        		END AS valor_desc
        	, AD.ajuda
        	, AD.mascara
        	, TA.nom_tipo
        	, TA.cod_tipo
        FROM administracao.atributo_dinamico AS ACA
        	, administracao.atributo_dinamico AS AD
        	, administracao.tipo_atributo AS TA
        WHERE ACA.cod_atributo = AD.cod_atributo
        	AND ACA.cod_cadastro = AD.cod_cadastro
        	AND ACA.cod_modulo = AD.cod_modulo
        	AND ACA.ativo = true
        	AND TA.cod_tipo = AD.cod_tipo
        	AND AD.ativo = true
        	AND AD.cod_modulo = 10
        	AND AD.cod_cadastro = 1
        ;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filter
     * @param $numcgm
     * @return array
     */
    public function filterPreEmpenho($filter, $numcgm)
    {
        $sql = "
            SELECT DISTINCT
              tabela.*,
              CD.cod_estrutural AS cod_estrutural_conta
            FROM (
                   SELECT
                     AE.cod_autorizacao,
                     TO_CHAR(AE.dt_autorizacao, 'dd/mm/yyyy') AS dt_autorizacao,
                     PD.cod_despesa,
                     D.cod_conta,
                     CD.cod_estrutural                        AS cod_estrutural_rubrica,
                     PE.descricao,
                     PE.exercicio,
                     PE.cod_pre_empenho,
                     PE.cgm_beneficiario                      AS credor,
                     AE.cod_entidade,
                     AE.num_orgao,
                     AE.num_unidade,
                     AR.cod_reserva,
                     C.nom_cgm                                AS nom_fornecedor,
                     CASE WHEN O.anulada IS NOT NULL
                       THEN O.anulada
                     ELSE 'f'
                     END                                      AS anulada,
                     compra_direta.cod_modalidade             AS compra_cod_modalidade,
                     compra_direta.cod_compra_direta,
                     adjudicacao.cod_modalidade               AS licitacao_cod_modalidade,
                     adjudicacao.cod_licitacao,
                     item_pre_empenho.cod_centro              AS centro_custo
            
                   FROM empenho.autorizacao_empenho AS AE
            
                     LEFT JOIN empenho.autorizacao_reserva AS AR
                       ON AR.exercicio = AE.exercicio
                          AND AR.cod_entidade = AE.cod_entidade
                          AND AR.cod_autorizacao = AE.cod_autorizacao
            
                     LEFT JOIN empenho.autorizacao_anulada AS AA
                       ON AA.cod_autorizacao = AE.cod_autorizacao
                          AND AA.exercicio = AE.exercicio
                          AND AA.cod_entidade = AE.cod_entidade
            
                     LEFT JOIN orcamento.reserva AS O
                       ON O.exercicio = AR.exercicio
                          AND O.cod_reserva = AR.cod_reserva
            
                     INNER JOIN empenho.pre_empenho AS PE
                       ON AE.cod_pre_empenho = PE.cod_pre_empenho
                          AND AE.exercicio = PE.exercicio
            
                     INNER JOIN sw_cgm AS C
                       ON C.numcgm = PE.cgm_beneficiario
            
                     LEFT JOIN empenho.item_pre_empenho
                       ON item_pre_empenho.cod_pre_empenho = pe.cod_pre_empenho
                          AND item_pre_empenho.exercicio = pe.exercicio
            
                     LEFT JOIN empenho.item_pre_empenho_julgamento
                       ON item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
                          AND item_pre_empenho_julgamento.exercicio = item_pre_empenho.exercicio
                          AND item_pre_empenho_julgamento.num_item = item_pre_empenho.num_item
            
                     LEFT JOIN compras.julgamento_item
                       ON julgamento_item.exercicio = item_pre_empenho_julgamento.exercicio_julgamento
                          AND julgamento_item.cod_cotacao = item_pre_empenho_julgamento.cod_cotacao
                          AND julgamento_item.cod_item = item_pre_empenho_julgamento.cod_item
                          AND julgamento_item.lote = item_pre_empenho_julgamento.lote
                          AND julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
            
                     LEFT JOIN compras.cotacao_item
                       ON cotacao_item.exercicio = julgamento_item.exercicio
                          AND cotacao_item.cod_cotacao = julgamento_item.cod_cotacao
                          AND cotacao_item.lote = julgamento_item.lote
                          AND cotacao_item.cod_item = julgamento_item.cod_item
            
                     LEFT JOIN compras.cotacao
                       ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
                          AND cotacao.exercicio = cotacao_item.exercicio
            
                     LEFT JOIN compras.mapa_cotacao
                       ON mapa_cotacao.cod_cotacao = cotacao.cod_cotacao
                          AND mapa_cotacao.exercicio_cotacao = cotacao.exercicio
            
                     LEFT JOIN compras.mapa
                       ON mapa.cod_mapa = mapa_cotacao.cod_mapa
                          AND mapa.exercicio = mapa_cotacao.exercicio_mapa
            
                     LEFT JOIN compras.compra_direta
                       ON compra_direta.cod_mapa = mapa.cod_mapa
                          AND compra_direta.exercicio_mapa = mapa.exercicio
            
                     LEFT JOIN licitacao.adjudicacao
                       ON adjudicacao.exercicio_cotacao = cotacao_item.exercicio
                          AND adjudicacao.cod_cotacao = cotacao_item.cod_cotacao
                          AND adjudicacao.lote = cotacao_item.lote
                          AND adjudicacao.cod_item = cotacao_item.cod_item
            
                     LEFT JOIN empenho.pre_empenho_despesa AS PD
                       ON PD.cod_pre_empenho = PE.cod_pre_empenho
                          AND PD.exercicio = PE.exercicio
            
                     LEFT JOIN orcamento.conta_despesa AS CD
                       ON CD.exercicio = PD.exercicio
                          AND CD.cod_conta = PD.cod_conta
            
                     LEFT JOIN orcamento.despesa AS D
                       ON D.exercicio = PD.exercicio
                          AND D.cod_despesa = PD.cod_despesa
            
                   WHERE -- AA.cod_autorizacao IS NULL AND 
                        NOT EXISTS(SELECT *
                                        FROM empenho.empenho_autorizacao AS ea
                                        WHERE AE.cod_autorizacao = ea.cod_autorizacao
                                              AND AE.cod_entidade = ea.cod_entidade
                                              AND AE.exercicio = ea.exercicio
                                              AND ea.cod_entidade = ae.cod_entidade
                                              AND ea.exercicio = :exercicio
                   )
                 ) AS tabela
            
              LEFT JOIN orcamento.conta_despesa AS CD
                ON CD.exercicio = tabela.exercicio
                   AND CD.cod_conta = tabela.cod_conta
            
              LEFT JOIN orcamento.despesa AS D
                ON D.cod_despesa = tabela.cod_despesa
                   AND D.exercicio = tabela.exercicio
            
            WHERE tabela.num_orgao :: VARCHAR || tabela.num_unidade :: VARCHAR
                  IN (SELECT num_orgao :: VARCHAR || num_unidade :: VARCHAR
                      FROM empenho.permissao_autorizacao
                      WHERE numcgm = :numcgm
                            AND exercicio = :exercicio
                  )
                  AND tabela.cod_entidade IN (:cod_entidade) AND tabela.exercicio = :exercicio AND
                  NOT EXISTS(SELECT ee.cod_pre_empenho
                             FROM empenho.empenho AS ee
                             WHERE ee.cod_pre_empenho = tabela.cod_pre_empenho
                                   AND ee.exercicio = tabela.exercicio
                  )
        ";

        if ($filter['codCentroCusto']['value'] !== "") {
            $sql .= " AND tabela.centro_custo = :cod_centro";
        }

        if ($filter['codDespesa']['value'] !== "") {
            $sql .= " AND tabela.cod_despesa = :cod_despesa";
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_autorizacao >= :codAutorizacaoInicial AND tabela.cod_autorizacao <= :codAutorizacaoFinal";
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $sql .= " AND TO_DATE(dt_autorizacao,'dd/mm/yyyy' ) BETWEEN TO_DATE(:periodoInicial,'dd/mm/yyyy' ) AND TO_DATE(:periodoFinal,'dd/mm/yyyy' )";
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $sql .= " AND tabela.licitacao_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_compra_direta >= :codCompraDiretaInicial AND tabela.cod_compra_direta <= :codCompraDiretaFinal";
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $sql .= " AND tabela.compra_cod_modalidade = :cod_modalidade";
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_licitacao >= :codLicitacaoInicial AND tabela.cod_licitacao <= :codLicitacaoFinal";
        }

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':cod_entidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $filter['exercicio']['value'], \PDO::PARAM_STR);
        $query->bindValue(':numcgm', $numcgm, \PDO::PARAM_INT);

        if ($filter['codCentroCusto']['value'] !== "") {
            $query->bindValue(':cod_centro', $filter['codCentroCusto']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codDespesa']['value'] !== "") {
            $query->bindValue(':cod_despesa', $filter['codDespesa']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $query->bindValue(':codAutorizacaoInicial', $filter['codAutorizacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codAutorizacaoFinal', $filter['codAutorizacaoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
            $query->bindValue(':periodoInicial', $periodoInicial);
            $query->bindValue(':periodoFinal', $periodoFinal);
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeCompra']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $query->bindValue(':codCompraDiretaInicial', $filter['codCompraDiretaInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codCompraDiretaFinal', $filter['codCompraDiretaFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $query->bindValue(':cod_modalidade', $filter['codModalidadeLicitacao']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $query->bindValue(':codLicitacaoInicial', $filter['codLicitacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue(':codLicitacaoFinal', $filter['codLicitacaoFinal']['value'], \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getReservaSaldo($codDespesa, $exercicio)
    {
        $sql = "
        SELECT rs.cod_reserva
        FROM orcamento.reserva_saldos rs
        WHERE rs.cod_despesa = :cod_despesa
        	AND rs.exercicio = :exercicio;
        ;";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':cod_despesa', $codDespesa, \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $exercicio);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }
    
    public function getUltimoPreEmpenho($exercicio)
    {
        return $this->nextVal(
            "cod_pre_empenho",
            array(
                'exercicio' => $exercicio
            )
        );
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function exerciciosQueryBuilder()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select('e.exercicio');
        $qb->groupBy('e.exercicio');
        $qb->orderBy('e.exercicio', 'DESC');

        return $qb;
    }

    /**
     * @return mixed
     */
    public function findExerciciosList()
    {
        $qb = $this->exerciciosQueryBuilder();
        return $qb->getQuery()->execute();
    }
}
