# features/recursosHumanos/beneficios/linha.feature
Feature: Homepage RecursosHumanos>Beneficios>Linha
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando e Listando linhas
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/linha/list"
    Then I should see text matching "589"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/linha/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo Linha
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/linha/create"
    Then I should see text matching "Linha"
    And I fill field with uniqueId as "descricao" with "888P"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando Linha
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/linha/list"
    And I search by "888P" in "filter_descricao_value" and follow to "edit"
    And I fill field with uniqueId as "descricao" with "971C"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete Linha
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/linha/list"
    And I fill in "filter_descricao_value" with "971C"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"