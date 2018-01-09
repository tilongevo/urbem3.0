<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191048 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->insertRoute('urbem_financeiro_orcamento_orgao_list', 'Plano Plurianual - Órgão Orçamentário', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_orgao_new', 'Novo', 'urbem_financeiro_orcamento_orgao_list');
        $this->insertRoute('urbem_financeiro_orcamento_orgao_delet', 'Apagar', 'urbem_financeiro_orcamento_orgao_list');
        $this->insertRoute('urbem_financeiro_orcamento_unidade_list', 'Plano Plurianual - Unidade Orçamentária', 'financeiro');

        //Início > Financeiro > Plano Plurianual - Unidade Orçamentária
        $this->insertRoute('financeiro_orcamento_unidade_filtro', 'Plano Plurianual - Unidade Orçamentária', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_unidade_create', 'Novo', 'financeiro_orcamento_unidade_filtro');
        $this->insertRoute('urbem_financeiro_orcamento_unidade_edit', 'Editar', 'financeiro_orcamento_unidade_filtro');
        $this->insertRoute('urbem_financeiro_orcamento_unidade_delete', 'Apagar', 'financeiro_orcamento_unidade_filtro');
        $this->insertRoute('urbem_financeiro_orcamento_unidade_show', 'Detalhes', 'financeiro_orcamento_unidade_filtro');

        $this->insertRoute('urbem_financeiro_orcamento_orgao_create', 'Novo', 'urbem_financeiro_orcamento_orgao_list');
        $this->insertRoute('urbem_financeiro_orcamento_orgao_delete', 'Apagar', 'urbem_financeiro_orcamento_orgao_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_regiao_list', 'Plano Plurianual - Regiões', 'financeiro');
        $this->insertRoute('urbem_financeiro_plano_plurianual_regiao_create', 'Novo', 'urbem_financeiro_plano_plurianual_regiao_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_regiao_edit', 'Editar', 'urbem_financeiro_plano_plurianual_regiao_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_regiao_delete', 'Apagar', 'urbem_financeiro_plano_plurianual_regiao_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_regiao_show', 'Detalhes', 'urbem_financeiro_plano_plurianual_regiao_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_produto_list', 'Plano Plurianual - Produtos', 'financeiro');
        $this->insertRoute('urbem_financeiro_plano_plurianual_produto_create', 'Novo', 'urbem_financeiro_plano_plurianual_produto_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_produto_edit', 'Editar', 'urbem_financeiro_plano_plurianual_produto_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_produto_delete', 'Apagar', 'urbem_financeiro_plano_plurianual_produto_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_produto_show', 'Detalhes', 'urbem_financeiro_plano_plurianual_produto_list');
        $this->insertRoute('orcamento_configuracao_home', 'Orçamento - Configuração', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_configuracao_responsavel_tecnico_list', 'Responsável Técnico', 'orcamento_configuracao_home');
        $this->insertRoute('urbem_financeiro_orcamento_configuracao_responsavel_tecnico_create', 'Novo', 'urbem_financeiro_orcamento_configuracao_responsavel_tecnico_list');
        $this->insertRoute('urbem_financeiro_orcamento_configuracao_responsavel_tecnico_edit', 'Editar', 'urbem_financeiro_orcamento_configuracao_responsavel_tecnico_list');
        $this->insertRoute('urbem_financeiro_orcamento_configuracao_responsavel_tecnico_delete', 'Apagar', 'urbem_financeiro_orcamento_configuracao_responsavel_tecnico_list');
        $this->insertRoute('urbem_financeiro_orcamento_configuracao_responsavel_tecnico_show', 'Detalhes', 'urbem_financeiro_orcamento_configuracao_responsavel_tecnico_list');
        $this->insertRoute('plano_plurianual_classificacao_funcional_programatica', 'Plano Plurianual - Classificação Funcional Programática', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_funcao_list', 'Função', 'plano_plurianual_classificacao_funcional_programatica');
        $this->insertRoute('urbem_financeiro_orcamento_funcao_create', 'Novo', 'urbem_financeiro_orcamento_funcao_list');
        $this->insertRoute('urbem_financeiro_orcamento_funcao_edit', 'Editar', 'urbem_financeiro_orcamento_funcao_list');
        $this->insertRoute('urbem_financeiro_orcamento_funcao_delete', 'Apagar', 'urbem_financeiro_orcamento_funcao_list');
        $this->insertRoute('urbem_financeiro_orcamento_funcao_show', 'Detalhes', 'urbem_financeiro_orcamento_funcao_list');
        $this->insertRoute('urbem_financeiro_orcamento_subfuncao_list', 'Subfunção', 'plano_plurianual_classificacao_funcional_programatica');
        $this->insertRoute('urbem_financeiro_orcamento_subfuncao_create', 'Novo', 'urbem_financeiro_orcamento_subfuncao_list');
        $this->insertRoute('urbem_financeiro_orcamento_subfuncao_edit', 'Editar', 'urbem_financeiro_orcamento_subfuncao_list');
        $this->insertRoute('urbem_financeiro_orcamento_subfuncao_delete', 'Apagar', 'urbem_financeiro_orcamento_subfuncao_list');
        $this->insertRoute('urbem_financeiro_orcamento_subfuncao_show', 'Detalhes', 'urbem_financeiro_orcamento_subfuncao_list');

        //Início > Financeiro > Plano Plurianual - Recursos
        $this->insertRoute('urbem_financeiro_plano_plurianual_recursos_list', 'Plano Plurianual - Recursos', 'financeiro');
        $this->insertRoute('urbem_financeiro_plano_plurianual_recursos_create', 'Novo', 'urbem_financeiro_plano_plurianual_recursos_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_recursos_edit', 'Editar', 'urbem_financeiro_plano_plurianual_recursos_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_recursos_delete', 'Apagar', 'urbem_financeiro_plano_plurianual_recursos_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_recursos_show', 'Detalhes', 'urbem_financeiro_plano_plurianual_recursos_list');

        //Início > Financeiro > PPA - Configuração
        $this->insertRoute('ppa_configuracao_home', 'PPA - Configuração', 'financeiro');

        //Início > Financeiro > PPA - Configuração > Projeto, Atividade e Operação Especial
        $this->insertRoute('urbem_financeiro_ppa_configuracao', 'Projeto, Atividade e Operação Especial', 'ppa_configuracao_home');

        //Início > Financeiro > PPA - Configuração > Definir Parâmetros
        $this->insertRoute('financeiro_ppa_parametros', 'Definir Parâmetros', 'ppa_configuracao_home');

        //Início > Financeiro > PPA - Configuração > Plano Plurianual
        $this->insertRoute('urbem_financeiro_plano_plurianual_ppa_list', 'Plano Plurianual ', 'ppa_configuracao_home');
        $this->insertRoute('urbem_financeiro_plano_plurianual_ppa_create', 'Novo', 'urbem_financeiro_plano_plurianual_ppa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_ppa_edit', 'Editar', 'urbem_financeiro_plano_plurianual_ppa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_ppa_delete', 'Apagar', 'urbem_financeiro_plano_plurianual_ppa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_ppa_show', 'Detalhes', 'urbem_financeiro_plano_plurianual_ppa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_ppa_homologar', 'Homologar', 'urbem_financeiro_plano_plurianual_ppa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_ppa_estimativa', 'Elaborar estimativa', 'urbem_financeiro_plano_plurianual_ppa_list');

        $this->insertRoute('urbem_financeiro_orcamento_suplementacao_list', 'Orçamento - Alteração Orçamentária', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_suplementacao_create', 'Novo', 'urbem_financeiro_orcamento_suplementacao_list');
        $this->insertRoute('urbem_financeiro_orcamento_suplementacao_edit', 'Editar', 'urbem_financeiro_orcamento_suplementacao_list');
        $this->insertRoute('urbem_financeiro_orcamento_suplementacao_delete', 'Apagar', 'urbem_financeiro_orcamento_suplementacao_list');
        $this->insertRoute('urbem_financeiro_orcamento_suplementacao_show', 'Detalhes', 'urbem_financeiro_orcamento_suplementacao_list');
        $this->insertRoute('financeiro_orcamento_suplementacao_credito_suplementar', 'Orçamento - Alteração Orçamentária', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_suplementacao_anular', 'Anular Alteração Orçamentária', 'urbem_financeiro_orcamento_suplementacao_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_macro_objetivo_list', 'Plano Plurianual - Macro Objetivo', 'financeiro');
        $this->insertRoute('urbem_financeiro_plano_plurianual_macro_objetivo_create', 'Novo', 'urbem_financeiro_plano_plurianual_macro_objetivo_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_macro_objetivo_edit', 'Editar', 'urbem_financeiro_plano_plurianual_macro_objetivo_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_macro_objetivo_delete', 'Apagar', 'urbem_financeiro_plano_plurianual_macro_objetivo_list');
        $this->insertRoute('orcamento_classificacao_economica_home', 'Orçamento - Classificação Econômica', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_list', 'Classificação da Receita', 'orcamento_classificacao_economica_home');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_create', 'Novo', 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_edit', 'Editar', 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_delete', 'Apagar', 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_show', 'Detalhes', 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_list', 'Classificação da Receita Dedutora', 'orcamento_classificacao_economica_home');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_create', 'Novo', 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_edit', 'Editar', 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_delete', 'Apagar', 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_show', 'Detalhes', 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_setorial_list', 'Programas Setoriais', 'financeiro');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_setorial_create', 'Novo', 'urbem_financeiro_plano_plurianual_programa_setorial_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_setorial_edit', 'Editar', 'urbem_financeiro_plano_plurianual_programa_setorial_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_setorial_delete', 'Apagar', 'urbem_financeiro_plano_plurianual_programa_setorial_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_list', 'Rubrica de Despesa', 'orcamento_classificacao_economica_home');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_create', 'Novo', 'urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_edit', 'Editar', 'urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_delete', 'Apagar', 'urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_show', 'Detalhes', 'urbem_financeiro_orcamento_classificacao_economica_rubrica_despesa_list');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_recurso_list', 'Grupo de Destinação', 'plano_plurianual_destinacao_recursos');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_recurso_create', 'Novo', 'urbem_financeiro_orcamento_destinacao_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_recurso_edit', 'Editar', 'urbem_financeiro_orcamento_destinacao_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_recurso_delete', 'Apagar', 'urbem_financeiro_orcamento_destinacao_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_recurso_show', 'Detalhes', 'urbem_financeiro_orcamento_destinacao_recurso_list');
        $this->insertRoute('ldo_configuracao_home', 'Lei de Diretrizes Orçamentárias - Configuração', 'financeiro');
        $this->insertRoute('ldo_configuracao_evolucao_divida', 'Evolução da Dívida', 'ldo_configuracao_home');
        $this->insertRoute('ldo_configuracao_evolucao_divida_grid', 'Evolução da Dívida', 'ldo_configuracao_home');
        $this->insertRoute('ldo_configuracao_evolucao_patrimonio_liquido', 'Evolução Patrimônio Líquido', 'ldo_configuracao_home');
        $this->insertRoute('ldo_configuracao_evolucao_patrimonio_liquido_grid', 'Evolução Patrimônio Líquido', 'ldo_configuracao_home');
        $this->insertRoute('contabilidade_configuracao_home', 'Contabilidade - Configuração', 'financeiro');
        $this->insertRoute('contabilidade_configuracao_index', 'Classificação Contábil', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_classificacao_contabil_list', 'Classificação Contábil', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_classificacao_contabil_create', 'Novo', 'urbem_financeiro_contabilidade_configuracao_classificacao_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_classificacao_contabil_edit', 'Editar', 'urbem_financeiro_contabilidade_configuracao_classificacao_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_classificacao_contabil_delete', 'Apagar', 'urbem_financeiro_contabilidade_configuracao_classificacao_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_classificacao_contabil_show', 'Detalhes', 'urbem_financeiro_contabilidade_configuracao_classificacao_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_sistema_contabil_list', 'Sistema Contábil', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_sistema_contabil_create', 'Novo', 'urbem_financeiro_contabilidade_configuracao_sistema_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_sistema_contabil_edit', 'Editar', 'urbem_financeiro_contabilidade_configuracao_sistema_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_sistema_contabil_delete', 'Apagar', 'urbem_financeiro_contabilidade_configuracao_sistema_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_sistema_contabil_show', 'Detalhes', 'urbem_financeiro_contabilidade_configuracao_sistema_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_encerrar_mes_permissao', 'Permissão', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_encerrar_mes_create', 'Novo', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_reabrir_mes_encerrado_permissao', 'Permissão', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_reabrir_mes_encerrado_create', 'Novo', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_reabrir_mes_encerrado_permissao', 'Permissão', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_list', 'Configurar Conta Contábil Restos a Pagar NP', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_create', 'Novo', 'urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_edit', 'Editar', 'urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_delete', 'Apagar', 'urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_show', 'Detalhes', 'urbem_financeiro_contabilidade_configuracao_conta_contabil_restos_pagar_np_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_list', 'Plano Plurianual - Programas', 'financeiro');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_create', 'Novo', 'urbem_financeiro_plano_plurianual_programa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_edit', 'Editar', 'urbem_financeiro_plano_plurianual_programa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_delete', 'Apagar', 'urbem_financeiro_plano_plurianual_programa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_indicadores_list', 'Plano Plurianual - Indicadores de Programas', 'urbem_financeiro_plano_plurianual_programa_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_indicadores_create', 'Novo', 'urbem_financeiro_plano_plurianual_programa_indicadores_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_indicadores_edit', 'Editar', 'urbem_financeiro_plano_plurianual_programa_indicadores_list');
        $this->insertRoute('urbem_financeiro_plano_plurianual_programa_indicadores_delete', 'Apagar', 'urbem_financeiro_plano_plurianual_programa_indicadores_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_configurar_lancamento_despesa_list', 'Configurar Lançamentos de Despesa', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_configurar_lancamento_despesa_create', 'Novo', 'urbem_financeiro_contabilidade_configuracao_configurar_lancamento_despesa_list');
        $this->insertRoute('urbem_financeiro_ldo_tipo_indicadores_list', 'Tipo de Indicador', 'ldo_configuracao_home');
        $this->insertRoute('urbem_financeiro_ldo_tipo_indicadores_create', 'Novo', 'urbem_financeiro_ldo_tipo_indicadores_list');
        $this->insertRoute('urbem_financeiro_ldo_tipo_indicadores_edit', 'Editar', 'urbem_financeiro_ldo_tipo_indicadores_list');
        $this->insertRoute('urbem_financeiro_ldo_tipo_indicadores_delete', 'Apagar', 'urbem_financeiro_ldo_tipo_indicadores_list');
        $this->insertRoute('urbem_financeiro_ldo_indicadores_list', 'Configurar Indicadores', 'ldo_configuracao_home');
        $this->insertRoute('urbem_financeiro_ldo_indicadores_create', 'Novo', 'urbem_financeiro_ldo_indicadores_list');
        $this->insertRoute('urbem_financeiro_ldo_indicadores_edit', 'Editar', 'urbem_financeiro_ldo_indicadores_list');
        $this->insertRoute('urbem_financeiro_ldo_indicadores_delete', 'Apagar', 'urbem_financeiro_ldo_indicadores_list');
        $this->insertRoute('urbem_financeiro_ppa_acao_list', 'Cadastro de Ações', 'financeiro_ppa_acao_home');
        $this->insertRoute('urbem_financeiro_ppa_acao_create', 'Novo', 'urbem_financeiro_ppa_acao_list');
        $this->insertRoute('urbem_financeiro_ppa_acao_edit', 'Editar', 'urbem_financeiro_ppa_acao_list');
        $this->insertRoute('urbem_financeiro_ppa_acao_delete', 'Apagar', 'urbem_financeiro_ppa_acao_list');
        $this->insertRoute('urbem_financeiro_ppa_acao_perfil', 'Plano Plurianual - Ações', 'financeiro');
        $this->insertRoute('urbem_financeiro_ppa_acao_recurso_create', 'Fontes de Recurso', 'urbem_financeiro_ppa_acao_list');
        $this->insertRoute('financeiro_ppa_acao_home', 'Plano Plurianual - Ações', 'financeiro');
        $this->insertRoute('financeiro_ppa_acao_lancar', 'Lançar Metas Físicas Realizadas', 'financeiro_ppa_acao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_historico_contabil_list', 'Contabilidade - Histórico Padrão', 'financeiro');
        $this->insertRoute('urbem_financeiro_contabilidade_historico_contabil_create', 'Novo', 'urbem_financeiro_contabilidade_historico_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_historico_contabil_edit', 'Editar', 'urbem_financeiro_contabilidade_historico_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_historico_contabil_delete', 'Apagar', 'urbem_financeiro_contabilidade_historico_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_historico_contabil_show', 'Detalhes', 'urbem_financeiro_contabilidade_historico_contabil_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_desdobramento_receita_list', 'Desdobramento da Receita', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_desdobramento_receita_create', 'Novo', 'urbem_financeiro_contabilidade_configuracao_desdobramento_receita_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_desdobramento_receita_edit', 'Editar', 'urbem_financeiro_contabilidade_configuracao_desdobramento_receita_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_desdobramento_receita_delete', 'Apagar', 'urbem_financeiro_contabilidade_configuracao_desdobramento_receita_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_desdobramento_receita_show', 'Detalhes', 'urbem_financeiro_contabilidade_configuracao_desdobramento_receita_list');
        $this->insertRoute('plano_plurianual_destinacao_recursos', 'Plano Plurianual - Destinação de Recursos', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_identificador_uso_list', 'Identificadores de Uso', 'plano_plurianual_destinacao_recursos');
        $this->insertRoute('urbem_financeiro_orcamento_identificador_uso_create', 'Novo', 'urbem_financeiro_orcamento_identificador_uso_list');
        $this->insertRoute('urbem_financeiro_orcamento_identificador_uso_edit', 'Editar', 'urbem_financeiro_orcamento_identificador_uso_list');
        $this->insertRoute('urbem_financeiro_orcamento_identificador_uso_delete', 'Apagar', 'urbem_financeiro_orcamento_identificador_uso_list');
        $this->insertRoute('urbem_financeiro_orcamento_identificador_uso_show', 'Detalhes', 'urbem_financeiro_orcamento_identificador_uso_list');

        //Início > Financeiro > Empenho - Configuração > Histórico Empenho
        $this->insertRoute('urbem_financeiro_empenho_configuracao_historico_list', 'Histórico Empenho', 'empenho_configuracao_home');
        $this->insertRoute('urbem_financeiro_empenho_configuracao_historico_create', 'Novo', 'urbem_financeiro_empenho_configuracao_historico_list');
        $this->insertRoute('urbem_financeiro_empenho_configuracao_historico_edit', 'Editar', 'urbem_financeiro_empenho_configuracao_historico_list');
        $this->insertRoute('urbem_financeiro_empenho_configuracao_historico_delete', 'Apagar', 'urbem_financeiro_empenho_configuracao_historico_list');
        $this->insertRoute('urbem_financeiro_empenho_configuracao_historico_show', 'Detalhes', 'urbem_financeiro_empenho_configuracao_historico_list');

        $this->insertRoute('urbem_financeiro_ldo_validacao_acoes_list', 'Validação de Ações', 'ldo_configuracao_home');
        $this->insertRoute('urbem_financeiro_ldo_validacao_acoes_create', 'Novo', 'urbem_financeiro_ldo_validacao_acoes_list');
        $this->insertRoute('urbem_financeiro_ldo_validacao_acoes_edit', 'Editar', 'urbem_financeiro_ldo_validacao_acoes_list');
        $this->insertRoute('urbem_financeiro_ldo_validacao_acoes_delete', 'Apagar', 'urbem_financeiro_ldo_validacao_acoes_list');
        $this->insertRoute('urbem_financeiro_ldo_validacao_acoes_show', 'Detalhes', 'urbem_financeiro_ldo_validacao_acoes_list');
        $this->insertRoute('urbem_financeiro_orcamento_especificacao_destinacao_recurso_list', 'Especificação das Destinações', 'plano_plurianual_destinacao_recursos');
        $this->insertRoute('urbem_financeiro_orcamento_especificacao_destinacao_recurso_create', 'Novo', 'urbem_financeiro_orcamento_especificacao_destinacao_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_especificacao_destinacao_recurso_edit', 'Editar', 'urbem_financeiro_orcamento_especificacao_destinacao_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_especificacao_destinacao_recurso_delete', 'Apagar', 'urbem_financeiro_orcamento_especificacao_destinacao_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_especificacao_destinacao_recurso_show', 'Detalhes', 'urbem_financeiro_orcamento_especificacao_destinacao_recurso_list');
        $this->insertRoute('empenho_configuracao_home', 'Empenho - Configuração', 'financeiro');
        $this->insertRoute('financeiro_empenho_home', 'Empenho', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_detalhamento_recurso_list', 'Detalhamento de Destinações', 'plano_plurianual_destinacao_recursos');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_detalhamento_recurso_create', 'Novo', 'urbem_financeiro_orcamento_destinacao_detalhamento_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_detalhamento_recurso_edit', 'Editar', 'urbem_financeiro_orcamento_destinacao_detalhamento_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_detalhamento_recurso_delete', 'Apagar', 'urbem_financeiro_orcamento_destinacao_detalhamento_recurso_list');
        $this->insertRoute('urbem_financeiro_orcamento_destinacao_detalhamento_recurso_show', 'Detalhes', 'urbem_financeiro_orcamento_destinacao_detalhamento_recurso_list');
        $this->insertRoute('urbem_financeiro_ldo_renuncia_receita_list', 'Renúncia de Receita', 'ldo_configuracao_home');
        $this->insertRoute('urbem_financeiro_ldo_renuncia_receita_create', 'Novo', 'urbem_financeiro_ldo_renuncia_receita_list');
        $this->insertRoute('urbem_financeiro_ldo_renuncia_receita_edit', 'Editar', 'urbem_financeiro_ldo_renuncia_receita_list');
        $this->insertRoute('urbem_financeiro_ldo_renuncia_receita_delete', 'Apagar', 'urbem_financeiro_ldo_renuncia_receita_list');
        $this->insertRoute('urbem_financeiro_ldo_renuncia_receita_show', 'Detalhes', 'urbem_financeiro_ldo_renuncia_receita_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_configurar_lancamento_receita_list', 'Configurar Lançamentos de Receita', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_configurar_lancamento_receita_create', 'Novo', 'urbem_financeiro_contabilidade_configuracao_configurar_lancamento_receita_list');
        $this->insertRoute('ldo_configuracao_despesa_receita', 'Despesa - Receita', 'ldo_configuracao_home');
        $this->insertRoute('ldo_configuracao_despesa_receita_grid', 'Despesa - Receita', 'ldo_configuracao_home');
        $this->insertRoute('ldo_configuracao_despesa_receita_gravar', 'Despesa - Receita', 'ldo_configuracao_home');
        $this->insertRoute('urbem_financeiro_ldo_homologar_ldo_create', 'Homologar LDO', 'ldo_configuracao_home');
        $this->insertRoute('urbem_financeiro_ldo_homologar_ldo_edit', 'Homologar LDO', 'ldo_configuracao_home');
        $this->insertRoute('adiantamento_subvencao_index', 'Empenho - Adiantamento / Subvenção', 'financeiro');
        $this->insertRoute('urbem_financeiro_empenho_contrapartida_responsavel_list', 'Responsáveis por Adiantamento', 'adiantamento_subvencao_index');
        $this->insertRoute('urbem_financeiro_empenho_contrapartida_responsavel_create', 'Novo', 'urbem_financeiro_empenho_contrapartida_responsavel_list');
        $this->insertRoute('urbem_financeiro_empenho_contrapartida_responsavel_edit', 'Editar', 'urbem_financeiro_empenho_contrapartida_responsavel_list');
        $this->insertRoute('urbem_financeiro_empenho_contrapartida_responsavel_delete', 'Apagar', 'urbem_financeiro_empenho_contrapartida_responsavel_list');
        $this->insertRoute('urbem_financeiro_empenho_contrapartida_responsavel_show', 'Detalhes', 'urbem_financeiro_empenho_contrapartida_responsavel_list');
        $this->insertRoute('urbem_financeiro_orcamento_configuracao_replicar_entidade_create', 'Replicar Entidade', 'orcamento_configuracao_home');
        $this->insertRoute('urbem_financeiro_empenho_configuracao_permissao_autorizacao_create', 'Definir Permissão', 'empenho_configuracao_home');

        //Início > Financeiro > PPA - Relatórios
        $this->insertRoute('plano_plurianual_relatorios', 'Plano Plurianual - Relatorios', 'financeiro');
        $this->insertRoute('urbem_financeiro_ppa_relatorios_estimativa_receita_create', 'Estimativa da Receita', 'plano_plurianual_relatorios');
        $this->insertRoute('urbem_financeiro_ppa_relatorios_programa_macro_objetivo_create', 'Programas por Macro Objetivo', 'plano_plurianual_relatorios');
        $this->insertRoute('urbem_financeiro_ppa_relatorios_despesas_previstas_funcao_create', 'Despesas Previstas por Função', 'plano_plurianual_relatorios');
        $this->insertRoute('urbem_financeiro_ppa_relatorios_resumo_despesas_programas_create', 'Resumo Despesas por Programas', 'plano_plurianual_relatorios');
        $this->insertRoute('urbem_financeiro_ppa_relatorios_acoes_nao_orcamentarias_create', 'Ações Não Orçamentárias', 'plano_plurianual_relatorios');
        $this->insertRoute('urbem_financeiro_ppa_relatorios_despesa_fonte_recursos_create', 'Despesa por Fonte de Recursos', 'plano_plurianual_relatorios');
        $this->insertRoute('urbem_financeiro_empenho_autorizacao_list', 'Autorização', 'empenho_autorizacao_home');
        $this->insertRoute('urbem_financeiro_empenho_autorizacao_create', 'Incluir Autorização Diversos', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_empenho_autorizacao_edit', 'Alterar Autorização', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_empenho_autorizacao_delete', 'Apagar', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_empenho_autorizacao_show', 'Detalhes', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_empenho_item_pre_empenho_create', 'Item de Autorização :: Novo', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_empenho_item_pre_empenho_edit', 'Item de Autorização :: Editar', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_empenho_item_pre_empenho_delete', 'Item de Autorização :: Remover', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_empenho_anular_autorizacao_create', 'Anular Autorização', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_empenho_anular_autorizacao_edit', 'Anular Autorização', 'urbem_financeiro_empenho_autorizacao_list');
        $this->insertRoute('urbem_financeiro_contabilidade_planoconta_list', 'Plano de Contas', 'financeiro');
        $this->insertRoute('urbem_financeiro_contabilidade_planoconta_create', 'Novo', 'urbem_financeiro_contabilidade_planoconta_list');
        $this->insertRoute('urbem_financeiro_contabilidade_planoconta_edit', 'Editar', 'urbem_financeiro_contabilidade_planoconta_list');
        $this->insertRoute('urbem_financeiro_contabilidade_planoconta_delete', 'Apagar', 'urbem_financeiro_contabilidade_planoconta_list');
        $this->insertRoute('urbem_financeiro_contabilidade_planoconta_show', 'Detalhes', 'urbem_financeiro_contabilidade_planoconta_list');

        //Início > Financeiro > Contabilidade - Plano de Contas
        $this->insertRoute('financeiro_contabilidade_planoconta_home', 'Contabilidade - Plano de Contas', 'financeiro');
        $this->insertRoute('urbem_contabilidade_planoconta_list', 'Contabilidade - Plano de Contas', 'financeiro');
        $this->insertRoute('urbem_contabilidade_planoconta_create', 'Novo', 'urbem_contabilidade_planoconta_list');
        $this->insertRoute('urbem_contabilidade_planoconta_edit', 'Editar', 'urbem_contabilidade_planoconta_list');
        $this->insertRoute('urbem_contabilidade_planoconta_delete', 'Apagar', 'urbem_contabilidade_planoconta_list');
        $this->insertRoute('urbem_contabilidade_planoconta_show', 'Detalhes', 'urbem_contabilidade_planoconta_list');
        $this->insertRoute('urbem_contabilidade_planoconta_encerramento', 'Encerramento de Conta', 'urbem_contabilidade_planoconta_list');
        $this->insertRoute('urbem_contabilidade_planoconta_cancela_encerramento', 'Cancelar Encerramento', 'urbem_contabilidade_planoconta_list');
        $this->insertRoute('financeiro_contabilidade_planoconta_escolha', 'Contabilidade - Escolher Plano de Contas', 'financeiro');

        //Início > Financeiro > Contabilidade - Lançamento Contábil > Lançamentos
        $this->insertRoute('lancamento_contabil_index', 'Contabilidade - Lançamento Contábil', 'financeiro');
        $this->insertRoute('urbem_financeiro_contabilidade_lote_list', 'Lançamentos', 'lancamento_contabil_index');
        $this->insertRoute('urbem_financeiro_contabilidade_lote_create', 'Novo', 'urbem_financeiro_contabilidade_lote_list');
        $this->insertRoute('urbem_financeiro_contabilidade_lote_edit', 'Editar', 'urbem_financeiro_contabilidade_lote_list');
        $this->insertRoute('urbem_financeiro_contabilidade_lote_perfil', 'Detalhes', 'urbem_financeiro_contabilidade_lote_list');
        $this->insertRoute('urbem_financeiro_contabilidade_lancamento_create', 'Novo', 'urbem_financeiro_contabilidade_lote_list');
        $this->insertRoute('urbem_financeiro_contabilidade_lancamento_edit', 'Editar', 'urbem_financeiro_contabilidade_lote_list');
        $this->insertRoute('urbem_financeiro_contabilidade_lancamento_delete', 'Apagar', 'urbem_financeiro_contabilidade_lote_list');

        $this->insertRoute('financeiro_contabilidade_encerramento_home', 'Contabilidade - Encerramento', 'financeiro');
        $this->insertRoute('financeiro_contabilidade_encerramento_efetuar_lancamento_contabil_encerramento', 'Efetuar Lançamentos Contábeis de Encerramento', 'financeiro_contabilidade_encerramento_home');
        $this->insertRoute('financeiro_contabilidade_encerramento_excluir_lancamento_contabil_encerramento', 'Excluir Lançamentos Contábeis de Encerramento', 'financeiro_contabilidade_encerramento_home');
        $this->insertRoute('financeiro_contabilidade_encerramento_gerar_restos_pagar', 'Gerar Restos a Pagar', 'financeiro_contabilidade_encerramento_home');

        $this->insertRoute('urbem_financeiro_tesouraria_configuracao_implantar_saldo_inicial_create', 'Implantar Saldos Iniciais', 'tesouraria_configuracao_home');

        $this->insertRoute('financeiro_tesouraria_configuracao_home', 'Tesouraria - Configuração', 'financeiro');
        $this->insertRoute('urbem_financeiro_empenho_emitir_empenho_autorizacao_list', 'Emitir Empenho por Autorização', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_emitir_empenho_autorizacao_edit', 'Emitir', 'urbem_financeiro_empenho_emitir_empenho_autorizacao_list');
        $this->insertRoute('ldo_relatorios_home', ' LDO - Relatorios ', 'financeiro');
        $this->insertRoute('urbem_financeiro_ldo_metas_prioridades_report_create', 'Anexo I - Metas e prioridades', 'ldo_relatorios_home');
        $this->insertRoute('tesouraria_saldos_consultar', 'Tesouraria - Consultar saldos', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_reserva_saldos_list', 'Orçamento - Reserva de Saldos', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_reserva_saldos_create', 'Novo', 'urbem_financeiro_orcamento_reserva_saldos_list');
        $this->insertRoute('urbem_financeiro_orcamento_reserva_saldos_edit', 'Anular', 'urbem_financeiro_orcamento_reserva_saldos_list');
        $this->insertRoute('urbem_financeiro_orcamento_reserva_saldos_show', 'Detalhes', 'urbem_financeiro_orcamento_reserva_saldos_list');
        $this->insertRoute('contabilidade_relatorios_home', 'Contabilidade - Relatórios', 'financeiro');
        $this->insertRoute('contabilidade_lancamento_contabil_implantacao_saldo', 'Implantação de Saldo', 'lancamento_contabil_index');
        $this->insertRoute('contabilidade_lancamento_contabil_implantacao_saldo_grid', 'Registros', 'contabilidade_lancamento_contabil_implantacao_saldo');
        $this->insertRoute('urbem_financeiro_tesouraria_abrir_boletim_list', 'Tesouraria - Boletim', 'financeiro');
        $this->insertRoute('urbem_financeiro_tesouraria_abrir_boletim_create', 'Abrir Boletim', 'urbem_financeiro_tesouraria_abrir_boletim_list');
        $this->insertRoute('tesouraria_boletim_profile', 'Detalhes', 'urbem_financeiro_tesouraria_abrir_boletim_list');
        $this->insertRoute('urbem_financeiro_tesouraria_recibo_extra_list', 'Tesouraria - Recibo Extra', 'financeiro');
        $this->insertRoute('urbem_financeiro_tesouraria_recibo_extra_create', 'Emitir Recibo', 'urbem_financeiro_tesouraria_recibo_extra_list');
        $this->insertRoute('urbem_financeiro_tesouraria_recibo_extra_delete', 'Anular', 'urbem_financeiro_tesouraria_recibo_extra_list');
        $this->insertRoute('urbem_financeiro_tesouraria_recibo_extra_show', 'Detalhes', 'urbem_financeiro_tesouraria_recibo_extra_list');

        //Início > Financeiro > Empenho - Emitir Empenho Diversos
        $this->insertRoute('urbem_financeiro_empenho_emitir_empenho_diversos_create', 'Emitir Empenho Diversos', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_emitir_empenho_diversos_delete', 'Remover', 'urbem_financeiro_empenho_emitir_empenho_diversos_create');
        $this->insertRoute('urbem_financeiro_empenho_emitir_empenho_diversos_show', 'Detalhes', 'urbem_financeiro_empenho_emitir_empenho_diversos_create');
        $this->insertRoute('urbem_financeiro_empenho_item_empenho_diversos_create', 'Emitir Empenho Diversos :: Adicionar Item', 'urbem_financeiro_empenho_emitir_empenho_diversos_create');
        $this->insertRoute('urbem_financeiro_empenho_item_empenho_diversos_delete', 'Remover', 'urbem_financeiro_empenho_item_empenho_diversos_create');
        $this->insertRoute('urbem_financeiro_empenho_item_empenho_diversos_show', 'Detalhes', 'urbem_financeiro_empenho_item_empenho_diversos_create');
        $this->insertRoute('urbem_financeiro_empenho_item_empenho_diversos_edit', 'Emitir Empenho Diversos :: Editar Item', 'urbem_financeiro_empenho_emitir_empenho_diversos_create');

        $this->insertRoute('financeiro_contabilidade_encerramento_anular_restos_pagar', 'Anular Inscrição Restos a Pagar', 'financeiro_contabilidade_encerramento_home');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_institucional_list', 'Orçamento - Classificação Institucional', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_institucional_create', 'Novo', 'urbem_financeiro_orcamento_classificacao_institucional_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_institucional_edit', 'Editar', 'urbem_financeiro_orcamento_classificacao_institucional_list');
        $this->insertRoute('urbem_financeiro_orcamento_classificacao_institucional_show', 'Detalhes', 'urbem_financeiro_orcamento_classificacao_institucional_list');
        $this->insertRoute('urbem_financeiro_empenho_emitir_empenho_complementar_create', 'Emitir Empenho Complementar', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_emitir_empenho_complementar_delete', 'Remover', 'urbem_financeiro_empenho_emitir_empenho_complementar_create');
        $this->insertRoute('urbem_financeiro_empenho_emitir_empenho_complementar_show', 'Detalhes', 'urbem_financeiro_empenho_emitir_empenho_complementar_create');
        $this->insertRoute('urbem_financeiro_empenho_item_empenho_complementar_create', 'Emitir Empenho Complementar :: Adicionar Item', 'urbem_financeiro_empenho_emitir_empenho_complementar_create');
        $this->insertRoute('urbem_financeiro_empenho_item_empenho_complementar_edit', 'Emitir Empenho Complementar :: Adicionar Item', 'urbem_financeiro_empenho_emitir_empenho_complementar_create');
        $this->insertRoute('urbem_financeiro_empenho_item_empenho_complementar_delete', 'Remover', 'urbem_financeiro_empenho_item_empenho_diversos_create');
        $this->insertRoute('urbem_financeiro_empenho_item_empenho_complementar_show', 'Detalhes', 'urbem_financeiro_empenho_item_empenho_diversos_create');
        $this->insertRoute('urbem_financeiro_tesouraria_terminal_list', 'Terminal e Usuários', 'tesouraria_configuracao_home');
        $this->insertRoute('urbem_financeiro_tesouraria_terminal_create', 'Incluir ', 'urbem_financeiro_tesouraria_terminal_list');
        $this->insertRoute('urbem_financeiro_tesouraria_terminal_edit', 'Alterar ', 'urbem_financeiro_tesouraria_terminal_list');
        $this->insertRoute('urbem_financeiro_tesouraria_terminal_delete', 'Desativar ', 'urbem_financeiro_tesouraria_terminal_list');
        $this->insertRoute('urbem_financeiro_tesouraria_terminal_show', 'Consultar ', 'urbem_financeiro_tesouraria_terminal_list');

        //Início > Financeiro > Empenho - Ordem de Pagamento
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_list', 'Empenho - Ordem de Pagamento', 'financeiro');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_create', 'Emitir Ordem de Pagamento', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_pagamento_liquidacao_create', 'Novo Item', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_pagamento_liquidacao_delete', 'Apagar Item', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_perfil', 'Perfil', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_retencao_create', 'Nova Retenção', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_retencao_delete', 'Apagar Retenção', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_assinatura_create', 'Nova Assinatura', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_assinatura_delete', 'Apagar Assinatura', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_edit', 'Anular Ordem de Pagamento', 'urbem_financeiro_empenho_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_empenho_ordem_pagamento_anulada_list', 'Reemitir Ordem de Pagamento', 'urbem_financeiro_empenho_ordem_pagamento_list');

        $this->insertRoute('urbem_financeiro_orcamento_saldodotacao_list', 'Orçamento - Saldos de Dotação', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_saldodotacao_show', 'Detalhes', 'urbem_financeiro_orcamento_saldodotacao_list');
        $this->insertRoute('tesouraria_emitir_cheque_home', 'Tesouraria - Emissão e Controle de Cheques', 'financeiro');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_list', 'Emissão e Controle', 'tesouraria_emitir_cheque_home');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_create', 'Incluir cheque ', 'urbem_financeiro_tesouraria_cheque_emissao_list');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_delete', 'Excluir cheque ', 'urbem_financeiro_tesouraria_cheque_emissao_list');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_show', 'Consultar cheque', 'urbem_financeiro_tesouraria_cheque_emissao_list');
        $this->insertRoute('urbem_financeiro_empenho_reemitir_empenho_list', 'Reemitir Empenho', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_consultar_empenho_list', 'Consultar Empenho', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_consultar_empenho_show', 'Detalhe', 'urbem_financeiro_empenho_consultar_empenho_list');
        $this->insertRoute('tesouraria_arrecadacao_home', 'Tesouraria - Arrecadação', 'financeiro');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_orcamentaria_arrecadacoes_create', 'Orçamentária - Arrecadações', 'tesouraria_arrecadacao_home');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_orcamentaria_devolucao_receita_create', 'Orçamentária - Devolução de Receita', 'tesouraria_arrecadacao_home');
        $this->insertRoute('tesouraria_arrecadacao_permissao', 'Permissão', 'tesouraria_arrecadacao_home');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_orcamentaria_arrecadacoes_list', 'Orçamentária - Estornos', 'tesouraria_arrecadacao_home');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_orcamentaria_arrecadacoes_edit', 'Estornar Arrecadação por Receita', 'urbem_financeiro_tesouraria_arrecadacao_orcamentaria_arrecadacoes_list');
        $this->insertRoute('tesouraria_outras_operacoes_home', 'Tesoureria - Outras Operações', 'financeiro');
        $this->insertRoute('urbem_financeiro_tesouraria_aplicacao_list', 'Aplicações', 'tesouraria_outras_operacoes_home');
        $this->insertRoute('urbem_financeiro_tesouraria_aplicacao_create', 'Novo', 'urbem_financeiro_tesouraria_aplicacao_list');
        $this->insertRoute('urbem_financeiro_tesouraria_aplicacao_show', 'Detalhes', 'urbem_financeiro_tesouraria_aplicacao_list');
        $this->insertRoute('urbem_financeiro_tesouraria_resgate_list', 'Resgate', 'tesouraria_outras_operacoes_home');
        $this->insertRoute('urbem_financeiro_tesouraria_resgate_create', 'Novo', 'urbem_financeiro_tesouraria_resgate_list');
        $this->insertRoute('urbem_financeiro_tesouraria_resgate_show', 'Detalhes', 'urbem_financeiro_tesouraria_resgate_list');
        $this->insertRoute('urbem_financeiro_tesouraria_deposito_list', 'Depósito', 'tesouraria_outras_operacoes_home');
        $this->insertRoute('urbem_financeiro_tesouraria_deposito_create', 'Novo', 'urbem_financeiro_tesouraria_deposito_list');
        $this->insertRoute('urbem_financeiro_tesouraria_deposito_show', 'Detalhes', 'urbem_financeiro_tesouraria_deposito_list');
        $this->insertRoute('urbem_financeiro_empenho_liquidar_empenho_list', 'Empenho - Liquidação de Empenho', 'financeiro');
        $this->insertRoute('urbem_financeiro_empenho_liquidar_empenho_edit', 'Editar', 'urbem_financeiro_empenho_liquidar_empenho_list');

        //Início > Financeiro > Orçamento - Elaboração do Orçamento
        $this->insertRoute('financeiro_orcamento_elaboracao_orcamento_home', 'Elaboração Orçamento', 'financeiro');
        $this->insertRoute('urbem_financeiro_orcamento_registro_metas_arrecadacao_receita_create', 'Orçamento - Metas de arrecadação', 'financeiro_orcamento_elaboracao_orcamento_home');
        $this->insertRoute('urbem_financeiro_orcamento_registro_metas_arrecadacao_receita_edit', 'Lançar', 'urbem_financeiro_orcamento_registro_metas_arrecadacao_receita_create');

        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_list', 'Emitir Cheque por Ordem de pagamento', 'tesouraria_emitir_cheque_home');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_edit', 'Emissão por Ordem de Pagamento', 'urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_cheque_create', 'Cheque para Emissão por Ordem de Pagamento', 'urbem_financeiro_tesouraria_cheque_emissao_ordem_pagamento_list');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_extra_arrecadacoes_list', 'Extra - Arrecadações', 'tesouraria_arrecadacao_home');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_extra_arrecadacoes_create', 'Novo', 'urbem_financeiro_tesouraria_arrecadacao_extra_arrecadacoes_list');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_extra_arrecadacoes_show', 'Detalhe', 'urbem_financeiro_tesouraria_arrecadacao_extra_arrecadacoes_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_nota_explicativa_list', 'Manter Notas Explicativas', 'contabilidade_configuracao_home');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_nota_explicativa_create', 'Incluir', 'urbem_financeiro_contabilidade_configuracao_nota_explicativa_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_nota_explicativa_edit', 'Editar', 'urbem_financeiro_contabilidade_configuracao_nota_explicativa_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_nota_explicativa_show', 'Detalhes', 'urbem_financeiro_contabilidade_configuracao_nota_explicativa_list');
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao_nota_explicativa_delete', 'Apagar', 'urbem_financeiro_contabilidade_configuracao_nota_explicativa_list');
        $this->insertRoute('contabilidade_lancamento_contabil_saldo_balanco', 'Saldo de Balanço', 'lancamento_contabil_index');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_extra_arrecadacoes_create', 'Extra - Arrecadações', 'tesouraria_arrecadacao_home');
        $this->insertRoute('urbem_financeiro_empenho_anular_empenho_list', 'Anular Empenho', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_anular_empenho_edit', 'Anular', 'urbem_financeiro_empenho_anular_empenho_list');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_recibo_extra_list', 'Emitir Cheque por Despesa Extra', 'tesouraria_emitir_cheque_home');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_recibo_extra_edit', 'Emissão de Despesa Extra', 'urbem_financeiro_tesouraria_cheque_emissao_recibo_extra_list');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_recibo_extra_cheque_create', 'Cheque para Emissão por Despesa Extra', 'urbem_financeiro_tesouraria_cheque_emissao_recibo_extra_list');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_transferencia_list', 'Emitir cheque por Transferência', 'tesouraria_emitir_cheque_home');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_transferencia_edit', 'Emissão por Transferência', 'urbem_financeiro_tesouraria_cheque_emissao_transferencia_list');
        $this->insertRoute('urbem_financeiro_tesouraria_cheque_emissao_transferencia_cheque_create', 'Cheque para Emissão por Transferência', 'urbem_financeiro_tesouraria_cheque_emissao_transferencia_list');
        $this->insertRoute('contabilidade_lancamento_contabil_gerar_lancamento_credito_receber', 'Gerar Lançamentos Créditos a Receber', 'lancamento_contabil_index');
        $this->insertRoute('urbem_financeiro_tesouraria_estorno_create', 'Tesouraria - Estornos', 'financeiro');
        $this->insertRoute('contabilidade_lancamento_contabil_gerar_lancamento_credito_receber_grid', 'Gerar Lançamentos Créditos a Receber', 'lancamento_contabil_index');
        $this->insertRoute('urbem_financeiro_empenho_reemitir_anulacao_empenho_list', 'Reemitir Anulação de Empenho', 'financeiro_empenho_home');
        $this->insertRoute('contabilidade_lancamento_contabil_abertura_orcamento_anual', 'Abertura de Orçamento Anual', 'lancamento_contabil_index');
        $this->insertRoute('contabilidade_lancamento_contabil_abertura_orcamento_anual_grid', 'Registrar Saldos', 'contabilidade_lancamento_contabil_abertura_orcamento_anual');
        $this->insertRoute('contabilidade_lancamento_contabil_abertura_restos_pagar', 'Abertura Restos a Pagar', 'lancamento_contabil_index');
        $this->insertRoute('urbem_financeiro_empenho_empenho_convenio_list', 'Vincular Empenho a um Convênio', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_empenho_convenio_criar_vinculo', 'Vincular Empenho a um Convênio', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_empenho_assinatura_create', 'Assinaturas :: Incluir', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_empenho_assinatura_edit', 'Assinaturas :: Editar', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_empenho_assinatura_delete', 'Assinaturas :: Remover', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_empenho_assinatura_list', 'Assinaturas :: Listar', 'financeiro_empenho_home');

        $this->insertRoute('urbem_financeiro_tesouraria_pagamentos_orcamentaria_pagamentos_list', 'Orçamentária - Pagamentos', 'financeiro_tesouraria_pagamentos_home');
        $this->insertRoute('urbem_financeiro_tesouraria_pagamentos_orcamentaria_pagamentos_edit', 'Pagar', 'urbem_financeiro_tesouraria_pagamentos_orcamentaria_pagamentos_list');
        $this->insertRoute('urbem_financeiro_tesouraria_pagamentos_orcamentaria_pagamentos_create', 'Pagar', 'urbem_financeiro_tesouraria_pagamentos_orcamentaria_pagamentos_list');
        $this->insertRoute('financeiro_tesouraria_permissao', 'Permissão', 'financeiro_tesouraria_pagamentos_home');

        $this->insertRoute('empenho_autorizacao_home', 'Autorização de Empenho', 'financeiro');
        $this->insertRoute('urbem_financeiro_empenho_duplicar_autorizacao', 'Duplicar Autorização', 'empenho_autorizacao_home');

        //Rotas de Financeiro > Tesouraria > Pagamentos Home
        $this->insertRoute('financeiro_tesouraria_pagamentos_home', 'Tesouraria - Pagamentos', 'financeiro');
        $this->insertRoute('urbem_financeiro_tesouraria_pagamentos_orcamentaria_estornos_list', 'Orçamentária - Estornos', 'financeiro_tesouraria_pagamentos_home');
        $this->insertRoute('urbem_financeiro_tesouraria_pagamentos_orcamentaria_estornos_create', 'Estornar', 'urbem_financeiro_tesouraria_pagamentos_orcamentaria_estornos_list');

        //Rotas de Financeiro > Tesouraria - Pagamentos > Extra - Estornos
        $this->insertRoute('urbem_financeiro_tesouraria_extra_estorno_list', 'Extra - Estornos', 'financeiro_tesouraria_pagamentos_home');
        $this->insertRoute('urbem_financeiro_tesouraria_extra_estorno_create', 'Extra - Estornos', 'financeiro_tesouraria_pagamentos_home');
        $this->insertRoute('urbem_financeiro_tesouraria_extra_estorno_show', 'Extra - Estornos', 'financeiro_tesouraria_pagamentos_home');

        //Rotas de Financeiro > Tesouraria > Conciliação
        $this->insertRoute('urbem_financeiro_tesouraria_conciliacao_list', 'Tesouraria - Conciliação', 'financeiro');
        $this->insertRoute('urbem_financeiro_tesouraria_conciliacao_edit', 'Conciliar', 'urbem_financeiro_tesouraria_conciliacao_list');
        $this->insertRoute('urbem_financeiro_tesouraria_conciliacao_create', 'Conciliar Conta', 'urbem_financeiro_tesouraria_conciliacao_list');

        //Início > Financeiro > Empenho > Vincular Empenho a um Convênio
        $this->insertRoute('urbem_financeiro_empenho_empenho_convenio_edit', 'Criar Vínculo', 'urbem_financeiro_empenho_empenho_convenio_list');

        //Início > Financeiro > Empenho > Vincular Empenho a um Contrato
        $this->insertRoute('urbem_financeiro_empenho_empenho_contrato_list', 'Vincular Empenho a um Contrato', 'financeiro_empenho_home');
        $this->insertRoute('urbem_financeiro_empenho_empenho_contrato_edit', 'Criar Vínculo', 'urbem_financeiro_empenho_empenho_contrato_list');

        //Início > Financeiro > Orçamento - Elaboração do Orçamento > Receita
        $this->insertRoute('urbem_financeiro_orcamento_elaboracao_orcamento_receita_list', 'Receita', 'financeiro_orcamento_elaboracao_orcamento_home');
        $this->insertRoute('urbem_financeiro_orcamento_elaboracao_orcamento_receita_create', 'Incluir Receita', 'urbem_financeiro_orcamento_elaboracao_orcamento_receita_list');
        $this->insertRoute('urbem_financeiro_orcamento_elaboracao_orcamento_receita_edit', 'Alterar Receita', 'urbem_financeiro_orcamento_elaboracao_orcamento_receita_list');
        $this->insertRoute('urbem_financeiro_orcamento_elaboracao_orcamento_receita_delete', 'Excluir Receita', 'urbem_financeiro_orcamento_elaboracao_orcamento_receita_list');

        //Início > Financeiro > Tesouraria - Arrecadação > Extra Extorno
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_extra_estornos_list', 'Extra - Estornos', 'tesouraria_arrecadacao_home');
        $this->insertRoute('urbem_financeiro_tesouraria_arrecadacao_extra_estornos_create', 'Estornar', 'urbem_financeiro_tesouraria_arrecadacao_extra_estornos_list');

        //Rotas de Financeiro > Tesouraria > Pagamentos > Estorno
        $this->insertRoute('urbem_financeiro_tesouraria_pagamentos_estorno_list', 'Orçamentária - Estornos', 'financeiro_tesouraria_pagamentos_home');
        $this->insertRoute('urbem_financeiro_tesouraria_pagamentos_estorno_edit', 'Detalhe', 'urbem_financeiro_tesouraria_pagamentos_estorno_list');

        //Rotas de Financeiro > Orçamento - Configuração
        $this->insertRoute('urbem_financeiro_orcamento_configuracao', 'Orçamento - Configuração', 'financeiro');

        //Rotas de Financeiro > Contabilidade - Configuração
        $this->insertRoute('urbem_financeiro_contabilidade_configuracao', 'Contabilidade - Configuração', 'financeiro');
        $this->insertRoute('financeiro_contabilidade_configuracao_desdobramento_receita_filtro', 'Configurar Desdobramento da Receita', 'contabilidade_configuracao_home');

        //Rotas de Financeiro > Empenho - Configuração
        $this->insertRoute('urbem_financeiro_empenho_configuracao', 'Empenho - Configuração', 'financeiro');

        //Rotas de Financeiro > Tesouraria - Configuração
        $this->insertRoute('urbem_financeiro_tesouraria_configuracao', 'Tesouraria - Configuração', 'financeiro');

        //Rotas de Financeiro > Tesouraria > Pagamentos > Extra - Pagamentos
        $this->insertRoute('urbem_financeiro_tesouraria_extra_pagamento_list', 'Extra - Pagamentos', 'financeiro_tesouraria_pagamentos_home');
        $this->insertRoute('urbem_financeiro_tesouraria_extra_pagamento_create', 'Novo', 'urbem_financeiro_tesouraria_extra_pagamento_list');
        $this->insertRoute('urbem_financeiro_tesouraria_extra_pagamento_show', 'Detalhe', 'urbem_financeiro_tesouraria_extra_pagamento_list');

        //Rotas de Financeiro > Contabilidade > Cancelar Abertura Restos A Pagar
        $this->insertRoute('urbem_financeiro_contabilidade_cancelar_abertura_restos_a_pagar_list', 'Cancelar Abertura Restos a Pagar', 'lancamento_contabil_index');
        $this->insertRoute('urbem_financeiro_contabilidade_cancelar_abertura_restos_a_pagar_processar', 'Cancelar', 'urbem_financeiro_contabilidade_cancelar_abertura_restos_a_pagar_list');

        //Rotas de Financeiro > Tesouraria > Bordero
        $this->insertRoute('urbem_financeiro_tesouraria_pagamento_bordero_list', 'Borderô - Pagamentos', 'financeiro_tesouraria_pagamentos_home');
        $this->insertRoute('urbem_financeiro_tesouraria_pagamento_bordero_create', 'Borderô - Pagamentos', 'urbem_financeiro_tesouraria_pagamento_bordero_list');
        $this->insertRoute('urbem_financeiro_tesouraria_pagamento_bordero_show', 'Borderô - Pagamentos', 'urbem_financeiro_tesouraria_pagamento_bordero_list');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
