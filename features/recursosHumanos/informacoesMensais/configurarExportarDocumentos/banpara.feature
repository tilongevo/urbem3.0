# ./vendor/bin/behat features/recursosHumanos/informacoesMensais/configurarExportarDocumentos/banpara.feature
Feature: Homepage RecursosHumanos>InformacoesMensais>ConfigurarExportarDocumentos
  In order to Homepage RH
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Acessando lista banpara
    Given I am on "/recursos-humanos/informacoes/configuracao/banpara/list"
    Then I should see text matching "Banpará"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am on "/recursos-humanos/informacoes/configuracao/banpara/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo configuracao banpara
    Given I am on "/recursos-humanos/informacoes/configuracao/banpara/create"
    Then I should see text matching "Vencimento"
    And I fill field with uniqueId as "vigencia" with "31/12/2016"
    And I fill field with uniqueId as "codEmpresa" with "888"
    And I fill field with uniqueId as "numOrgaoBanpara" with "777"
    And I fill field with uniqueId as "descricao" with "BeHat Teste"
    And I fill field with uniqueId as "codOrgao" with "703"
    And I fill field with uniqueId as "codLocal" with "5"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando configuracao banpara
    Given I am on "/recursos-humanos/informacoes/configuracao/banpara/list"
    And I fill in "filter_descricao_value" with "BeHat"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "descricao" with "BeHat teste edit"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete configuracao banpara
    Given I am on "/recursos-humanos/informacoes/configuracao/banpara/list"
    And I fill in "filter_descricao_value" with "BeHat"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
