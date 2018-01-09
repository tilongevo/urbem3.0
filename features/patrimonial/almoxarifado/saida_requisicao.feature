# features/patrimonial/almoxarifado/saida_requisicao.feature
Feature: Homepage Patrimonial > Almoxarifado > Requisicao
  In order to Homepage Patrimonial > Almoxarifado > Requisicao
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create data to be used during this test
    Given I am on "/administrativo/cgm_pessoa_fisica/create"
      And I fill field with uniqueId as "numcgm__nomCgm" with "BEHAT PESSOA FISICA" when field is "input"
      And I fill field with uniqueId as "cpf" with "38976585845" when field is "input"
      And I fill field with uniqueId as "rg" with "4803500594" when field is "input"
      And I fill field with uniqueId as "orgao_emissor" with "SSP" when field is "input"
      And I fill field with uniqueId as "cod_uf_orgao_emissor" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "cod_nacionalidade" with "Brasileira" when field is "select"
      And I fill field with uniqueId as "cod_escolaridade" with "Superior" when field is "select"
      And I fill field with uniqueId as "numcgm__codPais" with "Brasil" when field is "select"
      And I fill field with uniqueId as "numcgm__codUf" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "numcgm__codMunicipio" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "numcgm__logradouro" with "R França Pinto" when field is "input"
      And I fill field with uniqueId as "numcgm__numero" with "1361" when field is "input"
      And I fill field with uniqueId as "numcgm__bairro" with "Vila Mariana" when field is "input"
      And I fill field with uniqueId as "numcgm__cep" with "04016035" when field is "input"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

    #  Cadastrar CGM Pessoa Juridica
    Given I am on "/administrativo/cgm_pessoa_juridica/create"
      And I fill field with uniqueId as "numcgm__nomCgm" with "G. P. RANGEL SERVIÇOS ESPECIALIZADOS. - EPP" when field is "input"
      And I fill field with uniqueId as "nom_fantasia" with "LONGEVO SERVICOS ESPECIALIZADOS" when field is "input"
      And I fill field with uniqueId as "cnpj" with "21271389000180" when field is "input"
      And I fill field with uniqueId as "numcgm__codPais" with "Brasil" when field is "select"
      And I fill field with uniqueId as "numcgm__codUf" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "numcgm__codMunicipio" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "numcgm__logradouro" with "R França Pinto" when field is "input"
      And I fill field with uniqueId as "numcgm__numero" with "1361" when field is "input"
      And I fill field with uniqueId as "numcgm__bairro" with "Vila Mariana" when field is "input"
      And I fill field with uniqueId as "numcgm__cep" with "04016035" when field is "input"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

    #  Cadastrar Almoxarifado
    Given I am on "/patrimonial/almoxarifado/almoxarifado/create"
      And I fill field with uniqueId as "cgmAlmoxarifado" with "LONGEVO SERVICOS ESPECIALIZADOS" when field is "select"
      And I fill field with uniqueId as "cgmResponsavel" with "BEHAT PESSOA FISICA" when field is "select"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

    #  Cadastrar Item
    Given I am on "/patrimonial/almoxarifado/catalogo-item/create"
      And I fill field with uniqueId as "codCatalogo" with "Catálogo da Prefeitura" when field is "select"
      And I fill field with uniqueId as "codClassificacao" with "AQUISIÇÃO DE MATERIAL QUIMICO" when field is "select"
      And I fill field with uniqueId as "codTipo_0" with "1" when field is "input"
      And I fill field with uniqueId as "descricao" with "BEHAT ITEM QUIMICO" when field is "input"
      And I fill field with uniqueId as "descricaoResumida" with "BEHAT ITEM QUIMICO" when field is "input"
      And I fill field with uniqueId as "codGrandeza" with "Litro(s)" when field is "select"
      And I fill field with uniqueId as "controleEstoque_estoqueMinimo" with "2,0000" when field is "input"
      And I fill field with uniqueId as "controleEstoque_pontoPedido" with "1,0000" when field is "input"
      And I fill field with uniqueId as "controleEstoque_estoqueMaximo" with "5,0000" when field is "input"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

  Scenario: Devolver um item com sucesso
    Given I am on "/patrimonial/almoxarifado/saida/requisicao/list"
      And I fill in "filter_codAlmoxarifado_value" with "2"
      And I fill in "filter_exercicio_value" with "2016"
      And I press "search"
      And I follow "Devolver"
    Then I should see "ARMA DE FOGO - EMPUNHAVEL - MEDIO PORTE - TIPO ESPINGARDA - Não Informado"
      And I fill field with uniqueId as "requisicaoItemCollection_0_quantidade" with "10" when field is "input"
      And I fill field with uniqueId as "requisicaoItemCollection_0_codContaDespesa" with "3.3.9.0.30.26.00.00.00" when field is "select"
      And I fill field with uniqueId as "requisicaoItemCollection_0_codVeiculo" with "2 - IVP-1084 / Ford / Fiesta Hatch 1.0" when field is "select"
      And I fill field with uniqueId as "requisicaoItemCollection_0_km" with "500,00" when field is "input"
      And I fill field with uniqueId as "requisicaoItemCollection_0_complemento" with "Ainda assim, existem dúvidas a respeito de como a consolidação das estruturas promove a alavancagem do sistema de participação geral." when field is "input"
    Then I press "Salvar"
      And I should see "com sucesso."

  #  Remove todos os items externos que foram cadastrados para serem usados durante o teste
  Scenario: Remove created data during this feature test
    Given I am on "/patrimonial/almoxarifado/almoxarifado/list"
      And I select "LONGEVO SERVICOS ESPECIALIZADOS" from "filter_cgmAlmoxarifado_value"
      And I select "BEHAT PESSOA FISICA" from "filter_cgmResponsavel_value"
      And I press "search"
      And I follow "Excluir"
      And I press "Sim, remover"
    Then I should see "removido com sucesso."
    Given I am on "/administrativo/cgm_pessoa_juridica/list"
      And I fill in "filter_cnpj_value" with "21271389000180"
      And I press "search"
      And I follow "Excluir"
      And I press "Sim, remover"
    Then I should see text matching "removido com sucesso."
    Given I am on "/administrativo/cgm_pessoa_fisica/list"
      And I search by "38976585845" in "filter_cpf_value" and follow to "delete"
      And I press "Sim, remover"
    Then I should see text matching "removido com sucesso."
