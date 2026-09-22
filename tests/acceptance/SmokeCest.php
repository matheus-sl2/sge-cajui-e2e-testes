<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Page\LoginPage;

/**
 * Testes iniciais de fumaça (Smoke Tests) para validar disponibilidade e renderização básica da aplicação.
 */
class SmokeCest
{
    /**
     * Valida se a página de login carrega com sucesso e exibe os campos principais.
     */
    public function verificarPaginaDeLoginDisponivel(AcceptanceTester $I): void
    {
        $I->wantTo('verificar se a tela de login do Cajuí está acessível');
        $loginPage = new LoginPage($I);
        $loginPage->open();

        $I->seeInTitle('Cajuí');
        $I->seeElement(LoginPage::$usernameField);
        $I->seeElement(LoginPage::$passwordField);
        $I->seeElement(LoginPage::$loginButton);
    }

    /**
     * Valida se a tentativa de login sem preencher campos exibe validação.
     */
    public function verificarValidacaoCamposVazios(AcceptanceTester $I): void
    {
        $I->wantTo('verificar validação de campos obrigatórios ao submeter formulário em branco');
        $loginPage = new LoginPage($I);
        $loginPage->open();
        $I->click(LoginPage::$loginButton);

        // Verifica se permanece na tela de login
        $I->seeElement(LoginPage::$loginButton);
    }
}
