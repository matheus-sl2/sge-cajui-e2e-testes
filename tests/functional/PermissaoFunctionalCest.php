<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\PermissaoPage;

/**
 * Testes funcionais para o gerenciamento de Permissões e Perfis do módulo de Estágios
 * Módulo: gestaoestagio/permissao
 */
class PermissaoFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarPermissoes(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar permissões');
        $I->amOnPage(PermissaoPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar o módulo de permissões (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarPermissoes(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar tela de permissões');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $permissaoPage = new PermissaoPage($I);
        $permissaoPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Coordenador de estágio visualiza a listagem e o grid de permissões cadastradas
     */
    public function testCoordenadorEstagioVisualizaListagemPermissoes(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o coordenador de estágio visualiza o grid de permissões');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $permissaoPage = new PermissaoPage($I);
        $permissaoPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(PermissaoPage::$pageTitle, 'h1');
        $I->seeElement(PermissaoPage::$gridContainer);
        $I->see('Pessoa', 'th');
        $I->see('Papel', 'th');
    }

    /**
     * Filtra o grid de permissões pelo nome da pessoa
     */
    public function testFiltroPermissaoPorPessoa(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar permissões cadastradas pelo nome da pessoa');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $permissaoPage = new PermissaoPage($I);
        $permissaoPage->filtrarPorPessoa('Felipe');

        $I->seeResponseCodeIs(200);
        $I->seeElement(PermissaoPage::$gridContainer);
    }

    /**
     * Administrador visualiza o formulário de atribuição de nova permissão
     */
    public function testAdminVisualizaFormularioCadastroPermissao(FunctionalTester $I): void
    {
        $I->wantTo('Verificar renderização do formulário de atribuição de permissão com campos essenciais');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $permissaoPage = new PermissaoPage($I);
        $permissaoPage->irParaCriacao();

        $I->seeResponseCodeIs(200);
        $I->seeElement(PermissaoPage::$formPermissao);
        $I->see('Papel');
    }

    /**
     * Visualização dos detalhes da permissão atribuída a uma pessoa
     */
    public function testAdminVisualizaDetalhesPermissao(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização dos dados detalhados de uma permissão atribuída');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $permissaoPage = new PermissaoPage($I);
        $permissaoPage->irParaDetalhes(188906);

        $I->seeResponseCodeIs(200);
        $I->see('Pessoa');
        $I->see('Papel');
    }
}
