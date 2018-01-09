<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Economico\LicencaDocumento;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170531185321 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->changeColumnToDateTimeMicrosecondType(LicencaDocumento::class, 'timestamp');
        $this->addSql("DROP VIEW IF EXISTS public.sw_vw_consultaprocessopenultimoandamento");
        $this->addSql("DROP VIEW IF EXISTS public.sw_vw_consultaprocesso");
        $this->changeColumnToDateTimeMicrosecondType(SwProcesso::class, 'timestamp');
        $this->addSql("CREATE OR REPLACE VIEW public.sw_vw_consultaprocesso AS
                         SELECT p.cod_processo AS codprocesso,
                            p.ano_exercicio AS exercicio,
                            p.cod_situacao AS codsituacao,
                            p.\"timestamp\" AS datainclusao,
                            p.cod_usuario AS codusuarioinclusao,
                            sw_processo_interessado.numcgm AS codinteressado,
                            p.cod_classificacao AS codclassificacao,
                            p.cod_assunto AS codassunto,
                            p.resumo_assunto,
                            p.confidencial,
                            sw_situacao_processo.nom_situacao AS nomsituacao,
                            usuario_inclusao.username AS usuarioinclusao,
                            sw_cgm.nom_cgm AS nominteressado,
                            ultimo_andamento.cod_andamento AS codultimoandamento,
                            ultimo_andamento.cod_usuario AS codusuarioultimoandamento,
                            ultimo_andamento.cod_orgao AS codorgao,
                            ultimo_andamento.\"timestamp\" AS dataultimoandamento,
                            usuario_ultimo_andamento.username AS usuarioultimoandamento,
                            classificacao.nom_classificacao AS nomclassificacao,
                            assunto.nom_assunto AS nomassunto,
                            sw_recebimento.\"timestamp\" AS datarecebimento,
                                CASE
                                    WHEN sw_recebimento.\"timestamp\" IS NULL THEN 'f'::text
                                    ELSE 't'::text
                                END AS recebido,
                                CASE
                                    WHEN sw_assinatura_digital.cod_andamento IS NULL THEN 'Off-Line'::character varying
                                    ELSE sw_usuario_assinatura_digital.username
                                END AS usuariorecebimento,
                                CASE
                                    WHEN sw_assinatura_digital.cod_usuario IS NULL THEN 0
                                    ELSE sw_assinatura_digital.cod_usuario
                                END AS codusuariorecebimento,
                                CASE
                                    WHEN sw_processo_arquivado.cod_processo IS NULL THEN 'f'::text
                                    ELSE 't'::text
                                END AS arquivado,
                            sw_historico_arquivamento.nom_historico AS nomhistoricoarquivamento,
                            sw_recibo_impresso.cod_recibo AS numreciboimpresso,
                            sw_processo_apensado.cod_processo_pai AS codprocessoapensado,
                            sw_processo_apensado.exercicio_pai AS exercicioprocessoapensado,
                            sw_processo_apensado.timestamp_apensamento AS data_processo_apensado,
                            sw_processo_arquivado.timestamp_arquivamento,
                                CASE
                                    WHEN sw_processo_apensado.cod_processo_filho IS NULL THEN 'f'::text
                                    ELSE 't'::text
                                END AS apensado
                           FROM sw_processo p
                             LEFT JOIN sw_processo_apensado ON sw_processo_apensado.cod_processo_filho = p.cod_processo AND sw_processo_apensado.exercicio_filho::text = p.ano_exercicio::text AND sw_processo_apensado.timestamp_desapensamento IS NULL
                             LEFT JOIN sw_processo_arquivado ON sw_processo_arquivado.cod_processo = p.cod_processo AND sw_processo_arquivado.ano_exercicio::text = p.ano_exercicio::text
                             LEFT JOIN sw_historico_arquivamento ON sw_historico_arquivamento.cod_historico = sw_processo_arquivado.cod_historico
                             JOIN sw_processo_interessado ON sw_processo_interessado.cod_processo = p.cod_processo AND sw_processo_interessado.ano_exercicio::text = p.ano_exercicio::text,
                            sw_cgm,
                            administracao.usuario usuario_inclusao,
                            sw_situacao_processo,
                            sw_ultimo_andamento ultimo_andamento
                             LEFT JOIN sw_recebimento ON sw_recebimento.cod_andamento = ultimo_andamento.cod_andamento AND sw_recebimento.cod_processo = ultimo_andamento.cod_processo AND sw_recebimento.ano_exercicio::text = ultimo_andamento.ano_exercicio::text
                             LEFT JOIN sw_recibo_impresso ON sw_recibo_impresso.cod_andamento = ultimo_andamento.cod_andamento AND sw_recibo_impresso.cod_processo = ultimo_andamento.cod_processo AND sw_recibo_impresso.ano_exercicio::text = ultimo_andamento.ano_exercicio::text
                             LEFT JOIN sw_assinatura_digital ON sw_assinatura_digital.cod_andamento = ultimo_andamento.cod_andamento AND sw_assinatura_digital.cod_processo = ultimo_andamento.cod_processo AND sw_assinatura_digital.ano_exercicio::text = ultimo_andamento.ano_exercicio::text
                             LEFT JOIN administracao.usuario sw_usuario_assinatura_digital ON sw_usuario_assinatura_digital.numcgm = sw_assinatura_digital.cod_usuario,
                            administracao.usuario usuario_ultimo_andamento,
                            sw_classificacao classificacao,
                            sw_assunto assunto
                          WHERE sw_processo_interessado.numcgm = sw_cgm.numcgm AND p.cod_usuario = usuario_inclusao.numcgm AND p.cod_situacao = sw_situacao_processo.cod_situacao AND p.cod_processo = ultimo_andamento.cod_processo AND p.ano_exercicio::text = ultimo_andamento.ano_exercicio::text AND p.cod_assunto = assunto.cod_assunto AND p.cod_classificacao = assunto.cod_classificacao AND ultimo_andamento.cod_usuario = usuario_ultimo_andamento.numcgm AND p.cod_classificacao = classificacao.cod_classificacao");
        $this->addSql("CREATE OR REPLACE VIEW public.sw_vw_consultaprocessopenultimoandamento AS
                         SELECT p.cod_processo AS codprocesso,
                            p.ano_exercicio AS exercicio,
                            p.cod_situacao AS codsituacao,
                            sw_situacao_processo.nom_situacao AS nomsituacao,
                            p.\"timestamp\" AS datainclusao,
                            p.cod_usuario AS codusuarioinclusao,
                            sw_usuario_inclusao.username AS usuarioinclusao,
                            sw_processo_interessado.numcgm AS codinteressado,
                            sw_cgm.nom_cgm AS nominteressado,
                            p.cod_classificacao AS codclassificacao,
                            sw_classificacao.nom_classificacao AS nomclassificacao,
                            p.cod_assunto AS codassunto,
                            sw_assunto.nom_assunto AS nomassunto,
                                CASE
                                    WHEN sw_assinatura_digital.cod_andamento IS NULL THEN 'Off-Line'::character varying
                                    ELSE sw_usuario_assinatura_digital.username
                                END AS usuariorecebimento,
                                CASE
                                    WHEN sw_assinatura_digital.cod_usuario IS NULL THEN 0
                                    ELSE sw_assinatura_digital.cod_usuario
                                END AS codusuariorecebimento,
                            sw_recebimento.\"timestamp\" AS datarecebimento,
                                CASE
                                    WHEN sw_recebimento.\"timestamp\" IS NULL THEN 'f'::text
                                    ELSE 't'::text
                                END AS recebido,
                            sw_penultimo_andamento.cod_andamento AS codpenultimoandamento,
                            sw_penultimo_andamento.cod_usuario AS codusuariopenultimoandamento,
                            sw_usuario_penultimo_andamento.username AS usuariopenultimoandamento,
                            sw_penultimo_andamento.cod_orgao AS codpenultimoorgao,
                            sw_penultimo_andamento.\"timestamp\" AS datapenultimoandamento,
                            sw_processo_apensado.cod_processo_pai AS codprocessoapensado,
                            sw_processo_apensado.exercicio_pai AS exercicioprocessoapensado,
                                CASE
                                    WHEN sw_processo_apensado.cod_processo_filho IS NULL THEN 'f'::text
                                    ELSE 't'::text
                                END AS apensado,
                                CASE
                                    WHEN sw_processo_arquivado.cod_processo IS NULL THEN 'f'::text
                                    ELSE 't'::text
                                END AS arquivado,
                            sw_historico_arquivamento.nom_historico AS nomhistoricoarquivamento,
                            sw_recibo_impresso.cod_recibo AS numreciboimpresso
                           FROM sw_processo p
                             LEFT JOIN ( SELECT max(sw_andamento.cod_andamento) - 1 AS cod_andamento,
                                    sw_andamento.cod_processo,
                                    sw_andamento.ano_exercicio
                                   FROM sw_andamento
                                  GROUP BY sw_andamento.cod_processo, sw_andamento.ano_exercicio) sw_codigo_penultimo_andamento ON sw_codigo_penultimo_andamento.cod_processo = p.cod_processo AND sw_codigo_penultimo_andamento.ano_exercicio = p.ano_exercicio
                             LEFT JOIN sw_andamento sw_penultimo_andamento ON sw_penultimo_andamento.cod_andamento = sw_codigo_penultimo_andamento.cod_andamento AND sw_penultimo_andamento.cod_processo = p.cod_processo AND sw_penultimo_andamento.ano_exercicio = p.ano_exercicio
                             LEFT JOIN administracao.usuario sw_usuario_penultimo_andamento ON sw_usuario_penultimo_andamento.numcgm = sw_penultimo_andamento.cod_usuario
                             JOIN sw_processo_interessado ON sw_processo_interessado.cod_processo = p.cod_processo AND sw_processo_interessado.ano_exercicio = p.ano_exercicio
                             LEFT JOIN sw_cgm ON sw_cgm.numcgm = sw_processo_interessado.numcgm
                             LEFT JOIN sw_classificacao ON sw_classificacao.cod_classificacao = p.cod_classificacao
                             LEFT JOIN sw_assunto ON sw_assunto.cod_assunto = p.cod_assunto AND sw_assunto.cod_classificacao = p.cod_classificacao
                             LEFT JOIN sw_situacao_processo ON sw_situacao_processo.cod_situacao = p.cod_situacao
                             LEFT JOIN administracao.usuario sw_usuario_inclusao ON sw_usuario_inclusao.numcgm = p.cod_usuario
                             LEFT JOIN sw_recebimento ON sw_recebimento.cod_andamento = sw_penultimo_andamento.cod_andamento AND sw_recebimento.cod_processo = p.cod_processo AND sw_recebimento.ano_exercicio = p.ano_exercicio
                             LEFT JOIN sw_recibo_impresso ON sw_recibo_impresso.cod_andamento = sw_penultimo_andamento.cod_andamento AND sw_recibo_impresso.cod_processo = p.cod_processo AND sw_recibo_impresso.ano_exercicio = p.ano_exercicio
                             LEFT JOIN sw_assinatura_digital ON sw_assinatura_digital.cod_andamento = sw_penultimo_andamento.cod_andamento AND sw_assinatura_digital.cod_processo = p.cod_processo AND sw_assinatura_digital.ano_exercicio = p.ano_exercicio
                             LEFT JOIN administracao.usuario sw_usuario_assinatura_digital ON sw_usuario_assinatura_digital.numcgm = sw_assinatura_digital.cod_usuario
                             LEFT JOIN sw_processo_apensado ON sw_processo_apensado.cod_processo_filho = p.cod_processo AND sw_processo_apensado.exercicio_filho = p.ano_exercicio AND sw_processo_apensado.timestamp_desapensamento IS NULL
                             LEFT JOIN sw_processo_arquivado ON sw_processo_arquivado.cod_processo = p.cod_processo AND sw_processo_arquivado.ano_exercicio = p.ano_exercicio
                             LEFT JOIN sw_historico_arquivamento ON sw_historico_arquivamento.cod_historico = sw_processo_arquivado.cod_historico");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
