<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\RegistroEstagioPage;

/**
 * Testes funcionais para o fluxo de aprovação de matrícula pelo setor de registro escolar
 * Módulo: gestaoestagio/registro
 */
class RegistroEstagioFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarRegistro(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar setor de registro');
        $I->amOnPage(RegistroEstagioPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar o módulo do setor de registro (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarRegistro(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar tela do setor de registro');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $registroPage = new RegistroEstagioPage($I);
        $registroPage->irParaListagem();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Administrador acessa a listagem de estágios pendentes para o setor de registro
     */
    public function testAdminAcessaListagemRegistro(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que administrador acessa a lista de estágios do setor de registro');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $registroPage = new RegistroEstagioPage($I);
        $registroPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(RegistroEstagioPage::$pageTitle, 'h1');
        $I->seeElement(RegistroEstagioPage::$gridContainer);
        $I->see('Discente', 'th');
        $I->see('Curso', 'th');
    }

    /**
     * Filtra o grid de estágios do setor de registro por nome do discente
     */
    public function testFiltroDiscenteNoGridRegistro(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar estágios do setor de registro pelo nome do discente');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $registroPage = new RegistroEstagioPage($I);
        $registroPage->filtrarPorDiscente('Gloria');

        $I->seeResponseCodeIs(200);
        $I->seeElement(RegistroEstagioPage::$gridContainer);
    }

    /**
     * Administrador acessa os detalhes de conferência de matrícula de um estágio
     */
    public function testAdminAcessaDetalhesRegistroEstagio(FunctionalTester $I): void
    {
        $I->wantTo('Verificar acesso à tela de detalhes e conferência do estágio no setor de registro');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $registroPage = new RegistroEstagioPage($I);
        $registroPage->irParaView(115);

        $I->seeResponseCodeIs(200);
        $I->see('Dados do Estágio');
        $I->see('Discente');
        $I->see('Curso');
        $I->see('Adicionar informações');
        $I->seeElement(RegistroEstagioPage::$campoPeriodo);
        $I->seeElement(RegistroEstagioPage::$campoTurno);
        $I->seeElement(RegistroEstagioPage::$campoInicioAno);
        $I->see('Indeferir Estágio');
    }

    /**
     * Administrador acessa a visualização unificada do TCE pelo módulo de registro
     */
    public function testAdminAcessaVisualizacaoTceNoRegistro(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização do Termo de Compromisso de Estágio (TCE) no setor de registro');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAdmin();

        $registroPage = new RegistroEstagioPage($I);
        $registroPage->irParaTce(115);

        $I->seeResponseCodeIs(200);
        $I->see('TERMO DE COMPROMISSO DE ESTÁGIO (TCE)');
        $I->see('INSTITUIÇÃO CONCEDENTE');
    }
}
