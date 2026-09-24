<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\AssinaturaTcePage;

/**
 * Testes funcionais para o fluxo de Assinaturas Eletrônicas do Termo de Compromisso (TCE)
 * Módulos: gestaoestagio/assinaturas-empresa e gestaoestagio/assinaturas-registro
 */
class AssinaturasTceFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarAssinaturas(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar assinaturas');
        $I->amOnPage(AssinaturaTcePage::$URL_ASSINATURAS_EMPRESA);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar o painel de assinaturas da concedente (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarAssinaturasEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar assinaturas da concedente');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $tcePage = new AssinaturaTcePage($I);
        $tcePage->irParaAssinaturasEmpresa();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Supervisor de estágio da empresa acessa o painel de assinaturas pendentes
     */
    public function testSupervisorEmpresaAcessaPainelAssinaturas(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que supervisor da empresa visualiza a tela de assinaturas de TCE');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoSupervisorEmpresa();

        $tcePage = new AssinaturaTcePage($I);
        $tcePage->irParaAssinaturasEmpresa();

        $I->seeResponseCodeIs(200);
        $I->see('Assinaturas', 'h1');
        $I->seeElement(AssinaturaTcePage::$gridContainer);
    }

    /**
     * Responsável legal da empresa acessa o painel de assinaturas de TCE
     */
    public function testResponsavelEmpresaAcessaPainelAssinaturas(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que responsável legal da empresa acessa as assinaturas de TCE');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsResponsavelEmpresa();

        $tcePage = new AssinaturaTcePage($I);
        $tcePage->irParaAssinaturasEmpresa();

        $I->seeResponseCodeIs(200);
        $I->see('Assinaturas', 'h1');
        $I->seeElement(AssinaturaTcePage::$gridContainer);
    }

    /**
     * Administrador / Registro Escolar acessa o painel de assinaturas de registro
     */
    public function testAdminAcessaPainelAssinaturasRegistro(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que setor de registro acompanha os estágios em fase de assinatura');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $tcePage = new AssinaturaTcePage($I);
        $tcePage->irParaAssinaturasRegistro();

        $I->seeResponseCodeIs(200);
        $I->see('Assinaturas de TCE', 'h1');
        $I->seeElement(AssinaturaTcePage::$gridContainer);
    }
}
