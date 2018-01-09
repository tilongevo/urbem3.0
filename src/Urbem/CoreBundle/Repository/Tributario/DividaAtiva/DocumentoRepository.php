<?php

namespace Urbem\CoreBundle\Repository\Tributario\DividaAtiva;

use PDO;
use Urbem\CoreBundle\Repository\AbstractRepository;

class DocumentoRepository extends AbstractRepository
{
    const COD_MODULO_ADMINISTRACAO = 2;
    const COD_MODULO_DIVIDA_ATIVA = 33;

    /**
    * @param array $filtro
    * @return array
    */
    public function getDocumentos(array $filtro = [])
    {
        $query = "
            SELECT DISTINCT
                        ddp.cod_inscricao || '|' || ddp.exercicio,
                        ddd.*
                        , tmp_ded.num_emissao
                        , tmp_ded.num_documento
                        , tmp_ded.exercicio
                        , CASE WHEN dp.numero_parcelamento = -1 THEN
                                ' '
                          ELSE
                                dp.numero_parcelamento::text
                          END AS numero_parcelamento
                        , CASE WHEN dp.exercicio = '-1' THEN
                                ' '
                          ELSE
                                dp.exercicio::text
                          END AS exercicio_cobranca
                        , swc.nom_cgm
                        , ddc.numcgm
                        , amd.nome_documento
                        , amd.nome_arquivo_agt
                        , aad.nome_arquivo_swx
                        , to_char(tmp_dedm.timestamp, 'dd/mm/YYYY') AS data_emissao
                        , ddp.cod_inscricao || '/' || ddp.exercicio AS inscricoes,
                        ddp.cod_inscricao,
                        ddp.exercicio
                FROM divida.documento as ddd
                INNER JOIN tmp_ddp AS ddp
                       ON ddp.num_parcelamento = ddd.num_parcelamento
                LEFT JOIN tmp_ded
                       ON tmp_ded.cod_tipo_documento = ddd.cod_tipo_documento
                      AND tmp_ded.cod_documento      = ddd.cod_documento
                      AND tmp_ded.num_parcelamento   = ddd.num_parcelamento

                LEFT JOIN tmp_dedm
                       ON tmp_dedm.cod_tipo_documento = ddd.cod_tipo_documento
                      AND tmp_dedm.cod_documento      = ddd.cod_documento
                      AND tmp_dedm.num_parcelamento   = ddd.num_parcelamento


                INNER JOIN divida.parcelamento AS dp
                       ON dp.num_parcelamento = ddd.num_parcelamento

                INNER JOIN divida.divida_cgm AS ddc
                       ON ddc.exercicio = ddp.exercicio
                      AND ddc.cod_inscricao = ddp.cod_inscricao

                INNER JOIN sw_cgm AS swc
                       ON swc.numcgm = ddc.numcgm

                INNER JOIN administracao.modelo_documento AS amd
                       ON amd.cod_documento = ddd.cod_documento
                      AND amd.cod_tipo_documento = ddd.cod_tipo_documento
                INNER JOIN administracao.modelo_arquivos_documento AS amad
                       ON amad.cod_documento = ddd.cod_documento
                      AND amad.cod_tipo_documento = ddd.cod_tipo_documento
                INNER JOIN administracao.arquivos_documento AS aad
                       ON aad.cod_arquivo = amad.cod_arquivo
                LEFT JOIN divida.divida_cancelada AS ddcanc
                       ON ddcanc.cod_inscricao = ddp.cod_inscricao
                      AND ddcanc.exercicio = ddp.exercicio
                LEFT JOIN divida.divida_remissao
                       ON divida_remissao.cod_inscricao = ddp.cod_inscricao
                      AND divida_remissao.exercicio = ddp.exercicio
                LEFT JOIN divida.divida_imovel AS ddi
                      ON ddi.cod_inscricao = ddp.cod_inscricao
                      AND ddi.exercicio = ddp.exercicio
                LEFT JOIN divida.divida_empresa AS dde
                      ON dde.cod_inscricao = ddp.cod_inscricao
                      AND dde.exercicio = ddp.exercicio
                LEFT JOIN divida.emissao_documento AS ded
                      ON ded.num_parcelamento = dp.num_parcelamento
                      AND ded.cod_tipo_documento = amd.cod_tipo_documento
                LEFT JOIN divida.documento AS dd
                      ON ded.num_parcelamento = dp.num_parcelamento
                      AND dd.cod_tipo_documento = amd.cod_tipo_documento
                    WHERE CASE WHEN ( divida_remissao.cod_inscricao IS NOT NULL ) THEN
                               CASE WHEN ( ddd.cod_tipo_documento = 7 ) THEN
                                    true
                               ELSE
                                    false
                               END
                          ELSE
                               true
                          END

                    AND ddcanc.cod_inscricao IS NULL
                    AND ddcanc.exercicio IS NULL
                    %s
                ORDER BY ddp.cod_inscricao, ddp.exercicio, swc.nom_cgm ASC";

        $where = '';
        if (!empty($filtro['tipoDocumento'])) {
            $where .= sprintf("AND amd.cod_tipo_documento = %d\n", $filtro['tipoDocumento']);
        }

        if (!empty($filtro['documento'])) {
            list($codTipoDocumento, $codDocumento) = explode('~', $filtro['documento']);
            $where .= sprintf("AND dd.cod_tipo_documento = %d AND dd.cod_documento = %d\n", $codTipoDocumento, $codDocumento);
        }

        if (!empty($filtro['cgmInicial'])) {
            $where .= sprintf("AND ddc.numcgm >= %d\n", $filtro['cgmInicial']);
        }

        if (!empty($filtro['cgmFinal'])) {
            $where .= sprintf("AND ddc.numcgm <= %d\n", $filtro['cgmFinal']);
        }

        if (!empty($filtro['inscricaoMunicipalInicial'])) {
            $where .= sprintf("AND ddi.inscricao_municipal >= %d\n", $filtro['inscricaoMunicipalInicial']);
        }

        if (!empty($filtro['inscricaoMunicipalFinal'])) {
            $where .= sprintf("AND ddi.inscricao_municipal <= %d\n", $filtro['inscricaoMunicipalFinal']);
        }

        if (!empty($filtro['cadastroEconomicoInicial'])) {
            $where .= sprintf("AND dde.inscricao_economica >= %d\n", $filtro['cadastroEconomicoInicial']);
        }

        if (!empty($filtro['cadastroEconomicoFinal'])) {
            $where .= sprintf("AND dde.inscricao_economica <= %d\n", $filtro['cadastroEconomicoFinal']);
        }

        if (!empty($filtro['inscricaoAnoInicial'])) {
            list($inscricao, $ano) = explode('/', $filtro['inscricaoAnoInicial']);
            $where .= sprintf("AND ddp.cod_inscricao >= %d AND ddp.exercicio >= '%s'\n", $inscricao, $ano);
        }

        if (!empty($filtro['inscricaoAnoFinal'])) {
            list($inscricao, $ano) = explode('/', $filtro['inscricaoAnoFinal']);
            $where .= sprintf("AND ddp.cod_inscricao <= %d AND ddp.exercicio <= '%s'\n", $inscricao, $ano);
        }

        $pdo = $this->_em->getConnection();
        $pdo->beginTransaction();

        $pdo->exec($this->getTemporaryTablesSql());

        $sth = $pdo->prepare(sprintf($query, $where));
        $sth->execute();

        $pdo->commit();

        return $sth->fetchAll(PDO::FETCH_UNIQUE);
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function getDocumentosEmitidos(array $filtro = [])
    {
        $query = "
            SELECT MAX(EMISSAO_DOCUMENTO.NUM_EMISSAO) AS  NUM_EMISSAO
                             , EMISSAO_DOCUMENTO.num_parcelamento
                             , EMISSAO_DOCUMENTO.cod_tipo_documento
                             , EMISSAO_DOCUMENTO.cod_documento
                             , EMISSAO_DOCUMENTO.num_documento
                             , EMISSAO_DOCUMENTO.exercicio
                             , TO_CHAR(MAX(EMISSAO_DOCUMENTO.timestamp),'dd/mm/YYYY') AS data_emissao
                             , DIVIDA_DOCUMENTO.nom_cgm
                             , DIVIDA_DOCUMENTO.numcgm
                             , DIVIDA_DOCUMENTO.nome_documento
                             , DIVIDA_DOCUMENTO.nome_arquivo_agt
                             , DIVIDA_DOCUMENTO.nome_arquivo_swx
                             , DIVIDA_DOCUMENTO.REMIDO
                             , lista_cobranca_por_documento ( EMISSAO_DOCUMENTO.num_documento, EMISSAO_DOCUMENTO.cod_documento, EMISSAO_DOCUMENTO.cod_tipo_documento ) AS cobranca
                             , lista_inscricao_por_documento( EMISSAO_DOCUMENTO.num_documento, EMISSAO_DOCUMENTO.cod_documento, EMISSAO_DOCUMENTO.cod_tipo_documento, EMISSAO_DOCUMENTO.exercicio ) AS inscricoes
                             , DIVIDA_DOCUMENTO.cod_inscricao
                             , DIVIDA_DOCUMENTO.inscricao_municipal
                             , DIVIDA_DOCUMENTO.inscricao_economica
                          FROM DIVIDA.EMISSAO_DOCUMENTO
                    INNER JOIN
                             (   SELECT DOCUMENTO.cod_tipo_documento
                                      , DOCUMENTO.cod_documento
                                      , DOCUMENTO.num_parcelamento
                                      , SW_CGM.nom_cgm
                                      , SW_CGM.numcgm
                                      , MODELO_DOCUMENTO.nome_documento
                                      , MODELO_DOCUMENTO.nome_arquivo_agt
                                      , ARQUIVOS_DOCUMENTO.nome_arquivo_swx
                                      , CASE WHEN ( divida_remissao.cod_inscricao IS NOT NULL ) THEN
                                          TRUE
                                        ELSE
                                            FALSE
                                        END  AS REMIDO
                                      , DIVIDA_CGM.cod_inscricao
                                      , ddi.inscricao_municipal
                                      , dde.inscricao_economica
                                   FROM DIVIDA.DOCUMENTO
                             INNER JOIN DIVIDA.DIVIDA_PARCELAMENTO
                                     ON DOCUMENTO.NUM_PARCELAMENTO = DIVIDA_PARCELAMENTO.NUM_PARCELAMENTO
                             INNER JOIN ADMINISTRACAO.MODELO_DOCUMENTO
                                     ON DOCUMENTO.COD_TIPO_DOCUMENTO = MODELO_DOCUMENTO.COD_TIPO_DOCUMENTO
                                    AND DOCUMENTO.COD_DOCUMENTO  = MODELO_DOCUMENTO.COD_DOCUMENTO
                             INNER JOIN
                                      ( SELECT DISTINCT
                                               COD_DOCUMENTO
                                             , COD_TIPO_DOCUMENTO
                                             , COD_ARQUIVO
                                         FROM  ADMINISTRACAO.MODELO_ARQUIVOS_DOCUMENTO
                                      ) AS MODELO_ARQUIVOS_DOCUMENTO
                                     ON DOCUMENTO.COD_DOCUMENTO = MODELO_ARQUIVOS_DOCUMENTO.COD_DOCUMENTO
                                    AND DOCUMENTO.COD_TIPO_DOCUMENTO = MODELO_ARQUIVOS_DOCUMENTO.COD_TIPO_DOCUMENTO
                             INNER JOIN ADMINISTRACAO.ARQUIVOS_DOCUMENTO
                                     ON MODELO_ARQUIVOS_DOCUMENTO.COD_ARQUIVO = ARQUIVOS_DOCUMENTO.COD_ARQUIVO
                             INNER JOIN DIVIDA.DIVIDA_CGM
                                     ON DIVIDA_PARCELAMENTO.COD_INSCRICAO = DIVIDA_CGM.COD_INSCRICAO
                                    AND DIVIDA_PARCELAMENTO.EXERCICIO = DIVIDA_CGM.EXERCICIO
                             INNER JOIN SW_CGM
                                     ON DIVIDA_CGM.NUMCGM = SW_CGM.NUMCGM           LEFT JOIN DIVIDA.DIVIDA_REMISSAO
                                         ON DIVIDA_PARCELAMENTO.COD_INSCRICAO = DIVIDA_REMISSAO.COD_INSCRICAO
                                        AND DIVIDA_PARCELAMENTO.EXERCICIO = DIVIDA_REMISSAO.EXERCICIO
                              LEFT JOIN divida.divida_imovel AS ddi
                                    ON ddi.cod_inscricao = DIVIDA_CGM.cod_inscricao
                                    AND ddi.exercicio = DIVIDA_CGM.exercicio
                              LEFT JOIN divida.divida_empresa AS dde
                                    ON dde.cod_inscricao = DIVIDA_CGM.cod_inscricao
                                    AND dde.exercicio = DIVIDA_CGM.exercicio
                                  ) AS DIVIDA_DOCUMENTO
                                 ON DIVIDA_DOCUMENTO.cod_tipo_documento = EMISSAO_DOCUMENTO.cod_tipo_documento
                                AND DIVIDA_DOCUMENTO.cod_documento      = EMISSAO_DOCUMENTO.cod_documento
                                AND DIVIDA_DOCUMENTO.num_parcelamento   = EMISSAO_DOCUMENTO.num_parcelamento
                                WHERE DIVIDA_DOCUMENTO.cod_inscricao IS NOT NULL
                                  AND EMISSAO_DOCUMENTO.exercicio IS NOT NULL
                                  %s

                           GROUP BY EMISSAO_DOCUMENTO.num_parcelamento
                                  , EMISSAO_DOCUMENTO.cod_tipo_documento
                                  , EMISSAO_DOCUMENTO.cod_documento
                                  , EMISSAO_DOCUMENTO.num_documento
                                  , EMISSAO_DOCUMENTO.exercicio
                                  , DIVIDA_DOCUMENTO.nom_cgm
                                  , DIVIDA_DOCUMENTO.numcgm
                                  , DIVIDA_DOCUMENTO.nome_documento
                                  , DIVIDA_DOCUMENTO.nome_arquivo_agt
                                  , DIVIDA_DOCUMENTO.nome_arquivo_swx
                                  , DIVIDA_DOCUMENTO.REMIDO
                                  , DIVIDA_DOCUMENTO.cod_inscricao
                                  , DIVIDA_DOCUMENTO.inscricao_municipal
                                  , DIVIDA_DOCUMENTO.inscricao_economica";

        $where = '';
        if (!empty($filtro['tipoDocumento'])) {
            $where .= sprintf("AND EMISSAO_DOCUMENTO.cod_tipo_documento = %d\n", $filtro['tipoDocumento']);
        }

        if (!empty($filtro['documento'])) {
            list($numParcelamento, $codTipoDocumento, $codDocumento) = explode('~', $filtro['documento']);
            $where .= sprintf("AND EMISSAO_DOCUMENTO.num_parcelamento = %d AND EMISSAO_DOCUMENTO.cod_tipo_documento = %d AND EMISSAO_DOCUMENTO.cod_documento = %d\n", $numParcelamento, $codTipoDocumento, $codDocumento);
        }

        if (!empty($filtro['cgmInicial'])) {
            $where .= sprintf("AND DIVIDA_DOCUMENTO.numcgm >= %d\n", $filtro['cgmInicial']);
        }

        if (!empty($filtro['cgmFinal'])) {
            $where .= sprintf("AND DIVIDA_DOCUMENTO.numcgm <= %d\n", $filtro['cgmFinal']);
        }

        if (!empty($filtro['inscricaoMunicipalInicial'])) {
            $where .= sprintf("AND DIVIDA_DOCUMENTO.inscricao_municipal >= %d\n", $filtro['inscricaoMunicipalInicial']);
        }

        if (!empty($filtro['inscricaoMunicipalFinal'])) {
            $where .= sprintf("AND DIVIDA_DOCUMENTO.inscricao_municipal <= %d\n", $filtro['inscricaoMunicipalFinal']);
        }

        if (!empty($filtro['cadastroEconomicoInicial'])) {
            $where .= sprintf("AND DIVIDA_DOCUMENTO.inscricao_economica >= %d\n", $filtro['cadastroEconomicoInicial']);
        }

        if (!empty($filtro['cadastroEconomicoFinal'])) {
            $where .= sprintf("AND DIVIDA_DOCUMENTO.inscricao_economica <= %d\n", $filtro['cadastroEconomicoFinal']);
        }

        if (!empty($filtro['inscricaoAnoInicial'])) {
            list($inscricao, $ano) = explode('/', $filtro['inscricaoAnoInicial']);
            $where .= sprintf("AND DIVIDA_DOCUMENTO.cod_inscricao >= %d AND EMISSAO_DOCUMENTO.exercicio >= '%s'\n", $inscricao, $ano);
        }

        if (!empty($filtro['inscricaoAnoFinal'])) {
            list($inscricao, $ano) = explode('/', $filtro['inscricaoAnoFinal']);
            $where .= sprintf("AND DIVIDA_DOCUMENTO.cod_inscricao <= %d AND EMISSAO_DOCUMENTO.exercicio <= '%s'\n", $inscricao, $ano);
        }

        if (!empty($filtro['numDocumento'])) {
            $where .= sprintf("AND EMISSAO_DOCUMENTO.num_documento = %d\n", $filtro['numDocumento']);
        }

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare(sprintf($query, $where));
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @return array
    */
    public function getModelosDocumento()
    {
        $query = "
            SELECT DISTINCT
                        amd.nome_documento
                        , amd.nome_arquivo_agt
                FROM divida.documento as ddd
                INNER JOIN tmp_ddp AS ddp
                       ON ddp.num_parcelamento = ddd.num_parcelamento
                LEFT JOIN tmp_ded
                       ON tmp_ded.cod_tipo_documento = ddd.cod_tipo_documento
                      AND tmp_ded.cod_documento      = ddd.cod_documento
                      AND tmp_ded.num_parcelamento   = ddd.num_parcelamento

                LEFT JOIN tmp_dedm
                       ON tmp_dedm.cod_tipo_documento = ddd.cod_tipo_documento
                      AND tmp_dedm.cod_documento      = ddd.cod_documento
                      AND tmp_dedm.num_parcelamento   = ddd.num_parcelamento


                INNER JOIN divida.parcelamento AS dp
                       ON dp.num_parcelamento = ddd.num_parcelamento

                INNER JOIN divida.divida_cgm AS ddc
                       ON ddc.exercicio = ddp.exercicio
                      AND ddc.cod_inscricao = ddp.cod_inscricao

                INNER JOIN sw_cgm AS swc
                       ON swc.numcgm = ddc.numcgm

                INNER JOIN administracao.modelo_documento AS amd
                       ON amd.cod_documento = ddd.cod_documento
                      AND amd.cod_tipo_documento = ddd.cod_tipo_documento
                INNER JOIN administracao.modelo_arquivos_documento AS amad
                       ON amad.cod_documento = ddd.cod_documento
                      AND amad.cod_tipo_documento = ddd.cod_tipo_documento
                INNER JOIN administracao.arquivos_documento AS aad
                       ON aad.cod_arquivo = amad.cod_arquivo
                ORDER BY amd.nome_documento, amd.nome_arquivo_agt ASC";

        $pdo = $this->_em->getConnection();
        $pdo->beginTransaction();

        $pdo->exec($this->getTemporaryTablesSql());

        $sth = $pdo->prepare($query);
        $sth->execute();

        $pdo->commit();

        return $sth->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosCertidaoDAUrbem(array $params = [])
    {
        if (empty($params['numParcelamento'])) {
            return [];
        }

        $query = "
            SELECT DISTINCT
                            to_char(now(), 'dd/mm/yyyy') AS dt_notificacao,
                            dda.dt_vencimento_origem,
                            sw_cgm_pessoa_fisica.rg,
                            sw_cgm_pessoa_fisica.orgao_emissor,
                            COALESCE( sw_cgm_pessoa_fisica.cpf, sw_cgm_pessoa_juridica.cnpj ) AS cpf_cnpj,
                            dda.cod_inscricao,
                            dda.exercicio,
                            dpar.cod_modalidade,
                            ddi.inscricao_municipal,
                            dde.inscricao_economica,
                            COALESCE( ddi.inscricao_municipal, dde.inscricao_economica, ddc.numcgm) AS inscricao,
                            dda.num_livro,
                            dda.num_folha,
                            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 1 )
                            ELSE
                                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 1 )
                                ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 1 )
                                END
                            END AS endereco,

                            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 2 )
                            ELSE
                                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 2 )
                                ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 2 )
                                END
                            END AS bairro,

                            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 3 )
                            ELSE
                                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 3 )
                                ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 3 )
                                END
                            END AS cep,

                            parcela_origem.valor AS valor_origem,
                            parcela_origem.cod_credito||'.'||parcela_origem.cod_especie||'.'||parcela_origem.cod_genero||'.'||parcela_origem.cod_natureza||' - '||credito.descricao_credito AS credito_origem,
                            parcela_origem.cod_natureza,
                            aplica_acrescimo_modalidade (
                                0,
                                dda.cod_inscricao,
                                dda.exercicio::integer,
                                dpar.cod_modalidade,
                                3,
                                dpar.num_parcelamento,
                                parcela_origem.valor,
                                dda.dt_vencimento_origem,
                                now()::date,
                                'false'
                            ) AS acrescimos_m,

                            aplica_acrescimo_modalidade (
                                0,
                                dda.cod_inscricao,
                                dda.exercicio::integer,
                                dpar.cod_modalidade,
                                2,
                                dpar.num_parcelamento,
                                parcela_origem.valor,
                                dda.dt_vencimento_origem,
                                now()::date,
                                'false'
                            ) AS acrescimos_j,

                            aplica_acrescimo_modalidade (
                                0,
                                dda.cod_inscricao,
                                dda.exercicio::integer,
                                dpar.cod_modalidade,
                                1,
                                dpar.num_parcelamento,
                                parcela_origem.valor,
                                dda.dt_vencimento_origem,
                                now()::date,
                                'false'
                            ) AS acrescimos_c,

                            (
                                SELECT
                                    sum(valor)
                                FROM
                                    divida.parcela_reducao
                                WHERE
                                    divida.parcela_reducao.num_parcelamento = ddp.num_parcelamento
                            )AS total_reducao,
                            dda.exercicio_original AS exercicio_origem,
                            (
                                SELECT
                                    (
                                        SELECT
                                            arrecadacao.fn_busca_origem_lancamento ( ap.cod_lancamento, dda.exercicio_original::integer, 1, 1 )
                                        FROM
                                            arrecadacao.parcela AS ap
                                        WHERE
                                            ap.cod_parcela = dpo.cod_parcela
                                    )
                                FROM
                                    divida.parcela_origem AS dpo
                                WHERE
                                    dpo.num_parcelamento = (
                                        SELECT
                                            divida.divida_parcelamento.num_parcelamento
                                        FROM
                                            divida.divida_parcelamento
                                        WHERE
                                            divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                            AND divida.divida_parcelamento.exercicio = dda.exercicio
                                        ORDER BY
                                            divida.divida_parcelamento.num_parcelamento ASC
                                        LIMIT 1
                                    )
                                    AND dpo.cod_parcela IN (
                                        SELECT
                                            dpo2.cod_parcela
                                        FROM
                                            divida.parcela_origem AS dpo2
                                        WHERE
                                            dpo2.num_parcelamento = ddp.num_parcelamento
                                            AND dpo2.cod_parcela = dpo.cod_parcela
                                    )
                                    LIMIT 1
                            )AS imposto,

                            sw_cgm.nom_cgm AS contribuinte,
                            sw_cgm.numcgm,

                            dpar.num_parcelamento,
                            to_char( dda.dt_inscricao, 'dd/mm/yyyy' ) AS dt_inscricao_divida

                        FROM
                            divida.divida_ativa AS dda

                        INNER JOIN
                            divida.divida_cgm AS ddc
                        ON
                            ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio


                        INNER JOIN
                            sw_cgm
                        ON
                            sw_cgm.numcgm = ddc.numcgm

                        LEFT JOIN
                            sw_cgm_pessoa_fisica
                        ON
                            sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm

                        LEFT JOIN
                            sw_cgm_pessoa_juridica
                        ON
                            sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm

                        LEFT JOIN
                            divida.divida_imovel AS ddi
                        ON
                            ddi.cod_inscricao = ddc.cod_inscricao
                            AND ddi.exercicio = ddc.exercicio

                        LEFT JOIN
                            divida.divida_empresa AS dde
                        ON
                            dde.cod_inscricao = ddc.cod_inscricao
                            AND dde.exercicio = ddc.exercicio

                        INNER JOIN
                            (
                                SELECT
                                    divida_parcelamento.cod_inscricao,
                                    divida_parcelamento.exercicio,
                                    max(divida_parcelamento.num_parcelamento) AS num_parcelamento
                                FROM
                                    divida.divida_parcelamento
                                GROUP BY
                                    divida_parcelamento.cod_inscricao,
                                    divida_parcelamento.exercicio
                            )AS ddp
                        ON
                            ddp.cod_inscricao = ddc.cod_inscricao
                            AND ddp.exercicio = ddc.exercicio

                        INNER JOIN
                            divida.parcelamento AS dpar
                        ON
                            dpar.num_parcelamento = ddp.num_parcelamento

                        INNER JOIN
                            (
                                SELECT
                                    min( divida.divida_parcelamento.num_parcelamento ) AS num_parcelamento,
                                    divida_parcelamento.cod_inscricao,
                                    divida_parcelamento.exercicio
                                FROM
                                    divida.divida_parcelamento
                                GROUP BY
                                    divida_parcelamento.cod_inscricao,
                                    divida_parcelamento.exercicio
                            )AS parcelamento_inscricao
                        ON
                            parcelamento_inscricao.cod_inscricao = ddc.cod_inscricao
                            AND parcelamento_inscricao.exercicio = ddc.exercicio

                        INNER JOIN
                            (
                                SELECT
                                    sum( dpo.valor ) as valor,
                                    dpo.cod_especie,
                                    dpo.cod_genero,
                                    dpo.cod_natureza,
                                    dpo.cod_credito,
                                    dpo.num_parcelamento,
                                    dpo2.num_parcelamento AS num_parcelamento_atual
                                FROM
                                    divida.parcela_origem AS dpo

                                INNER JOIN
                                    divida.parcela_origem AS dpo2
                                ON
                                    dpo2.cod_parcela = dpo.cod_parcela

                                GROUP BY
                                    dpo.cod_especie,
                                    dpo.cod_genero,
                                    dpo.cod_natureza,
                                    dpo.cod_credito,
                                    dpo.num_parcelamento,
                                    dpo2.num_parcelamento
                            )AS parcela_origem
                        ON
                            parcela_origem.num_parcelamento_atual = ddp.num_parcelamento
                            AND parcela_origem.num_parcelamento = parcelamento_inscricao.num_parcelamento

                        INNER JOIN
                            monetario.credito
                        ON
                            credito.cod_credito = parcela_origem.cod_credito
                            AND credito.cod_especie = parcela_origem.cod_especie
                            AND credito.cod_genero = parcela_origem.cod_genero
                            AND credito.cod_natureza = parcela_origem.cod_natureza  WHERE dpar.num_parcelamento = :numParcelamento";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('numParcelamento', $params['numParcelamento']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosAcrescimoFundamentacao(array $params = [])
    {
        if (empty($params['numParcelamento'])) {
            return [];
        }

        $query = "
            SELECT
                    norma.cod_norma||' - '||norma.nom_norma||' - '||norma.descricao AS norma,
                    norma.descricao,
                    acrescimo_norma.cod_acrescimo||'.'||acrescimo_norma.cod_tipo||' - '||acrescimo.descricao_acrescimo AS acrescimo

                FROM
                    divida.parcelamento

                INNER JOIN
                    divida.modalidade_acrescimo
                ON
                    modalidade_acrescimo.cod_modalidade = parcelamento.cod_modalidade
                    AND modalidade_acrescimo.timestamp = parcelamento.timestamp_modalidade

                INNER JOIN
                    monetario.acrescimo
                ON
                    acrescimo.cod_acrescimo = modalidade_acrescimo.cod_acrescimo
                    AND acrescimo.cod_tipo = modalidade_acrescimo.cod_tipo

                INNER JOIN
                    (
                        SELECT
                            acrescimo_norma.*

                        FROM
                            monetario.acrescimo_norma

                        INNER JOIN
                            (
                                SELECT
                                    max(timestamp) AS timestamp,
                                    cod_acrescimo,
                                    cod_tipo
                                FROM
                                    monetario.acrescimo_norma
                                GROUP BY
                                    cod_acrescimo,
                                    cod_tipo
                            )AS tmp
                        ON
                            tmp.cod_acrescimo = acrescimo_norma.cod_acrescimo
                            AND tmp.cod_tipo = acrescimo_norma.cod_tipo
                            AND tmp.timestamp = acrescimo_norma.timestamp
                    )AS acrescimo_norma
                ON
                    acrescimo_norma.cod_acrescimo = modalidade_acrescimo.cod_acrescimo
                    AND acrescimo_norma.cod_tipo = modalidade_acrescimo.cod_tipo

                INNER JOIN
                    normas.norma
                ON
                    norma.cod_norma = acrescimo_norma.cod_norma

                WHERE
                    modalidade_acrescimo.pagamento = false  AND parcelamento.num_parcelamento = :numParcelamento";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('numParcelamento', $params['numParcelamento']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param int $inDocumento
    * @return array
    */
    public function fetchDadosConfiguracaoUsuario($inDocumento)
    {
        $query = "
            SELECT
            (
                SELECT
                    '/gestaoAdministrativa/fontes/PHP/framework/temas/padrao/imagens/'||valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloAdministracao
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'logotipo'
            )AS url_logo,
            (

                SELECT
                sw_municipio.nom_municipio

                FROM
                    sw_municipio

                WHERE
                    sw_municipio.cod_municipio IN (
                        SELECT
                            valor::integer
                        FROM
                            administracao.configuracao

                        WHERE
                            cod_modulo = :codModuloAdministracao
                            AND exercicio = extract(year from now())::varchar
                            AND parametro = 'cod_municipio'
                    ) AND sw_municipio.cod_uf IN (
                        SELECT
                            valor::integer
                        FROM
                            administracao.configuracao

                        WHERE
                            cod_modulo = :codModuloAdministracao
                            AND exercicio = extract(year from now())::varchar
                            AND parametro = 'cod_uf'
                    )
            ) AS nom_municipio,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloAdministracao
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'nom_prefeitura'
            ) AS nom_prefeitura,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'secretaria_%1\$s'
            )AS nom_secretaria,

            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'chefe_departamento_%1\$s'
            )AS nom_chefe_departamento,

            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'coordenador_%1\$s'
            )AS nom_coordenador,

            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'setor_arrecadacao_%1\$s'
            )AS setor_arrecadacao,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'metodologia_calculo_%1\$s'
            )AS metodologia_calculo,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'nro_lei_inscricao_da_%1\$s'
            )AS nro_lei_inscricao_da,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'msg_doc_%1\$s'
            )AS msg_doc,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'utilmsg_doc_%1\$s'
            )AS util_msg_doc,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'utilresp2_doc_%1\$s'
            )AS util_resp2_doc,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'utilleida_doc_%1\$s'
            )AS util_leida_doc,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'utilincval_doc_%1\$s'
            )AS util_incval_doc,
            (
                SELECT
                    valor
                FROM
                    administracao.configuracao
                WHERE
                    cod_modulo = :codModuloDividaAtiva
                    AND exercicio = extract(year from now())::varchar
                    AND parametro = 'utilmetcalc_doc_%1\$s'
            )AS util_metcalc_doc";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare(sprintf($query, $inDocumento));
        $sth->bindValue('codModuloAdministracao', $this::COD_MODULO_ADMINISTRACAO);
        $sth->bindValue('codModuloDividaAtiva', $this::COD_MODULO_DIVIDA_ATIVA);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosTermoConsolidacaoDAUrbem(array $params = [])
    {
        if (empty($params['numParcelamento'])) {
            return [];
        }

        $query = "
            SELECT DISTINCT
                            tdpa.total,
                            to_char(now(), 'dd/mm/yyyy') AS dt_notificacao,
                            ddi.inscricao_municipal,

                            (
                                SELECT
                                    COALESCE( sw_cgm_pessoa_fisica.cpf, sw_cgm_pessoa_juridica.cnpj )

                                FROM
                                    sw_cgm

                                LEFT JOIN
                                    sw_cgm_pessoa_fisica
                                ON
                                    sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm

                                LEFT JOIN
                                    sw_cgm_pessoa_juridica
                                ON
                                    sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm

                                WHERE
                                    sw_cgm.numcgm = ddc.numcgm
                            )AS cpf_cnpj,

                            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                'im'
                            ELSE
                                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    'ie'
                                ELSE
                                    'cgm'
                                END
                            END AS tipo_inscricao,

                            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 1)||' '||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 3)||', '||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 4) )
                            ELSE
                                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) )
                                ELSE
                                    (
                                        SELECT
                                            sw_cgm.logradouro ||' '|| sw_cgm.numero ||' '|| sw_cgm.complemento
                                        FROM
                                            sw_cgm
                                        WHERE
                                            sw_cgm.numcgm = ddc.numcgm
                                    )
                                END
                            END AS domicilio_fiscal,

                            (
                                SELECT
                                    sw_cgm.nom_cgm
                                FROM
                                    sw_cgm
                                WHERE
                                    sw_cgm.numcgm = ddc.numcgm
                            )AS contribuinte,

                            dde.inscricao_economica,

                            dpa.num_parcela,
                            dpa.num_parcela || '/' || tdpa.total AS parcelas,
                            dpa.vlr_parcela,
                            to_char(dpa.dt_vencimento_parcela, 'dd/mm/yyyy') AS dt_vencimento,
                            to_char(dp.timestamp, 'dd/mm/yyyy') AS dt_acordo,
                            CASE WHEN paga = true THEN
                                'Paga'
                            ELSE
                                CASE WHEN ( dpa.dt_vencimento_parcela < now() ) THEN
                                    'Vencida'
                                ELSE
                                    'Sem Pagamento'
                                END
                            END AS situacao,

                            dp.numero_parcelamento ||'/'||dp.exercicio AS nr_acordo_administrativo,
                            (
                                SELECT
                                    num_documento||'/'||exercicio
                                FROM
                                    divida.emissao_documento
                                WHERE
                                    emissao_documento.num_parcelamento = dp.num_parcelamento
                                    AND emissao_documento.exercicio = dp.exercicio
                                    AND cod_tipo_documento = 4
                                ORDER BY
                                    timestamp DESC
                                LIMIT 1
                            )as notificacao_nr,
                            calculo.valor AS valor_corrigido,
                            total_multa.valor AS valor_multa,
                            total_correcao.valor AS valor_correcao,
                            total_juros.valor AS valor_juros,
                            total_reducao.valor AS valor_reducao,
                            pagamento.valor AS valor_pago,
                            pagamento.dt_pagamento
                        FROM
                            divida.divida_ativa AS dda

                        INNER JOIN
                            divida.divida_cgm AS ddc
                        ON
                            ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio

                        LEFT JOIN
                            divida.divida_imovel AS ddi
                        ON
                            ddi.cod_inscricao = dda.cod_inscricao
                            AND ddi.exercicio = dda.exercicio

                        LEFT JOIN
                            divida.divida_empresa AS dde
                        ON
                            dde.cod_inscricao = dda.cod_inscricao
                            AND dde.exercicio = dda.exercicio

                        INNER JOIN
                            divida.divida_parcelamento AS ddp
                        ON
                            ddp.cod_inscricao = dda.cod_inscricao
                            AND ddp.exercicio = dda.exercicio

                        INNER JOIN
                            divida.parcelamento AS dp
                        ON
                            dp.num_parcelamento = ddp.num_parcelamento

                        INNER JOIN
                            (
                                SELECT
                                    count(num_parcela) AS total,
                                    num_parcelamento
                                FROM
                                    divida.parcela
                                GROUP BY
                                    num_parcelamento
                            )AS tdpa
                        ON
                            tdpa.num_parcelamento = ddp.num_parcelamento

                        INNER JOIN
                            divida.parcela AS dpa
                        ON
                            dpa.num_parcelamento = ddp.num_parcelamento

                        LEFT JOIN ( SELECT parcela_calculo.num_parcelamento
                                         , parcela_calculo.num_parcela
                                         , pagamento.valor
                                         , to_char( pagamento.data_pagamento, 'dd/mm/yyyy' ) AS dt_pagamento
                                      FROM divida.parcela_calculo
                                INNER JOIN arrecadacao.lancamento_calculo
                                        ON lancamento_calculo.cod_calculo = parcela_calculo.cod_calculo
                                INNER JOIN arrecadacao.parcela
                                        ON parcela.nr_parcela = parcela_calculo.num_parcela
                                       AND parcela.cod_lancamento = lancamento_calculo.cod_lancamento
                                INNER JOIN arrecadacao.carne
                                        ON carne.cod_parcela = parcela.cod_parcela
                                INNER JOIN arrecadacao.pagamento
                                        ON pagamento.numeracao = carne.numeracao
                                  )AS pagamento
                                ON pagamento.num_parcelamento = ddp.num_parcelamento
                               AND pagamento.num_parcela = dpa.num_parcela

                        INNER JOIN ( SELECT sum(vl_credito) AS valor
                                          , num_parcelamento
                                       FROM divida.parcela_calculo
                                   GROUP BY num_parcelamento
                                   )AS calculo
                                ON calculo.num_parcelamento = ddp.num_parcelamento

                        LEFT JOIN ( SELECT sum(vlracrescimo) AS valor
                                         , num_parcelamento
                                      FROM divida.parcela_acrescimo
                                     WHERE cod_tipo = 1
                                  GROUP BY num_parcelamento
                                  )AS total_correcao
                               ON total_correcao.num_parcelamento = ddp.num_parcelamento

                        LEFT JOIN ( SELECT sum(vlracrescimo) AS valor
                                         , num_parcelamento
                                      FROM divida.parcela_acrescimo
                                     WHERE cod_tipo = 2
                                  GROUP BY num_parcelamento
                                  )AS total_juros
                               ON total_juros.num_parcelamento = ddp.num_parcelamento

                        LEFT JOIN ( SELECT sum(vlracrescimo) AS valor
                                         , num_parcelamento
                                      FROM divida.parcela_acrescimo
                                     WHERE cod_tipo = 3
                                  GROUP BY num_parcelamento
                                  )AS total_multa
                               ON total_multa.num_parcelamento = ddp.num_parcelamento

                        LEFT JOIN ( SELECT sum(valor) AS valor
                                         , num_parcelamento
                                      FROM divida.parcela_reducao
                                  GROUP BY num_parcelamento
                                  )AS total_reducao
                               ON total_reducao.num_parcelamento = ddp.num_parcelamento

                        WHERE ddp.num_parcelamento = :numParcelamento";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('numParcelamento', $params['numParcelamento']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosMemorialCalculoDAUrbem(array $params = [])
    {
        if (empty($params['numParcelamento'])) {
            return [];
        }

        $query = "
            SELECT DISTINCT
                            to_char(now(), 'dd/mm/yyyy') AS dt_notificacao,
                            dda.dt_vencimento_origem,
                            sw_cgm_pessoa_fisica.rg,
                            sw_cgm_pessoa_fisica.orgao_emissor,
                            COALESCE( sw_cgm_pessoa_fisica.cpf, sw_cgm_pessoa_juridica.cnpj ) AS cpf_cnpj,
                            dda.cod_inscricao,
                            dda.exercicio,
                            dpar.cod_modalidade,
                            ddi.inscricao_municipal,
                            dde.inscricao_economica,
                            COALESCE( ddi.inscricao_municipal, dde.inscricao_economica, ddc.numcgm) AS inscricao,
                            dda.num_livro,
                            dda.num_folha,
                            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 1 )
                            ELSE
                                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 1 )
                                ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 1 )
                                END
                            END AS endereco,

                            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 2 )
                            ELSE
                                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 2 )
                                ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 2 )
                                END
                            END AS bairro,

                            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 3 )
                            ELSE
                                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 3 )
                                ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 3 )
                                END
                            END AS cep,

                            parcela_origem.valor AS valor_origem,
                            parcela_origem.cod_credito||'.'||parcela_origem.cod_especie||'.'||parcela_origem.cod_genero||'.'||parcela_origem.cod_natureza||' - '||credito.descricao_credito AS credito_origem,
                            parcela_origem.cod_natureza,
                            aplica_acrescimo_modalidade (
                                0,
                                dda.cod_inscricao,
                                dda.exercicio::integer,
                                dpar.cod_modalidade,
                                3,
                                dpar.num_parcelamento,
                                parcela_origem.valor,
                                dda.dt_vencimento_origem,
                                now()::date,
                                'false'
                            ) AS acrescimos_m,

                            aplica_acrescimo_modalidade (
                                0,
                                dda.cod_inscricao,
                                dda.exercicio::integer,
                                dpar.cod_modalidade,
                                2,
                                dpar.num_parcelamento,
                                parcela_origem.valor,
                                dda.dt_vencimento_origem,
                                now()::date,
                                'false'
                            ) AS acrescimos_j,

                            aplica_acrescimo_modalidade (
                                0,
                                dda.cod_inscricao,
                                dda.exercicio::integer,
                                dpar.cod_modalidade,
                                1,
                                dpar.num_parcelamento,
                                parcela_origem.valor,
                                dda.dt_vencimento_origem,
                                now()::date,
                                'false'
                            ) AS acrescimos_c,

                            (
                                SELECT
                                    sum(valor)
                                FROM
                                    divida.parcela_reducao
                                WHERE
                                    divida.parcela_reducao.num_parcelamento = ddp.num_parcelamento
                            )AS total_reducao,
                            dda.exercicio_original AS exercicio_origem,
                            (
                                SELECT
                                    (
                                        SELECT
                                            arrecadacao.fn_busca_origem_lancamento ( ap.cod_lancamento, dda.exercicio_original::integer, 1, 1 )
                                        FROM
                                            arrecadacao.parcela AS ap
                                        WHERE
                                            ap.cod_parcela = dpo.cod_parcela
                                    )
                                FROM
                                    divida.parcela_origem AS dpo
                                WHERE
                                    dpo.num_parcelamento = (
                                        SELECT
                                            divida.divida_parcelamento.num_parcelamento
                                        FROM
                                            divida.divida_parcelamento
                                        WHERE
                                            divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                            AND divida.divida_parcelamento.exercicio = dda.exercicio
                                        ORDER BY
                                            divida.divida_parcelamento.num_parcelamento ASC
                                        LIMIT 1
                                    )
                                    AND dpo.cod_parcela IN (
                                        SELECT
                                            dpo2.cod_parcela
                                        FROM
                                            divida.parcela_origem AS dpo2
                                        WHERE
                                            dpo2.num_parcelamento = ddp.num_parcelamento
                                            AND dpo2.cod_parcela = dpo.cod_parcela
                                    )
                                    LIMIT 1
                            )AS imposto,

                            sw_cgm.nom_cgm AS contribuinte,
                            sw_cgm.numcgm,

                            dpar.num_parcelamento,
                            to_char( dda.dt_inscricao, 'dd/mm/yyyy' ) AS dt_inscricao_divida

                        FROM
                            divida.divida_ativa AS dda

                        INNER JOIN
                            divida.divida_cgm AS ddc
                        ON
                            ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio


                        INNER JOIN
                            sw_cgm
                        ON
                            sw_cgm.numcgm = ddc.numcgm

                        LEFT JOIN
                            sw_cgm_pessoa_fisica
                        ON
                            sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm

                        LEFT JOIN
                            sw_cgm_pessoa_juridica
                        ON
                            sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm

                        LEFT JOIN
                            divida.divida_imovel AS ddi
                        ON
                            ddi.cod_inscricao = ddc.cod_inscricao
                            AND ddi.exercicio = ddc.exercicio

                        LEFT JOIN
                            divida.divida_empresa AS dde
                        ON
                            dde.cod_inscricao = ddc.cod_inscricao
                            AND dde.exercicio = ddc.exercicio

                        INNER JOIN
                            (
                                SELECT
                                    divida_parcelamento.cod_inscricao,
                                    divida_parcelamento.exercicio,
                                    max(divida_parcelamento.num_parcelamento) AS num_parcelamento
                                FROM
                                    divida.divida_parcelamento
                                GROUP BY
                                    divida_parcelamento.cod_inscricao,
                                    divida_parcelamento.exercicio
                            )AS ddp
                        ON
                            ddp.cod_inscricao = ddc.cod_inscricao
                            AND ddp.exercicio = ddc.exercicio

                        INNER JOIN
                            divida.parcelamento AS dpar
                        ON
                            dpar.num_parcelamento = ddp.num_parcelamento

                        INNER JOIN
                            (
                                SELECT
                                    min( divida.divida_parcelamento.num_parcelamento ) AS num_parcelamento,
                                    divida_parcelamento.cod_inscricao,
                                    divida_parcelamento.exercicio
                                FROM
                                    divida.divida_parcelamento
                                GROUP BY
                                    divida_parcelamento.cod_inscricao,
                                    divida_parcelamento.exercicio
                            )AS parcelamento_inscricao
                        ON
                            parcelamento_inscricao.cod_inscricao = ddc.cod_inscricao
                            AND parcelamento_inscricao.exercicio = ddc.exercicio

                        INNER JOIN
                            (
                                SELECT
                                    sum( dpo.valor ) as valor,
                                    dpo.cod_especie,
                                    dpo.cod_genero,
                                    dpo.cod_natureza,
                                    dpo.cod_credito,
                                    dpo.num_parcelamento,
                                    dpo2.num_parcelamento AS num_parcelamento_atual
                                FROM
                                    divida.parcela_origem AS dpo

                                INNER JOIN
                                    divida.parcela_origem AS dpo2
                                ON
                                    dpo2.cod_parcela = dpo.cod_parcela

                                GROUP BY
                                    dpo.cod_especie,
                                    dpo.cod_genero,
                                    dpo.cod_natureza,
                                    dpo.cod_credito,
                                    dpo.num_parcelamento,
                                    dpo2.num_parcelamento
                            )AS parcela_origem
                        ON
                            parcela_origem.num_parcelamento_atual = ddp.num_parcelamento
                            AND parcela_origem.num_parcelamento = parcelamento_inscricao.num_parcelamento

                        INNER JOIN
                            monetario.credito
                        ON
                            credito.cod_credito = parcela_origem.cod_credito
                            AND credito.cod_especie = parcela_origem.cod_especie
                            AND credito.cod_genero = parcela_origem.cod_genero
                            AND credito.cod_natureza = parcela_origem.cod_natureza  WHERE dpar.num_parcelamento = :numParcelamento";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('numParcelamento', $params['numParcelamento']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchMemorialCalculoGenerico($codInscricao, $exercicio, $codModalidade, $inscricao, $valorOrigem, $dtOrigem, $dtAtual)
    {
        $query = "
            SELECT
                aplica_acrescimo_modalidade (
                    0,
                    :codInscricao,
                    :exercicio,
                    :codModalidade,
                    0,
                    :inscricao,
                    :valorOrigem,
                    :dtOrigem,
                    :dtAtual,
                    'false'
                ) AS acrescimos";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('codInscricao', $codInscricao);
        $sth->bindValue('exercicio', $exercicio);
        $sth->bindValue('codModalidade', $codModalidade);
        $sth->bindValue('inscricao', $inscricao);
        $sth->bindValue('valorOrigem', $valorOrigem);
        $sth->bindValue('dtOrigem', $dtOrigem);
        $sth->bindValue('dtAtual', $dtAtual);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosTermoComposicaoDAMariana(array $params = [])
    {
        if (empty($params['numParcelamento'])) {
            return [];
        }

        $query = "
            SELECT
             --  DISTINCT
             ( SELECT il.nom_localizacao
                              FROM imobiliario.lote_localizacao AS ill
                        INNER JOIN imobiliario.localizacao AS il
                                ON il.cod_localizacao = ill.cod_localizacao
                        INNER JOIN imobiliario.localizacao_nivel AS iln
                                ON il.codigo_composto = iln.valor || '.00'
                               AND iln.cod_localizacao = ill.cod_localizacao
                               AND iln.cod_nivel = 1
                             WHERE ill.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                  FROM economico.domicilio_fiscal
                                                                                                 WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                               )
                                                                                             , ddi.inscricao_municipal
                                                                                             )
                                                                                   )
                          )AS regiao
                        , ( SELECT il.nom_localizacao
                              FROM imobiliario.lote_localizacao AS ill
                        INNER JOIN imobiliario.localizacao AS il
                                ON il.cod_localizacao = ill.cod_localizacao
                             WHERE ill.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                  FROM economico.domicilio_fiscal
                                                                                                 WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                              )
                                                                                             , ddi.inscricao_municipal
                                                                                            )
                                                                                  )
                          )AS distrito
                        , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 2) )
                          ELSE
                              CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                split_part( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 2 )
                              ELSE
                                0::text
                              END
                          END AS cod_logradouro
                        , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 9)||'/'||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 11) )
                          END AS cidade_estado
                        , sw_cgm.bairro AS bairro_notificado
                        , sw_cgm.cep AS cep_notificado
                        , ( SELECT sw_municipio.nom_municipio || '/' || sw_uf.nom_uf
                              FROM sw_cgm
                        INNER JOIN sw_uf
                                ON sw_uf.cod_pais = sw_cgm.cod_pais
                               AND sw_uf.cod_uf = sw_cgm.cod_uf
                        INNER JOIN sw_municipio
                                ON sw_municipio.cod_municipio = sw_cgm.cod_municipio
                               AND sw_municipio.cod_uf = sw_cgm.cod_uf
                             WHERE sw_cgm.numcgm = ddc.numcgm
                          )AS cidade_estado_notificado
                        , sw_cgm.logradouro ||' '|| sw_cgm.numero ||' '|| sw_cgm.complemento AS endereco_notificado
                        , COALESCE
                          (
                            (SELECT cpf  FROM sw_cgm_pessoa_fisica   WHERE sw_cgm_pessoa_fisica.numcgm   = sw_cgm.numcgm),
                            (SELECT cnpj FROM sw_cgm_pessoa_juridica WHERE sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm)
                          ) AS cpf_cnpj_notificado
                        , ( SELECT COALESCE( ( SELECT valor
                                                 FROM imobiliario.atributo_lote_urbano_valor as ialu
                                                WHERE ialu.cod_atributo = 5
                                                  AND ialu.cod_lote = il.cod_lote
                                             ORDER BY ialu.timestamp DESC
                                                limit 1
                                             )
                                           , ( SELECT valor
                                                 FROM imobiliario.atributo_lote_rural_valor as ialr
                                                WHERE ialr.cod_atributo = 5
                                                  AND ialr.cod_lote = il.cod_lote
                                             ORDER BY ialr.timestamp DESC
                                                limit 1
                                             )
                                           )

                              FROM imobiliario.lote as il
                             WHERE il.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                 FROM economico.domicilio_fiscal
                                                                                                WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                             )
                                                                                            , ddi.inscricao_municipal
                                                                                           )
                                                                                 )
                          ) AS numero_quadra
                        , ( SELECT COALESCE( ( SELECT valor
                                                 FROM imobiliario.atributo_lote_urbano_valor as ialu
                                                WHERE ialu.cod_atributo = 7
                                                  AND ialu.cod_lote = il.cod_lote
                                             ORDER BY ialu.timestamp DESC
                                                limit 1
                                             )
                                           , ( SELECT valor
                                                 FROM imobiliario.atributo_lote_rural_valor as ialr
                                                WHERE ialr.cod_atributo = 7
                                                  AND ialr.cod_lote = il.cod_lote
                                             ORDER BY ialr.timestamp DESC
                                                limit 1
                                             )
                                           )
                              FROM imobiliario.lote as il
                             WHERE il.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                 FROM economico.domicilio_fiscal
                                                                                                WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                             )
                                                                                           , ddi.inscricao_municipal
                                                                                           )
                                                                                 )
                          ) AS numero_lote
                        , to_char(dda.dt_vencimento_origem, 'dd/mm/yyyy') AS dt_vencimento_origem
                        , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            'im'
                          ELSE
                            CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                              'ie'
                            ELSE
                              'cgm'
                            END
                          END AS tipo_inscricao
                        , ddi.inscricao_municipal
                        , dde.inscricao_economica
                        , dda.num_livro
                        , dda.num_folha
                        , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica, ddc.numcgm) AS inscricao

                        , ( SELECT sum(dpo.valor)
                                FROM divida.parcela_origem AS dpo
                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                FROM divida.divida_parcelamento
                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                               LIMIT 1
                                                            )
                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                            FROM divida.parcela_origem AS dpo2
                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                        )
                            )AS valor_origem
             -- , origem.valor AS valor_origem

                        , split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 1
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                            FROM divida.parcela_origem AS dpo
                                                                           WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                            FROM divida.divida_parcelamento
                                                                                                           WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                             AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                        ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                           LIMIT 1
                                                                                                        )
                                                                             AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                        FROM divida.parcela_origem AS dpo2
                                                                                                       WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                         AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                    )
                                                                        ),
                                                                      0.00
                                                                 )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 1 ) AS correcao

                        , split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 2
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                              ),
                                                                           0.00
                                                                  )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 1 ) AS juros


                        ,COALESCE(NULLIF(split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 3
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                             ),
                                                                           0.00
                                                                  )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 5),''),'0.00')::numeric AS multa_infracao


                        ,COALESCE(NULLIF(split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 3
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                            ), 0.00
                                                                )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 2 ),''),'0.00')::numeric AS multa

                                    ,aplica_reducao_modalidade_acrescimo(
                                                                  dpar.cod_modalidade
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE(NULLIF(split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 2
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                              ),
                                                                           0.00
                                                                  )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 1 ),''),'0.00')::numeric
                                                                , 2
                                                                , 2
                                                                , dda.dt_vencimento_origem
                                                                , 1
                                                                 )  AS reducao_juros

                                        ,aplica_reducao_modalidade_acrescimo(
                                                                  dpar.cod_modalidade
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE(NULLIF(split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 3
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                             ),
                                                                           0.00
                                                                  )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    ,2),''),'0.00')::numeric
                                                                , 3
                                                                , 3
                                                                , dda.dt_vencimento_origem
                                                                , 1
                                                                 ) AS reducao_multa




                        , dda.exercicio_original AS exercicio_origem
                        , sw_cgm.nom_cgm AS nome_notificado
                        , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 1)||' '||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 3)||', '||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 4) )
                          ELSE
                            CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                              ( select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 1 ))||' '||(select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 3 ))||', '||(select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 4 ))
                            ELSE
                              sw_cgm.logradouro ||' '|| sw_cgm.numero ||' '|| sw_cgm.complemento
                            END
                          END AS domicilio_fiscal
                        , dpar.num_parcelamento
                        , origem.descricao_credito

                     FROM divida.divida_ativa AS dda

               INNER JOIN divida.divida_cgm AS ddc
                       ON ddc.cod_inscricao = dda.cod_inscricao
                      AND ddc.exercicio = dda.exercicio

               INNER JOIN sw_cgm
                       ON sw_cgm.numcgm = ddc.numcgm

                LEFT JOIN divida.divida_imovel AS ddi
                       ON ddi.cod_inscricao = ddc.cod_inscricao
                      AND ddi.exercicio = ddc.exercicio

                LEFT JOIN divida.divida_empresa AS dde
                       ON dde.cod_inscricao = ddc.cod_inscricao
                      AND dde.exercicio = ddc.exercicio

               INNER JOIN ( SELECT divida_parcelamento.cod_inscricao
                                 , divida_parcelamento.exercicio
                                 , max(divida_parcelamento.num_parcelamento) AS num_parcelamento
                              FROM divida.divida_parcelamento
                              WHERE NOT EXISTS ( SELECT 1
                                                  FROM divida.parcelamento_cancelamento
                                                 WHERE parcelamento_cancelamento.num_parcelamento = divida_parcelamento.num_parcelamento )
                          GROUP BY divida_parcelamento.cod_inscricao
                                 , divida_parcelamento.exercicio
                          )AS ddp
                       ON ddp.cod_inscricao = dda.cod_inscricao
                      AND ddp.exercicio = dda.exercicio

               INNER JOIN divida.parcelamento AS dpar
                       ON dpar.num_parcelamento = ddp.num_parcelamento

                LEFT JOIN divida.parcela AS dparc
                       ON dpar.num_parcelamento = dparc.num_parcelamento
                      AND dparc.num_parcela = 1


               INNER JOIN (
                                   SELECT parcela_origem.valor
                    --   , parcela_origem.cod_parcela
                         , parcela_origem.num_parcelamento
                         , credito.descricao_credito
                         , divida_parcelamento.exercicio
                         , divida_parcelamento.cod_inscricao
                      FROM divida.parcela_origem
                INNER JOIN divida.divida_parcelamento
                        ON divida_parcelamento.num_parcelamento = parcela_origem.num_parcelamento
                INNER JOIN (   SELECT MIN(num_parcelamento) AS num_parcelamento
                                    , cod_inscricao
                                    , exercicio
                                 FROM divida.divida_parcelamento
                             GROUP BY cod_inscricao
                                      , exercicio
                           ) AS minimo
                        ON minimo.cod_inscricao = divida_parcelamento.cod_inscricao
                       AND minimo.exercicio     = divida_parcelamento.exercicio
                INNER JOIN (   SELECT MIN(cod_parcela) AS cod_parcela
                                    , cod_credito
                                    , cod_especie
                                    , cod_genero
                                    , cod_natureza
                                    , num_parcelamento
                                FROM divida.parcela_origem AS p1
                WHERE p1.num_parcelamento  = :numParcelamento
                GROUP BY cod_credito
                                    , cod_especie
                                    , cod_genero
                                    , cod_natureza
                                    , num_parcelamento
                           ) AS origem
                        ON origem.cod_parcela      = parcela_origem.cod_parcela
                       AND origem.cod_credito      = parcela_origem.cod_credito
                       AND origem.cod_especie      = parcela_origem.cod_especie
                       AND origem.cod_genero       = parcela_origem.cod_genero
                       AND origem.cod_natureza     = parcela_origem.cod_natureza
                       AND origem.num_parcelamento = minimo.num_parcelamento
                INNER JOIN monetario.credito
                        ON credito.cod_credito  = parcela_origem.cod_credito
                       AND credito.cod_especie  = parcela_origem.cod_especie
                       AND credito.cod_genero   = parcela_origem.cod_genero
                       AND credito.cod_natureza = parcela_origem.cod_natureza

                     WHERE parcela_origem.cod_parcela      = origem.cod_parcela
            ) AS origem
            ON origem.num_parcelamento = ddp.num_parcelamento
            AND origem.exercicio = dda.exercicio
            AND origem.cod_inscricao = dda.cod_inscricao
            ORDER BY dda.exercicio_original DESC, origem.descricao_credito ASC";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('numParcelamento', $params['numParcelamento']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosCertidaoDivida(array $params = [])
    {
        if (empty($params['numParcelamento']) || empty($params['numDocumento'])) {
            return [];
        }

        $query = "
            SELECT DISTINCT ( SELECT procurador.oab
                                           FROM divida.autoridade
                                     INNER JOIN divida.procurador
                                             ON procurador.cod_autoridade = autoridade.cod_autoridade
                                          WHERE autoridade.cod_autoridade = dda.cod_autoridade
                                       )AS oab
                            , ( SELECT ( SELECT nom_cgm
                                           FROM sw_cgm
                                          WHERE sw_cgm.numcgm = autoridade.numcgm
                                       )
                                  FROM divida.autoridade
                            INNER JOIN divida.procurador
                                    ON procurador.cod_autoridade = autoridade.cod_autoridade
                                 WHERE autoridade.cod_autoridade = dda.cod_autoridade
                              )AS procurador
                            , to_char(now(), 'dd/mm/yyyy') AS dt_notificacao
                            , ( SELECT COALESCE( sw_cgm_pessoa_fisica.cpf, sw_cgm_pessoa_juridica.cnpj )
                                  FROM sw_cgm
                             LEFT JOIN sw_cgm_pessoa_fisica
                                    ON sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm
                             LEFT JOIN sw_cgm_pessoa_juridica
                                    ON sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm
                                 WHERE sw_cgm.numcgm = ddc.numcgm
                              )AS cpf_cnpj
                            , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                 'im'
                              ELSE
                                 CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    'ie'
                                 ELSE
                                    'cgm'
                                 END
                              END AS tipo_inscricao
                            , ddi.inscricao_municipal
                            , dde.inscricao_economica
                            , dda.cod_inscricao
                            , dda.exercicio
                            , dda.num_livro
                            , dda.num_folha
                            , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica, ddc.numcgm) AS inscricao
                            , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                 arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 1 )
                              ELSE
                                 CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 1 )
                                 ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 1 )
                                 END
                              END AS endereco
                            , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                 arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 2 )
                              ELSE
                                 CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 2 )
                                 ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 2 )
                                 END
                              END AS bairro
                            , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                 arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 3 )
                              ELSE
                                 CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 3 )
                                 ELSE
                                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 3 )
                                 END
                              END AS cep
                            , ( SELECT sum(dpo.valor)
                                  FROM divida.parcela_origem AS dpo
                                 WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                  FROM divida.divida_parcelamento
                                                                 WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                   AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                              ORDER BY divida.divida_parcelamento.num_parcelamento DESC
                                                                 LIMIT 1
                                                              )
                                   AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                              FROM divida.parcela_origem AS dpo2
                                                             WHERE dpo2.num_parcelamento = (select min(num_parcelamento) from divida.divida_parcelamento where cod_inscricao = ddp.cod_inscricao and exercicio = ddp.exercicio)
                                                              AND dpo2.cod_parcela   = dpo.cod_parcela
                                                              AND dpo2.cod_especie  = dpo.cod_especie
                                                              AND dpo2.cod_genero   = dpo.cod_genero
                                                              AND dpo2.cod_natureza = dpo.cod_natureza
                                                              AND dpo2.cod_credito  = dpo.cod_credito
                                                          )
                              )AS valor_origem
                            , (SELECT CASE WHEN tabela.split_part = '' THEN '0.00' ELSE tabela.split_part END AS multa FROM (SELECT split_part (
                                  aplica_acrescimo_modalidade( 0,
                                      dda.cod_inscricao,
                                      dda.exercicio::integer,
                                      dpar.cod_modalidade,
                                      3,
                                      dpar.num_parcelamento,
                                      COALESCE( ( SELECT sum(dpo.valor)
                                                      FROM divida.parcela_origem AS dpo
                                                     WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                      FROM divida.divida_parcelamento
                                                                                     WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                       AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                  ORDER BY divida.divida_parcelamento.num_parcelamento DESC
                                                                                     LIMIT 1
                                                                                  )
                                                       AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                  FROM divida.parcela_origem AS dpo2
                                                                                 WHERE dpo2.num_parcelamento = (select min(num_parcelamento) from divida.divida_parcelamento where cod_inscricao = ddp.cod_inscricao and exercicio = ddp.exercicio)
                                                                                   AND dpo2.cod_parcela   = dpo.cod_parcela
                                                                                   AND dpo2.cod_especie  = dpo.cod_especie
                                                                                   AND dpo2.cod_genero   = dpo.cod_genero
                                                                                   AND dpo2.cod_natureza = dpo.cod_natureza
                                                                                   AND dpo2.cod_credito  = dpo.cod_credito
                                                                              )
                                                ), 0.00
                                      ),
                                      dda.dt_vencimento_origem,
                                      CASE WHEN (parcela.dt_vencimento_parcela IS NULL) THEN
                                              dda.dt_inscricao
                                           ELSE
                                              parcela.dt_vencimento_parcela
                                           END ,
                                      'false'
                                  ),
                                ';',
                                2
                              )) AS tabela ) AS multa

                            , (SELECT CASE WHEN tabela.split_part = '' THEN '0.00' ELSE tabela.split_part END AS multa FROM (SELECT split_part (
                                  aplica_acrescimo_modalidade( 0,
                                      dda.cod_inscricao,
                                      dda.exercicio::integer,
                                      dpar.cod_modalidade,
                                      3,
                                      dpar.num_parcelamento,
                                      COALESCE( ( SELECT sum(dpo.valor)
                                                  FROM divida.parcela_origem AS dpo
                                                 WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                  FROM divida.divida_parcelamento
                                                                                 WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                   AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                              ORDER BY divida.divida_parcelamento.num_parcelamento DESC
                                                                                 LIMIT 1
                                                                              )
                                                   AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                              FROM divida.parcela_origem AS dpo2
                                                                             WHERE dpo2.num_parcelamento = (select min(num_parcelamento) from divida.divida_parcelamento where cod_inscricao = ddp.cod_inscricao and exercicio = ddp.exercicio)
                                                                                   AND dpo2.cod_parcela   = dpo.cod_parcela
                                                                                   AND dpo2.cod_especie  = dpo.cod_especie
                                                                                   AND dpo2.cod_genero   = dpo.cod_genero
                                                                                   AND dpo2.cod_natureza = dpo.cod_natureza
                                                                                   AND dpo2.cod_credito  = dpo.cod_credito
                                                                          )
                                                 ),
                                               0.00
                                      ),
                                      dda.dt_vencimento_origem,
                                      CASE WHEN (parcela.dt_vencimento_parcela IS NULL) THEN
                                              dda.dt_inscricao
                                           ELSE
                                              parcela.dt_vencimento_parcela
                                           END ,
                                      'false'
                                  ),
                                ';',
                                5
                              )) AS tabela ) AS multa_infracao

                            , split_part(
                                  aplica_acrescimo_modalidade( 0,
                                      dda.cod_inscricao,
                                      dda.exercicio::integer,
                                      dpar.cod_modalidade,
                                      2,
                                      dpar.num_parcelamento,
                                      COALESCE( ( SELECT sum(dpo.valor)
                                                  FROM divida.parcela_origem AS dpo
                                                 WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                  FROM divida.divida_parcelamento
                                                                                 WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                   AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                              ORDER BY divida.divida_parcelamento.num_parcelamento DESC
                                                                                 LIMIT 1
                                                                              )
                                                   AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                              FROM divida.parcela_origem AS dpo2
                                                                             WHERE dpo2.num_parcelamento = (select min(num_parcelamento) from divida.divida_parcelamento where cod_inscricao = ddp.cod_inscricao and exercicio = ddp.exercicio)
                                                                                   AND dpo2.cod_parcela   = dpo.cod_parcela
                                                                                   AND dpo2.cod_especie  = dpo.cod_especie
                                                                                   AND dpo2.cod_genero   = dpo.cod_genero
                                                                                   AND dpo2.cod_natureza = dpo.cod_natureza
                                                                                   AND dpo2.cod_credito  = dpo.cod_credito
                                                                          )
                                                  ),
                                               0.00
                                      ),
                                      dda.dt_vencimento_origem,
                                      CASE WHEN (parcela.dt_vencimento_parcela IS NULL) THEN
                                              dda.dt_inscricao
                                           ELSE
                                              parcela.dt_vencimento_parcela
                                           END ,
                                      'false'
                                  ),
                                  ';',
                                  1
                              ) AS juros
                            , split_part(
                                  aplica_acrescimo_modalidade( 0,
                                      dda.cod_inscricao,
                                      dda.exercicio::integer,
                                      dpar.cod_modalidade,
                                      1,
                                      dpar.num_parcelamento,
                                      COALESCE( ( SELECT sum(dpo.valor)
                                                  FROM divida.parcela_origem AS dpo
                                                 WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                  FROM divida.divida_parcelamento
                                                                                 WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                   AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                              ORDER BY divida.divida_parcelamento.num_parcelamento DESC
                                                                                 LIMIT 1
                                                                              )
                                                   AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                              FROM divida.parcela_origem AS dpo2
                                                                             WHERE dpo2.num_parcelamento = (select min(num_parcelamento) from divida.divida_parcelamento where cod_inscricao = ddp.cod_inscricao and exercicio = ddp.exercicio)
                                                                                   AND dpo2.cod_parcela   = dpo.cod_parcela
                                                                                   AND dpo2.cod_especie  = dpo.cod_especie
                                                                                   AND dpo2.cod_genero   = dpo.cod_genero
                                                                                   AND dpo2.cod_natureza = dpo.cod_natureza
                                                                                   AND dpo2.cod_credito  = dpo.cod_credito
                                                                          )
                                                ),
                                              0.00
                                      ),
                                      dda.dt_vencimento_origem,
                                      CASE WHEN (parcela.dt_vencimento_parcela IS NULL) THEN
                                              dda.dt_inscricao
                                           ELSE
                                              parcela.dt_vencimento_parcela
                                           END ,
                                      'false'
                                  ),
                                  ';',
                                  1
                              ) AS correcao

                            , ( SELECT sum(valor)
                                  FROM divida.parcela_reducao
                                 WHERE divida.parcela_reducao.num_parcelamento = ddp.num_parcelamento
                              )AS total_reducao

                            , dda.exercicio_original AS exercicio_origem
                            , arrecadacao.fn_busca_origem_inscricao_divida_ativa( dda.cod_inscricao, dda.exercicio::integer, 4 ) AS imposto
                            , ( SELECT nom_cgm
                                  FROM sw_cgm
                                 WHERE sw_cgm.numcgm = ddc.numcgm
                              )AS contribuinte
                            , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                              ( SELECT COALESCE( ( SELECT valor
                                                     FROM imobiliario.atributo_lote_urbano_valor as ialu
                                                    WHERE ialu.cod_atributo = 5
                                                      AND ialu.cod_lote = il.cod_lote
                                                 ORDER BY ialu.timestamp DESC
                                                    limit 1
                                                 )
                                               , ( SELECT valor
                                                     FROM imobiliario.atributo_lote_rural_valor as ialr
                                                    WHERE ialr.cod_atributo = 5
                                                      AND ialr.cod_lote = il.cod_lote
                                                 ORDER BY ialr.timestamp DESC
                                                    limit 1
                                                 )
                                               )
                                  FROM imobiliario.lote as il
                                 WHERE il.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                     FROM economico.domicilio_fiscal
                                                                                                    WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                                 ),
                                                                                                 ddi.inscricao_municipal
                                                                                       )
                                                                                     )
                              ) END AS numero_quadra
                              , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                  ( SELECT COALESCE( ( SELECT valor
                                                     FROM imobiliario.atributo_lote_urbano_valor as ialu
                                                    WHERE ialu.cod_atributo = 7
                                                      AND ialu.cod_lote = il.cod_lote
                                                 ORDER BY ialu.timestamp DESC
                                                    limit 1
                                                 ), ( SELECT valor
                                                        FROM imobiliario.atributo_lote_rural_valor as ialr
                                                       WHERE ialr.cod_atributo = 7
                                                         AND ialr.cod_lote = il.cod_lote
                                                    ORDER BY ialr.timestamp DESC
                                                       limit 1
                                                 )
                                      )
                                  FROM imobiliario.lote as il
                                 WHERE il.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                     FROM economico.domicilio_fiscal
                                                                                                    WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                                 ),
                                                                                                 ddi.inscricao_municipal
                                                                                       )
                                                                                     )
                              ) END AS numero_lote
                            , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                                  ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 1)||' '||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 3)||', '||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 4) )
                              ELSE
                                 CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                     ( select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 1 ))||' '||(select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 3 ))||', '||(select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 4 ))
                                 ELSE
                                     ( SELECT sw_cgm.logradouro ||' '|| sw_cgm.numero ||' '|| sw_cgm.complemento
                                         FROM sw_cgm
                                        WHERE sw_cgm.numcgm = ddc.numcgm
                                     )
                                 END
                              END AS domicilio_fiscal
                            , dpar.num_parcelamento
                            , to_char( dda.dt_inscricao, 'dd/mm/yyyy' ) AS dt_inscricao_divida
                            , :numDocumento AS num_documento
                         FROM divida.divida_ativa AS dda
                   INNER JOIN divida.divida_cgm AS ddc
                           ON ddc.cod_inscricao = dda.cod_inscricao
                          AND ddc.exercicio = dda.exercicio
                    LEFT JOIN divida.divida_imovel AS ddi
                           ON ddi.cod_inscricao = ddc.cod_inscricao
                          AND ddi.exercicio = ddc.exercicio
                    LEFT JOIN divida.divida_empresa AS dde
                           ON dde.cod_inscricao = ddc.cod_inscricao
                          AND dde.exercicio = ddc.exercicio
                   INNER JOIN ( SELECT divida_parcelamento.cod_inscricao
                                     , divida_parcelamento.exercicio
                                     , max(divida_parcelamento.num_parcelamento) AS num_parcelamento
                                  FROM divida.divida_parcelamento
                 LEFT JOIN divida.parcelamento_cancelamento
                    ON divida_parcelamento.num_parcelamento = parcelamento_cancelamento.num_parcelamento
                     WHERE parcelamento_cancelamento.num_parcelamento IS NULL
                              GROUP BY divida_parcelamento.cod_inscricao
                                     , divida_parcelamento.exercicio
                              )AS ddp
                           ON ddp.cod_inscricao = ddc.cod_inscricao
                          AND ddp.exercicio = ddc.exercicio
                   INNER JOIN divida.parcelamento AS dpar
                           ON dpar.num_parcelamento = ddp.num_parcelamento
                   LEFT JOIN divida.parcela
                           ON parcela.num_parcelamento = dpar.num_parcelamento
                          AND parcela.num_parcela      = 1

   WHERE ddp.num_parcelamento = :numParcelamento";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('numParcelamento', $params['numParcelamento']);
        $sth->bindValue('numDocumento', $params['numDocumento']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosNotificacaoDivida(array $params = [])
    {
        if (empty($params['numParcelamento'])) {
            return [];
        }

        $query = "
            SELECT
             --  DISTINCT
             ( SELECT il.nom_localizacao
                              FROM imobiliario.lote_localizacao AS ill
                        INNER JOIN imobiliario.localizacao AS il
                                ON il.cod_localizacao = ill.cod_localizacao
                        INNER JOIN imobiliario.localizacao_nivel AS iln
                                ON il.codigo_composto = iln.valor || '.00'
                               AND iln.cod_localizacao = ill.cod_localizacao
                               AND iln.cod_nivel = 1
                             WHERE ill.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                  FROM economico.domicilio_fiscal
                                                                                                 WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                               )
                                                                                             , ddi.inscricao_municipal
                                                                                             )
                                                                                   )
                          )AS regiao
                        , ( SELECT il.nom_localizacao
                              FROM imobiliario.lote_localizacao AS ill
                        INNER JOIN imobiliario.localizacao AS il
                                ON il.cod_localizacao = ill.cod_localizacao
                             WHERE ill.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                  FROM economico.domicilio_fiscal
                                                                                                 WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                              )
                                                                                             , ddi.inscricao_municipal
                                                                                            )
                                                                                  )
                          )AS distrito
                        , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 2) )
                          ELSE
                              CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                                split_part( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 2 )
                              ELSE
                                0::text
                              END
                          END AS cod_logradouro
                        , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 9)||'/'||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 11) )
                          END AS cidade_estado
                        , sw_cgm.bairro AS bairro_notificado
                        , sw_cgm.cep AS cep_notificado
                        , ( SELECT sw_municipio.nom_municipio || '/' || sw_uf.nom_uf
                              FROM sw_cgm
                        INNER JOIN sw_uf
                                ON sw_uf.cod_pais = sw_cgm.cod_pais
                               AND sw_uf.cod_uf = sw_cgm.cod_uf
                        INNER JOIN sw_municipio
                                ON sw_municipio.cod_municipio = sw_cgm.cod_municipio
                               AND sw_municipio.cod_uf = sw_cgm.cod_uf
                             WHERE sw_cgm.numcgm = ddc.numcgm
                          )AS cidade_estado_notificado
                        , sw_cgm.logradouro ||' '|| sw_cgm.numero ||' '|| sw_cgm.complemento AS endereco_notificado
                        , COALESCE
                          (
                            (SELECT cpf  FROM sw_cgm_pessoa_fisica   WHERE sw_cgm_pessoa_fisica.numcgm   = sw_cgm.numcgm),
                            (SELECT cnpj FROM sw_cgm_pessoa_juridica WHERE sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm)
                          ) AS cpf_cnpj_notificado
                        , ( SELECT COALESCE( ( SELECT valor
                                                 FROM imobiliario.atributo_lote_urbano_valor as ialu
                                                WHERE ialu.cod_atributo = 5
                                                  AND ialu.cod_lote = il.cod_lote
                                             ORDER BY ialu.timestamp DESC
                                                limit 1
                                             )
                                           , ( SELECT valor
                                                 FROM imobiliario.atributo_lote_rural_valor as ialr
                                                WHERE ialr.cod_atributo = 5
                                                  AND ialr.cod_lote = il.cod_lote
                                             ORDER BY ialr.timestamp DESC
                                                limit 1
                                             )
                                           )

                              FROM imobiliario.lote as il
                             WHERE il.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                 FROM economico.domicilio_fiscal
                                                                                                WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                             )
                                                                                            , ddi.inscricao_municipal
                                                                                           )
                                                                                 )
                          ) AS numero_quadra
                        , ( SELECT COALESCE( ( SELECT valor
                                                 FROM imobiliario.atributo_lote_urbano_valor as ialu
                                                WHERE ialu.cod_atributo = 7
                                                  AND ialu.cod_lote = il.cod_lote
                                             ORDER BY ialu.timestamp DESC
                                                limit 1
                                             )
                                           , ( SELECT valor
                                                 FROM imobiliario.atributo_lote_rural_valor as ialr
                                                WHERE ialr.cod_atributo = 7
                                                  AND ialr.cod_lote = il.cod_lote
                                             ORDER BY ialr.timestamp DESC
                                                limit 1
                                             )
                                           )
                              FROM imobiliario.lote as il
                             WHERE il.cod_lote = imobiliario.fn_busca_lote_imovel( COALESCE( ( SELECT domicilio_fiscal.inscricao_municipal
                                                                                                 FROM economico.domicilio_fiscal
                                                                                                WHERE domicilio_fiscal.inscricao_economica = dde.inscricao_economica
                                                                                             )
                                                                                           , ddi.inscricao_municipal
                                                                                           )
                                                                                 )
                          ) AS numero_lote
                        , to_char(dda.dt_vencimento_origem, 'dd/mm/yyyy') AS dt_vencimento_origem
                        , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            'im'
                          ELSE
                            CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                              'ie'
                            ELSE
                              'cgm'
                            END
                          END AS tipo_inscricao
                        , ddi.inscricao_municipal
                        , dde.inscricao_economica
                        , dda.num_livro
                        , dda.num_folha
                        , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica, ddc.numcgm) AS inscricao

                        , ( SELECT sum(dpo.valor)
                                FROM divida.parcela_origem AS dpo
                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                FROM divida.divida_parcelamento
                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                               LIMIT 1
                                                            )
                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                            FROM divida.parcela_origem AS dpo2
                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                        )
                            )AS valor_origem
             -- , origem.valor AS valor_origem

                        , split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 1
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                            FROM divida.parcela_origem AS dpo
                                                                           WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                            FROM divida.divida_parcelamento
                                                                                                           WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                             AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                        ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                           LIMIT 1
                                                                                                        )
                                                                             AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                        FROM divida.parcela_origem AS dpo2
                                                                                                       WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                         AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                    )
                                                                        ),
                                                                      0.00
                                                                 )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 1 ) AS correcao

                        , split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 2
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                              ),
                                                                           0.00
                                                                  )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 1 ) AS juros


                        ,COALESCE(NULLIF(split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 3
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                             ),
                                                                           0.00
                                                                  )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 5),''),'0.00')::numeric AS multa_infracao


                        ,COALESCE(NULLIF(split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 3
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                            ), 0.00
                                                                )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 2 ),''),'0.00')::numeric AS multa

                                    ,aplica_reducao_modalidade_acrescimo(
                                                                  dpar.cod_modalidade
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE(NULLIF(split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 2
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                              ),
                                                                           0.00
                                                                  )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    , 1 ),''),'0.00')::numeric
                                                                , 2
                                                                , 2
                                                                , dda.dt_vencimento_origem
                                                                , 1
                                                                 )  AS reducao_juros

                                        ,aplica_reducao_modalidade_acrescimo(
                                                                  dpar.cod_modalidade
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE(NULLIF(split_part( aplica_acrescimo_modalidade( CASE WHEN dpar.judicial = FALSE THEN 0 ELSE 1 END
                                                                 , dda.cod_inscricao
                                                                 , dda.exercicio::integer
                                                                 , dpar.cod_modalidade
                                                                 , 3
                                                                 , dpar.num_parcelamento
                                                                 , COALESCE( ( SELECT sum(dpo.valor)
                                                                                FROM divida.parcela_origem AS dpo
                                                                               WHERE dpo.num_parcelamento = ( SELECT divida.divida_parcelamento.num_parcelamento
                                                                                                                FROM divida.divida_parcelamento
                                                                                                               WHERE divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                                                                                                                 AND divida.divida_parcelamento.exercicio = dda.exercicio
                                                                                                            ORDER BY divida.divida_parcelamento.num_parcelamento ASC
                                                                                                               LIMIT 1
                                                                                                            )
                                                                                 AND dpo.cod_parcela IN ( SELECT dpo2.cod_parcela
                                                                                                            FROM divida.parcela_origem AS dpo2
                                                                                                           WHERE dpo2.num_parcelamento = ddp.num_parcelamento
                                                                                                             AND dpo2.cod_parcela = dpo.cod_parcela
                                                                                                        )
                                                                             ),
                                                                           0.00
                                                                  )
                                                                 , dda.dt_vencimento_origem
                                                                 , COALESCE(dparc.dt_vencimento_parcela,NOW()::DATE)
                                                                 , 'false' )
                                    , ';'
                                    ,2),''),'0.00')::numeric
                                                                , 3
                                                                , 3
                                                                , dda.dt_vencimento_origem
                                                                , 1
                                                                 ) AS reducao_multa




                        , dda.exercicio_original AS exercicio_origem
                        , sw_cgm.nom_cgm AS nome_notificado
                        , CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                            ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 1)||' '||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 3)||', '||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), '§', 4) )
                          ELSE
                            CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                              ( select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 1 ))||' '||(select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 3 ))||', '||(select split_part ( COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) ), '§', 4 ))
                            ELSE
                              sw_cgm.logradouro ||' '|| sw_cgm.numero ||' '|| sw_cgm.complemento
                            END
                          END AS domicilio_fiscal
                        , dpar.num_parcelamento
                        , origem.descricao_credito
                        , origem.cod_inscricao

                     FROM divida.divida_ativa AS dda

               INNER JOIN divida.divida_cgm AS ddc
                       ON ddc.cod_inscricao = dda.cod_inscricao
                      AND ddc.exercicio = dda.exercicio

               INNER JOIN sw_cgm
                       ON sw_cgm.numcgm = ddc.numcgm

                LEFT JOIN divida.divida_imovel AS ddi
                       ON ddi.cod_inscricao = ddc.cod_inscricao
                      AND ddi.exercicio = ddc.exercicio

                LEFT JOIN divida.divida_empresa AS dde
                       ON dde.cod_inscricao = ddc.cod_inscricao
                      AND dde.exercicio = ddc.exercicio

               INNER JOIN ( SELECT divida_parcelamento.cod_inscricao
                                 , divida_parcelamento.exercicio
                                 , max(divida_parcelamento.num_parcelamento) AS num_parcelamento
                              FROM divida.divida_parcelamento
                              WHERE NOT EXISTS ( SELECT 1
                                                  FROM divida.parcelamento_cancelamento
                                                 WHERE parcelamento_cancelamento.num_parcelamento = divida_parcelamento.num_parcelamento )
                          GROUP BY divida_parcelamento.cod_inscricao
                                 , divida_parcelamento.exercicio
                          )AS ddp
                       ON ddp.cod_inscricao = dda.cod_inscricao
                      AND ddp.exercicio = dda.exercicio

               INNER JOIN divida.parcelamento AS dpar
                       ON dpar.num_parcelamento = ddp.num_parcelamento

                LEFT JOIN divida.parcela AS dparc
                       ON dpar.num_parcelamento = dparc.num_parcelamento
                      AND dparc.num_parcela = 1


               INNER JOIN (
                                   SELECT parcela_origem.valor
                    --   , parcela_origem.cod_parcela
                         , parcela_origem.num_parcelamento
                         , credito.descricao_credito
                         , divida_parcelamento.exercicio
                         , divida_parcelamento.cod_inscricao
                      FROM divida.parcela_origem
                INNER JOIN divida.divida_parcelamento
                        ON divida_parcelamento.num_parcelamento = parcela_origem.num_parcelamento
                INNER JOIN (   SELECT MIN(num_parcelamento) AS num_parcelamento
                                    , cod_inscricao
                                    , exercicio
                                 FROM divida.divida_parcelamento
                             GROUP BY cod_inscricao
                                      , exercicio
                           ) AS minimo
                        ON minimo.cod_inscricao = divida_parcelamento.cod_inscricao
                       AND minimo.exercicio     = divida_parcelamento.exercicio
                INNER JOIN (   SELECT MIN(cod_parcela) AS cod_parcela
                                    , cod_credito
                                    , cod_especie
                                    , cod_genero
                                    , cod_natureza
                                    , num_parcelamento
                                FROM divida.parcela_origem AS p1
                WHERE p1.num_parcelamento = :numParcelamento
                GROUP BY cod_credito
                                    , cod_especie
                                    , cod_genero
                                    , cod_natureza
                                    , num_parcelamento
                           ) AS origem
                        ON origem.cod_parcela      = parcela_origem.cod_parcela
                       AND origem.cod_credito      = parcela_origem.cod_credito
                       AND origem.cod_especie      = parcela_origem.cod_especie
                       AND origem.cod_genero       = parcela_origem.cod_genero
                       AND origem.cod_natureza     = parcela_origem.cod_natureza
                       AND origem.num_parcelamento = minimo.num_parcelamento
                INNER JOIN monetario.credito
                        ON credito.cod_credito  = parcela_origem.cod_credito
                       AND credito.cod_especie  = parcela_origem.cod_especie
                       AND credito.cod_genero   = parcela_origem.cod_genero
                       AND credito.cod_natureza = parcela_origem.cod_natureza

                     WHERE parcela_origem.cod_parcela      = origem.cod_parcela
            ) AS origem
            ON origem.num_parcelamento = ddp.num_parcelamento
            AND origem.exercicio = dda.exercicio
            AND origem.cod_inscricao = dda.cod_inscricao;";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('numParcelamento', $params['numParcelamento']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @return string
    */
    private function getTemporaryTablesSql()
    {
        return "
            CREATE TEMPORARY TABLE tmp_ded ON COMMIT DROP AS
                        SELECT tmp.*
                              FROM divida.emissao_documento AS tmp
                        INNER JOIN ( SELECT max(timestamp) as timestamp
                                          , cod_tipo_documento
                                          , cod_documento
                                          , num_parcelamento
                                       FROM divida.emissao_documento
                                   GROUP BY cod_tipo_documento
                                          , cod_documento
                                          , num_parcelamento
                                   )AS tmp2
                                ON tmp2.cod_tipo_documento = tmp.cod_tipo_documento
                               AND tmp2.cod_documento = tmp.cod_documento
                               AND tmp2.num_parcelamento = tmp.num_parcelamento
                               AND tmp2.timestamp = tmp.timestamp;

            CREATE TEMPORARY TABLE tmp_dedm ON COMMIT DROP AS
                        SELECT tmp.*
                              FROM divida.emissao_documento AS tmp
                        INNER JOIN ( SELECT min(timestamp) as timestamp
                                          , cod_tipo_documento
                                          , cod_documento
                                          , num_parcelamento
                                       FROM divida.emissao_documento
                                   GROUP BY cod_tipo_documento
                                          , cod_documento
                                          , num_parcelamento
                                   )AS tmp2
                                ON tmp2.cod_tipo_documento = tmp.cod_tipo_documento
                               AND tmp2.cod_documento = tmp.cod_documento
                               AND tmp2.num_parcelamento = tmp.num_parcelamento
                               AND tmp2.timestamp = tmp.timestamp;

            CREATE TEMPORARY TABLE tmp_ddp ON COMMIT DROP AS
                        SELECT MAX(dp.num_parcelamento) AS num_parcelamento
                                 , dp.cod_inscricao
                                 , dp.exercicio
                              FROM divida.divida_parcelamento AS dp
                         LEFT JOIN divida.parcelamento_cancelamento
                                ON parcelamento_cancelamento.num_parcelamento = dp.num_parcelamento
                             WHERE parcelamento_cancelamento.num_parcelamento IS NULL
                             GROUP BY dp.cod_inscricao , dp.exercicio;";
    }
}
