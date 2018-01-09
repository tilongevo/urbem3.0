# features/recursosHumanos/calendario/calendarioCadastro.feature
Feature: Homepage RecursosHumanos>Calendario>Calendario
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acesso ao calendario
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/calendario"
    Then I should see text matching "Eventos"

  Scenario: Acessando e listando cadastrados
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/calendario"
    When I follow "Evento"
    Then I should see text matching "Feriado"

  Scenario: Lançar erro ignorando campos obrigatorios
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/calendario/calendario-cadastro/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo calendario com feriados atrelados
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/calendario/calendario-cadastro/list"
    When I follow "Incluir"
    Then I should see text matching "Eventos"
    Then I fill field with uniqueId as "descricao" with "Behat calendario cadastro"
    Then I fill field with uniqueId as "codFeriado" with "1"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando calendario
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/calendario/calendario-cadastro/list"
    And I search by "Behat calendario cadastro" in "filter_descricao_value" and follow to "edit"
    Then I should see text matching "cadastro"
    And I fill field with uniqueId as "descricao" with "Behat edit calendario cadastro"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete evento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/calendario/calendario-cadastro/list"
    And I search by "Behat edit calendario cadastro" in "filter_descricao_value" and follow to "delete"
    Then I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido"
