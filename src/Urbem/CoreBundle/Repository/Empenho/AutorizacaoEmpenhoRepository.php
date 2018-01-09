<?php

namespace Urbem\CoreBundle\Repository\Empenho;

use Urbem\CoreBundle\Repository\AbstractRepository;

class AutorizacaoEmpenhoRepository extends AbstractRepository
{
    /**
     * @param $numcgm
     * @param $exercicio
     * @param $filter
     * @return array
     */
    public function getAutorizacaoEmpenho($numcgm, $exercicio, $filter)
    {
        $sql = "
        SELECT
            DISTINCT tabela.*,
            CD.cod_estrutural AS cod_estrutural_conta
        FROM (
                SELECT
                    AE.cod_autorizacao,
                    to_char (
                        AE.dt_autorizacao,
                        'dd/mm/yyyy' ) AS dt_autorizacao,
                    PD.cod_despesa,
                    D.cod_conta,
                    CD.cod_estrutural AS cod_estrutural_rubrica,
                    PE.descricao,
                    PE.exercicio,
                    PE.cod_pre_empenho,
                    PE.cgm_beneficiario AS credor,
                    AE.cod_entidade,
                    AE.num_orgao,
                    AE.num_unidade,
                    AR.cod_reserva,
                    C.nom_cgm AS nom_fornecedor,
                    CASE
                        WHEN O.anulada IS NOT NULL THEN O.anulada
                        ELSE 'f'
                    END AS anulada,
                    compra_direta.cod_modalidade AS compra_cod_modalidade,
                    compra_direta.cod_compra_direta,
                    adjudicacao.cod_modalidade AS licitacao_cod_modalidade,
                    adjudicacao.cod_licitacao,
                    item_pre_empenho.cod_centro AS centro_custo
                FROM
                    empenho.autorizacao_empenho AS AE
                LEFT JOIN empenho.autorizacao_reserva AS AR ON AR.exercicio = AE.exercicio
                AND AR.cod_entidade = AE.cod_entidade
                AND AR.cod_autorizacao = AE.cod_autorizacao
            LEFT JOIN empenho.autorizacao_anulada AS AA ON AA.cod_autorizacao = AE.cod_autorizacao
            AND AA.exercicio = AE.exercicio
            AND AA.cod_entidade = AE.cod_entidade
            LEFT JOIN orcamento.reserva AS O ON O.exercicio = AR.exercicio
            AND O.cod_reserva = AR.cod_reserva
            INNER JOIN empenho.pre_empenho AS PE ON AE.cod_pre_empenho = PE.cod_pre_empenho
                AND AE.exercicio = PE.exercicio
            INNER JOIN sw_cgm AS C ON C.numcgm = PE.cgm_beneficiario
            LEFT JOIN empenho.item_pre_empenho ON item_pre_empenho.cod_pre_empenho = pe.cod_pre_empenho
            AND item_pre_empenho.exercicio = pe.exercicio
            LEFT JOIN empenho.item_pre_empenho_julgamento ON item_pre_empenho_julgamento.cod_pre_empenho = item_pre_empenho.cod_pre_empenho
            AND item_pre_empenho_julgamento.exercicio = item_pre_empenho.exercicio
            AND item_pre_empenho_julgamento.num_item = item_pre_empenho.num_item
            LEFT JOIN compras.julgamento_item ON julgamento_item.exercicio = item_pre_empenho_julgamento.exercicio_julgamento
            AND julgamento_item.cod_cotacao = item_pre_empenho_julgamento.cod_cotacao
            AND julgamento_item.cod_item = item_pre_empenho_julgamento.cod_item
            AND julgamento_item.lote = item_pre_empenho_julgamento.lote
            AND julgamento_item.cgm_fornecedor = item_pre_empenho_julgamento.cgm_fornecedor
            LEFT JOIN compras.cotacao_item ON cotacao_item.exercicio = julgamento_item.exercicio
            AND cotacao_item.cod_cotacao = julgamento_item.cod_cotacao
            AND cotacao_item.lote = julgamento_item.lote
            AND cotacao_item.cod_item = julgamento_item.cod_item
            LEFT JOIN compras.cotacao ON cotacao.cod_cotacao = cotacao_item.cod_cotacao
            AND cotacao.exercicio = cotacao_item.exercicio
            LEFT JOIN compras.mapa_cotacao ON mapa_cotacao.cod_cotacao = cotacao.cod_cotacao
            AND mapa_cotacao.exercicio_cotacao = cotacao.exercicio
            LEFT JOIN compras.mapa ON mapa.cod_mapa = mapa_cotacao.cod_mapa
            AND mapa.exercicio = mapa_cotacao.exercicio_mapa
            LEFT JOIN compras.compra_direta ON compra_direta.cod_mapa = mapa.cod_mapa
            AND compra_direta.exercicio_mapa = mapa.exercicio
            LEFT JOIN licitacao.adjudicacao ON adjudicacao.exercicio_cotacao = cotacao_item.exercicio
            AND adjudicacao.cod_cotacao = cotacao_item.cod_cotacao
            AND adjudicacao.lote = cotacao_item.lote
            AND adjudicacao.cod_item = cotacao_item.cod_item
            LEFT JOIN empenho.pre_empenho_despesa AS PD ON PD.cod_pre_empenho = PE.cod_pre_empenho
            AND PD.exercicio = PE.exercicio
            LEFT JOIN orcamento.conta_despesa AS CD ON CD.exercicio = PD.exercicio
            AND CD.cod_conta = PD.cod_conta
            LEFT JOIN orcamento.despesa AS D ON D.exercicio = PD.exercicio
            AND D.cod_despesa = PD.cod_despesa
        WHERE
            AA.cod_autorizacao IS NULL
            AND NOT EXISTS (
                SELECT
                    *
                FROM
                    empenho.empenho_autorizacao AS ea
                WHERE
                    AE.cod_autorizacao = ea.cod_autorizacao
                    AND AE.cod_entidade = ea.cod_entidade
                    AND AE.exercicio = ea.exercicio
                    AND ea.cod_entidade = ae.cod_entidade
                    AND ea.exercicio = '2016' ) ) AS tabela
            LEFT JOIN orcamento.conta_despesa AS CD ON CD.exercicio = tabela.exercicio
            AND CD.cod_conta = tabela.cod_conta
            LEFT JOIN orcamento.despesa AS D ON D.cod_despesa = tabela.cod_despesa
            AND D.exercicio = tabela.exercicio
        WHERE
            tabela.num_orgao ::varchar || tabela.num_unidade ::varchar IN (
                SELECT
                    num_orgao::varchar || num_unidade::varchar
                FROM
                    empenho.permissao_autorizacao
                WHERE
                    numcgm = :numcgm
                    AND exercicio = :exercicio )
            AND tabela.exercicio = :exercicio
            AND tabela.anulada = 'f'
        ";
        
        if ($filter['codEntidade']['value'] !== "") {
            $sql .= " AND tabela.cod_entidade = :cod_entidade";
        }
        
        if ($filter['codDespesa']['value'] !== "") {
            $sql .= " AND tabela.cod_despesa = :cod_despesa";
        }
        
        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_autorizacao BETWEEN :codAutorizacaoInicial AND :codAutorizacaoFinal";
        }
        
        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $sql .= " AND tabela.dt_autorizacao BETWEEN :periodoInicial AND :periodoFinal";
        }
        
        if ($filter['codModalidadeCompra']['value'] !== "") {
            $sql .= " AND tabela.compra_cod_modalidade = :cod_modalidade";
        }
        
        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_compra_direta BETWEEN :codCompraDiretaInicial AND :codCompraDiretaFinal";
        }
        
        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $sql .= " AND tabela.licitacao_cod_modalidade = :cod_modalidade";
        }
        
        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_licitacao BETWEEN :codLicitacaoInicial AND :codLicitacaoFinal";
        }
        
        if ($filter['codCentroCusto']['value'] !== "") {
            $sql .= " AND tabela.centro_custo = :centro_custo";
        }
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('numcgm', $numcgm);
        $query->bindValue('exercicio', $exercicio);
        
        if ($filter['codEntidade']['value'] !== "") {
            $query->bindValue('cod_entidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        }
        
        if ($filter['codDespesa']['value'] !== "") {
            $query->bindValue('cod_despesa', $filter['codDespesa']['value'], \PDO::PARAM_INT);
        }
        
        if ($filter['codAutorizacaoInicial']['value'] !== "" && $filter['codAutorizacaoFinal']['value'] !== "") {
            $query->bindValue('codAutorizacaoInicial', $filter['codAutorizacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue('codAutorizacaoFinal', $filter['codAutorizacaoFinal']['value'], \PDO::PARAM_INT);
        }
        
        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
            $query->bindValue('periodoInicial', $periodoInicial);
            $query->bindValue('periodoFinal', $periodoFinal);
        }

        if ($filter['codModalidadeCompra']['value'] !== "") {
            $query->bindValue('cod_modalidade', $filter['codModalidadeCompra']['value'], \PDO::PARAM_INT);
        }
        
        if ($filter['codCompraDiretaInicial']['value'] !== "" && $filter['codCompraDiretaFinal']['value'] !== "") {
            $query->bindValue('codCompraDiretaInicial', $filter['codCompraDiretaInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue('codCompraDiretaFinal', $filter['codCompraDiretaFinal']['value'], \PDO::PARAM_INT);
        }
        
        if ($filter['codModalidadeLicitacao']['value'] !== "") {
            $query->bindValue('cod_modalidade', $filter['codModalidadeLicitacao']['value'], \PDO::PARAM_INT);
        }
        
        if ($filter['codLicitacaoInicial']['value'] !== "" && $filter['codLicitacaoFinal']['value'] !== "") {
            $query->bindValue('codLicitacaoInicial', $filter['codLicitacaoInicial']['value'], \PDO::PARAM_INT);
            $query->bindValue('codLicitacaoFinal', $filter['codLicitacaoFinal']['value'], \PDO::PARAM_INT);
        }
        
        if ($filter['codCentroCusto']['value'] !== "") {
            $query->bindValue('centro_custo', $filter['codCentroCusto']['value'], \PDO::PARAM_INT);
        }

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $exercicio
     * @param bool|int $codEntidade
     * @return int
     */
    public function getProximoCodAutorizacao($exercicio, $codEntidade = false)
    {
        $params = array();
        $params['exercicio'] = $exercicio;
        if ($codEntidade) {
            $params['cod_entidade'] = $codEntidade;
        }

        return $this->nextVal(
            "cod_autorizacao",
            $params
        );
    }

    /**
     * @param $numcgm
     * @param $filter
     * @return array
     */
    public function filterDuplicarAutorizacaoEmpenho($numcgm, $filter)
    {
        $sql = "
            SELECT
                tabela.*,
                D.cod_recurso,
                CD.cod_estrutural AS cod_estrutural_conta
            FROM
                (
                    SELECT
                        AE.cod_autorizacao,
                        EA.cod_empenho,
                        TO_CHAR(
                            AE.dt_autorizacao,
                            'dd/mm/yyyy'
                        ) AS dt_autorizacao,
                        PD.cod_despesa,
                        D.cod_conta,
                        CD.cod_estrutural AS cod_estrutural_rubrica,
                        PE.descricao,
                        PE.exercicio,
                        PE.cod_pre_empenho,
                        PE.cgm_beneficiario AS credor,
                        PE.cod_historico,
                        AE.cod_entidade,
                        AE.num_orgao,
                        AE.num_unidade,
                        AE.cod_categoria,
                        AR.cod_reserva,
                        C.nom_cgm AS nom_fornecedor,
                        CASE
                            WHEN AA.cod_autorizacao > 0 THEN 'Anulada'
                            ELSE CASE
                                WHEN EA.cod_autorizacao > 0 THEN 'Empenhada'
                                ELSE 'Não Empenhada'
                            END
                        END AS situacao,
                        CASE
                            WHEN O.anulada IS NOT NULL THEN O.anulada
                            ELSE 'f'
                        END AS anulada,
                        sum( IPE.vl_total ) AS vl_empenhado
                    FROM
                        empenho.autorizacao_empenho AS AE LEFT JOIN empenho.autorizacao_reserva AS AR ON
                        (
                            AR.exercicio = AE.exercicio
                            AND AR.cod_entidade = AE.cod_entidade
                            AND AR.cod_autorizacao = AE.cod_autorizacao
                        ) LEFT JOIN empenho.autorizacao_anulada AS AA ON
                        (
                            AA.cod_autorizacao = AE.cod_autorizacao
                            AND AA.exercicio = AE.exercicio
                            AND AA.cod_entidade = AE.cod_entidade
                        ) LEFT JOIN orcamento.reserva AS O ON
                        (
                            O.exercicio = AR.exercicio
                            AND O.cod_reserva = AR.cod_reserva
                        ) LEFT JOIN empenho.empenho_autorizacao AS EA ON
                        (
                            EA.exercicio = AE.exercicio
                            AND EA.cod_entidade = AE.cod_entidade
                            AND EA.cod_autorizacao = AE.cod_autorizacao
                        ),
                        sw_cgm AS C,
                        empenho.pre_empenho AS PE LEFT JOIN empenho.pre_empenho_despesa AS PD ON
                        (
                            PD.cod_pre_empenho = PE.cod_pre_empenho
                            AND PD.exercicio = PE.exercicio
                        ) LEFT JOIN empenho.item_pre_empenho AS IPE ON
                        (
                            IPE.cod_pre_empenho = PE.cod_pre_empenho
                            AND IPE.exercicio = PE.exercicio
                        ) LEFT JOIN orcamento.conta_despesa AS CD ON
                        (
                            CD.exercicio = PD.exercicio
                            AND CD.cod_conta = PD.cod_conta
                        ) LEFT JOIN orcamento.despesa AS D ON
                        (
                            D.exercicio = PD.exercicio
                            AND D.cod_despesa = PD.cod_despesa
                        )
                    where
                        AE.cod_pre_empenho = PE.cod_pre_empenho
                        AND AE.exercicio = PE.exercicio
                        AND C.numcgm = PE.cgm_beneficiario
                    GROUP BY
                        AE.cod_autorizacao,
                        EA.cod_empenho,
                        TO_CHAR(
                            AE.dt_autorizacao,
                            'dd/mm/yyyy'
                        ),
                        PD.cod_despesa,
                        D.cod_conta,
                        CD.cod_estrutural,
                        PE.descricao,
                        PE.exercicio,
                        PE.cod_pre_empenho,
                        PE.cgm_beneficiario,
                        PE.cod_historico,
                        AE.cod_entidade,
                        AE.num_orgao,
                        AE.num_unidade,
                        AE.cod_categoria,
                        AR.cod_reserva,
                        C.nom_cgm,
                        situacao,
                        anulada
                ) AS tabela LEFT JOIN orcamento.conta_despesa AS CD ON
                (
                    CD.exercicio = tabela.exercicio
                    AND CD.cod_conta = tabela.cod_conta
                ) LEFT JOIN orcamento.despesa AS D ON
                (
                    D.cod_despesa = tabela.cod_despesa
                    AND D.exercicio = tabela.exercicio
                )
            WHERE
                tabela.num_orgao::varchar || tabela.num_unidade::varchar in(
                    SELECT
                        num_orgao::varchar || num_unidade::varchar
                    FROM
                        empenho.permissao_autorizacao
                    where
                        1 = 1
                        AND numcgm = :numcgm
                        AND exercicio = :exercicio
                )
                AND tabela.exercicio = :exercicio
                AND tabela.situacao = 'Anulada'
                AND tabela.vl_empenhado =(
                    SELECT
                        SUM( EAI.vl_anulado )
                    FROM
                        empenho.empenho_anulado_item AS EAI
                    WHERE
                        EAI.cod_pre_empenho = tabela.cod_pre_empenho
                        AND EAI.exercicio = tabela.exercicio
                )
        ";

        if ($filter['codAutorizacaoInicial']['value'] !== "") {
            $sql .= " AND tabela.cod_autorizacao >= :codAutorizacaoInicial";
        }

        if ($filter['codAutorizacaoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_autorizacao <= :codAutorizacaoFinal";
        }

        if ($filter['codEmpenhoInicial']['value'] !== "") {
            $sql .= " AND tabela.cod_empenho >= :codEmpenhoInicial";
        }

        if ($filter['codEmpenhoFinal']['value'] !== "") {
            $sql .= " AND tabela.cod_empenho <= :codEmpenhoFinal";
        }

        if ($filter['codEntidade']['value'] !== "") {
            $sql .= " AND tabela.cod_entidade in(:codEntidade)";
        }

        if ($filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'] !== "") {
            $sql .= " AND tabela.credor = :credor";
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $sql .= " AND TO_DATE(dt_autorizacao, 'dd/mm/yyyy') 
                    between TO_DATE(:periodoInicial,'dd/mm/yyyy') 
                    AND TO_DATE(:periodoFinal, 'dd/mm/yyyy')";
        }

        $sql .= "ORDER BY
                tabela.cod_entidade,
                tabela.cod_autorizacao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('numcgm', $numcgm, \PDO::PARAM_INT);
        $query->bindValue('exercicio', $filter['exercicio']['value'], \PDO::PARAM_STR);

        if ($filter['codEntidade']['value'] !== "") {
            $query->bindValue('codEntidade', $filter['codEntidade']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codAutorizacaoInicial']['value'] !== "") {
            $query->bindValue('codAutorizacaoInicial', $filter['codAutorizacaoInicial']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codAutorizacaoFinal']['value'] !== "") {
            $query->bindValue('codAutorizacaoFinal', $filter['codAutorizacaoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
            $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
            $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
            $query->bindValue('periodoInicial', $periodoInicial);
            $query->bindValue('periodoFinal', $periodoFinal);
        }

        if ($filter['codEmpenhoInicial']['value'] !== "") {
            $query->bindValue('codEmpenhoInicial', $filter['codEmpenhoInicial']['value'], \PDO::PARAM_INT);
        }

        if ($filter['codEmpenhoFinal']['value'] !== "") {
            $query->bindValue('codEmpenhoFinal', $filter['codEmpenhoFinal']['value'], \PDO::PARAM_INT);
        }

        if ($filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'] !== "") {
            $query->bindValue('credor', $filter['fkEmpenhoPreEmpenho__fkSwCgm']['value'], \PDO::PARAM_INT);
        }

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * @param $exercicio
     * @param $inCodEntidade
     * @return \Doctrine\DBAL\Driver\Statement|mixed
     */
    public function recuperaMaiorDataAutorizacao($exercicio, $inCodEntidade)
    {
        $sql = "SELECT
        CASE WHEN max(dt_autorizacao) < to_date('01/01/" . $exercicio . "','dd/mm/yyyy') THEN
            '01/01/" . $exercicio . "'
        ELSE
            to_char(max(dt_autorizacao),'dd/mm/yyyy')
        END AS data_autorizacao
        FROM
        empenho.autorizacao_empenho
        WHERE cod_entidade IN (" . $inCodEntidade . ")
        AND exercicio = '" . $exercicio . "'";

        $result = $this->_em->getConnection()->prepare($sql);
        $result->execute();
        $result = $result->fetch(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return mixed
     */
    public function recuperaMaiorDataAutorizacaoEmpenho($exercicio, $codEntidade)
    {
        $sql = "
             SELECT dt_autorizacao
              FROM empenho.autorizacao_empenho
              WHERE cod_entidade = :cod_entidade
              AND exercicio = :exercicio
              ORDER BY dt_autorizacao DESC LIMIT 1
              ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue('cod_entidade', $codEntidade, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }


    /**
     * @param $codEntidade
     * @param $codAutorizacao
     * @param $codPreEmpenho
     * @param $exercicio
     * @return array
     */
    public function findDadosReemitirAutorizacao($codEntidade, $codAutorizacao, $codPreEmpenho, $exercicio, $dadosDefaultQuery)
    {
        $sql = "
           SELECT
                  tabela.*
                 ,publico.fn_mascara_dinamica( ( SELECT valor FROM administracao.configuracao
                                                  WHERE parametro = 'masc_despesa'
                                                    AND exercicio = :exercicio )
                                               ,tabela.num_orgao
                                                ||'.'||tabela.num_unidade
                                                ||'.'||tabela.cod_funcao
                                                ||'.'||tabela.cod_subfuncao
                                                ||'.'||tabela.num_programa
                                                ||'.'||tabela.num_acao
                                                ||'.'||replace(cd.cod_estrutural,'.','')
                  ) AS dotacao
                 ,tabela.nom_pao AS dotacao
                 ,cd.descricao AS nom_conta
                 ,tabela.nom_pao
                 ,tabela.cod_recurso
                 ,tabela.nom_recurso
            FROM (
                 SELECT
                      tabela.*
                     ,CGM.nom_cgm as nom_entidade
                     ,de.cod_funcao
                     ,de.cod_subfuncao
                     ,de.cod_programa
                     ,de.num_pao
                     ,pao.nom_pao
                     ,rec.cod_recurso
                     ,rec.nom_recurso
                     ,de.cod_despesa as dotacao_reduzida
                     ,CAST(ppa.programa.num_programa AS varchar) as num_programa
                     ,CAST(ppa.acao.num_acao AS VARCHAR) as num_acao
                 FROM
                 (
                     SELECT
                          pe.cod_pre_empenho
                         ,pe.descricao
                         ,aa.motivo
                         ,TO_CHAR(aa.dt_anulacao,'dd/mm/yyyy') as dt_anulacao
                         ,ae.cod_entidade
                         ,ae.cod_autorizacao
                         ,to_char(ae.dt_autorizacao, 'dd/mm/yyyy')  as dt_autorizacao
                         ,it.vl_total  as valor_total
                         ,(it.vl_total/it.quantidade) as valor_unitario
                         ,it.num_item
                         ,it.cod_item
                         ,it.cod_centro
                         ,centro_custo.descricao AS nom_centro
                         ,it.quantidade
                         ,it.nom_unidade
                         ,it.sigla_unidade as simbolo
                         ,TRIM(it.nom_item) as nom_item
                         ,CASE WHEN it.cod_marca IS NOT NULL 
                            THEN it.nom_item||' ( Marca: '||marca.cod_marca||' - '||marca.descricao||' )'
                            ELSE it.nom_item
                          END as nom_item_e_marca
                         ,TRIM(it.complemento) as complemento
                         ,cg.numcgm as num_fornecedor
                         ,cg.nom_cgm
                         ,oe.numcgm
                         ,CASE WHEN pf.numcgm IS NOT NULL THEN pf.cpf
                               ELSE pj.cnpj
                          END as cpf_cnpj
                         ,cg.tipo_logradouro||' '||cg.logradouro||' '||cg.numero||' '||cg.complemento as endereco
                         ,mu.nom_municipio
                         ,CASE WHEN cg.fone_residencial IS NOT NULL THEN cg.fone_residencial
                               ELSE cg.fone_comercial
                          END as telefone
                         ,uf.sigla_uf
                         ,pd.cod_despesa
                         ,pd.cod_conta
                         ,ae.exercicio
                         ,ae.num_orgao
                         ,oo.nom_orgao as num_nom_orgao
                         ,TO_CHAR(ore.dt_validade_final ,'dd/mm/yyyy') as dt_validade_final
                         ,ou.num_unidade
                         ,ou.nom_unidade  as num_nom_unidade
                         ,LPAD(atributo_empenho_valor.valor,4,'0') AS cod_processo
                         ,atributo_empenho_valor_ano.valor AS ano_processo
                         ,CASE WHEN atributo_processo.ativo IS TRUE
                               THEN 'TRUE'
                               ELSE 'FALSE'
                          END AS bo_processo
                     FROM
                          empenho.pre_empenho          as pe
                         LEFT JOIN  
                                empenho.atributo_empenho_valor
                          ON (  atributo_empenho_valor.exercicio = pe.exercicio AND
                                atributo_empenho_valor.cod_pre_empenho  = pe.cod_pre_empenho AND
                                atributo_empenho_valor.cod_modulo = :cod_modulo AND
                                atributo_empenho_valor.cod_atributo = :cod_atributo_join_valor )
                         LEFT JOIN
                                empenho.atributo_empenho_valor AS atributo_empenho_valor_ano
                          ON (  atributo_empenho_valor_ano.exercicio = pe.exercicio AND
                                atributo_empenho_valor_ano.cod_pre_empenho  = pe.cod_pre_empenho AND
                                atributo_empenho_valor_ano.cod_modulo = :cod_modulo AND
                                atributo_empenho_valor_ano.cod_atributo = :cod_atributo_join_valor_ano )
                         LEFT JOIN
                                administracao.atributo_dinamico AS atributo_processo
                          ON (  atributo_processo.cod_modulo = :cod_modulo AND
                                atributo_processo.cod_atributo = :cod_atributo_join_valor )
                         LEFT JOIN
                                empenho.autorizacao_empenho as ae
                          ON (     ae.cod_pre_empenho  = pe.cod_pre_empenho
                                AND ae.exercicio        = pe.exercicio   )
                         LEFT JOIN
                                empenho.autorizacao_reserva as ar
                          ON ( ar.cod_autorizacao = ae.cod_autorizacao AND
                               ar.exercicio       = ae.exercicio       AND
                               ar.cod_entidade    = ae.cod_entidade    )
                         LEFT JOIN
                                orcamento.reserva as ore
                          ON ( ore.cod_reserva  =  ar.cod_reserva   AND
                               ore.exercicio    =  ar.exercicio     )
                          LEFT JOIN
                                  empenho.autorizacao_anulada as aa
                               ON (     ae.cod_entidade     = aa.cod_entidade
                                    AND ae.exercicio        = aa.exercicio
                                    AND ae.cod_autorizacao  = aa.cod_autorizacao )
                          LEFT JOIN
                                  empenho.pre_empenho_despesa as pd
                               ON (     pe.cod_pre_empenho   = pd.cod_pre_empenho
                                    AND pe.exercicio        = pd.exercicio      )
                         ,empenho.item_pre_empenho     as it
                         LEFT JOIN
                          almoxarifado.centro_custo
                         ON centro_custo.cod_centro = it.cod_centro
                         LEFT JOIN almoxarifado.marca
                          ON marca.cod_marca = it.cod_marca
                         ,orcamento.unidade            as ou
                         ,orcamento.orgao              as oo
                         ,orcamento.entidade           as oe
                         ,administracao.unidade_medida            as um
                         ,sw_cgm                       as cg
                         LEFT JOIN
                          sw_cgm_pessoa_fisica         as pf
                         ON (cg.numcgm = pf.numcgm)
                         LEFT JOIN
                          sw_cgm_pessoa_juridica       as pj
                         ON (cg.numcgm = pj.numcgm)
                        ,sw_municipio                  as mu
                        ,sw_uf                         as uf
                     WHERE   pe.cod_pre_empenho  = it.cod_pre_empenho
                     AND     pe.exercicio        = it.exercicio
                     AND     pe.cod_pre_empenho  = ae.cod_pre_empenho
                     AND     pe.exercicio        = ae.exercicio
                     --Órgão
                     AND     ae.num_orgao        = ou.num_orgao
                     AND     ae.num_unidade      = ou.num_unidade
                     AND     ae.exercicio        = ou.exercicio
                     AND     ou.num_orgao        = oo.num_orgao
                     AND     ou.exercicio        = oo.exercicio
                     --Unidade
                     AND     ae.num_orgao        = ou.num_orgao
                     AND     ae.num_unidade      = ou.num_unidade
                     AND     ae.exercicio        = ou.exercicio
                     -- Entidade
                     AND     ae.cod_entidade = OE.cod_entidade
                     AND     ae.exercicio    = OE.exercicio
                     --CGM
                     AND     pe.cgm_beneficiario = cg.numcgm
                     --Municipio
                     AND     cg.cod_municipio    = mu.cod_municipio
                     AND     cg.cod_uf           = mu.cod_uf
                     --Uf
                     AND     mu.cod_uf           = uf.cod_uf
                     --Unidade Medida
                     AND     it.cod_unidade      = um.cod_unidade
                     AND     it.cod_grandeza     = um.cod_grandeza
                     AND ae.cod_entidade = :cod_entidade AND ae.cod_autorizacao = :cod_autorizacao AND ae.cod_pre_empenho = :cod_pre_empenho AND ae.exercicio = :exercicio
                     ORDER BY ae.cod_pre_empenho, it.num_item
                 ) as tabela
                       LEFT JOIN
                            orcamento.despesa as de
                       ON (    de.cod_despesa = tabela.cod_despesa
                           AND de.exercicio   = tabela.exercicio   )
                       LEFT JOIN
                            orcamento.pao as pao
                       ON (    de.num_pao = pao.num_pao
                           AND de.exercicio   = pao.exercicio   )
                       LEFT JOIN
                            orcamento.recurso as rec
                       ON (    de.cod_recurso = rec.cod_recurso
                           AND de.exercicio   = rec.exercicio   )
                       LEFT JOIN orcamento.programa_ppa_programa
                              ON programa_ppa_programa.cod_programa = de.cod_programa
                             AND programa_ppa_programa.exercicio   = de.exercicio
                       LEFT JOIN ppa.programa
                              ON ppa.programa.cod_programa = programa_ppa_programa.cod_programa_ppa
                       LEFT JOIN orcamento.pao_ppa_acao
                              ON pao_ppa_acao.num_pao = de.num_pao
                             AND pao_ppa_acao.exercicio = de.exercicio
                       LEFT JOIN ppa.acao
                              ON ppa.acao.cod_acao = pao_ppa_acao.cod_acao
                      ,sw_cgm  as cgm
                 WHERE
                      CGM.numcgm          = tabela.numcgm
            ) as tabela
                 LEFT JOIN
                      orcamento.conta_despesa as cd
                 ON (    cd.cod_conta  = tabela.cod_conta
                     AND cd.exercicio  = tabela.exercicio   )
        ";

        list($codModulo, $codAtributoJoinValor, $codAtributoJoinValorAno) = $dadosDefaultQuery;
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_autorizacao', $codAutorizacao);
        $query->bindValue('cod_pre_empenho', $codPreEmpenho);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->bindValue('cod_modulo', $codModulo);
        $query->bindValue('cod_atributo_join_valor', $codAtributoJoinValor);
        $query->bindValue('cod_atributo_join_valor_ano', $codAtributoJoinValorAno);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
