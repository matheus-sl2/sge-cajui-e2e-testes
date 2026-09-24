<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\DataLimitePage;

/**
 * Testes funcionais para a configuração de Datas Limite e Prazos de Estágio
 * Módulo: gestaoestagio/data-limite
 */
class DataLimiteFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarDataLimite(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar data limite');
        $I->amOnPage(DataLimitePage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar as configurações de data limite (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarDataLimite(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar tela de data limite');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $dataLimitePage = new DataLimitePage($I);
        $dataLimitePage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Coordenador de estágio acessa e visualiza a listagem de datas limite
     */
    public function testCoordenadorEstagioVisualizaListagemDataLimite(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o coordenador de estágio visualiza o grid de datas limite');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $dataLimitePage = new DataLimitePage($I);
        $dataLimitePage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(DataLimitePage::$pageTitle, 'h1');
        $I->seeElement(DataLimitePage::$gridContainer);
        $I->seeElement(DataLimitePage::$btnNovo);
    }

    /**
     * Filtra datas limite pelo ano no grid de busca
     */
    public function testFiltroDataLimitePorAno(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar datas limite cadastradas pelo ano');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $dataLimitePage = new DataLimitePage($I);
        $dataLimitePage->filtrarPorAno('2026');

        $I->seeResponseCodeIs(200);
        $I->seeElement(DataLimitePage::$gridContainer);
        $I->see('2026', DataLimitePage::$gridContainer);
    }

    /**
     * Renderização do formulário de criação de nova data limite
     */
    public function testRenderizacaoFormularioCriacaoDataLimite(FunctionalTester $I): void
    {
        $I->wantTo('Verificar renderização do formulário de cadastro de data limite com campos de prazo');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $dataLimitePage = new DataLimitePage($I);
        $dataLimitePage->irParaCriacao();

        $I->seeResponseCodeIs(200);
        $I->seeElement(DataLimitePage::$formDataLimite);
        $I->seeElement(DataLimitePage::$selectMes);
        $I->seeElement(DataLimitePage::$selectAno);
        $I->seeElement(DataLimitePage::$inputDiaLimite);
        $I->seeElement(DataLimitePage::$btnSalvar);
    }

    /**
     * Visualização dos detalhes de uma configuração de data limite existente
     */
    public function testVisualizacaoDetalhesDataLimite(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização dos detalhes de uma configuração de data limite');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $dataLimitePage = new DataLimitePage($I);
        $dataLimitePage->irParaDetalhes(1);

        $I->seeResponseCodeIs(200);
        $I->see('Data Limite');
        $I->see('2026');
    }
}
