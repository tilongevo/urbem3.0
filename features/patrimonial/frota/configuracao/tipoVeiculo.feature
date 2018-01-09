# features/patrimonial/frota/configuracao/tipoVeiculo.feature
Feature: Homepage Patrimonial>Frota>Configuracao/Tipo Veiculo
  In order to Homepage Patrimonial>Frota>Configuracao>Tipo Veiculo
  I would be able to access the urbem

  Scenario: Create a new Modelo with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/tipo-veiculo/create"
    And I fill field with uniqueId as "nomTipo" with "" when field is "input"
    And I press "btn_create_and_list"
    Then I should not see "criado com sucesso"

  Scenario: Create a new Tipo Veiculo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/tipo-veiculo/create"
    And I fill field with uniqueId as "nomTipo" with "Boia Salva Vidas" when field is "input"
    And I fill field with uniqueId as "placa" with "checkField" when field is "checkbox"
    And I fill field with uniqueId as "codPrefixo" with "checkField" when field is "checkbox"
    And I fill field with uniqueId as "controlarHorasTrabalhadas" with "checkField" when field is "checkbox"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Edit a Tipo Veiculo with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/tipo-veiculo/list"
    And I search by "Boia Salva Vidas" in "filter_nomTipo_value" and follow to "edit"
    And I fill field with uniqueId as "nomTipo" with "" when field is "input"
    And I press "Salvar"
    Then I should not see "O item foi atualizado com sucesso."

  Scenario: Edit a Tipo Veiculo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/tipo-veiculo/list"
    And I search by "Boia Salva Vidas" in "filter_nomTipo_value" and follow to "edit"
    And I fill field with uniqueId as "nomTipo" with "Carrinho de rolima" when field is "input"
    And I fill field with uniqueId as "placa" with "uncheckField" when field is "checkbox"
    And I fill field with uniqueId as "codPrefixo" with "uncheckField" when field is "checkbox"
    And I fill field with uniqueId as "controlarHorasTrabalhadas" with "uncheckField" when field is "checkbox"
    And I press "Salvar"
    Then I should see "O item foi atualizado com sucesso."

  Scenario: Delete a Tipo Veiculo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/tipo-veiculo/list"
    And I search by "Carrinho de rolima" in "filter_nomTipo_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso."
