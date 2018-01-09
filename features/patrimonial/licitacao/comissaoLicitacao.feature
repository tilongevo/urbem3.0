# features/patrimonial/licitacao/comissaoLicitacao.feature
Feature: Homepage Patrimonial>Licitacao>ComissaoLicitacao
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando e licitacoes
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/licitacao/comissao/list"
    Then I should see text matching "Finalidade"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/licitacao/comissao/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "sucesso"

  Scenario: Incluindo comissao de licitacao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/licitacao/comissao/create"
    Then I should see text matching "Finalidade"
    And I fill field with uniqueId as "codTipoComissao" with "2"
    And I fill field with uniqueId as "codNorma" with "304"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando ecomissao de licitacao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/licitacao/comissao/list"
    And I fill in "filter_codTipoComissao_value" with "2"
    And I press "search"
    And I follow "Editar"
    And I fill field with uniqueId as "codNorma" with "32"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete entidade intermediadora
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/licitacao/comissao/list"
    And I fill in "filter_codTipoComissao_value" with "2"
    And I press "search"
    And I follow "Excluir"
    And I should see text matching "remover"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"
