<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170908173319 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->insertRoute('urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida_list', 'Cobrar Dívida Ativa', 'tributario_divida_ativa_cobranca_administrativa_home');
        $this->insertRoute('urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida_batch', 'Cobrar Dívida Ativa', 'tributario_divida_ativa_cobranca_administrativa_home');
        $this->insertRoute('urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida_edit', 'Efetuar Cobrança', 'urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida_list');
        $this->insertRoute('urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida_emitir_documento', 'Emitir Documentos', 'urbem_tributario_divida_ativa_cobranca_administrativa_cobrar_divida_list');
        $this->addSql('CREATE OR REPLACE FUNCTION divida.fn_busca_saldo_divida(integer, integer, integer, integer, integer, integer, character varying, boolean)
             RETURNS SETOF record
             LANGUAGE plpgsql
            AS $function$
            DECLARE
                inNumCGM            ALIAS FOR $1;
                inInscMunIni        ALIAS FOR $2;
                inInscMunFim        ALIAS FOR $3;
                inInscEcoIni        ALIAS FOR $4;
                inInscEcoFim        ALIAS FOR $5;
                inInscDivida        ALIAS FOR $6;
                stExercicio         ALIAS FOR $7;
                boAgrupa            ALIAS FOR $8;
                stNomeTabela        VARCHAR;
                stSQL               VARCHAR;
                stSQLFiltro         VARCHAR;
                stSQLParcelamento   VARCHAR;
                stSQLUpdate         VARCHAR;
                rcRegistro          RECORD;
                rcParcelamento      RECORD;
                nuValor             NUMERIC(14,2);
                nuValorCredito      NUMERIC(14,2);
                nuFatorReducao      NUMERIC(14,5);
                nuValorCorrigido    NUMERIC(14,5);
                inNumParcelamento   INTEGER;
                inCountParcelamento INTEGER;
                inTotalParcelas     INTEGER;
            BEGIN
                SELECT \'tmpDivida\'|| TO_CHAR(NOW(),\'DDMMYYYYHHMISS\') INTO stNomeTabela;
                stSQL:= \'\';
                IF inInscMunIni IS NOT NULL OR inInscMunFim IS NOT NULL THEN
                    IF inInscMunIni IS NULL THEN
                       stSQLFiltro := \' = \'|| inInscMunFim;
                    ELSE IF inInscMunFim IS NULL THEN
                            stSQLFiltro := \' = \'|| inInscMunIni;
                         ELSE
                            stSQLFiltro := \' BETWEEN \'|| inInscMunIni ||\' AND \'|| inInscMunFim;
                         END IF;
                    END IF;

                    stSQL:= stSQL || \' AND EXISTS ( SELECT 1
                                                      FROM divida.divida_imovel
                                                     WHERE divida_ativa.cod_inscricao = divida_imovel.cod_inscricao
                                                       AND divida_ativa.exercicio     = divida_imovel.exercicio
                                                       AND divida_imovel.inscricao_municipal \'|| stSQLFiltro ||\')\';
                END IF;
                IF inInscEcoIni IS NOT NULL OR inInscEcoFim IS NOT NULL THEN
                    IF inInscEcoIni IS NULL THEN
                       stSQLFiltro := \' = \'|| inInscEcoFim;
                    ELSE IF inInscEcoFim IS NULL THEN
                            stSQLFiltro := \' = \'|| inInscEcoIni;
                         ELSE
                            stSQLFiltro := \' BETWEEN \'|| inInscEcoIni ||\' AND \'|| inInscEcoFim;
                         END IF;
                    END IF;

                    stSQL:= stSQL || \' AND EXISTS ( SELECT 1
                                             FROM divida.divida_empresa
                                            WHERE divida_ativa.cod_inscricao = divida_empresa.cod_inscricao
                                              AND divida_ativa.exercicio     = divida_empresa.exercicio
                                              AND divida_empresa.inscricao_economica \'|| stSQLFiltro ||\')\';
                END IF;
                IF inInscDivida IS NOT NULL THEN
                    stSQL:= stSQL || \' AND divida_ativa.cod_inscricao = \'|| inInscDivida ||\'
                                       AND divida_ativa.exercicio = \'|| quote_literal(stExercicio) ||\' \';
                END IF;
                stSQL:= \'CREATE TEMP TABLE \'|| stNomeTabela ||\' AS
                              SELECT divida_ativa.cod_inscricao
                                   , divida_ativa.exercicio
                                   , divida_ativa.dt_vencimento_origem
                                   , 1 AS total_parcelas_divida
                                   , COALESCE ( divida_imovel.inscricao_municipal, divida_empresa.inscricao_economica ) AS inscricao
                                   , ( CASE WHEN divida_imovel.inscricao_municipal is not null THEN
                                           \'\'imobiliaria\'\'
                                       WHEN divida_empresa.inscricao_economica is not null THEN
                                           \'\'economica\'\'
                                       ELSE
                                           \'\'cgm\'\'
                                       END ) AS inscricao_tipo
                                   , parcela_origem.cod_especie
                                   , parcela_origem.cod_genero
                                   , parcela_origem.cod_natureza
                                   , parcela_origem.cod_credito
                                   , split_part ( monetario.fn_busca_mascara_credito( parcela_origem.cod_credito, parcela_origem.cod_especie, parcela_origem.cod_genero, parcela_origem.cod_natureza ), \'\'§\'\', 1 )  as credito_formatado

                                   , arrecadacao.fn_busca_origem_lancamento_sem_exercicio ( parcela.cod_lancamento, 1, 1 ) AS origem
                                   , split_part ( monetario.fn_busca_mascara_credito( parcela_origem.cod_credito, parcela_origem.cod_especie, parcela_origem.cod_genero, parcela_origem.cod_natureza ), \'\'§\'\', 6 ) as descricao_credito
                                   , SUM(parcela_origem.valor) AS valor
                                   , SUM(parcela_origem.valor) AS valor_corrigido

                                   , sw_cgm.numcgm
                                   , sw_cgm.nom_cgm
                                   , true AS retorna
                                FROM (   SELECT divida_ativa.exercicio
                                              , divida_ativa.cod_inscricao
                                              , divida_ativa.cod_autoridade
                                              , divida_ativa.numcgm_usuario
                                              , divida_ativa.dt_inscricao
                                              , divida_ativa.num_livro
                                              , divida_ativa.num_folha
                                              , divida_ativa.dt_vencimento_origem
                                              , divida_ativa.exercicio_original
                                              , divida_ativa.exercicio_livro
                                              , MIN(num_parcelamento) AS num_parcelamento
                                           FROM divida.divida_ativa
                                     INNER JOIN divida.divida_parcelamento
                                             ON divida_ativa.cod_inscricao = divida_parcelamento.cod_inscricao
                                            AND divida_ativa.exercicio     = divida_parcelamento.exercicio

                                    -- comentado para poder efetuar estorno de cobrança judicial

                                  WHERE NOT EXISTS (SELECT 1
                                                               FROM divida.divida_remissao
                                                              WHERE divida_remissao.cod_inscricao = divida_ativa.cod_inscricao
                                                                AND divida_remissao.exercicio     = divida_ativa.exercicio)
                                            AND NOT EXISTS (SELECT 1
                                                               FROM divida.divida_estorno
                                                              WHERE divida_estorno.cod_inscricao = divida_ativa.cod_inscricao
                                                                AND divida_estorno.exercicio     = divida_ativa.exercicio)
                                            AND NOT EXISTS (SELECT 1
                                                               FROM divida.divida_cancelada
                                                              WHERE divida_cancelada.cod_inscricao = divida_ativa.cod_inscricao
                                                                AND divida_cancelada.exercicio     = divida_ativa.exercicio)
                                  --          AND NOT EXISTS (SELECT 1
                                  --                             FROM divida.cobranca_judicial
                                  --                            WHERE cobranca_judicial.cod_inscricao = divida_ativa.cod_inscricao
                                  --                              AND cobranca_judicial.exercicio     = divida_ativa.exercicio)

                           \'|| stSQL ||\'
                                       GROUP BY divida_ativa.exercicio
                                              , divida_ativa.cod_inscricao
                                              , divida_ativa.cod_autoridade
                                              , divida_ativa.numcgm_usuario
                                              , divida_ativa.dt_inscricao
                                              , divida_ativa.num_livro
                                              , divida_ativa.num_folha
                                              , divida_ativa.dt_vencimento_origem
                                              , divida_ativa.exercicio_original
                                              , divida_ativa.exercicio_livro
                                    ) AS divida_ativa
                          INNER JOIN divida.divida_cgm
                                  ON divida_ativa.cod_inscricao = divida_cgm.cod_inscricao
                                 AND divida_ativa.exercicio     = divida_cgm.exercicio
                            \';

                  IF inNumCGM IS NOT NULL THEN
                         stSQL:= stSQL ||\' AND divida_cgm.numcgm =\'|| inNumCGM;
                  END IF;
                  stSQL:=  stSQL ||\'
                          INNER JOIN sw_cgm
                                  ON divida_cgm.numcgm = sw_cgm.numcgm
                          INNER JOIN divida.divida_parcelamento
                                  ON divida_ativa.cod_inscricao   = divida_parcelamento.cod_inscricao
                                 AND divida_ativa.exercicio       = divida_parcelamento.exercicio
                                 AND divida_ativa.num_parcelamento = divida_parcelamento.num_parcelamento
                          INNER JOIN divida.parcelamento
                                  ON divida_parcelamento.num_parcelamento = parcelamento.num_parcelamento
                          INNER JOIN divida.parcela_origem
                                  ON parcelamento.num_parcelamento = parcela_origem.num_parcelamento
                          INNER JOIN arrecadacao.parcela
                                  ON parcela_origem.cod_parcela = parcela.cod_parcela
                           LEFT JOIN divida.divida_imovel
                                  ON divida_ativa.cod_inscricao = divida_imovel.cod_inscricao
                                 AND divida_ativa.exercicio     = divida_imovel.exercicio
                           LEFT JOIN divida.divida_empresa
                                  ON divida_ativa.cod_inscricao = divida_empresa.cod_inscricao
                                 AND divida_ativa.exercicio     = divida_empresa.exercicio
                            GROUP BY divida_ativa.cod_inscricao
                                   , divida_ativa.exercicio
                                   , divida_ativa.dt_vencimento_origem
                                   , parcela_origem.cod_especie
                                   , parcela_origem.cod_genero
                                   , parcela_origem.cod_natureza
                                   , parcela_origem.cod_credito
                                   , parcela.cod_lancamento
                                   , sw_cgm.numcgm
                                   , sw_cgm.nom_cgm
                                   , divida_imovel.inscricao_municipal
                                   , divida_empresa.inscricao_economica\';

                EXECUTE stSQL;

                stSQL := \'SELECT * FROM \'|| stNomeTabela;
                FOR rcRegistro IN EXECUTE stSQL LOOP
                    IF nuValorCorrigido IS NULL THEN
                         nuValorCorrigido := rcRegistro.valor;
                    END IF;

                    SELECT COUNT(divida_parcelamento.num_parcelamento)
                      INTO inCountParcelamento
                      FROM divida.divida_parcelamento
                      JOIN divida.parcelamento
                        ON parcelamento.num_parcelamento    = divida_parcelamento.num_parcelamento
                     WHERE divida_parcelamento.cod_inscricao = rcRegistro.cod_inscricao
                       AND divida_parcelamento.exercicio = rcRegistro.exercicio;

                    IF (inCountParcelamento > 1) THEN
                        --BUSCA O ULTIMO PARCELAMENTO DA INSCRICAO PARA VALIDAR SE ELA FOI ESTORNADA
                        SELECT num_parcelamento INTO inNumParcelamento
                          FROM divida.parcelamento_cancelamento
                         WHERE num_parcelamento = ( SELECT MAX(num_parcelamento)
                                                      FROM divida.divida_parcelamento
                                                     WHERE cod_inscricao = rcRegistro.cod_inscricao
                                                       AND exercicio = rcRegistro.exercicio );
                    END IF;

                    -- Caso tenha sido cobrado e não houve cancelamento, não pode ser cobrado novamente
                    IF ((inNumParcelamento IS NOT NULL AND inCountParcelamento = 1) OR (inNumParcelamento IS NULL AND inCountParcelamento <> 1)) THEN
                         EXECUTE \'UPDATE \'|| stNomeTabela ||\' SET retorna = false  WHERE cod_inscricao = \'|| rcRegistro.cod_inscricao ||\' AND exercicio = \'\'\'|| rcRegistro.exercicio||\'\'\'\';
                    ELSE
                        --RETORNA O NÚMERO TOTAL DE PARCELAS DA ORIGEM
                        --ESTE VALOR É SÓ PARA DEMOSTRATIVO, SEM APLICAÇÃO REAL DENTRO DESTA FUNÇÃO
                        SELECT COUNT(*) INTO inTotalParcelas
                          FROM divida.parcela_origem
                         WHERE num_parcelamento = ( SELECT MIN(num_parcelamento)
                                                  FROM divida.divida_parcelamento
                                                 WHERE cod_inscricao = rcRegistro.cod_inscricao
                                                   AND exercicio = rcRegistro.exercicio );
                        EXECUTE \'UPDATE \'|| stNomeTabela ||\' SET total_parcelas_divida = \'|| inTotalParcelas ||\'  WHERE cod_inscricao = \'|| rcRegistro.cod_inscricao ||\' AND exercicio = \'\'\'|| rcRegistro.exercicio||\'\'\'\';

                        --BUSCA OS PARCELAMENTOS QUE TIVERAM PAGAMENTOS EM QUE A INSCRIÇÃO PARTICIPOU
                        stSQLParcelamento := \'    SELECT DISTINCT parcelamento.num_parcelamento
                                                    FROM divida.divida_parcelamento
                                              INNER JOIN divida.parcelamento
                                                      ON divida_parcelamento.num_parcelamento = parcelamento.num_parcelamento
                                                     AND divida_parcelamento.cod_inscricao = \'|| rcRegistro.cod_inscricao ||\'
                                                     AND divida_parcelamento.exercicio = \'\'\'|| rcRegistro.exercicio ||\'\'\'
                                                     AND parcelamento.exercicio::integer > -1
                                                     AND parcelamento.numero_parcelamento > -1
                                              INNER JOIN divida.parcela
                                                      ON parcelamento.num_parcelamento = parcela.num_parcelamento
                                                     AND parcela.paga=\'\'t\'\'
                                              INNER JOIN divida.parcela_calculo
                                                      ON parcela.num_parcelamento = parcela_calculo.num_parcelamento
                                                     AND parcela.num_parcela      = parcela_calculo.num_parcela
                                              INNER JOIN divida.parcelamento_cancelamento
                                                      ON parcelamento.num_parcelamento = parcelamento_cancelamento.num_parcelamento\';

                        FOR rcParcelamento IN EXECUTE stSQLParcelamento LOOP
                           --PERCORRE CADA PARCELAMENTO PARA CALCULAR QUANTO O VALOR DA INSCRICAO REPRESENTA EM RELAÇÃO AO TODO
                               SELECT COALESCE(SUM(valor), 0.00) INTO nuValor
                                 FROM divida.parcelamento
                           INNER JOIN divida.parcela_origem
                                   ON parcelamento.num_parcelamento = parcela_origem.num_parcelamento
                                  AND parcela_origem.cod_especie  = rcRegistro.cod_especie
                                  AND parcela_origem.cod_genero   = rcRegistro.cod_genero
                                  AND parcela_origem.cod_natureza = rcRegistro.cod_natureza
                                  AND parcela_origem.cod_credito  = rcRegistro.cod_credito
                                  AND parcelamento.num_parcelamento = rcParcelamento.num_parcelamento;

                           --calcula o fator de redução
                           --tem casos em que nuValor eh zero, ocorrendo erro
                           IF nuValor = 0.00 THEN
                               nuFatorReducao := 0.00;
                           ELSE
                               nuFatorReducao := nuValorCorrigido / nuValor;
                           END IF;


                           --BUSCA O VALOR PAGO DO CREDITO SETADO. DEVE SER PEGO O PERCENTUAL E APLICADO AQUI;
                               SELECT COALESCE(sum(parcela_calculo.vl_credito), 0.00) INTO nuValorCredito
                                 FROM divida.parcelamento
                           INNER JOIN divida.parcela
                                   ON parcelamento.num_parcelamento = parcela.num_parcelamento
                                  AND parcelamento.num_parcelamento = rcParcelamento.num_parcelamento
                                  AND parcelamento.exercicio::integer > -1
                                  AND parcelamento.numero_parcelamento > -1
                                  AND parcela.paga=\'t\'
                           INNER JOIN divida.parcela_calculo
                                   ON parcela.num_parcelamento = parcela_calculo.num_parcelamento
                                  AND parcela.num_parcela      = parcela_calculo.num_parcela
                           INNER JOIN arrecadacao.calculo
                                   ON parcela_calculo.cod_calculo = calculo.cod_calculo
                                  AND calculo.cod_especie  = rcRegistro.cod_especie
                                  AND calculo.cod_genero   = rcRegistro.cod_genero
                                  AND calculo.cod_natureza = rcRegistro.cod_natureza
                                  AND calculo.cod_credito  = rcRegistro.cod_credito;
                           nuValorCorrigido := nuValorCorrigido - ( nuValorCredito * nuFatorReducao);
                           stSQLUpdate := \'UPDATE \'|| stNomeTabela ||\' SET valor_corrigido = \'|| nuValorCorrigido::numeric(14,2) ||\' WHERE cod_inscricao = \'|| rcRegistro.cod_inscricao ||\' AND exercicio = \'|| quote_literal(rcRegistro.exercicio) ||\' AND credito_formatado=\'|| quote_literal(rcRegistro.credito_formatado) ||\' \';
                           EXECUTE stSQLUpdate;
                        END LOOP;--rcParcelamento
                    END IF;
                    nuValorCorrigido := NULL;
                    inNumParcelamento := NULL;
                END LOOP;--rcRegistro
                IF boAgrupa THEN
                    stSQL := \'SELECT cod_inscricao
                                   , exercicio
                                   , dt_vencimento_origem
                                   , total_parcelas_divida
                                   , inscricao
                                   , inscricao_tipo
                                   , null::int AS cod_especie
                                   , null::int AS cod_genero
                                   , null::int AS cod_natureza
                                   , null::int AS cod_credito
                                   , \'\'\'\'::text AS credito_formatado
                                   , origem
                                   , descricao_credito
                                   , SUM(valor) as valor
                                   , ROUND(SUM(valor_corrigido),2) AS valor_corrigido
                                   , numcgm
                                   , nom_cgm
                                FROM \'|| stNomeTabela ||\'
                               WHERE valor_corrigido > 0
                                 AND retorna = true
                            GROUP BY cod_inscricao
                                   , exercicio
                                   , dt_vencimento_origem
                                   , total_parcelas_divida
                                   , inscricao
                                   , inscricao_tipo
                                   , origem
                                   , descricao_credito
                                   , numcgm
                                   , nom_cgm
                            ORDER BY exercicio
                                   , cod_inscricao
                         \';
                ELSE
                    stSQL := \'SELECT cod_inscricao
                                   , exercicio
                                   , dt_vencimento_origem
                                   , total_parcelas_divida
                                   , inscricao
                                   , inscricao_tipo
                                   , cod_especie
                                   , cod_genero
                                   , cod_natureza
                                   , cod_credito
                                   , credito_formatado
                                   , origem
                                   , descricao_credito
                                   , valor
                                   , ROUND(valor_corrigido,2) AS valor_corrigido
                                   , numcgm
                                   , nom_cgm
                                FROM \'|| stNomeTabela ||\'
                               WHERE valor_corrigido > 0
                                 AND retorna = true
                            ORDER BY exercicio
                                   , cod_inscricao\';
                END IF;
                FOR rcRegistro IN EXECUTE stSQL LOOP
                    RETURN NEXT rcRegistro;
                END LOOP;

                EXECUTE \'DROP TABLE \'|| stNomeTabela;

                RETURN;
            END;
            $function$
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
                               inDiffMes := (diff_datas_em_meses(dtVencimento,\'2003-12-31\')*2) + diff_datas_em_meses(\'2003-12-31\',dtDataCalculo);
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
                    $function$
        ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('DROP FUNCTION IF EXISTS  divida.fn_busca_saldo_divida(integer, integer, integer, integer, integer, integer, character varying, boolean);');
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
                    $function$
        ');
    }
}
