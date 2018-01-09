# features/login.feature
Feature: Login
  In order to login
  As a customer with valid credentials
  I would be able to access the urbem

  Scenario: Bad Credentials Login
    Given I am authenticated as "teste@teste.com.br" with "123"
    Then I should see text matching "Credenciais inválidas."

  Scenario: Successfull Login
    Given I am authenticated as "suporte" with "123"
    Then I should see text matching "Seja Bem-vindo!"