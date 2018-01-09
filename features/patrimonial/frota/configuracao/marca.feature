# features/patrimonial/frota/configuracao/marca.feature
Feature: Homepage Patrimonial>Frota>Configuracao>Marca
  In order to Homepage Patrimonial>Frota>Configuracao>Marca
  I would be able to access the urbem

  Scenario: Create a new Marca with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/marca/create"
    And I fill field with uniqueId as "nomMarca" with "Mercedes-Benz" when field is "input"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Create a new Marca with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/marca/create"
    And I fill field with uniqueId as "nomMarca" with "" when field is "input"
    And I press "btn_create_and_list"
    Then I should not see "criado com sucesso"

  Scenario: Edit a Marca with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/marca/list"
    And I search by "Mercedes-Benz" in "filter_nomMarca_value" and follow to "edit"
    And I fill field with uniqueId as "nomMarca" with "" when field is "input"
    And I press "Salvar"
    Then I should not see "O item foi atualizado com sucesso."

  Scenario: Edit a Marca with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/marca/list"
    And I search by "Mercedes-Benz" in "filter_nomMarca_value" and follow to "edit"
    And I fill field with uniqueId as "nomMarca" with "Mercedes-Benz2" when field is "input"
    And I press "Salvar"
    Then I should see "O item foi atualizado com sucesso."

  Scenario: Delete a Marca with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/marca/list"
    And I search by "Mercedes-Benz2" in "filter_nomMarca_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso."
