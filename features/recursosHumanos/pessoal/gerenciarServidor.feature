# features/recursosHumanos/pessoal/gerenciarServidor.feature
Feature: Homepage RecursosHumanos>Pessoal>Gerenciar Servidor
  In order to Homepage RH
  I would be able to access the urbem

  Scenario: Acesso a tela principal
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/servidor/list"
    Then I should see text matching "CPF"

  Scenario: Bloquear gravação sem campos obrigatórios preenchidos
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/servidor/create"
    And I press "btn_create_and_list"
    Then I should not see text matching "criado com sucesso"

  Scenario: Incluindo servidor
    Given I am authenticated as "suporte" with "123"
    Given I am on "recursos-humanos/pessoal/servidor/create"
    Then I should see text matching "Identificação"
    And I fill field with uniqueId as "numcgm" with "6854"
    And I fill field with uniqueId as "dtNascimento" with "10/05/2012"
    And I fill field with uniqueId as "sexo" with "feminino"
    And I fill field with uniqueId as "nomePai" with "JOÃO OLIVEIRA KOWALESKI"
    And I fill field with uniqueId as "nomeMae" with "Maria OLIVEIRA KOWALESKI"
    And I fill field with uniqueId as "codEstadoCivil" with "7"
    And I fill field with uniqueId as "servidorConjuge_numcgm" with "5298"
    And I fill field with uniqueId as "codRaca" with "3"
    And I fill field with uniqueId as "servidorCid_cod_cid" with "2582"
    And I fill field with uniqueId as "servidorCid_dataLaudo" with "24/10/2016"
    And I fill field with uniqueId as "codUf" with "26"
    And I fill field with uniqueId as "codMunicipio" with "48"
    And I fill field with uniqueId as "endereco" with "Estrada EST LINHA POTREIRO GRANDE"
    And I fill field with uniqueId as "bairro" with "Potreiro Grande"
    And I fill field with uniqueId as "municipio" with "São Bento do Norte"
    And I fill field with uniqueId as "fone" with "88889999"
    And I fill field with uniqueId as "escolaridade" with "Não informado"
    And I fill field with uniqueId as "servidorPisPasep_dtPisPasep" with "12/06/2004"
    And I fill field with uniqueId as "nrTituloEleitor" with "882758620140"
    And I fill field with uniqueId as "secaoTitulo" with "888"
    And I fill field with uniqueId as "zonaTitulo" with "99"
    And I fill field with uniqueId as "servidorReservista_nrCarteiraRes" with "444555"
    And I fill field with uniqueId as "servidorReservista_catReservista" with "1"
    And I fill field with uniqueId as "servidorReservista_origemReservista" with "1"
    And  I press "btn_create_and_list"
    Then I should see text matching "criado com sucesso"

  Scenario: Atualizando servidor
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/servidor/list"
    And I search by "6854" in "filter_numcgm__numcgm_value" and follow to "edit"
    Then I should see text matching "Identificação"
    And I fill field with uniqueId as "nomeMae" with "MARIA OLIVEIRA KOWALESKI"
    And I press "btn_update_and_list"
    Then I should see text matching "atualizado com sucesso"

  Scenario: Acessando form de contrato do servidor
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/servidor/list"
    And I search by "6854" in "filter_numcgm__numcgm_value" and follow to "perfil"
    Then I should see text matching "Identificação"
    Then I follow "Contrato"
    Then I should see text matching "Contratuais"

  Scenario: Acessando form de dependentes do servidor
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/servidor/list"
    And I search by "6854" in "filter_numcgm__numcgm_value" and follow to "perfil"
    Then I should see text matching "Identificação"
    Then I follow "Dependentes"
    Then I should see text matching "Dependente"

  Scenario: Delete servidor
    Given I am authenticated as "suporte" with "123"
    Given I am on "/recursos-humanos/pessoal/servidor/list"
    And I search by "6854" in "filter_numcgm__numcgm_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see text matching "removido com sucesso"