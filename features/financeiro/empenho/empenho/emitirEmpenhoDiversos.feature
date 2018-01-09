# features/financeiro/empenho/empenho/emitirEmpenhoDiversos.feature
Feature: Emitir Empenho Diversos
    In order to Emitir Empenho Diversos
    I would be able to access the urbem

    Scenario: Acesso ao formulário
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/empenho/emitir-empenho-diversos/create"
        And I fill field with uniqueId as "codEntidade" with "2" when field is "select"
        And I fill field with uniqueId as "dtEmpenho" with "20/10/2016" when field is "input"
        And I fill field with uniqueId as "codCategoria" with "2" when field is "select"
        And I fill field with uniqueId as "descricao" with "Evidentemente, a consulta aos diversos militantes agrega valor ao estabelecimento do sistema de participação geral." when field is "input"
        And I fill field with uniqueId as "codTipo" with "2" when field is "select"
        And I fill field with uniqueId as "dtValidadeFinal" with "31/12/2016" when field is "input"
        And I fill field with uniqueId as "codHistorico" with "1" when field is "select"
        And I fill field with uniqueId as "Atributo_18_1" with "7" when field is "select"
        And I fill field with uniqueId as "Atributo_16_1" with "12" when field is "select"
