# ./vendor/bin/behat features/recursosHumanos/diarias/configuracao.feature
Feature: Homepage RecursosHumanos>Diarias>Configuracao
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando e Listando diarias
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/diarias/tipo-diaria/list"
    Then I should see text matching "Nome"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/diarias/tipo-diaria/create"
    And I fill field with uniqueId as "vigencia" with "31/12/2016"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo diaria
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/diarias/tipo-diaria/create"
    Then I should see text matching "Nome"
    And I fill field with uniqueId as "nomTipo" with "BeHat testes"
    And I fill field with uniqueId as "codNorma" with "511"
    And I fill field with uniqueId as "valor" with "999"
    And I fill field with uniqueId as "vigencia" with "31/12/2016"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando diaria
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/diarias/tipo-diaria/list"
    And I fill in "filter_nomTipo_value" with "BeHat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "nomTipo" with "BeHat testes edit"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete diaria
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/diarias/tipo-diaria/list"
    And I fill in "filter_nomTipo_value" with "BeHat"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
