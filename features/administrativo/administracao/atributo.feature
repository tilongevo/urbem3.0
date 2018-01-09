# features/administrativo/administracao/atributo.feature
Feature: Homepage Administrativo>Administracao>Atributo
  In order to Homepage Administrativo>Administracao>Atributo
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Atributo with success
    Given I am on "/administrativo/administracao/atributo/create"
    And I fill field with uniqueId as "codGestao" with "Patrimonial" when field is "select"
    And I fill field with uniqueId as "codModulo" with "Patrimônio" when field is "select"
    And I fill field with uniqueId as "codCadastro" with "Bem" when field is "select"
    And I fill field with uniqueId as "codTipo" with "Texto" when field is "select"
    And I fill field with uniqueId as "nomAtributo" with "teste Behat" when field is "input"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Create a Atributo with failure
    Given I am on "/administrativo/administracao/atributo/create"
    And I fill field with uniqueId as "codGestao" with "Patrimonial" when field is "select"
    And I fill field with uniqueId as "codModulo" with "Patrimônio" when field is "select"
    And I fill field with uniqueId as "codCadastro" with "Bem" when field is "select"
    And I fill field with uniqueId as "codTipo" with "Texto" when field is "select"
    And I press "btn_create_and_list"
    Then I should not see "criado com sucesso"

  Scenario: Edit a Atributo with success
    Given I am on "/administrativo/administracao/atributo/list"
    And I fill in "filter_nomAtributo_value" with "teste Behat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "ajuda" with "Msg auxiliar Behat" when field is "input"
    And I press "Salvar"
    Then I should see "atualizado com sucesso"

  Scenario: Edit a Atributo with success
    Given I am on "/administrativo/administracao/atributo/list"
    And I fill in "filter_nomAtributo_value" with "teste Behat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "nomAtributo" with "" when field is "input"
    And I press "Salvar"
    Then I should not see "atualizado com sucesso"

  Scenario: Show a Atributo with success
    Given I am on "/administrativo/administracao/atributo/list"
    And I fill in "filter_nomAtributo_value" with "teste Behat"
    And I press "search"
    And I follow "Detalhe"
    Then I should see "teste Behat"

  Scenario: Delete a Atributo with success
    Given I am on "/administrativo/administracao/atributo/list"
    And I fill in "filter_nomAtributo_value" with "teste Behat"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "removido com sucesso."
