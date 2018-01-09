# features/financeiro/contabilidade/encerramento/encerramento.feature

Feature: Homepage Encerramento
  In order to Homepage Encerramento
  I would be able to access the urbem
  
  Scenario: Acessar a home de encerramento com sucesso
    Given I am authenticated as "suporte" with "123"
    Given I am on "/financeiro/contabilidade/encerramento/home"
    Then I should see text matching "Encerramento"

  Scenario: Acessar o formulário de anular restos a pagar com sucesso
    Given I am authenticated as "suporte" with "123"
    Given I am on "/financeiro/contabilidade/encerramento/anular-restos-a-pagar"
    And I select "1" from "form_entidade"
    And I press "btn_update_and_list"
    Then I should see text matching "Anulação de restos a pagar concluído com sucesso."
