# features/login.feature
Feature: Homepage RecursosHumanos
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Successfull access
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos"
    Then I should see text matching "Concurso"
    Then I should see text matching "Calendário"
    Then I should see text matching "Pessoal"
    Then I should see text matching "Gerenciamento de Cargo"
    Then I should see text matching "Benefícios"
    Then I should see text matching "Folha de Pagamento"
    Then I should see text matching "Estágio"
    Then I should see text matching "Informações Mensais e An..."
    Then I should see text matching "Diárias"
