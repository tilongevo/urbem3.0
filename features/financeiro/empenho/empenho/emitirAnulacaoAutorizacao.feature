Feature: Consultar Anulação Autorização Empenho
    In order to Consultar Empenho
    I would be able to access the urbem
    
    Scenario: Lista em branco
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/autorizacao/list"
        And I should see "Utilize os filtros acima para gerar a lista."
        
    Scenario: Pesquisar empenho
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/autorizacao/list"
        And I select "2" from "filter_codEntidade_value"
        Then I press "search"
        Then I should see "Desta maneira, a mobilidade dos capitais internacionais representa uma abertura para a melhoria do retorno esperado a longo prazo."
