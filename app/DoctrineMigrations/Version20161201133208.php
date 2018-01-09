<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Tesouraria\UsuarioTerminalExcluido;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Urbem\CoreBundle\Entity\Tesouraria\Terminal;
use Urbem\CoreBundle\Entity\Tesouraria\TerminalDesativado;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161201133208 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE tesouraria.terminal ALTER COLUMN "timestamp_terminal" TYPE timestamp USING "timestamp_terminal"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.terminal ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.terminal ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_terminal" TYPE timestamp USING timestamp_terminal::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_desativado" TYPE timestamp USING timestamp_desativado::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_desativado" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_desativado" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_terminal" TYPE timestamp USING "timestamp_terminal"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_usuario" TYPE timestamp USING "timestamp_usuario"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_usuario" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_usuario" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_terminal" TYPE timestamp USING "timestamp_terminal"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_abertura" TYPE timestamp USING "timestamp_abertura"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_abertura" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_abertura" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_usuario" TYPE timestamp USING "timestamp_usuario"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_usuario" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_usuario" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_terminal" TYPE timestamp USING timestamp_terminal::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_abertura" TYPE timestamp USING timestamp_abertura::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_abertura" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_abertura" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING timestamp_fechamento::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('DROP VIEW IF EXISTS tesouraria.vw_boletins');

        $this->changeColumnToDateTimeMicrosecondType(Terminal::class, 'timestamp_terminal');
        $this->changeColumnToDateTimeMicrosecondType(TerminalDesativado::class, 'timestamp_desativado');
        $this->changeColumnToDateTimeMicrosecondType(UsuarioTerminalExcluido::class, 'timestamp_excluido');

        $this->addSql('ALTER TABLE tesouraria.boletim_fechado ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_fechado ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_fechado ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_liberado" TYPE timestamp USING "timestamp_liberado"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_liberado" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_liberado" DROP DEFAULT;');

        $this->addSql($this->queryVwBoletins());

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_liberado" TYPE timestamp USING "timestamp_liberado"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_liberado" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_liberado" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_liberado" TYPE timestamp USING "timestamp_liberado"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_liberado" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_liberado" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" TYPE timestamp USING "timestamp_arrecadacao"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" TYPE timestamp USING "timestamp_arrecadacao"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_inconsistencia ALTER COLUMN "timestamp_arrecadacao" TYPE timestamp USING "timestamp_arrecadacao"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_inconsistencia ALTER COLUMN "timestamp_arrecadacao" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_inconsistencia ALTER COLUMN "timestamp_arrecadacao" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_reaberto ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::timestamp;');
        $this->addSql('ALTER TABLE tesouraria.boletim_reaberto ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_reaberto ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE tesouraria.terminal ALTER COLUMN "timestamp_terminal" TYPE date USING "timestamp_terminal"::date;');
        $this->addSql('ALTER TABLE tesouraria.terminal ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.terminal ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_terminal" TYPE date USING "timestamp_terminal"::date;');
        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.terminal_desativado ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_terminal" TYPE date USING "timestamp_terminal"::date;');
        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_usuario" TYPE date USING "timestamp_usuario"::date;');
        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_usuario" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.usuario_terminal ALTER COLUMN "timestamp_usuario" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_terminal" TYPE timestamp USING "timestamp_terminal"::date;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_abertura" TYPE timestamp USING "timestamp_abertura"::date;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_abertura" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_abertura" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_usuario" TYPE timestamp USING "timestamp_usuario"::date;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_usuario" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.abertura ALTER COLUMN "timestamp_usuario" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_terminal" TYPE timestamp USING timestamp_terminal::date;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_terminal" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_terminal" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_abertura" TYPE timestamp USING timestamp_abertura::date;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_abertura" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_abertura" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING timestamp_fechamento::date;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.fechamento ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_fechado ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_fechado ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_fechado ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_liberado" TYPE timestamp USING "timestamp_liberado"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_liberado" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado ALTER COLUMN "timestamp_liberado" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_liberado" TYPE timestamp USING "timestamp_liberado"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_liberado" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_cancelado ALTER COLUMN "timestamp_liberado" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_liberado" TYPE timestamp USING "timestamp_liberado"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_liberado" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_liberado_lote ALTER COLUMN "timestamp_liberado" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" TYPE timestamp USING "timestamp_arrecadacao"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" TYPE timestamp USING "timestamp_arrecadacao"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_estornado ALTER COLUMN "timestamp_arrecadacao" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_inconsistencia ALTER COLUMN "timestamp_arrecadacao" TYPE timestamp USING "timestamp_arrecadacao"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_inconsistencia ALTER COLUMN "timestamp_arrecadacao" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_lote_arrecadacao_inconsistencia ALTER COLUMN "timestamp_arrecadacao" DROP DEFAULT;');

        $this->addSql('ALTER TABLE tesouraria.boletim_reaberto ALTER COLUMN "timestamp_fechamento" TYPE timestamp USING "timestamp_fechamento"::date;');
        $this->addSql('ALTER TABLE tesouraria.boletim_reaberto ALTER COLUMN "timestamp_fechamento" SET NOT NULL;');
        $this->addSql('ALTER TABLE tesouraria.boletim_reaberto ALTER COLUMN "timestamp_fechamento" DROP DEFAULT;');
    }

    private function queryVwBoletins()
    {
        return ' CREATE OR REPLACE VIEW tesouraria.vw_boletins AS
        SELECT TB.cod_boletim
                ,TB.exercicio
                ,TB.cod_entidade
                ,TB.cod_terminal
                ,TB.timestamp_terminal
                ,TB.cgm_usuario
                ,TB.timestamp_usuario
                ,TBF.timestamp_fechamento
                ,TBR.timestamp_reabertura
                ,TO_CHAR( TB.dt_boletim, \'dd/mm/yyyy\' ) as dt_boletim
                ,TO_CHAR( TBF.timestamp_fechamento, \'dd/mm/yyyy - HH24:mm:ss\' ) as dt_fechamento
                ,CGM.nom_cgm
                ,TBL.timestamp_liberado
                ,CASE WHEN TBF.timestamp_fechamento IS NOT NULL
                  THEN CASE WHEN TBR.timestamp_reabertura IS NOT NULL
                        THEN CASE WHEN TBF.timestamp_fechamento >= TBR.timestamp_reabertura
                              THEN CASE WHEN TBL.timestamp_liberado IS NOT NULL
                                    THEN \'liberado\'
                                    ELSE \'fechado\'
                                   END
                              ELSE \'reaberto\'
                             END
                        ELSE CASE WHEN TBL.timestamp_liberado IS NOT NULL
                               THEN \'liberado\'
                               ELSE \'fechado\'
                             END
                       END
                  ELSE \'aberto\'
                 END AS situacao
          FROM tesouraria.boletim AS TB
          LEFT JOIN( SELECT TBF.cod_boletim
                           ,TBF.exercicio
                           ,TBF.cod_entidade
                           ,MAX( TBF.timestamp_fechamento ) as timestamp_fechamento
                     FROM tesouraria.boletim_fechado AS TBF
                     GROUP BY cod_boletim
                             ,exercicio
                             ,cod_entidade
                     ORDER BY cod_boletim
                             ,exercicio
                             ,cod_entidade
          ) AS TBF ON( TB.cod_boletim = TBF.cod_boletim
            AND TB.exercicio   = TBF.exercicio
            AND TB.cod_entidade= TBF.cod_entidade )
          LEFT JOIN( SELECT TBR.cod_boletim
                           ,TBR.exercicio
                           ,TBR.cod_entidade
                           ,MAX( TBR.timestamp_reabertura ) as timestamp_reabertura
                     FROM tesouraria.boletim_reaberto AS TBR
                     GROUP BY TBR.cod_boletim
                             ,TBR.exercicio
                             ,TBR.cod_entidade
                     ORDER BY TBR.cod_boletim
                             ,TBR.exercicio
                             ,TBR.cod_entidade
          ) AS TBR ON( TB.cod_boletim = TBR.cod_boletim
            AND TB.exercicio   = TBR.exercicio
            AND TB.cod_entidade= TBR.cod_entidade )
          LEFT JOIN( SELECT TBL.cod_boletim
                           ,TBL.exercicio
                           ,TBL.cod_entidade
                           ,MAX( TBL.timestamp_liberado  ) as timestamp_liberado
                     FROM tesouraria.boletim_liberado   AS TBL
                     GROUP BY TBL.cod_boletim
                             ,TBL.exercicio
                             ,TBL.cod_entidade
                     ORDER BY TBL.cod_boletim
                             ,TBL.exercicio
                             ,TBL.cod_entidade
          ) AS TBL ON( TB.cod_boletim = TBL.cod_boletim
            AND TB.exercicio   = TBL.exercicio
            AND TB.cod_entidade= TBL.cod_entidade )
          ,sw_cgm as CGM
          WHERE TB.cgm_usuario = CGM.numcgm
        AND TBL.timestamp_liberado IS NULL AND
                              CASE WHEN tbf.timestamp_fechamento IS NULL
                               THEN
                                   TRUE
                               ELSE
                                  CASE WHEN TBR.timestamp_reabertura IS NOT NULL
                                      THEN
                                          TBF.timestamp_fechamento < TBR.timestamp_reabertura
                                      ELSE
                                          FALSE
                                  END
                               end
             ORDER BY  cod_boletim';
    }
}
