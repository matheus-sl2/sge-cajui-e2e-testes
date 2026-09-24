<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\ValidarEstagioPage;

/**
 * Testes funcionais para o fluxo de validação acadêmica de estágio na secretaria escolar
 * Módulo: gestaoestagio/validar-estagio
 */
class ValidarEstagioFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarValidarEstagio(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar validar estágio');
        $I->amOnPage(ValidarEstagioPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar o módulo de validação de estágios (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarValidarEstagio(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar tela de validação de estágios');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $validarPage = new ValidarEstagioPage($I);
        $validarPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Administrador acessa a listagem de estágios para validação acadêmica
     */
    public function testAdminAcessaListagemValidarEstagio(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que administrador acessa a lista de estágios pendentes de validação');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $validarPage = new ValidarEstagioPage($I);
        $validarPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(ValidarEstagioPage::$pageTitle, 'h1');
        $I->seeElement(ValidarEstagioPage::$gridContainer);
        $I->see('Discente', 'th');
        $I->see('Curso', 'th');
    }

    /**
     * Filtra o grid de validação por nome do discente
     */
    public function testFiltroDiscenteNoGridValidarEstagio(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar estágios para validação pelo nome do discente');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $validarPage = new ValidarEstagioPage($I);
        $validarPage->filtrarPorDiscente('Rita');

        $I->seeResponseCodeIs(200);
        $I->seeElement(ValidarEstagioPage::$gridContainer);
    }

    /**
     * Administrador acessa a tela de conferência de dados para integralização do estágio
     */
    public function testAcessoTelaValidacaoEstagio(FunctionalTester $I): void
    {
        $I->wantTo('Verificar tela de conferência acadêmica para validação de estágio');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $validarPage = new ValidarEstagioPage($I);
        $validarPage->irParaValidacao(116);

        $I->seeResponseCodeIs(200);
        $I->see('Contrato');
        $I->see('Professor');
    }
}
