# features/financeiro/orcamento/alteracaoOrcamentaria.feature
Feature: Inclusão em Alteração Orçamentária

    Scenario: Acessa o formulário de alteração orçamentária
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/orcamento/suplementacao/create"
        And I fill field with uniqueId as "codTipo" with "1" when field is "select"
        And I fill field with uniqueId as "entidade" with "2" when field is "select"
        And I fill field with uniqueId as "norma" with "1" when field is "select"
        And I fill field with uniqueId as "dtSuplementacao" with "01/11/2016" when field is "input"
        And I fill field with uniqueId as "valor" with "100" when field is "input"
        And I fill field with uniqueId as "motivo" with "Motivo da suplementação" when field is "input"
        And I should see text matching "Adicionar Dotações Redutoras"
        And I should see text matching "Adicionar Dotações Suplementadas"
