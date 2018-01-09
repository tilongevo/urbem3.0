# features/financeiro/contabilidade/lancamentoContabil/aberturaOrcamentoAnual.feature
Feature: Homepage Financeiro>Contabilidade - Lançamento Contábil>Abertura de Orçamento Anual
  In order to Homepage Financeiro>Contabilidade - Lançamento Contábil>Abertura de Orçamento Anual
  I would be able to access the urbem

  Scenario: Access to the main page of Abertura de Orçamento Anual
    Given I am authenticated as "suporte" with "123"
    Given I am on "/financeiro/contabilidade/lancamento-contabil/abertura-orcamento-anual/"
    Then I should see text matching "Dados para Abertura de Orçamento"

  Scenario: Create a new Abertura de Orçamento Anual
    Given I am authenticated as "suporte" with "123"
    Given I am on "/financeiro/contabilidade/lancamento-contabil/abertura-orcamento-anual/"
    And I select "2" from "form_codEntidade"
    And I press "btn_update_and_list"
    Then I should see "Registros de saldos iniciais"
    And I fill in "receitaBrutaOrcadaExercicio" with "975,86"
    And I fill in "fundeb" with "560,49"
    And I fill in "renuncia" with "788,50"
    And I fill in "outrasDeducoes" with "257,23"
    And I fill in "despesaPrevistaExercicio" with "654,95"
    And I press "AberturaOrcamentoAnual"
    Then I should see "Abertura de Orçamento Anual configurada com sucesso!"
