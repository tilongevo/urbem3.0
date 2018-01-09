<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Entity\Arrecadacao\AtributoCadEconFaturamentoValor;
use Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento;
use Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoSemMovimento;
use Urbem\CoreBundle\Entity\Arrecadacao\FaturamentoServico;
use Urbem\CoreBundle\Entity\Arrecadacao\NotaServico;
use Urbem\CoreBundle\Entity\Arrecadacao\RetencaoFonte;
use Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota;
use Urbem\CoreBundle\Entity\Arrecadacao\RetencaoServico;
use Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao;
use Urbem\CoreBundle\Entity\Arrecadacao\ServicoSemRetencao;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170721152122 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_consulta_escrituracao_list', 'Consulta de Escrituração de Receita', 'tributario_arrecadacao_consulta_home');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'tributario_arrecadacao_consulta_home', 'Arrecadação - Consultas', 'tributario');");
        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_arrecadacao_consulta_escrituracao_atividade', 'Dados da Consulta', 'urbem_tributario_arrecadacao_consulta_escrituracao_list');");
        $this->changeColumnToDateTimeMicrosecondType(CadastroEconomicoFaturamento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(FaturamentoSemMovimento::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(AtributoCadEconFaturamentoValor::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(NotaServico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(RetencaoFonte::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(RetencaoNota::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(RetencaoServico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ServicoComRetencao::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CadastroEconomico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(CadastroEconomicoCalculo::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(FaturamentoServico::class, 'timestamp');
        $this->changeColumnToDateTimeMicrosecondType(ServicoSemRetencao::class, 'timestamp');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.buscavalororiginalparcela(character varying)
                         RETURNS numeric
                         LANGUAGE plpgsql
                        AS $function$
                        
                        DECLARE
                            inNumeracao     ALIAS FOR $1;
                            nuValor         numeric;
                        
                        BEGIN
                            -- Verifica se a parcela possui desconto
                        nuValor := null;
                        
                            SELECT
                                apd.valor
                            INTO
                                nuValor
                            FROM
                                arrecadacao.parcela_desconto as apd
                                INNER JOIN arrecadacao.carne as ac
                                ON ac.cod_parcela = apd.cod_parcela
                            WHERE
                                apd.cod_parcela is not null and
                                ac.numeracao = inNumeracao;
                        
                        
                            IF ( nuValor IS NULL ) THEN
                                SELECT
                                    case when apr.valor is not null then
                                        apr.valor
                                    else
                                        ap.valor
                                    end
                                INTO
                                    nuValor
                                FROM
                                    arrecadacao.parcela as ap
                                    INNER JOIN arrecadacao.carne as ac
                                    ON ac.cod_parcela = ap.cod_parcela
                                    LEFT JOIN                                                                                
                                    (                                                                                        
                                        select apr.cod_parcela, valor
                                        from arrecadacao.parcela_reemissao apr
                                        inner join (
                                            select cod_parcela, min(timestamp) as timestamp
                                            from arrecadacao.parcela_reemissao
                                            group by cod_parcela
                                            ) as apr2
                                            ON apr2.cod_parcela = apr.cod_parcela AND
                                            apr2.timestamp = apr.timestamp
                                        ) as apr
                                    ON apr.cod_parcela = ap.cod_parcela
                                WHERE
                                    ac.numeracao = inNumeracao;
                            END IF;
                        
                            return nuValor;
                        end;
                        $function$;
                        ');

        $this->addSql('CREATE OR REPLACE FUNCTION economico.fn_busca_sociedade(integer)
                     RETURNS character varying[]
                     LANGUAGE plpgsql
                    AS $function$
                                    DECLARE
                                        reRecord                RECORD;
                                        stValor                 VARCHAR[];
                                        stSql                   VARCHAR;
                                        inInscricaoEconomica    ALIAS FOR $1;
                                        inCount                 INTEGER;
                                    BEGIN
                                        stSql := \'
                                            SELECT 
                                                numcgm as valor
                                            FROM
                                                economico.sociedade
                                            WHERE
                                                inscricao_economica = \'||inInscricaoEconomica||\'
                                            ORDER BY 
                                                quota_socio DESC
                                            
                                          \';
                                    
                                        inCount := 1;
                                        FOR reRecord IN EXECUTE stSql LOOP
                                    --            stValor := stValor||\',\'|| reRecord.valor;
                                            stValor[inCount] := reRecord.valor;
                                            inCount := inCount +1;
                                        END LOOP;
                                    
                                    --        stValor := SUBSTR( stValor, 2, LENGTH(stValor) );
                                    
                                        RETURN stValor;
                                    END;
                                
                                $function$;
                    ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_atualiza_data_vencimento(date)
                         RETURNS date
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                        
                            dataVencimento	ALIAS FOR $1;
                            ano 			integer := substring ( $1::varchar, 0, 5 );
                            mes 			integer := substring ( $1::varchar, 6, 2 );
                            dia 			integer := substring ( $1::varchar, 9, 2 );
                        
                            anoV			varchar;
                            mesV			char(2);
                            diaV			varchar;
                            dataVarchar		varchar;
                        
                            diaSemana		integer;
                            diaFev			integer;
                            novoVencimento	date;
                        
                            stSql			varchar;
                        
                            stRetorno       date;
                            reRecord        RECORD;
                        
                        begin
                        
                        stSql := \'
                            SELECT EXTRACT( DOW FROM DATE \'\'\'||dataVencimento||\'\'\' ) as valor
                            \';
                        
                            FOR reRecord IN EXECUTE stSql LOOP
                                diaSemana := reRecord.valor;
                            END LOOP;
                        
                            --verifica ano bissexto
                            IF ( ( ano - 1980 ) % 4 = 0 ) THEN
                                diaFev := 29;
                            ELSE
                                diaFev := 28;
                            END IF;
                        
                        
                            IF diaSemana = 6 THEN -- se for SÁBADO
                                IF (dia = 31) OR ( mes = 2 AND dia = diaFev ) OR  ( dia = 30 AND mes in ( 04, 06, 09, 11 ) )  THEN
                                    dia := 2;
                                    IF mes = 12 THEN
                                        mes := 1;
                                        ano := ano + 1;
                                    ELSE
                                        mes := mes + 1;
                                    END IF;
                                ELSIF ( (dia = (diaFev-1)) AND mes = 2) OR (dia = 29 AND mes in (04, 06, 09, 11)) OR (dia = 30 AND mes in (01, 03, 05, 07, 08, 10, 12) ) THEN
                                    dia := 1;
                                    IF mes = 12 THEN
                                        mes := 1;
                                        ano := ano + 1;
                                    ELSE
                                        mes := mes + 1;
                                    END IF;
                                ELSE
                                    dia := dia + 2;
                                END IF;
                        
                            ELSIF diaSemana = 0 THEN --se for DOMINGO
                                IF (dia = 31) OR ( mes = 2 AND dia = diaFev ) OR ( dia = 30 AND mes in ( 04, 06, 09, 11 ) ) THEN
                                    dia := 1;
                                    IF mes = 12 THEN
                                        mes := 1;
                                        ano := ano + 1;
                                    ELSE
                                        mes := mes + 1;
                                    END IF;
                                ELSE
                                    dia := dia + 1;
                                END IF;
                            END IF;
                        
                            anoV := to_char(ano,\'0000\');
                            mesV := substring ( to_char(mes,\'00\'), 2, 2 );
                            diaV := substring ( to_char(dia,\'00\'), 2, 2 );
                        
                            dataVarchar := anoV||\'-\'||mesV||\'-\'||diaV;
                        
                            --novoVencimento := to_date ( dataVarchar, \'\'YYYY-MM-DD\'\');
                        
                            return dataVarchar;
                        end;
                        $function$;
                        ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_percentual_desconto_parcela(integer, date, integer)
                             RETURNS numeric
                             LANGUAGE plpgsql
                            AS $function$
                            declare
                                inCodParcela    ALIAS FOR $1;
                                dtDataCalculo   ALIAS FOR $2;
                                inExercicio        ALIAS FOR $3;
                                nuRetorno       numeric;
                                nuOriginal      numeric;
                                nuDesconto      numeric;
                                nuDescontoO     numeric;
                            begin
                            -- Valor Original
                            select valor into nuOriginal  from arrecadacao.parcela where cod_parcela = inCodParcela;
                            select valor into nuDescontoO from arrecadacao.parcela_desconto where cod_parcela = inCodParcela;
                            -- Valor Desconto
                                
                                SELECT 
                                    sum(alc.valor) 
                                INTO 
                                    nuDesconto 
                                FROM
                                    arrecadacao.lancamento_calculo alc 
                                    INNER JOIN arrecadacao.calculo as calc ON calc.cod_calculo = alc.cod_calculo
                                    INNER JOIN arrecadacao.calculo_grupo_credito cgc ON cgc.cod_calculo = alc.cod_calculo 
                                    INNER JOIN arrecadacao.credito_grupo cg ON cg.cod_credito = calc.cod_credito  
                                                                                                            AND cgc.cod_grupo = cg.cod_grupo  
                                                                                                            AND cgc.ano_exercicio = cg.ano_exercicio
                                WHERE
                                    alc.cod_lancamento in (  select cod_lancamento 
                                                                            from arrecadacao.parcela 
                                                                            where cod_parcela = inCodParcela )
                                   and cg.desconto = true
                                   and cg.ano_exercicio = quote_literal(inExercicio);
                            
                            
                            if ( nuOriginal > nuDescontoO ) and (nuDesconto > 0) and (nuOriginal > 0)then
                                nuRetorno := arrecadacao.fn_juro_multa_aplicado_reemissao(nuDesconto,nuDesconto+(nuOriginal-nuDescontoO));
                            else
                                nuRetorno := NULL;
                            end if;
                            
                                return coalesce(nuRetorno,0.00);
                                --
                            end;
                            $function$;
                            ');

        $this->addSql('CREATE OR REPLACE FUNCTION arrecadacao.fn_total_parcelas(integer)
                         RETURNS integer
                         LANGUAGE plpgsql
                        AS $function$
                        DECLARE
                            inCodLancamento ALIAS FOR $1;   
                            inRetorno       INTEGER;
                        BEGIN
                            SELECT 
                                count(nr_parcela) as total_parcela 
                            INTO 
                                inRetorno 
                            FROM 
                                arrecadacao.parcela 
                            WHERE 
                                cod_lancamento = inCodLancamento AND 
                                nr_parcela > 0;
                            
                            RETURN inRetorno;
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
