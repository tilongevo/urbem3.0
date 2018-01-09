# features/recursosHumanos/pessoal/configuracaoContrato/categoria.feature
Feature: Homepage RecursosHumanos>Pessoal>ConfiguracaoDeContrato>Categoria
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de configuracao de contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/contrato-servidor/gestao"
    Then I should see text matching "servidor"

  Scenario: Acessando e listando tipos de contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/categoria/list"
    Then I should see text matching "avulso"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/categoria/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/categoria/create"
    Then I should see text matching "Categoria"
    And I fill field with uniqueId as "descricao" with "BeHat"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/categoria/list"
    And I search by "BeHat" in "filter_descricao_value" and follow to "edit"
    Then I should see text matching "Categoria"
    And I fill field with uniqueId as "descricao" with "BeHat contrato"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/categoria/list"
    And I search by "BeHat" in "filter_descricao_value" and follow to "delete"
    Then I should see text matching "BeHat"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
