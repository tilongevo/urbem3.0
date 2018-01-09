<?php

namespace Application\Migrations;

use PDO;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal;
use Urbem\CoreBundle\Entity\Divida\CobrancaJudicial;
use Urbem\CoreBundle\Entity\Divida\DividaEstorno;
use Urbem\CoreBundle\Entity\Economico\DomicilioFiscal;
use Urbem\CoreBundle\Entity\Imobiliario\AreaLote;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoNivelValor;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaLocalizacao;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaLote;
use Urbem\CoreBundle\Entity\Imobiliario\ExProprietario;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelLote;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoAliquota;
use Urbem\CoreBundle\Entity\Imobiliario\LocalizacaoValorM2;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem;
use Urbem\CoreBundle\Entity\Imobiliario\LoteBairro;
use Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado;
use Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovel;
use Urbem\CoreBundle\Entity\Imobiliario\ProfundidadeMedia;
use Urbem\CoreBundle\Entity\Imobiliario\Proprietario;
use Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170803133446 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_divida_ativa_inscricao_divida_consulta_list', 'Consultar Inscrição em Dívida', 'tributario_divida_ativa_consulta_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'tributario_divida_ativa_consulta_home', 'Divida Ativa - Consulta', 'tributario');");

        $stmt = $this->connection->query('
            SELECT
                table_name
            FROM
                information_schema.views
            WHERE
                table_name IN (\'vw_imovel_ativo\',\'vw_max_imovel_lote\',\'vw_lote_ativo\',\'vw_matricula_imovel_atual\',\'vw_unidades\',\'vw_area_lote_atual\',\'vw_localizacao_ativa\')
                AND table_schema = \'imobiliario\';
        ');
        $stmt->execute();
        $views = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (in_array('vw_imovel_ativo', $views)) {
            $this->addSql('DROP VIEW imobiliario.vw_imovel_ativo');
        }

        if (in_array('vw_max_imovel_lote', $views)) {
            $this->addSql('DROP VIEW imobiliario.vw_max_imovel_lote');
        }

        if (in_array('vw_lote_ativo', $views)) {
            $this->addSql('DROP VIEW imobiliario.vw_lote_ativo');
        }
        if (in_array('vw_matricula_imovel_atual', $views)) {
            $this->addSql('DROP VIEW imobiliario.vw_matricula_imovel_atual');
        }
        if (in_array('vw_unidades', $views)) {
            $this->addSql('DROP VIEW imobiliario.vw_unidades');
        }
        if (in_array('vw_area_lote_atual', $views)) {
            $this->addSql('DROP VIEW imobiliario.vw_area_lote_atual');
        }
        if (in_array('vw_localizacao_ativa', $views)) {
            $this->addSql('DROP VIEW imobiliario.vw_localizacao_ativa');
        }

        $this->changeColumnToDateTimeMicrosecondType(Lote::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ImovelLote::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Imovel::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ImovelImobiliaria::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoImovelValor::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BaixaImovel::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ExProprietario::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ImovelProcesso::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(MatriculaImovel::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(Proprietario::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(UnidadeAutonoma::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ImovelVVenal::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(DomicilioFiscal::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ImovelCorrespondencia::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AreaLote::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BaixaLote::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LoteBairro::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LoteProcesso::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LoteamentoLoteOrigem::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ProfundidadeMedia::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LoteParcelado::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoNivelValor::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(BaixaLocalizacao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LocalizacaoAliquota::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(LocalizacaoValorM2::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CobrancaJudicial::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(DividaEstorno::class, 'timestamp');

        if (in_array('vw_imovel_ativo', $views)) {
            $this->addSql('CREATE OR REPLACE VIEW imobiliario.vw_imovel_ativo AS
             SELECT i.inscricao_municipal,
                iil.cod_lote,
                i.cod_sublote,
                ( SELECT max(imovel_lote."timestamp") AS max
                       FROM imobiliario.imovel_lote) AS "timestamp",
                i.dt_cadastro
               FROM imobiliario.imovel i
                 LEFT JOIN ( SELECT bal.inscricao_municipal,
                        bal."timestamp",
                        bal.justificativa,
                        bal.justificativa_termino,
                        bal.dt_inicio,
                        bal.dt_termino
                       FROM imobiliario.baixa_imovel bal,
                        ( SELECT max(baixa_imovel."timestamp") AS "timestamp",
                                baixa_imovel.inscricao_municipal
                               FROM imobiliario.baixa_imovel
                              GROUP BY baixa_imovel.inscricao_municipal) bt
                      WHERE bal.inscricao_municipal = bt.inscricao_municipal AND bal."timestamp" = bt."timestamp") bi ON i.inscricao_municipal = bi.inscricao_municipal
                 JOIN ( SELECT iil_1.inscricao_municipal,
                        iil_1."timestamp",
                        iil_1.cod_lote
                       FROM imobiliario.imovel_lote iil_1,
                        ( SELECT max(imovel_lote."timestamp") AS "timestamp",
                                imovel_lote.inscricao_municipal
                               FROM imobiliario.imovel_lote
                              GROUP BY imovel_lote.inscricao_municipal) il
                      WHERE iil_1.inscricao_municipal = il.inscricao_municipal AND iil_1."timestamp" = il."timestamp") iil ON i.inscricao_municipal = iil.inscricao_municipal
              WHERE bi.dt_inicio IS NULL OR bi.dt_inicio IS NOT NULL AND bi.dt_termino IS NOT NULL AND bi.inscricao_municipal = i.inscricao_municipal;
            ');
        }

        if (in_array('vw_max_imovel_lote', $views)) {
            $this->addSql('CREATE OR REPLACE VIEW imobiliario.vw_max_imovel_lote AS
             SELECT il.inscricao_municipal,
                il.cod_lote,
                il."timestamp"
               FROM imobiliario.imovel_lote il,
                ( SELECT max(il_1."timestamp") AS "timestamp",
                        il_1.inscricao_municipal
                       FROM imobiliario.imovel_lote il_1
                      GROUP BY il_1.inscricao_municipal) mil
              WHERE il.inscricao_municipal = mil.inscricao_municipal AND il."timestamp" = mil."timestamp";
            ');
        }

        if (in_array('vw_lote_ativo', $views)) {
            $this->addSql('CREATE OR REPLACE VIEW imobiliario.vw_lote_ativo AS
             SELECT l.cod_lote,
                l."timestamp",
                l.dt_inscricao
               FROM imobiliario.lote l
                 LEFT JOIN ( SELECT bal.cod_lote,
                        bal."timestamp",
                        bal.justificativa,
                        bal.justificativa_termino,
                        bal.dt_inicio,
                        bal.dt_termino
                       FROM imobiliario.baixa_lote bal,
                        ( SELECT max(baixa_lote."timestamp") AS "timestamp",
                                baixa_lote.cod_lote
                               FROM imobiliario.baixa_lote
                              GROUP BY baixa_lote.cod_lote) bt
                      WHERE bal.cod_lote = bt.cod_lote AND bal."timestamp" = bt."timestamp") bl ON l.cod_lote = bl.cod_lote
              WHERE bl.dt_inicio IS NULL OR bl.dt_inicio IS NOT NULL AND bl.dt_termino IS NOT NULL AND bl.cod_lote = l.cod_lote
              ORDER BY l.cod_lote;
            ');
        }

        if (in_array('vw_matricula_imovel_atual', $views)) {
            $this->addSql('CREATE OR REPLACE VIEW imobiliario.vw_matricula_imovel_atual AS
                         SELECT matricula_imovel.inscricao_municipal,
                            matricula_imovel."timestamp",
                            matricula_imovel.mat_registro_imovel,
                            matricula_imovel.zona
                           FROM imobiliario.matricula_imovel,
                            ( SELECT matricula_imovel_1.inscricao_municipal,
                                    max(matricula_imovel_1."timestamp") AS "timestamp"
                                   FROM imobiliario.matricula_imovel matricula_imovel_1
                                  GROUP BY matricula_imovel_1.inscricao_municipal) max_matricula_imovel
                          WHERE matricula_imovel.inscricao_municipal = max_matricula_imovel.inscricao_municipal AND matricula_imovel."timestamp" = max_matricula_imovel."timestamp";
                        ');
        }

        if (in_array('vw_unidades', $views)) {
            $this->addSql('CREATE OR REPLACE VIEW imobiliario.vw_unidades AS
                                 SELECT uni.inscricao_municipal,
                                    uni.cod_tipo,
                                    uni.cod_tipo_dependente,
                                    uni.cod_construcao,
                                    uni."timestamp",
                                    uni.cod_construcao_dependente,
                                    uni.area,
                                    uni.nom_tipo,
                                    uni.data_construcao,
                                        CASE
                                            WHEN uni.cod_construcao_dependente::character varying::text = 0::text THEN \'Autônoma\'::text
                                            ELSE \'Dependente\'::text
                                        END AS tipo_unidade
                                   FROM ( SELECT ua.inscricao_municipal,
                                            ua.cod_tipo,
                                            ua.cod_tipo AS cod_tipo_dependente,
                                            ua.cod_construcao,
                                            ua."timestamp",
                                            0 AS cod_construcao_dependente,
                                            aua.area,
                                            te.nom_tipo,
                                            to_char(dc.data_construcao::timestamp with time zone, \'DD/MM/YYYY\'::text) AS data_construcao
                                           FROM imobiliario.unidade_autonoma ua
                                             LEFT JOIN ( SELECT bal.inscricao_municipal,
                                                    bal.cod_tipo,
                                                    bal.cod_construcao,
                                                    bal."timestamp",
                                                    bal.justificativa,
                                                    bal.justificativa_termino,
                                                    bal.dt_inicio,
                                                    bal.dt_termino
                                                   FROM imobiliario.baixa_unidade_autonoma bal,
                                                    ( SELECT max(baixa_unidade_autonoma."timestamp") AS "timestamp",
                                                            baixa_unidade_autonoma.inscricao_municipal,
                                                            baixa_unidade_autonoma.cod_tipo,
                                                            baixa_unidade_autonoma.cod_construcao
                                                           FROM imobiliario.baixa_unidade_autonoma
                                                          GROUP BY baixa_unidade_autonoma.inscricao_municipal, baixa_unidade_autonoma.cod_tipo, baixa_unidade_autonoma.cod_construcao) bt
                                                  WHERE bal.inscricao_municipal = bt.inscricao_municipal AND bal.cod_tipo = bt.cod_tipo AND bal.cod_construcao = bt.cod_construcao AND bal."timestamp" = bt."timestamp") bua ON bua.inscricao_municipal = ua.inscricao_municipal AND bua.cod_tipo = ua.cod_tipo AND bua.cod_construcao = ua.cod_construcao
                                             JOIN ( SELECT aua_1.inscricao_municipal,
                                                    aua_1.cod_tipo,
                                                    aua_1.cod_construcao,
                                                    aua_1."timestamp",
                                                    aua_1.area
                                                   FROM imobiliario.area_unidade_autonoma aua_1,
                                                    ( SELECT max(area_unidade_autonoma."timestamp") AS "timestamp",
                                                            area_unidade_autonoma.inscricao_municipal
                                                           FROM imobiliario.area_unidade_autonoma
                                                          GROUP BY area_unidade_autonoma.inscricao_municipal) maua
                                                  WHERE aua_1.inscricao_municipal = maua.inscricao_municipal AND aua_1."timestamp" = maua."timestamp") aua ON ua.inscricao_municipal = aua.inscricao_municipal
                                             LEFT JOIN imobiliario.tipo_edificacao te ON ua.cod_tipo = te.cod_tipo
                                             LEFT JOIN imobiliario.data_construcao dc ON ua.cod_construcao = dc.cod_construcao
                                          WHERE bua.dt_inicio IS NULL OR bua.dt_inicio IS NOT NULL AND bua.dt_termino IS NOT NULL AND bua.inscricao_municipal = ua.inscricao_municipal AND bua.cod_tipo = ua.cod_tipo AND bua.cod_construcao = ua.cod_construcao
                                        UNION
                                         SELECT ud.inscricao_municipal,
                                            ud.cod_tipo,
                                            ce.cod_tipo AS cod_tipo_dependente,
                                            ud.cod_construcao,
                                            ud."timestamp",
                                            ud.cod_construcao_dependente,
                                            aud.area,
                                            te.nom_tipo,
                                            to_char(dc.data_construcao::timestamp with time zone, \'DD/MM/YYYY\'::text) AS data_construcao
                                           FROM imobiliario.construcao_edificacao ce,
                                            imobiliario.unidade_dependente ud
                                             JOIN imobiliario.vw_max_area_un_dep aud ON ud.inscricao_municipal = aud.inscricao_municipal AND aud.cod_construcao_dependente = ud.cod_construcao_dependente
                                             LEFT JOIN ( SELECT bal.inscricao_municipal,
                                                    bal.cod_construcao_dependente,
                                                    bal.cod_construcao,
                                                    bal.cod_tipo,
                                                    bal."timestamp",
                                                    bal.justificativa,
                                                    bal.justificativa_termino,
                                                    bal.dt_inicio,
                                                    bal.dt_termino
                                                   FROM imobiliario.baixa_unidade_dependente bal,
                                                    ( SELECT max(baixa_unidade_dependente."timestamp") AS "timestamp",
                                                            baixa_unidade_dependente.inscricao_municipal,
                                                            baixa_unidade_dependente.cod_tipo,
                                                            baixa_unidade_dependente.cod_construcao,
                                                            baixa_unidade_dependente.cod_construcao_dependente
                                                           FROM imobiliario.baixa_unidade_dependente
                                                          GROUP BY baixa_unidade_dependente.inscricao_municipal, baixa_unidade_dependente.cod_tipo, baixa_unidade_dependente.cod_construcao, baixa_unidade_dependente.cod_construcao_dependente) bt
                                                  WHERE bal.inscricao_municipal = bt.inscricao_municipal AND bal.cod_tipo = bt.cod_tipo AND bal.cod_construcao = bt.cod_construcao AND bal.cod_construcao_dependente = bt.cod_construcao_dependente AND bal."timestamp" = bt."timestamp") bud ON bud.inscricao_municipal = ud.inscricao_municipal AND bud.cod_tipo = ud.cod_tipo AND bud.cod_construcao = ud.cod_construcao AND bud.cod_construcao_dependente = ud.cod_construcao_dependente
                                             LEFT JOIN imobiliario.tipo_edificacao te ON ud.cod_tipo = te.cod_tipo
                                             LEFT JOIN imobiliario.data_construcao dc ON dc.cod_construcao = ud.cod_construcao_dependente
                                          WHERE aud.inscricao_municipal = ud.inscricao_municipal AND ce.cod_construcao = ud.cod_construcao_dependente AND (bud.dt_inicio IS NULL OR bud.dt_inicio IS NOT NULL AND bud.dt_termino IS NOT NULL AND bud.inscricao_municipal = ud.inscricao_municipal AND bud.cod_tipo = ud.cod_tipo AND bud.cod_construcao = ud.cod_construcao AND bud.cod_construcao_dependente = ud.cod_construcao_dependente)) uni;
                                ');
        }

        if (in_array('vw_area_lote_atual', $views)) {
            $this->addSql('CREATE OR REPLACE VIEW imobiliario.vw_area_lote_atual AS
                 SELECT al.cod_lote,
                    al."timestamp",
                    al.cod_grandeza,
                    al.cod_unidade,
                    al.area_real
                   FROM imobiliario.area_lote al,
                    ( SELECT area_lote.cod_lote,
                            max(area_lote."timestamp") AS "timestamp"
                           FROM imobiliario.area_lote
                          GROUP BY area_lote.cod_lote) mal
                  WHERE al.cod_lote = mal.cod_lote AND al."timestamp" = mal."timestamp";
                ');
        }

        if (in_array('vw_localizacao_ativa', $views)) {
            $this->addSql('CREATE OR REPLACE VIEW imobiliario.vw_localizacao_ativa AS
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
                                    bal."timestamp",
                                    bal.justificativa
                                   FROM imobiliario.baixa_localizacao bal,
                                    ( SELECT max(baixa_localizacao."timestamp") AS "timestamp",
                                            baixa_localizacao.cod_localizacao
                                           FROM imobiliario.baixa_localizacao
                                          GROUP BY baixa_localizacao.cod_localizacao) bl
                                  WHERE bal.cod_localizacao = bl.cod_localizacao AND bal."timestamp" = bl."timestamp" AND bl.cod_localizacao = loc_1.cod_localizacao AND bal.dt_inicio IS NOT NULL AND bal.dt_termino IS NULL))) loc,
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
                ');
        }

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_busca_origem_inscricao_divida_ativa(integer, integer, integer)
         RETURNS character varying
         LANGUAGE plpgsql
        AS $function$
        declare
            inCodInscricao    	ALIAS FOR $1;
            inExercicio         ALIAS FOR $2;
            inTipo              ALIAS FOR $3;
            stOrigem            VARCHAR := \'\';
            stSQL2              VARCHAR;
            stSQL1              VARCHAR;
            reRecordExecuta     RECORD;
            reRecordExecuta2    RECORD;
        
        begin
        
        -- TIPO :
            -- caso esteja com valor 0, mostra codigo do grupo / grupo_descricao
            -- caso esteja com valor 1, mostra codigo do grupo / ano exercicio
            -- caso valor = 2, mostra cod_grupo, cod_modulo , descricao e ano_exercicio
        
            stSQL2 := \'
                SELECT DISTINCT
                    (
                        CASE WHEN lancamento.divida = true THEN
                            \'\'DA\'\'
                        ELSE
                            CASE WHEN acgc.cod_grupo IS NOT NULL THEN
                                CASE WHEN ( \'|| inTipo ||\' = 1 OR \'|| inTipo ||\' = 4 )  THEN
                                    agc.descricao||\'\' / \'\'|| acgc.ano_exercicio 
                                ELSE
                                    CASE WHEN \'|| inTipo ||\' = 2 THEN
                                        \'\'§\'\'|| acgc.cod_grupo||\'\'§\'\'|| agc.descricao||\'\'§\'\'|| acgc.ano_exercicio||\'\'§§\'\'|| agc.cod_modulo
                                    ELSE
                                        CASE WHEN \'|| inTipo ||\' = 6 THEN
                                            acgc.cod_grupo||\'\' / \'\'|| acgc.ano_exercicio||\'\' - \'\'|| agc.descricao
                                        ELSE
                                            acgc.cod_grupo||\'\' § \'\'|| agc.descricao
                                        END
                                    END
                                END
                            ELSE
                                CASE WHEN ( \'|| inTipo ||\' = 1 OR \'|| inTipo ||\' = 4 )  THEN
                                    mc.descricao_credito||\'\' / \'\'|| ac.exercicio
                                ELSE
                                    CASE WHEN \'|| inTipo ||\' = 2 THEN
                                        mc.cod_credito||\'\'§§\'\'|| mc.descricao_credito||\'\'§\'\'|| ac.exercicio||\'\'§§\'\'|| mc.cod_especie||\'\'§\'\'|| mc.cod_genero||\'\'§\'\'|| mc.cod_natureza
                                    ELSE
                                        to_char(mc.cod_credito,\'\'FM999099\'\')||\'\'.\'\'|| to_char(mc.cod_especie,\'\'FM999099\'\')||\'\'.\'\'|| to_char(mc.cod_genero,\'\'FM999099\'\')||\'\'.\'\'|| mc.cod_natureza||\'\' - \'\'|| mc.descricao_credito||\'\' \'\'|| ac.exercicio
                                    END
                                END
                            END
                        END
                    )::varchar AS stOrigem,
                    CASE WHEN acgc.cod_grupo IS NOT NULL THEN
                        1
                    ELSE
                        0
                    END::integer AS inEhGrupo
        
                FROM
                    divida.divida_parcelamento
                
                INNER JOIN
                    (
                        --validar cobranca
                        SELECT
                            min( divida_parcelamento.num_parcelamento ) AS num_parcelamento,
                            divida_parcelamento.cod_inscricao,
                            divida_parcelamento.exercicio
                
                        FROM
                            divida.divida_parcelamento
                
                        LEFT JOIN
                            divida.parcela
                        ON
                            parcela.num_parcelamento = divida_parcelamento.num_parcelamento
                
                        WHERE
                            CASE WHEN parcela.num_parcelamento IS NOT NULL THEN
                                CASE WHEN ( 
                                    SELECT
                                        t.num_parcelamento
                                    FROM
                                        divida.parcela AS t
                                    WHERE
                                        t.num_parcelamento = divida_parcelamento.num_parcelamento
                                        AND t.cancelada = true
                                    LIMIT 1
                                ) IS NULL THEN
                                    true
                                ELSE
                                    false
                                END
                            ELSE
                                true
                            END
                
                        GROUP BY
                            divida_parcelamento.cod_inscricao,
                            divida_parcelamento.exercicio
                    )AS parcelamento
                ON
                    parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento
                    AND parcelamento.cod_inscricao = divida_parcelamento.cod_inscricao
                    AND parcelamento.exercicio = divida_parcelamento.exercicio
                
                INNER JOIN
                    divida.parcela_origem
                ON
                    parcela_origem.num_parcelamento = divida_parcelamento.num_parcelamento
                
                INNER JOIN
                    arrecadacao.parcela
                ON
                    parcela.cod_parcela = parcela_origem.cod_parcela
                
                INNER JOIN 
                    arrecadacao.lancamento_calculo
                ON
                    lancamento_calculo.cod_lancamento = parcela.cod_lancamento
                
                INNER JOIN
                    arrecadacao.lancamento
                ON
                    lancamento.cod_lancamento = lancamento_calculo.cod_lancamento
                
                INNER JOIN
                    arrecadacao.calculo AS ac
                ON
                    ac.cod_calculo = lancamento_calculo.cod_calculo
                
                INNER JOIN 
                    monetario.credito as mc
                ON 
                    mc.cod_credito = ac.cod_credito
                    AND mc.cod_especie = ac.cod_especie
                    AND mc.cod_genero = ac.cod_genero
                    AND mc.cod_natureza = ac.cod_natureza
                
                LEFT JOIN 
                    arrecadacao.calculo_grupo_credito as acgc
                ON 
                    acgc.cod_calculo = ac.cod_calculo
                    AND acgc.ano_exercicio = ac.exercicio
                
                LEFT JOIN 
                    arrecadacao.grupo_credito as agc
                ON 
                    agc.cod_grupo = acgc.cod_grupo
                    AND agc.ano_exercicio = acgc.ano_exercicio
                
                WHERE
                    divida_parcelamento.cod_inscricao = \'|| inCodInscricao ||\'
                    AND divida_parcelamento.exercicio = \'\'\'|| inExercicio ||\'\'\'
            \';
        
            FOR reRecordExecuta2 IN EXECUTE stSQL2 LOOP
                IF ( reRecordExecuta2.stOrigem = \'DA\' ) THEN
                    stSQL1 := \'
                        SELECT DISTINCT
                            \'\'§§DA - \'\'||  ddp.cod_inscricao ||\'\'§\'\'|| ddp.exercicio AS origem
        
                        FROM
                            divida.parcelamento as dp
        
                        INNER JOIN 
                            divida.divida_parcelamento as ddp
                        ON 
                            ddp.num_parcelamento = dp.num_parcelamento
        
                        INNER JOIN 
                            divida.parcela as dpar
                        ON 
                            dpar.num_parcelamento = dp.num_parcelamento
        
                        INNER JOIN 
                            divida.parcela_calculo as dpc
                        ON 
                            dpc.num_parcelamento = dpar.num_parcelamento
                            AND dpc.num_parcela = dpar.num_parcela
        
                        INNER JOIN 
                            arrecadacao.lancamento_calculo as alc
                        ON 
                            alc.cod_calculo = dpc.cod_calculo
        
                        WHERE
                            alc.cod_lancamento in (
                                SELECT DISTINCT
                                    parcela.cod_lancamento
                                FROM
                                    divida.divida_parcelamento
            
                                INNER JOIN
                                    divida.parcela_origem
                                ON
                                    parcela_origem.num_parcelamento = divida_parcelamento.num_parcelamento
            
                                INNER JOIN
                                    arrecadacao.parcela
                                ON
                                    parcela.cod_parcela = parcela_origem.cod_parcela
            
                                WHERE
                                    divida_parcelamento.cod_inscricao = \'|| inCodInscricao ||\'
                                    AND divida_parcelamento.exercicio = \'\'\'|| inExercicio ||\'\'\'
                            );
                    \';
        
                    FOR reRecordExecuta IN EXECUTE stSQL1 LOOP
                        stOrigem := reRecordExecuta.stOrigem ||\'; \'|| reRecordExecuta2.stOrigem ||\'; \'|| stOrigem;
                    END LOOP;
                ELSEIF ( reRecordExecuta2.inEhGrupo = 1 ) THEN
                    stSQL1 := \'
                        SELECT DISTINCT
                            CASE WHEN \'|| inTipo ||\' = 4 THEN
                                credito.descricao_credito
                            ELSE
                                to_char(credito.cod_credito,\'\'FM999099\'\')||\'\'.\'\'|| to_char(credito.cod_especie,\'\'FM999099\'\')||\'\'.\'\'|| to_char(credito.cod_genero,\'\'FM999099\'\')||\'\'.\'\'|| credito.cod_natureza||\'\' - \'\'|| credito.descricao_credito
                            END AS cred_desc
        
                        FROM
                            divida.divida_parcelamento               
        
                         INNER JOIN ( SELECT divida_parcelamento.cod_inscricao
                                           , divida_parcelamento.exercicio
                                           , max(divida_parcelamento.num_parcelamento) AS num_parcelamento
                                        FROM divida.divida_parcelamento
                       LEFT JOIN divida.parcelamento_cancelamento
                          ON divida_parcelamento.num_parcelamento = parcelamento_cancelamento.num_parcelamento
                           WHERE parcelamento_cancelamento.num_parcelamento IS NULL
                                    GROUP BY divida_parcelamento.cod_inscricao
                                           , divida_parcelamento.exercicio
                                    )AS parcelamento
        
                                 ON parcelamento.cod_inscricao = divida_parcelamento.cod_inscricao
                                AND parcelamento.exercicio = divida_parcelamento.exercicio                  
        
                        INNER JOIN
                            divida.parcela_origem
                        ON
                            parcela_origem.num_parcelamento = divida_parcelamento.num_parcelamento
        
                        INNER JOIN 
                            monetario.credito
                        ON 
                            credito.cod_credito = parcela_origem.cod_credito
                            AND credito.cod_especie = parcela_origem.cod_especie
                            AND credito.cod_genero = parcela_origem.cod_genero
                            AND credito.cod_natureza = parcela_origem.cod_natureza
        
                        WHERE
                            divida_parcelamento.cod_inscricao = \'|| inCodInscricao ||\'
                            AND divida_parcelamento.exercicio = \'\'\'|| inExercicio ||\'\'\'\';
        
                    FOR reRecordExecuta IN EXECUTE stSQL1 LOOP
                        IF ( stOrigem IS NOT NULL ) THEN
                            stOrigem := \'; \'|| stOrigem;
                        END IF;
        
                        IF ( inTipo = 4 ) THEN
                            stOrigem := reRecordExecuta.cred_desc ||\' - \'|| reRecordExecuta2.stOrigem;
                        ELSE
                            stOrigem := reRecordExecuta.cred_desc ||\'; \'|| reRecordExecuta2.stOrigem;
                        END IF;
        
                    END LOOP;
                ELSE
                    stOrigem := reRecordExecuta2.stOrigem ||\'; \'|| stOrigem;
                END IF;
            END LOOP;
        
            return stOrigem;
        
        end;
        $function$;
        ');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_busca_origem_lancamento_sem_exercicio(integer, integer, integer)
         RETURNS character varying
         LANGUAGE plpgsql
        AS $function$
        declare
            inCodLancamento    	ALIAS FOR $1;
            inTipoGrupo         ALIAS FOR $2;
            inTipoCredito       ALIAS FOR $3;
            stOrigem            VARCHAR := \'\';
            stGrupo             VARCHAR := \'\';
            inNumParcelamento   INTEGER;
            reRecordFuncoes 	RECORD;
            stSqlFuncoes        VARCHAR;
        begin
        
        -- TIPO GRUPO:
            -- caso esteja com valor 0, mostra codigo do grupo / grupo_descricao
            -- caso esteja com valor 1, mostra codigo do grupo / ano exercicio
            -- caso valor = 2, mostra cod_grupo, cod_modulo , descricao e ano_exercicio
        
        -- TIPO CREDITO:
            -- caso esteja com valor 0, mostra codigo do credito - cod_especie - cod_genero - cod_natureza - descricao
            -- caso esteja com valor 1, mostra apenas descricao_credito
        
            SELECT
                (   CASE WHEN al.divida = true THEN
                        \'DA\'
                    ELSE
                        CASE WHEN acgc.cod_grupo IS NOT NULL THEN
                            CASE WHEN inTipoGrupo = 1 THEN
                                agc.descricao||\' / \'||acgc.ano_exercicio
                            ELSE
                                CASE WHEN inTipoGrupo = 2 THEN
                                    \'§\'||acgc.cod_grupo||\'§\'||agc.descricao||\'§\'||acgc.ano_exercicio||\'§§\'||agc.cod_modulo
                                ELSE
                                    acgc.cod_grupo||\' § \'||agc.descricao
                                END
                            END
                        ELSE
                            CASE WHEN inTipoCredito = 1 THEN
                                mc.descricao_credito||\' / \'||ac.exercicio
                            ELSE
                                CASE WHEN inTipoGrupo = 2 THEN
                                    mc.cod_credito||\'§§\'||mc.descricao_credito||\'§\'||ac.exercicio||\'§§\'||mc.cod_especie||\'§\'||mc.cod_genero||\'§\'||mc.cod_natureza
                                ELSE
                                    mc.cod_credito||\'.\'||mc.cod_especie||\'.\'||mc.cod_genero||\'.\'||mc.cod_natureza||\'.\'||mc.descricao_credito
                                END
                            END
                        END
                    END
                )::varchar
            INTO 
                stOrigem
            FROM
                arrecadacao.lancamento as al
        
                INNER JOIN (
                    SELECT
                        cod_lancamento
                        , max(cod_calculo) as cod_calculo
                    FROM arrecadacao.lancamento_calculo
                    GROUP BY
                        cod_lancamento
                ) as alc
                ON alc.cod_lancamento = al.cod_lancamento
        
                INNER JOIN arrecadacao.calculo as ac
                            ON ac.cod_calculo = alc.cod_calculo
        
                 LEFT JOIN arrecadacao.calculo_grupo_credito as acgc		
                          ON acgc.cod_calculo = ac.cod_calculo
                    --   AND acgc.ano_exercicio = ac.exercicio
        
                 LEFT JOIN arrecadacao.grupo_credito as agc
                          ON agc.cod_grupo = acgc.cod_grupo
                        AND agc.ano_exercicio = acgc.ano_exercicio
        
                LEFT JOIN monetario.credito as mc	
                         ON mc.cod_credito = ac.cod_credito
                       AND mc.cod_especie = ac.cod_especie
                       AND mc.cod_genero = ac.cod_genero
                       AND mc.cod_natureza = ac.cod_natureza
            
                WHERE al.cod_lancamento = inCodLancamento
        --        and ac.exercicio = inExercicio;
                ;
        
        
            IF ( stOrigem = \'DA\' ) THEN
            SELECT distinct num_parcelamento 
                INTO
                    inNumParcelamento
                FROM divida.parcela_calculo as dpc
                    INNER JOIN arrecadacao.lancamento_calculo as alc
                    ON alc.cod_calculo = dpc.cod_calculo
                WHERE
                    alc.cod_lancamento = inCodLancamento;
        
         stSqlFuncoes := \'
                SELECT
                    DIVIDA_PARCELAMENTO.cod_inscricao,
                    DIVIDA_PARCELAMENTO.exercicio
        
                FROM
                    DIVIDA.DIVIDA_PARCELAMENTO
                WHERE
                    DIVIDA_PARCELAMENTO.num_parcelamento = \'||inNumParcelamento||\'
            \';
            stOrigem := \'§§\';
            FOR reRecordFuncoes IN EXECUTE stSqlFuncoes LOOP
                stOrigem := stOrigem || \'DA - \' || reRecordFuncoes.cod_inscricao || \'/\' || reRecordFuncoes.exercicio || \'<br>\';
            END LOOP;
            stOrigem := stOrigem || \'§\';
        
            END IF;
        
        
            
            return stOrigem;
            --
        end;
        $function$;
        ');
        $this->addSql('CREATE OR REPLACE FUNCTION monetario.fn_busca_mascara_credito(integer, integer, integer, integer)
     RETURNS character varying
     LANGUAGE plpgsql
    AS $function$
    DECLARE
    
        inCodCredito    ALIAS FOR $1;
        inCodEspecie    ALIAS FOR $2;
        inCodGenero     ALIAS FOR $3;
        inCodNatureza   ALIAS FOR $4;
        stRetorno       VARCHAR;
        reRecord        record;
        stSql 			VARCHAR;
        
    BEGIN
    
    stSql = \'
        SELECT
            c.descricao_credito,
            lpad ( c.cod_credito::varchar, max_credito.valor, \'\'0\'\' ) as cod_credito,
            lpad ( c.cod_especie::varchar, max_especie.valor, \'\'0\'\' ) as cod_especie,
            lpad ( c.cod_genero::varchar,  max_genero.valor, \'\'0\'\' ) as cod_genero,
            lpad ( c.cod_natureza::varchar, max_natureza.valor, \'\'0\'\' ) as cod_natureza,
    
            ( lpad ( c.cod_credito::varchar, max_credito.valor, \'\'0\'\' )||\'\'.\'\'|| lpad( c.cod_especie::varchar, max_especie.valor, \'\'0\'\' )||\'\'.\'\'|| lpad (c.cod_genero::varchar, max_genero.valor, \'\'0\'\' )||\'\'.\'\'|| lpad( c.cod_natureza::varchar, max_natureza.valor, \'\'0\'\' )) as codigo_composto
    
        FROM
            monetario.credito as c,
            ( select length(max(cod_credito)::varchar) as valor from monetario.credito ) as max_credito,
            ( select length(max(cod_genero)::varchar) as valor from monetario.genero_credito ) as max_genero,
            ( select length(max(cod_especie)::varchar) as valor from monetario.especie_credito ) as max_especie,
            ( select length(max(cod_natureza)::varchar) as valor from monetario.natureza_credito ) as max_natureza
        WHERE
            c.cod_credito = \'|| inCodCredito ||\'
            AND c.cod_especie   = \'|| inCodEspecie ||\'
            AND c.cod_genero    = \'|| inCodGenero ||\'
            AND c.cod_natureza  = \'|| inCodNatureza ||\'
        GROUP BY
            c.cod_credito, c.descricao_credito, c.cod_especie, c.cod_genero, c.cod_natureza,
            max_credito.valor, max_especie.valor, max_genero.valor, max_natureza.valor
        \';
    
        FOR reRecord IN EXECUTE stSql LOOP
            stRetorno := reRecord.codigo_composto;
            stRetorno := stRetorno||\'§\'||reRecord.cod_credito;
            stRetorno := stRetorno||\'§\'||reRecord.cod_especie;
            stRetorno := stRetorno||\'§\'||reRecord.cod_genero;
            stRetorno := stRetorno||\'§\'||reRecord.cod_natureza;
            stRetorno := stRetorno||\'§\'||reRecord.descricao_credito;
        END LOOP;
    
        RETURN stRetorno;
    END;
    $function$;
    ');
        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_total_parcelas_aberto(integer, character)
                 RETURNS integer
                 LANGUAGE plpgsql
                AS $function$
                declare
                    inLancamento    ALIAS FOR $1;
                    stExercicio     ALIAS FOR $2;
                    inSoma          integer := 0;
                    inTotalPagas    integer;
                    inTotalParcelas integer;
                    reRecord        record;
                
                begin
                
                    SELECT * INTO inTotalParcelas FROM arrecadacao.fn_total_parcelas ( inLancamento );
                    SELECT * INTO inTotalPagas FROM arrecadacao.fn_total_parcelas_pagas ( inLancamento, stExercicio );
                
                    inSoma = inTotalParcelas - inTotalPagas;
                
                    return coalesce ( inSoma, 0 );
                
                end;
                
                $function$;
                ');

        $this->addSql('CREATE OR REPLACE FUNCTION public.aplica_acrescimo_modalidade(integer, integer, integer, integer, integer, integer, numeric, date, date, text)
                         RETURNS character varying
                         LANGUAGE plpgsql
                        AS $function$
                        declare
                            inCobrancaJudicial  ALIAS FOR $1;
                            inCodInscricao      ALIAS FOR $2;
                            inExercicio         ALIAS FOR $3;
                            inCodModalidade     ALIAS FOR $4;
                            inCodTipo           ALIAS FOR $5;
                            inRegistro          ALIAS FOR $6;
                            nuValor2            ALIAS FOR $7;
                            nuValor         NUMERIC;
                            dtDataVencimento    ALIAS FOR $8;
                            dtDataBase          ALIAS FOR $9;
                            boIncidencia        ALIAS FOR $10;
                            stSqlFuncoes        VARCHAR;
                            stExecuta           VARCHAR;
                            stRetorno           VARCHAR;
                            stTabela            VARCHAR;
                            stValores           VARCHAR := \'\';
                            inValorTotal        NUMERIC := 0.00;
                            reRecordFuncoes     RECORD;
                            reRecordExecuta     RECORD;
                            boUtilizar          BOOLEAN;
                            inTMP               INTEGER;
                            dtTimestamp         TIMESTAMP;
                            boUsaTimestamp      BOOLEAN;
                            stTMP               TEXT;
                        
                        begin
                            inTMP := criarbufferinteiro( \'inCodInscricao\', inCodInscricao );
                            inTMP := criarbufferinteiro( \'inExercicio\', inExercicio );
                            inTMP := criarbufferinteiro( \'inCodModalidade\', inCodModalidade );
                            inTMP := criarbufferinteiro( \'inRegistro\', inRegistro );
                            stTMP := criarbuffertexto( \'boIncidencia\', boIncidencia );
                            inTMP := criarbufferinteiro( \'judicial\', inCobrancaJudicial );
                        if nuValor2 IS NULL THEN nuValor := 0; ELSE nuValor = nuValor2;END IF;
                        
                            stSqlFuncoes := \'
                                SELECT
                                    administracao.funcao.nom_funcao as funcao
                                    , divida.modalidade_acrescimo.cod_acrescimo
                                    , divida.modalidade_acrescimo.cod_tipo
                                    , (
                                        SELECT
                                            administracao.funcao.nom_funcao
                                        FROM
                                            administracao.funcao
                                        WHERE
                                            administracao.funcao.cod_funcao = divida.modalidade_acrescimo.cod_funcao
                                            AND administracao.funcao.cod_modulo = divida.modalidade_acrescimo.cod_modulo
                                            AND administracao.funcao.cod_biblioteca = divida.modalidade_acrescimo.cod_biblioteca
                                      )AS funcao_valida
                        
                                FROM
                                    divida.modalidade
                                
                                INNER JOIN
                                    divida.modalidade_vigencia
                                ON
                                    divida.modalidade_vigencia.timestamp = divida.modalidade.ultimo_timestamp
                                    AND divida.modalidade_vigencia.cod_modalidade = divida.modalidade.cod_modalidade
                                
                                INNER JOIN
                                    divida.modalidade_acrescimo
                                ON
                                    divida.modalidade_acrescimo.timestamp = divida.modalidade.ultimo_timestamp
                                    AND divida.modalidade_acrescimo.cod_modalidade = divida.modalidade.cod_modalidade
                                \';
                                IF inCodTipo != 0 THEN
                                    stSqlFuncoes := stSqlFuncoes || \' AND divida.modalidade_acrescimo.cod_tipo = \'|| inCodTipo ||\' \';
                                END IF;
                                
                                stSqlFuncoes := stSqlFuncoes || \' 
                                    AND divida.modalidade_acrescimo.pagamento = \'|| boIncidencia ||\'
                                
                                INNER JOIN
                                    (
                                        SELECT
                                            tmp.*
                                        FROM
                                           monetario.formula_acrescimo AS tmp,
                                           (
                               \';
                               --AJUSTE FEITO PARA RECUPERAR A FUNÇÃO QUE FOI UTILIZADA NO MOMENTO DA COBRANÇA
                               IF COALESCE(recuperarbuffertexto(\'boConsulta\'),\'false\') = \'true\' THEN
                                    IF (inRegistro = 0) THEN
                                        dtTimestamp := now();
                                    ELSE
                                        SELECT timestamp INTO dtTimestamp FROM divida.parcelamento WHERE num_parcelamento = inRegistro;
                                    END IF;
                        
                                    SELECT CASE WHEN timestamp IS NULL THEN
                                                false
                                           ELSE
                                                true
                                           END INTO boUsaTimestamp
                                      FROM monetario.formula_acrescimo
                                     WHERE timestamp <= dtTimestamp;
                        
                                  IF boUsaTimestamp THEN
                                        stSqlFuncoes := stSqlFuncoes || \' SELECT MAX(timestamp)AS timestamp
                                                                            , cod_tipo
                                                                            , cod_acrescimo
                                                                         FROM monetario.formula_acrescimo
                                                                        WHERE timestamp <= \'|| quote_literal(dtTimestamp) ||\' \';
                                  ELSE
                                       stSqlFuncoes := stSqlFuncoes || \' SELECT MIN(timestamp)AS timestamp
                                                                            , cod_tipo
                                                                            , cod_acrescimo
                                                                         FROM monetario.formula_acrescimo\';
                                  END IF;
                               ELSE
                                    stSqlFuncoes := stSqlFuncoes || \' SELECT MAX(timestamp)AS timestamp
                                                                            , cod_tipo
                                                                            , cod_acrescimo
                                                                         FROM monetario.formula_acrescimo\';
                               END IF;
                               stSqlFuncoes := stSqlFuncoes || \'
                                                GROUP BY cod_tipo, cod_acrescimo
                                           )AS tmp2
                                        WHERE
                                            tmp.timestamp = tmp2.timestamp
                                            AND tmp.cod_tipo = tmp2.cod_tipo
                                            AND tmp.cod_acrescimo = tmp2.cod_acrescimo
                                    )AS mfa
                                ON
                                    mfa.cod_acrescimo = divida.modalidade_acrescimo.cod_acrescimo
                                    AND mfa.cod_tipo = divida.modalidade_acrescimo.cod_tipo
                                
                                INNER JOIN
                                    administracao.funcao
                                ON
                                    administracao.funcao.cod_funcao = mfa.cod_funcao
                                    AND administracao.funcao.cod_modulo = mfa.cod_modulo
                                    AND administracao.funcao.cod_biblioteca = mfa.cod_biblioteca
                                
                                WHERE
                                    divida.modalidade.cod_modalidade = \'|| inCodModalidade ||\'
                            \';
                            IF ( dtDataVencimento <= dtDataBase ) THEN
                                -- executa
                                FOR reRecordFuncoes IN EXECUTE stSqlFuncoes LOOP
                                    stExecuta :=  \'SELECT \'||reRecordFuncoes.funcao_valida||\'( \'||inRegistro||\' ) as utilizar \';
                                    FOR reRecordExecuta IN EXECUTE stExecuta LOOP
                                        boUtilizar := reRecordExecuta.utilizar;
                                    END LOOP;
                                    IF ( boUtilizar ) THEN 
                                        stExecuta :=  \'SELECT \'||reRecordFuncoes.funcao||\'(\'|| quote_literal(dtDataVencimento)||\',\'|| quote_literal(dtDataBase)||\',\'||nuValor||\', \'||reRecordFuncoes.cod_acrescimo||\' , \'||reRecordFuncoes.cod_tipo||\') as valor \';
                                        FOR reRecordExecuta IN EXECUTE stExecuta LOOP                
                                            inValorTotal := inValorTotal + reRecordExecuta.valor;
                                            stValores := stValores || \';\' || reRecordExecuta.valor || \';\' || reRecordFuncoes.cod_acrescimo || \';\' || reRecordFuncoes.cod_tipo;
                                        END LOOP;           
                                    END IF;
                                END LOOP;
                            END IF;
                        
                            stRetorno := inValorTotal || stValores;
                           return stRetorno;
                        end;
                        $function$;
                        ');

        $this->addSql('CREATE OR REPLACE FUNCTION public.aplica_acrescimo_modalidade(integer, integer, integer, numeric, date, date)
                 RETURNS character varying
                 LANGUAGE plpgsql
                AS $function$
                declare
                    inCodModalidade     ALIAS FOR $1;
                    inCodTipo           ALIAS FOR $2;
                    inRegistro          ALIAS FOR $3;
                    nuValor             ALIAS FOR $4;
                    dtDataVencimento    ALIAS FOR $5;
                    dtDataBase          ALIAS FOR $6;
                    stSqlFuncoes        VARCHAR;
                    stExecuta           VARCHAR;
                    stRetorno           VARCHAR;
                    stValores           VARCHAR := \'\';
                    inValorTotal        NUMERIC := 0.00;
                    reRecordFuncoes     RECORD;
                    reRecordExecuta     RECORD;
                    boUtilizar          BOOLEAN;
                
                begin
                    stSqlFuncoes := \'                                       
                        SELECT
                            administracao.funcao.nom_funcao as funcao
                            , divida.modalidade_acrescimo.cod_acrescimo
                            , divida.modalidade_acrescimo.cod_tipo
                            , (
                                SELECT
                                    administracao.funcao.nom_funcao
                                FROM
                                    administracao.funcao
                                WHERE
                                    administracao.funcao.cod_funcao = divida.modalidade_acrescimo.cod_funcao
                                    AND administracao.funcao.cod_modulo = divida.modalidade_acrescimo.cod_modulo
                                    AND administracao.funcao.cod_biblioteca = divida.modalidade_acrescimo.cod_biblioteca
                              )AS funcao_valida
                
                        FROM
                            divida.modalidade
                        
                        INNER JOIN
                            divida.modalidade_vigencia
                        ON
                            divida.modalidade_vigencia.timestamp = divida.modalidade.ultimo_timestamp
                            AND divida.modalidade_vigencia.cod_modalidade = divida.modalidade.cod_modalidade
                        
                        INNER JOIN
                            divida.modalidade_acrescimo
                        ON
                            divida.modalidade_acrescimo.timestamp = divida.modalidade.ultimo_timestamp
                            AND divida.modalidade_acrescimo.cod_modalidade = divida.modalidade.cod_modalidade
                            AND divida.modalidade_acrescimo.cod_tipo = \'||inCodTipo||\'
                        
                        INNER JOIN
                            (
                                SELECT
                                    tmp.*
                                FROM
                                   monetario.formula_acrescimo AS tmp,
                                   (
                                        SELECT
                                            MAX(timestamp)AS timestamp,
                                            cod_tipo,
                                            cod_acrescimo
                                        FROM
                                            monetario.formula_acrescimo
                                        GROUP BY
                                            cod_tipo, cod_acrescimo
                                   )AS tmp2
                                WHERE
                                    tmp.timestamp = tmp2.timestamp
                                    AND tmp.cod_tipo = tmp2.cod_tipo
                                    AND tmp.cod_acrescimo = tmp2.cod_acrescimo
                            )AS mfa
                        ON
                            mfa.cod_acrescimo = divida.modalidade_acrescimo.cod_acrescimo
                            AND mfa.cod_tipo = divida.modalidade_acrescimo.cod_tipo
                        
                        INNER JOIN
                            administracao.funcao
                        ON
                            administracao.funcao.cod_funcao = mfa.cod_funcao
                            AND administracao.funcao.cod_modulo = mfa.cod_modulo
                            AND administracao.funcao.cod_biblioteca = mfa.cod_biblioteca
                        
                        WHERE
                            divida.modalidade.cod_modalidade = \'||inCodModalidade||\'
                    \';
                
                    IF ( dtDataVencimento < dtDataBase ) THEN
                        -- executa
                        FOR reRecordFuncoes IN EXECUTE stSqlFuncoes LOOP
                    
                            stExecuta :=  \'SELECT \'||reRecordFuncoes.funcao_valida||\'( \'||inRegistro||\' ) as utilizar \';
                            FOR reRecordExecuta IN EXECUTE stExecuta LOOP
                                boUtilizar := reRecordExecuta.utilizar;
                            END LOOP;
                    
                            IF ( boUtilizar ) THEN 
                                stExecuta :=  \'SELECT \'||reRecordFuncoes.funcao||\'(\'\'\'||dtDataVencimento||\'\'\',\'\'\'||dtDataBase||\'\'\',\'||nuValor||\', \'||reRecordFuncoes.cod_acrescimo||\' , \'||reRecordFuncoes.cod_tipo||\') as valor \';     
                                FOR reRecordExecuta IN EXECUTE stExecuta LOOP                
                                    inValorTotal := inValorTotal + reRecordExecuta.valor;
                                    stValores := stValores || \';\' || reRecordExecuta.valor || \';\' || reRecordFuncoes.cod_acrescimo || \';\' || reRecordFuncoes.cod_tipo;
                                END LOOP;           
                            END IF;
                        END LOOP;
                    END IF;
                
                    stRetorno := inValorTotal || stValores;
                   return stRetorno;
                end;
                $function$;
                ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_total_parcelas_pagas(integer, character)
                 RETURNS integer
                 LANGUAGE plpgsql
                AS $function$
                declare
                    inLancamento    ALIAS FOR $1;
                    stExercicio     ALIAS FOR $2;
                    inSoma          integer;
                    reRecord        record;
                
                begin
                
                    select
                        count(pagamento.numeracao)
                    into
                        inSoma
                    from
                        arrecadacao.parcela as ap
                        INNER JOIN arrecadacao.carne
                        ON carne.cod_parcela = ap.cod_parcela
                        , arrecadacao.pagamento pagamento
                    where
                        ap.cod_lancamento = inLancamento
                        and pagamento.numeracao = carne.numeracao
                        and pagamento.cod_convenio = carne.cod_convenio
                        and pagamento.valor > 0;
                
                   return coalesce(inSoma,0);
                
                end;
                
                $function$;
                ');

        $this->addSql('CREATE OR REPLACE FUNCTION public.aplica_acrescimo_modalidade(integer, integer, integer, integer, integer, integer, numeric, date, date, text)
                 RETURNS character varying
                 LANGUAGE plpgsql
                AS $function$
                declare
                    inCobrancaJudicial  ALIAS FOR $1;
                    inCodInscricao      ALIAS FOR $2;
                    inExercicio         ALIAS FOR $3;
                    inCodModalidade     ALIAS FOR $4;
                    inCodTipo           ALIAS FOR $5;
                    inRegistro          ALIAS FOR $6;
                    nuValor2            ALIAS FOR $7;
                    nuValor         NUMERIC;
                    dtDataVencimento    ALIAS FOR $8;
                    dtDataBase          ALIAS FOR $9;
                    boIncidencia        ALIAS FOR $10;
                    stSqlFuncoes        VARCHAR;
                    stExecuta           VARCHAR;
                    stRetorno           VARCHAR;
                    stTabela            VARCHAR;
                    stValores           VARCHAR := \'\';
                    inValorTotal        NUMERIC := 0.00;
                    reRecordFuncoes     RECORD;
                    reRecordExecuta     RECORD;
                    boUtilizar          BOOLEAN;
                    inTMP               INTEGER;
                    dtTimestamp         TIMESTAMP;
                    boUsaTimestamp      BOOLEAN;
                    stTMP               TEXT;
                
                begin
                    inTMP := criarbufferinteiro( \'inCodInscricao\', inCodInscricao );
                    inTMP := criarbufferinteiro( \'inExercicio\', inExercicio );
                    inTMP := criarbufferinteiro( \'inCodModalidade\', inCodModalidade );
                    inTMP := criarbufferinteiro( \'inRegistro\', inRegistro );
                    stTMP := criarbuffertexto( \'boIncidencia\', boIncidencia );
                    inTMP := criarbufferinteiro( \'judicial\', inCobrancaJudicial );
                if nuValor2 IS NULL THEN nuValor := 0; ELSE nuValor = nuValor2;END IF;
                
                    stSqlFuncoes := \'
                        SELECT
                            administracao.funcao.nom_funcao as funcao
                            , divida.modalidade_acrescimo.cod_acrescimo
                            , divida.modalidade_acrescimo.cod_tipo
                            , (
                                SELECT
                                    administracao.funcao.nom_funcao
                                FROM
                                    administracao.funcao
                                WHERE
                                    administracao.funcao.cod_funcao = divida.modalidade_acrescimo.cod_funcao
                                    AND administracao.funcao.cod_modulo = divida.modalidade_acrescimo.cod_modulo
                                    AND administracao.funcao.cod_biblioteca = divida.modalidade_acrescimo.cod_biblioteca
                              )AS funcao_valida
                
                        FROM
                            divida.modalidade
                        
                        INNER JOIN
                            divida.modalidade_vigencia
                        ON
                            divida.modalidade_vigencia.timestamp = divida.modalidade.ultimo_timestamp
                            AND divida.modalidade_vigencia.cod_modalidade = divida.modalidade.cod_modalidade
                        
                        INNER JOIN
                            divida.modalidade_acrescimo
                        ON
                            divida.modalidade_acrescimo.timestamp = divida.modalidade.ultimo_timestamp
                            AND divida.modalidade_acrescimo.cod_modalidade = divida.modalidade.cod_modalidade
                        \';
                        IF inCodTipo != 0 THEN
                            stSqlFuncoes := stSqlFuncoes || \' AND divida.modalidade_acrescimo.cod_tipo = \'|| inCodTipo ||\' \';
                        END IF;
                        
                        stSqlFuncoes := stSqlFuncoes || \' 
                            AND divida.modalidade_acrescimo.pagamento = \'|| boIncidencia ||\'
                        
                        INNER JOIN
                            (
                                SELECT
                                    tmp.*
                                FROM
                                   monetario.formula_acrescimo AS tmp,
                                   (
                       \';
                       --AJUSTE FEITO PARA RECUPERAR A FUNÇÃO QUE FOI UTILIZADA NO MOMENTO DA COBRANÇA
                       IF COALESCE(recuperarbuffertexto(\'boConsulta\'),\'false\') = \'true\' THEN
                            IF (inRegistro = 0) THEN
                                dtTimestamp := now();
                            ELSE
                                SELECT timestamp INTO dtTimestamp FROM divida.parcelamento WHERE num_parcelamento = inRegistro;
                            END IF;
                
                            SELECT CASE WHEN timestamp IS NULL THEN
                                        false
                                   ELSE
                                        true
                                   END INTO boUsaTimestamp
                              FROM monetario.formula_acrescimo
                             WHERE timestamp <= dtTimestamp;
                
                          IF boUsaTimestamp THEN
                                stSqlFuncoes := stSqlFuncoes || \' SELECT MAX(timestamp)AS timestamp
                                                                    , cod_tipo
                                                                    , cod_acrescimo
                                                                 FROM monetario.formula_acrescimo
                                                                WHERE timestamp <= \'|| quote_literal(dtTimestamp) ||\' \';
                          ELSE
                               stSqlFuncoes := stSqlFuncoes || \' SELECT MIN(timestamp)AS timestamp
                                                                    , cod_tipo
                                                                    , cod_acrescimo
                                                                 FROM monetario.formula_acrescimo\';
                          END IF;
                       ELSE
                            stSqlFuncoes := stSqlFuncoes || \' SELECT MAX(timestamp)AS timestamp
                                                                    , cod_tipo
                                                                    , cod_acrescimo
                                                                 FROM monetario.formula_acrescimo\';
                       END IF;
                       stSqlFuncoes := stSqlFuncoes || \'
                                        GROUP BY cod_tipo, cod_acrescimo
                                   )AS tmp2
                                WHERE
                                    tmp.timestamp = tmp2.timestamp
                                    AND tmp.cod_tipo = tmp2.cod_tipo
                                    AND tmp.cod_acrescimo = tmp2.cod_acrescimo
                            )AS mfa
                        ON
                            mfa.cod_acrescimo = divida.modalidade_acrescimo.cod_acrescimo
                            AND mfa.cod_tipo = divida.modalidade_acrescimo.cod_tipo
                        
                        INNER JOIN
                            administracao.funcao
                        ON
                            administracao.funcao.cod_funcao = mfa.cod_funcao
                            AND administracao.funcao.cod_modulo = mfa.cod_modulo
                            AND administracao.funcao.cod_biblioteca = mfa.cod_biblioteca
                        
                        WHERE
                            divida.modalidade.cod_modalidade = \'|| inCodModalidade ||\'
                    \';
                    IF ( dtDataVencimento <= dtDataBase ) THEN
                        -- executa
                        FOR reRecordFuncoes IN EXECUTE stSqlFuncoes LOOP
                            stExecuta :=  \'SELECT \'||reRecordFuncoes.funcao_valida||\'( \'||inRegistro||\' ) as utilizar \';
                            FOR reRecordExecuta IN EXECUTE stExecuta LOOP
                                boUtilizar := reRecordExecuta.utilizar;
                            END LOOP;
                            IF ( boUtilizar ) THEN 
                                stExecuta :=  \'SELECT \'||reRecordFuncoes.funcao||\'(\'|| quote_literal(dtDataVencimento)||\',\'|| quote_literal(dtDataBase)||\',\'||nuValor||\', \'||reRecordFuncoes.cod_acrescimo||\' , \'||reRecordFuncoes.cod_tipo||\') as valor \';
                                FOR reRecordExecuta IN EXECUTE stExecuta LOOP                
                                    inValorTotal := inValorTotal + reRecordExecuta.valor;
                                    stValores := stValores || \';\' || reRecordExecuta.valor || \';\' || reRecordFuncoes.cod_acrescimo || \';\' || reRecordFuncoes.cod_tipo;
                                END LOOP;           
                            END IF;
                        END LOOP;
                    END IF;
                
                    stRetorno := inValorTotal || stValores;
                   return stRetorno;
                end;
                $function$;
                ');

        $this->addSql('CREATE OR REPLACE FUNCTION public.fn_multa_2_porcento_mariana(date, date, numeric, integer, integer)
                     RETURNS numeric
                     LANGUAGE plpgsql
                    AS $function$
                    
                        DECLARE
                            dtVencimento    ALIAS FOR $1;
                            dtDataCalculo   ALIAS FOR $2;
                            flCorrigido     ALIAS FOR $3;
                            inCodAcrescimo  ALIAS FOR $4;
                            inCodTipo       ALIAS FOR $5;
                            flCorrecao      NUMERIC;
                            flMulta         NUMERIC;
                            inDiff          INTEGER;
                            inDiffMes       INTEGER;
                        BEGIN
                    
                            flCorrecao:=fn_correcao_mariana(dtVencimento,dtDataCalculo,flCorrigido,5,1);
                            -- recupera diferença em dias das datas
                            inDiffMes := diff_datas_em_meses(dtVencimento,dtDataCalculo);
                            IF ( inDiffMes = 0 ) THEN
                                inDiffMes := inDiffMes + 0;
                            ELSE
                                inDiffMes := inDiffMes + 1;
                            END IF;
                    
                    --caso o vencimento seja anterior a 2004 a multa passa a ser de 2 por cento ao mes até o fonal de 2003
                            IF (dtVencimento < \'01-01-2004\') THEN
                               --inDiffMes := inDiffMes*2;
                               inDiffMes := (diff_datas_em_meses(dtVencimento,\'12-31-2003\')*2) + diff_datas_em_meses(\'12-31-2003\',dtDataCalculo);
                            END IF;
                     
                            inDiff := diff_datas_em_dias( dtVencimento, dtDataCalculo );
                            flMulta := 0.00;
                            
                            IF dtVencimento <= dtDataCalculo::date  THEN
                                IF ( inDiff > 0 ) THEN
                                    flMulta := ( (flCorrigido + flCorrecao) * inDiffMes ) / 100; 
                                END IF;
                            END IF;
                    
                            RETURN flMulta::numeric(14,2);
                        END;
                    $function$;
                    ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
