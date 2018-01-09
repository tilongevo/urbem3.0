# features/recursosHumanos/beneficios/planoDeSaude/beneficiarios.feature
Feature: Homepage RecursosHumanos>Beneficios>PlanoDeSaude>Beneficiarios
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de plano de saude
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/plano-saude/"
    Then I should see text matching "Plano"

  Scenario: Acessando e Listando beneficiarios
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/beneficiario/list"
    Then I should see text matching "Desconto"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/beneficiario/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo beneficiario
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/beneficiario/create"
    Then I should see text matching "Desconto"
    And I fill field with uniqueId as "cgmBeneficiario" with "5898"
    And I fill field with uniqueId as "cgmFornecedor" with "4"
    And I fill field with uniqueId as "codModalidade" with "1"
    And I fill field with uniqueId as "codTipoConvenio" with "2"
    And I fill field with uniqueId as "codigoUsuario" with "888"
    And I fill field with uniqueId as "grauParentesco" with "4"
    And I fill field with uniqueId as "dtInicio" with "02/11/2016"
    And I fill field with uniqueId as "dtFim" with "02/11/2017"
    And I fill field with uniqueId as "valor" with "150"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando beneficiario
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/beneficiario/list"
    And I search by "Lana" in "filter_cgmBeneficiario__nomCgm_value" and follow to "edit"
    And I fill field with uniqueId as "valor" with "199"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Atualizando beneficiario
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/beneficio/beneficiario/list"
    And I search by "Lana" in "filter_cgmBeneficiario__nomCgm_value" and follow to "show"
    And I should see text matching "5898"
    And I follow "delete"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"

