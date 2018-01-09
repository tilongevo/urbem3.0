# features/patrimonial/almoxarifado/almoxarifado.feature
Feature: Homepage Patrimonial > Almoxarifado > Almoxarifado
  In order to Homepage Patrimonial > Almoxarifado > Almoxarifado
  I would be able to access the urbem

  Background:
    #  Cadastrar CGM Pessoa Fisica
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Almoxarifado with success
    Given I am on "/patrimonial/almoxarifado/almoxarifado/create"
      And I fill field with uniqueId as "cgmAlmoxarifado" with "3931 - Empresa PJ 2" when field is "select"
      And I fill field with uniqueId as "cgmResponsavel" with "2 - JOEL GHISIO" when field is "select"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

  Scenario: Show an Almoxarifado with success
    Given I am on "/patrimonial/almoxarifado/almoxarifado/list"
      And I fill in "filter_cgmAlmoxarifado_value" with "Empresa PJ 2"
      And I press "search"
      And I follow "Detalhe"
    Then I should see "JOEL GHISIO"

  Scenario: Edit an Almoxarifado with success
    Given I am on "/patrimonial/almoxarifado/almoxarifado/list"
      And I fill in "filter_cgmAlmoxarifado_value" with "Empresa PJ 2"
      And I press "search"
      And I follow "Editar"
      And I fill field with uniqueId as "cgmAlmoxarifado" with "3849 - ABASTECEDORA INTERNA DA PREFEITURA MARIANA PIMENTEL" when field is "select"
      And I press "Salvar"
    Then I should see "foi atualizado com sucesso."

  Scenario: Delete a created Almoxarifado with success
    Given I am on "/patrimonial/almoxarifado/almoxarifado/list"
      And I fill in "filter_cgmAlmoxarifado_value" with "ABASTECEDORA INTERNA DA PREFEITURA MARIANA PIMENTEL"
      And I press "search"
      And I follow "Excluir"
      And I press "Sim, remover"
    Then I should see "removido com sucesso."
