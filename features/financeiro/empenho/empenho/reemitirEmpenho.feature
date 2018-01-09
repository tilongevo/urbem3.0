# features/financeiro/empenho/empenho/reemitirEmpenho.feature
Feature: Reemitir Empenho
    In order to Reemitir Empenho
    I would be able to access the urbem
    
    Scenario: Acesso a Lista
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/reemitir-empenho/list"
        And I select "2" from "filter_codEntidade_value"
        And I fill in "filter_codEmpenhoInicial_value" with "1"
        And I fill in "filter_codEmpenhoFinal_value" with "2"
        And I press "search"
        Then I should see "04/01/2016"
        And I should see "ADRIANO LUIZ KUBIAK"
    