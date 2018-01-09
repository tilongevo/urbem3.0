# ./vendor/bin/behat features/recursosHumanos/estagio/entidadeIntermediadora.feature
Feature: Homepage RecursosHumanos>Estagio>EntidadeIntermediadora
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando e Listando entidades
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/entidade-intermediadora/list"
    Then I should see text matching "Ensino"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/entidade-intermediadora/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo entidade intermediadora
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/entidade-intermediadora/create"
    Then I should see text matching "Entidade"
    And I fill field with uniqueId as "numcgm" with "5159"
    And I fill field with uniqueId as "percentualAtual" with "10"
    And I fill field with uniqueId as "cgmInstituicao" with "CAMARA MUNICIPAL DE VEREADORES"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando entidade intermediadora
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/entidade-intermediadora/list"
    And I fill in "filter_numcgm_value" with "Empresa PJ"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "percentualAtual" with "11"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete entidade intermediadora
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/entidade-intermediadora/list"
    And I fill in "filter_numcgm_value" with "Empresa PJ"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
