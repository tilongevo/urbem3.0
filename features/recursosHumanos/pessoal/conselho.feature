# features/recursosHumanos/pessoal/conselho.feature
Feature: Homepage RecursosHumanos>Pessoal>Conselho
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando conselho
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/conselho/list"
    Then I should see text matching "Sigla"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/conselho/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo conselho
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/conselho/create"
    Then I should see text matching "Sigla"
    And I fill field with uniqueId as "sigla" with "A99"
    And I fill field with uniqueId as "descricao" with "BeHat teste conselho"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando conselho
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/conselho/list"
    And I search by "A99" in "filter_sigla_value" and follow to "edit"
    And I fill field with uniqueId as "descricao" with "BeHat edit conselho"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete conselho
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/conselho/list"
    And I fill in "filter_sigla_value" with "A99"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"