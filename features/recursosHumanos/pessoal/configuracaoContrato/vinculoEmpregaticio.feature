#features/recursosHumanos/pessoal/configuracaoContrato/vinculoEmpregaticio.feature
Feature: Homepage RecursosHumanos>Pessoal>ConfiguracaoDeContrato>VinculoEmpregaticio
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de configuracao de contrato
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/contrato-servidor/gestao"
    Then I should see text matching "servidor"

  Scenario: Acessando e Listando vinculos empregaticios
    Given I am authenticated as "suporte" with "123"
    Given I am on "recursos-humanos/vinculo-empregaticio/list"
    Then I should see text matching "vinculado"

  Scenario: Bloquear gravação sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/vinculo-empregaticio/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo vinculos empregaticios
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/vinculo-empregaticio/create"
    And I should see text matching "Vinculo"
    And I fill field with uniqueId as "descricao" with "BeHat"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualuzando vinculos empregaticios
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/vinculo-empregaticio/list"
    And I search by "BeHat" in "filter_descricao_value" and follow to "edit"
    And I should see text matching "Vinculo"
    And I fill field with uniqueId as "descricao" with "BeHat nivel II"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete vinculos empregaticios
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/vinculo-empregaticio/list"
    And I search by "BeHat" in "filter_descricao_value" and follow to "delete"
    Then I should see text matching "BeHat"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
