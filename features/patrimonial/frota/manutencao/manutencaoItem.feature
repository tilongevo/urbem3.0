# features/patrimonial/frota//manutencao/manutencaoItem.feature
Feature: Homepage Patrimonial>Frota>Manutenção Item
  In order to Homepage Patrimonial>Frota>Manutenção Item
  I would be able to access the urbem

  Scenario: Create a new Manutencao with Tipo Manutencao 'Outros' with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/manutencao/create"
    And I fill field with uniqueId as "tipoManutencao_1" with "2" when field is "input"
    And I fill field with uniqueId as "codVeiculo" with "1 - IJJ9373 - VolksWagem - Kombi" when field is "select"
    And I fill field with uniqueId as "dtManutencao" with "26/10/2016" when field is "input"
    And I fill field with uniqueId as "observacao" with "##Teste 5 - Incluir Item##" when field is "input"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Create a new Manutencao Item with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/manutencao/list"
    And I fill in "filter_observacao_value" with "##Teste 5 - Incluir Item##"
    And I press "search"
    And I follow "Detalhe"
    And I follow "incluirManutencaoItem"
    And I fill field with uniqueId as "fkFrotaItem" with "ARMA DE FOGO DE PEQUENO PORTE - REVOLVER / PISTOLA" when field is "select"
    And I fill field with uniqueId as "quantidade" with "1.5468" when field is "input"
    And I fill field with uniqueId as "valor" with "154.68" when field is "input"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Edit a Manutencao Item with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/manutencao/list"
    And I fill in "filter_observacao_value" with "##Teste 5 - Incluir Item##"
    And I press "search"
    And I follow "Detalhe"
    And I follow "manutencaoItem"
    And I fill field with uniqueId as "fkFrotaItem" with "ARMA DE FOGO - EMPUNHAVEL - MEDIO PORTE - TIPO ESPINGARDA" when field is "select"
    And I fill field with uniqueId as "quantidade" with "1.5468" when field is "input"
    And I fill field with uniqueId as "valor" with "154.68" when field is "input"
    And I press "Salvar"
    Then I should see "O item foi atualizado com sucesso."

  Scenario: Delete a Manutencao Item with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/manutencao/list"
    And I fill in "filter_observacao_value" with "##Teste 5 - Incluir Item##"
    And I press "search"
    And I follow "Detalhe"
    And I follow "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso."

  Scenario: Annulment a Manutencao with Tipo Manutencao 'Outros' with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/manutencao/list"
    And I fill in "filter_observacao_value" with "##Teste 5 - Incluir Item##"
    And I press "search"
    And I follow "Detalhe"
    And I follow "Anular Manutenção"
    And I fill field with uniqueId as "observacao" with "##Teste 3 - Incluir Item Anulação##" when field is "input"
    And I press "Salvar"
    Then I should see "Anulação Manutenção"
