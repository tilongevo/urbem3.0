#features/recursosHumanos/pessoal/rescisao/causaDeRescisao.feature
Feature: Homepage RecursosHumanos>Pessoal>Recisao>CausaDeRecisao
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de rescisao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/rescisao/"
    Then I should see text matching "Causa"

  Scenario: Acessando e Listando rescisoes
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/list"
    Then I should see text matching "Causa"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo causa de rescicao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/create"
    Then I should see text matching "Causa"
    And I fill field with uniqueId as "numCausa" with "888"
    And I fill field with uniqueId as "descricao" with "BeHat agente de testes"
    And I fill field with uniqueId as "codCaged" with "3"
    And I fill field with uniqueId as "fkPessoalCausaAfastamentoMte" with "SJ1"
    And I fill field with uniqueId as "fkPessoalMovSefipSaida" with "8"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando causa de rescisao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/list"
    And I search by "888" in "filter_numCausa_value" and follow to "edit"
    And I fill field with uniqueId as "descricao" with "BeHat edit ok"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete causa de rescisao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/list"
    And I search by "888" in "filter_numCausa_value" and follow to "delete"
    Then I should see text matching "BeHat"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
