# features/recursosHumanos/folhaPagamento/configuracao/valoresDiversos.feature
Feature: Homepage RecursosHumanos>FolhaPagamento>Configuracao>ValoresDiversos
  In order to Homepage RecursosHumanos>FolhaPagamento>Configuracao>ValoresDiversos
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create new Valores Diversos with success
    Given I am on "/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/create"
    And I fill field with uniqueId as "codValor" with "123" when field is "input"
    And I fill field with uniqueId as "dataVigencia" with "29/11/2016" when field is "input"
    And I fill field with uniqueId as "descricao" with "teste Behat" when field is "input"
    And I fill field with uniqueId as "valor" with "9,99" when field is "input"
    Then I press "btn_create_and_list"
    And I should see "foi criado com sucesso."

  Scenario: Show Valores Diversos with success
    Given I am on "/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/list"
    And I fill in "filter_descricao_value" with "teste Behat"
    And I press "search"
    And I follow "Detalhe"
    Then I should see "teste Behat"

  Scenario: Edit Valores Diversos with success
    Given I am on "/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/list"
    And I fill in "filter_descricao_value" with "teste Behat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "codValor" with "124" when field is "input"
    And I fill field with uniqueId as "descricao" with "teste Behat alterado" when field is "input"
    And I fill field with uniqueId as "valor" with "19,99" when field is "input"
    And I press "Salvar"
    Then I should see "foi atualizado com sucesso."

  Scenario: Delete a created Almoxarifado with success
    Given I am on "/recursos-humanos/folha-pagamento/configuracao/gestao/valores-diversos/list"
    And I fill in "filter_descricao_value" with "teste Behat alterado"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "removido com sucesso."
