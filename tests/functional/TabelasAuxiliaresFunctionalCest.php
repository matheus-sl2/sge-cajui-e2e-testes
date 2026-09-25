<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\TabelasAuxiliaresPage;

/**
 * Testes funcionais para as tabelas auxiliares de apoio:
 * - Área das Empresas Concedentes (gestaoestagio/area)
 * - Setores de Estágio (gestaoestagio/setor)
 * - Tipos de Empresa Concedente (gestaoestagio/tipo-empresa)
 */
class TabelasAuxiliaresFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarTabelasAuxiliares(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar tabelas auxiliares');

        $I->amOnPage(TabelasAuxiliaresPage::$URL_AREA_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');

        $I->amOnPage(TabelasAuxiliaresPage::$URL_SETOR_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');

        $I->amOnPage(TabelasAuxiliaresPage::$URL_TIPO_EMPRESA_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar os módulos de tabelas auxiliares (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarTabelasAuxiliares(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar telas de tabelas auxiliares');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $auxPage = new TabelasAuxiliaresPage($I);

        $auxPage->irParaListagemArea();
        $I->seeResponseCodeIs(403);

        $auxPage->irParaListagemTipoEmpresa();
        $I->seeResponseCodeIs(403);
    }

    /**
     * Coordenador de estágio visualiza o grid de áreas de empresas concedentes
     */
    public function testCoordenadorEstagioVisualizaListagemArea(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o coordenador de estágio visualiza o grid de áreas');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->irParaListagemArea();

        $I->seeResponseCodeIs(200);
        $I->see(TabelasAuxiliaresPage::$titleArea, 'h1');
        $I->seeElement(TabelasAuxiliaresPage::$gridArea);
        $I->see('Área', 'th');
    }

    /**
     * Filtra a listagem de áreas pelo nome
     */
    public function testFiltroAreaPorNome(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar áreas de empresas concedentes pelo nome');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->filtrarAreaPorNome('Saúde');

        $I->seeResponseCodeIs(200);
        $I->seeElement(TabelasAuxiliaresPage::$gridArea);
    }

    /**
     * Visualização dos detalhes de uma área de estágio
     */
    public function testAdminVisualizaDetalhesArea(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização dos detalhes de uma área de atuação');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->irParaViewArea(1);

        $I->seeResponseCodeIs(200);
        $I->see('Saúde');
    }

    /**
     * Coordenador de estágio visualiza o grid de setores
     */
    public function testCoordenadorEstagioVisualizaListagemSetor(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o coordenador de estágio visualiza o grid de setores');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->irParaListagemSetor();

        $I->seeResponseCodeIs(200);
        $I->see(TabelasAuxiliaresPage::$titleSetor, 'h1');
        $I->seeElement(TabelasAuxiliaresPage::$gridSetor);
        $I->see('Nome', 'th');
    }

    /**
     * Filtra a listagem de setores pelo nome
     */
    public function testFiltroSetorPorNome(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar setores pelo nome');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->filtrarSetorPorNome('Biblioteca');

        $I->seeResponseCodeIs(200);
        $I->seeElement(TabelasAuxiliaresPage::$gridSetor);
    }

    /**
     * Visualização dos detalhes de um setor
     */
    public function testAdminVisualizaDetalhesSetor(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização dos detalhes de um setor');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->irParaViewSetor(1);

        $I->seeResponseCodeIs(200);
        $I->see('Biblioteca');
    }

    /**
     * Coordenador de estágio visualiza o grid de tipos de empresa
     */
    public function testCoordenadorEstagioVisualizaListagemTipoEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o coordenador de estágio visualiza o grid de tipos de empresa');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->irParaListagemTipoEmpresa();

        $I->seeResponseCodeIs(200);
        $I->see(TabelasAuxiliaresPage::$titleTipoEmpresa, 'h1');
        $I->seeElement(TabelasAuxiliaresPage::$gridTipoEmpresa);
        $I->see('Nome', 'th');
    }

    /**
     * Filtra a listagem de tipos de empresa pelo nome
     */
    public function testFiltroTipoEmpresaPorNome(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar tipos de empresa pelo nome');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->filtrarTipoEmpresaPorNome('Pública');

        $I->seeResponseCodeIs(200);
        $I->seeElement(TabelasAuxiliaresPage::$gridTipoEmpresa);
    }

    /**
     * Visualização dos detalhes de um tipo de empresa
     */
    public function testAdminVisualizaDetalhesTipoEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização dos detalhes de um tipo de empresa');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $auxPage = new TabelasAuxiliaresPage($I);
        $auxPage->irParaViewTipoEmpresa(1);

        $I->seeResponseCodeIs(200);
        $I->see('Pública');
    }
}
