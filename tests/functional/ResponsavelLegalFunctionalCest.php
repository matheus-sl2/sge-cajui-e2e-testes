<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\ResponsavelLegalPage;

/**
 * Testes funcionais para o gerenciamento de Responsáveis Legais de Empresas Concedentes
 * Módulo: gestaoestagio/responsavel-legal
 */
class ResponsavelLegalFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarResponsavelLegal(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar responsáveis legais');
        $I->amOnPage(ResponsavelLegalPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar o módulo de responsáveis legais (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarResponsavelLegal(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar tela de responsáveis legais');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $responsavelPage = new ResponsavelLegalPage($I);
        $responsavelPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Administrador visualiza o grid de responsáveis legais cadastrados
     */
    public function testAdminVisualizaListagemResponsaveisLegais(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o administrador visualiza o grid de responsáveis legais');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $responsavelPage = new ResponsavelLegalPage($I);
        $responsavelPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(ResponsavelLegalPage::$pageTitle, 'h1');
        $I->seeElement(ResponsavelLegalPage::$gridContainer);
        $I->see('Nome', 'th');
        $I->see('Email', 'th');
    }

    /**
     * Filtra a listagem de responsáveis legais pelo nome
     */
    public function testFiltroResponsavelLegalPorNome(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar responsáveis legais cadastrados pelo nome');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $responsavelPage = new ResponsavelLegalPage($I);
        $responsavelPage->filtrarPorNome('Felipe');

        $I->seeResponseCodeIs(200);
        $I->seeElement(ResponsavelLegalPage::$gridContainer);
    }

    /**
     * Renderização do formulário de cadastro de novo responsável legal
     */
    public function testAdminVisualizaFormularioCadastroResponsavelLegal(FunctionalTester $I): void
    {
        $I->wantTo('Verificar renderização do formulário de cadastro de responsável legal com campos essenciais');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $responsavelPage = new ResponsavelLegalPage($I);
        $responsavelPage->irParaCriacao(105);

        $I->seeResponseCodeIs(200);
        $I->see('Responsável Legal');
        $I->seeElement(ResponsavelLegalPage::$inputCpf);
        $I->seeElement(ResponsavelLegalPage::$inputNome);
        $I->seeElement(ResponsavelLegalPage::$inputEmail);
    }

    /**
     * Visualização dos detalhes de cadastro de um responsável legal
     */
    public function testAdminVisualizaDetalhesResponsavelLegal(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização dos dados detalhados de um responsável legal');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $responsavelPage = new ResponsavelLegalPage($I);
        $responsavelPage->irParaDetalhes(1);

        $I->seeResponseCodeIs(200);
        $I->see('Usuário');
    }

    /**
     * Coordenador de estágio acessa o painel de estágios de responsáveis legais
     */
    public function testCoordenadorEstagioAcessaPainelEstagios(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que coordenador de estágio acessa o painel de estágios vinculados');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $responsavelPage = new ResponsavelLegalPage($I);
        $responsavelPage->irParaPainelEstagio();

        $I->seeResponseCodeIs(200);
        $I->see('Estágios', 'h1');
        $I->seeElement('#pjax-estagio-index');
    }

    /**
     * Visualização do Termo de Compromisso de Estágio (TCE) pelo módulo de responsável legal
     */
    public function testVisualizacaoTceNoModuloResponsavelLegal(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização do Termo de Compromisso (TCE) no módulo do responsável legal');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $responsavelPage = new ResponsavelLegalPage($I);
        $responsavelPage->irParaTce(115);

        $I->seeResponseCodeIs(200);
        $I->see('TERMO DE COMPROMISSO DE ESTÁGIO (TCE)');
        $I->see('INSTITUIÇÃO CONCEDENTE');
    }

    /**
     * Responsável legal da empresa autenticado acessa seu módulo de estágios vinculados
     */
    public function testResponsavelLegalAcessaEstagiosEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que responsável legal da empresa acessa o histórico de estágios vinculados');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsResponsavelEmpresa();

        $I->amOnPage('/index.php/gestaoestagio/estagios-empresa');
        $I->seeResponseCodeIs(200);
    }

    /**
     * Responsável legal da empresa é bloqueado com 403 ao tentar acessar o CRUD administrativo
     */
    public function testResponsavelLegalBloqueadoParaGestaoResponsaveis(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que responsável legal da empresa não tem permissão para gerenciar cadastros administrativos');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsResponsavelEmpresa();

        $responsavelPage = new ResponsavelLegalPage($I);
        $responsavelPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }
}
