# ./vendor/bin/behat features/administrativo/administracao/grupos.feature
Feature: Homepage Administrativo>Administracao>Grupos
  In order to Homepage Administracao
  I would be able to access the urbem

  Scenario: Acessando e listando grupos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/administrativo/administracao/grupo/list"
    Then I should see text matching "Grupo"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/administrativo/administracao/grupo/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo grupo
    Given I am authenticated as "suporte" with "123"
    Given I am on "/administrativo/administracao/grupo/create"
    Then I should see text matching "Nome"
    And I fill field with uniqueId as "nomGrupo" with "BeHat testes"
    And I fill field with uniqueId as "descGrupo" with "Grupo de testes"
    And I fill field with uniqueId as "ativo" with "checkField" when field is "checkbox"
    And I fill field with uniqueId as "grupoUsuario" with "4"
    And  I press "btn_create_and_list"
    Then I should see text matching "com sucesso"

  Scenario: Atualizando grupo
    Given I am authenticated as "suporte" with "123"
    Given I am on "/administrativo/administracao/grupo/list"
    And I fill in "filter_nomGrupo_value" with "BeHat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "descGrupo" with "BeHat testes edit"
    And I press "btn_update_and_list"
    Then I should see text matching "com sucesso"

  Scenario: Delete grupo
    Given I am authenticated as "suporte" with "123"
    Given I am on "/administrativo/administracao/grupo/list"
    And I fill in "filter_nomGrupo_value" with "BeHat"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
