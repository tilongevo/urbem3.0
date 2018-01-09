<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenhoAnulado;
use Urbem\CoreBundle\Entity\Empenho\EmpenhoAnulado;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170209153027 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP VIEW IF EXISTS orcamento.saldo_dotacao;');
        $this->addSql('CREATE TABLE IF NOT EXISTS contabilidade.lancamento_empenho_anulado (
            exercicio bpchar(4) NOT NULL,
            cod_lote int4 NOT NULL,
            tipo bpchar(1) NOT NULL,
            sequencia int4 NOT NULL,
            cod_entidade int4 NOT NULL,
            exercicio_anulacao bpchar(4) NOT NULL,
            cod_empenho_anulacao int4 NOT NULL,
            timestamp_anulacao timestamp NOT NULL,
            CONSTRAINT pk_lancamento_empenho_anulado PRIMARY KEY (exercicio,cod_lote,tipo,sequencia,cod_entidade,exercicio_anulacao,cod_empenho_anulacao,timestamp_anulacao),
            CONSTRAINT fk_lancamento_empenho_anulado_1 FOREIGN KEY (exercicio,cod_lote,tipo,sequencia,cod_entidade) REFERENCES contabilidade.lancamento_empenho(exercicio,cod_lote,tipo,sequencia,cod_entidade)        
        )
        WITH (
        OIDS=FALSE
        );
        ');
        $this->changeColumnToDateTimeMicrosecondType(LancamentoEmpenhoAnulado::class, 'timestamp_anulacao');
        $this->changeColumnToDateTimeMicrosecondType(EmpenhoAnulado::class, 'timestamp');
        $this->addSql("CREATE OR REPLACE VIEW orcamento.saldo_dotacao AS
SELECT *,
	 (valor_orcado + valor_suplementado - valor_reduzido - valor_empenhado + valor_anulado - valor_reserva) as saldo_disponivel  ,(valor_orcado - valor_reserva) as saldo, row_number() OVER () as rnum FROM(
	 SELECT
	      D.cod_entidade,
	      D.exercicio,
	      CGM.nom_cgm as entidade,
	      D.cod_despesa,
	      CD.cod_conta,
	      CD.descricao,
	      D.num_orgao,
	      OO.nom_orgao,       D.num_unidade,
	      OU.nom_unidade,       D.cod_funcao,
	      F.descricao as funcao,
	      D.cod_subfuncao,
	      SF.descricao as subfuncao,
	      D.cod_programa,
	      ppa.programa.num_programa AS num_programa,
	      P.descricao as programa,
	      D.num_pao,
	      ppa.acao.num_acao AS num_acao,
	      PAO.nom_pao,
	      CD.cod_estrutural,
	      D.cod_recurso,
	      R.nom_recurso,
	      R.cod_fonte,
	      R.masc_recurso_red,
	      R.cod_detalhamento,
	      coalesce(sum(D.vl_original),0.00) as valor_orcado,
	      coalesce(sum(SS.valor),0.00)      as valor_suplementado,
	      coalesce(sum(SR.valor),0.00)      as valor_reduzido,
	      coalesce(sum(RS.vl_reserva),0.00) as valor_reserva,
	      coalesce(sum(EMP.vl_empenhado),0.00) as valor_empenhado,
	      coalesce(sum(EMP.vl_anulado),0.00)   as valor_anulado,
	      coalesce(sum(EMP.vl_liquidado),0.00) as valor_liquidado,
	      coalesce(sum(EMP.vl_pago),0.00)      as valor_pago
	  FROM
	      orcamento.despesa        AS D
	        LEFT JOIN (
	            SELECT
	                SSUP.cod_despesa,
	                SSUP.exercicio,
	                coalesce(sum(SSUP.valor),0.00) as valor
	            FROM
	                orcamento.suplementacao_suplementada    as SSUP,
	                orcamento.suplementacao                 as S
	            WHERE
	                SSUP.cod_suplementacao  = S.cod_suplementacao   AND
	                SSUP.exercicio          = S.exercicio

	            AND S.cod_tipo <> 16
	            AND ( select sa.cod_suplementacao
	                    from orcamento.suplementacao_anulada as sa
	                   where sa.exercicio = S.exercicio
	                     and sa.cod_suplementacao = S.cod_suplementacao
	                ) IS NULL

	       GROUP BY SSUP.cod_despesa, SSUP.exercicio
	        )  as SS ON
	            D.cod_despesa   = SS.cod_despesa    AND
	            D.exercicio     = SS.exercicio
	        LEFT JOIN (
	            SELECT
	                SRED.cod_despesa,
	                SRED.exercicio,
	                coalesce(sum(SRED.valor),0.00) as valor
	            FROM
	                orcamento.suplementacao_reducao         as SRED,
	                orcamento.suplementacao                 as S
	            WHERE
	                SRED.cod_suplementacao  = S.cod_suplementacao   AND
	                SRED.exercicio          = S.exercicio

	            AND S.cod_tipo <> 16
	            AND ( select sa.cod_suplementacao
	                    from orcamento.suplementacao_anulada as sa
	                   where sa.exercicio = S.exercicio
	                     and sa.cod_suplementacao = S.cod_suplementacao
	                ) IS NULL

	       GROUP BY SRED.cod_despesa, SRED.exercicio
	        ) as SR ON
	            D.cod_despesa   = SR.cod_despesa    AND
	            D.exercicio     = SR.exercicio
	        LEFT JOIN (
	            SELECT
	                R.cod_despesa,
	                R.exercicio,
	                coalesce(sum(R.vl_reserva),0.00) as vl_reserva
	            FROM
	                orcamento.reserva_saldos        AS R
	            WHERE NOT EXISTS ( SELECT 1
	                                 FROM orcamento.reserva_saldos_anulada orsa
	                                WHERE orsa.cod_reserva = R.cod_reserva
	                                  AND orsa.exercicio   = R.exercicio
	                             )
	                                  AND R.dt_validade_final > to_date(now()::varchar, 'yyyy-mm-dd')
	        GROUP BY R.cod_despesa, R.exercicio
	        )            as RS ON
	            D.cod_despesa   = RS.cod_despesa    AND
	            D.exercicio     = RS.exercicio
	        LEFT JOIN (
	            SELECT
	                PD.cod_despesa,
	                PD.exercicio,
	                EE.cod_entidade,
	                coalesce(sum(EMP.valor),0.00)               as vl_empenhado,
	                coalesce(sum(ANU.valor),0.00)               as vl_anulado,
	                (coalesce(sum(NL.vl_liquidado),0.00) - coalesce(sum(NL.vl_liquidado_anulado),0.00)) as vl_liquidado,
	                (coalesce(sum(NL.vl_pago),0.00) - coalesce(sum(NL.vl_estornado),0.00))              as vl_pago
	            FROM
	                    empenho.empenho             AS EE
	                        LEFT JOIN (
	                            SELECT
	                                PE.exercicio,
	                                PE.cod_pre_empenho,
	                                coalesce(sum(IE.vl_total),0.00) as valor
	                            FROM
	                                empenho.empenho                       AS E,
	                                empenho.pre_empenho                   AS PE,
	                                empenho.item_pre_empenho              AS IE
	                            WHERE
	                                    E.cod_pre_empenho   = PE.cod_pre_empenho
	                            AND     E.exercicio         = PE.exercicio
	                            AND     IE.cod_pre_empenho   = PE.cod_pre_empenho
	                            AND     IE.exercicio         = PE.exercicio
	                            GROUP BY PE.exercicio,PE.cod_pre_empenho
	                        ) as EMP ON (
	                                    EMP.exercicio         = EE.exercicio
	                            AND     EMP.cod_pre_empenho   = EE.cod_pre_empenho
	                        )
	                        LEFT JOIN (
	                            SELECT
	                                EA.exercicio,
	                                EA.cod_empenho,
	                                EA.cod_entidade,
	                                coalesce(sum(EAI.vl_anulado),0.00) as valor
	                            FROM
	                                empenho.empenho_anulado               AS EA,
	                                empenho.empenho_anulado_item          AS EAI
	                           WHERE
	                                    EA.exercicio        = EAI.exercicio
	                            AND     EA.cod_entidade     = EAI.cod_entidade
	                            AND     EA.cod_empenho      = EAI.cod_empenho
	                            AND     EA.timestamp        = EAI.timestamp
	                        GROUP BY EA.exercicio, EA.cod_empenho, EA.cod_entidade
	                        ) as ANU ON (
	                                    ANU.exercicio     = EE.exercicio
	                            AND     ANU.cod_empenho   = EE.cod_empenho
	                            AND     ANU.cod_entidade  = EE.cod_entidade
	                        )
	                        LEFT JOIN (
	                            SELECT
	                                NL.exercicio,
	                                NL.cod_empenho,
	                                NL.cod_entidade,
	                                sum(NLI.vl_total)       as vl_liquidado,
	                                sum(NLIA.valor)         as vl_liquidado_anulado,
	                                sum(NLP.vl_pago)        as vl_pago,
	                                sum(NLPA.vl_estornado)  as vl_estornado
	                            FROM
	                                empenho.nota_liquidacao             AS NL
	                                LEFT JOIN (
	                                select
	                                    exercicio,
	                                    cod_nota,
	                                    cod_entidade,
	                                    coalesce(sum(vl_total),0.00)as vl_total
	                                    from
	                                    empenho.nota_liquidacao_item
	                                    group by
	                                    exercicio,cod_nota,cod_entidade
	                                ) as NLI on
	                                    NL.exercicio         = NLI.exercicio
	                                AND NL.cod_nota          = NLI.cod_nota
	                                AND NL.cod_entidade      = NLI.cod_entidade
	                                    LEFT JOIN (
	                                        SELECT
	                                            NLI.exercicio,
	                                            NLI.cod_nota,
	                                            NLI.cod_entidade,
	                                            coalesce(sum(NLIA.vl_anulado),0.00) as valor
	                                        FROM
	                                            empenho.nota_liquidacao_item            AS NLI,
	                                            empenho.nota_liquidacao_item_anulado    AS NLIA
	                                        WHERE
	                                                NLI.exercicio        = NLIA.exercicio
	                                            AND NLI.cod_nota         = NLIA.cod_nota
	                                            AND NLI.num_item         = NLIA.num_item
	                                            AND NLI.exercicio_item   = NLIA.exercicio_item
	                                            AND NLI.cod_pre_empenho  = NLIA.cod_pre_empenho
	                                            AND NLI.cod_entidade     = NLIA.cod_entidade
	                                     GROUP BY nli.exercicio, nli.cod_nota, nli.cod_entidade
	                                    ) as NLIA ON
	                                            NL.exercicio         = NLIA.exercicio
	                                        AND NL.cod_nota          = NLIA.cod_nota
	                                        AND NL.cod_entidade      = NLIA.cod_entidade

	                                    LEFT JOIN (
	                                       SELECT
	                                           coalesce(sum(NLP.vl_pago),0.00) as vl_pago,
	                                           NLP.exercicio,
	                                           NLP.cod_entidade,
	                                           NLP.cod_nota
	                                       FROM
	                                           empenho.nota_liquidacao_paga AS NLP

	                                       GROUP BY NLP.exercicio, NLP.cod_entidade, NLP.cod_nota
	                                   ) as NLP ON
	                                           NL.exercicio         = NLP.exercicio
	                                       AND NL.cod_nota          = NLP.cod_nota
	                                       AND NL.cod_entidade      = NLP.cod_entidade

	                                    LEFT JOIN (
	                                        SELECT
	                                            NLP.exercicio,
	                                            NLP.cod_nota,
	                                            NLP.cod_entidade,
	                                            coalesce(sum(NLPA.vl_anulado),0.00) as vl_estornado
	                                        FROM
	                                            empenho.nota_liquidacao_paga            AS NLP,
	                                            empenho.nota_liquidacao_paga_anulada    AS NLPA
	                                        WHERE
	                                                NLP.exercicio        = NLPA.exercicio
	                                            AND NLP.cod_nota         = NLPA.cod_nota
	                                            AND NLP.cod_entidade     = NLPA.cod_entidade
	                                            AND NLP.timestamp        = NLPA.timestamp
	                                         GROUP BY nlp.exercicio,nlp.cod_nota,nlp.cod_entidade
	                        ) as NLPA ON
	                                            NL.exercicio         = NLPA.exercicio
	                                        AND NL.cod_nota          = NLPA.cod_nota
	                                        AND NL.cod_entidade      = NLPA.cod_entidade
	                            GROUP BY
	                                NL.exercicio,
	                                NL.cod_empenho,
	                                NL.cod_entidade
	                        ) as NL ON (
	                                    NL.exercicio     = EE.exercicio
	                            AND     NL.cod_empenho   = EE.cod_empenho
	                            AND     NL.cod_entidade  = EE.cod_entidade
	                        )
	                    ,empenho.pre_empenho         AS PE
	                    ,empenho.pre_empenho_despesa AS PD
	            WHERE
	                       EE.cod_pre_empenho = PE.cod_pre_empenho
	                AND    EE.exercicio       = PE.exercicio

	                AND    PD.cod_pre_empenho = PE.cod_pre_empenho
	                AND    PD.exercicio       = PE.exercicio
	            GROUP BY
	                PD.cod_despesa,
	                PD.exercicio,
	                EE.cod_entidade

	        ) AS EMP ON
	            D.cod_despesa   = EMP.cod_despesa   AND
	            D.exercicio     = EMP.exercicio     AND
	            D.cod_entidade  = EMP.cod_entidade
	            JOIN orcamento.programa_ppa_programa
	              ON programa_ppa_programa.cod_programa = D.cod_programa
	             AND programa_ppa_programa.exercicio   = D.exercicio
	            JOIN ppa.programa
	              ON ppa.programa.cod_programa = programa_ppa_programa.cod_programa_ppa
	            JOIN orcamento.pao_ppa_acao
	              ON pao_ppa_acao.num_pao = D.num_pao
	             AND pao_ppa_acao.exercicio = D.exercicio
	            JOIN ppa.acao
	              ON ppa.acao.cod_acao = pao_ppa_acao.cod_acao
	      ,orcamento.conta_despesa  AS CD
	      ,orcamento.entidade       AS E
	      ,sw_cgm                   AS CGM
	      ,orcamento.orgao          AS OO
	      ,orcamento.unidade        AS OU
	      ,orcamento.funcao         AS F
	      ,orcamento.subfuncao      AS SF
	      ,orcamento.programa       AS P
	      ,orcamento.pao            AS PAO
	      --,orcamento.recurso(EXTRACT ( YEAR FROM to_date('31/12/2016'::varchar, 'dd/mm/yyyy'))::varchar) AS R
	      ,orcamento.recurso(D.exercicio) as R
	  WHERE
	          D.cod_conta     = CD.cod_conta
	      AND D.exercicio     = CD.exercicio
	      AND D.exercicio     = OU.exercicio
	      AND D.num_unidade   = OU.num_unidade
	      AND D.num_orgao     = OU.num_orgao
	      AND D.exercicio     = E.exercicio
	      AND D.cod_entidade  = E.cod_entidade
	      AND E.numcgm        = CGM.numcgm
	      AND OU.exercicio    = OO.exercicio
	      AND OU.num_orgao    = OO.num_orgao
	      AND D.exercicio     = F.exercicio
	      AND D.cod_funcao    = F.cod_funcao
	      AND D.exercicio     = SF.exercicio
	      AND D.cod_subfuncao = SF.cod_subfuncao
	      AND D.exercicio     = P.exercicio
	      AND D.cod_programa  = P.cod_programa
	      AND D.exercicio     = PAO.exercicio
	      AND D.num_pao       = PAO.num_pao
	      AND D.exercicio     = R.exercicio
	      AND D.cod_recurso   = R.cod_recurso
	 --AND D.exercicio = '2016'
	        GROUP BY
	              D.cod_entidade,
	              D.exercicio,
	              CGM.nom_cgm,

	              D.cod_despesa,
	              CD.cod_conta,
	              CD.descricao,

	              D.num_orgao,
	              OO.nom_orgao,
	              OU.nom_unidade,

	              D.num_unidade,

	              D.cod_funcao,
	              F.descricao,

	              D.cod_subfuncao,
	              SF.descricao,

	              D.cod_programa,
	              ppa.programa.num_programa,
	              P.descricao,

	              D.num_pao,
	              ppa.acao.num_acao,
	              PAO.nom_pao,

	              CD.cod_estrutural,

	              D.cod_recurso,
	              R.nom_recurso,
	              R.masc_recurso,
	              R.cod_fonte,
	              R.masc_recurso_red,
	              R.cod_detalhamento

	     ORDER BY D.cod_entidade, D.cod_despesa ) as tabela;");
    }


    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP VIEW orcamento.saldo_dotacao;');
    }
}
