<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\CoordenadorCursoPage;

/**
 * Testes funcionais do Painel de Aprovação Pedagógica do Coordenador de Curso.
 */
class CoordenadorCursoCest
{
    /**
     * Valida que visitantes sem autenticação não conseguem acessar o painel do coordenador de curso.
     */
    public function testAcessoBloqueadoParaVisitanteNaoAutenticado(FunctionalTester $I): void
    {
        $I->wantTo('garantir que visitante sem login seja redirecionado ao tentar acessar painel do coordenador de curso');
        $coordPage = new CoordenadorCursoPage($I);
        $coordPage->open();

        $I->see('Cajuí');
        $I->seeElement('button[name="login-button"]');
    }

    /**
     * Valida que discente não possui permissão para acessar o painel pedagógico do coordenador de curso (RBAC).
     */
    public function testAcessoBloqueadoParaDiscente(FunctionalTester $I): void
    {
        $I->wantTo('verificar que discente é impedido de acessar o painel do coordenador de curso');
        $loginPage = new LoginPage($I);
        $coordPage = new CoordenadorCursoPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');
        $coordPage->open();

        $I->dontSeeElement(CoordenadorCursoPage::$gridContainer);
    }

    /**
     * Valida que o Coordenador de Curso acessa com sucesso seu painel pedagógico e visualiza o grid de solicitações.
     */
    public function testCoordenadorCursoAcessaPainelAprovacao(FunctionalTester $I): void
    {
        $I->wantTo('verificar que o coordenador de curso visualiza o painel de aprovação de estágios e filtros');
        $loginPage = new LoginPage($I);
        $coordPage = new CoordenadorCursoPage($I);

        $loginPage->loginAsCoordenadorCurso();
        $coordPage->open();

        $I->seeResponseCodeIs(200);
        $I->see(CoordenadorCursoPage::$pageTitle);
        $I->seeElement(CoordenadorCursoPage::$gridContainer);
        $I->seeElement(CoordenadorCursoPage::$filtroAluno);
        $I->seeElement(CoordenadorCursoPage::$filtroOrientador);
    }
}
