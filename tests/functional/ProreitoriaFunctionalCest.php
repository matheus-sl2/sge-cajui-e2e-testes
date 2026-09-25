<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\ProreitoriaPage;

/**
 * Testes funcionais para o Painel de Estágios da Pró-Reitoria de Extensão
 * Módulo: gestaoestagio/proreitoria
 */
class ProreitoriaFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarProreitoria(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar painel da pró-reitoria');
        $I->amOnPage(ProreitoriaPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar o painel da pró-reitoria (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarProreitoria(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar tela da pró-reitoria');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $proreitoriaPage = new ProreitoriaPage($I);
        $proreitoriaPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Administrador acessa o painel de estágios da pró-reitoria e visualiza os dados e colunas
     */
    public function testAdminVisualizaPainelProreitoria(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o administrador visualiza o grid geral da pró-reitoria com colunas essenciais');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $proreitoriaPage = new ProreitoriaPage($I);
        $proreitoriaPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(ProreitoriaPage::$pageTitle, 'h1');
        $I->seeElement(ProreitoriaPage::$gridContainer);
        $I->see('Discente', 'th');
        $I->see('Instituição Concedente', 'th');
        $I->see('Data de Início', 'th');
        $I->see('Data de Fim', 'th');
        $I->see('Curso', 'th');
        $I->see('Unidade', 'th');
        $I->see('Situação', 'th');
    }

    /**
     * Filtra os estágios da pró-reitoria pelo nome do discente
     */
    public function testFiltroDiscenteNoPainelProreitoria(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar estágios da pró-reitoria pelo nome do discente');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $proreitoriaPage = new ProreitoriaPage($I);
        $proreitoriaPage->filtrarPorDiscente('Gloria');

        $I->seeResponseCodeIs(200);
        $I->seeElement(ProreitoriaPage::$gridContainer);
    }

    /**
     * Filtra os estágios da pró-reitoria pelo nome da concedente
     */
    public function testFiltroEmpresaNoPainelProreitoria(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar estágios da pró-reitoria pela instituição concedente');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $proreitoriaPage = new ProreitoriaPage($I);
        $proreitoriaPage->filtrarPorEmpresa('IFNMG');

        $I->seeResponseCodeIs(200);
        $I->seeElement(ProreitoriaPage::$gridContainer);
    }
}
