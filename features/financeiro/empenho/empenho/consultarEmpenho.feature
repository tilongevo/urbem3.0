Feature: Consultar Empenho
    In order to Consultar Empenho
    I would be able to access the urbem
    
    Scenario: Lista em branco
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/consultar-empenho/list"
        And I should see "Utilize os filtros acima para gerar a lista."
        
    Scenario: Pesquisar empenho
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/consultar-empenho/list"
        And I select "2" from "filter_codEntidade_value"
        And I fill in "filter_codEmpenhoInicial_value" with "2"
        And I fill in "filter_codEmpenhoFinal_value" with "4"
        Then I press "search"
        Then I should see "2/2016"
        And I follow "Detalhe"
        Then I should see "3.1.9.0.04.01.03.00.00 - CONTRATAÇÃO POR TEMPO DETERMINADO DE PROFESSORES EFETIVOS 60% FUNDEB"
        Then I should see "R$50.000,00"
