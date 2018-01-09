# features/recursosHumanos/folhaPagamento/configuracao/sequenciaCalculo.feature
Feature: Homepage Recursos Humanos > Folha Pagamento > Configuracao > Sequencia Calculo
  In order to Homepage Recursos Humanos > Folha Pagamento > Configuracao > Sequencia Calculo
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create new Sequencia de Calculo with success
    Given I am on "/recursos-humanos/folha-pagamento/sequencia-calculo/create"
    And I fill field with uniqueId as "sequencia" with "99" when field is "input"
    And I fill field with uniqueId as "descricao" with "teste Behat" when field is "input"
    And I fill field with uniqueId as "complemento" with "testando o sistema" when field is "input"
    Then I press "btn_create_and_list"
    And I should see "foi criado com sucesso."

  Scenario: Show Sequencia de Calculo with success
    Given I am on "/recursos-humanos/folha-pagamento/sequencia-calculo/list"
    And I fill in "filter_sequencia_value" with "99"
    And I press "search"
    And I follow "Detalhe"
    Then I should see "teste Behat"

  Scenario: Edit Sequencia de Calculo with success
    Given I am on "/recursos-humanos/folha-pagamento/sequencia-calculo/list"
    And I fill in "filter_sequencia_value" with "99"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "descricao" with "teste Behat alterado" when field is "input"
    And I press "Salvar"
    Then I should see "foi atualizado com sucesso."

  Scenario: Delete Sequencia de Calculo with success
    Given I am on "/recursos-humanos/folha-pagamento/sequencia-calculo/list"
    And I fill in "filter_sequencia_value" with "99"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "removido com sucesso."
