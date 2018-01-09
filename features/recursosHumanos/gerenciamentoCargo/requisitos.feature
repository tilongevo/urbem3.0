# features/recursosHumanos/gerenciamentoCargo/requisitos.feature
Feature: Homepage RecursosHumanos>GerenciamentoCargo>Requisitos
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando requisitos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/requisito/list"
    Then I should see text matching "TRANSPORTES"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/requisito/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo requisito
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/requisito/create"
    And I fill field with uniqueId as "descricao" with "BeHat requisito"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando requisito recem cadastrado
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/requisito/list"
    And I fill in "filter_descricao_value" with "BeHat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "descricao" with "BeHat edit"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete requisito
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/requisito/list"
    And I fill in "filter_descricao_value" with "BeHat"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
