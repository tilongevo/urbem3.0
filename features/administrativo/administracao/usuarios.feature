# features/administrativo/administracao/usuarios.feature
Feature: Homepage Administrativo>Administracao>Usuarios
  In order to Administrativo>Administracao>Usuarios
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Usuario with success
    Given I am on "/administrativo/administracao/usuarios/create"
    And I fill field with uniqueId as "numcgm" with "7069" when field is "select"
    And I fill field with uniqueId as "username" with "user behat" when field is "input"
    And I fill field with uniqueId as "email" with "user@behat.com" when field is "input"
    And I fill field with uniqueId as "plainPassword" with "123456" when field is "input"
    And I fill field with uniqueId as "orgao_1" with "Prefeitura Municipal de Mariana Pimentel" when field is "select"
    And I fill field with uniqueId as "orgao_2" with "Sec. Mun. da Fazenda" when field is "select"
    And I fill field with uniqueId as "orgao_3" with "Administracao - CLT" when field is "select"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Create a new Usuario with success
    Given I am on "/administrativo/administracao/usuarios/create"
    And I press "btn_create_and_list"
    Then I should not see "criado com sucesso"

  Scenario: Edit a Usuario with success
    Given I am on "/administrativo/administracao/usuarios/list"
    And I search by "7069" in "filter_numcgm_value" and follow to "edit"
    And I fill field with uniqueId as "email" with "user@behat.com" when field is "input"
    And I fill field with uniqueId as "orgao_1" with "Prefeitura Municipal de Mariana Pimentel" when field is "select"
    And I fill field with uniqueId as "orgao_2" with "Sec. Mun. de Educacao" when field is "select"
    And I fill field with uniqueId as "orgao_3" with "Educacao - CC" when field is "select"
    And I fill field with uniqueId as "isAdmin" with "checkField" when field is "checkbox"
    And I press "Salvar"
    Then I should see "atualizado com sucesso."

  Scenario: Edit a password with failure
    Given I am on "/administrativo/administracao/usuarios/list"
    And I select "7069" from "filter_numcgm_value"
    And I press "search"
    And I follow "vpn_key"
    And I fill in "form_password_first" with ""
    And I fill in "form_password_second" with ""
    And I press "Salvar"
    Then I should see "Falha ao atualizar a senha"

  Scenario: Edit a password with success
    Given I am on "/administrativo/administracao/usuarios/list"
    And I select "7069" from "filter_numcgm_value"
    And I press "search"
    And I follow "vpn_key"
    And I fill in "form_password_first" with "654321"
    And I fill in "form_password_second" with "654321"
    And I press "Salvar"
    Then I should see "atualizada com sucesso"

  Scenario: Show a Usuario with success
    Given I am on "/administrativo/administracao/usuarios/list"
    And I select "7069" from "filter_numcgm_value"
    And I press "search"
    And I follow "Detalhe"
    Then I should see "user behat"

  Scenario: Delete a Usuario with success
    Given I am on "/administrativo/administracao/usuarios/list"
    And I search by "7069" in "filter_numcgm_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso."
