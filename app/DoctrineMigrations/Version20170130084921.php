<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170130084921 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('
            CREATE OR REPLACE VIEW tesouraria.vw_orcamentaria_pagamento_estorno AS
                SELECT EOP.exercicio,
                       EOP.exercicio AS empenho_pagamento,
                       CGM.exercicio_liquidacao,
                       CGM.exercicio_empenho,
                       EOP.cod_entidade,
                       EOP.cod_empenho,
                       EOP.cod_nota,
                       empenho.retorna_empenhos(EOP.exercicio, EOP.cod_ordem, EOP.cod_entidade) AS empenho,
                       empenho.retorna_notas (EOP.exercicio, EOP.cod_ordem, EOP.cod_entidade) AS nota,
                       EOP.cod_ordem ||\'/\'|| EOP.exercicio AS ordem,
                       CGM.nom_cgm AS beneficiario,
                       0.00 AS vl_nota,
                       coalesce(EOP.vl_pago,0.00) AS vl_ordem,
                       coalesce(CGM.vl_prestado,0.00) AS vl_prestado,
                       EOP.cod_conta AS cod_conta,
                       EOP.nom_conta,
                       CASE
                           WHEN ordem_pagamento_retencao.cod_ordem IS NOT NULL THEN TRUE
                           ELSE FALSE
                       END AS retencao
                FROM
                  (SELECT EPLNLP.cod_ordem,
                          ENLP.cod_entidade,
                          ENLP.cod_empenho,
                          EPLNLP.exercicio,
                          EPLNLP.cod_nota,
                          sum(coalesce(ENLP.vl_pago,0.00)) AS vl_pago,
                          ENLP.cod_conta AS cod_conta,
                          ENLP.nom_conta AS nom_conta
                   FROM empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPLNLP
                   INNER JOIN
                     (SELECT TP.exercicio,
                             TP.cod_entidade,
                             TP.cod_nota,
                             TP.timestamp,
                             (coalesce(ENLP.vl_pago,0.00) - coalesce(TPE.vl_anulado,0.00)) AS vl_pago,
                             CPC.cod_conta AS cod_conta,
                             CPC.nom_conta AS nom_conta,
                             ENL.cod_empenho
                      FROM tesouraria.pagamento AS TP
                      LEFT JOIN
                        (SELECT ENLPA.cod_nota,
                                ENLPA.cod_entidade,
                                ENLPA.exercicio,
                                ENLPA.timestamp,
                                sum(coalesce(ENLPA.vl_anulado,0.00)) AS vl_anulado
                         FROM tesouraria.pagamento_estornado AS TPE
                         INNER JOIN empenho.nota_liquidacao_paga_anulada AS ENLPA ON ENLPA.cod_entidade = TPE.cod_entidade
                         AND ENLPA.exercicio = TPE.exercicio
                         AND ENLPA.timestamp = TPE.timestamp
                         AND ENLPA.timestamp_anulada = TPE.timestamp_anulado
                         GROUP BY ENLPA.cod_nota,
                                  ENLPA.cod_entidade,
                                  ENLPA.exercicio,
                                  ENLPA.timestamp) AS TPE ON TP.cod_nota = TPE.cod_nota
                      AND TP.cod_entidade = TPE.cod_entidade
                      AND TP.exercicio = TPE.exercicio
                      AND TP.timestamp = TPE.timestamp
                      LEFT JOIN contabilidade.plano_analitica AS CPA ON TP.cod_plano=CPA.cod_plano
                      AND TP.exercicio = CPA.exercicio
                      LEFT JOIN contabilidade.plano_conta AS CPC ON CPC.exercicio=CPA.exercicio
                      AND CPC.cod_conta = CPA.cod_conta,
                          empenho.nota_liquidacao_paga AS ENLP,
                          empenho.nota_liquidacao AS ENL
                      WHERE TP.exercicio = ENLP.exercicio
                        AND TP.cod_entidade = ENLP.cod_entidade
                        AND TP.cod_nota = ENLP.cod_nota
                        AND TP.timestamp = ENLP.timestamp
                        AND ENLP.exercicio = ENL.exercicio
                        AND ENLP.cod_entidade = ENL.cod_entidade
                        AND ENLP.cod_nota = ENL.cod_nota ) AS ENLP ON ENLP.exercicio = EPLNLP.exercicio_liquidacao
                   AND ENLP.cod_entidade = EPLNLP.cod_entidade
                   AND ENLP.cod_nota = EPLNLP.cod_nota
                   AND ENLP.timestamp = EPLNLP.timestamp
                   WHERE coalesce(ENLP.vl_pago,0.00) > 0.00
                   GROUP BY EPLNLP.cod_ordem,
                            ENLP.cod_entidade,
                            EPLNLP.cod_nota,
                            ENLP.cod_empenho,
                            EPLNLP.exercicio,
                            ENLP.cod_conta,
                            ENLP.nom_conta) AS EOP
                LEFT JOIN
                  (SELECT ordem_pagamento_retencao.exercicio,
                          ordem_pagamento_retencao.cod_entidade,
                          ordem_pagamento_retencao.cod_ordem
                   FROM empenho.ordem_pagamento_retencao
                   GROUP BY ordem_pagamento_retencao.exercicio,
                            ordem_pagamento_retencao.cod_entidade,
                            ordem_pagamento_retencao.cod_ordem) AS ordem_pagamento_retencao ON EOP.exercicio = ordem_pagamento_retencao.exercicio
                AND EOP.cod_entidade = ordem_pagamento_retencao.cod_entidade
                AND EOP.cod_ordem = ordem_pagamento_retencao.cod_ordem
                INNER JOIN
                  (SELECT EPLNLP.exercicio,
                          EPLNLP.exercicio_liquidacao,
                          EE.exercicio AS exercicio_empenho,
                          EPLNLP.cod_entidade,
                          EPLNLP.cod_ordem,
                          CGM.nom_cgm,
                          coalesce(itens.vl_prestado,0.00) AS vl_prestado
                   FROM empenho.pagamento_liquidacao_nota_liquidacao_paga AS EPLNLP,
                        empenho.pagamento_liquidacao AS EPL,
                        empenho.nota_liquidacao AS ENL,
                        empenho.empenho AS EE
                   LEFT JOIN
                     (SELECT cod_empenho,
                             exercicio,
                             cod_entidade,
                             coalesce(SUM(valor_item),0.00) AS vl_prestado
                      FROM empenho.item_prestacao_contas AS eipc
                      WHERE NOT EXISTS
                          (SELECT num_item
                           FROM empenho.item_prestacao_contas_anulado
                           WHERE cod_empenho = eipc.cod_empenho
                             AND exercicio = eipc.exercicio
                             AND cod_entidade = eipc.cod_entidade
                             AND num_item = eipc.num_item )
                      GROUP BY cod_empenho,
                               exercicio,
                               cod_entidade) AS itens ON itens.cod_empenho = EE.cod_empenho
                   AND itens.exercicio = EE.exercicio
                   AND itens.cod_entidade = EE.cod_entidade,
                       empenho.pre_empenho AS EPE,
                       sw_cgm AS CGM
                   WHERE EPLNLP.exercicio_liquidacao = EPL.exercicio_liquidacao
                     AND EPLNLP.cod_entidade = EPL.cod_entidade
                     AND EPLNLP.cod_ordem = EPL.cod_ordem
                     AND EPLNLP.exercicio = EPL.exercicio
                     AND EPLNLP.cod_nota = EPL.cod_nota
                     AND EPL.exercicio_liquidacao = ENL.exercicio
                     AND EPL.cod_entidade = ENL.cod_entidade
                     AND EPL.cod_nota = ENL.cod_nota
                     AND ENL.exercicio_empenho = EE.exercicio
                     AND ENL.cod_entidade = EE.cod_entidade
                     AND ENL.cod_empenho = EE.cod_empenho
                     AND EE.exercicio = EPE.exercicio
                     AND EE.cod_pre_empenho = EPE.cod_pre_empenho
                     AND EPE.cgm_beneficiario = CGM.numcgm
                   GROUP BY EPLNLP.exercicio,
                            EPLNLP.cod_entidade,
                            EPLNLP.cod_ordem,
                            CGM.nom_cgm,
                            itens.vl_prestado,
                            EPLNLP.exercicio_liquidacao,
                            EE.exercicio
                   ORDER BY EPLNLP.exercicio,
                            EPLNLP.cod_entidade,
                            EPLNLP.cod_ordem,
                            CGM.nom_cgm) AS CGM ON CGM.exercicio = EOP.exercicio
                AND CGM.cod_entidade = EOP.cod_entidade
                AND CGM.cod_ordem = EOP.cod_ordem;
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP VIEW tesouraria.vw_orcamentaria_pagamento_estorno;');
    }
}
