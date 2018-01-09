# features/recursosHumanos/concurso/concurso.feature
Feature: Homepage RecursosHumanos>Calendario
  In order to Homepage RH
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Acessando concurso desde a home
    Given I am on "/recursos-humanos"
    When I follow "Concurso"
    Then I should see text matching "Publicação"

  Scenario: Bloquear gravação sem campos obrigatórios preenchidos
    Given I am on "/recursos-humanos/concurso/create"
    And I fill field with uniqueId as "editalAbertura" with "368"
    And I fill field with uniqueId as "dtAplicacao" with "31/10/2016" when field is "input"
    And I fill field with uniqueId as "cod_norma" with "416"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo concurso
    Given I am on "/recursos-humanos/concurso/create"
    And I should see text matching "concurso"
    And I fill field with uniqueId as "editalAbertura" with "368"
    And I fill field with uniqueId as "codTipoNorma" with "3"
    And I fill field with uniqueId as "codNorma" with "541"
    And I fill field with uniqueId as "dtAplicacao" with "10/11/2016"
    And I fill field with uniqueId as "mesesValidade" with "10"
    And I fill field with uniqueId as "notaMinima" with "7"
    And I fill field with uniqueId as "cod_norma" with "416"
    And I fill field with uniqueId as "tipoProva_0" with "T"
    And I fill field with uniqueId as "avaliaTitulacao" with "1"
    And I fill field with uniqueId as "codCargo" with "82"
    And I fill field with uniqueId as "codCargo" with "13"
    And I fill field with uniqueId as "codCargo" with "20"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando concurso
    Given I am on "recursos-humanos/concurso/list"
    And I search by "368" in "filter_editalAbertura__codNorma_value" and follow to "edit"
    And I should see text matching "Concurso"
    And I fill field with uniqueId as "codCargo" with "82"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete concurso
    Given I am on "recursos-humanos/concurso/list"
    And I search by "368" in "filter_editalAbertura__codNorma_value" and follow to "delete"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido"
