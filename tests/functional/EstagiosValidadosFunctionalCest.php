<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\EstagiosValidadosPage;

/**
 * Testes funcionais para o histórico e consulta de Estágios Validados e Integralizados
 * Módulo: gestaoestagio/estagios-validados
 */
class EstagiosValidadosFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarEstagiosValidados(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar histórico de estágios validados');
        $I->amOnPage(EstagiosValidadosPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar o histórico de estágios validados (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarEstagiosValidados(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar tela de estágios validados');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $validadosPage = new EstagiosValidadosPage($I);
        $validadosPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Administrador acessa a listagem e visualiza as colunas do grid de estágios validados
     */
    public function testAdminAcessaHistoricoEstagiosValidados(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que administrador acessa a lista histórica de estágios validados');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $validadosPage = new EstagiosValidadosPage($I);
        $validadosPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(EstagiosValidadosPage::$pageTitle, 'h1');
        $I->seeElement(EstagiosValidadosPage::$gridContainer);
        $I->see('Discente', 'th');
        $I->see('Curso', 'th');
        $I->see('Empresa', 'th');
        $I->see('Data de Envio', 'th');
        $I->see('Criado Por', 'th');
    }

    /**
     * Filtra o grid de estágios validados por discente
     */
    public function testFiltroDiscenteNoGridEstagiosValidados(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar histórico de estágios validados pelo nome do discente');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $validadosPage = new EstagiosValidadosPage($I);
        $validadosPage->filtrarPorDiscente('Gloria');

        $I->seeResponseCodeIs(200);
        $I->seeElement(EstagiosValidadosPage::$gridContainer);
    }

    /**
     * Filtra o grid de estágios validados por empresa
     */
    public function testFiltroEmpresaNoGridEstagiosValidados(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar histórico de estágios validados pelo nome da concedente');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $validadosPage = new EstagiosValidadosPage($I);
        $validadosPage->filtrarPorEmpresa('IFNMG');

        $I->seeResponseCodeIs(200);
        $I->seeElement(EstagiosValidadosPage::$gridContainer);
    }

    /**
     * Filtra o grid de estágios validados pelo usuário criador
     */
    public function testFiltroCriadoPorNoGridEstagiosValidados(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar histórico de estágios validados pelo usuário que registrou a validação');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $validadosPage = new EstagiosValidadosPage($I);
        $validadosPage->filtrarPorCriadoPor('admin');

        $I->seeResponseCodeIs(200);
        $I->seeElement(EstagiosValidadosPage::$gridContainer);
    }
}
