# features/patrimonial/frota/posto.feature
Feature: Homepage Patrimonial>Frota>Posto
  In order to Homepage Patrimonial>Frota>Posto
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Posto with success
    Given I am on "/patrimonial/frota/posto/create"
    And I fill field with uniqueId as "fkSwCgmPessoaJuridica" with "2329 - COMERCIAL KOBIELSKI" when field is "select"
    And I fill field with uniqueId as "interno" with "checkField" when field is "checkbox"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Show a Posto with success
    Given I am on "/patrimonial/frota/posto/list"
    And I fill in "filter_fkSwCgmPessoaJuridica_value" with "COMERCIAL KOBIELSKI"
    And I press "search"
    And I follow "Detalhe"
    Then I should see "COMERCIAL KOBIELSKI"

  Scenario: Show a Posto with success
    Given I am on "/patrimonial/frota/posto/list"
    And I fill in "filter_fkSwCgmPessoaJuridica_value" with "COMERCIAL KOBIELSKI"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "interno" with "uncheckField" when field is "checkbox"
    And I fill field with uniqueId as "ativo" with "checkField" when field is "checkbox"
    And I press "Salvar"
    Then I should see "atualizado com sucesso"

  Scenario: Delete third vehicle with success
    Given I am on "/patrimonial/frota/posto/list"
    And I fill in "filter_fkSwCgmPessoaJuridica_value" with "COMERCIAL KOBIELSKI"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso"
