# features/patrimonial/frota/veiculoBaixa.feature
Feature: Homepage Patrimonial>Frota>Veiculo>Veículo Baixado
  In order to Homepage Patrimonial>Frota>Veiculo>Veículo Baixado
  I would be able to access the urbem

  Scenario: Create a new Veiculo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/veiculo/create"
    And I fill field with uniqueId as "codMarca" with "VolksWagem" when field is "select"
    And I fill field with uniqueId as "codModelo" with "Motoniveladora 165 S" when field is "select"
    And I fill field with uniqueId as "codTipoVeiculo" with "Passeio" when field is "select"
    And I fill field with uniqueId as "codCombustivel" with "Diesel" when field is "select"
    And I fill field with uniqueId as "placa" with "kkk1234" when field is "input"
    And I fill field with uniqueId as "prefixo" with "abc" when field is "input"
    And I fill field with uniqueId as "chassi" with "9BG116GW04C400001" when field is "input"
    And I fill field with uniqueId as "kmInicial" with "5000" when field is "input"
    And I fill field with uniqueId as "numCertificado" with "73865132920" when field is "input"
    And I fill field with uniqueId as "anoFabricacao" with "2014" when field is "input"
    And I fill field with uniqueId as "anoModelo" with "2015" when field is "input"
    And I fill field with uniqueId as "categoria" with "Oficial" when field is "input"
    And I fill field with uniqueId as "capacidade" with "4" when field is "input"
    And I fill field with uniqueId as "potencia" with "1.50T" when field is "input"
    And I fill field with uniqueId as "cilindrada" with "061C" when field is "input"
    And I fill field with uniqueId as "numPassageiro" with "2" when field is "input"
    And I fill field with uniqueId as "capacidadeTanque" with "50" when field is "input"
    And I fill field with uniqueId as "cor" with "Azul" when field is "input"
    And I fill field with uniqueId as "dtAquisicao" with "01/01/2016" when field is "input"
    And I fill field with uniqueId as "codCategoria" with "AB" when field is "select"
    And I fill field with uniqueId as "verificado" with "checkField" when field is "checkbox"
    And I press "btn_create_and_list"
    Then I should see "criado com sucesso"

  Scenario: Baixa Veiculo with failure
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/veiculo/list"
    And I fill in "filter_placa_value" with "kkk1234"
    And I press "search"
    And I follow "Perfil"
    And I follow "Baixar Veículo"
    And I fill field with uniqueId as "dtBaixa" with "abc" when field is "input"
    And I press "Salvar"
    Then I should not see "Veículo Baixado com sucesso!"

  Scenario: Baixa Veiculo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/veiculo/list"
    And I fill in "filter_placa_value" with "kkk1234"
    And I press "search"
    And I follow "Perfil"
    And I follow "Baixar Veículo"
    And I fill field with uniqueId as "dtBaixa" with "21/10/2016" when field is "input"
    And I fill field with uniqueId as "codTipoBaixa" with "1 - Alienação" when field is "select"
    And I fill field with uniqueId as "motivo" with "Teste Behat" when field is "input"
    And I press "Salvar"
    Then I should see "Veículo Baixado com sucesso!"

  Scenario: Delete a Veículo Baixado with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/baixa-veiculo/list"
    And I search by "Teste Behat" in "filter_motivo_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "Veículo Baixa removido com sucesso!"

  Scenario: Delete a Veiculo with success
    Given I am authenticated as "suporte" with "123"
    Given I am on "/patrimonial/frota/veiculo/list"
    And I search by "kkk1234" in "filter_placa_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso"
