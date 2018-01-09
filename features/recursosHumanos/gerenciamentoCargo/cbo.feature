# features/recursosHumanos/gerenciamentoCargo/cbo.feature
Feature: Homepage Recursos Humanos>Gerenciamento de Cargo>CBO
  In order to Homepage Recursos Humanos>Gerenciamento de Cargo>CBO
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new CBO with success
    Given I am on "/recursos-humanos/cbo/create"
    And I fill field with uniqueId as "codigo" with "99" when field is "input"
    And I fill field with uniqueId as "descricao" with "teste Behat" when field is "input"
    And I fill field with uniqueId as "dtInicial" with "02/11/2016" when field is "input"
    And I fill field with uniqueId as "dtFinal" with "30/11/2016" when field is "input"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Create a new CBO with failure
    Given I am on "/recursos-humanos/cbo/create"
    And I fill field with uniqueId as "codigo" with "" when field is "input"
    And I fill field with uniqueId as "descricao" with "" when field is "input"
    And I fill field with uniqueId as "dtInicial" with "02/11/2016" when field is "input"
    And I press "btn_create_and_list"
    Then I should not see "criado com sucesso"

  Scenario: Edit CBO with failure
    Given I am on "/recursos-humanos/cbo/list"
    And I fill in "filter_descricao_value" with "teste Behat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "codigo" with "" when field is "input"
    And I fill field with uniqueId as "descricao" with "" when field is "input"
    And I press "Salvar"
    Then I should not see "atualizado com sucesso."

  Scenario: Edit CBO with success
    Given I am on "/recursos-humanos/cbo/list"
    And I fill in "filter_descricao_value" with "teste Behat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "codigo" with "101" when field is "input"
    And I fill field with uniqueId as "descricao" with "teste Behat alterado" when field is "input"
    And I fill field with uniqueId as "dtInicial" with "05/11/2016" when field is "input"
    And I press "Salvar"
    Then I should see "atualizado com sucesso."

  Scenario: Show CBO with success
    Given I am on "/recursos-humanos/cbo/list"
    And I fill in "filter_descricao_value" with "teste Behat"
    And I press "search"
    And I follow "Detalhe"
    Then I should see "teste Behat alterado"

  Scenario: Delete a CBO with success
    Given I am on "/recursos-humanos/cbo/list"
    And I fill in "filter_descricao_value" with "teste Behat"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso"
