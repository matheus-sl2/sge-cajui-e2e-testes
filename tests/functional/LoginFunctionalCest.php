<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

/**
 * Testes funcionais via HTTP/PhpBrowser validando a camada web do Cajuí.
 */
class LoginFunctionalCest
{
    public function testPaginaDeLoginRespondeComSucesso(FunctionalTester $I): void
    {
        $I->wantTo('verificar se a página de login responde com HTTP 200 e elementos visíveis');
        $I->amOnPage('/index.php?r=cajui/login');
        $I->seeResponseCodeIs(200);
        $I->see('Cajuí');
        $I->seeElement('form');
        $I->seeElement('button[name="login-button"]');
    }

    public function testLoginComUsuario(FunctionalTester $I): void
    {
        $I->wantTo('testar autenticação com discente real no Cajuí');
        $I->amOnPage('/index.php?r=cajui/login');
        $I->submitForm('form', [
            'LoginForm[username]' => 'gloria.smith157938',
            'LoginForm[password]' => '123',
        ]);
        $I->dontSee('Usuário ou senha incorretos');
        $I->dontSee('Preencha os campos para entrar');

        // Navegar para o módulo de Novo Estágio
        $I->amOnPage('/index.php?r=gestaoestagio/novo-estagio/index');
        $I->seeResponseCodeIs(200);
        $I->see('Novo Estágio');
    }
}
