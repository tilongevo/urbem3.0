# features/recursosHumanos/pessoal/cadastroInternacionalDeDoencas.feature
Feature: Homepage RecursosHumanos>Pessoal>CadastroInternacionalDeDoencas
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando e Listando eventos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/cid/list"
    Then I should see text matching "A00"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/cid/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo CID
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/cid/create"
    Then I should see text matching "Sigla"
    And I fill field with uniqueId as "sigla" with "AAA6"
    And I fill field with uniqueId as "descricao" with "BeHat teste CID"
    And I fill field with uniqueId as "fkPessoalTipoDeficiencia" with "3"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando CID
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/cid/list"
    And I search by "AAA6" in "filter_sigla_value" and follow to "edit"
    And I fill field with uniqueId as "descricao" with "BeHat edit CID"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete CID
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/cid/list"
    And I fill in "filter_sigla_value" with "AAA6"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"