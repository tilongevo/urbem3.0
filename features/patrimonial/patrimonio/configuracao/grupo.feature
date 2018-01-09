# features/patrimonial/patrimonio/configuracao/grupo.feature
Feature: Homepage Patrimonial>Patrimonio>Configuracao
  In order to Homepage Patrimonial>Patrimonio>Configuracao>Grupo
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Acessando e Listando grupos cadastrados
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/patrimonio/grupo/list"
    Then I should see text matching "Natureza"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/patrimonio/grupo/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Cadastrando um grupo
    Given I am on "/patrimonial/patrimonio/grupo/create"
    And I fill field with uniqueId as "exercicio" with "2016"
    And I fill field with uniqueId as "codNatureza" with "2" when field is "select"
    And I fill field with uniqueId as "nomGrupo" with "BeHat Teste"
    And I fill field with uniqueId as "codGrupoPlano_codPlano" with "12" when field is "select"
    And I fill field with uniqueId as "codGrupoPlano_codPlanoDoacao" with "13" when field is "select"
    And I fill field with uniqueId as "codGrupoPlano_codPlanoPerdaInvoluntaria" with "14" when field is "select"
    And I fill field with uniqueId as "codGrupoPlano_codPlanoTransferencia" with "15" when field is "select"
    And I fill field with uniqueId as "codGrupoPlano_codPlanoAlienacaoGanho" with "16" when field is "select"
    And I fill field with uniqueId as "codGrupoPlano_codPlanoAlienacaoPerda" with "17" when field is "select"
    And I fill field with uniqueId as "codGrupoPlanoDepreciacao_codPlano" with "18" when field is "select"
    And I fill field with uniqueId as "depreciacao" with "10"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Atualizando grupo recem cadastrado
    Given I am on "/patrimonial/patrimonio/grupo/list"
    And I fill in "filter_nomGrupo_value" with "Behat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "nomGrupo" with "BeHat Teste edit"
    And I press "Salvar"
    Then I should see "atualizado com sucesso"

  Scenario: Delete a Atributo with success
    Given I am on "/patrimonial/patrimonio/grupo/list"
    And I fill in "filter_nomGrupo_value" with "Behat"
    And I press "search"
    And I follow "Excluir"
    And I press "Sim, remover"
    Then I should see "removido com sucesso"
