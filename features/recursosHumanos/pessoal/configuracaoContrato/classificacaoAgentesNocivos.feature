#features/recursosHumanos/pessoal/configuracaoContrato/classificacaoAgentesNocivos.feature
Feature: Homepage RecursosHumanos>Pessoal>ConfiguracaoDeContrato>ClassificacaoDosAgentesNocivos
  In order to Homepage RH
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Acessando home de configuracao de contrato
    Given I am on "/recursos-humanos/pessoal/contrato-servidor/gestao"
    Then I should see text matching "servidor"

  Scenario: Acessando e Listando descricoes dos agentes nocivos
    Given I am on "/recursos-humanos/pessoal/classificacao-agentes-nocivos/list"
    Then I should see text matching "nocivo"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am on "/recursos-humanos/pessoal/classificacao-agentes-nocivos/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo agente nocivo
    Given I am on "/recursos-humanos/pessoal/classificacao-agentes-nocivos/create"
    And I should see text matching "Regime"
    And I fill field with uniqueId as "numOcorrencia" with "888"
    And I fill field with uniqueId as "fkFolhapagamentoRegimePrevidencia" with "2"
    And I fill field with uniqueId as "descricao" with "BeHat agente de testes"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando um agente nocivo cadastrado
    Given I am on "/recursos-humanos/pessoal/classificacao-agentes-nocivos/list"
    And I fill in "filter_numOcorrencia_value" with "888"
    And I press "search"
    And I follow "Editar"
    And I should see text matching "Regime"
    And I fill field with uniqueId as "descricao" with "BeHat edited ok"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete agente nocivo
    Given I am on "/recursos-humanos/pessoal/classificacao-agentes-nocivos/list"
    And I fill in "filter_numOcorrencia_value" with "888"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
