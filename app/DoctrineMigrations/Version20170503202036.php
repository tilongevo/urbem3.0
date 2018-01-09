<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170503202036 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('CREATE OR REPLACE FUNCTION public.cancelarperiodomovimentacao(character varying)
 RETURNS boolean
 LANGUAGE plpgsql
AS $function$
DECLARE
    stEntidade                          ALIAS FOR $1;
    stSql                               VARCHAR;
    stDescricao                         VARCHAR;
    stTipoFolha                         VARCHAR;
    inCodPeriodoMovimentacao            INTEGER; 
    inCodFerias                         INTEGER; 
    inIndex                             INTEGER:=1;   
    reRegistro                          RECORD;
    dtPeriodoInicial                    DATE;
    dtPeriodoFincal                     DATE;
    arCompetencia                       VARCHAR[];
    arTabelasPessoal                    VARCHAR[];
    arTabelasFolhaPagamento             VARCHAR[];
    arTabelasEstagio                    VARCHAR[];
    arContratos                         VARCHAR[]:=\'{}\';
    crCursor                            REFCURSOR;
    boRetorno                           BOOLEAN;
BEGIN

    PERFORM criarBufferTexto(\'stEntidade\', stEntidade);

    --Busca do periodo de movimentação que será cancelado
    --sempre será o último que foi aberto
    stSql := \'  SELECT cod_periodo_movimentacao
                     , dt_inicial
                     , dt_final
                  FROM folhapagamento\'|| stEntidade ||\'.periodo_movimentacao
              ORDER BY cod_periodo_movimentacao desc
                 LIMIT 1\';
    OPEN crCursor FOR EXECUTE stSql;
        FETCH crCursor INTO inCodPeriodoMovimentacao,dtPeriodoInicial,dtPeriodoFincal;
    CLOSE crCursor; 
    arCompetencia := string_to_array(dtPeriodoFincal::varchar,\'-\');
    
    --Busca dos registro de evento da folha salário do periodo que será cancelado
    --todos esses registros serão excluídos
    stSql := \'SELECT cod_registro
                FROM folhapagamento\'|| stEntidade ||\'.registro_evento_periodo
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao;
    stTipoFolha := criarBufferTexto(\'stTipoFolha\',\'S\');
    FOR reRegistro IN EXECUTE stSql LOOP
        boRetorno := deletarRegistroEventoPeriodo(reRegistro.cod_registro);
    END LOOP;
    
    
    --Busca dos registro de evento da folha complementar do periodo que será cancelado
    --todos esses registros serão excluídos
    stSql := \'SELECT cod_registro
                   , timestamp
                   , cod_evento
                   , cod_configuracao
                FROM folhapagamento\'|| stEntidade ||\'.registro_evento_complementar
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao;
    stTipoFolha := criarBufferTexto(\'stTipoFolha\',\'C\');
    FOR reRegistro IN EXECUTE stSql LOOP
        boRetorno := deletarRegistroEvento(reRegistro.cod_registro,reRegistro.cod_evento,reRegistro.cod_configuracao::varchar,reRegistro.timestamp::varchar);
    END LOOP; 
    
    --Busca dos registro de evento da folha férias do periodo que será cancelado
    --todos esses registros serão excluídos
    stSql := \'SELECT cod_registro
                   , timestamp
                   , cod_evento
                   , desdobramento
                   , cod_contrato
                FROM folhapagamento\'|| stEntidade ||\'.registro_evento_ferias
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao ||\'
            ORDER BY cod_contrato\';
    inIndex := 1;
    stTipoFolha := criarBufferTexto(\'stTipoFolha\',\'F\');
    FOR reRegistro IN EXECUTE stSql LOOP
        IF arContratos[inIndex-1]::integer != reRegistro.cod_contrato OR arContratos[inIndex-1] IS NULL THEN
            arContratos[inIndex] := reRegistro.cod_contrato;        
            inIndex := inIndex + 1;
        END IF;
        boRetorno := deletarRegistroEvento(reRegistro.cod_registro,reRegistro.cod_evento,reRegistro.desdobramento,reRegistro.timestamp::varchar);
    END LOOP;    

    --Busca dos registro de evento da folha décimo do periodo que será cancelado
    --todos esses registros serão excluídos
    stSql := \'SELECT cod_registro
                   , timestamp
                   , cod_evento
                   , desdobramento
                FROM folhapagamento\'|| stEntidade ||\'.registro_evento_decimo
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao;
    stTipoFolha := criarBufferTexto(\'stTipoFolha\',\'D\');
    FOR reRegistro IN EXECUTE stSql LOOP
        boRetorno := deletarRegistroEvento(reRegistro.cod_registro,reRegistro.cod_evento,reRegistro.desdobramento,reRegistro.timestamp::varchar);
    END LOOP; 
         
    --Busca dos registro de evento da folha rescisão do periodo que será cancelado
    --todos esses registros serão excluídos
    stSql := \'SELECT cod_registro
                   , timestamp
                   , cod_evento
                   , desdobramento
                   , cod_contrato
                FROM folhapagamento\'|| stEntidade ||\'.registro_evento_rescisao
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao ||\'
            ORDER BY cod_contrato\';
    inIndex := 1;
    arContratos := \'{}\';
    stTipoFolha := criarBufferTexto(\'stTipoFolha\',\'R\');
    FOR reRegistro IN EXECUTE stSql LOOP
        IF arContratos[inIndex-1]::integer != reRegistro.cod_contrato OR arContratos[inIndex-1] IS NULL THEN
            arContratos[inIndex] := reRegistro.cod_contrato;        
            inIndex := inIndex + 1;
        END IF;
        boRetorno := deletarRegistroEvento(reRegistro.cod_registro,reRegistro.cod_evento,reRegistro.desdobramento,reRegistro.timestamp::varchar);
    END LOOP;    
    
    --Exclusão dos da rescisao dos contratos que foram excluídos seus eventos da folha Rescisão
    inIndex := 1;
    LOOP 
        IF arContratos[inIndex] IS NOT NULL THEN
            --Exclusão de férias geradas atravez da rescisão
            stSql := \'   SELECT ferias.cod_ferias
                           FROM pessoal\'|| stEntidade ||\'.ferias
                     INNER JOIN pessoal\'|| stEntidade ||\'.lancamento_ferias
                             ON lancamento_ferias.cod_ferias = ferias.cod_ferias
                            AND lancamento_ferias.mes_competencia = \'|| quote_literal(arCompetencia[2]) ||\'
                            AND lancamento_ferias.ano_competencia = \'|| quote_literal(arCompetencia[1]) ||\'
                          WHERE ferias.cod_contrato = \'|| arContratos[inIndex] ||\'
                            AND ferias.rescisao IS TRUE\';
            FOR reRegistro IN EXECUTE stSql LOOP
                stSql := \'DELETE FROM pessoal\'|| stEntidade ||\'.lancamento_ferias WHERE cod_ferias =\'|| reRegistro.cod_ferias;
                EXECUTE stSql;
                stSql := \'DELETE FROM pessoal\'|| stEntidade ||\'.ferias WHERE cod_ferias =\'|| reRegistro.cod_ferias;
                EXECUTE stSql;
            END LOOP;   
        
            stSql := \'    SELECT assentamento_gerado.*
                            FROM pessoal\'|| stEntidade ||\'.assentamento
                      INNER JOIN ( SELECT cod_assentamento
                                        , max(timestamp) as timestamp
                                     FROM pessoal\'|| stEntidade ||\'.assentamento
                                 GROUP BY cod_assentamento) as max_assentamento
                              ON assentamento.cod_assentamento = max_assentamento.cod_assentamento
                             AND assentamento.timestamp        = max_assentamento.timestamp
                      INNER JOIN pessoal\'|| stEntidade ||\'.assentamento_assentamento
                              ON assentamento.cod_assentamento = assentamento_assentamento.cod_assentamento
                      INNER JOIN pessoal\'|| stEntidade ||\'.classificacao_assentamento
                              ON assentamento_assentamento.cod_classificacao = classificacao_assentamento.cod_classificacao
                      INNER JOIN pessoal\'|| stEntidade ||\'.assentamento_gerado
                              ON assentamento_gerado.cod_assentamento = assentamento.cod_assentamento
                      INNER JOIN ( SELECT cod_assentamento_gerado
                                        , max(timestamp) as timestamp
                                     FROM pessoal\'|| stEntidade ||\'.assentamento_gerado
                                 GROUP BY cod_assentamento_gerado) as max_assentamento_gerado
                              ON assentamento_gerado.cod_assentamento_gerado = max_assentamento_gerado.cod_assentamento_gerado
                             AND assentamento_gerado.timestamp        = max_assentamento_gerado.timestamp
                      INNER JOIN pessoal\'|| stEntidade ||\'.assentamento_gerado_contrato_servidor
                              ON assentamento_gerado_contrato_servidor.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado
                           WHERE assentamento.assentamento_automatico = true
                             AND classificacao_assentamento.cod_tipo = 3
                             AND assentamento_assentamento.cod_motivo = 4
                             AND assentamento_gerado_contrato_servidor.cod_contrato = \'|| arContratos[inIndex] ||\'
                             AND NOT EXISTS (SELECT 1
                                               FROM pessoal\'|| stEntidade ||\'.assentamento_gerado_excluido
                                              WHERE assentamento_gerado_excluido.cod_assentamento_gerado = assentamento_gerado.cod_assentamento_gerado
                                                AND assentamento_gerado_excluido.timestamp = assentamento_gerado.timestamp)\';
        
            FOR reRegistro IN EXECUTE stSql LOOP
                stDescricao := \'Exclusão de assentamento gerado por consequência do cancelamento do período de movimentação de \'|| to_char(dtPeriodoInicial,\'dd/mm/yyyy\') ||\' a \'|| to_char(dtPeriodoFincal,\'dd/mm/yyyy\') ||\'.\';
                stSql := \'INSERT INTO pessoal\'|| stEntidade ||\'.assentamento_gerado_excluido 
                          (timestamp,cod_assentamento_gerado,descricao) VALUES
                          (\'|| quote_literal(reRegistro.timestamp) ||\',\'|| reRegistro.cod_assentamento_gerado ||\',\'|| quote_literal(stDescricao) ||\')\';
                EXECUTE stSql;
            END LOOP;
        
            stSql := \'DELETE FROM pessoal\'|| stEntidade ||\'.aviso_previo
                       WHERE cod_contrato = \'|| arContratos[inIndex];
            EXECUTE stSql;
        
            stSql := \'DELETE FROM pessoal\'|| stEntidade ||\'.causa_obito
                       WHERE cod_contrato = \'|| arContratos[inIndex];
            EXECUTE stSql;
        
            stSql := \'DELETE FROM pessoal\'|| stEntidade ||\'.contrato_servidor_caso_causa_norma
                       WHERE cod_contrato = \'|| arContratos[inIndex];
            EXECUTE stSql;
        
            stSql := \'DELETE FROM pessoal\'|| stEntidade ||\'.contrato_servidor_caso_causa
                       WHERE cod_contrato = \'|| arContratos[inIndex];
            EXECUTE stSql;
        END IF;
        inIndex := inIndex + 1;
        EXIT WHEN arContratos[inIndex] IS NULL;
    END LOOP;
    
   
        
    --Exclusão das tabelas do esquema pessoal que tem relação direta com cod_periodo_movimentacao
    --exclui todos as entradas de salario marcadas como reajuste para o perido de movimentacao
    stSql := \'SELECT *
                FROM pessoal\'|| stEntidade ||\'.contrato_servidor_salario
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao ||\' AND reajuste = true\';
    FOR reRegistro IN EXECUTE stSql LOOP
        stSql := \'DELETE FROM folhapagamento\'|| stEntidade ||\'.reajuste_contrato_servidor_salario
                   WHERE cod_contrato = \'|| reRegistro.cod_contrato ||\'
                     AND timestamp = \'|| quote_literal(reRegistro.timestamp) ||\' \';
        EXECUTE stSql;    
    END LOOP;
    stSql := \'DELETE FROM pessoal\'|| stEntidade ||\'.contrato_servidor_salario
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao ||\' AND reajuste = true\';
    EXECUTE stSql;
    
    stSql := \'DELETE FROM pessoal.contrato_servidor_situacao
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao ||\'\';
    EXECUTE stSql;
   
    --mantem o historico de todas as entradas de salario no periodo movimentacao que nao sao reajustes
    --alterando o periodo de movimentacao para o anterior
    stSql := \'UPDATE pessoal\'|| stEntidade ||\'.contrato_servidor_salario
                 SET cod_periodo_movimentacao = \'|| (inCodPeriodoMovimentacao-1) ||\' 
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao ||\' AND reajuste = false\';
    EXECUTE stSql;
    
    stSql := \'DELETE FROM pessoal\'|| stEntidade ||\'.contrato_servidor_nivel_padrao
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao ||\' AND reajuste = true\';
    EXECUTE stSql;
    
    stSql := \'UPDATE pessoal\'|| stEntidade ||\'.contrato_servidor_nivel_padrao
                 SET cod_periodo_movimentacao = \'|| (inCodPeriodoMovimentacao-1) ||\'
               WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao ||\' AND reajuste = false\';
    EXECUTE stSql;
        
    --Exclusão das tabelas do esquema estagio que tem relação direta com cod_periodo_movimentacao
    --verifica os estagiarios que tem somente alteracoes de bolsa no ultimo periodo movimentacao
    --caso tenha alteracao de bolsa em mais de um periodo, exclui as alteracoes do periodo movimentacao a cancelar
    --caso tenha alteracao somente no ultimo periodo (estagiario novo), altera periodo_movimentacao para o anterior
    stSql := \' SELECT estagiario_estagio_bolsa.cgm_instituicao_ensino
                    , estagiario_estagio_bolsa.cgm_estagiario
                    , estagiario_estagio_bolsa.cod_curso
                    , estagiario_estagio_bolsa.cod_estagio
                    , estagiario_estagio_bolsa.timestamp
                    , estagios_unico_periodo.periodo_unico
                 FROM estagio\'|| stEntidade ||\'.estagiario_estagio_bolsa
            LEFT JOIN (
                    SELECT cgm_instituicao_ensino
                         , cgm_estagiario
                         , cod_curso
                         , cod_estagio
                         , 1 as periodo_unico
                      FROM (
                              SELECT cgm_instituicao_ensino
                                   , cgm_estagiario
                                   , cod_curso
                                   , cod_estagio
                                   , cod_periodo_movimentacao
                                FROM estagio\'|| stEntidade ||\'.estagiario_estagio_bolsa
                            GROUP BY cgm_instituicao_ensino
                                   , cgm_estagiario
                                   , cod_curso
                                   , cod_estagio
                                   , cod_periodo_movimentacao
                            ) as  estagio_periodos
                  GROUP BY cgm_instituicao_ensino
                         , cgm_estagiario
                         , cod_curso
                         , cod_estagio
                    HAVING count(cod_periodo_movimentacao) = 1
                    ) as estagios_unico_periodo
                ON (estagiario_estagio_bolsa.cgm_instituicao_ensino = estagios_unico_periodo.cgm_instituicao_ensino
               AND  estagiario_estagio_bolsa.cgm_estagiario         = estagios_unico_periodo.cgm_estagiario
               AND  estagiario_estagio_bolsa.cod_curso              = estagios_unico_periodo.cod_curso
               AND  estagiario_estagio_bolsa.cod_estagio            = estagios_unico_periodo.cod_estagio)
             WHERE  estagiario_estagio_bolsa.cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao;
    
    FOR reRegistro IN EXECUTE stSql LOOP
    
        IF reRegistro.periodo_unico = 1 THEN
            stSql := \'UPDATE estagio\'|| stEntidade ||\'.estagiario_estagio_bolsa
                         SET cod_periodo_movimentacao = \'|| (inCodPeriodoMovimentacao-1) ||\'
                       WHERE cgm_instituicao_ensino = \'|| reRegistro.cgm_instituicao_ensino ||\'
                         AND cgm_estagiario         = \'|| reRegistro.cgm_estagiario ||\'
                         AND cod_curso              = \'|| reRegistro.cod_curso ||\'
                         AND cod_estagio            = \'|| reRegistro.cod_estagio ||\'
                         AND timestamp              = \'|| quote_literal(reRegistro.timestamp) ||\' \';
            EXECUTE stSql;
        ELSE
            --remove alteracoes de vale refeicao e bolsa caso exista em mais de um periodo movimentacao
            inIndex := 1;
            arTabelasPessoal := \'{
                    "estagiario_vale_refeicao",
                    "estagiario_estagio_bolsa"
                }\';
                
            LOOP    
                stSql := \'DELETE FROM estagio\'|| stEntidade ||\'.\'|| arTabelasPessoal[inIndex] ||\'
                           WHERE cgm_instituicao_ensino = \'|| reRegistro.cgm_instituicao_ensino ||\'
                             AND cgm_estagiario         = \'|| reRegistro.cgm_estagiario ||\'
                             AND cod_curso              = \'|| reRegistro.cod_curso ||\'
                             AND cod_estagio            = \'|| reRegistro.cod_estagio ||\'
                             AND timestamp              = \'|| quote_literal(reRegistro.timestamp) ||\' \';
                EXECUTE stSql;
                inIndex := inIndex + 1;
                EXIT WHEN arTabelasPessoal[inIndex] IS NULL;
            END LOOP;
            
        END IF;
    
    END LOOP;            
        
    --Exclusão das tabelas do esquema folhapagamento que tem relação direta com cod_periodo_movimentacao
    inIndex := 1; 
    arTabelasFolhaPagamento := \'{
        "deducao_dependente_complementar",
        "deducao_dependente",
        "contrato_servidor_periodo",
        "periodo_movimentacao_situacao",
        "contrato_servidor_complementar",
        "complementar_situacao_fechada",
        "complementar_situacao",
        "complementar",
        "configuracao_adiantamento",
        "concessao_decimo",
        "folha_situacao",
        "periodo_movimentacao"
    }\';    
    LOOP    
        stSql := \'DELETE FROM folhapagamento\'|| stEntidade ||\'.\'|| arTabelasFolhaPagamento[inIndex] ||\'
                   WHERE cod_periodo_movimentacao = \'|| inCodPeriodoMovimentacao;        
        EXECUTE stSql;
        inIndex := inIndex + 1;
        EXIT WHEN arTabelasFolhaPagamento[inIndex] IS NULL;        
    END LOOP;        
       
        
    --Inclui uma situação de aberta para o periodo de movimentacao anterior
    inCodPeriodoMovimentacao := inCodPeriodoMovimentacao - 1;
    if inCodPeriodoMovimentacao > 0 THEN
	    stSql := \'INSERT INTO folhapagamento\'|| stEntidade ||\'.periodo_movimentacao_situacao
	              (cod_periodo_movimentacao,situacao)
	              VALUES
	              (\'|| inCodPeriodoMovimentacao ||\',\'\'a\'\')\';
	    EXECUTE stSql;
    end if;
    
    RETURN TRUE;
END
$function$');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
