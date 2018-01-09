# features/recursosHumanos/folhaPagamento/vinculo.feature
Feature: Homepage RecursosHumanos>FolhaDePagamento>Vinculo
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando vinculos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/vinculo/list"
    Then I should see text matching "Ativo"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/vinculo/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo vinculo
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/vinculo/create"
    And I fill field with uniqueId as "descricao" with "BeHat"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando vinculo recem criado
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/vinculo/list"
    And I fill in "filter_descricao_value" with "BeHat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "descricao" with "BeHat edit"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete regime trabalhista
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/vinculo/list"
    And I fill in "filter_descricao_value" with "BeHat"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
