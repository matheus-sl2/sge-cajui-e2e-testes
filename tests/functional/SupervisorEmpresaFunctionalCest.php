<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\SupervisorEmpresaPage;

/**
 * Testes funcionais para o gerenciamento de Supervisores de Estágio da Empresa
 * Módulo: gestaoestagio/supervisor-empresa
 */
class SupervisorEmpresaFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarSupervisorEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar supervisores');
        $I->amOnPage(SupervisorEmpresaPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Coordenador de estágio acessa e visualiza a listagem de supervisores
     */
    public function testCoordenadorEstagioVisualizaListagemSupervisores(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o coordenador de estágio visualiza o grid de supervisores');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $supervisorPage = new SupervisorEmpresaPage($I);
        $supervisorPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(SupervisorEmpresaPage::$pageTitle, 'h1');
        $I->seeElement(SupervisorEmpresaPage::$gridContainer);
        $I->see('CPF', 'th');
        $I->see('Nome', 'th');
        $I->see('Email', 'th');
    }

    /**
     * Filtra a listagem de supervisores pelo nome
     */
    public function testFiltroSupervisorPorNome(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar supervisores cadastrados pelo nome');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $supervisorPage = new SupervisorEmpresaPage($I);
        $supervisorPage->filtrarPorNome('Felipe');

        $I->seeResponseCodeIs(200);
        $I->seeElement(SupervisorEmpresaPage::$gridContainer);
        $I->see('Felipe', SupervisorEmpresaPage::$gridContainer);
    }

    /**
     * Renderização do formulário de criação de supervisor vinculado a uma empresa
     */
    public function testRenderizacaoFormularioSupervisor(FunctionalTester $I): void
    {
        $I->wantTo('Verificar renderização do formulário de cadastro de supervisor da empresa');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $supervisorPage = new SupervisorEmpresaPage($I);
        $supervisorPage->irParaCriacao(2);

        $I->seeResponseCodeIs(200);
        $I->seeElement(SupervisorEmpresaPage::$formSupervisor);
        $I->seeElement(SupervisorEmpresaPage::$inputCpf);
        $I->seeElement(SupervisorEmpresaPage::$inputNome);
        $I->seeElement(SupervisorEmpresaPage::$inputEmail);
        $I->seeElement(SupervisorEmpresaPage::$inputTelefone);
        $I->seeElement(SupervisorEmpresaPage::$inputCargo);
        $I->seeElement(SupervisorEmpresaPage::$inputHabilitacao);
        $I->seeElement(SupervisorEmpresaPage::$btnSalvar);
    }

    /**
     * Valida que submissão vazia exibe mensagens de campos obrigatórios
     */
    public function testValidacaoCamposObrigatoriosSupervisor(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que submissão vazia de supervisor aciona validações obrigatórias');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $supervisorPage = new SupervisorEmpresaPage($I);
        $supervisorPage->irParaCriacao(2);
        $supervisorPage->submeter();

        $I->seeResponseCodeIs(200);
        $I->seeElement('.has-error, .is-invalid, .help-block-error, .invalid-feedback');
    }

    /**
     * Coordenador de estágio visualiza o painel de estágios supervisionados
     */
    public function testCoordenadorEstagioAcessaPainelEstagios(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que coordenador de estágio acessa o painel de estágios supervisionados');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $supervisorPage = new SupervisorEmpresaPage($I);
        $supervisorPage->irParaPainelEstagios();

        $I->seeResponseCodeIs(200);
        $I->see('Estágios', 'h1');
        $I->seeElement('#pjax-estagio-index');
    }

    /**
     * Supervisor da empresa autenticado acessa seu módulo de estágios vinculados
     */
    public function testSupervisorEmpresaAcessaEstagiosEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que supervisor da empresa acessa seu módulo de estágios vinculados');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoSupervisorEmpresa();

        $I->amOnPage('/index.php/gestaoestagio/estagios-empresa');
        $I->seeResponseCodeIs(200);
    }

    /**
     * Supervisor da empresa é bloqueado com 403 ao tentar acessar o CRUD administrativo de supervisores
     */
    public function testSupervisorEmpresaBloqueadoParaGestaoSupervisores(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que supervisor da empresa não tem permissão para gerenciar cadastros de supervisores');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoSupervisorEmpresa();

        $supervisorPage = new SupervisorEmpresaPage($I);
        $supervisorPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }
}

