# features/recursosHumanos/folhaPagamento/regimePrevidencia.feature
Feature: Homepage RecursosHumanos>FolhaPagamento>RegimePrevidencia
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando regimes de previdencias
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/regime-previdencia/list"
    Then I should see text matching "Regime"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/regime-previdencia/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo regime previdenciario
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/regime-previdencia/create"
    And I fill field with uniqueId as "descricao" with "BHT"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando regime previdenciario
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/regime-previdencia/list"
    And I fill in "filter_descricao_value" with "BHT"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "descricao" with "ED"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete regime previdenciario
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/folha-pagamento/regime-previdencia/list"
    And I fill in "filter_descricao_value" with "ED"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
