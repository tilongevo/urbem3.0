<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Imobiliario\AreaLote;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor;
use Urbem\CoreBundle\Entity\Imobiliario\ConfrontacaoExtensao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteBairro;
use Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170419151235 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("
            CREATE OR REPLACE function public.fn_add_col(_tbl regclass, _col  text, _type regtype)
              RETURNS bool AS
            \$func$
            BEGIN
               IF EXISTS (SELECT 1 FROM pg_attribute
                          WHERE  attrelid = _tbl
                          AND    attname = _col
                          AND    NOT attisdropped) THEN
                  RETURN FALSE;
               ELSE
                  EXECUTE format('ALTER TABLE %s ADD COLUMN %I %s', _tbl, _col, _type);
                  RETURN TRUE;
               END IF;
            END
            \$func$  LANGUAGE plpgsql;
        ");
        $this->addSql("SELECT public.fn_add_col('imobiliario.lote', 'localizacao', 'text');");
        $this->addSql("DROP FUNCTION public.fn_add_col(_tbl regclass, _col  text, _type regtype);");

        $this->addSql("DROP VIEW IF EXISTS imobiliario.vw_lote_ativo;");
        $this->addSql("DROP VIEW IF EXISTS imobiliario.vw_area_lote_atual;");
        $this->addSql("DROP VIEW IF EXISTS imobiliario.vw_confrontacao_extensao_atual;");
        $this->addSql("DROP VIEW IF EXISTS imobiliario.vw_localizacao_ativa;");
        $this->addSql("DROP VIEW IF EXISTS imobiliario.vw_trecho_ativo;");

        $this->changeColumnToDateTimeMicrosecondType(Lote::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AreaLote::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ProfundidadeMedia::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LoteBairro::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ConfrontacaoExtensao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoLoteUrbanoValor::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoLoteRuralValor::class, 'timestamp');

        $this->addSql("
            CREATE OR REPLACE VIEW imobiliario.vw_lote_ativo AS
                 SELECT l.cod_lote,
                    l.\"timestamp\",
                    l.dt_inscricao
                   FROM imobiliario.lote l
                     LEFT JOIN ( SELECT bal.cod_lote,
                            bal.\"timestamp\",
                            bal.justificativa,
                            bal.justificativa_termino,
                            bal.dt_inicio,
                            bal.dt_termino
                           FROM imobiliario.baixa_lote bal,
                            ( SELECT max(baixa_lote.\"timestamp\") AS \"timestamp\",
                                    baixa_lote.cod_lote
                                   FROM imobiliario.baixa_lote
                                  GROUP BY baixa_lote.cod_lote) bt
                          WHERE bal.cod_lote = bt.cod_lote AND bal.\"timestamp\" = bt.\"timestamp\") bl ON l.cod_lote = bl.cod_lote
                  WHERE bl.dt_inicio IS NULL OR bl.dt_inicio IS NOT NULL AND bl.dt_termino IS NOT NULL AND bl.cod_lote = l.cod_lote
                  ORDER BY l.cod_lote;
        ");

        $this->addSql("
            CREATE OR REPLACE VIEW imobiliario.vw_area_lote_atual AS
                 SELECT al.cod_lote,
                    al.\"timestamp\",
                    al.cod_grandeza,
                    al.cod_unidade,
                    al.area_real
                   FROM imobiliario.area_lote al,
                    ( SELECT area_lote.cod_lote,
                            max(area_lote.\"timestamp\") AS \"timestamp\"
                           FROM imobiliario.area_lote
                          GROUP BY area_lote.cod_lote) mal
                  WHERE al.cod_lote = mal.cod_lote AND al.\"timestamp\" = mal.\"timestamp\";
        ");

        $this->addSql("
            CREATE OR REPLACE VIEW imobiliario.vw_confrontacao_extensao_atual AS
             SELECT cf.cod_confrontacao,
                cf.cod_lote,
                cf.\"timestamp\",
                cf.valor
               FROM imobiliario.confrontacao_extensao cf,
                ( SELECT confrontacao_extensao.cod_confrontacao,
                        confrontacao_extensao.cod_lote,
                        max(confrontacao_extensao.\"timestamp\") AS \"timestamp\"
                       FROM imobiliario.confrontacao_extensao
                      GROUP BY confrontacao_extensao.cod_confrontacao, confrontacao_extensao.cod_lote) cfa
              WHERE cf.cod_confrontacao = cfa.cod_confrontacao AND cf.cod_lote = cfa.cod_lote AND cf.\"timestamp\" = cfa.\"timestamp\";
        ");

        $this->addSql("
            CREATE OR REPLACE VIEW imobiliario.vw_localizacao_ativa AS
                 SELECT niv.cod_nivel,
                    niv.cod_vigencia,
                    niv.mascara,
                    niv.nom_nivel,
                    loc.cod_localizacao,
                    loc.nom_localizacao,
                    loc.codigo_composto AS valor_composto,
                    publico.fn_mascarareduzida(loc.codigo_composto) AS valor_reduzido,
                    locn.valor
                   FROM ( SELECT loc_1.cod_localizacao,
                            loc_1.nom_localizacao,
                            loc_1.codigo_composto
                           FROM imobiliario.localizacao loc_1
                          WHERE NOT (EXISTS ( SELECT bal.cod_localizacao,
                                    bal.\"timestamp\",
                                    bal.justificativa
                                   FROM imobiliario.baixa_localizacao bal,
                                    ( SELECT max(baixa_localizacao.\"timestamp\") AS \"timestamp\",
                                            baixa_localizacao.cod_localizacao
                                           FROM imobiliario.baixa_localizacao
                                          GROUP BY baixa_localizacao.cod_localizacao) bl
                                  WHERE bal.cod_localizacao = bl.cod_localizacao AND bal.\"timestamp\" = bl.\"timestamp\" AND bl.cod_localizacao = loc_1.cod_localizacao AND bal.dt_inicio IS NOT NULL AND bal.dt_termino IS NULL))) loc,
                    imobiliario.localizacao_nivel locn,
                    ( SELECT max(localizacao_nivel.cod_nivel) AS cod_nivel,
                            localizacao_nivel.cod_vigencia,
                            localizacao_nivel.cod_localizacao
                           FROM imobiliario.localizacao_nivel
                          WHERE localizacao_nivel.valor::integer <> 0
                          GROUP BY localizacao_nivel.cod_vigencia, localizacao_nivel.cod_localizacao) mniv,
                    imobiliario.nivel niv
                  WHERE loc.cod_localizacao = mniv.cod_localizacao AND loc.cod_localizacao = locn.cod_localizacao AND mniv.cod_vigencia = locn.cod_vigencia AND mniv.cod_nivel = locn.cod_nivel AND mniv.cod_vigencia = niv.cod_vigencia AND mniv.cod_nivel = niv.cod_nivel
                  ORDER BY loc.codigo_composto;
        ");

        $this->addSql("
            CREATE OR REPLACE VIEW imobiliario.vw_trecho_ativo AS
                 SELECT t.cod_trecho,
                    t.cod_logradouro,
                    t.sequencia,
                    t.extensao
                   FROM imobiliario.trecho t
                     LEFT JOIN ( SELECT bat.cod_trecho,
                            bat.cod_logradouro,
                            bat.\"timestamp\",
                            bat.justificativa,
                            bat.justificativa_termino,
                            bat.dt_inicio,
                            bat.dt_termino
                           FROM imobiliario.baixa_trecho bat,
                            ( SELECT max(baixa_trecho.\"timestamp\") AS \"timestamp\",
                                    baixa_trecho.cod_logradouro,
                                    baixa_trecho.cod_trecho
                                   FROM imobiliario.baixa_trecho
                                  GROUP BY baixa_trecho.cod_logradouro, baixa_trecho.cod_trecho) bt
                          WHERE bat.cod_trecho = bt.cod_trecho AND bat.cod_logradouro = bt.cod_logradouro AND bat.\"timestamp\" = bt.\"timestamp\") btt ON t.cod_trecho = btt.cod_trecho AND t.cod_logradouro = btt.cod_logradouro
                  WHERE btt.dt_inicio IS NULL OR btt.dt_inicio IS NOT NULL AND btt.dt_termino IS NOT NULL AND btt.cod_trecho = t.cod_trecho AND btt.cod_logradouro = t.cod_logradouro;
        ");

        $this->insertRoute('urbem_tributario_imobiliario_lote_list', 'Cadastro Imobiliário - Lote Urbano/Rural', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_lote_create', 'Incluir', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_edit', 'Alterar', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_delete', 'Excluir', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_show', 'Detalhe', 'urbem_tributario_imobiliario_lote_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
