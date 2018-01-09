<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use PDO;
use Urbem\CoreBundle\Entity\Arrecadacao\Lote;
use Urbem\CoreBundle\Repository\AbstractRepository;

class LoteRepository extends AbstractRepository
{
    /**
     * @param Lote $lote
     * @return array
     */
    public function getPagamentos(Lote $lote)
    {
        $query = "
            SELECT
          tabela2.*,
          tabela2.valor_pago_calculo + tabela2.juros + tabela2.multa + tabela2.diferenca + tabela2.correcao as valor_pago_normal
     FROM
         (
             SELECT
                 tabela.*
                    , ( SELECT coalesce (sum(valor), 0.00) as juros
                      FROM
                         arrecadacao.pagamento_acrescimo
                     WHERE
                         cod_tipo = 1
                         and numeracao = tabela.numeracao
                         and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                         and cod_convenio = tabela.cod_convenio
                 )::numeric(14,2) as correcao

        , COALESCE(
        ( SELECT
            sum(valor)
            FROM
            arrecadacao.pagamento_diferenca
            WHERE
                pagamento_diferenca.numeracao        = tabela.numeracao
            AND pagamento_diferenca.cod_convenio         = tabela.cod_convenio
            AND pagamento_diferenca.ocorrencia_pagamento = tabela.ocorrencia_pagamento
        ), 0.00
          )::numeric(14,2) AS diferenca
                 , ( SELECT coalesce (sum(valor), 0.00) as juros
                     FROM
                         arrecadacao.pagamento_acrescimo
                     WHERE
                         cod_tipo = 2
                         and numeracao = tabela.numeracao
                         and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                         and cod_convenio = tabela.cod_convenio
                 )::numeric(14,2) as juros
                 , ( select coalesce ( ( aplica_juro (
                                             tabela.numeracao
                                             , tabela.exercicio
                                             , tabela.cod_parcela
                                             , tabela.data_pagamento )
                                         * arrecadacao.calculaProporcaoParcela(
                                                 tabela.cod_parcela )
                                         )
                                         , 0.00 )
                 )::numeric(14,2) as juros_calculado
                 , ( select coalesce (sum(valor), 0.00) as multa
                     from arrecadacao.pagamento_acrescimo
                     where cod_tipo = 3
                     and numeracao = tabela.numeracao
                     and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                     and cod_convenio = tabela.cod_convenio
                 )::numeric(14,2) as multa
                 , ( select coalesce ((aplica_multa (
                                         tabela.numeracao
                                         , tabela.exercicio
                                         , tabela.cod_parcela
                                         , tabela.data_pagamento )
                                     * arrecadacao.calculaProporcaoParcela(
                                                             tabela.cod_parcela )
                                     ), 0.00 )
                 )::numeric(14,2) as multa_calculada
                 , arrecadacao.fn_busca_soma_pagamento_calculo(
                             tabela.numeracao
                             , tabela.cod_convenio
                             , tabela.ocorrencia_pagamento
                 )::numeric(14,2) as valor_pago_calculo
                 , arrecadacao.buscaContribuinteLancamento( tabela.cod_lancamento
                 ) as contribuinte
                 , (
                     SELECT atp2.cod_tipo
                     FROM arrecadacao.tipo_pagamento as atp2
                         INNER JOIN arrecadacao.pagamento as apag2
                         ON apag2.cod_tipo = atp2.cod_tipo
                     WHERE
                         apag2.numeracao = tabela.numeracao
                         AND apag2.cod_convenio = tabela.cod_convenio
                         AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento
                 ) as cod_tipo_pagamento
                 , (
                     SELECT atp2.nom_resumido
                     FROM arrecadacao.tipo_pagamento as atp2
                         INNER JOIN arrecadacao.pagamento as apag2
                         ON apag2.cod_tipo = atp2.cod_tipo
                     WHERE
                         apag2.numeracao = tabela.numeracao
                         AND apag2.cod_convenio = tabela.cod_convenio
                         AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento
                 ) as nom_tipo
             FROM
                 (
                     SELECT DISTINCT
                         lote.cod_lote
                         , to_char(lote.data_lote, 'dd/mm/YYYY') as data_lote
                         , to_char(pagamento.data_pagamento, 'dd/mm/YYYY'
                         ) as data_pagamento_br
                         , pagamento.data_pagamento
                         , atp.cod_tipo
                         , atp.nom_resumido as nom_tipo
                         , carne.numeracao
                         , carne.cod_convenio
                         , carne.exercicio::int
                         , pagamento.ocorrencia_pagamento
                         , cgm.numcgm
                         , cgm.nom_cgm
                         , parcela.cod_parcela
                         , parcela.cod_lancamento
                         , parcela.nr_parcela
                         , pagamento.valor as valor_pago_normal
                         , now()::date as hoje
                         , ali.numeracao as inconsistencia_numeracao
                         , arrecadacao.fn_info_parcela (parcela.cod_parcela) as info_parcela
                         , arrecadacao.buscaInscricaoLancamento( parcela.cod_lancamento
                         ) as inscricao
                         , arrecadacao.buscaVinculoLancamento ( parcela.cod_lancamento, pagamento_lote.exercicio::int
                         ) as origem
                     FROM
                         arrecadacao.lote
                         INNER JOIN arrecadacao.pagamento_lote
                         ON pagamento_lote.cod_lote = lote.cod_lote
                         AND pagamento_lote.exercicio = lote.exercicio
                         INNER JOIN arrecadacao.pagamento
                         ON pagamento.numeracao = pagamento_lote.numeracao
                         AND pagamento.ocorrencia_pagamento
                             = pagamento_lote.ocorrencia_pagamento
                         AND pagamento.cod_convenio = pagamento_lote.cod_convenio
                         INNER JOIN arrecadacao.tipo_pagamento as atp
                         ON atp.cod_tipo = pagamento.cod_tipo
                         INNER JOIN arrecadacao.carne
                         ON carne.numeracao = pagamento_lote.numeracao
                         AND carne.cod_convenio = pagamento_lote.cod_convenio
                         INNER JOIN arrecadacao.parcela
                         ON  parcela.cod_parcela = carne.cod_parcela
                         INNER JOIN sw_cgm as cgm
                         ON cgm.numcgm = pagamento.numcgm
                         LEFT JOIN arrecadacao.lote_inconsistencia as ali
                         ON ali.numeracao = carne.numeracao
                         AND pagamento.ocorrencia_pagamento = ali.ocorrencia
                         AND ali.exercicio = carne.exercicio
                         AND ali.cod_lote = lote.cod_lote
                         INNER JOIN arrecadacao.lancamento_calculo as alc
                         ON alc.cod_lancamento = parcela.cod_lancamento
                         INNER JOIN arrecadacao.calculo as c
                         ON c.cod_calculo = alc.cod_calculo
                         INNER JOIN arrecadacao.calculo_cgm as accgm
                         ON accgm.cod_calculo = c.cod_calculo
                         INNER JOIN monetario.credito as mc
                         ON mc.cod_credito = c.cod_credito
                         AND mc.cod_especie = c.cod_especie
                         AND mc.cod_genero = c.cod_genero
                         AND mc.cod_natureza = c.cod_natureza
                         LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
                         ON acgc.cod_calculo = c.cod_calculo
                         LEFT JOIN arrecadacao.grupo_credito as agc
                         ON agc.cod_grupo = acgc.cod_grupo
                         AND agc.ano_exercicio = acgc.ano_exercicio
                      WHERE  pagamento_lote.cod_lote = :lote AND pagamento_lote.exercicio = :exercicio AND
     pagamento.cod_convenio != -1
                 ) as tabela
             ) as tabela2
         ORDER BY
             exercicio, cod_lancamento, nr_parcela";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':lote', $lote->getCodLote());
        $sth->bindValue(':exercicio', $lote->getExercicio());
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param Lote $lote
     * @return array
     */
    public function getPagamentosGrupoCredito(Lote $lote)
    {
        $query = "
            SELECT
          tabela2.*,
          tabela2.valor_pago_calculo + tabela2.juros + tabela2.multa + tabela2.diferenca + tabela2.correcao as valor_pago_normal
     FROM
         (
             SELECT
                 tabela.*
                    , ( SELECT coalesce (sum(valor), 0.00) as juros
                      FROM
                         arrecadacao.pagamento_acrescimo
                     WHERE
                         cod_tipo = 1
                         and numeracao = tabela.numeracao
                         and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                         and cod_convenio = tabela.cod_convenio
                 )::numeric(14,2) as correcao

        , COALESCE(
        ( SELECT
            sum(valor)
            FROM
            arrecadacao.pagamento_diferenca
            WHERE
                pagamento_diferenca.numeracao        = tabela.numeracao
            AND pagamento_diferenca.cod_convenio         = tabela.cod_convenio
            AND pagamento_diferenca.ocorrencia_pagamento = tabela.ocorrencia_pagamento
        ), 0.00
          )::numeric(14,2) AS diferenca
                 , ( SELECT coalesce (sum(valor), 0.00) as juros
                     FROM
                         arrecadacao.pagamento_acrescimo
                     WHERE
                         cod_tipo = 2
                         and numeracao = tabela.numeracao
                         and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                         and cod_convenio = tabela.cod_convenio
                 )::numeric(14,2) as juros
                 , ( select coalesce ( ( aplica_juro (
                                             tabela.numeracao
                                             , tabela.exercicio
                                             , tabela.cod_parcela
                                             , tabela.data_pagamento )
                                         * arrecadacao.calculaProporcaoParcela(
                                                 tabela.cod_parcela )
                                         )
                                         , 0.00 )
                 )::numeric(14,2) as juros_calculado
                 , ( select coalesce (sum(valor), 0.00) as multa
                     from arrecadacao.pagamento_acrescimo
                     where cod_tipo = 3
                     and numeracao = tabela.numeracao
                     and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                     and cod_convenio = tabela.cod_convenio
                 )::numeric(14,2) as multa
                 , ( select coalesce ((aplica_multa (
                                         tabela.numeracao
                                         , tabela.exercicio
                                         , tabela.cod_parcela
                                         , tabela.data_pagamento )
                                     * arrecadacao.calculaProporcaoParcela(
                                                             tabela.cod_parcela )
                                     ), 0.00 )
                 )::numeric(14,2) as multa_calculada
                 , arrecadacao.fn_busca_soma_pagamento_calculo(
                             tabela.numeracao
                             , tabela.cod_convenio
                             , tabela.ocorrencia_pagamento
                 )::numeric(14,2) as valor_pago_calculo
                 , arrecadacao.buscaContribuinteLancamento( tabela.cod_lancamento
                 ) as contribuinte
                 , (
                     SELECT atp2.cod_tipo
                     FROM arrecadacao.tipo_pagamento as atp2
                         INNER JOIN arrecadacao.pagamento as apag2
                         ON apag2.cod_tipo = atp2.cod_tipo
                     WHERE
                         apag2.numeracao = tabela.numeracao
                         AND apag2.cod_convenio = tabela.cod_convenio
                         AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento
                 ) as cod_tipo_pagamento
                 , (
                     SELECT atp2.nom_resumido
                     FROM arrecadacao.tipo_pagamento as atp2
                         INNER JOIN arrecadacao.pagamento as apag2
                         ON apag2.cod_tipo = atp2.cod_tipo
                     WHERE
                         apag2.numeracao = tabela.numeracao
                         AND apag2.cod_convenio = tabela.cod_convenio
                         AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento
                 ) as nom_tipo
             FROM
                 (
                     SELECT DISTINCT
                         arrecadacao.buscaVinculoLancamento ( parcela.cod_lancamento, pagamento_lote.exercicio::int
                         ),
                         lote.cod_lote
                         , to_char(lote.data_lote, 'dd/mm/YYYY') as data_lote
                         , to_char(pagamento.data_pagamento, 'dd/mm/YYYY'
                         ) as data_pagamento_br
                         , pagamento.data_pagamento
                         , atp.cod_tipo
                         , atp.nom_resumido as nom_tipo
                         , carne.numeracao
                         , carne.cod_convenio
                         , carne.exercicio::int
                         , pagamento.ocorrencia_pagamento
                         , cgm.numcgm
                         , cgm.nom_cgm
                         , parcela.cod_parcela
                         , parcela.cod_lancamento
                         , parcela.nr_parcela
                         , pagamento.valor as valor_pago_normal
                         , now()::date as hoje
                         , ali.numeracao as inconsistencia_numeracao
                         , arrecadacao.fn_info_parcela (parcela.cod_parcela) as info_parcela
                         , arrecadacao.buscaInscricaoLancamento( parcela.cod_lancamento
                         ) as inscricao
                         , arrecadacao.buscaVinculoLancamento ( parcela.cod_lancamento, pagamento_lote.exercicio::int
                         ) as origem
                     FROM
                         arrecadacao.lote
                         INNER JOIN arrecadacao.pagamento_lote
                         ON pagamento_lote.cod_lote = lote.cod_lote
                         AND pagamento_lote.exercicio = lote.exercicio
                         INNER JOIN arrecadacao.pagamento
                         ON pagamento.numeracao = pagamento_lote.numeracao
                         AND pagamento.ocorrencia_pagamento
                             = pagamento_lote.ocorrencia_pagamento
                         AND pagamento.cod_convenio = pagamento_lote.cod_convenio
                         INNER JOIN arrecadacao.tipo_pagamento as atp
                         ON atp.cod_tipo = pagamento.cod_tipo
                         INNER JOIN arrecadacao.carne
                         ON carne.numeracao = pagamento_lote.numeracao
                         AND carne.cod_convenio = pagamento_lote.cod_convenio
                         INNER JOIN arrecadacao.parcela
                         ON  parcela.cod_parcela = carne.cod_parcela
                         INNER JOIN sw_cgm as cgm
                         ON cgm.numcgm = pagamento.numcgm
                         LEFT JOIN arrecadacao.lote_inconsistencia as ali
                         ON ali.numeracao = carne.numeracao
                         AND pagamento.ocorrencia_pagamento = ali.ocorrencia
                         AND ali.exercicio = carne.exercicio
                         AND ali.cod_lote = lote.cod_lote
                         INNER JOIN arrecadacao.lancamento_calculo as alc
                         ON alc.cod_lancamento = parcela.cod_lancamento
                         INNER JOIN arrecadacao.calculo as c
                         ON c.cod_calculo = alc.cod_calculo
                         INNER JOIN arrecadacao.calculo_cgm as accgm
                         ON accgm.cod_calculo = c.cod_calculo
                         INNER JOIN monetario.credito as mc
                         ON mc.cod_credito = c.cod_credito
                         AND mc.cod_especie = c.cod_especie
                         AND mc.cod_genero = c.cod_genero
                         AND mc.cod_natureza = c.cod_natureza
                         LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
                         ON acgc.cod_calculo = c.cod_calculo
                         LEFT JOIN arrecadacao.grupo_credito as agc
                         ON agc.cod_grupo = acgc.cod_grupo
                         AND agc.ano_exercicio = acgc.ano_exercicio
                      WHERE  pagamento_lote.cod_lote = :lote AND pagamento_lote.exercicio = :exercicio AND
     pagamento.cod_convenio != -1
                 ) as tabela
             ) as tabela2
         ORDER BY
             exercicio, cod_lancamento, nr_parcela";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':lote', $lote->getCodLote());
        $sth->bindValue(':exercicio', $lote->getExercicio());
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_GROUP);
    }

    /**
     * @param Lote $lote
     * @return array
     */
    public function getPagamentosCredito(Lote $lote)
    {
        $query = "
            SELECT
                tabela2.*,
                tabela2.valor_pago_calculo + tabela2.juros + tabela2.multa + tabela2.diferenca + tabela2.correcao as valor_pago_normal

            FROM
                (
                    SELECT
                        tabela.*

                        , ( SELECT coalesce (sum(valor), 0.00) as juros
                            FROM
                                arrecadacao.pagamento_acrescimo
                            WHERE
                                cod_tipo = 1
                                and numeracao = tabela.numeracao
                                and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                                and cod_convenio = tabela.cod_convenio
                                and cod_calculo = tabela.cod_calculo
                        )::numeric(14,2) as correcao

                        , ( SELECT coalesce (sum(valor), 0.00) as juros
                            FROM
                                arrecadacao.pagamento_acrescimo
                            WHERE
                                cod_tipo = 2
                                and numeracao = tabela.numeracao
                                and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                                and cod_convenio = tabela.cod_convenio
                                and cod_calculo = tabela.cod_calculo
                        )::numeric(14,2) as juros

                        , ( select coalesce (sum(valor), 0.00) as multa
                            from arrecadacao.pagamento_acrescimo
                            where cod_tipo = 3
                            and numeracao = tabela.numeracao
                            and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                            and cod_convenio = tabela.cod_convenio
                            and cod_calculo = tabela.cod_calculo
                        )::numeric(14,2) as multa
                        , arrecadacao.buscaContribuinteLancamento( tabela.cod_lancamento ) as contribuinte
                        , (
                            SELECT atp2.cod_tipo
                            FROM arrecadacao.tipo_pagamento as atp2
                                INNER JOIN arrecadacao.pagamento as apag2
                                ON apag2.cod_tipo = atp2.cod_tipo
                            WHERE
                                apag2.numeracao = tabela.numeracao
                                AND apag2.cod_convenio = tabela.cod_convenio
                                AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento
                        ) as cod_tipo_pagamento
                        , (
                            SELECT atp2.nom_resumido
                            FROM arrecadacao.tipo_pagamento as atp2
                                INNER JOIN arrecadacao.pagamento as apag2
                                ON apag2.cod_tipo = atp2.cod_tipo
                            WHERE
                                apag2.numeracao = tabela.numeracao
                                AND apag2.cod_convenio = tabela.cod_convenio
                                AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento
                        ) as nom_tipo
                    FROM
                        (
                            SELECT DISTINCT
                                CONCAT(agc.cod_grupo, ' - ', agc.descricao) AS grupo_credito,
                                lote.cod_lote
                                , to_char(lote.data_lote, 'dd/mm/YYYY') as data_lote
                                , to_char(pagamento.data_pagamento, 'dd/mm/YYYY'
                                ) as data_pagamento_br
                                , pagamento.data_pagamento
                                , atp.cod_tipo
                                , atp.nom_resumido as nom_tipo
                                , carne.numeracao
                                , carne.cod_convenio
                                , carne.exercicio::int
                                , pagamento.ocorrencia_pagamento
                                , cgm.numcgm
                                , cgm.nom_cgm
                                , parcela.cod_parcela
                                , parcela.cod_lancamento
                                , parcela.nr_parcela
                                , pagamento_calculo.valor as valor_pago_calculo


                                , COALESCE(
                                    ( SELECT
                                            sum(valor)
                                        FROM
                                            arrecadacao.pagamento_diferenca
                                        WHERE
                                            pagamento_diferenca.numeracao = pagamento.numeracao
                                            AND pagamento_diferenca.cod_convenio = pagamento.cod_convenio
                                            AND pagamento_diferenca.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                                            AND pagamento_diferenca.cod_calculo = pagamento_calculo.cod_calculo
                                    ), 0.00
                                  )AS diferenca

                                , now()::date as hoje
                                , ali.numeracao as inconsistencia_numeracao
                                , arrecadacao.fn_info_parcela (parcela.cod_parcela) as info_parcela
                                , arrecadacao.buscaInscricaoLancamento( parcela.cod_lancamento
                                ) as inscricao
                                , c.cod_calculo
                                , c.cod_credito ||'.'|| c.cod_especie ||'.'|| c.cod_genero ||'.'|| c.cod_natureza as origem
                                , mc.descricao_credito

                            FROM
                                arrecadacao.lote
                                INNER JOIN arrecadacao.pagamento_lote
                                ON pagamento_lote.cod_lote = lote.cod_lote
                                AND pagamento_lote.exercicio = lote.exercicio
                                INNER JOIN arrecadacao.pagamento
                                ON pagamento.numeracao = pagamento_lote.numeracao
                                AND pagamento.ocorrencia_pagamento
                                    = pagamento_lote.ocorrencia_pagamento
                                AND pagamento.cod_convenio = pagamento_lote.cod_convenio


                                INNER JOIN arrecadacao.tipo_pagamento as atp
                                ON atp.cod_tipo = pagamento.cod_tipo
                                INNER JOIN arrecadacao.carne
                                ON carne.numeracao = pagamento_lote.numeracao
                                AND carne.cod_convenio = pagamento_lote.cod_convenio
                                INNER JOIN arrecadacao.parcela
                                ON  parcela.cod_parcela = carne.cod_parcela
                                INNER JOIN sw_cgm as cgm
                                ON cgm.numcgm = pagamento.numcgm
                                LEFT JOIN arrecadacao.lote_inconsistencia as ali
                                ON ali.numeracao = carne.numeracao
                                AND pagamento.ocorrencia_pagamento = ali.ocorrencia
                                AND ali.exercicio = carne.exercicio
                                AND ali.cod_lote = lote.cod_lote
                                INNER JOIN arrecadacao.lancamento_calculo as alc
                                ON alc.cod_lancamento = parcela.cod_lancamento

                                INNER JOIN arrecadacao.calculo as c
                                ON c.cod_calculo = alc.cod_calculo

                                INNER JOIN arrecadacao.pagamento_calculo
                                ON pagamento_calculo.numeracao = pagamento_lote.numeracao
                                AND pagamento_calculo.ocorrencia_pagamento = pagamento_lote.ocorrencia_pagamento
                                AND pagamento_calculo.cod_convenio = pagamento_lote.cod_convenio
                                AND pagamento_calculo.cod_calculo = c.cod_calculo


                                INNER JOIN monetario.credito as mc
                                ON mc.cod_credito = c.cod_credito
                                AND mc.cod_especie = c.cod_especie
                                AND mc.cod_genero = c.cod_genero
                                AND mc.cod_natureza = c.cod_natureza
                                LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
                                ON acgc.cod_calculo = c.cod_calculo
                                LEFT JOIN arrecadacao.grupo_credito as agc
                                ON agc.cod_grupo = acgc.cod_grupo
                                AND agc.ano_exercicio = acgc.ano_exercicio
                      WHERE pagamento_lote.cod_lote = :lote

     AND acgc.cod_grupo = 01
     and acgc.cod_grupo is not null
     AND c.exercicio = :exercicio AND pagamento.cod_convenio != -1
                 ) as tabela
             ) as tabela2
         ORDER BY
             exercicio, cod_lancamento, nr_parcela;
            ";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':lote', $lote->getCodLote());
        $sth->bindValue(':exercicio', $lote->getExercicio());
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_GROUP);
    }

    /**
     * @param Lote $lote
     * @return array
     */
    public function getLoteInfo(Lote $lote)
    {
        $query = "
            SELECT
                 l.cod_lote
                 , to_char(l.data_lote, 'dd/mm/YYYY') as data_lote
                 , to_char(arrecadacao.dtBaixaLote(l.cod_lote, l.exercicio::int),'dd/mm/YYYY') as data_baixa
                 , mb.cod_banco
                 , mb.num_banco
                 , mb.nom_banco
                 , ma.cod_agencia
                 , ma.num_agencia
                 , ma.nom_agencia
                 , l.exercicio, now() as hoje
                 , la.nom_arquivo
                 ,( select count(0) from arrecadacao.pagamento_lote where cod_lote=l.cod_lote) as registros,
                 cgm.numcgm,
                 cgm.nom_cgm
             FROM
                 arrecadacao.lote as l
                 INNER JOIN monetario.banco as mb ON mb.cod_banco = l.cod_banco
                 INNER JOIN monetario.agencia as ma
                 ON ma.cod_agencia = l.cod_agencia and mb.cod_banco = ma.cod_banco
                 LEFT JOIN arrecadacao.lote_arquivo as la ON la.cod_lote = l.cod_lote
                 LEFT JOIN sw_cgm as cgm ON cgm.numcgm = l.numcgm
             WHERE  l.cod_lote= :lote and l.exercicio= :exercicio;
            ";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':lote', $lote->getCodLote());
        $sth->bindValue(':exercicio', $lote->getExercicio());
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param Lote $lote
     * @return array
     */
    public function getInconsistencias(Lote $lote)
    {
        $query = "
            select
                 li.numeracao
                 , to_char ( li.data_pagamento, 'dd/mm/yyyy' ) as data_pagamento
                 , replace ( li.valor::varchar,'.',',' ) as valor
             from
                 arrecadacao.lote_inconsistencia li
             WHERE li.exercicio = :exercicio AND li.cod_lote = :lote;
            ";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':lote', $lote->getCodLote());
        $sth->bindValue(':exercicio', $lote->getExercicio());
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function getListaLotes($filter)
    {
        $query = "SELECT DISTINCT                                                                     
         lote.cod_lote                                                                   
         , to_char(lote.data_lote, 'dd/mm/YYYY') as data_lote                            
         , to_char(pagamento.data_pagamento, 'dd/mm/YYYY') as data_pagamento             
         , to_char(pagamento.data_baixa, 'dd/mm/YYYY') as data_baixa                     
         , lote.exercicio                                                                
     FROM                                                                                
         arrecadacao.lote                                                                
         LEFT JOIN  monetario.agencia                                                   
         ON lote.cod_agencia = agencia.cod_agencia                                       
         AND lote.cod_banco = agencia.cod_banco                                          
         LEFT JOIN monetario.banco                                                      
         ON lote.cod_banco = banco.cod_banco                                             
         LEFT JOIN arrecadacao.pagamento_lote                                           
         ON pagamento_lote.cod_lote = lote.cod_lote                                      
         AND pagamento_lote.exercicio = lote.exercicio                                   
         LEFT JOIN arrecadacao.pagamento                                                
         ON pagamento.numeracao = pagamento_lote.numeracao                               
         AND pagamento.ocorrencia_pagamento = pagamento_lote.ocorrencia_pagamento        
         AND pagamento.cod_convenio = pagamento_lote.cod_convenio                        
         LEFT JOIN arrecadacao.tipo_pagamento                                           
         ON tipo_pagamento.cod_tipo = pagamento.cod_tipo                                 
         LEFT JOIN arrecadacao.lote_inconsistencia as ali                                
         ON  ali.cod_lote = lote.cod_lote                                                
         AND ali.exercicio = lote.exercicio       
         where 1 = 1";

        if (isset($filter['exercicio'])) {
            $query .= " AND lote.exercicio = :exercicio";
        }

        if (isset($filter['numBanco'])) {
            $query .= " AND banco.num_banco = :numBanco";
        }

        if (isset($filter['codAgencia'])) {
            $query .= " agencia.num_agencia = :numAgencia";
        }

        if (isset($filter['tipoLote']) && !empty($filter['tipoLote'])) {
            $query .= " AND lote.automatico = :tipoLote";
        }

        if (isset($filter['codLote']) && !isset($filter['codLoteFinal']) || !isset($filter['codLote']) && isset($filter['codLoteFinal'])) {
            $query .= " AND lote.cod_lote = :cod_lote";
        }

        if (isset($filter['codLote']) && isset($filter['codLoteFinal'])) {
            $query .= " AND lote.cod_lote BETWEEN :codLote and :codLoteFinal";
        }

        if (isset($filter['dataLoteInicial']) && !isset($filter['dataLoteFinal']) || !isset($filter['dataLoteInicial']) && isset($filter['dataLoteFinal'])) {
            $query .= " AND lote.data_lote = :dataLote";
        }

        if (isset($filter['dataLoteInicial']) && isset($filter['dataLoteFinal'])) {
            $query .= " AND lote.data_lote BETWEEN :dataLoteInicial AND :dataLoteFinal";
        }

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);

        if (isset($filter['numBanco'])) {
            $sth->bindValue(':numBanco', $filter['numBanco'], \PDO::PARAM_STR);
        }

        if (isset($filter['codAgencia'])) {
            $sth->bindValue(':numAgencia', $filter['codAgencia'], \PDO::PARAM_STR);
        }

        if (isset($filter['exercicio'])) {
            $sth->bindValue(':exercicio', $filter['exercicio'], \PDO::PARAM_STR);
        }

        if (isset($filter['tipoLote']) && !empty($filter['tipoLote'])) {
            $sth->bindValue(':tipoLote', $filter['tipoLote'], \PDO::PARAM_BOOL);
        }

        if (isset($filter['exercicio'])) {
            $sth->bindValue(':exercicio', $filter['exercicio'], \PDO::PARAM_STR);
        }

        if (isset($filter['codLote']) && !isset($filter['codLoteFinal']) || !isset($filter['codLote']) && isset($filter['codLoteFinal'])) {
            $sth->bindValue(':codLote', (isset($filter['codLote']) ? $filter['codLote'] : $filter['codLoteFinal']), \PDO::PARAM_INT);
        }

        if (isset($filter['codLote']) && isset($filter['codLoteFinal'])) {
            $sth->bindValue(':codLote', $filter['codLote'], \PDO::PARAM_INT);
            $sth->bindValue(':codLoteFinal', $filter['codLoteFinal'], \PDO::PARAM_INT);
        }

        if (isset($filter['dataLoteInicial']) && !isset($filter['dataLoteFinal']) || !isset($filter['dataLoteInicial']) && isset($filter['dataLoteFinal'])) {
            $sth->bindValue(':dataLote', (isset($filter['dataLoteInicial']) ? $filter['dataLoteInicial']['date'] : $filter['dataLoteFinal']['date']), \PDO::PARAM_STR);
        }

        if (isset($filter['dataLoteInicial']) && isset($filter['dataLoteFinal'])) {
            $sth->bindValue(':dataLoteInicial', $filter['dataLoteInicial']['date'], \PDO::PARAM_STR);
            $sth->bindValue(':dataLoteFinal', $filter['dataLoteFinal']['date'], \PDO::PARAM_STR);
        }

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param $lotes
     * @return array
     */
    public function getListaResumoLotesOrigem($lotes)
    {
        $exercicio = current($lotes)['exercicio'];

        $codLotes = implode(',', array_unique(array_column($lotes, 'cod_lote')));

        $query = "select
                *
            from
                (
                    select
                        (
                            case
                                when agc.cod_grupo is not null then 'grupo'
                                else 'credito'
                            end
                        ) as tipo,
                        (
                            case
                                when agc.cod_grupo is not null then LPAD(
                                    agc.cod_grupo::varchar,
                                    (
                                        select
                                            length(
                                                max( cod_grupo )::varchar
                                            ) as valor
                                        from
                                            arrecadacao.grupo_credito
                                    ),
                                    '0'
                                )::varchar
                                else split_part(
                                    monetario.fn_busca_mascara_credito(
                                        mc.cod_credito,
                                        mc.cod_especie,
                                        mc.cod_genero,
                                        mc.cod_natureza
                                    ),
                                    '§',
                                    1
                                )::varchar
                            end
                        ) as origem,
                        case
                            when al.divida = true then(
                                case
                                    when agc.cod_grupo is not null then agc.descricao || '(D.A.)'
                                    else mc.descricao_credito || '(D.A.)'
                                end
                            )
                            else(
                                case
                                    when agc.cod_grupo is not null then agc.descricao
                                    else mc.descricao_credito
                                end
                            )
                        end as descricao,
                        calc.exercicio as origem_exercicio,
                        carne.cod_convenio,
                        numeracoes.tipo_numeracao
                    from
                        (
                            select
                                cod_lote,
                                exercicio as lote_exercicio,
                                numeracao,
                                tipo_numeracao
                            from
                                (
                                    select
                                        lote.cod_lote,
                                        lote.exercicio,
                                        plote.numeracao,
                                        'PAGAMENTO'::varchar as tipo_numeracao
                                    from
                                        arrecadacao.lote inner join arrecadacao.pagamento_lote as plote on
                                        plote.cod_lote = lote.cod_lote
                                        and plote.exercicio = lote.exercicio
                                    where
                                        lote.exercicio = :exercicio
                                        and lote.cod_lote in($codLotes)
                                union select
                                        lote.cod_lote,
                                        lote.exercicio,
                                        ali.numeracao,
                                        'INCONSISTENCIA'::varchar as tipo_numeracao
                                    from
                                        arrecadacao.lote inner join arrecadacao.lote_inconsistencia as ali on
                                        ali.cod_lote = lote.cod_lote
                                        and ali.exercicio = lote.exercicio
                                    where
                                        lote.exercicio = :exercicio
                                        and lote.cod_lote in($codLotes)
                                ) as numeracoes
                        ) as numeracoes inner join arrecadacao.carne on
                        carne.numeracao = numeracoes.numeracao --AND carne.exercicio = numeracoes.lote_exercicio
                        inner join arrecadacao.parcela as ap on
                        ap.cod_parcela = carne.cod_parcela inner join arrecadacao.lancamento_calculo as alc on
                        alc.cod_lancamento = ap.cod_lancamento inner join arrecadacao.lancamento as al on
                        al.cod_lancamento = ap.cod_lancamento left join arrecadacao.calculo as calc on
                        calc.cod_calculo = alc.cod_calculo left join monetario.credito as mc on
                        mc.cod_credito = calc.cod_credito
                        and mc.cod_especie = calc.cod_especie
                        and mc.cod_genero = calc.cod_genero
                        and mc.cod_natureza = calc.cod_natureza left join arrecadacao.calculo_grupo_credito as acgc on
                        acgc.cod_calculo = calc.cod_calculo left join arrecadacao.grupo_credito as agc on
                        agc.cod_grupo = acgc.cod_grupo
                        and agc.ano_exercicio = acgc.ano_exercicio
                    group by
                        agc.cod_grupo,
                        agc.descricao,
                        mc.descricao_credito,
                        mc.cod_credito,
                        mc.cod_especie,
                        mc.cod_genero,
                        mc.cod_natureza,
                        calc.exercicio,
                        al.divida,
                        carne.cod_convenio,
                        numeracoes.tipo_numeracao
                    order by
                        tipo,
                        calc.exercicio,
                        descricao
                ) as origem
            group by
                origem.tipo,
                origem.origem,
                origem.descricao,
                origem.origem_exercicio,
                origem.cod_convenio,
                origem.tipo_numeracao;";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);

        $sth->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param $lotes
     * @param $origem
     * @return mixed
     */
    public function getListaPagamentosLote($lotes, $origem)
    {
        $codLotes = implode(',', array_unique(array_column($lotes, 'cod_lote')));

        $filter = "WHERE pagamento_lote.cod_lote IN ($codLotes)";

        if ($origem['tipo'] == 'grupo') {
            $filter .= " AND acgc.cod_grupo = :codGrupo";
            $filter .= " AND acgc.cod_grupo is not null";
            $filter .= " AND c.exercicio = :origemExercicio";
        }

        if ($origem['tipo'] != 'grupo') {
            $filter .= " AND c.exercicio = :origemExercicio";
            $filter .= " AND c.cod_credito = :codCredito";
            $filter .= " AND c.cod_especie = :codEspecie";
            $filter .= " AND c.cod_genero = :codGenero";
            $filter .= " AND c.cod_natureza = :codNatureza";
            $filter .= " AND acgc.cod_grupo is null";
        }

        $filter .= ' AND pagamento.cod_convenio != -1';

        $query = "SELECT                                                                                  
              tabela2.*                                                                           
         FROM                                                                                    
             (                                                                                   
                 SELECT                                                                          
                     tabela.*                                                                    
                        , ( SELECT coalesce (sum(valor), 0.00) as juros                          
                          FROM                                                                   
                             arrecadacao.pagamento_acrescimo                                     
                         WHERE                                                                   
                             cod_tipo = 1                                                        
                             and numeracao = tabela.numeracao                                    
                             and ocorrencia_pagamento = tabela.ocorrencia_pagamento               
                             and cod_convenio = tabela.cod_convenio                              
                     )::numeric(14,2) as correcao                                                
                                                                                                 
            , COALESCE(                                                                          
            ( SELECT                                                                                
                sum(valor)                                                                          
                FROM                                                                                
                arrecadacao.pagamento_diferenca                                                     
                WHERE                                                                               
                    pagamento_diferenca.numeracao 	     = tabela.numeracao                         
                AND pagamento_diferenca.cod_convenio 	     = tabela.cod_convenio                  
                AND pagamento_diferenca.ocorrencia_pagamento = tabela.ocorrencia_pagamento          
            ), 0.00                                                                                 
              )::numeric(14,2) AS diferenca                                                                      
                     , ( SELECT coalesce (sum(valor), 0.00) as juros                             
                         FROM                                                                    
                             arrecadacao.pagamento_acrescimo                                     
                         WHERE                                                                   
                             cod_tipo = 2                                                        
                             and numeracao = tabela.numeracao                                    
                             and ocorrencia_pagamento = tabela.ocorrencia_pagamento              
                             and cod_convenio = tabela.cod_convenio                              
                     )::numeric(14,2) as juros                                                   
                     , ( select coalesce ( ( aplica_juro (                                       
                                                 tabela.numeracao                                
                                                 , tabela.exercicio                              
                                                 , tabela.cod_parcela                            
                                                 , tabela.data_pagamento )                       
                                             * arrecadacao.calculaProporcaoParcela(              
                                                     tabela.cod_parcela )                        
                                             )                                                   
                                             , 0.00 )                                            
                     )::numeric(14,2) as juros_calculado                                         
                     , ( select coalesce (sum(valor), 0.00) as multa                             
                         from arrecadacao.pagamento_acrescimo                                    
                         where cod_tipo = 3                                                      
                         and numeracao = tabela.numeracao                                        
                         and ocorrencia_pagamento = tabela.ocorrencia_pagamento                  
                         and cod_convenio = tabela.cod_convenio                                  
                     )::numeric(14,2) as multa                                                   
                     , ( select coalesce ((aplica_multa (                                        
                                             tabela.numeracao                                    
                                             , tabela.exercicio                                  
                                             , tabela.cod_parcela                                
                                             , tabela.data_pagamento )                           
                                         * arrecadacao.calculaProporcaoParcela(                  
                                                                 tabela.cod_parcela )            
                                         ), 0.00 )                                               
                     )::numeric(14,2) as multa_calculada                                         
                     , arrecadacao.fn_busca_soma_pagamento_calculo(                              
                                 tabela.numeracao                                                
                                 , tabela.cod_convenio                                           
                                 , tabela.ocorrencia_pagamento                                   
                     )::numeric(14,2) as valor_pago_calculo                                                     
                     , arrecadacao.buscaContribuinteLancamento( tabela.cod_lancamento            
                     ) as contribuinte                                                           
                     , (                                                                         
                         SELECT atp2.cod_tipo                                                    
                         FROM arrecadacao.tipo_pagamento as atp2                                 
                             INNER JOIN arrecadacao.pagamento as apag2                           
                             ON apag2.cod_tipo = atp2.cod_tipo                                   
                         WHERE                                                                   
                             apag2.numeracao = tabela.numeracao                                  
                             AND apag2.cod_convenio = tabela.cod_convenio                        
                             AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento        
                     ) as cod_tipo_pagamento                                                     
                     , (                                                                         
                         SELECT atp2.nom_resumido                                                
                         FROM arrecadacao.tipo_pagamento as atp2                                 
                             INNER JOIN arrecadacao.pagamento as apag2                           
                             ON apag2.cod_tipo = atp2.cod_tipo                                   
                         WHERE                                                                   
                             apag2.numeracao = tabela.numeracao                                  
                             AND apag2.cod_convenio = tabela.cod_convenio                        
                             AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento        
                     ) as nom_tipo                                                               
                 FROM                                                                            
                     (                                                                           
                         SELECT DISTINCT                                                         
                             lote.cod_lote                                                       
                             , to_char(lote.data_lote, 'dd/mm/YYYY') as data_lote                
                             , to_char(pagamento.data_pagamento, 'dd/mm/YYYY'                    
                             ) as data_pagamento_br                                              
                             , pagamento.data_pagamento                                          
                             , atp.cod_tipo                                                      
                             , atp.nom_resumido as nom_tipo                                      
                             , carne.numeracao                                                   
                             , carne.cod_convenio                                                
                             , carne.exercicio::int                                              
                             , pagamento.ocorrencia_pagamento                                    
                             , cgm.numcgm                                                        
                             , cgm.nom_cgm                                                       
                             , parcela.cod_parcela                                               
                             , parcela.cod_lancamento                                            
                             , parcela.nr_parcela                                                
                             , pagamento.valor as valor_pago_normal                              
                             , now()::date as hoje                                               
                             , ali.numeracao as inconsistencia_numeracao                         
                             , arrecadacao.fn_info_parcela (parcela.cod_parcela) as info_parcela 
                             , arrecadacao.buscaInscricaoLancamento( parcela.cod_lancamento      
                             ) as inscricao                                                      
                             , arrecadacao.buscaVinculoLancamento ( parcela.cod_lancamento       
                             ) as origem                                                         
                         FROM                                                                    
                             arrecadacao.lote                                                    
                             INNER JOIN arrecadacao.pagamento_lote                               
                             ON pagamento_lote.cod_lote = lote.cod_lote                          
                             AND pagamento_lote.exercicio = lote.exercicio                       
                             INNER JOIN arrecadacao.pagamento                                    
                             ON pagamento.numeracao = pagamento_lote.numeracao                   
                             AND pagamento.ocorrencia_pagamento                                  
                                 = pagamento_lote.ocorrencia_pagamento                           
                             AND pagamento.cod_convenio = pagamento_lote.cod_convenio            
                             INNER JOIN arrecadacao.tipo_pagamento as atp                        
                             ON atp.cod_tipo = pagamento.cod_tipo                                
                             INNER JOIN arrecadacao.carne                                        
                             ON carne.numeracao = pagamento_lote.numeracao                       
                             AND carne.cod_convenio = pagamento_lote.cod_convenio                
                             INNER JOIN arrecadacao.parcela                                      
                             ON  parcela.cod_parcela = carne.cod_parcela                         
                             INNER JOIN sw_cgm as cgm                                            
                             ON cgm.numcgm = pagamento.numcgm                                    
                             LEFT JOIN arrecadacao.lote_inconsistencia as ali                    
                             ON ali.numeracao = carne.numeracao                                  
                             AND pagamento.ocorrencia_pagamento = ali.ocorrencia                 
                             AND ali.exercicio = carne.exercicio                                 
                             AND ali.cod_lote = lote.cod_lote                                    
                             INNER JOIN arrecadacao.lancamento_calculo as alc                    
                             ON alc.cod_lancamento = parcela.cod_lancamento                      
                             INNER JOIN arrecadacao.calculo as c                                 
                             ON c.cod_calculo = alc.cod_calculo                                  
                             INNER JOIN arrecadacao.calculo_cgm as accgm                         
                             ON accgm.cod_calculo = c.cod_calculo                                
                             INNER JOIN monetario.credito as mc                                  
                             ON mc.cod_credito = c.cod_credito                                   
                             AND mc.cod_especie = c.cod_especie                                  
                             AND mc.cod_genero = c.cod_genero                                    
                             AND mc.cod_natureza = c.cod_natureza                                
                             LEFT JOIN arrecadacao.calculo_grupo_credito as acgc                 
                             ON acgc.cod_calculo = c.cod_calculo                                 
                             LEFT JOIN arrecadacao.grupo_credito as agc                          
                             ON agc.cod_grupo = acgc.cod_grupo                                   
                             AND agc.ano_exercicio = acgc.ano_exercicio                          
                          $filter                                                         
                     ) as tabela                                                                 
                 ) as tabela2                                                                    
             ORDER BY                                                                            
                 exercicio, cod_lancamento, nr_parcela";


        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);

        if ($origem['tipo'] == 'grupo') {
            $sth->bindValue(':codGrupo', $origem['origem']);
            $sth->bindValue(':origemExercicio', $origem['origem_exercicio']);
        }

        if ($origem['tipo'] != 'grupo') {
            list($codCredito, $codEspecie, $codGenero, $codNatureza) = explode('.', $origem['origem']);

            $sth->bindValue(':origemExercicio', $origem['origem_exercicio']);
            $sth->bindValue(':codCredito', $codCredito);
            $sth->bindValue(':codEspecie', $codEspecie);
            $sth->bindValue(':codGenero', $codGenero);
            $sth->bindValue(':codNatureza', $codNatureza);
        }

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param $lotes
     * @param $origem
     * @return array
     */
    public function getListaPagamentosLoteAnalitico($lotes, $origem)
    {
        $codlotes = implode(',', array_unique(array_column($lotes, 'cod_lote')));

        $filter = "WHERE pagamento_lote.cod_lote IN ($codlotes)";

        if ($origem['tipo'] == 'grupo') {
            $filter .= " AND acgc.cod_grupo = :codGrupo";
            $filter .= " AND acgc.cod_grupo is not null";
            $filter .= " AND c.exercicio = :origemExercicio";
        }

        if ($origem['tipo'] != 'grupo') {
            $filter .= " AND c.exercicio = :origemExercicio";
            $filter .= " AND c.cod_credito = :codCredito";
            $filter .= " AND c.cod_especie = :codEspecie";
            $filter .= " AND c.cod_genero = :codGenero";
            $filter .= " AND c.cod_natureza = :codNatureza";
            $filter .= " AND acgc.cod_grupo is null";
        }

        $filter .= ' AND pagamento.cod_convenio != -1';

        $query = "SELECT
            tabela2.*,
            tabela2.valor_pago_calculo + tabela2.juros + tabela2.multa + tabela2.diferenca + tabela2.correcao as valor_pago_normal

        FROM
            (
                SELECT
                    tabela.*

                    , ( SELECT coalesce (sum(valor), 0.00) as juros
                        FROM
                            arrecadacao.pagamento_acrescimo
                        WHERE
                            cod_tipo = 1
                            and numeracao = tabela.numeracao
                            and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                            and cod_convenio = tabela.cod_convenio
                            and cod_calculo = tabela.cod_calculo
                    )::numeric(14,2) as correcao

                    , ( SELECT coalesce (sum(valor), 0.00) as juros
                        FROM
                            arrecadacao.pagamento_acrescimo
                        WHERE
                            cod_tipo = 2
                            and numeracao = tabela.numeracao
                            and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                            and cod_convenio = tabela.cod_convenio
                            and cod_calculo = tabela.cod_calculo
                    )::numeric(14,2) as juros

                    , ( select coalesce (sum(valor), 0.00) as multa
                        from arrecadacao.pagamento_acrescimo
                        where cod_tipo = 3
                        and numeracao = tabela.numeracao
                        and ocorrencia_pagamento = tabela.ocorrencia_pagamento
                        and cod_convenio = tabela.cod_convenio
                        and cod_calculo = tabela.cod_calculo
                    )::numeric(14,2) as multa
                    , arrecadacao.buscaContribuinteLancamento( tabela.cod_lancamento ) as contribuinte
                    , (
                        SELECT atp2.cod_tipo
                        FROM arrecadacao.tipo_pagamento as atp2
                            INNER JOIN arrecadacao.pagamento as apag2
                            ON apag2.cod_tipo = atp2.cod_tipo
                        WHERE
                            apag2.numeracao = tabela.numeracao
                            AND apag2.cod_convenio = tabela.cod_convenio
                            AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento
                    ) as cod_tipo_pagamento
                    , (
                        SELECT atp2.nom_resumido
                        FROM arrecadacao.tipo_pagamento as atp2
                            INNER JOIN arrecadacao.pagamento as apag2
                            ON apag2.cod_tipo = atp2.cod_tipo
                        WHERE
                            apag2.numeracao = tabela.numeracao
                            AND apag2.cod_convenio = tabela.cod_convenio
                            AND apag2.ocorrencia_pagamento = tabela.ocorrencia_pagamento
                    ) as nom_tipo
                FROM
                    (
                        SELECT DISTINCT
                            lote.cod_lote
                            , to_char(lote.data_lote, 'dd/mm/YYYY') as data_lote
                            , to_char(pagamento.data_pagamento, 'dd/mm/YYYY'
                            ) as data_pagamento_br
                            , pagamento.data_pagamento
                            , atp.cod_tipo
                            , atp.nom_resumido as nom_tipo
                            , carne.numeracao
                            , carne.cod_convenio
                            , carne.exercicio::int
                            , pagamento.ocorrencia_pagamento
                            , cgm.numcgm
                            , cgm.nom_cgm
                            , parcela.cod_parcela
                            , parcela.cod_lancamento
                            , parcela.nr_parcela
                            , pagamento_calculo.valor as valor_pago_calculo


                            , COALESCE(
                                ( SELECT
                                        sum(valor)
                                    FROM
                                        arrecadacao.pagamento_diferenca
                                    WHERE
                                        pagamento_diferenca.numeracao = pagamento.numeracao
                                        AND pagamento_diferenca.cod_convenio = pagamento.cod_convenio
                                        AND pagamento_diferenca.ocorrencia_pagamento = pagamento.ocorrencia_pagamento
                                        AND pagamento_diferenca.cod_calculo = pagamento_calculo.cod_calculo
                                ), 0.00
                              )AS diferenca

                            , now()::date as hoje
                            , ali.numeracao as inconsistencia_numeracao
                            , arrecadacao.fn_info_parcela (parcela.cod_parcela) as info_parcela
                            , arrecadacao.buscaInscricaoLancamento( parcela.cod_lancamento
                            ) as inscricao
                            , c.cod_calculo
                            , c.cod_credito ||'.'|| c.cod_especie ||'.'|| c.cod_genero ||'.'|| c.cod_natureza as origem
                            , mc.descricao_credito

                        FROM
                            arrecadacao.lote
                            INNER JOIN arrecadacao.pagamento_lote
                            ON pagamento_lote.cod_lote = lote.cod_lote
                            AND pagamento_lote.exercicio = lote.exercicio
                            INNER JOIN arrecadacao.pagamento
                            ON pagamento.numeracao = pagamento_lote.numeracao
                            AND pagamento.ocorrencia_pagamento
                                = pagamento_lote.ocorrencia_pagamento
                            AND pagamento.cod_convenio = pagamento_lote.cod_convenio


                            INNER JOIN arrecadacao.tipo_pagamento as atp
                            ON atp.cod_tipo = pagamento.cod_tipo
                            INNER JOIN arrecadacao.carne
                            ON carne.numeracao = pagamento_lote.numeracao
                            AND carne.cod_convenio = pagamento_lote.cod_convenio
                            INNER JOIN arrecadacao.parcela
                            ON  parcela.cod_parcela = carne.cod_parcela
                            INNER JOIN sw_cgm as cgm
                            ON cgm.numcgm = pagamento.numcgm
                            LEFT JOIN arrecadacao.lote_inconsistencia as ali
                            ON ali.numeracao = carne.numeracao
                            AND pagamento.ocorrencia_pagamento = ali.ocorrencia
                            AND ali.exercicio = carne.exercicio
                            AND ali.cod_lote = lote.cod_lote
                            INNER JOIN arrecadacao.lancamento_calculo as alc
                            ON alc.cod_lancamento = parcela.cod_lancamento

                            INNER JOIN arrecadacao.calculo as c
                            ON c.cod_calculo = alc.cod_calculo

                            INNER JOIN arrecadacao.pagamento_calculo
                            ON pagamento_calculo.numeracao = pagamento_lote.numeracao
                            AND pagamento_calculo.ocorrencia_pagamento = pagamento_lote.ocorrencia_pagamento
                            AND pagamento_calculo.cod_convenio = pagamento_lote.cod_convenio
                            AND pagamento_calculo.cod_calculo = c.cod_calculo


                            INNER JOIN monetario.credito as mc
                            ON mc.cod_credito = c.cod_credito
                            AND mc.cod_especie = c.cod_especie
                            AND mc.cod_genero = c.cod_genero
                            AND mc.cod_natureza = c.cod_natureza
                            LEFT JOIN arrecadacao.calculo_grupo_credito as acgc
                            ON acgc.cod_calculo = c.cod_calculo
                            LEFT JOIN arrecadacao.grupo_credito as agc
                            ON agc.cod_grupo = acgc.cod_grupo
                            AND agc.ano_exercicio = acgc.ano_exercicio                          
                          $filter                                                         
                     ) as tabela                                                               
                 ) as tabela2                                                                    
             ORDER BY                                                                            
                 exercicio, cod_lancamento, nr_parcela";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);

        if ($origem['tipo'] == 'grupo') {
            $sth->bindValue(':codGrupo', $origem['origem']);
            $sth->bindValue(':origemExercicio', $origem['origem_exercicio']);
        }

        if ($origem['tipo'] != 'grupo') {
            list($codCredito, $codEspecie, $codGenero, $codNatureza) = explode('.', $origem['origem']);

            $sth->bindValue(':origemExercicio', $origem['origem_exercicio']);
            $sth->bindValue(':codCredito', $codCredito);
            $sth->bindValue(':codEspecie', $codEspecie);
            $sth->bindValue(':codGenero', $codGenero);
            $sth->bindValue(':codNatureza', $codNatureza);
        }

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param $lotes
     * @param $origem
     * @return array
     */
    public function getResumoLoteListaInconsistenteAgrupado($lotes, $origem)
    {
        $exercicio = current($lotes)['exercicio'];

        $codlotes = implode(',', array_unique(array_column($lotes, 'cod_lote')));

        $filter = "WHERE ali.exercicio = :exercicio AND ali.cod_lote IN ($codlotes) ";

        if ($origem['tipo'] == 'grupo') {
            $filter .= " AND acgc.cod_grupo = :codGrupo";
            $filter .= " AND acgc.cod_grupo is not null";
            $filter .= " AND c.exercicio = :origemExercicio";
        }

        if ($origem['tipo'] != 'grupo') {
            $filter .= " AND c.exercicio = :origemExercicio";
            $filter .= " AND c.cod_credito = :codCredito";
            $filter .= " AND c.cod_especie = :codEspecie";
            $filter .= " AND c.cod_genero = :codGenero";
            $filter .= " AND c.cod_natureza = :codNatureza";
            $filter .= " AND acgc.cod_grupo is null";
        }

        $filter .= " AND carne.cod_convenio = :codConvenio";

        $query = " SELECT DISTINCT                                                                         
         tudo.numeracao                                                                      
         , tudo.origem                                                                       
         , tudo.cod_grupo                                                                   
         , tudo.descricao                                                                    
         , tudo.inscricao                                                                    
         , tudo.contribuinte                                                                 
         , tudo.exercicio                                                                    
         , tudo.data_pagamento                                                               
         , tudo.valor                                                                        
     FROM                                                                                    
     (                                                                                       
         SELECT                                                                              
              ali.numeracao                                                                   
              , ( CASE WHEN acgc.cod_grupo IS NOT NULL THEN                                   
                      agc.descricao                                                           
                  ELSE                                                                        
                      split_part ( monetario.fn_busca_mascara_credito( c.cod_credito,         
                      c.cod_especie, c.cod_genero, c.cod_natureza ), '§' , 1 )::varchar       
                  END                                                                         
              ) as origem                                                                     
              , acgc.cod_grupo                                                                
              , mc.descricao_credito as descricao                                             
              , c.exercicio                                                                   
              , ali.valor                                                                     
              , to_char(ali.data_pagamento, 'dd/mm/YYYY') as data_pagamento                   
              , arrecadacao.buscaInscricaoLancamento ( alc.cod_lancamento ) as inscricao      
              , descobreProprietarios ( alc.cod_lancamento ) as contribuinte                  
          FROM                                                                                
              arrecadacao.calculo c                                                           
              INNER JOIN (                                                                    
                  select                                                                      
                      max(cod_calculo) as cod_calculo                                         
                      , cod_lancamento                                                        
                  from                                                                        
                      arrecadacao.lancamento_calculo as alc                                   
                  GROUP BY cod_lancamento                                                     
              ) as alc                                                                        
              ON alc.cod_calculo = c.cod_calculo                                              
              INNER JOIN arrecadacao.calculo_cgm  as accgm                                    
              ON accgm.cod_calculo = c.cod_calculo                                            
              INNER JOIN sw_cgm as cgm                                                        
              ON cgm.numcgm = accgm.numcgm                                                    
              INNER JOIN arrecadacao.parcela as ap                                            
              ON ap.cod_lancamento = alc.cod_lancamento                                       
              INNER JOIN arrecadacao.carne as carne                                           
              ON carne.cod_parcela = ap.cod_parcela                                           
              INNER JOIN arrecadacao.lote_inconsistencia as ali                               
              ON ali.numeracao = carne.numeracao                                              
              LEFT JOIN arrecadacao.calculo_grupo_credito as acgc                             
              ON acgc.cod_calculo = c.cod_calculo                                             
              INNER JOIN monetario.credito mc                                                 
              ON mc.cod_credito = c.cod_credito                                               
              and mc.cod_especie = c.cod_especie                                              
              and mc.cod_genero = c.cod_genero                                                
              and mc.cod_natureza = c.cod_natureza                                            
              LEFT JOIN arrecadacao.grupo_credito as agc                                      
              ON agc.cod_grupo = acgc.cod_grupo                                               
              AND agc.ano_exercicio = acgc.ano_exercicio                                      
               $filter                                                                
          GROUP BY                                                                            
              ali.numeracao, ali.data_pagamento                                               
              , c.cod_credito, c.exercicio , acgc.cod_grupo                                   
              , c.cod_especie, c.cod_genero, c.cod_natureza                                   
              , mc.descricao_credito ,  agc.descricao                                         
              , alc.cod_lancamento, cgm.numcgm, cgm.nom_cgm                                   
              , ali.valor                                                                     
          ORDER BY                                                                            
              c.exercicio, acgc.cod_grupo desc, c.cod_credito                                 
     ) as tudo                                                                               
    ;";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);

        if ($origem['tipo'] == 'grupo') {
            $sth->bindValue(':codGrupo', $origem['origem']);
            $sth->bindValue(':origemExercicio', $origem['origem_exercicio']);
        }

        if ($origem['tipo'] != 'grupo') {
            list($codCredito, $codEspecie, $codGenero, $codNatureza) = explode('.', $origem['origem']);

            $sth->bindValue(':origemExercicio', $origem['origem_exercicio']);
            $sth->bindValue(':codCredito', $codCredito);
            $sth->bindValue(':codEspecie', $codEspecie);
            $sth->bindValue(':codGenero', $codGenero);
            $sth->bindValue(':codNatureza', $codNatureza);
        }

        $sth->bindValue(':codConvenio', ($origem['cod_convenio']) ? $origem['cod_convenio'] : -1);


        $sth->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param Lote $lote
     * @return array
     */
    public function getInconsistenciasSemVinculo(Lote $lote)
    {
        $query = "
            select
                 li.numeracao
                 , to_char ( li.data_pagamento, 'dd/mm/yyyy' ) as data_pagamento
                 , replace ( li.valor::varchar,'.',',' ) as valor
             from
                 arrecadacao.lote_inconsistencia li
             WHERE li.exercicio = :exercicio AND li.cod_lote = :lote
             AND NOT EXISTS ( select numeracao FROM arrecadacao.carne WHERE numeracao = li.numeracao );
            ";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':lote', $lote->getCodLote());
        $sth->bindValue(':exercicio', $lote->getExercicio());
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param $lotes
     * @return mixed
     */
    public function getResumoLoteListaInconsistenteDividaAtiva($lotes)
    {
        $exercicio = current($lotes)['exercicio'];

        $codLotes = implode(',', array_unique(array_column($lotes, 'cod_lote')));

        $query = "select                                                                          
                 li.numeracao                                                                
                 , to_char ( li.data_pagamento, 'dd/mm/yyyy' ) as data_pagamento             
                 , replace ( li.valor::varchar,'.',',' ) as valor                            
             from                                                                            
                 arrecadacao.lote_inconsistencia li  
                 WHERE li.exercicio = :exercicio and li.cod_lote IN ($codLotes) 
                 AND EXISTS ( select numeracao FROM arrecadacao.carne WHERE numeracao = li.numeracao AND cod_convenio = -1)";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
     * @param $lotes
     * @return array
     */
    public function getResumoLoteListaInconsistenteSemVinculo($lotes)
    {
        $exercicio = current($lotes)['exercicio'];

        $codLotes = implode(',', array_unique(array_column($lotes, 'cod_lote')));

        $query = "
            select
                 li.numeracao
                 , to_char ( li.data_pagamento, 'dd/mm/yyyy' ) as data_pagamento
                 , replace ( li.valor::varchar,'.',',' ) as valor
             from
                 arrecadacao.lote_inconsistencia li
             WHERE li.exercicio = :exercicio AND li.cod_lote IN($codLotes)
             AND NOT EXISTS ( select numeracao FROM arrecadacao.carne WHERE numeracao = li.numeracao );
            ";

        $pdo = $this->_em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        $sth->execute();

        return $sth->fetchAll();
    }
}
