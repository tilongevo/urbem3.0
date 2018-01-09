<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use PDO;
use Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa;
use Urbem\CoreBundle\Repository\AbstractRepository;

class NotaAvulsaRepository extends AbstractRepository
{
    /**
     * @param NotaAvulsa $notaAvulsa
     * @return array
     */
    public function getInfo(NotaAvulsa $notaAvulsa)
    {
        $query = "
            select distinct
                    carne.numeracao,
                    carne.exercicio,
                    cadastro_economico_calculo.inscricao_economica,
                    faturamento_servico.cod_modalidade,
                    (
                        select
                            nom_cgm
                        from
                            sw_cgm
                        where
                            sw_cgm.numcgm = coalesce ( cadastro_economico_empresa_fato.numcgm, cadastro_economico_autonomo.numcgm, cadastro_economico_empresa_direito.numcgm )
                    )AS nomcgm_prestador,
                    coalesce ( cadastro_economico_empresa_fato.numcgm, cadastro_economico_autonomo.numcgm, cadastro_economico_empresa_direito.numcgm ) AS numcgm_prestador,
                    (
                        select
                            modalidade_lancamento.nom_modalidade
                        from
                            economico.modalidade_lancamento
                        where
                            modalidade_lancamento.cod_modalidade = faturamento_servico.cod_modalidade
                    )AS descricao_modalidade,
                    arrecadacao.fn_consulta_endereco_empresa( cadastro_economico_calculo.inscricao_economica ) AS endereco_empresa,
                    cadastro_economico_faturamento.competencia,
                    nota_avulsa.nro_nota,
                    nota_avulsa.nro_serie,
                    case when nota_avulsa_cancelada.cod_nota is not null then
                        'cancelada'
                    else
                        'ativa'
                    end as situacao_nota,
                    to_char ( faturamento_servico.dt_emissao, 'dd/mm/YYYY' ) as dt_emissao,
                    nota_avulsa.numcgm_tomador,
                    (
                        select
                            nom_cgm
                        from
                            sw_cgm
                        where
                            sw_cgm.numcgm = nota_avulsa.numcgm_tomador
                    )as nomcgm_tomador,
                    servico_sem_retencao.cod_servico,
                    (
                        select
                            servico.nom_servico
                        from
                            economico.servico
                        where
                            servico.cod_servico = servico_sem_retencao.cod_servico
                    )AS descricao_servico,
                    servico_sem_retencao.valor_declarado,
                    servico_sem_retencao.valor_deducao,
                    servico_sem_retencao.valor_lancado,
                    servico_sem_retencao.aliquota,
                    ap.valor as valor_a_pagar,
                    aplica_correcao( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, now()::date )::numeric(14,2) AS valor_correcao_a_pagar,
                    aplica_multa( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, now()::date )::numeric(14,2) AS valor_multa_a_pagar,
                    aplica_juro( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, now()::date )::numeric(14,2) AS valor_juros_a_pagar,
                    (ap.valor + aplica_correcao( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, now()::date ) + aplica_multa( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, now()::date ) +  aplica_juro( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, now()::date ) )::numeric(14,2) AS valor_total_a_pagar,
                    to_char ( ap.vencimento, 'dd/mm/YYYY' ) as dt_vencimento,
                    case when pagamento.numeracao is not null then
                        'pago'
                    else
                        'aberto'
                    end as situacao_parcela,
                    pagamento_lote.cod_lote,
                    to_char ( pagamento.data_pagamento, 'dd/mm/YYYY' ) as dt_pagamento,
                    pagamento.observacao as observacao_pagamento,
                    to_char ( pagamento.data_baixa, 'dd/mm/YYYY' ) as dt_baixa,
                    processo_pagamento.cod_processo,
                    processo_pagamento.ano_exercicio,
                    banco.num_banco,
                    banco.nom_banco,
                    agencia.num_agencia,
                    agencia.nom_agencia,
                    coalesce( pagamento.valor, 0.00 ) as valor_pago_total,
                    coalesce (
                        (
                            select
                                sum(valor)
                            from
                                arrecadacao.pagamento_acrescimo
                            where
                                pagamento_acrescimo.numeracao = pagamento.numeracao
                                and pagamento_acrescimo.cod_acrescimo = 1
                                and pagamento_acrescimo.cod_tipo = 2
                                and pagamento_acrescimo.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                        ),
                        0.00
                    )as valor_pago_juros,
                    coalesce (
                        (
                            select
                                sum(valor)
                            from
                                arrecadacao.pagamento_acrescimo
                            where
                                pagamento_acrescimo.numeracao = pagamento.numeracao
                                and pagamento_acrescimo.cod_acrescimo = 2
                                and pagamento_acrescimo.cod_tipo = 3
                                and pagamento_acrescimo.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                        ),
                        0.00
                    )as valor_pago_multa,
                    coalesce(
                        (
                            select
                                sum(valor)
                            from
                                arrecadacao.pagamento_acrescimo
                            where
                                pagamento_acrescimo.numeracao = pagamento.numeracao
                                and pagamento_acrescimo.cod_acrescimo = 3
                                and pagamento_acrescimo.cod_tipo = 1
                                and pagamento_acrescimo.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                        ),
                        0.00
                    )as valor_pago_correcao,
                    coalesce (
                        (
                            select
                                sum(valor)
                            from
                                arrecadacao.pagamento_calculo
                            where
                                pagamento_calculo.numeracao = pagamento.numeracao
                                and pagamento_calculo.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                        ),
                        0.00
                    )as valor_pago,
                    coalesce( parcela_desconto.valor, 0.00 ) as valor_desconto

                from
                    arrecadacao.carne

                left join
                    arrecadacao.pagamento
                on
                    carne.numeracao = pagamento.numeracao

                left join
                    arrecadacao.processo_pagamento
                on
                    processo_pagamento.numeracao = pagamento.numeracao
                    and processo_pagamento.ocorrencia_pagamento = pagamento.ocorrencia_pagamento

                left join
                    arrecadacao.pagamento_lote
                on
                    pagamento_lote.numeracao = pagamento.numeracao
                    and pagamento_lote.ocorrencia_pagamento = pagamento.ocorrencia_pagamento

                left join
                    arrecadacao.lote
                on
                    lote.cod_lote = pagamento_lote.cod_lote

                left join
                    monetario.banco
                on
                    banco.cod_banco = lote.cod_banco

                left join
                    monetario.agencia
                on
                    agencia.cod_banco = lote.cod_banco
                    and agencia.cod_agencia = lote.cod_agencia

                inner join
                    arrecadacao.parcela AS ap
                on
                    ap.cod_parcela = carne.cod_parcela

                left join
                    arrecadacao.parcela_desconto
                on
                    parcela_desconto.cod_parcela = ap.cod_parcela

                inner join
                    arrecadacao.lancamento_calculo
                on
                    lancamento_calculo.cod_lancamento = ap.cod_lancamento

                inner join
                    arrecadacao.calculo
                on
                    calculo.cod_calculo = lancamento_calculo.cod_calculo
                    and not ( calculo.cod_credito = 99 and calculo.cod_genero = 2 and calculo.cod_especie = 1 and calculo.cod_natureza = 1 )

                inner join
                    arrecadacao.cadastro_economico_calculo
                on
                    cadastro_economico_calculo.cod_calculo = lancamento_calculo.cod_calculo

                left join
                    economico.cadastro_economico_empresa_fato
                on
                    cadastro_economico_empresa_fato.inscricao_economica = cadastro_economico_calculo.inscricao_economica

                left join
                    economico.cadastro_economico_autonomo
                on
                    cadastro_economico_autonomo.inscricao_economica = cadastro_economico_calculo.inscricao_economica

                left join
                    economico.cadastro_economico_empresa_direito
                on
                    cadastro_economico_empresa_direito.inscricao_economica = cadastro_economico_calculo.inscricao_economica

                inner join
                    arrecadacao.cadastro_economico_faturamento
                on
                    cadastro_economico_faturamento.inscricao_economica = cadastro_economico_calculo.inscricao_economica
                    AND cadastro_economico_faturamento.timestamp = cadastro_economico_calculo.timestamp

                inner join
                    arrecadacao.faturamento_servico
                on
                    faturamento_servico.inscricao_economica = cadastro_economico_faturamento.inscricao_economica
                    AND faturamento_servico.timestamp = cadastro_economico_faturamento.timestamp

                inner join
                    arrecadacao.servico_sem_retencao
                on
                    servico_sem_retencao.inscricao_economica = faturamento_servico.inscricao_economica
                    AND servico_sem_retencao.timestamp = faturamento_servico.timestamp
                    AND servico_sem_retencao.cod_servico = faturamento_servico.cod_servico
                    AND servico_sem_retencao.ocorrencia = faturamento_servico.ocorrencia
                    AND servico_sem_retencao.cod_atividade = faturamento_servico.cod_atividade

                inner join
                    arrecadacao.nota_servico
                on
                    nota_servico.inscricao_economica = faturamento_servico.inscricao_economica
                    AND nota_servico.timestamp = faturamento_servico.timestamp
                    AND nota_servico.cod_servico = faturamento_servico.cod_servico
                    AND nota_servico.ocorrencia = faturamento_servico.ocorrencia
                    AND nota_servico.cod_atividade = faturamento_servico.cod_atividade

                inner join
                    arrecadacao.nota
                on
                    nota.cod_nota = nota_servico.cod_nota

                inner join
                    arrecadacao.nota_avulsa
                on
                    nota_avulsa.cod_nota = nota.cod_nota

                left join
                    arrecadacao.nota_avulsa_cancelada
                on
                    nota_avulsa_cancelada.cod_nota = nota_avulsa.cod_nota
             WHERE  nota_avulsa.cod_nota = :notaAvulsa";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':notaAvulsa', $notaAvulsa->getCodNota());
        $sth->execute();

        return $sth->fetch();
    }
}
