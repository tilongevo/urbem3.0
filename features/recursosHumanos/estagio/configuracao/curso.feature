# features/recursosHumanos/estagio/configuracao/curso.feature
Feature: Homepage RecursosHumanos>Estagio>Configuracao>Curso
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de configuracoes de estagio
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/configuracoes"
    Then I should see text matching "Curso"

  Scenario: Acessando e listando relacao de cursos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/curso/list"
    Then I should see text matching "Curso"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/curso/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo curso
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/curso/create"
    Then I should see text matching "Curso"
    And I fill field with uniqueId as "nomCurso" with "BeHat Especialist"
    And I fill field with uniqueId as "fkEstagioAreaConhecimento" with "12"
    And I fill field with uniqueId as "fkEstagioGrau" with "5"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando curso
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/curso/list"
    And I fill in "filter_nomCurso_value" with "BeHat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "nomCurso" with "BeHat Especialist II"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete curso
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/curso/list"
    And I fill in "filter_nomCurso_value" with "BeHat"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
