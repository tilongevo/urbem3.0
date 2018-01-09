# features/patrimonial/frota/veiculoRetirar.feature
Feature: Homepage Patrimonial>Frota>Veiculo>Perfil>Retirar
  In order to Homepage Patrimonial>Frota>Veiculo>Perfil>Retirar
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Veiculo with success
    Given I am on "/patrimonial/frota/veiculo/create"
    And I fill field with uniqueId as "codMarca" with "VolksWagem" when field is "select"
    And I fill field with uniqueId as "codModelo" with "Motoniveladora 165 S" when field is "select"
    And I fill field with uniqueId as "codTipoVeiculo" with "Passeio" when field is "select"
    And I fill field with uniqueId as "codCombustivel" with "Diesel" when field is "select"
    And I fill field with uniqueId as "placa" with "ppp1234" when field is "input"
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

  Scenario: Add Retirar Veiculo with failure
    Given I am on "/patrimonial/frota/veiculo/list"
    And I fill in "filter_placa_value" with "ppp1234"
    And I press "search"
    And I follow "Perfil"
    And I follow "Retirar Veículo"
    And I fill field with uniqueId as "codMotorista" with "" when field is "select"
    And I fill field with uniqueId as "dtSaida" with "" when field is "input"
    And I fill field with uniqueId as "hrSaida" with "" when field is "input"
    And I fill field with uniqueId as "kmSaida" with "" when field is "input"
    And I fill field with uniqueId as "destino" with "" when field is "input"
    And I press "Salvar"
    Then I should not see "Retirar Veículo criado com sucesso!"

  Scenario: Add Retirar Veiculo with success
    Given I am on "/patrimonial/frota/veiculo/list"
    And I fill in "filter_placa_value" with "ppp1234"
    And I press "search"
    And I follow "Perfil"
    And I follow "Retirar Veículo"
    And I fill field with uniqueId as "codMotorista" with "2 - JOEL GHISIO" when field is "select"
    And I fill field with uniqueId as "dtSaida" with "24/10/2016" when field is "input"
    And I fill field with uniqueId as "hrSaida" with "11:00" when field is "input"
    And I fill field with uniqueId as "kmSaida" with "5000" when field is "input"
    And I fill field with uniqueId as "destino" with "Floripa" when field is "input"
    And I press "Salvar"
    Then I should see "Retirar Veículo criado com sucesso!"

  Scenario: Add Excluir Retidada with success
    Given I am on "/patrimonial/frota/veiculo/list"
    And I fill in "filter_placa_value" with "ppp1234"
    And I press "search"
    And I follow "Perfil"
    And I follow "Excluir Retirada"
    And I press "Sim, remover"
    Then I should see "Retirar Veículo removido com sucesso!"

  Scenario: Delete a Veiculo with success
    Given I am on "/patrimonial/frota/veiculo/list"
    And I search by "ppp1234" in "filter_placa_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso"
