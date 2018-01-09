# features/patrimonial/compras/fornecedorSocios.feature
Feature: Homepage Patrimonial>Compras>Fornecedor>Perfil>Socios
  In order to Homepage Patrimonial>Compras>Fornecedor>Perfil>Socios
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Fornecedor to be used during this test
    Given I am on "/patrimonial/compras/fornecedor/create"
    And I fill field with uniqueId as "cgmFornecedor" with "6494" when field is "inputByName"
    And I fill field with uniqueId as "vlMinimoNf" with "150" when field is "input"
    And I fill field with uniqueId as "ativo" with "checkField" when field is "checkbox"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Add a new Socio with success
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Perfil"
    And I follow "addSocio"
    And I fill field with uniqueId as "cgmSocio" with "2489" when field is "inputByName"
    And I fill field with uniqueId as "codTipo" with "Representante legal" when field is "select"
    And I fill field with uniqueId as "ativo" with "checkField" when field is "checkbox"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Edit Socio with success
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Perfil"
    And I follow "editSocio"
    And I fill field with uniqueId as "cgmSocio" with "6816" when field is "inputByName"
    And I fill field with uniqueId as "codTipo" with "Demais membros do quadro societário" when field is "select"
    And I fill field with uniqueId as "ativo" with "uncheckField" when field is "checkbox"
    And I press "Salvar"
    Then I should see "atualizado com sucesso"

  Scenario: Delete a Socio with success
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Perfil"
    And I follow "delete"
    And I press "Sim, remover"
    Then I should see "removido com sucesso"

  Scenario: Remove created data during this feature test
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "removido com sucesso"
