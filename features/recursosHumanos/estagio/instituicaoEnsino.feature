# ./vendor/bin/behat features/recursosHumanos/estagio/instituicaoEnsino.feature
Feature: Homepage RecursosHumanos>Estagio>InstituicaoEnsino
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando e Listando instituicoes de ensino
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/instituicao-ensino/list"
    Then I should see text matching "Ensino"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/instituicao-ensino/create"
    And I fill field with uniqueId as "numcgm" with "3849"
    And I fill field with uniqueId as "vlBolsa" with "abc"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo instituicao de ensino
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/instituicao-ensino/create"
    Then I should see text matching "Ensino"
    And I fill field with uniqueId as "numcgm" with "4"
    And I fill field with uniqueId as "codCurso" with "4"
    And I fill field with uniqueId as "codMes" with "3"
    And I fill field with uniqueId as "codMes" with "3"
    And I fill field with uniqueId as "vlBolsa" with "888"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando instituicao de ensino
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/instituicao-ensino/list"
    And I fill in "filter_codCurso_value" with "4"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "vlBolsa" with "777"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete area de conhecimento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/instituicao-ensino/list"
    And I fill in "filter_codCurso_value" with "4"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
