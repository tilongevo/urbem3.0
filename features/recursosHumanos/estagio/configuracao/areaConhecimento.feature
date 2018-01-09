# features/recursosHumanos/estagio/configuracao/areaConhecimento.feature
Feature: Homepage RecursosHumanos>Estagio>Configuracao>AreaConhecimento
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de configuracoes de estagio
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/configuracoes"
    Then I should see text matching "Curso"

  Scenario: Acessando e Listando areas de conhecimento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/area-conhecimento/list"
    Then I should see text matching "Artes"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/area-conhecimento/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo area de conhecimento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/area-conhecimento/create"
    Then I should see text matching "Conhecimento"
    And I fill field with uniqueId as "descricao" with "BeHat Testes"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando area de conhecimento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/area-conhecimento/list"
    And I fill in "filter_descricao_value" with "BeHat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "descricao" with "BeHat Testes Edit OK"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Atualizando area de conhecimento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/estagio/area-conhecimento/list"
    And I fill in "filter_descricao_value" with "BeHat"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
