# features/financeiro/empenho/empenho/emitirEmpenhoComplementar.feature
Feature: Emitir Empenho Complementar
    In order to Emitir Empenho Complementar
    I would be able to access the urbem

    Scenario: Acesso ao formulário
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/emitir-empenho-complementar/create"
        And I fill field with uniqueId as "codEntidade" with "2" when field is "select"
        And I fill field with uniqueId as "codEmpenhoInicial" with "1" when field is "input"
        And I fill field with uniqueId as "codEmpenhoFinal" with "99" when field is "input"
        And I fill field with uniqueId as "periodoInicial" with "01/01/2016" when field is "input"
        And I fill field with uniqueId as "periodoFinal" with "28/01/2016" when field is "input"
        
    Scenario: Acesso ao perfil
        Given I am authenticated as "suporte" with "123"
        And I am on "/financeiro/empenho/emitir-empenho-complementar/4~2016/show"
        And I should see "2 - PREFEITURA MUNICIPAL DE MARIANA PIMENTEL"
        And I should see "381 - CONTRATACAO POR TEMPO DETERMINADO"
        And I should see "3.1.9.0.04.01.03.00.00 - CONTRATAÇÃO POR TEMPO DETERMINADO DE PROFESSORES EFETIVOS 60% FUNDEB"
        And I should see "9999999999"
        And I should see "R$3.031,70"
    
    Scenario: Acesso ao formulário para incluir item de Empenho Complementar
        Given I am authenticated as "suporte" with "123"
        And I am on "/financeiro/empenho/item-empenho-complementar/create?pre_empenho=4&exercicio=2016"
        And I fill field with uniqueId as "nomItem" with "No entanto, não podemos esquecer que a constante divulgação das informações exige a precisão e a definição de todos os recursos funcionais envolvidos." when field is "input"
        And I fill field with uniqueId as "complemento" with "Pensando mais a longo prazo, a hegemonia do ambiente político promove a alavancagem do retorno esperado a longo prazo." when field is "input"
        And I fill field with uniqueId as "codMarca" with "3" when field is "select"
        And I fill field with uniqueId as "codCentro" with "115" when field is "select"
        And I fill field with uniqueId as "quantidade" with "2" when field is "input"
        And I fill field with uniqueId as "codUnidade" with "1-7" when field is "select"
        And I fill field with uniqueId as "vlUnitario" with "15,13" when field is "input"
        
    Scenario: Acesso ao formulário de Assinatura de Empenho
        Given I am authenticated as "suporte" with "123"
        And I am on "/financeiro/empenho/empenho-assinatura/create?empenho=4&exercicio=2016"
        And I fill field with uniqueId as "numcgm" with "331" when field is "select"
