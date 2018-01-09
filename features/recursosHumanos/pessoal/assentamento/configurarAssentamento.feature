# features/recursosHumanos/pessoal/assentamento/configurarAssentamento.feature
Feature: Homepage RecursosHumanos>Pessoal>Assentamento>Configurar Assentamento
  In order to Homepage Pessoal>Assentamento>Configurar Assentamento
  I would be able to access the urbem

  Scenario: Access to the main page of Configurar Assentamento
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/configuracao/list"
    Then I should see text matching "Férias"

  Scenario: Create a new Assentamento with fail
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/configuracao/create"
    And I fill field with uniqueId as "assentamentoValidade_dtInicial" with "28/10/2016" when field is "input"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Create a new Assentamento with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/configuracao/create"
    And I fill field with uniqueId as "codClassificacao" with "Férias" when field is "select"
    And I fill field with uniqueId as "descricao" with "FériasTesteBehatParaFiltro" when field is "input"
    And I fill field with uniqueId as "sigla" with "caju" when field is "input"
    And I fill field with uniqueId as "abreviacao" with "Fé" when field is "input"
    And I fill field with uniqueId as "codNorma" with "Abre Crédito Suplementar para fazer fren/DECRETO" when field is "select"
    And I fill field with uniqueId as "assentamentoSubDivisao" with "CLT/CLT Extinção" when field is "select"
    And I fill field with uniqueId as "codOperador" with "Desconsidera" when field is "select"
    And I fill field with uniqueId as "codRegimePrevidencia" with "RPP" when field is "select"
    And I fill field with uniqueId as "assentamento_codEsfera" with "Municipal" when field is "select"
    And I fill field with uniqueId as "assentamento_assentamentoInicio" with "checkField" when field is "checkbox"
    And I fill field with uniqueId as "assentamentoValidade_dtInicial" with "20/10/2016" when field is "input"
    And I fill field with uniqueId as "codMotivo" with "Alteração Lotação/Local" when field is "select"
    And I fill field with uniqueId as "quantDiasOnusEmpregador" with "15" when field is "input"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Edit a Assentamento with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/configuracao/list"
    And I search by "FériasTesteBehatParaFiltro" in "filter_descricao_value" and follow to "edit"
    And I fill field with uniqueId as "abreviacao" with "Fs" when field is "input"
    And I fill field with uniqueId as "assentamentoSubDivisao" with "CLT/CLT Extinção" when field is "select"
    And I fill field with uniqueId as "codOperador" with "Desconsidera" when field is "select"
    And I fill field with uniqueId as "assentamento_codEsfera" with "Municipal" when field is "select"
    And I fill field with uniqueId as "assentamento_assentamentoInicio" with "uncheckField" when field is "checkbox"
    And I fill field with uniqueId as "assentamentoValidade_dtInicial" with "20/06/2016" when field is "input"
    And I fill field with uniqueId as "quantDiasOnusEmpregador" with "10" when field is "input"
    And I press "Salvar"
    Then I should see "O item foi atualizado com sucesso"

  Scenario: Delete a Assentamento with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/assentamento/configuracao/list"
    And I search by "FériasTesteBehatParaFiltro" in "filter_descricao_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso"
