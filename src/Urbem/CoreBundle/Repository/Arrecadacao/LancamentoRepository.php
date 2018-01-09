<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class LancamentoRepository
 * @package Urbem\CoreBundle\Repository\Arrecadacao
 */
class LancamentoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextVal()
    {
        return $this->nextVal("cod_lancamento");
    }

    /**
     * @param $params
     * @return array
     */
    public function getArrecadacao($cgm, $exercicio, $cadastroEconomico, $inscricaoMunicipal, $numeracao)
    {
        $sql = "
        SELECT DISTINCT
         lancamentos.*,
         ( split_part( lancamentos.origem_info, '§', 1) ) as cod_credito,
         ( split_part( lancamentos.origem_info, '§', 2) ) as cod_grupo,
      CASE WHEN split_part( lancamentos.origem_info, '§', 4) = '' then
        split_part( lancamentos.origem_info, '§', 3)
          ELSE
              ( split_part( lancamentos.origem_info, '§', 3) ||' / '|| split_part(
    lancamentos.origem_info, '§', 4))
        end as origem,
         ( split_part( lancamentos.origem_info, '§', 4) ) as exercicio_origem,
         ( split_part( lancamentos.origem_info, '§', 6 )) as cod_modulo
         , arrecadacao.fn_busca_lancamento_situacao( lancamentos.cod_lancamento )
         as situacao_lancamento
     FROM
    (
         select
         alc.cod_lancamento,
         calc.exercicio,
         arrecadacao.fn_busca_origem_lancamento_sem_exercicio( alc.cod_lancamento, 2, 2
         ) as origem_info
         , (case
         when ic.cod_calculo  is not null then
             ic.inscricao_municipal
         when cec.cod_calculo is not null then
             cec.inscricao_economica
         end) as inscricao
        ,( arrecadacao.buscaCgmLancamento (alc.cod_lancamento)||' - '||
           arrecadacao.buscaContribuinteLancamento(alc.cod_lancamento)
        )::varchar as proprietarios
     , (case
         when ic.cod_calculo  is not null then
             arrecadacao.fn_consulta_endereco_imovel(ic.inscricao_municipal)
         when cec.cod_calculo is not null then
             arrecadacao.fn_consulta_endereco_empresa(cec.inscricao_economica)
         end) as dados_complementares
         , ( case when ic.cod_calculo  is not null then
                                    arrecadacao.fn_ultimo_venal_por_im_lanc(ic.inscricao_municipal,  alc.cod_lancamento)
                                end
                            ) as venal
        , arrecadacao.fn_tipo_ultimo_venal_por_im_lanc(ic.inscricao_municipal,  alc.cod_lancamento) AS tipo_venal
         ,coalesce(al.total_parcelas,0)::int as num_parcelas
         ,coalesce(arrecadacao.fn_num_unicas(alc.cod_lancamento),0)::int as num_unicas
         ,al.valor as valor_lancamento

                        , CASE WHEN ( calc.calculado = true ) THEN
                                'Calculado'
                          ELSE
                                'Lançamento Manual'
                          END AS tipo_calculo
     FROM
     ( SELECT * FROM arrecadacao.calculo
                           WHERE cod_calculo
                             NOT IN( SELECT COD_CALCULO from divida.parcela_calculo
                                      INNER JOIN divida.parcela
                                      USING (num_parcelamento, num_parcela)
                                      WHERE parcela.cancelada = true )) as calc
     INNER JOIN (
         SELECT
             max(cod_calculo) as cod_calculo
             , cod_lancamento
         FROM
             arrecadacao.lancamento_calculo
         GROUP BY cod_lancamento
     )  AS alc
     ON alc.cod_calculo = calc.cod_calculo
     INNER JOIN arrecadacao.lancamento AS al
     ON al.cod_lancamento = alc.cod_lancamento
     INNER JOIN arrecadacao.calculo_cgm  AS cgm
     ON calc.cod_calculo = cgm.cod_calculo
         LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
         ON acgc.cod_calculo = cgm.cod_calculo
         AND acgc.ano_exercicio = calc.exercicio
         LEFT JOIN arrecadacao.imovel_calculo ic
         ON ic.cod_calculo = calc.cod_calculo
         LEFT JOIN arrecadacao.cadastro_economico_calculo cec
         ON cec.cod_calculo  = calc.cod_calculo

         WHERE
         %s
     ) as lancamentos
     ORDER BY
         lancamentos.exercicio
         , origem
         , lancamentos.inscricao
         , lancamentos.cod_lancamento
            ";

        $where[] = '1=1';

        if ($cgm) {
            $where[] = 'cgm.numcgm = :numcgm';
        }

        if ($exercicio) {
            $where[] = 'calc.exercicio = :exercicio';
        }

        if ($cadastroEconomico) {
            $where[] = 'cec.inscricao_economica = :inscricaoEconomica';
        }

        if ($inscricaoMunicipal) {
            $where[] = 'ic.inscricao_municipal = :inscricaoMunicipal';
        }

        if ($numeracao) {
            $where[] = 'nac.numeracao = :numeracao';
        }


        $query = $this->_em->getConnection()->prepare(sprintf($sql, implode(' AND ', $where)));

        if ($cgm) {
            $query->bindValue('numcgm', $cgm, \PDO::PARAM_INT);
        }
        if ($exercicio) {
            $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        }
        if ($cadastroEconomico) {
            $query->bindValue('inscricaoEconomica', $cadastroEconomico, \PDO::PARAM_INT);
        }
        if ($inscricaoMunicipal) {
            $query->bindValue('inscricaoMunicipal', $inscricaoMunicipal, \PDO::PARAM_INT);
        }
        if ($numeracao) {
            $query->bindValue('numeracao', $numeracao, \PDO::PARAM_STR);
        }

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param obj $lancamento
     *  @return array
     */
    public function getContribuinte($lancamento)
    {
        $sql = "SELECT arrecadacao.buscaContribuinteLancamento(:codLancamento)";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codLancamento', $lancamento->getCodLancamento(), \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  obj $lancamento
     *  @return array
     */
    public function getSituacao($lancamento)
    {
        $sql = "SELECT arrecadacao.fn_busca_lancamento_situacao(:codLancamento)";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codLancamento', $lancamento->getCodLancamento(), \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  obj $lancamento
     *  @param  $getDescription
     *  @return array
     */
    public function getOrigemCobranca($lancamento, $getDescription = false)
    {
        $sql = sprintf(
            "SELECT arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, %s)",
            ($getDescription) ? '1,1' : '2,2'
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codLancamento', $lancamento->getCodLancamento(), \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  $codLancamento
     *  @return array
     */
    public function getBuscaOrigemLancamento($codLancamento)
    {
        $sql = "SELECT split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, 1, 1 ), '§', 3)||'/'||split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, 1, 1 ), '§', 4) AS origem";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codLancamento', $codLancamento, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  obj $lancamento
     *  @return array
     */
    public function getCgm($lancamento)
    {
        $sql = "SELECT arrecadacao.buscacgmlancamento(:codLancamento)";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codLancamento', $lancamento->getCodLancamento(), \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  int $inscricaoMunicipal
     *  @return array
     */
    public function getEnderecoByInscricaoMunicipal($inscricaoMunicipal)
    {
        $sql = "SELECT arrecadacao.fn_consulta_endereco_imovel(:inscricaoMunicipal)";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('inscricaoMunicipal', $inscricaoMunicipal, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  int $inscricaoEconomica
     *  @return array
     */
    public function getEnderecoByInscricaoEconomica($inscricaoEconomica)
    {
        $sql = "SELECT arrecadacao.fn_consulta_endereco_empresa(:inscricaoEconomica)";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('inscricaoEconomica', $inscricaoEconomica, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  obj  $param
     *  @return array
     */
    public function getListaCreditos($param)
    {
        $sql = "SELECT
         al.cod_lancamento,
         agc.cod_grupo,
         mc.descricao_credito,
         ac.cod_credito,
         ac.cod_especie,
         ac.cod_genero,
         ac.cod_natureza,
         alc.cod_calculo,
        -- ac.exercicio,
         CASE WHEN acgc.cod_grupo IS NOT NULL THEN
                   agc.ano_exercicio
          ELSE
                  ac.exercicio
         END as exercicio,
         ac.valor as valor_calculado,
         alc.valor ,
         split_part ( monetario.fn_busca_mascara_credito( mc.cod_credito, mc.cod_especie,
         mc.cod_genero, mc.cod_natureza ),'§', 1) as codigo_composto
     FROM
         arrecadacao.lancamento as al
         INNER JOIN arrecadacao.lancamento_calculo as alc
         ON alc.cod_lancamento = al.cod_lancamento
         INNER JOIN arrecadacao.calculo as ac
         ON ac.cod_calculo = alc.cod_calculo
         LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
         ON acgc.cod_calculo = alc.cod_calculo
         --AND acgc.ano_exercicio = ac.exercicio
         LEFT JOIN arrecadacao.grupo_credito as agc
         ON agc.cod_grupo = acgc.cod_grupo
         AND agc.ano_exercicio = acgc.ano_exercicio
         INNER JOIN monetario.credito as mc
         ON ac.cod_credito   = mc.cod_credito
         AND ac.cod_especie  = mc.cod_especie
         AND ac.cod_genero   = mc.cod_genero
         AND ac.cod_natureza = mc.cod_natureza

         WHERE
        al.cod_lancamento= :codLancamento";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codLancamento', $param->getCodLancamento(), \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  obj  $param
     *  @return array
     */
    public function getListaParcelas($param)
    {
        $sql = "SELECT
        *
        FROM
        arrecadacao.fn_consulta_parcela (:codLancamento, now()::date) as
        (   cod_lancamento integer,
            cod_parcela integer,
            nr_parcela integer,
            valor numeric,
            vencimento varchar,
            vencimento_original varchar,
            vencimento_us date,
            info_parcela varchar,
            database date,
            database_br varchar,
            numeracao varchar,
            exercicio varchar,
            situacao varchar,
            situacao_resumida varchar,
            numeracao_migracao varchar,
            prefixo varchar,
            pagamento date,
            ocorrencia_pagamento integer
        ) ORDER BY nr_parcela;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codLancamento', $param->getCodLancamento(), \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  int $codLancamento
     *  @param  string $numeracao
     *  @param  int $ocorrenciaPagamento
     *  @param  int $codParcela
     *  @return array
     */
    public function getDetalheParcela($codLancamento, $numeracao, $ocorrenciaPagamento, $codParcela)
    {
        $sql = "SELECT
          consulta.*
          , ( CASE WHEN consulta.pagamento_data is not null THEN
                  CASE WHEN
                      ( consulta.pagamento_valor !=
                      ( (consulta.parcela_valor - parcela_valor_desconto ) +
                      consulta.parcela_juros_pagar + consulta.parcela_multa_pagar
                      + parcela_correcao_pagar
                      + consulta.tmp_pagamento_diferenca )
                      )
                  THEN
                      coalesce (
                          consulta.pagamento_valor -
                          (( consulta.parcela_valor - consulta.parcela_valor_desconto ) +
                          ( consulta.parcela_juros_pagar )
                          + ( consulta.parcela_multa_pagar )
                          + ( consulta.parcela_correcao_pagar )
                          ), 0.00 )
                      + coalesce( (
                      ( consulta.parcela_juros_pago - consulta.parcela_juros_pagar )
                      + ( consulta.parcela_multa_pago - consulta.parcela_multa_pagar )
                      + ( consulta.parcela_correcao_pago - consulta.parcela_correcao_pagar )
                      ), 0.00 )
                  ELSE
                      consulta.tmp_pagamento_diferenca
                  END
              ELSE
                  0.00
              END
          ) as pagamento_diferenca
          , ( CASE WHEN  consulta.situacao = 'Em Aberto' THEN
                  consulta.parcela_juros_pagar
              ELSE
                  CASE WHEN consulta.pagamento_data is not null THEN
                      consulta.parcela_juros_pago
                  ELSE
                      0.00
                  END
              END
          ) as parcela_juros
          , ( CASE WHEN  consulta.situacao = 'Em Aberto' THEN
                  consulta.parcela_multa_pagar
              ELSE
                  CASE WHEN consulta.pagamento_data is not null THEN
                      consulta.parcela_multa_pago
                  ELSE
                      0.00
                  END
              END
          ) as parcela_multa
          , ( CASE WHEN consulta.situacao = 'Em Aberto' THEN
                  ( consulta.parcela_valor - parcela_valor_desconto
                  + consulta.parcela_juros_pagar + consulta.parcela_multa_pagar
                  + consulta.parcela_correcao_pagar )
              ELSE
                  CASE WHEN consulta.pagamento_data is not null THEN
                      consulta.pagamento_valor
                  ELSE
                      0.00
                  END
              END
          ) as valor_total
      FROM
          (
              select DISTINCT
                  al.cod_lancamento
                  , carne.numeracao
                  , carne.cod_convenio
              ---- PARCELA
                  , ap.cod_parcela
                  , ap.nr_parcela
                  , ( CASE WHEN apr.cod_parcela is not null THEN
                          to_char (arrecadacao.fn_atualiza_data_vencimento(apr.vencimento),
                          'dd/mm/YYYY')
                      ELSE
                          to_char (arrecadacao.fn_atualiza_data_vencimento(ap.vencimento),
                          'dd/mm/YYYY')
                      END
                  )::varchar as parcela_vencimento_original
                  , ( CASE WHEN apr.cod_parcela is null THEN
                          arrecadacao.fn_atualiza_data_vencimento(ap.vencimento)
                      ELSE
                          arrecadacao.fn_atualiza_data_vencimento(apr.vencimento)
                      END
                  )::varchar as parcela_vencimento_US
                  , to_char (arrecadacao.fn_atualiza_data_vencimento(ap.vencimento), 'dd/mm/YYYY')
                  as vencimento_original --VENCIMENTO PARA EXIBIÇÃO
                  , ap.valor as parcela_valor
                  , ( CASE WHEN apd.cod_parcela is not null
                           AND (ap.vencimento >= :todayDate ) THEN
                          (ap.valor - apd.valor)
                      ELSE
                          0.00
                      END
                  )::numeric(14,2) as parcela_valor_desconto
                  , ( select arrecadacao.buscaValorOriginalParcela( carne.numeracao ) as valor
                  ) as parcela_valor_original
                  , ( CASE WHEN apd.cod_parcela is not null AND apag.numeracao is NULL
                           AND (ap.vencimento >= :todayDate ) THEN
                          arrecadacao.fn_percentual_desconto_parcela( ap.cod_parcela,
                          ap.vencimento, (carne.exercicio)::int )
                      ELSE
                          0.00
                      END
                  ) as parcela_desconto_percentual
                  , ( CASE WHEN ap.nr_parcela = 0 THEN
                          'Única'::VARCHAR
                      ELSE
                          ap.nr_parcela::varchar||'/'||
                          arrecadacao.fn_total_parcelas(al.cod_lancamento)
                      END
                  ) as info_parcela
                  , ( CASE WHEN apag.numeracao is not null THEN
                          apag.pagamento_tipo
                      ELSE
                          CASE WHEN acd.devolucao_data is not null THEN
                              acd.devolucao_descricao
                          ELSE
                              CASE WHEN ap.nr_parcela = 0
                                          and (ap.vencimento < :todayDate)
                                          and baixa_manual_unica.valor = 'nao'
                              THEN
                                  'Cancelada (Parcela única vencida)'
                              ELSE
                                  'Em Aberto'
                              END
                          END
                      END
                  )::varchar as situacao
              ---- PARCELA FIM
                  , al.valor as lancamento_valor
              ---- PAGAMENTO
                  , to_char(apag.pagamento_data,'dd/mm/YYYY') as pagamento_data
                  , apag.pagamento_data_baixa
                  , apag.processo_pagamento
                  , apag.observacao
                  , apag.tp_pagamento
                  , apag.pagamento_tipo
                  , pag_lote.pagamento_cod_lote
                  , coalesce ( apag_dif.pagamento_diferenca, 0.00 ) as tmp_pagamento_diferenca
                  , apag.pagamento_valor
                  , ( CASE WHEN pag_lote.numeracao is not null THEN
                          pag_lote.cod_banco
                      ELSE
                          pag_lote_manual.cod_banco
                      END
                  ) as pagamento_cod_banco
                  , ( CASE WHEN pag_lote.numeracao is not null THEN
                          pag_lote.num_banco
                      ELSE
                          pag_lote_manual.num_banco
                      END
                  ) as pagamento_num_banco
                  , ( CASE WHEN pag_lote.numeracao is not null THEN
                          pag_lote.nom_banco
                      ELSE
                          pag_lote_manual.nom_banco
                      END
                  ) as pagamento_nom_banco
                  , ( CASE WHEN pag_lote.numeracao is not null THEN
                          pag_lote.cod_agencia
                      ELSE
                          pag_lote_manual.cod_agencia
                      END
                  ) as pagamento_cod_agencia
                  , ( CASE WHEN pag_lote.numeracao is not null THEN
                          pag_lote.num_agencia
                      ELSE
                          pag_lote_manual.num_agencia
                      END
                  ) as pagamento_num_agencia
                  , ( CASE WHEN pag_lote.numeracao is not null THEN
                          pag_lote.nom_agencia
                      ELSE
                          pag_lote_manual.nom_agencia
                      END
                  ) as pagamento_nom_agencia
                  , ( CASE WHEN pag_lote.numeracao is not null THEN
                          pag_lote.numcgm
                      ELSE
                          apag.pagamento_cgm
                      END
                  ) as pagamento_numcgm
                  , ( CASE WHEN pag_lote.numeracao is not null THEN
                          pag_lote.nom_cgm
                      ELSE
                          apag.pagamento_nome
                      END
                  ) as pagamento_nomcgm
                  , apag.ocorrencia_pagamento
              ---- CARNE DEVOLUCAO
                  , acd.devolucao_data
                  , acd.devolucao_descricao
              ---- CARNE MIGRACAO
                  , acm.numeracao_migracao as migracao_numeracao
                  , acm.prefixo as migracao_prefixo
              ---- CONSOLIDACAO
                  , accon.numeracao_consolidacao as consolidacao_numeracao
              ---- PARCELA ACRESCIMOS
                  , ( CASE WHEN
                                  ( ap.valor = 0.00 )
                                  OR ( apag.pagamento_data is not null
                                       AND ap.vencimento >= apag.pagamento_data )
                      THEN
                          0.00
                      ELSE
                          aplica_correcao( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, :todayDate::date )::numeric(14,2)
                      END
                  )::numeric(14,2) as parcela_correcao_pagar
                  , ( CASE WHEN
                                  ( ap.valor = 0.00 )
                                  OR ( apag.pagamento_data is not null
                                       AND ap.vencimento >= apag.pagamento_data )
                      THEN
                          0.00
                      ELSE
                          aplica_juro( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, :todayDate::date )::numeric(14,2)
                      END
                  )::numeric(14,2) as parcela_juros_pagar
                  , ( CASE WHEN
                                  ( ap.valor = 0.00 )
                                  OR (apag.pagamento_data is not null
                                      AND ap.vencimento >= apag.pagamento_data
                                  )
                      THEN
                          0.00
                      ELSE
                          aplica_multa( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, :todayDate::date )::numeric(14,2)
                      END
                  )::numeric(14,2) as parcela_multa_pagar
                  , ( CASE WHEN ( apag.pagamento_data is not null
                                  AND ap.vencimento < apag.pagamento_data )
                      THEN
                          ( select
                                sum(valor)
                            from
                                arrecadacao.pagamento_acrescimo
                            where
                                numeracao = apag.numeracao
                                AND cod_convenio = apag.cod_convenio
                                AND ocorrencia_pagamento = apag.ocorrencia_pagamento
                                AND cod_tipo = 1
                          )
                      ELSE
                          0.00
                      END
                  )::numeric(14,2) as parcela_correcao_pago
                  , ( CASE WHEN ( apag.pagamento_data is not null
                                  AND ap.vencimento < apag.pagamento_data )
                      THEN
                          ( select
                                sum(valor)
                            from
                                arrecadacao.pagamento_acrescimo
                            where
                                numeracao = apag.numeracao
                                AND cod_convenio = apag.cod_convenio
                                AND ocorrencia_pagamento = apag.ocorrencia_pagamento
                                AND cod_tipo = 3
                          )
                      ELSE
                          0.00
                      END
                  )::numeric(14,2) as parcela_multa_pago
                  , ( CASE WHEN ( apag.pagamento_data is not null AND
                                  ap.vencimento < apag.pagamento_data )
                      THEN
                          ( select
                              sum(valor)
                            from
                              arrecadacao.pagamento_acrescimo
                            where
                              numeracao = apag.numeracao
                              AND cod_convenio = apag.cod_convenio
                              AND ocorrencia_pagamento = apag.ocorrencia_pagamento
                              AND cod_tipo = 2
                          )
                      ELSE
                          0.00
                      END
                  )::numeric(14,2) as parcela_juros_pago
      FROM
          arrecadacao.carne as carne
          LEFT JOIN (
              select
                  exercicio
                  , valor
              from
                  administracao.configuracao
              where parametro = 'baixa_manual' AND cod_modulo = 25
          ) as baixa_manual_unica
          ON baixa_manual_unica.exercicio = carne.exercicio
      ---- PARCELA
          INNER JOIN (
              select
                  cod_parcela
                  , valor
                  , arrecadacao.fn_atualiza_data_vencimento (vencimento) as vencimento
                  , nr_parcela
                  , cod_lancamento
              from
                  arrecadacao.parcela as ap
          ) as ap
          ON ap.cod_parcela = carne.cod_parcela
          LEFT JOIN (
              select
                  apr.cod_parcela
                  , arrecadacao.fn_atualiza_data_vencimento( vencimento ) as vencimento
                  , valor
              from
                  arrecadacao.parcela_reemissao apr
                  inner join (
                      select cod_parcela, min(timestamp) as timestamp
                      from arrecadacao.parcela_reemissao
                      group by cod_parcela
                  ) as apr2
                  ON apr2.cod_parcela = apr.cod_parcela
                  AND apr2.timestamp = apr.timestamp
          ) as apr
          ON apr.cod_parcela = ap.cod_parcela
          LEFT JOIN arrecadacao.parcela_desconto apd
          ON apd.cod_parcela = ap.cod_parcela
        ---- #
          INNER JOIN arrecadacao.lancamento as al
          ON al.cod_lancamento = ap.cod_lancamento
          INNER JOIN arrecadacao.lancamento_calculo as alc
          ON alc.cod_lancamento = al.cod_lancamento
          INNER JOIN arrecadacao.calculo as ac
          ON ac.cod_calculo = alc.cod_calculo
      ---- PAGAMENTO
          LEFT JOIN (
              SELECT
                  apag.numeracao
                  , apag.cod_convenio
                  , apag.observacao
                  , atp.pagamento as tp_pagamento
                  , apag.data_pagamento as pagamento_data
                  , to_char(apag.data_baixa,'dd/mm/YYYY') as pagamento_data_baixa
                  , app.cod_processo::varchar||'/'||app.ano_exercicio as processo_pagamento
                  , cgm.numcgm as pagamento_cgm
                  , cgm.nom_cgm as pagamento_nome
                  , atp.nom_tipo as pagamento_tipo
                  , apag.valor as pagamento_valor
                  , apag.ocorrencia_pagamento
              FROM
                  arrecadacao.pagamento as apag
                  INNER JOIN sw_cgm as cgm
                  ON cgm.numcgm = apag.numcgm
                  INNER JOIN arrecadacao.tipo_pagamento as atp
                  ON atp.cod_tipo = apag.cod_tipo
                  LEFT JOIN arrecadacao.processo_pagamento as app
                  ON app.numeracao = apag.numeracao AND app.cod_convenio = apag.cod_convenio
          ) as apag
          ON apag.numeracao = carne.numeracao
          AND apag.cod_convenio = carne.cod_convenio
          LEFT JOIN (
              SELECT
                  numeracao
                  , cod_convenio
                  , ocorrencia_pagamento
                  , sum( valor ) as pagamento_diferenca
              FROM arrecadacao.pagamento_diferenca
              GROUP BY numeracao, cod_convenio, ocorrencia_pagamento
          ) as apag_dif
          ON apag_dif.numeracao = carne.numeracao
          AND apag_dif.cod_convenio = carne.cod_convenio
          AND apag_dif.ocorrencia_pagamento = apag.ocorrencia_pagamento
      ---- PAGAMENTO LOTE AUTOMATICO
          LEFT JOIN (
              SELECT
                  pag_lote.numeracao
                  , pag_lote.cod_convenio
                  , lote.cod_lote as pagamento_cod_lote
                  , cgm.numcgm
                  , cgm.nom_cgm
                  , lote.data_lote
                  , mb.cod_banco
                  , mb.num_banco
                  , mb.nom_banco
                  , mag.cod_agencia
                  , mag.num_agencia
                  , mag.nom_agencia
                  , pag_lote.ocorrencia_pagamento
              FROM
                  arrecadacao.pagamento_lote pag_lote
                  INNER JOIN arrecadacao.lote lote
                  ON lote.cod_lote = pag_lote.cod_lote
                  AND pag_lote.exercicio = lote.exercicio
                  INNER JOIN monetario.banco as mb ON mb.cod_banco = lote.cod_banco
                  INNER JOIN sw_cgm cgm ON cgm.numcgm = lote.numcgm
                  LEFT JOIN monetario.conta_corrente_convenio mccc
                  ON mccc.cod_convenio = pag_lote.cod_convenio
                  LEFT JOIN monetario.agencia mag
                  ON mag.cod_agencia = lote.cod_agencia
                  AND mag.cod_banco = mb.cod_banco
          ) as pag_lote
          ON pag_lote.numeracao = carne.numeracao
          AND pag_lote.cod_convenio = carne.cod_convenio
      ----- PAGAMENTO LOTE MANUAL
          LEFT JOIN (
              SELECT
                  pag_lote.numeracao
                  , pag_lote.cod_convenio
                  , mb.cod_banco
                  , mb.num_banco
                  , mb.nom_banco
                  , mag.cod_agencia
                  , mag.num_agencia
                  , mag.nom_agencia
                  , pag_lote.ocorrencia_pagamento
              FROM
                  arrecadacao.pagamento_lote_manual pag_lote
                  INNER JOIN monetario.banco as mb ON mb.cod_banco = pag_lote.cod_banco
                  LEFT JOIN monetario.conta_corrente_convenio mccc
                  ON mccc.cod_convenio = pag_lote.cod_convenio
                  LEFT JOIN monetario.agencia mag
                  ON mag.cod_agencia = pag_lote.cod_agencia
                  AND mag.cod_banco = mb.cod_banco
          ) as pag_lote_manual
          ON pag_lote_manual.numeracao = carne.numeracao
          AND pag_lote_manual.cod_convenio = carne.cod_convenio
          AND pag_lote_manual.ocorrencia_pagamento = apag.ocorrencia_pagamento
      ---- CARNE DEVOLUCAO
          LEFT JOIN (
              SELECT
                  acd.numeracao
                  , acd.cod_convenio
                  , acd.dt_devolucao as devolucao_data
                  , amd.descricao as devolucao_descricao
              FROM
                  arrecadacao.carne_devolucao as acd
                  INNER JOIN arrecadacao.motivo_devolucao as amd
                  ON amd.cod_motivo = acd.cod_motivo
          ) as acd
          ON acd.numeracao = carne.numeracao
          AND acd.cod_convenio = carne.cod_convenio
          LEFT JOIN arrecadacao.carne_migracao acm
          ON  acm.numeracao  = carne.numeracao
          AND acm.cod_convenio = carne.cod_convenio
          LEFT JOIN arrecadacao.carne_consolidacao as accon
          ON accon.numeracao = carne.numeracao
          AND accon.cod_convenio = carne.cod_convenio
      WHERE
            %s
           -- al.cod_lancamento= 9881 AND  carne.numeracao= '10000000000001058' AND  apag.ocorrencia_pagamento = 1 AND  ap.cod_parcela= 42263
      ORDER BY
          ap.nr_parcela
      ) as consulta";

        $where[] = '1=1';

        if ($codLancamento) {
            $where[] = 'al.cod_lancamento= :codLancamento';
        }
        if ($numeracao) {
            $where[] = 'carne.numeracao= :numeracao';
        }
        if ($ocorrenciaPagamento) {
            $where[] = 'apag.ocorrencia_pagamento = :ocorrenciaPagamento';
        }
        if ($codParcela) {
            $where[] = 'ap.cod_parcela= :codParcela';
        }

        $query = $this->_em->getConnection()->prepare(sprintf($sql, implode(' AND ', $where)));

        $query->bindValue('todayDate', date('Y-m-d'), \PDO::PARAM_STR);

        if ($codLancamento) {
            $query->bindValue('codLancamento', $codLancamento, \PDO::PARAM_INT);
        }
        if ($numeracao) {
            $query->bindValue('numeracao', $numeracao, \PDO::PARAM_STR);
        }
        if ($ocorrenciaPagamento) {
            $query->bindValue('ocorrenciaPagamento', $ocorrenciaPagamento, \PDO::PARAM_INT);
        }
        if ($codParcela) {
            $query->bindValue('codParcela', $codParcela, \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  obj @params
     *  @return array
     */
    public function getDetalhamentoPorCredito($params)
    {
        $sql = "
            SELECT
          *
          , ( (   soma_total.valor_credito - soma_total.credito_descontos)
                + soma_total.credito_juros_pagar + soma_total.credito_multa_pagar
                + soma_total.credito_correcao_pagar + soma_total.diferenca
          ) as valor_total
      FROM
          (
          SELECT
              *
              , ( CASE WHEN consulta.pagamento_data is not null AND ( consulta.tp_pagamento is true )
                  THEN
                      ( consulta.pagamento_valor )
                      - ( consulta.valor_credito - consulta.credito_descontos )
                      + (consulta.credito_juros_pago - consulta.credito_juros_pagar)
                      + (consulta.credito_multa_pago - consulta.credito_multa_pagar)
                      + ( consulta.credito_correcao_pago - consulta.credito_correcao_pagar )
                      + consulta.pagamento_diferenca
                  ELSE
                      0.00
                  END
              ) as diferenca
              , to_char( consulta.pagamento_data,'dd/mm/YYYY' ) as pagamento_data
          FROM
              (
              SELECT
                  split_part ( monetario.fn_busca_mascara_credito( ac.cod_credito, ac.cod_especie,
                      ac.cod_genero, ac.cod_natureza), '§', 1
                  ) as credito_codigo_composto
                  , split_part ( monetario.fn_busca_mascara_credito( ac.cod_credito, ac.cod_especie,
                          ac.cod_genero, ac.cod_natureza), '§', 6
                  ) as credito_nome
                  , ac.cod_calculo
                  , ac.valor as calculo_valor
                  , ap.vencimento as parcela_vencimento
                  , apag.pagamento_data
                  , apag.tp_pagamento
                  , apagc.valor as pagamento_valor
                  , coalesce (apag_dif.valor, 0.00) as pagamento_diferenca
                  , coalesce (apagcorr.valor, 0.00) as credito_correcao_pago
                  , coalesce (apagj.valor, 0.00) as credito_juros_pago
                  , coalesce (apagm.valor, 0.00) as credito_multa_pago
                  , (  CASE WHEN alc.valor = 0.00 THEN
                           0.00
                       ELSE
                          CASE WHEN ap.nr_parcela = 0 THEN
                              alc.valor
                          ELSE
                          coalesce (
                                                (
                                                    (( alc.valor * 100 ) / somaALC.valor )
                                                        *
                                                     ap.valor
                                                ) / 100,
                                                0.00
                                             )::numeric(14,6)
                          END
                      END
                  )::numeric(14,2) as valor_credito
              ---- ACRESCIMOS ABERTO
                  , ( CASE WHEN ( ap.vencimento_antigo >= :todayDate AND ap.nr_parcela >= 0 )
                              OR
                              ( ap.nr_parcela = 0 and baixa_manual_unica.valor = 'nao' )
                              OR
                              ( apag.pagamento_data is not null
                                  AND
                                ap.vencimento >= apag.pagamento_data
                              )
                              OR ( ap.nr_parcela > 0 AND acd.numeracao is not null )
                              OR  ( ap.valor = 0.00 )
                      THEN
                          0.00
                      ELSE
                          coalesce (
                                                (
                                                    (( alc.valor * 100 ) / somaALC.valor )
                                                        *
                                                     aplica_correcao ( carne.numeracao, ac.exercicio::int, ap.cod_parcela, :todayDate )
                                                ) / 100,
                                                0.00
                                             )::numeric(14,6)
                      END
                    )::numeric(14,2) as credito_correcao_pagar
                  , ( CASE WHEN ( ap.vencimento_antigo >= :todayDate AND ap.nr_parcela >= 0 )
                              OR
                              ( ap.nr_parcela = 0 and baixa_manual_unica.valor = 'nao' )
                              OR
                              ( apag.pagamento_data is not null
                                  AND
                                ap.vencimento >= apag.pagamento_data
                              )
                              OR ( ap.nr_parcela > 0 AND acd.numeracao is not null )
                              OR  ( ap.valor = 0.00 )
                      THEN
                          0.00
                      ELSE
                          coalesce (
                                                (
                                                    (( alc.valor * 100 ) / somaALC.valor )
                                                        *
                                                     aplica_juro ( carne.numeracao, ac.exercicio::int, ap.cod_parcela, :todayDate )
                                                ) / 100,
                                                0.00
                                             )::numeric(14,6)
                      END
                  )::numeric(14,2) as credito_juros_pagar
                  , ( CASE WHEN ( ap.vencimento_antigo >= :todayDate AND ap.nr_parcela >= 0 )
                              OR
                              ( ap.nr_parcela = 0 and baixa_manual_unica.valor = 'nao' )
                              OR
                              ( apag.pagamento_data is not null
                                  AND
                                ap.vencimento >= apag.pagamento_data
                              )
                              OR ( ap.nr_parcela > 0 AND acd.numeracao is not null )
                              OR  ( ap.valor = 0.00 )
                      THEN
                          0.00
                      ELSE
                          coalesce (
                                                (
                                                    (( alc.valor * 100 ) / somaALC.valor )
                                                        *
                                                     aplica_multa ( carne.numeracao, ac.exercicio::int, ap.cod_parcela, :todayDate )
                                                ) / 100,
                                                0.00
                                             )::numeric(14,6)
                      END
                  )::numeric(14,2) as credito_multa_pagar
                  , ( CASE WHEN apag.pagamento_data is not null
                          AND apag.pagamento_data > ap.vencimento
                          OR ( ap.vencimento_antigo < :todayDate )
                          OR ( alc.valor = 0.00 )
                      THEN
                          0.00
                      ELSE

                                    coalesce (
                                                (
                                                    (( alc.valor * 100 ) / somaALC.valor )
                                                        *
                                                     apd.valor
                                                ) / 100,
                                                0.00
                                             )::numeric(14,6)
                      END
                  )::numeric(14,2) as credito_descontos
              , CASE WHEN
                                (
                                    SELECT
                                        calculo_grupo_credito.cod_calculo
                                    FROM
                                        arrecadacao.calculo_grupo_credito
                                    WHERE
                                        calculo_grupo_credito.cod_calculo = ac.cod_calculo
                                ) IS NOT NULL AND ( apd.cod_parcela IS NOT NULL ) THEN
                                COALESCE(
                                    (
                                        SELECT
                                            acg.desconto
                                        FROM
                                            arrecadacao.credito_grupo AS acg
                                        WHERE
                                            acg.cod_credito = ac.cod_credito
                                            AND acg.cod_genero = ac.cod_genero
                                            AND acg.cod_especie = ac.cod_especie
                                            AND acg.cod_natureza = ac.cod_natureza
                                            AND acg.cod_grupo = (
                                                SELECT
                                                    cod_grupo
                                                FROM
                                                    arrecadacao.calculo_grupo_credito
                                                WHERE
                                                    calculo_grupo_credito.cod_calculo = ac.cod_calculo
                                            )
                                            AND acg.ano_exercicio = (
                                                SELECT
                                                    ano_exercicio
                                                FROM
                                                    arrecadacao.calculo_grupo_credito
                                                WHERE
                                                    calculo_grupo_credito.cod_calculo = ac.cod_calculo
                                            )
                                    ),
                                    false
                                )
                        ELSE
                            CASE WHEN ( apd.cod_parcela IS NOT NULL ) THEN
                                true
                            ELSE
                                false
                            END
                        END AS usar_desconto
              FROM
                  arrecadacao.carne as carne
                  LEFT JOIN (
                      select
                          exercicio
                          , valor
                      from
                          administracao.configuracao
                      where parametro = 'baixa_manual' AND cod_modulo = 25
                  ) as baixa_manual_unica
                  ON baixa_manual_unica.exercicio = carne.exercicio
                  INNER JOIN (
                      select
                          cod_parcela
                          , valor
                                    , COALESCE(
                                        (
                                            SELECT
                                                arrecadacao.fn_atualiza_data_vencimento (parcela_reemissao.vencimento)
                                            FROM
                                                arrecadacao.parcela_reemissao
                                            WHERE
                                                parcela_reemissao.cod_parcela = ap.cod_parcela
                                            ORDER BY
                                                parcela_reemissao.timestamp ASC
                                            LIMIT 1
                                        ),
                                        arrecadacao.fn_atualiza_data_vencimento (ap.vencimento)
                                    )AS vencimento_antigo
                          , arrecadacao.fn_atualiza_data_vencimento (vencimento) as vencimento
                          , nr_parcela
                          , cod_lancamento
                      from
                          arrecadacao.parcela as ap
                  ) as ap
                  ON ap.cod_parcela = carne.cod_parcela
                  LEFT JOIN arrecadacao.parcela_desconto as apd
                  ON apd.cod_parcela = ap.cod_parcela
                  INNER JOIN arrecadacao.lancamento as al
                  ON al.cod_lancamento = ap.cod_lancamento
                            INNER JOIN (
                                SELECT
                                    sum(valor) AS valor
                                    , cod_lancamento
                                FROM
                                    arrecadacao.lancamento_calculo
                                GROUP BY
                                    cod_lancamento
                            )AS somaALC
                            ON somaALC.cod_lancamento = al.cod_lancamento
                  INNER JOIN arrecadacao.lancamento_calculo as alc
                  ON alc.cod_lancamento = al.cod_lancamento
                  INNER JOIN arrecadacao.calculo as ac
                  ON ac.cod_calculo = alc.cod_calculo
              ---- PAGAMENTO
                  LEFT JOIN (
                      SELECT
                          apag.numeracao
                          , apag.cod_convenio
                          , apag.observacao
                          , apag.data_pagamento as pagamento_data
                          , to_char(apag.data_baixa,'dd/mm/YYYY') as pagamento_data_baixa
                          , app.cod_processo::varchar||'/'||app.ano_exercicio as processo_pagamento
                          , cgm.numcgm as pagamento_cgm
                          , cgm.nom_cgm as pagamento_nome
                          , atp.nom_tipo as pagamento_tipo
                          , apag.valor as pagamento_valor
                          , apag.ocorrencia_pagamento
                          , atp.pagamento as tp_pagamento
                          , apag.valor as pagamento_parcela_valor
                      FROM
                          arrecadacao.pagamento as apag
                          INNER JOIN sw_cgm as cgm
                          ON cgm.numcgm = apag.numcgm
                          INNER JOIN arrecadacao.tipo_pagamento as atp
                          ON atp.cod_tipo = apag.cod_tipo
                          LEFT JOIN arrecadacao.processo_pagamento as app
                          ON app.numeracao = apag.numeracao AND app.cod_convenio = apag.cod_convenio
                  ) as apag
                  ON apag.numeracao = carne.numeracao
                  AND apag.cod_convenio = carne.cod_convenio
                  LEFT JOIN (
                      SELECT
                          numeracao
                          , cod_convenio
                          , ocorrencia_pagamento
                          , cod_calculo
                          , valor
                      FROM arrecadacao.pagamento_diferenca
                  ) as apag_dif
                  ON apag_dif.numeracao = carne.numeracao
                  AND apag_dif.cod_convenio = carne.cod_convenio
                  AND apag_dif.ocorrencia_pagamento = apag.ocorrencia_pagamento
                  AND apag_dif.cod_calculo = ac.cod_calculo
                  LEFT JOIN arrecadacao.pagamento_calculo as apagc
                  ON apagc.cod_calculo = ac.cod_calculo
                  AND apagc.numeracao = apag.numeracao
                  AND apagc.cod_convenio = apag.cod_convenio
                  AND apagc.ocorrencia_pagamento = apag.ocorrencia_pagamento
                  LEFT JOIN arrecadacao.pagamento_acrescimo as apagcorr
                  ON apagcorr.cod_calculo = ac.cod_calculo
                  AND apagcorr.numeracao = apag.numeracao
                  AND apagcorr.cod_convenio = apag.cod_convenio
                  AND apagcorr.ocorrencia_pagamento = apag.ocorrencia_pagamento
                  AND apagcorr.cod_tipo = 1
                  LEFT JOIN arrecadacao.pagamento_acrescimo as apagj
                  ON apagj.cod_calculo = ac.cod_calculo
                  AND apagj.numeracao = apag.numeracao
                  AND apagj.cod_convenio = apag.cod_convenio
                  AND apagj.ocorrencia_pagamento = apag.ocorrencia_pagamento
                  AND apagj.cod_tipo = 2
                  LEFT JOIN arrecadacao.pagamento_acrescimo as apagm
                  ON apagm.cod_calculo = ac.cod_calculo
                  AND apagm.numeracao = apag.numeracao
                  AND apagm.cod_convenio = apag.cod_convenio
                  AND apagm.ocorrencia_pagamento = apag.ocorrencia_pagamento
                  AND apagm.cod_tipo = 3
                  LEFT JOIN arrecadacao.carne_devolucao as acd
                  ON acd.numeracao = carne.numeracao
                  AND acd.cod_convenio = carne.cod_convenio
          WHERE
            %s
              -- al.cod_lancamento= 9883 and  carne.numeracao= '10000000000001065' and  ap.cod_parcela= 42270
      ) as consulta ) as soma_total
        ";

        $where[] = '1=1';

        if ($params->query->get('codLancamento')) {
            $where[] = 'al.cod_lancamento= :codLancamento';
        }
        if ($params->query->get('numeracao')) {
            $where[] = 'carne.numeracao= :numeracao';
        }
        if ($params->query->get('codParcela')) {
            $where[] = 'ap.cod_parcela= :codParcela';
        }

        $query = $this->_em->getConnection()->prepare(sprintf($sql, implode(' AND ', $where)));

        $query->bindValue('todayDate', date('Y-m-d'), \PDO::PARAM_STR);

        if ($params->query->get('codLancamento')) {
            $query->bindValue('codLancamento', $params->query->get('codLancamento'), \PDO::PARAM_INT);
        }
        if ($params->query->get('numeracao')) {
            $query->bindValue('numeracao', $params->query->get('numeracao'), \PDO::PARAM_STR);
        }
        if ($params->query->get('codParcela')) {
            $query->bindValue('codParcela', $params->query->get('codParcela'), \PDO::PARAM_INT);
        }

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $inscricaoMunicipal
     * @param $codLancamento
     * @return array
     */
    public function getUltimoVenal($inscricaoMunicipal, $codLancamento)
    {
        $sql = 'SELECT arrecadacao.fn_ultimo_venal_por_im_lanc(:inscricaoMunicipal, :codLancamento) as valor';

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue('inscricaoMunicipal', $inscricaoMunicipal, \PDO::PARAM_INT);
        $query->bindValue('codLancamento', $codLancamento, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $inscricaoMunicipal
     * @param $data
     * @return array
     */
    public function getSituacaoImovel($inscricaoMunicipal, $data)
    {
        $sql = 'SELECT imobiliario.fn_busca_situacao_imovel(:inscricaoMunicipal,:data) as valor';

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue('inscricaoMunicipal', $inscricaoMunicipal, \PDO::PARAM_INT);
        $query->bindValue('data', $data, \PDO::PARAM_STR);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $inscricaoEconomica
     * @return array
     */
    public function getLancamentoByInscricaoEconomica($inscricaoEconomica)
    {
        $sql = "SELECT DISTINCT
         lancamentos.*,
         ( split_part( lancamentos.origem_info, '§', 1) ) as cod_credito,
         ( split_part( lancamentos.origem_info, '§', 2) ) as cod_grupo,
      CASE WHEN split_part( lancamentos.origem_info, '§', 4) = '' then
        split_part( lancamentos.origem_info, '§', 3)
          ELSE
              ( split_part( lancamentos.origem_info, '§', 3) ||' / '|| split_part(
    lancamentos.origem_info, '§', 4))
        end as origem,
         ( split_part( lancamentos.origem_info, '§', 4) ) as exercicio_origem,
         ( split_part( lancamentos.origem_info, '§', 6 )) as cod_modulo
         , arrecadacao.fn_busca_lancamento_situacao( lancamentos.cod_lancamento )
         as situacao_lancamento
     FROM
    (
         select
         alc.cod_lancamento,
         calc.exercicio,
         arrecadacao.fn_busca_origem_lancamento_sem_exercicio( alc.cod_lancamento, 2, 2
         ) as origem_info
     , cec.inscricao_economica as inscricao
        ,( arrecadacao.buscaCgmLancamento (alc.cod_lancamento)||' - '||
           arrecadacao.buscaContribuinteLancamento(alc.cod_lancamento)
        )::varchar as proprietarios
     ,arrecadacao.fn_consulta_endereco_empresa(cec.inscricao_economica) as dados_complementares
         ,coalesce(al.total_parcelas,0)::int as num_parcelas
         ,coalesce(arrecadacao.fn_num_unicas(alc.cod_lancamento),0)::int as num_unicas
         ,al.valor as valor_lancamento

                        , CASE WHEN ( calc.calculado = true ) THEN
                                'Calculado'
                          ELSE
                                'Lançamento Manual'
                          END AS tipo_calculo
         ,cef.competencia
     FROM
     ( SELECT * FROM arrecadacao.calculo
                           WHERE cod_calculo
                             NOT IN( SELECT COD_CALCULO from divida.parcela_calculo
                                      INNER JOIN divida.parcela
                                      USING (num_parcelamento, num_parcela)
                                      WHERE parcela.cancelada = true )) as calc
     INNER JOIN (
         SELECT
             max(cod_calculo) as cod_calculo
             , cod_lancamento
         FROM
             arrecadacao.lancamento_calculo
         GROUP BY cod_lancamento
     )  AS alc
     ON alc.cod_calculo = calc.cod_calculo
     INNER JOIN arrecadacao.lancamento AS al
     ON al.cod_lancamento = alc.cod_lancamento
         INNER JOIN arrecadacao.cadastro_economico_calculo as cec
         ON cec.cod_calculo = calc.cod_calculo
         INNER JOIN arrecadacao.cadastro_economico_faturamento as cef
         ON cef.inscricao_economica = cec.inscricao_economica AND
            cef.timestamp = cec.timestamp
         INNER JOIN arrecadacao.calculo_cgm cgm ON cgm.cod_calculo = cec.cod_calculo
         LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
         ON acgc.cod_calculo = cgm.cod_calculo
         AND acgc.ano_exercicio = calc.exercicio

         WHERE
    cec.inscricao_economica = :inscricaoEconomica
     ) as lancamentos
     ORDER BY
         lancamentos.exercicio
         , origem
         , lancamentos.inscricao
         , lancamentos.cod_lancamento";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue('inscricaoEconomica', $inscricaoEconomica, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     *  @param  $codLancamento
     *  @return array
     */
    public function getOrigemFormated($codLancamento)
    {
        $sql = 'SELECT
            ( split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, 2, 2), \'§\', 1) ) as cod_credito,
         ( split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, 2, 2), \'§\', 2) ) as cod_grupo,
    CASE WHEN split_part(  arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, 2, 2) , \'§\', 4) = \'\' then
        split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, 2, 2), \'§\', 3)
          ELSE
              ( split_part( arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, 2, 2), \'§\', 3) ||\' / \'|| split_part(
    arrecadacao.fn_busca_origem_lancamento_sem_exercicio(:codLancamento, 2, 2), \'§\', 4))
        end as origem
        ';

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue('codLancamento', $codLancamento, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $codGrupo
     * @param $anoExercicio
     * @return array
     */
    public function getCreditosByGrupoCreditos($codGrupo, $anoExercicio)
    {
        $sql = "
            SELECT
              acg.cod_credito,
              acg.cod_grupo,
              acg.ano_exercicio,
              acg.cod_especie,
              acg.cod_genero,
              acg.cod_natureza,
              acg.desconto,
              acg.ordem,
              mc.descricao_credito,
              mc.cod_convenio
            FROM
              arrecadacao.credito_grupo as acg
              INNER JOIN monetario.credito mc ON
                                                acg.cod_credito = mc.cod_credito AND
                                                acg.cod_especie = mc.cod_especie AND
                                                acg.cod_genero  = mc.cod_genero  AND
                                                acg.cod_natureza= mc.cod_natureza

            WHERE

              acg.cod_grupo = :codGrupo AND
              acg.ano_exercicio = :anoExercicio ORDER BY cod_credito;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codGrupo', $codGrupo, \PDO::PARAM_INT);
        $query->bindValue('anoExercicio', $anoExercicio, \PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
