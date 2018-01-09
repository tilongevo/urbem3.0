# features/patrimonial/frota/infracao.feature
Feature: Homepage Patrimonial>Frotas>Infracao
  In order to Homepage Patrimonial>Frotas>Infracao
  I would be able to access the urbem

  Scenario: Create a new Infracao with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/infracao/create"
    And I fill field with uniqueId as "codVeiculo" with "Kombi" when field is "select"
    And I fill field with uniqueId as "codMotorista" with "JOEL GHISIO" when field is "select"
    And I fill field with uniqueId as "autoInfracao" with "48792" when field is "input"
    And I fill field with uniqueId as "dataInfracao" with "25/10/2016" when field is "input"
    And I fill field with uniqueId as "codInfracao" with "91800" when field is "select"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Create a new Infracao with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/infracao/create"
    And I fill field with uniqueId as "codMotorista" with "" when field is "select"
    And I fill field with uniqueId as "dataInfracao" with "27/10/2016" when field is "input"
    And I press "btn_create_and_list"
    Then I should not see "criado com sucesso"

  Scenario: Edit a Modelo with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/infracao/list"
    And I search by "48792" in "filter_autoInfracao_value" and follow to "edit"
    And I fill field with uniqueId as "autoInfracao" with "" when field is "input"
    And I press "Salvar"
    Then I should not see "O item foi atualizado com sucesso."

  Scenario: Edit a Modelo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/infracao/list"
    And I search by "48792" in "filter_autoInfracao_value" and follow to "edit"
    And I fill field with uniqueId as "codVeiculo" with "Fiesta Hatch 1.0" when field is "select"
    And I fill field with uniqueId as "codMotorista" with "MARQUEL JOSE DE LIMA" when field is "select"
    And I fill field with uniqueId as "autoInfracao" with "48792" when field is "input"
    And I fill field with uniqueId as "dataInfracao" with "26/10/2016" when field is "input"
    And I fill field with uniqueId as "codInfracao" with "70481" when field is "select"
    And I press "Salvar"
    Then I should see "O item foi atualizado com sucesso."

  Scenario: Delete a Modelo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/infracao/list"
    And I search by "48792" in "filter_autoInfracao_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso."
