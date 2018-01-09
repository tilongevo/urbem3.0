# features/recursosHumanos/pessoal/gestao.feature
Feature: Homepage RecursosHumanos>Pessoal>Assentamento
  In order to Homepage Pessoal>Assentamento
  I would be able to access the urbem

  Scenario: Successfull access
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/gestao"
    Then I should see text matching "Configurar Assentamento"
