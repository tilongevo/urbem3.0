<?php

namespace Application\Migrations;

use Doctrine\DBAL\Driver\Connection;
use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171215090147 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        /** @var $connection Connection */
        $connection = $this->container->get('doctrine')->getConnection();
        $connection->exec(file_get_contents(__DIR__ . '/Version20171215090147_create.sql'));
        $connection->exec(file_get_contents(__DIR__ . '/Version20171215090147_data.sql'));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $tables = [
            'agrupamento_receita',
            'aplicacao_recurso',
            'area_projecao_receita',
            'avaliacao_licitacao',
            'banco',
            'classificacao_intervencao',
            'classificacao_objeto_licitacao',
            'classificacao_objeto_licitacao_x_regime_execucao_licitacao',
            'classificacao_obra',
            'consolidacao_divida',
            'consolidacao_tipo_documento_x_escopo',
            'desdobramento_fonte',
            'detalhamento_fonte',
            'escopo',
            'evento_padrao',
            'fonte_padrao',
            'grupo_fonte_padrao',
            'modalidade_licitacao',
            'modalidade_x_natureza_licitacao',
            'motivo_paralisacao',
            'natureza_acao',
            'natureza_cargo_comissao',
            'natureza_indicador',
            'natureza_licitacao',
            'natureza_x_funcao_quadro_estatal',
            'objetivo_milenio',
            'operacao_loa',
            'origem_acompanhamento',
            'origem_recurso',
            'produto',
            'produto_x_unidade_medida',
            'regime_execucao_licitacao',
            'risco_fiscal',
            'status_licitacao',
            'tipo_a_baixa_quadro_deliberativo_executivo',
            'tipo_acao',
            'tipo_acompanhamento',
            'tipo_aditivo_contrato',
            'tipo_aditivo_convenio',
            'tipo_agrupamento_bem',
            'tipo_agrupamento_receita',
            'tipo_alteracao_credito_adicional',
            'tipo_aplicacao_plano_contabil',
            'tipo_area_consorcio',
            'tipo_arrecadacao',
            'tipo_ato_contrato',
            'tipo_atribuicao_comissao',
            'tipo_atualizacao_orcamentaria',
            'tipo_baixa_reponsavel',
            'tipo_base_calculo',
            'tipo_cargo_quadro_societario',
            'tipo_categoria_agrupamento_receita',
            'tipo_categoria_bem',
            'tipo_categoria_objeto_despesa',
            'tipo_categoria_x_agrupamento_receita',
            'tipo_categoria_x_objeto_despesa',
            'tipo_certidao',
            'tipo_conta_bancaria',
            'tipo_contrapartida_execucacao_antecipada',
            'tipo_contribuicao_diferenciada',
            'tipo_contribuicao_previdencia',
            'tipo_controle_acao',
            'tipo_controle_conta',
            'tipo_credito_adicional',
            'tipo_credito_adicional_x_escopo',
            'tipo_credito_inicial',
            'tipo_deposito_restituivel_passivo',
            'tipo_detalhamento_bem',
            'tipo_divida',
            'tipo_documento',
            'tipo_documento_financeiro',
            'tipo_documento_fiscal',
            'tipo_documento_orgao_classe',
            'tipo_documento_pessoa',
            'tipo_empenho',
            'tipo_entrada_combustivel',
            'tipo_entrega_produto',
            'tipo_escrituracao',
            'tipo_esfera_governo',
            'tipo_estorno_empenho',
            'tipo_exclusao_credito_adicional',
            'tipo_execucao_acao',
            'tipo_execucao_antecipada',
            'tipo_exigencia_conta_bancaria_credor',
            'tipo_financeiro_patrimonial',
            'tipo_fluxo_interferencia',
            'tipo_forma_pagamento_contrato',
            'tipo_funcao_quadro_estatal',
            'tipo_garantia_contrato',
            'tipo_grupo_divida',
            'tipo_indicador',
            'tipo_intervencao',
            'tipo_medicao',
            'tipo_medidor',
            'tipo_modulo',
            'tipo_motivo_rescisao_contrato',
            'tipo_movimento',
            'tipo_movimento_contabil',
            'tipo_movimento_realizavel',
            'tipo_multa_contrato',
            'tipo_natureza_base_folha',
            'tipo_natureza_bem',
            'tipo_natureza_divida',
            'tipo_natureza_informacao',
            'tipo_natureza_juridica_consorcio',
            'tipo_natureza_quadro_estatal',
            'tipo_natureza_saldo',
            'tipo_natureza_transferencia',
            'tipo_nivel_conta',
            'tipo_objetivo_diaria',
            'tipo_objeto_despesa',
            'tipo_obra',
            'tipo_operacao_aditivo_contrato',
            'tipo_operacao_cisao_fusao',
            'tipo_operacao_conciliacao',
            'tipo_operacao_credito_adicional',
            'tipo_operacao_divida',
            'tipo_operacao_financeira',
            'tipo_operacao_pagamento',
            'tipo_operacao_programacao_financeira',
            'tipo_orgao_oficial',
            'tipo_origem_contrato',
            'tipo_origem_divida',
            'tipo_origem_receita',
            'tipo_parecer_licitacao',
            'tipo_parte_contrato',
            'tipo_permuta_status_divida',
            'tipo_planilha_orcamento',
            'tipo_propriedade_bem',
            'tipo_publico_alvo',
            'tipo_recurso_credito_adicional',
            'tipo_redimensionamento_objeto_contrato',
            'tipo_regime_execucao_contrato',
            'tipo_regime_intervencao',
            'tipo_regime_previdencia',
            'tipo_registro_quadro_societario',
            'tipo_renuncia',
            'tipo_responsabilidade_tecnica',
            'tipo_responsavel_modulo',
            'tipo_revisao',
            'tipo_saida_combustivel',
            'tipo_saldo',
            'tipo_serie_doc_fiscal',
            'tipo_situacao_convenio',
            'tipo_situacao_licitacao',
            'tipo_situacao_participante',
            'tipo_superavit_financeiro',
            'tipo_utilizacao_bem',
            'tipo_variacao_qualitativa',
            'tipo_verba_folha',
            'tipo_x_classificacao_obra',
            'tipo_x_natureza_indicador',
            'unidade_medida',
            'unidade_medida_intervencao',
        ];

        foreach ($tables as $table) {
            $this->addSql("DROP TABLE tcepr." . $table);
        }
    }
}
