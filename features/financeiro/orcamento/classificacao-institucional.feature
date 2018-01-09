# features/financeiro/orcamento/classificacao-institucional.feature
Feature: Classificacao Institucional
  In order to manage Entidades
  I would be able to create and edit Entidades

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Successfully create an Entidade
    Given I am on "/financeiro/orcamento/classificacao-institucional/create"
    Then I should see "Entidade"
    And I fill field with uniqueId as "numcgm" with "3931"
    And I fill field with uniqueId as "codResponsavel" with "2546"
    And I fill field with uniqueId as "codRespTecnico" with "10"
    And I fill field with uniqueId as "codUsuario" with "6"
    And I press "btn_create_and_list"
    Then I should see "Entidade"

  Scenario: Successfully edit an Entidade
    Given I am on "/financeiro/orcamento/classificacao-institucional/list"
    And I fill in "filter_numcgm__nomCgm_value" with "ELISANDRA"
    And I press "search"
    And I follow "Editar"
    And I press "btn_update_and_list"
    Then I should see text matching "com sucesso"