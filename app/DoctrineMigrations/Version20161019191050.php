<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191050 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->insertRoute('tributario', 'Tributário', 'home-urbem');

//Cadastro Imobiliário - Configuração
        $this->insertRoute('tributario_imobiliario_configuracao_home', 'Cadastro Imobiliário - Configuração', 'tributario');
        $this->insertRoute('tributario_imobiliario_configuracao_alterar', 'Alterar Configuração', 'tributario_imobiliario_configuracao_home');

//Cadastro Imobiliário - Hierarquia
        $this->insertRoute('tributario_imobiliario_hierarquia_home', 'Cadastro Imobiliário - Hierarquia', 'tributario');
        $this->insertRoute('tributario_economico_hierarquia_servico_home', 'Cadastro Econômico - Hierarquia de Serviço', 'tributario');

//Cadastro Imobiliário - Hierarquia > Vigência
        $this->insertRoute('urbem_tributario_imobiliario_vigencia_list', 'Vigência', 'tributario_imobiliario_hierarquia_home');
        $this->insertRoute('urbem_tributario_imobiliario_vigencia_create', 'Incluir', 'urbem_tributario_imobiliario_vigencia_list');
        $this->insertRoute('urbem_tributario_imobiliario_vigencia_edit', 'Alterar', 'urbem_tributario_imobiliario_vigencia_list');
        $this->insertRoute('urbem_tributario_imobiliario_vigencia_delete', 'Excluir', 'urbem_tributario_imobiliario_vigencia_list');

//Cadastro Imobiliário - Hierarquia > Nível
        $this->insertRoute('urbem_tributario_imobiliario_nivel_filtro', 'Nível - Filtro', 'tributario_imobiliario_hierarquia_home');
        $this->insertRoute('urbem_tributario_imobiliario_nivel_list', 'Nível', 'tributario_imobiliario_hierarquia_home');
        $this->insertRoute('urbem_tributario_imobiliario_nivel_create', 'Incluir', 'urbem_tributario_imobiliario_nivel_list');
        $this->insertRoute('urbem_tributario_imobiliario_nivel_edit', 'Alterar', 'urbem_tributario_imobiliario_nivel_list');
        $this->insertRoute('urbem_tributario_imobiliario_nivel_delete', 'Excluir', 'urbem_tributario_imobiliario_nivel_list');
        $this->insertRoute('urbem_tributario_imobiliario_nivel_show', 'Detalhe', 'urbem_tributario_imobiliario_nivel_list');

//Cadastro Monetário - Banco
        $this->insertRoute('urbem_tributario_monetario_banco_list', 'Cadastro Monetário - Banco', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_banco_create', 'Incluir', 'urbem_tributario_monetario_banco_list');
        $this->insertRoute('urbem_tributario_monetario_banco_edit', 'Alterar', 'urbem_tributario_monetario_banco_list');
        $this->insertRoute('urbem_tributario_monetario_banco_delete', 'Excluir', 'urbem_tributario_monetario_banco_list');
        $this->insertRoute('urbem_tributario_monetario_banco_show', 'Detalhe', 'urbem_tributario_monetario_banco_list');

//Cadastro Econômico - Configuração
        $this->insertRoute('tributario_economico_configuracao_home', 'Cadastro Econômico - Configuração', 'tributario');
        $this->insertRoute('tributario_economico_configuracao_alterar', 'Alterar Configuração', 'tributario_economico_configuracao_home');

//Cadastro Econômico - Categoria
        $this->insertRoute('urbem_tributario_economico_categoria_list', 'Cadastro Econômico - Categoria', 'tributario');
        $this->insertRoute('urbem_tributario_economico_categoria_create', 'Incluir', 'urbem_tributario_economico_categoria_list');
        $this->insertRoute('urbem_tributario_economico_categoria_edit', 'Alterar', 'urbem_tributario_economico_categoria_list');
        $this->insertRoute('urbem_tributario_economico_categoria_delete', 'Excluir', 'urbem_tributario_economico_categoria_list');
        $this->insertRoute('urbem_tributario_economico_categoria_show', 'Detalhe', 'urbem_tributario_economico_categoria_list');

//Econômico - Natureza Jurídica
        $this->insertRoute('urbem_tributario_economico_natureza_juridica_list', 'Natureza Jurídica', 'tributario');
        $this->insertRoute('urbem_tributario_economico_natureza_juridica_create', 'Incluir', 'urbem_tributario_economico_natureza_juridica_list');
        $this->insertRoute('urbem_tributario_economico_natureza_juridica_edit', 'Alterar', 'urbem_tributario_economico_natureza_juridica_list');
        $this->insertRoute('urbem_tributario_economico_natureza_juridica_show', 'Detalhe', 'urbem_tributario_economico_natureza_juridica_list');
        $this->insertRoute('urbem_tributario_economico_natureza_juridica_delete', 'Excluir', 'urbem_tributario_economico_natureza_juridica_list');
        $this->insertRoute('urbem_tributario_economico_natureza_juridica_baixar', 'Baixar', 'urbem_tributario_economico_natureza_juridica_list');
        $this->insertRoute('urbem_tributario_economico_natureza_juridica_cancelar', 'Cancelar', 'urbem_tributario_economico_natureza_juridica_list');

//Cadastro Monetário - Indicador Econômico
        $this->insertRoute('urbem_tributario_monetario_indicador_economico_list', 'Cadastro Monetário - Indicador Econômico', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_indicador_economico_create', 'Incluir', 'urbem_tributario_monetario_indicador_economico_list');
        $this->insertRoute('urbem_tributario_monetario_indicador_economico_edit', 'Alterar', 'urbem_tributario_monetario_indicador_economico_list');
        $this->insertRoute('urbem_tributario_monetario_indicador_economico_delete', 'Excluir', 'urbem_tributario_monetario_indicador_economico_list');
        $this->insertRoute('urbem_tributario_monetario_indicador_economico_show', 'Detalhe', 'urbem_tributario_monetario_indicador_economico_list');

//Cadastro Imobiliário - Localização
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_list', 'Cadastro Imobiliário - Localização', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_create', 'Incluir', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_edit', 'Alterar', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_delete', 'Excluir', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_show', 'Detalhe', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_baixar', 'Baixar', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_reativar', 'Reativar', 'urbem_tributario_imobiliario_localizacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_localizacao_caracteristicas', 'Alterar Características', 'urbem_tributario_imobiliario_localizacao_list');

//Cadastro Econômico - Elemento
        $this->insertRoute('urbem_tributario_economico_elemento_list', 'Cadastro Econômico - Elemento', 'tributario');
        $this->insertRoute('urbem_tributario_economico_elemento_create', 'Incluir', 'urbem_tributario_economico_elemento_list');
        $this->insertRoute('urbem_tributario_economico_elemento_edit', 'Alterar', 'urbem_tributario_economico_elemento_list');
        $this->insertRoute('urbem_tributario_economico_elemento_delete', 'Excluir', 'urbem_tributario_economico_elemento_list');
        $this->insertRoute('urbem_tributario_economico_elemento_show', 'Detalhe', 'urbem_tributario_economico_elemento_list');
        $this->insertRoute('urbem_tributario_economico_elemento_baixar', 'Baixar', 'urbem_tributario_economico_elemento_list');

//Cadastro Monetário - Agência Bancária
        $this->insertRoute('tributario_monetario_agencia_filtro', 'Cadastro Monetário - Agência Bancária', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_agencia_list', 'Cadastro Monetário - Agência Bancária', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_agencia_create', 'Incluir', 'tributario_monetario_agencia_filtro');
        $this->insertRoute('urbem_tributario_monetario_agencia_edit', 'Alterar', 'tributario_monetario_agencia_filtro');
        $this->insertRoute('urbem_tributario_monetario_agencia_delete', 'Excluir', 'tributario_monetario_agencia_filtro');
        $this->insertRoute('urbem_tributario_monetario_agencia_show', 'Detalhe', 'tributario_monetario_agencia_filtro');

//Cadastro Monetário - Conta Corrente
        $this->insertRoute('tributario_monetario_conta_corrente_filtro', 'Cadastro Monetário - Conta-Corrente', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_conta_corrente_list', 'Cadastro Monetário - Conta-Corrente', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_conta_corrente_create', 'Incluir', 'tributario_monetario_conta_corrente_filtro');
        $this->insertRoute('urbem_tributario_monetario_conta_corrente_edit', 'Alterar', 'tributario_monetario_conta_corrente_filtro');
        $this->insertRoute('urbem_tributario_monetario_conta_corrente_delete', 'Excluir', 'tributario_monetario_conta_corrente_filtro');
        $this->insertRoute('urbem_tributario_monetario_conta_corrente_show', 'Detalhe', 'tributario_monetario_conta_corrente_filtro');

//Cadastro Econômico - Hierarquia Serviço > Vigência
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_list', 'Vigência', 'tributario');
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_create', 'Incluir', 'urbem_tributario_economico_vigencia_servico_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_edit', 'Alterar', 'urbem_tributario_economico_vigencia_servico_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_delete', 'Excluir', 'urbem_tributario_economico_vigencia_servico_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_servico_show', 'Detalhe', 'urbem_tributario_economico_vigencia_servico_list');

//Cadastro Imobiliário - Trecho
        $this->insertRoute('urbem_tributario_imobiliario_trecho_list', 'Cadastro Imobiliário - Trecho', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_create', 'Incluir', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_edit', 'Alterar', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_delete', 'Excluir', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_show', 'Detalhe', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_baixar', 'Baixar', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_reativar', 'Reativar', 'urbem_tributario_imobiliario_trecho_list');
        $this->insertRoute('urbem_tributario_imobiliario_trecho_caracteristicas', 'Alterar Características', 'urbem_tributario_imobiliario_trecho_list');

//Cadastro Monetário - Carteira
        $this->insertRoute('urbem_tributario_monetario_carteira_list', 'Cadastro Monetário - Carteira', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_carteira_create', 'Incluir', 'urbem_tributario_monetario_carteira_list');
        $this->insertRoute('urbem_tributario_monetario_carteira_edit', 'Alterar', 'urbem_tributario_monetario_carteira_list');
        $this->insertRoute('urbem_tributario_monetario_carteira_delete', 'Excluir', 'urbem_tributario_monetario_carteira_list');
        $this->insertRoute('urbem_tributario_monetario_carteira_show', 'Detalhe', 'urbem_tributario_monetario_carteira_list');

//Cadastro Econômico - Hierarquia Serviço > Nível
        $this->insertRoute('urbem_tributario_economico_nivel_servico_filtro', 'Cadastro Econômico - Nível', 'tributario_economico_hierarquia_servico_home');
        $this->insertRoute('urbem_tributario_economico_nivel_servico_list', 'Nível', 'urbem_tributario_economico_nivel_servico_filtro');
        $this->insertRoute('urbem_tributario_economico_nivel_servico_create', 'Incluir', 'urbem_tributario_economico_nivel_servico_list');
        $this->insertRoute('urbem_tributario_economico_nivel_servico_edit', 'Alterar', 'urbem_tributario_economico_nivel_servico_list');
        $this->insertRoute('urbem_tributario_economico_nivel_servico_delete', 'Excluir', 'urbem_tributario_economico_nivel_servico_list');
        $this->insertRoute('urbem_tributario_economico_nivel_servico_show', 'Detalhe', 'urbem_tributario_economico_nivel_servico_list');

//Cadastro Monetário - Moeda
        $this->insertRoute('urbem_tributario_monetario_moeda_list', 'Cadastro Monetário - Moeda', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_moeda_create', 'Incluir', 'tributario_monetario_moeda_list');
        $this->insertRoute('urbem_tributario_monetario_moeda_edit', 'Alterar', 'tributario_monetario_moeda_list');
        $this->insertRoute('urbem_tributario_monetario_moeda_delete', 'Excluir', 'tributario_monetario_moeda_list');
        $this->insertRoute('urbem_tributario_monetario_moeda_show', 'Detalhe', 'tributario_monetario_moeda_list');

//Cadastro Imobiliário - Face de Quadra
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_list', 'Cadastro Imobiliário - Face de Quadra', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_create', 'Incluir', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_edit', 'Alterar', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_delete', 'Excluir', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_show', 'Detalhe', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_baixar', 'Baixar', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_reativar', 'Reativar', 'urbem_tributario_imobiliario_face_quadra_list');
        $this->insertRoute('urbem_tributario_imobiliario_face_quadra_caracteristicas', 'Alterar Características', 'urbem_tributario_imobiliario_face_quadra_list');

//Cadastro Monetário - Acréscimo
        $this->insertRoute('urbem_tributario_monetario_acrescimo_list', 'Cadastro Monetário - Acréscimo', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_acrescimo_create', 'Incluir', 'tributario_monetario_acrescimo_list');
        $this->insertRoute('urbem_tributario_monetario_acrescimo_edit', 'Alterar', 'tributario_monetario_acrescimo_list');
        $this->insertRoute('urbem_tributario_monetario_acrescimo_delete', 'Excluir', 'tributario_monetario_acrescimo_list');
        $this->insertRoute('urbem_tributario_monetario_acrescimo_show', 'Detalhe', 'tributario_monetario_acrescimo_list');
        $this->insertRoute('urbem_tributario_monetario_acrescimo_formula_calculo', 'Alterar Fórmula de Cálculo', 'tributario_monetario_acrescimo_list');

//Cadastro Monetário - Convênio
        $this->insertRoute('urbem_tributario_monetario_convenio_list', 'Cadastro Monetário - Convênio', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_convenio_create', 'Incluir', 'urbem_tributario_monetario_convenio_list');
        $this->insertRoute('urbem_tributario_monetario_convenio_edit', 'Alterar', 'urbem_tributario_monetario_convenio_list');
        $this->insertRoute('urbem_tributario_monetario_convenio_delete', 'Excluir', 'urbem_tributario_monetario_convenio_list');
        $this->insertRoute('urbem_tributario_monetario_convenio_show', 'Detalhe', 'urbem_tributario_monetario_convenio_list');
        $this->insertRoute('urbem_tributario_monetario_acrescimo_definir_valor', 'Definir Valor', 'urbem_tributario_monetario_acrescimo_list');

//Cadastro Monetário - Especie
        $this->insertRoute('urbem_tributario_monetario_especie_list', 'Cadastro Monetário - Espécie', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_especie_create', 'Incluir', 'tributario_monetario_especie_list');
        $this->insertRoute('urbem_tributario_monetario_especie_edit', 'Alterar', 'tributario_monetario_especie_list');
        $this->insertRoute('urbem_tributario_monetario_especie_delete', 'Excluir', 'tributario_monetario_especie_list');
        $this->insertRoute('urbem_tributario_monetario_especie_show', 'Detalhe', 'tributario_monetario_especie_list');

//Cadastro Imobiliário - Lote Urbano/Rural
        $this->insertRoute('tributario_imobiliario_lote_home', 'Cadastro Imobiliário - Lote', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_lote_list', 'Lote Urbano/Rural', 'tributario_imobiliario_lote_home');
        $this->insertRoute('urbem_tributario_imobiliario_lote_create', 'Incluir', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_edit', 'Alterar', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_delete', 'Excluir', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_show', 'Detalhe', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_baixa_create', 'Baixar', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_reativacao_create', 'Reativar', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_caracteristicas_create', 'Alterar Características', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_desmembrar_create', 'Desmembrar', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_aglutinar_create', 'Aglutinar', 'urbem_tributario_imobiliario_lote_list');
        $this->insertRoute('urbem_tributario_imobiliario_cancelar_desmembramento_list', 'Desmembramento', 'tributario_imobiliario_lote_home');
        $this->insertRoute('urbem_tributario_imobiliario_cancelar_desmembramento_delete', 'Cancelar', 'urbem_tributario_imobiliario_cancelar_desmembramento_list');
        $this->insertRoute('urbem_tributario_imobiliario_lote_validar_create', 'Validar Lote Desmembrado', 'urbem_tributario_imobiliario_lote_list');

//Cadastro Econômico - Responsável Técnico
        $this->insertRoute('tributario_economico_responsavel_tecnico_home', 'Cadastro Econômico - Responsável Técnico', 'tributario');
        $this->insertRoute('urbem_tributario_economico_responsavel_tecnico_list', 'Responsável Técnico', 'tributario_economico_responsavel_tecnico_home');
        $this->insertRoute('urbem_tributario_economico_responsavel_tecnico_create', 'Incluir', 'urbem_tributario_economico_responsavel_tecnico_list');
        $this->insertRoute('urbem_tributario_economico_responsavel_tecnico_edit', 'Alterar', 'urbem_tributario_economico_responsavel_tecnico_list');
        $this->insertRoute('urbem_tributario_economico_responsavel_tecnico_delete', 'Excluir', 'urbem_tributario_economico_responsavel_tecnico_list');
        $this->insertRoute('urbem_tributario_economico_responsavel_tecnico_show', 'Detalhe', 'urbem_tributario_economico_responsavel_tecnico_list');

//Cadastro Econômico - Responsável Empresa
        $this->insertRoute('urbem_tributario_economico_responsavel_empresa_list', 'Responsável Empresa', 'tributario_economico_responsavel_tecnico_home');
        $this->insertRoute('urbem_tributario_economico_responsavel_empresa_create', 'Incluir', 'urbem_tributario_economico_responsavel_empresa_list');
        $this->insertRoute('urbem_tributario_economico_responsavel_empresa_edit', 'Alterar', 'urbem_tributario_economico_responsavel_empresa_list');
        $this->insertRoute('urbem_tributario_economico_responsavel_empresa_delete', 'Excluir', 'urbem_tributario_economico_responsavel_empresa_list');
        $this->insertRoute('urbem_tributario_economico_responsavel_empresa_show', 'Detalhe', 'urbem_tributario_economico_responsavel_empresa_list');

//Cadastro Econômico - Serviço
        $this->insertRoute('urbem_tributario_economico_servico_list', 'Cadastro Econômico - Serviço', 'tributario');
        $this->insertRoute('urbem_tributario_economico_servico_create', 'Incluir', 'urbem_tributario_economico_servico_list');
        $this->insertRoute('urbem_tributario_economico_servico_edit', 'Alterar', 'urbem_tributario_economico_servico_list');
        $this->insertRoute('urbem_tributario_economico_servico_delete', 'Excluir', 'urbem_tributario_economico_servico_list');
        $this->insertRoute('urbem_tributario_economico_servico_show', 'Detalhe', 'urbem_tributario_economico_servico_list');
        $this->insertRoute('urbem_tributario_economico_servico_aliquota', '  Alterar Alíquota', 'urbem_tributario_economico_servico_list');

//Arrecadação - Grupo de Créditos
        $this->insertRoute('tributario_arrecadacao_grupo_credito_home', 'Arrecadação - Grupo de Créditos', 'tributario');
        $this->insertRoute('urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_list', 'Agrupar Créditos', 'tributario_arrecadacao_grupo_credito_home');
        $this->insertRoute('urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_create', 'Incluir', 'urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_list');
        $this->insertRoute('urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_edit', 'Alterar', 'urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_list');
        $this->insertRoute('urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_delete', 'Excluir', 'urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_list');
        $this->insertRoute('urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_show', 'Detalhe', 'urbem_tributario_arrecadacao_grupo_credito_agrupar_credito_list');
        $this->insertRoute('urbem_tributario_arrecadacao_grupo_credito_definir_permissao_create', 'Definir Permissões', 'tributario_arrecadacao_grupo_credito_home');

//Cadastro Monetário - Crédito
        $this->insertRoute('urbem_tributario_monetario_credito_list', 'Cadastro Monetário - Crédito', 'tributario');
        $this->insertRoute('urbem_tributario_monetario_credito_create', 'Incluir', 'urbem_tributario_monetario_credito_list');
        $this->insertRoute('urbem_tributario_monetario_credito_edit', 'Alterar', 'urbem_tributario_monetario_credito_list');
        $this->insertRoute('urbem_tributario_monetario_credito_delete', 'Excluir', 'urbem_tributario_monetario_credito_list');
        $this->insertRoute('urbem_tributario_monetario_credito_show', 'Detalhe', 'urbem_tributario_monetario_credito_list');

//Cadastro Econômico - Atividade Econômica
        $this->insertRoute('urbem_tributario_economico_atividade_economica_list', 'Cadastro Econômico - Atividade Econômica', 'tributario');
        $this->insertRoute('urbem_tributario_economico_atividade_economica_create', 'Incluir', 'urbem_tributario_economico_atividade_economica_list');
        $this->insertRoute('urbem_tributario_economico_atividade_economica_edit', 'Alterar', 'urbem_tributario_economico_atividade_economica_list');
        $this->insertRoute('urbem_tributario_economico_atividade_economica_delete', 'Excluir', 'urbem_tributario_economico_atividade_economica_list');
        $this->insertRoute('urbem_tributario_economico_atividade_economica_show', 'Detalhe', 'urbem_tributario_economico_atividade_economica_list');

//Cadastro Imobiliário - Tipo Edificação
        $this->insertRoute('urbem_tributario_imobiliario_tipo_edificacao_list', 'Cadastro Imobiliário - Tipo de Edificação', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_tipo_edificacao_create', 'Incluir', 'urbem_tributario_imobiliario_tipo_edificacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_tipo_edificacao_edit', 'Alterar', 'urbem_tributario_imobiliario_tipo_edificacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_tipo_edificacao_delete', 'Excluir', 'urbem_tributario_imobiliario_tipo_edificacao_list');
        $this->insertRoute('urbem_tributario_imobiliario_tipo_edificacao_show', 'Detalhe', 'urbem_tributario_imobiliario_tipo_edificacao_list');

//Configurar Inscrição
        $this->insertRoute('tributario_divida_ativa_configuracao_configurar_inscricao_create', 'Configurar Inscrição', 'tributario_divida_ativa_configuracao_home');

//Configuração Remissão Automática
        $this->insertRoute('tributario_divida_ativa_configuracao_configurar_remissao_automatica_create', 'Configuração Remissão Automática', 'tributario_divida_ativa_configuracao_home');

//Configurar Documentos
        $this->insertRoute('tributario_divida_ativa_configuracao_configurar_documentos_create', 'Configurar Documentos', 'tributario_divida_ativa_configuracao_home');

//Cadastro Econômico - Vigência Atividade
        $this->insertRoute('tributario_economico_hierarquia_atividade_home', 'Cadastro Econômico - Hierarquia de Atividade', 'tributario');
        $this->insertRoute('urbem_tributario_economico_vigencia_atividade_list', 'Vigência', 'tributario_economico_hierarquia_atividade_home');
        $this->insertRoute('urbem_tributario_economico_vigencia_atividade_create', 'Incluir', 'urbem_tributario_economico_vigencia_atividade_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_atividade_edit', 'Alterar', 'urbem_tributario_economico_vigencia_atividade_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_atividade_delete', 'Excluir', 'urbem_tributario_economico_vigencia_atividade_list');
        $this->insertRoute('urbem_tributario_economico_vigencia_atividade_show', 'Detalhe', 'urbem_tributario_economico_vigencia_atividade_list');

//Cadastro Econômico - Nível Atividade
        $this->insertRoute('tributario_economico_hierarquia_atividade_nivel_filtro', 'Nível', 'tributario_economico_hierarquia_atividade_home');
        $this->insertRoute('urbem_tributario_economico_nivel_atividade_list', 'Nível', 'tributario_economico_hierarquia_atividade_home');
        $this->insertRoute('urbem_tributario_economico_nivel_atividade_create', 'Incluir', 'urbem_tributario_economico_nivel_atividade_list');
        $this->insertRoute('urbem_tributario_economico_nivel_atividade_edit', 'Alterar', 'urbem_tributario_economico_nivel_atividade_list');
        $this->insertRoute('urbem_tributario_economico_nivel_atividade_delete', 'Excluir', 'urbem_tributario_economico_nivel_atividade_list');
        $this->insertRoute('urbem_tributario_economico_nivel_atividade_show', 'Detalhe', 'urbem_tributario_economico_nivel_atividade_list');

//Cadastro Econômico - Tipo de Licença Diversa
        $this->insertRoute('urbem_tributario_economico_tipo_licenca_list', 'Cadastro Econômico - Tipo de Licença Diversa', 'tributario');
        $this->insertRoute('urbem_tributario_economico_tipo_licenca_create', 'Incluir', 'urbem_tributario_economico_tipo_licenca_list');
        $this->insertRoute('urbem_tributario_economico_tipo_licenca_edit', 'Alterar', 'urbem_tributario_economico_tipo_licenca_list');
        $this->insertRoute('urbem_tributario_economico_tipo_licenca_delete', 'Excluir', 'urbem_tributario_economico_tipo_licenca_list');
        $this->insertRoute('urbem_tributario_economico_tipo_licenca_show', 'Detalhe', 'urbem_tributario_economico_tipo_licenca_list');

//Divida ativa - Autoridade
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_list', 'Dívida Ativa - Autoridade', 'tributario');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_create', 'Incluir Autoridade', 'urbem_tributario_divida_ativa_autoridade_list');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_edit', 'Alterar Autoridade', 'urbem_tributario_divida_ativa_autoridade_list');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_delete', 'Excluir Autoridade', 'urbem_tributario_divida_ativa_autoridade_list');
        $this->insertRoute('urbem_tributario_divida_ativa_autoridade_show', 'Autoridade', 'urbem_tributario_divida_ativa_autoridade_list');

//Arrecadação - Calendário Fiscal
        $this->insertRoute('tributario_arrecadacao_calendario_fiscal_home', 'Arrecadação - Calendário Fiscal', 'tributario');
        $this->insertRoute('urbem_tributario_arrecadacao_calendario_fiscal_calendario_list', 'Definir Calendário', 'tributario_arrecadacao_calendario_fiscal_home');
        $this->insertRoute('urbem_tributario_arrecadacao_calendario_fiscal_calendario_create', 'Incluir', 'urbem_tributario_arrecadacao_calendario_fiscal_calendario_list');
        $this->insertRoute('urbem_tributario_arrecadacao_calendario_fiscal_calendario_edit', 'Alterar', 'urbem_tributario_arrecadacao_calendario_fiscal_calendario_list');
        $this->insertRoute('urbem_tributario_arrecadacao_calendario_fiscal_calendario_delete', 'Excluir', 'urbem_tributario_arrecadacao_calendario_fiscal_calendario_list');
        $this->insertRoute('urbem_tributario_arrecadacao_calendario_fiscal_calendario_show', 'Detalhe', 'urbem_tributario_arrecadacao_calendario_fiscal_calendario_list');

//Arrecadação - Definir Calendário
        $this->insertRoute('urbem_tributario_arrecadacao_calendario_fiscal_definir_vencimentos_list', 'Definir Vencimentos', 'tributario_arrecadacao_calendario_fiscal_home');
        $this->insertRoute('urbem_tributario_arrecadacao_calendario_fiscal_definir_vencimentos_edit', 'Alterar', 'urbem_tributario_arrecadacao_calendario_fiscal_definir_vencimentos_list');

//Cadastro Imobiliário - Natureza de Transferência
        $this->insertRoute('urbem_tributario_imobiliario_natureza_transferencia_list', 'Cadastro Imobiliário - Natureza de Transferência', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_natureza_transferencia_create', 'Incluir', 'urbem_tributario_imobiliario_natureza_transferencia_list');
        $this->insertRoute('urbem_tributario_imobiliario_natureza_transferencia_edit', 'Alterar', 'urbem_tributario_imobiliario_natureza_transferencia_list');
        $this->insertRoute('urbem_tributario_imobiliario_natureza_transferencia_delete', 'Excluir', 'urbem_tributario_imobiliario_natureza_transferencia_list');
        $this->insertRoute('urbem_tributario_imobiliario_natureza_transferencia_show', 'Detalhe', 'urbem_tributario_imobiliario_natureza_transferencia_list');

//Cadastro Imobiliário - Imóvel
        $this->insertRoute('urbem_tributario_imobiliario_imovel_list', 'Cadastro Imobiliário - Imóvel', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_imovel_create', 'Incluir', 'urbem_tributario_imobiliario_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_imovel_edit', 'Alterar', 'urbem_tributario_imobiliario_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_imovel_delete', 'Excluir', 'urbem_tributario_imobiliario_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_imovel_show', 'Detalhe', 'urbem_tributario_imobiliario_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_imovel_baixa_create', 'Baixar', 'urbem_tributario_imobiliario_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_imovel_reativacao_create', 'Reativar', 'urbem_tributario_imobiliario_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_imovel_caracteristicas_create', 'Alterar Características', 'urbem_tributario_imobiliario_imovel_list');
        $this->insertRoute('urbem_tributario_imobiliario_imovel_fotos_create', 'Incluir Imagem', 'urbem_tributario_imobiliario_imovel_list');

//Arrecadação - Tipo de Suspensão
        $this->insertRoute('urbem_tributario_arrecadacao_tipo_suspensao_list', 'Arrecadação - Tipo de Suspensão', 'tributario');
        $this->insertRoute('urbem_tributario_arrecadacao_tipo_suspensao_create', 'Incluir', 'urbem_tributario_arrecadacao_tipo_suspensao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_tipo_suspensao_edit', 'Alterar', 'urbem_tributario_arrecadacao_tipo_suspensao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_tipo_suspensao_delete', 'Excluir', 'urbem_tributario_arrecadacao_tipo_suspensao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_tipo_suspensao_show', 'Detalhe', 'urbem_tributario_arrecadacao_tipo_suspensao_list');

//Arrecadação - Tabela de Conversão
        $this->insertRoute('tributario_arrecadacao_conversao_valores_home', 'Arrecadação - Conversão de Valores', 'tributario');
        $this->insertRoute('urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_list', 'Tabela de Conversão', 'tributario_arrecadacao_conversao_valores_home');
        $this->insertRoute('urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_create', 'Incluir', 'urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_edit', 'Alterar', 'urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_delete', 'Excluir', 'urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_show', 'Detalhe', 'urbem_tributario_arrecadacao_conversao_valores_tabela_conversao_list');
        $this->insertRoute('tributario_arrecadacao_conversao_valores_recadastrar_tabela_conversao', 'Recadastrar Tabela de Conversão', 'tributario_arrecadacao_conversao_valores_home');

//Cadastro Econômico - Empresa Fato
        $this->insertRoute('tributario_economico_cadastro_economico_home', 'Cadastro Econômico - Inscrição Econômica', 'tributario');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_fato_list', 'Empresa Fato', 'tributario_economico_cadastro_economico_home');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_fato_create', 'Incluir', 'urbem_tributario_economico_cadastro_economico_empresa_fato_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_fato_edit', 'Alterar', 'urbem_tributario_economico_cadastro_economico_empresa_fato_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_fato_delete', 'Excluir', 'urbem_tributario_economico_cadastro_economico_empresa_fato_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_fato_show', 'Detalhe', 'urbem_tributario_economico_cadastro_economico_empresa_fato_list');

//Cadastro Econômico - Autônomo
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_autonomo_list', 'Autônomo', 'tributario_economico_cadastro_economico_home');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_autonomo_create', 'Incluir', 'urbem_tributario_economico_cadastro_economico_autonomo_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_autonomo_edit', 'Alterar', 'urbem_tributario_economico_cadastro_economico_autonomo_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_autonomo_delete', 'Excluir', 'urbem_tributario_economico_cadastro_economico_autonomo_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_autonomo_show', 'Detalhe', 'urbem_tributario_economico_cadastro_economico_autonomo_list');

//Cadastro Imobiliário - Corretagem
        $this->insertRoute('tributario_imobiliario_corretagem_filtro', 'Cadastro Imobiliário - Corretagem', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_corretor_list', 'Cadastro Imobiliário - Corretor', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_corretor_create', 'Incluir', 'urbem_tributario_imobiliario_corretor_list');
        $this->insertRoute('urbem_tributario_imobiliario_corretor_edit', 'Alterar', 'urbem_tributario_imobiliario_corretor_list');
        $this->insertRoute('urbem_tributario_imobiliario_corretor_delete', 'Excluir', 'urbem_tributario_imobiliario_corretor_list');
        $this->insertRoute('urbem_tributario_imobiliario_corretor_show', 'Detalhe', 'urbem_tributario_imobiliario_corretor_list');
        $this->insertRoute('urbem_tributario_imobiliario_imobiliaria_list', 'Cadastro Imobiliário - Imobiliária', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_imobiliaria_create', 'Incluir', 'urbem_tributario_imobiliario_imobiliaria_list');
        $this->insertRoute('urbem_tributario_imobiliario_imobiliaria_edit', 'Alterar', 'urbem_tributario_imobiliario_imobiliaria_list');
        $this->insertRoute('urbem_tributario_imobiliario_imobiliaria_delete', 'Excluir', 'urbem_tributario_imobiliario_imobiliaria_list');
        $this->insertRoute('urbem_tributario_imobiliario_imobiliaria_show', 'Detalhe', 'urbem_tributario_imobiliario_imobiliaria_list');

//Arrecadação - Definir Desoneração
        $this->insertRoute('tributario_arrecadacao_desoneracao_home', 'Arrecadação - Desoneração', 'tributario');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list', 'Definir Desoneração', 'tributario_arrecadacao_desoneracao_home');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_create', 'Incluir', 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_edit', 'Alterar', 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_delete', 'Excluir', 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_show', 'Detalhe', 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao_list');

//Arrecadação - Conceder Desoneração
        $this->insertRoute('tributario_arrecadacao_conceder_desoneracao_filtro', 'Conceder Desoneração - Filtro', 'tributario_arrecadacao_desoneracao_home');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_create', 'Conceder', 'tributario_arrecadacao_conceder_desoneracao_filtro');
        $this->insertRoute('urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_grupo_create', 'Conceder', 'tributario_arrecadacao_conceder_desoneracao_filtro');

//Cadastro Imobiliário - Condomínio
        $this->insertRoute('urbem_tributario_imobiliario_condominio_list', 'Cadastro Imobiliário - Condomínio', 'tributario');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_create', 'Incluir', 'urbem_tributario_imobiliario_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_edit', 'Alterar', 'urbem_tributario_imobiliario_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_delete', 'Excluir', 'urbem_tributario_imobiliario_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_show', 'Detalhe', 'urbem_tributario_imobiliario_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_reforma_create', 'Incluir Reforma', 'urbem_tributario_imobiliario_condominio_list');
        $this->insertRoute('urbem_tributario_imobiliario_condominio_caracteristicas_create', 'Alterar Características', 'urbem_tributario_imobiliario_condominio_list');

//Cadastro Econômico - Empresa Direito
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_direito_list', 'Empresa Direito', 'tributario_economico_cadastro_economico_home');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_direito_create', 'Incluir', 'urbem_tributario_economico_cadastro_economico_empresa_direito_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_direito_edit', 'Alterar', 'urbem_tributario_economico_cadastro_economico_empresa_direito_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_direito_delete', 'Excluir', 'urbem_tributario_economico_cadastro_economico_empresa_direito_list');
        $this->insertRoute('urbem_tributario_economico_cadastro_economico_empresa_direito_show', 'Detalhe', 'urbem_tributario_economico_cadastro_economico_empresa_direito_list');

//Cadastro Econômico - Baixar
        $this->insertRoute('urbem_tributario_economico_baixa_cadastro_economico_create', 'Baixar', 'tributario_economico_cadastro_economico_home');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
