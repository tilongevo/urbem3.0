<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class CalculoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getCodCalculo()
    {
        return $this->nextVal("cod_calculo");
    }

    /**
     * @param $inscricaoEconomica
     * @return bool|string
     */
    public function getNumCgmByInscricaoEconomica($inscricaoEconomica)
    {
        $sql = "
            SELECT DISTINCT ON (CE.inscricao_economica)
	               CE.inscricao_economica
	             , TO_CHAR(CE.dt_abertura,'dd/mm/yyyy') as dt_abertura
	             , TO_CHAR(CE.timestamp, 'dd/mm/yyyy') as dt_inclusao
	             , ACE.cod_atividade
	             , A.nom_atividade
	             , COALESCE ( A.cod_estrutural, '&nbsp;' ) as cod_estrutural
	             , CGM.nom_cgm
	             , CGMPF.cpf
	             , CGMPJ.cnpj
	             , COALESCE ( CEED.numcgm, CEEF.numcgm, CEA.numcgm ) as numcgm
	             , CASE WHEN CAST( CEEF.numcgm AS VARCHAR) IS NOT NULL THEN
	                  'F'
	               WHEN CAST( CEA.numcgm AS VARCHAR ) IS NOT NULL THEN
	                  'A'
	               WHEN CAST( CEED.numcgm AS VARCHAR) IS NOT NULL THEN
	                  'D'
	               END AS enquadramento
	             , CASE WHEN (DF.timestamp IS NOT NULL AND DI.timestamp IS NOT NULL  AND DF.timestamp >= DI.timestamp) THEN
	                  'F'
	               WHEN (DF.timestamp IS NOT NULL AND DI.timestamp IS NOT NULL  AND DF.timestamp < DI.timestamp) THEN
	                  'I'
	               WHEN (DF.timestamp IS NOT NULL) THEN
	                  'F'
	               WHEN (DI.timestamp IS NOT NULL) THEN
	                  'I'
	               END AS tipo_domicilio
	             , CEED.num_registro_junta
	             , NJ.cod_natureza
	             , NJ.nom_natureza
	             , TL.nom_tipo||' '||NL.nom_logradouro as logradouro_f
	             , TL2.nom_tipo||' '||NL2.nom_logradouro as logradouro_i
	             , I.numero AS numero_f
	             , DI.numero AS numero_i
	             , I.complemento AS complemento_f
	             , DI.complemento AS complemento_i
	             , CA.nom_categoria
	             , CASE WHEN BA.dt_inicio IS NOT NULL AND BA.dt_termino IS NULL THEN
	                   BA.timestamp
	               ELSE
	                   NULL
	               END AS dt_baixa
	             , CASE WHEN BA.dt_inicio IS NOT NULL AND BA.dt_termino IS NULL THEN
	                   BA.motivo
	               ELSE
	                   NULL
	               END AS motivo
	             , UF.nom_uf
	             , MU.nom_municipio
	             , BAI.nom_bairro
	             , BAI.cod_bairro
	             , DI.cod_logradouro
	             , DI.cep
	             , DI.caixa_postal
	             , DF.inscricao_municipal
	          FROM economico.cadastro_economico CE

	     LEFT JOIN economico.atividade_cadastro_economico ACE
	            ON CE.inscricao_economica = ACE.inscricao_economica
	           AND ACE.principal = TRUE

	     LEFT JOIN economico.atividade A
	            ON A.cod_atividade = ACE.cod_atividade

	     LEFT JOIN economico.cadastro_economico_empresa_direito CEED
	            ON CEED.inscricao_economica = CE.inscricao_economica

	     LEFT JOIN economico.cadastro_economico_empresa_fato CEEF
	            ON CEEF.inscricao_economica = CE.inscricao_economica

	     LEFT JOIN economico.cadastro_economico_autonomo CEA
	            ON CEA.inscricao_economica = CE.inscricao_economica

	     LEFT JOIN economico.categoria CA
	            ON CA.cod_categoria = CEED.cod_categoria

	     LEFT JOIN economico.empresa_direito_natureza_juridica EDNJ
	            ON EDNJ.inscricao_economica = CEED.inscricao_economica

	     LEFT JOIN economico.natureza_juridica NJ
	            ON NJ.cod_natureza = EDNJ.cod_natureza

	     LEFT JOIN economico.domicilio_informado DI
	            ON DI.inscricao_economica = CE.inscricao_economica

	     LEFT JOIN ( SELECT MAX(timestamp) AS timestamp
	                      , inscricao_economica
	                   FROM economico.domicilio_fiscal
	               GROUP BY inscricao_economica
	              ) AS DF_MAX
	           ON DF_MAX.inscricao_economica = CE.inscricao_economica

	    LEFT JOIN economico.domicilio_fiscal AS DF
	           ON DF.timestamp           = DF_MAX.timestamp
	          AND DF.inscricao_economica = DF_MAX.inscricao_economica
	          AND DF.inscricao_economica = CE.inscricao_economica

	     LEFT JOIN economico.sociedade S
	            ON S.inscricao_economica = CE.inscricao_economica

	     LEFT JOIN imobiliario.imovel I
	            ON I.inscricao_municipal = DF.inscricao_municipal

	     LEFT JOIN imobiliario.imovel_confrontacao IC
	            ON IC.inscricao_municipal = I.inscricao_municipal

	     LEFT JOIN imobiliario.confrontacao_trecho CT
	            ON CT.cod_confrontacao = IC.cod_confrontacao
	           AND CT.cod_lote         = IC.cod_lote
	           AND CT.principal        = true

	     LEFT JOIN sw_uf UF
	            ON UF.cod_uf = DI.cod_uf

	     LEFT JOIN sw_municipio MU
	            ON MU.cod_municipio = DI.cod_municipio
	           AND MU.cod_uf        = DI.cod_uf

	     LEFT JOIN sw_bairro BAI
	            ON BAI.cod_bairro    = DI.cod_bairro
	           AND BAI.cod_uf        = DI.cod_uf
	           AND BAI.cod_municipio = DI.cod_municipio

	     LEFT JOIN sw_nome_logradouro NL
	            ON NL.cod_logradouro = CT.cod_logradouro

	     LEFT JOIN sw_tipo_logradouro TL
	            ON TL.cod_tipo = NL.cod_tipo

	     LEFT JOIN sw_nome_logradouro NL2
	            ON NL2.cod_logradouro = DI.cod_logradouro

	     LEFT JOIN sw_tipo_logradouro TL2
	            ON TL2.cod_tipo = NL2.cod_tipo

	     LEFT JOIN ( SELECT tmp.*
	                   FROM economico.baixa_cadastro_economico AS tmp
	             INNER JOIN ( SELECT MAX(timestamp) as timestamp
	                               , inscricao_economica
	                            FROM economico.baixa_cadastro_economico
	                        GROUP BY inscricao_economica
	                        )AS tmp2
	                     ON tmp.inscricao_economica = tmp2.inscricao_economica
	                    AND tmp.timestamp = tmp2.timestamp
	               ) AS BA
	            ON BA.inscricao_economica = CE.inscricao_economica
	             , sw_cgm AS CGM

	     LEFT JOIN sw_cgm_pessoa_fisica AS CGMPF
	            ON CGMPF.numcgm = CGM.numcgm

	     LEFT JOIN sw_cgm_pessoa_juridica AS CGMPJ
	            ON CGMPJ.numcgm = CGM.numcgm

	         WHERE COALESCE ( CEED.numcgm, CEEF.numcgm, CEA.numcgm ) = cgm.numcgm  AND CE.inscricao_economica = :inscricaoEconomica
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('inscricaoEconomica', $inscricaoEconomica, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchColumn(9);
    }

    /**
    * @param int $contribuinte
    * @param int $exercicioIni
    * @param int $exercicioEnd
    * @param int $inscricaoEconomica
    * @param int $inscricaoImobiliaria
    * @return array
    */
    public function getParcelasPagasEmDuplicidade($contribuinte, $exercicioIni, $exercicioEnd, $inscricaoEconomica, $inscricaoImobiliaria)
    {
        $sql = "
            SELECT DISTINCT
                calculo_cgm.numcgm,
                (
                    SELECT
                        nom_cgm
                    FROM
                        sw_cgm
                    WHERE
                        sw_cgm.numcgm = calculo_cgm.numcgm
                )AS nom_cgm,
                CASE WHEN parcela.nr_parcela = 0 THEN
                    'única'
                ELSE
                    parcela.nr_parcela::varchar
                END AS nr_parcela,
                parcela.cod_parcela,
                CASE WHEN carne.cod_convenio = -1 THEN
                    split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 ), '§', 3)||'/'||split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 ), '§', 4)
                ELSE
                    arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 )
                END AS origem,
                (
                    COALESCE(
                        (
                            SELECT
                                parcela_desconto.valor
                            FROM
                                arrecadacao.parcela_desconto
                            WHERE
                                parcela_desconto.cod_parcela = parcela.cod_parcela
                        ),
                        parcela.valor
                    )
                ) AS valor_parcela,
                pagamento.valor AS valor_pago,
                to_char(parcela.vencimento, 'dd/mm/yyyy' ) AS vencimento,
                carne.numeracao,
                carne.exercicio,
                pagamento.ocorrencia_pagamento,
                pagamento.cod_convenio

            FROM
                arrecadacao.calculo

            LEFT JOIN
                arrecadacao.imovel_calculo
            ON
                imovel_calculo.cod_calculo = calculo.cod_calculo

            LEFT JOIN
                arrecadacao.cadastro_economico_calculo
            ON
                cadastro_economico_calculo.cod_calculo = calculo.cod_calculo

            INNER JOIN
                arrecadacao.calculo_cgm
            ON
                calculo_cgm.cod_calculo = calculo.cod_calculo

            INNER JOIN
                arrecadacao.lancamento_calculo
            ON
                lancamento_calculo.cod_calculo = calculo.cod_calculo

            INNER JOIN
                arrecadacao.parcela
            ON
                parcela.cod_lancamento = lancamento_calculo.cod_lancamento

            INNER JOIN
                arrecadacao.carne
            ON
                carne.cod_parcela = parcela.cod_parcela

            INNER JOIN
                arrecadacao.pagamento
            ON
                pagamento.numeracao = carne.numeracao
                AND pagamento.cod_convenio = carne.cod_convenio

            LEFT JOIN
                arrecadacao.pagamento_compensacao
            ON
                pagamento_compensacao.numeracao = pagamento.numeracao
                AND pagamento_compensacao.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                AND pagamento_compensacao.cod_convenio = pagamento.cod_convenio

            LEFT JOIN
                arrecadacao.pagamento_diferenca_compensacao
            ON
                pagamento_diferenca_compensacao.numeracao = pagamento.numeracao
                AND pagamento_diferenca_compensacao.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                AND pagamento_diferenca_compensacao.cod_convenio = pagamento.cod_convenio

            WHERE
                pagamento_compensacao.numeracao IS NULL
                AND pagamento_diferenca_compensacao.numeracao IS NULL
                AND pagamento.ocorrencia_pagamento > 1
                AND pagamento.cod_tipo != 12 AND %s order by carne.exercicio, carne.numeracao
        ";

        $where = [];

        if ($contribuinte) {
            $where[] = 'calculo_cgm.numcgm = :numcgm';
        }

        if ($exercicioIni && $exercicioEnd) {
            $where[] = 'calculo.exercicio BETWEEN :exercicioIni AND :exercicioEnd';
        }

        if ($exercicioIni && !$exercicioEnd) {
            $where[] = 'calculo.exercicio = :exercicioIni';
        }

        if ($inscricaoEconomica) {
            $where[] = 'cadastro_economico_calculo.inscricao_economica = :inscricaoEconomica';
        }

        if ($inscricaoImobiliaria) {
            $where[] = 'imovel_calculo.inscricao_municipal = :inscricaoImobiliaria';
        }

        $sql = sprintf($sql, implode(' AND ', $where));

        $query = $this->_em->getConnection()->prepare($sql);

        if ($contribuinte) {
            $query->bindValue(':numcgm', $contribuinte, \PDO::PARAM_INT);
        }

        if ($exercicioIni && $exercicioEnd) {
            $query->bindValue(':exercicioIni', $exercicioIni, \PDO::PARAM_STR);
            $query->bindValue(':exercicioEnd', $exercicioEnd, \PDO::PARAM_STR);
        }

        if ($exercicioIni && !$exercicioEnd) {
            $query->bindValue(':exercicioIni', $exercicioIni, \PDO::PARAM_STR);
        }

        if ($inscricaoEconomica) {
            $query->bindValue(':inscricaoEconomica', $inscricaoEconomica, \PDO::PARAM_INT);
        }

        if ($inscricaoImobiliaria) {
            $query->bindValue(':inscricaoImobiliaria', $inscricaoImobiliaria, \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll();
    }

    /**
    * @param int $contribuinte
    * @param int $inscricaoEconomica
    * @param int $inscricaoImobiliaria
    * @return array
    */
    public function getParcelasAVencer($contribuinte, $inscricaoEconomica, $inscricaoImobiliaria)
    {
        $sql = "SELECT DISTINCT
                            calculo_cgm.numcgm,
                            (
                                SELECT
                                    nom_cgm
                                FROM
                                    sw_cgm
                                WHERE
                                    sw_cgm.numcgm = calculo_cgm.numcgm
                            )AS nom_cgm,
                            CASE WHEN parcela.nr_parcela = 0 THEN
                                'única'
                            ELSE
                                parcela.nr_parcela::varchar
                            END AS nr_parcela,
                            parcela.cod_parcela,
                            arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 ) AS origem,
                            (
                                COALESCE(
                                    (
                                        SELECT
                                            parcela_desconto.valor
                                        FROM
                                            arrecadacao.parcela_desconto
                                        WHERE
                                            parcela_desconto.cod_parcela = parcela.cod_parcela
                                    ),
                                    parcela.valor
                                )
                            ) AS valor_parcela,
                            (
                                COALESCE(
                                    (
                                        SELECT
                                            parcela_desconto.valor
                                        FROM
                                            arrecadacao.parcela_desconto
                                        WHERE
                                            parcela_desconto.cod_parcela = parcela.cod_parcela
                                    ),
                                    parcela.valor
                                )
                                    +
                                arrecadacao.aplica_acrescimo_parcela( carne.numeracao::varchar, carne.exercicio::integer, parcela.cod_parcela, now()::date, 3, 1)
                                    +
                                arrecadacao.aplica_acrescimo_parcela( carne.numeracao::varchar, carne.exercicio::integer, parcela.cod_parcela, now()::date, 1, 2)
                                    +
                                arrecadacao.aplica_acrescimo_parcela( carne.numeracao::varchar, carne.exercicio::integer, parcela.cod_parcela, now()::date, 2, 3)
                            ) AS valor_corrigido,
                            to_char(parcela.vencimento, 'dd/mm/yyyy' ) AS vencimento,
                            carne.numeracao,
                            carne.exercicio,
                            carne.cod_convenio

                        FROM
                            arrecadacao.calculo

                        LEFT JOIN
                            arrecadacao.imovel_calculo
                        ON
                            imovel_calculo.cod_calculo = calculo.cod_calculo

                        LEFT JOIN
                            arrecadacao.cadastro_economico_calculo
                        ON
                            cadastro_economico_calculo.cod_calculo = calculo.cod_calculo

                        INNER JOIN
                            arrecadacao.calculo_cgm
                        ON
                            calculo_cgm.cod_calculo = calculo.cod_calculo

                        INNER JOIN
                            arrecadacao.lancamento_calculo
                        ON
                            lancamento_calculo.cod_calculo = calculo.cod_calculo

                        INNER JOIN
                            arrecadacao.parcela
                        ON
                            parcela.cod_lancamento = lancamento_calculo.cod_lancamento

                        INNER JOIN
                            arrecadacao.carne
                        ON
                            carne.cod_parcela = parcela.cod_parcela

                        LEFT JOIN
                            arrecadacao.pagamento
                        ON
                            pagamento.numeracao = carne.numeracao
                            AND pagamento.cod_convenio = carne.cod_convenio

                        LEFT JOIN
                            arrecadacao.carne_devolucao
                        ON
                            carne_devolucao.numeracao = carne.numeracao

                        WHERE
                            carne_devolucao IS NULL
                            AND pagamento.numeracao IS NULL
                            AND carne.cod_convenio != -1  AND %s AND (((now()::date <= parcela.vencimento) AND parcela.nr_parcela = 0 ) OR parcela.nr_parcela > 0 )  order by carne.exercicio, carne.numeracao
        ";

        $where = [];

        if ($contribuinte) {
            $where[] = 'calculo_cgm.numcgm = :numcgm';
        }

        if ($inscricaoEconomica) {
            $where[] = 'cadastro_economico_calculo.inscricao_economica = :inscricaoEconomica';
        }

        if ($inscricaoImobiliaria) {
            $where[] = 'imovel_calculo.inscricao_municipal = :inscricaoImobiliaria';
        }

        $sql = sprintf($sql, implode(' AND ', $where));

        $query = $this->_em->getConnection()->prepare($sql);


        if ($contribuinte) {
            $query->bindValue(':numcgm', $contribuinte, \PDO::PARAM_INT);
        }

        if ($inscricaoEconomica) {
            $query->bindValue(':inscricaoEconomica', $inscricaoEconomica, \PDO::PARAM_INT);
        }

        if ($inscricaoImobiliaria) {
            $query->bindValue(':inscricaoImobiliaria', $inscricaoImobiliaria, \PDO::PARAM_INT);
        }


        $query->execute();

        return $query->fetchAll();
    }

    /**
    * @param int $contribuinte
    * @param int $exercicioIni
    * @param int $exercicioEnd
    * @param int $inscricaoEconomica
    * @param int $inscricaoImobiliaria
    * @return array
    */
    public function getParcelasComDiferencaPagas($contribuinte, $exercicioIni, $exercicioEnd, $inscricaoEconomica, $inscricaoImobiliaria)
    {
        $sql = "
            SELECT DISTINCT
                    calculo_cgm.numcgm,
                    (
                        SELECT
                            nom_cgm
                        FROM
                            sw_cgm
                        WHERE
                            sw_cgm.numcgm = calculo_cgm.numcgm
                    )AS nom_cgm,
                    CASE WHEN parcela.nr_parcela = 0 THEN
                        'única'
                    ELSE
                        parcela.nr_parcela::varchar
                    END AS nr_parcela,
                    parcela.cod_parcela,
                    CASE WHEN carne.cod_convenio = -1 THEN
                        split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 ), '§', 3)||'/'||split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 ), '§', 4)
                    ELSE
                        arrecadacao.fn_busca_origem_lancamento_sem_exercicio( parcela.cod_lancamento, 1, 1 )
                    END AS origem,
                    (
                        COALESCE(
                            (
                                SELECT
                                    parcela_desconto.valor
                                FROM
                                    arrecadacao.parcela_desconto
                                WHERE
                                    parcela_desconto.cod_parcela = parcela.cod_parcela
                            ),
                            parcela.valor
                        )
                    ) AS valor_parcela,
                    to_char(parcela.vencimento, 'dd/mm/yyyy' ) AS vencimento,
                    carne.numeracao,
                    carne.exercicio,
                    pagamento.ocorrencia_pagamento,
                    pagamento.cod_convenio,
                    pagamento_diferenca.valor AS valor_pago,
                    pagamento_diferenca.cod_calculo

                FROM
                    arrecadacao.calculo

                LEFT JOIN
                    arrecadacao.imovel_calculo
                ON
                    imovel_calculo.cod_calculo = calculo.cod_calculo

                LEFT JOIN
                    arrecadacao.cadastro_economico_calculo
                ON
                    cadastro_economico_calculo.cod_calculo = calculo.cod_calculo

                INNER JOIN
                    arrecadacao.calculo_cgm
                ON
                    calculo_cgm.cod_calculo = calculo.cod_calculo

                INNER JOIN
                    arrecadacao.lancamento_calculo
                ON
                    lancamento_calculo.cod_calculo = calculo.cod_calculo

                INNER JOIN
                    arrecadacao.parcela
                ON
                    parcela.cod_lancamento = lancamento_calculo.cod_lancamento

                INNER JOIN
                    arrecadacao.carne
                ON
                    carne.cod_parcela = parcela.cod_parcela

                INNER JOIN
                    arrecadacao.pagamento
                ON
                    pagamento.numeracao = carne.numeracao
                    AND pagamento.cod_convenio = carne.cod_convenio

                LEFT JOIN
                    arrecadacao.pagamento_diferenca
                ON
                    pagamento_diferenca.numeracao = pagamento.numeracao
                    AND pagamento_diferenca.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                    AND pagamento_diferenca.cod_convenio = pagamento.cod_convenio

                LEFT JOIN
                    arrecadacao.pagamento_compensacao
                ON
                    pagamento_compensacao.numeracao = pagamento.numeracao
                    AND pagamento_compensacao.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                    AND pagamento_compensacao.cod_convenio = pagamento.cod_convenio

                LEFT JOIN
                    arrecadacao.pagamento_diferenca_compensacao
                ON
                    pagamento_diferenca_compensacao.numeracao = pagamento.numeracao
                    AND pagamento_diferenca_compensacao.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                    AND pagamento_diferenca_compensacao.cod_convenio = pagamento.cod_convenio

                WHERE
                    pagamento_compensacao.numeracao IS NULL
                    AND pagamento_diferenca_compensacao.numeracao IS NULL
                    AND pagamento.cod_tipo != 12
                    AND pagamento_diferenca IS NOT NULL
                    AND %s
                order by carne.exercicio, carne.numeracao
        ";

        $where = [];

        if ($contribuinte) {
            $where[] = 'calculo_cgm.numcgm = :numcgm';
        }

        if ($exercicioIni && $exercicioEnd) {
            $where[] = 'calculo.exercicio BETWEEN :exercicioIni AND :exercicioEnd';
        }

        if ($exercicioIni && !$exercicioEnd) {
            $where[] = 'calculo.exercicio = :exercicioIni';
        }

        if ($inscricaoEconomica) {
            $where[] = 'cadastro_economico_calculo.inscricao_economica = :inscricaoEconomica';
        }

        if ($inscricaoImobiliaria) {
            $where[] = 'imovel_calculo.inscricao_municipal = :inscricaoImobiliaria';
        }

        $sql = sprintf($sql, implode(' AND ', $where));

        $query = $this->_em->getConnection()->prepare($sql);

        if ($contribuinte) {
            $query->bindValue(':numcgm', $contribuinte, \PDO::PARAM_INT);
        }

        if ($exercicioIni && $exercicioEnd) {
            $query->bindValue(':exercicioIni', $exercicioIni, \PDO::PARAM_STR);
            $query->bindValue(':exercicioEnd', $exercicioEnd, \PDO::PARAM_STR);
        }

        if ($exercicioIni && !$exercicioEnd) {
            $query->bindValue(':exercicioIni', $exercicioIni, \PDO::PARAM_STR);
        }

        if ($inscricaoEconomica) {
            $query->bindValue(':inscricaoEconomica', $inscricaoEconomica, \PDO::PARAM_INT);
        }

        if ($inscricaoImobiliaria) {
            $query->bindValue(':inscricaoImobiliaria', $inscricaoImobiliaria, \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll();
    }

    /**
    * @param int $numcgm
    * @return array
    */
    public function getSaldoDisponivel($numcgm)
    {
        $sql = "SELECT
                          COALESCE( sum( compensacao_resto.valor ), 0.00 ) AS saldo_disponivel
                       FROM (

                        SELECT
                        compensacao_resto.cod_compensacao

                        FROM
                            arrecadacao.calculo

                        LEFT JOIN
                            arrecadacao.imovel_calculo
                        ON
                            imovel_calculo.cod_calculo = calculo.cod_calculo

                        LEFT JOIN
                            arrecadacao.cadastro_economico_calculo
                        ON
                            cadastro_economico_calculo.cod_calculo = calculo.cod_calculo

                        LEFT JOIN
                            arrecadacao.calculo_cgm
                        ON
                            calculo_cgm.cod_calculo = calculo.cod_calculo

                        INNER JOIN
                            arrecadacao.lancamento_calculo
                        ON
                            lancamento_calculo.cod_calculo = calculo.cod_calculo

                        INNER JOIN
                            arrecadacao.parcela
                        ON
                            parcela.cod_lancamento = lancamento_calculo.cod_lancamento

                        INNER JOIN
                            arrecadacao.carne
                        ON
                            carne.cod_parcela = parcela.cod_parcela

                        INNER JOIN
                            arrecadacao.pagamento
                        ON
                            pagamento.numeracao = carne.numeracao
                            AND pagamento.cod_convenio = carne.cod_convenio

                        INNER JOIN
                            arrecadacao.pagamento_compensacao
                        ON
                            pagamento_compensacao.numeracao = pagamento.numeracao
                            AND pagamento_compensacao.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                            AND pagamento_compensacao.cod_convenio = pagamento.cod_convenio

                        INNER JOIN
                            arrecadacao.compensacao_resto
                        ON
                            compensacao_resto.cod_compensacao = pagamento_compensacao.cod_compensacao

                        WHERE  calculo_cgm.numcgm = :numcgm  GROUP BY 1
                           ) as compensacao
                               INNER JOIN
                               arrecadacao.compensacao_resto
                               ON
                               compensacao_resto.cod_compensacao = compensacao.cod_compensacao
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        if ($numcgm) {
            $query->bindValue(':numcgm', $numcgm, \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll();
    }

    /**
     *  @param int
     *  @param int
     *  @param int
     *  @return array
     */
    public function getCarnesPagamentoComResto($contribuinte, $inscricaoEconomica, $inscricaoImobiliaria)
    {
        $sql = "SELECT
                        pagamento_compensacao.*,
                        compensacao_resto.valor

                    FROM
                        arrecadacao.calculo

                    LEFT JOIN
                        arrecadacao.imovel_calculo
                    ON
                        imovel_calculo.cod_calculo = calculo.cod_calculo

                    LEFT JOIN
                        arrecadacao.cadastro_economico_calculo
                    ON
                        cadastro_economico_calculo.cod_calculo = calculo.cod_calculo

                    LEFT JOIN
                        arrecadacao.calculo_cgm
                    ON
                        calculo_cgm.cod_calculo = calculo.cod_calculo

                    INNER JOIN
                        arrecadacao.lancamento_calculo
                    ON
                        lancamento_calculo.cod_calculo = calculo.cod_calculo

                    INNER JOIN
                        arrecadacao.parcela
                    ON
                        parcela.cod_lancamento = lancamento_calculo.cod_lancamento

                    INNER JOIN
                        arrecadacao.carne
                    ON
                        carne.cod_parcela = parcela.cod_parcela

                    INNER JOIN
                        arrecadacao.pagamento
                    ON
                        pagamento.numeracao = carne.numeracao
                        AND pagamento.cod_convenio = carne.cod_convenio

                    INNER JOIN
                        arrecadacao.pagamento_compensacao
                    ON
                        pagamento_compensacao.numeracao = pagamento.numeracao
                        AND pagamento_compensacao.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                        AND pagamento_compensacao.cod_convenio = pagamento.cod_convenio

                    INNER JOIN
                        arrecadacao.compensacao_resto
                    ON
                        compensacao_resto.cod_compensacao = pagamento_compensacao.cod_compensacao

                    WHERE %s";
        $where = [];

        if ($contribuinte) {
            $where[] = 'calculo_cgm.numcgm = :numcgm';
        }

        if ($inscricaoImobiliaria) {
            $where[] = 'imovel_calculo.inscricao_municipal = :inscricaoImobiliaria';
        }

        if ($inscricaoEconomica) {
            $where[] = 'cadastro_economico_calculo.inscricao_economica =  :inscricaoEconomica';
        }

        $query = $this->_em->getConnection()->prepare(sprintf($sql, implode(' AND ', $where)));

        if ($contribuinte) {
            $query->bindValue(':numcgm', $contribuinte, \PDO::PARAM_INT);
        }

        if ($inscricaoImobiliaria) {
            $query->bindValue(':inscricaoImobiliaria', $inscricaoImobiliaria, \PDO::PARAM_INT);
        }

        if ($inscricaoEconomica) {
            $query->bindValue(':inscricaoEconomica', $inscricaoEconomica, \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll();
    }

    /**
     *  @param int codCalculo
     *  @return array
     */
    public function getNumeracaoParaCompensacao($codCalculo)
    {
        $sql = "
        SELECT DISTINCT
            funcao.nom_funcao,
            carteira.cod_carteira,
            convenio.cod_convenio

        FROM
            arrecadacao.calculo

        INNER JOIN
            monetario.credito
        ON
            credito.cod_credito = calculo.cod_credito
            AND credito.cod_especie = calculo.cod_especie
            AND credito.cod_natureza = calculo.cod_natureza
            AND credito.cod_genero = calculo.cod_genero

        INNER JOIN
            monetario.convenio
        ON
            convenio.cod_convenio = credito.cod_convenio

        LEFT JOIN
            monetario.carteira
        ON
            carteira.cod_convenio = convenio.cod_convenio

        INNER JOIN
            monetario.tipo_convenio
        ON
            tipo_convenio.cod_tipo = convenio.cod_tipo

        INNER JOIN
            administracao.funcao
        ON
            funcao.cod_funcao = tipo_convenio.cod_funcao
            AND funcao.cod_biblioteca = tipo_convenio.cod_biblioteca
            AND funcao.cod_modulo = tipo_convenio.cod_modulo

        WHERE
            calculo.cod_calculo = :codCalculo";

        $query = $this->_em->getConnection()->prepare($sql);

        if ($codCalculo) {
            $query->bindValue(':codCalculo', $codCalculo, \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     *  @param str nomeFuncao
     *  @param int|false codCarteira
     *  @param int codConvenio
     *  @return array
     */
    public function getNumeracaoFromFunction($nomeFuncao, $codCarteira, $codConvenio)
    {
        $sql = "SELECT " .strtolower($nomeFuncao). "('', :codConvenio) AS numeracao";
        if ($codCarteira) {
            $sql = "SELECT " .strtolower($nomeFuncao). "(:codCarteira, :codConvenio) AS numeracao";
        }

        $query = $this->_em->getConnection()->prepare($sql);

        if ($codCarteira) {
            $query->bindValue(':codCarteira', $codCarteira, \PDO::PARAM_INT);
        }

        if ($codConvenio) {
            $query->bindValue(':codConvenio', $codConvenio, \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
