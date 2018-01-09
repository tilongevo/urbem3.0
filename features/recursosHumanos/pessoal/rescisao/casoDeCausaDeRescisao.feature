#features/recursosHumanos/pessoal/rescisao/casoDeCausaDeRescisao.feature
Feature: Homepage RecursosHumanos>Pessoal>Recisao>CasoDeCausaDeRecisao
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acessando home de rescisao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/rescisao/"
    Then I should see text matching "Causa"

  Scenario: Acessando e Listando causas de rescisoes
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/caso-causa/list"
    Then I should see text matching "Causa"

  Scenario: Bloquear gravacao sem campos obrigatorios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/caso-causa/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo casos de causa de rescisao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/caso-causa/create"
    Then I should see text matching "Causa"
    And I fill field with uniqueId as "codCausaRescisao" with "1"
    And I fill field with uniqueId as "descricao" with "BeHat test agent"
    And I fill field with uniqueId as "codPeriodo" with "2"
    And I fill field with uniqueId as "codSubDivisao" with "3"
    And I fill field with uniqueId as "codSaqueFgts" with "888"
    And I fill field with uniqueId as "multaFgts" with "888"
    And I fill field with uniqueId as "percContSocial" with "10"
    And I fill field with uniqueId as "indenArt479" with "1"
    And I fill field with uniqueId as "pagaAvisoPrevio" with "1"
    And I fill field with uniqueId as "pagaFeriasVencida" with "1"
    And I fill field with uniqueId as "pagaFeriasProporcional" with "1"
    And I fill field with uniqueId as "incFgtsFerias" with "1"
    And I fill field with uniqueId as "incFgts13" with "1"
    And I fill field with uniqueId as "incFgtsAvisoPrevio" with "1"
    And I fill field with uniqueId as "incIrrfFerias" with "1"
    And I fill field with uniqueId as "incIrrf13" with "1"
    And I fill field with uniqueId as "incIrrfAvisoPrevio" with "1"
    And I fill field with uniqueId as "incPrevFerias" with "1"
    And I fill field with uniqueId as "incPrev13" with "1"
    And I fill field with uniqueId as "incPrevAvisoPrevio" with "1"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualuzando caso de causa de rescisao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/caso-causa/list"
    And I search by "BeHat" in "filter_descricao_value" and follow to "edit"
    Then I should see text matching "Causa"
    And I fill field with uniqueId as "descricao" with "BeHat edit ok"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Delete caso de causa de rescisao
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/causa-rescisao/caso-causa/list"
    And I search by "BeHat" in "filter_descricao_value" and follow to "delete"
    Then I should see text matching "BeHat"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"