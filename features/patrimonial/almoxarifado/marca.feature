# features/patrimonial/almoxarifado/marca.feature
Feature: Homepage Patrimonial > Almoxarifado > Marca
  In order to Homepage Patrimonial > Almoxarifado > Marca
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Marca with success
    Given I am on "/patrimonial/almoxarifado/marca/create"
    And I fill field with uniqueId as "descricao" with "teste Behat" when field is "input"
    Then I press "btn_create_and_list"
    And I should see "foi criado com sucesso."

  Scenario: Edit a Marca with success
    Given I am on "/patrimonial/almoxarifado/marca/list"
    And I fill in "filter_descricao_value" with "teste Behat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "descricao" with "teste Behat alterado" when field is "input"
    And I press "Salvar"
    Then I should see "O item foi atualizado com sucesso"

  Scenario: Show Marca with success
    Given I am on "/patrimonial/almoxarifado/marca/list"
    And I fill in "filter_descricao_value" with "teste Behat"
    And I press "search"
    And I follow "Detalhe"
    Then I should see "teste Behat alterado"

  Scenario: Delete a Assentamento with success
    Given I am on "/patrimonial/almoxarifado/marca/list"
    And I fill in "filter_descricao_value" with "teste Behat alterado"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso"
