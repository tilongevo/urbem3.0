<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170825180441 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'tributario_divida_ativa_emissao_documento_home', 'Emissão de Documentos', 'tributario');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_divida_ativa_emitir_carne_filtro', 'Emitir Carnês - Filtro', 'tributario_divida_ativa_emissao_documento_home');");

        $this->addSql("INSERT INTO administracao.rota (cod_rota, descricao_rota, traducao_rota, rota_superior) VALUES (nextval('administracao.rota_cod_rota_seq'), 'urbem_tributario_divida_ativa_emitir_carne_create', 'Emitir Carnês', 'urbem_tributario_divida_ativa_emitir_carne_filtro');");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.buscaVinculoLancamento( inCodLancamento  INTEGER
                                                             , inExercicio      INTEGER
                                                             ) RETURNS          VARCHAR AS $$
            DECLARE
                stDesc          varchar;
            BEGIN

                   SELECT COALESCE( calculo_grupo_credito.cod_grupo ||' / '|| calculo_grupo_credito.ano_exercicio ||' - '|| grupo_credito.descricao
                                  , credito.descricao_credito
                                  ) AS vinculo
                     INTO stDesc
                     FROM arrecadacao.calculo
                     JOIN arrecadacao.lancamento_calculo
                       ON lancamento_calculo.cod_calculo = calculo.cod_calculo
                LEFT JOIN arrecadacao.calculo_grupo_credito
                       ON calculo_grupo_credito.cod_calculo = calculo.cod_calculo
                LEFT JOIN arrecadacao.grupo_credito
                       ON grupo_credito.cod_grupo     = calculo_grupo_credito.cod_grupo
                      AND grupo_credito.ano_exercicio = calculo_grupo_credito.ano_exercicio
                     JOIN monetario.credito
                       ON credito.cod_credito  = calculo.cod_credito
                      AND credito.cod_especie  = calculo.cod_especie
                      AND credito.cod_genero   = calculo.cod_genero
                      AND credito.cod_natureza = calculo.cod_natureza
                    WHERE lancamento_calculo.cod_lancamento = inCodLancamento
                      AND calculo.exercicio                 = inExercicio::varchar
                        ;

                PERFORM 1
                   FROM arrecadacao.lancamento
                  WHERE cod_lancamento = inCodLancamento
                    AND divida         = TRUE
                      ;
                IF FOUND THEN
                    stDesc := 'D.A. '||stDesc;
                END IF;

                RETURN stDesc;
            END;
            $$ LANGUAGE 'plpgsql';
        ");

        $this->addSql("
            CREATE OR REPLACE FUNCTION arrecadacao.buscaIdVinculo( inCodLancamento  INTEGER
                                                     , inExercicio      INTEGER
                                                     )  RETURNS         VARCHAR AS $$
            DECLARE
                inCalculo       integer;
                inGrupo         integer;
                stDesc          varchar;
            BEGIN

                   SELECT COALESCE(calculo_grupo_credito.cod_grupo::VARCHAR, calculo.cod_credito||'.'||calculo.cod_especie||'.'||calculo.cod_genero||'.'||calculo.cod_natureza) AS vinculo
                     INTO stDesc
                     FROM arrecadacao.calculo
                     JOIN arrecadacao.lancamento_calculo
                       ON lancamento_calculo.cod_calculo = calculo.cod_calculo
                LEFT JOIN arrecadacao.calculo_grupo_credito
                       ON calculo_grupo_credito.cod_calculo = calculo.cod_calculo
                    WHERE lancamento_calculo.cod_lancamento = inCodLancamento
                      AND calculo.exercicio                 = inExercicio::varchar
                        ;

                RETURN stDesc;
            END;
            $$ LANGUAGE 'plpgsql';
        ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
