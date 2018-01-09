Feature: Anular Empenho
    In order to Anular Empenho
    I would be able to access the urbem
    
    Scenario: Lista em branco
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/anular-empenho/list"
        And I should see "Utilize os filtros acima para gerar a lista."

    Scenario: Pesquisar empenho
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/anular-empenho/list"
        And I select "2" from "filter_codEntidade_value"
        Then I press "search"
        Then I should see "04/01/2016"
        And I should see "ADRIANO LUIZ KUBIAK"
