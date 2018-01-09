# features/patrimonial/compras/fornecedorContasBancarias.feature
Feature: Homepage Patrimonial>Compras>Fornecedor>Perfil>Contas
  In order to Homepage Patrimonial>Compras>Fornecedor>Perfil>Contas
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

  Scenario: Add a new Conta with success
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Perfil"
    And I follow "addConta"
    And I fill field with uniqueId as "codBanco" with "1000" when field is "select"
    And I fill field with uniqueId as "codAgencia" with "Centro" when field is "select"
    And I fill field with uniqueId as "numConta" with "102822" when field is "select"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Edit Conta with success
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Perfil"
    And I follow "editConta"
    And I fill field with uniqueId as "codBanco" with "Caixa da Tesouraria" when field is "select"
    And I fill field with uniqueId as "codAgencia" with "2" when field is "select"
    And I fill field with uniqueId as "numConta" with "143097" when field is "select"
    And I press "Salvar"
    Then I should see "atualizada com sucesso"

  Scenario: Delete a Fornecedor with success
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
