# features/patrimonial/frota/veiculoCessao.feature
Feature: Homepage Patrimonial>Frota>Veiculo>Perfil>Cessao
  In order to Homepage Patrimonial>Frota>Veiculo>Perfil>Cessao
  I would be able to access the urbem

  Background:
    Given I am authenticated as "suporte" with "123"

  Scenario: Create a new Veiculo with success
    Given I am on "/patrimonial/frota/veiculo/create"
    And I fill field with uniqueId as "codMarca" with "VolksWagem" when field is "select"
    And I fill field with uniqueId as "codModelo" with "Motoniveladora 165 S" when field is "select"
    And I fill field with uniqueId as "codTipoVeiculo" with "Passeio" when field is "select"
    And I fill field with uniqueId as "codCombustivel" with "Diesel" when field is "select"
    And I fill field with uniqueId as "placa" with "ccc1234" when field is "input"
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

  Scenario: Add Cessao Veiculo with success
    Given I am on "/patrimonial/frota/veiculo/list"
    And I fill in "filter_placa_value" with "ccc1234"
    And I press "search"
    And I follow "Perfil"
    And I follow "Cessão"
    And I fill field with uniqueId as "codProcesso" with "1542/2015 - Pedido de abonação de taxa de protocolo para funcionários" when field is "select"
    And I fill field with uniqueId as "cgmCedente" with "4 - Prefeitura Municipal de Mariana Pimentel" when field is "select"
    And I fill field with uniqueId as "dtInicio" with "24/10/2016" when field is "input"
    And I fill field with uniqueId as "dtTermino" with "31/10/2016" when field is "input"
    And I press "Salvar"
    Then I should see "Cessão criado com sucesso."

  Scenario: Edit Cessao Veiculo with success
    Given I am on "/patrimonial/frota/veiculo/list"
    And I fill in "filter_placa_value" with "ccc1234"
    And I press "search"
    And I follow "Perfil"
    And I follow "cessao"
    And I fill field with uniqueId as "codProcesso" with "848/2015 - Pedido de comprovação de prestação de serviços" when field is "select"
    And I fill field with uniqueId as "cgmCedente" with "3849 - ABASTECEDORA INTERNA DA PREFEITURA MARIANA PIMENTEL" when field is "select"
    And I fill field with uniqueId as "dtInicio" with "25/12/2016" when field is "input"
    And I fill field with uniqueId as "dtTermino" with "31/12/2016" when field is "input"
    And I press "Salvar"
    Then I should see "Cessão atualizado com sucesso."

  Scenario: Delete Cessao Veiculo with success
    Given I am on "/patrimonial/frota/veiculo/list"
    And I fill in "filter_placa_value" with "ccc1234"
    And I press "search"
    And I follow "Perfil"
    And I follow "delete"
    And I press "Sim, remover"
    Then I should see "Cessão removido com sucesso."

  Scenario: Delete a Veiculo with success
    Given I am on "/patrimonial/frota/veiculo/list"
    And I search by "ccc1234" in "filter_placa_value" and follow to "delete"
    And I press "Sim, remover"
    Then I should see "O item foi removido com sucesso"
