#features/recursosHumanos/calendario/calendario.feature
Feature: Homepage RecursosHumanos>Calendario>Calendario
  In order to Homepage RH
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Successfull access
    Given I am on "/recursos-humanos/calendario"
    Then I should see text matching "Eventos"

  Scenario: Acessando e Listando eventos
    Given I am on "/recursos-humanos/calendario"
    And I follow "Eventos"
    And I fill in "filter_dtFeriado_value" with "28/10/2016"
    Then I should see text matching "Feriado"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am on "/recursos-humanos/calendario/feriado/create"
    And I fill field with uniqueId as "dtFeriado" with "31/10/2016" when field is "input"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo evento do tipo Feriado Fixo Estadual
    Given I am on "/recursos-humanos/calendario/feriado/list"
    And I follow "Incluir"
    And I should see text matching "Evento"
    And I fill field with uniqueId as "dtFeriado" with "28/10/2016"
    And I fill field with uniqueId as "descricao" with "Behat Feriado Fixo Estadual"
    And I fill field with uniqueId as "tipoferiado_0" with "F"
    And I fill field with uniqueId as "abrangencia" with "E"
    Then  I press "btn_create_and_list"

  Scenario: Atualizando evento
    Given I am on "/recursos-humanos/calendario/feriado/list"
    And I search by "Behat Feriado Fixo Estadual" in "filter_descricao_value" and follow to "edit"
    And I should see text matching "Evento"
    And I fill field with uniqueId as "descricao" with "Behat editado Feriado Fixo Estadual"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete evento
    Given I am on "/recursos-humanos/calendario/feriado/list"
    And I search by "Behat editado Feriado Fixo Estadual" in "filter_descricao_value" and follow to "delete"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido"
