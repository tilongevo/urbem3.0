# features/patrimonial/compras/fornecedor.feature
Feature: Homepage Patrimonial>Compras>Fornecedor
  In order to Homepage Patrimonial>Compras>Fornecedor
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Fornecedor with success
    Given I am on "/patrimonial/compras/fornecedor/create"
    And I fill field with uniqueId as "cgmFornecedor" with "6494" when field is "inputByName"
    And I fill field with uniqueId as "vlMinimoNf" with "150" when field is "input"
    And I fill field with uniqueId as "ativo" with "checkField" when field is "checkbox"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Create a new Fornecedor with failure
    Given I am on "/patrimonial/compras/fornecedor/create"
    And I fill field with uniqueId as "cgmFornecedor" with "6494" when field is "inputByName"
    And I fill field with uniqueId as "vlMinimoNf" with "" when field is "input"
    And I press "btn_create_and_list"
    Then I should not see "criado com sucesso"

  Scenario: Edit Fornecedor with failure
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Perfil"
    And I follow "edit"
    And I fill field with uniqueId as "vlMinimoNf" with "abc" when field is "input"
    And I press "Salvar"
    Then I should not see "atualizado com sucesso."

  Scenario: Edit Fornecedor with success
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Perfil"
    And I follow "edit"
    And I fill field with uniqueId as "vlMinimoNf" with "200" when field is "input"
    And I fill field with uniqueId as "tipo_1" with "M" when field is "input"
    And I press "Salvar"
    Then I should see "atualizado com sucesso."

  Scenario: Show Fornecedor with success
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Detalhe"
    Then I should see "JOÃO VICTOR NUNES"

  Scenario: Delete a Fornecedor with success
    Given I am on "/patrimonial/compras/fornecedor/list"
    And I select "6494" from "filter_cgmFornecedor_value"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "removido com sucesso"
