# features/recursosHumanos/pessoal/aposentadoria.feature
Feature: Homepage RecursosHumanos>Pessoal>Aposentadoria
  In order to Homepage RH
  I would be able to access the urbem
  
  Scenario: Acessando e Listando eventos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/aposentadoria/list"
    Then I should see text matching "Servidor"

  Scenario: Bloquear gravação sem campos obrigatórios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/aposentadoria/create"
    And I fill field with uniqueId as "codContrato" with "1704"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo aposentadoria
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/aposentadoria/create"
    Then I should see text matching "Aposentadoria"
    And I fill field with uniqueId as "codContrato" with "1704"
    And I fill field with uniqueId as "dtRequirimento" with "26/10/2016"
    And I fill field with uniqueId as "dtConcessao" with "31/12/2016"
    And I fill field with uniqueId as "numProcessoTce" with "888"
    And I fill field with uniqueId as "codClassificacao" with "2"
    And I fill field with uniqueId as "codEnquadramento" with "3"
    And I fill field with uniqueId as "percentual" with "10"
    And I fill field with uniqueId as "dtPublicacao" with "27/10/2016"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando aposentadoria
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/aposentadoria/list"
    And I search by "1704" in "filter_full_text_value" and follow to "edit"
    Then I should see text matching "Aposentadoria"
    And I fill field with uniqueId as "numProcessoTce" with "999"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete aposentadoria
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/aposentadoria/list"
    And I search by "1704" in "filter_full_text_value" and follow to "delete"
    Then I should see text matching "1704"
    And I press "Sim, remover"
    Then I should see text matching "removido"
