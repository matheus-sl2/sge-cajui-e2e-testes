<?php

namespace Tests\Support\Page;

use Tests\Support\AcceptanceTester;

/**
 * Page Object para a tela de autenticação do Cajuí.
 */
class LoginPage
{
    /**
     * Rota de acesso à tela de login
     */
    public static string $URL = '/cajui/cajui/login';

    /**
     * Seletores da tela de login
     */
    public static string $usernameField = '#loginform-username';
    public static string $passwordField = '#loginform-password';
    public static string $loginButton   = 'button[name="login-button"]';
    public static string $loginBoxMsg   = '.login-box-msg';
    public static string $govBrButton   = 'a[href*="login-govbr"]';
    public static string $errorMessage  = '.help-block-error, .invalid-feedback';

    protected AcceptanceTester $tester;

    public function __construct(AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    /**
     * Navega para a página de login
     */
    public function open(): self
    {
        $this->tester->amOnPage(self::$URL);
        return $this;
    }

    /**
     * Realiza o login com as credenciais informadas
     */
    public function login(string $username, string $password): self
    {
        $this->tester->fillField(self::$usernameField, $username);
        $this->tester->fillField(self::$passwordField, $password);
        $this->tester->click(self::$loginButton);
        return $this;
    }
}
