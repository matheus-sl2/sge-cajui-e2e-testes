<?php

namespace Tests\Support\Page;

/**
 * Page Object para a tela de autenticação do Cajuí.
 */
class LoginPage
{
    /**
     * Rota de acesso à tela de login no Cajuí
     */
    public static string $URL = '/index.php?r=cajui/login';

    /**
     * Seletores da tela de login
     */
    public static string $usernameField = '#loginform-username';
    public static string $passwordField = '#loginform-password';
    public static string $loginButton   = 'button[name="login-button"]';
    public static string $loginBoxMsg   = '.login-box-msg';
    public static string $govBrButton   = 'a[href*="login-govbr"]';
    public static string $errorMessage  = '.help-block-error, .invalid-feedback, .alert-danger';

    /**
     * @var mixed Actor do teste ($I) - pode ser AcceptanceTester ou FunctionalTester
     */
    protected mixed $tester;

    public function __construct(mixed $I)
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
        $this->open();
        $this->tester->submitForm('form', [
            'LoginForm[username]' => $username,
            'LoginForm[password]' => $password,
        ]);
        return $this;
    }

    /**
     * Realiza login como Aluno/Discente
     */
    public function loginAsAluno(string $alunoKey = 'TEST_ALUNO_BSI_LOGIN'): self
    {
        $username = $_ENV[$alunoKey] ?? 'gloria.smith157938';
        $password = $_ENV['TEST_DEFAULT_PASSWORD'] ?? '123';
        return $this->login($username, $password);
    }

    /**
     * Realiza login como Administrador
     */
    public function loginAsAdmin(): self
    {
        $username = $_ENV['TEST_ADMIN_LOGIN'] ?? 'administrador';
        $password = $_ENV['TEST_DEFAULT_PASSWORD'] ?? '123';
        return $this->login($username, $password);
    }

    /**
     * Realiza login como Coordenador de Estágios
     */
    public function loginAsCoordenadorEstagio(): self
    {
        $username = $_ENV['TEST_COORD_ESTAGIO_LOGIN'] ?? 'alan.carter180333';
        $password = $_ENV['TEST_DEFAULT_PASSWORD'] ?? '123';
        return $this->login($username, $password);
    }

    /**
     * Realiza login como Coordenador de Curso
     */
    public function loginAsCoordenadorCurso(): self
    {
        $username = $_ENV['TEST_COORD_CURSO_LOGIN'] ?? 'steven.floyd104448';
        $password = $_ENV['TEST_DEFAULT_PASSWORD'] ?? '123';
        return $this->login($username, $password);
    }

    /**
     * Realiza login como Professor Orientador
     */
    public function loginAsOrientador(): self
    {
        $username = $_ENV['TEST_ORIENTADOR_LOGIN'] ?? 'joshua.ross118643';
        $password = $_ENV['TEST_DEFAULT_PASSWORD'] ?? '123';
        return $this->login($username, $password);
    }
}
