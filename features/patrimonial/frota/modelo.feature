# features/patrimonial/frota/modelo.feature
Feature: Homepage Patrimonial>Frota>Modelo
  In order to Homepage Patrimonial>Frota>Modelo
  I would be able to access the urbem

  Scenario: Create a new Modelo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/modelo/create"
    And I fill field with uniqueId as "codMarca" with "VolksWagem" when field is "select"
    And I fill field with uniqueId as "nomModelo" with "Fusca" when field is "input"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Create a new Modelo with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/modelo/create"
    And I fill field with uniqueId as "codMarca" with "" when field is "select"
    And I press "btn_create_and_list"
    Then I should not see "criado com sucesso"

  Scenario: Edit a Modelo with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/modelo/list"
    And I search by "Fusca" in "filter_nomModelo_value" and follow to "edit"
    And I fill field with uniqueId as "nomModelo" with "" when field is "input"
    And I press "Salvar"
    Then I should not see "O item foi atualizado com sucesso."

  Scenario: Edit a Modelo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/modelo/list"
    And I search by "Fusca" in "filter_nomModelo_value" and follow to "edit"
    And I fill field with uniqueId as "nomModelo" with "Brasilia" when field is "input"
    And I press "Salvar"
    Then I should see "O item foi atualizado com sucesso."

  Scenario: Delete a Modelo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/modelo/list"
    And I search by "Brasilia" in "filter_nomModelo_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso."
