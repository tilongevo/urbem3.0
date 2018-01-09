# features/financeiro/tesouraria/terminalUsuarioTerminal.feature
Feature: Terminal de Caixa (Financeira>Tesouraria>Configuração)

    Scenario: Acessar página lista de terminais com sucesso
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/tesouraria/boletim/abrir-boletim/list"
        Then I should see text matching "Código do boletim"

    Scenario: Acessar página create de terminais com sucesso
        Given I am authenticated as "suporte" with "123"
        Given I am on "/financeiro/tesouraria/terminal/create"
        Then I should see text matching "Dados para Terminal e Usuários"

    Scenario: Desativar terminal com sucesso
        Given I am authenticated as "suporte" with "123"
        And I am on "/financeiro/tesouraria/terminal/list"
        And I follow "Desativar terminal"
        Then I should see "Terminal desativado com sucesso"

    Scenario: Ativar terminal com sucesso
        Given I am authenticated as "suporte" with "123"
        And I am on "/financeiro/tesouraria/terminal/list"
        And I follow "Ativar terminal"
        Then I should see "Terminal ativado com sucesso"

    Scenario: fechar terminal com sucesso
        Given I am authenticated as "suporte" with "123"
        And I am on "/financeiro/tesouraria/terminal/list"
        And I follow "Fechar terminal"
        Then I should see "Terminal fechado com sucesso"

    Scenario: reabrir terminal com sucesso
        Given I am authenticated as "suporte" with "123"
        And I am on "/financeiro/tesouraria/terminal/list"
        And I follow "Reabrir terminal"
        Then I should see "Terminal reaberto com sucesso"