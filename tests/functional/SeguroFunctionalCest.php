<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\SeguroPage;

/**
 * Testes funcionais para o gerenciamento de Apólices de Seguros de Estágio
 * Módulo: gestaoestagio/seguros
 */
class SeguroFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarSeguros(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar seguros');
        $I->amOnPage(SeguroPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar o gerenciamento de seguros (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarSeguros(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar tela de seguros');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $seguroPage = new SeguroPage($I);
        $seguroPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Coordenador de estágio acessa e visualiza a listagem de seguros de estágio
     */
    public function testCoordenadorEstagioVisualizaListagemSeguros(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o coordenador de estágio visualiza o grid de apólices de seguros');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $seguroPage = new SeguroPage($I);
        $seguroPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(SeguroPage::$pageTitle, 'h1');
        $I->seeElement(SeguroPage::$gridContainer);
        $I->see('Data início', 'th');
        $I->see('Data final', 'th');
        $I->see('Seguradora', 'th');
        $I->seeElement(SeguroPage::$btnNovo);
    }

    /**
     * Filtra seguros cadastrados pelo nome da seguradora
     */
    public function testFiltroSegurosPorSeguradora(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar seguros pelo nome da seguradora');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $seguroPage = new SeguroPage($I);
        $seguroPage->filtrarPorSeguradora('Seguradora Estudantil');

        $I->seeResponseCodeIs(200);
        $I->seeElement(SeguroPage::$gridContainer);
        $I->see('Seguradora Estudantil', SeguroPage::$gridContainer);
    }

    /**
     * Filtra seguros cadastrados pelo número da apólice
     */
    public function testFiltroSegurosPorNumeroApolice(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar seguros pelo número da apólice');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $seguroPage = new SeguroPage($I);
        $seguroPage->filtrarPorApolice('159753456');

        $I->seeResponseCodeIs(200);
        $I->seeElement(SeguroPage::$gridContainer);
        $I->see('159753456', SeguroPage::$gridContainer);
    }

    /**
     * Renderização do formulário de criação de apólice de seguro com campos essenciais
     */
    public function testRenderizacaoFormularioCriacaoSeguro(FunctionalTester $I): void
    {
        $I->wantTo('Verificar renderização do formulário de cadastro de apólice de seguro');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $seguroPage = new SeguroPage($I);
        $seguroPage->irParaCriacao();

        $I->seeResponseCodeIs(200);
        $I->seeElement(SeguroPage::$formSeguro);
        $I->seeElement(SeguroPage::$inputApolice);
        $I->seeElement(SeguroPage::$inputSeguradora);
        $I->seeElement(SeguroPage::$inputTelefone);
        $I->seeElement(SeguroPage::$btnSalvar);
    }

    /**
     * Visualização dos detalhes de uma apólice de seguro existente
     */
    public function testVisualizacaoDetalhesSeguro(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização dos detalhes de uma apólice de seguro');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $seguroPage = new SeguroPage($I);
        $seguroPage->irParaDetalhes(2);

        $I->seeResponseCodeIs(200);
        $I->see('159753456');
        $I->see('Seguradora Estudantil');
    }
}
