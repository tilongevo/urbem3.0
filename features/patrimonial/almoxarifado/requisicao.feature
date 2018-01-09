# features/patrimonial/almoxarifado/requisicao.feature
Feature: Homepage Patrimonial > Almoxarifado > Requisicao
  In order to Homepage Patrimonial > Almoxarifado > Requisicao
  I would be able to access the urbem

  Background:
    #  Cadastrar CGM Pessoa Fisica
    Given I am authenticated as "suporte" with "123"

  Scenario: Create data to be used during this test
    Given I am on "/administrativo/cgm_pessoa_fisica/create"
      And I fill field with uniqueId as "numcgm__nomCgm" with "BEHAT PESSOA FISICA" when field is "input"
      And I fill field with uniqueId as "cpf" with "38976585845" when field is "input"
      And I fill field with uniqueId as "rg" with "4803500594" when field is "input"
      And I fill field with uniqueId as "orgao_emissor" with "SSP" when field is "input"
      And I fill field with uniqueId as "cod_uf_orgao_emissor" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "cod_nacionalidade" with "Brasileira" when field is "select"
      And I fill field with uniqueId as "cod_escolaridade" with "Superior" when field is "select"
      And I fill field with uniqueId as "numcgm__codPais" with "Brasil" when field is "select"
      And I fill field with uniqueId as "numcgm__codUf" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "numcgm__codMunicipio" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "numcgm__logradouro" with "R França Pinto" when field is "input"
      And I fill field with uniqueId as "numcgm__numero" with "1361" when field is "input"
      And I fill field with uniqueId as "numcgm__bairro" with "Vila Mariana" when field is "input"
      And I fill field with uniqueId as "numcgm__cep" with "04016035" when field is "input"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

    #  Cadastrar CGM Pessoa Juridica
    Given I am on "/administrativo/cgm_pessoa_juridica/create"
      And I fill field with uniqueId as "numcgm__nomCgm" with "G. P. RANGEL SERVIÇOS ESPECIALIZADOS. - EPP" when field is "input"
      And I fill field with uniqueId as "nom_fantasia" with "LONGEVO SERVICOS ESPECIALIZADOS" when field is "input"
      And I fill field with uniqueId as "cnpj" with "21271389000180" when field is "input"
      And I fill field with uniqueId as "numcgm__codPais" with "Brasil" when field is "select"
      And I fill field with uniqueId as "numcgm__codUf" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "numcgm__codMunicipio" with "São Paulo" when field is "select"
      And I fill field with uniqueId as "numcgm__logradouro" with "R França Pinto" when field is "input"
      And I fill field with uniqueId as "numcgm__numero" with "1361" when field is "input"
      And I fill field with uniqueId as "numcgm__bairro" with "Vila Mariana" when field is "input"
      And I fill field with uniqueId as "numcgm__cep" with "04016035" when field is "input"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

    #  Cadastrar Almoxarifado
    Given I am on "/patrimonial/almoxarifado/almoxarifado/create"
      And I fill field with uniqueId as "cgmAlmoxarifado" with "LONGEVO SERVICOS ESPECIALIZADOS" when field is "select"
      And I fill field with uniqueId as "cgmResponsavel" with "BEHAT PESSOA FISICA" when field is "select"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

  Scenario: Create a new Requisicao with success
    Given I am on "/patrimonial/almoxarifado/requisicao/create"
      And I fill field with uniqueId as "codAlmoxarifado" with "G. P. RANGEL SERVIÇOS ESPECIALIZADOS. - EPP" when field is "select"
      And I fill field with uniqueId as "cgmSolicitante" with "BEHAT PESSOA FISICA" when field is "select"
      And I fill field with uniqueId as "observacao" with "É claro que o acompanhamento das preferências de consumo assume importantes posições no estabelecimento do fluxo de informações." when field is "input"
    Then I press "btn_create_and_list"
      And I should see "foi criado com sucesso."

  Scenario: Show Requisicao profile with success
    Given I am on "/patrimonial/almoxarifado/requisicao/list"
      And I fill in "filter_exercicio_value" with "2016"
      And I select "G. P. RANGEL SERVIÇOS ESPECIALIZADOS. - EPP" from "filter_codAlmoxarifado_value"
      And I select "BEHAT PESSOA FISICA" from "filter_cgmSolicitante_value"
      And I press "search"
      And I follow "Perfil"
    Then I should see "G. P. RANGEL SERVIÇOS ESPECIALIZADOS. - EPP"
      And I should see "BEHAT PESSOA FISICA"
      And I should see "É claro que o acompanhamento das preferências de consumo assume importantes posições no estabelecimento do fluxo de informações."
  #   And I should see "Assim mesmo, a expansão dos mercados mundiais exige a precisão e a definição da gestão inovadora da qual fazemos parte."

  Scenario: Delete a created Almoxarifado with success
    Given I am on "/patrimonial/almoxarifado/requisicao/list"
      And I fill in "filter_exercicio_value" with "2016"
      And I select "G. P. RANGEL SERVIÇOS ESPECIALIZADOS. - EPP" from "filter_codAlmoxarifado_value"
      And I select "BEHAT PESSOA FISICA" from "filter_cgmSolicitante_value"
      And I press "search"
      And I press "search"
      And I follow "Excluir"
      And I press "Sim, remover"
    Then I should see "removido com sucesso."

  #  Remove todos os items externos que foram cadastrados para serem usados durante o teste
  Scenario: Remove created data during this feature test
    Given I am on "/patrimonial/almoxarifado/almoxarifado/list"
      And I select "LONGEVO SERVICOS ESPECIALIZADOS" from "filter_cgmAlmoxarifado_value"
      And I select "BEHAT PESSOA FISICA" from "filter_cgmResponsavel_value"
      And I press "search"
      And I follow "Excluir"
      And I press "Sim, remover"
    Then I should see "removido com sucesso."
    Given I am on "/administrativo/cgm_pessoa_juridica/list"
      And I fill in "filter_cnpj_value" with "21271389000180"
      And I press "search"
      And I follow "Excluir"
      And I press "Sim, remover"
    Then I should see text matching "removido com sucesso."
    Given I am on "/administrativo/cgm_pessoa_fisica/list"
      And I search by "38976585845" in "filter_cpf_value" and follow to "delete"
      And I press "Sim, remover"
    Then I should see text matching "removido com sucesso."

