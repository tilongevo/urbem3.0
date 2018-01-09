#features/recursosHumanos/pessoal/configuracaoContrato/tipoAdmissao.feature
Feature: Homepage RecursosHumanos>Pessoal>ConfiguracaoDeContrato>TipoDeAdmissao
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de configuraçao de contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/contrato-servidor/gestao"
    Then I should see text matching "servidor"

  Scenario: Acessando e Listando admissoes
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/tipo-admissao/list"
    Then I should see text matching "anterior"

  Scenario: Bloquear gravaçao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/tipo-admissao/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo admissao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/tipo-admissao/create"
    Then I should see text matching "Tipo"
    And I fill field with uniqueId as "descricao" with "BeHat"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualuzando admissao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/tipo-admissao/list"
    And I search by "BeHat" in "filter_descricao_value" and follow to "edit"
    Then I should see text matching "Tipo"
    And I fill field with uniqueId as "descricao" with "BeHat nivel II"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete admissao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/tipo-admissao/list"
    And I search by "BeHat" in "filter_descricao_value" and follow to "delete"
    Then I should see text matching "BeHat"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"