# features/recursosHumanos/pessoal/configuracao.feature
Feature: Homepage RecursosHumanos>Pessoal>Configuracao
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Successfull access
    Given I am authenticated as "suporte" with "123"
    Given I am on "/administrativo/administracao/configuracao/create?id=22"
    Then I should see text matching "Contagem"

  Scenario: Atualizando configuração
    Given I am authenticated as "suporte" with "123"
    Given I am on "/administrativo/administracao/configuracao/create?id=22"
    And I should see text matching "Contagem"
    And I fill field with uniqueId as "atributo_geracao_registro" with "M" when field is "select"
    And I press "btn_create_and_list"
