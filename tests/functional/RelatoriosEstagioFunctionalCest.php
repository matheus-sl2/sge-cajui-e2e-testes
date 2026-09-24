<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\RelatoriosEstagioPage;

/**
 * Testes funcionais para os Relatórios Gerenciais do Módulo de Estágio
 * Módulo: gestaoestagio/relatorios
 */
class RelatoriosEstagioFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarRelatorios(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar relatórios');
        $I->amOnPage(RelatoriosEstagioPage::$URL_ESTAGIO_EMPRESA);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Garante que discente seja impedido de acessar os relatórios gerenciais (RBAC 403)
     */
    public function testDiscenteBloqueadoAoTentarAcessarRelatorios(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que discente recebe 403 ao tentar acessar relatórios gerenciais');

        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno();

        $relatoriosPage = new RelatoriosEstagioPage($I);
        $relatoriosPage->irParaEstagioEmpresa();

        $I->seeResponseCodeIs(403);
    }

    /**
     * Coordenador de estágio visualiza o relatório de quantidade de estágios por empresa
     */
    public function testCoordenadorEstagioVisualizaRelatorioEstagioEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Verificar relatório de quantidade de estágios por empresa concedente');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $relatoriosPage = new RelatoriosEstagioPage($I);
        $relatoriosPage->irParaEstagioEmpresa();

        $I->seeResponseCodeIs(200);
        $I->see('Relatório - Quantidade de Estágios por Empresa', 'h1');
        $I->seeElement(RelatoriosEstagioPage::$gridEstagioEmpresa);
        $I->see('Instituição Concedente', 'th');
        $I->see('Estágios Concedidos', 'th');
    }

    /**
     * Coordenador de estágio visualiza o relatório de quantidade de estágios por curso
     */
    public function testCoordenadorEstagioVisualizaRelatorioEstagioCurso(FunctionalTester $I): void
    {
        $I->wantTo('Verificar relatório de quantidade de estágios por curso');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $relatoriosPage = new RelatoriosEstagioPage($I);
        $relatoriosPage->irParaEstagioCurso();

        $I->seeResponseCodeIs(200);
        $I->see('Relatório - Quantidade de Estágios por Curso', 'h1');
        $I->seeElement(RelatoriosEstagioPage::$gridEstagioCurso);
        $I->see('Curso', 'th');
        $I->see('Estágios Concedidos', 'th');
    }

    /**
     * Coordenador de estágio visualiza o relatório de assinaturas pendentes
     */
    public function testCoordenadorEstagioVisualizaRelatorioAssinaturasPendentes(FunctionalTester $I): void
    {
        $I->wantTo('Verificar relatório de assinaturas pendentes de documentos');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $relatoriosPage = new RelatoriosEstagioPage($I);
        $relatoriosPage->irParaAssinaturasPendentes();

        $I->seeResponseCodeIs(200);
        $I->see('Assinaturas Pendentes', 'h1');
        $I->see('Usuário', 'th');
        $I->see('Papel', 'th');
        $I->see('Estagiário', 'th');
    }

    /**
     * Coordenador de estágio visualiza o relatório de seguros com formulário de busca
     */
    public function testCoordenadorEstagioVisualizaRelatorioSeguros(FunctionalTester $I): void
    {
        $I->wantTo('Verificar relatório de seguros com filtro por data');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $relatoriosPage = new RelatoriosEstagioPage($I);
        $relatoriosPage->irParaSeguros();

        $I->seeResponseCodeIs(200);
        $I->see('Relatório de Seguros', 'h1');
        $I->seeElement('input#data_inicio-input');
        $I->seeElement('button[type="submit"]');
    }

    /**
     * Coordenador de estágio visualiza o relatório de orientações docentes
     */
    public function testCoordenadorEstagioVisualizaRelatorioOrientacoes(FunctionalTester $I): void
    {
        $I->wantTo('Verificar relatório de orientações de estágio do corpo docente');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $relatoriosPage = new RelatoriosEstagioPage($I);
        $relatoriosPage->irParaOrientacoes();

        $I->seeResponseCodeIs(200);
        $I->see('Relatório - Orientações', 'h1');
        $I->seeElement(RelatoriosEstagioPage::$gridOrientacoes);
        $I->see('Orientador', 'th');
        $I->see('Estagiário', 'th');
    }
}
