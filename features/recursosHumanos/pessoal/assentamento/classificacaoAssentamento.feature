# features/recursosHumanos/pessoal/assentamento/classificacaoAssentamento.feature
Feature: Homepage RecursosHumanos>Pessoal>Assentamento>ClassificacaoAssentamento
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando e Listando classificacoes de assentamento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/classificacao/list"
    Then I should see text matching "Tipo"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/classificacao/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo classificacoes de assentamento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/classificacao/create"
    And I fill field with uniqueId as "descricao" with "BeHat"
    And I fill field with uniqueId as "fkPessoalTipoClassificacao" with "4"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: classificacoes de assentamento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/classificacao/list"
    And I search by "behat" in "filter_descricao_value" and follow to "edit"
    And I fill field with uniqueId as "descricao" with "BeHat Edit ok"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: classificacoes de assentamento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/classificacao/list"
    And I search by "behat" in "filter_descricao_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see text matching "removido"
