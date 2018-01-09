#features/recursosHumanos/pessoal/rescisao/rescisaoContrato.feature
Feature: Homepage RecursosHumanos>Pessoal>Recisao>RecisaoDeContrato
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de rescisao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/rescisao/"
    Then I should see text matching "Causa"

  Scenario: Acessando e Listando rescisoes de contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/rescisao-contrato/list"
    Then I should see text matching "Contrato"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/rescisao-contrato/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo rescisoes de contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/rescisao-contrato/create"
    Then I should see text matching "Causa"
    And I fill field with uniqueId as "codContrato" with "1704"
    And I fill field with uniqueId as "dtRescisao" with "26/10/2016"
    And I fill field with uniqueId as "codCasoCausa" with "3"
    And I fill field with uniqueId as "codNorma" with "416"
    And I fill field with uniqueId as "incFolhaSalario" with "1"
    And I fill field with uniqueId as "incFolhaDecimo" with "1"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Visualizando e Deletando rescisao de contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/rescisao-contrato/list"
    And I search by "1704" in "filter_codContrato_value" and follow to "show"
    Then I should see text matching "Contrato"
    Then I follow "delete"
    Then I should see text matching "1704"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"