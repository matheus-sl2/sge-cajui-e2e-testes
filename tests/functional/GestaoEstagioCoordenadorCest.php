<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\EstagioPage;

/**
 * Testes funcionais da Gestão Geral de Estágios pelo Coordenador de Estágios.
 */
class GestaoEstagioCoordenadorCest
{
    /**
     * Valida que visitantes sem autenticação não conseguem acessar o gerenciamento geral de estágios.
     */
    public function testAcessoBloqueadoParaVisitanteNaoAutenticado(FunctionalTester $I): void
    {
        $I->wantTo('garantir que visitante sem login seja redirecionado ao tentar acessar gestão de estágios');
        $estagioPage = new EstagioPage($I);
        $estagioPage->openLista();

        $I->see('Cajuí');
        $I->seeElement('button[name="login-button"]');
    }

    /**
     * Valida que discente não possui permissão para acessar a tela administrativa geral de estágios (RBAC).
     */
    public function testAcessoBloqueadoParaDiscente(FunctionalTester $I): void
    {
        $I->wantTo('verificar que discente é impedido de acessar o grid geral de estágios');
        $loginPage = new LoginPage($I);
        $estagioPage = new EstagioPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');
        $estagioPage->openLista();

        // Discente não deve ter acesso ao grid administrativo de todos os estágios
        $I->dontSeeElement(EstagioPage::$gridContainer);
    }

    /**
     * Valida que o Coordenador de Estágios acessa com sucesso o grid com filtros de busca.
     */
    public function testCoordenadorEstagioAcessaGridGeral(FunctionalTester $I): void
    {
        $I->wantTo('verificar que o coordenador de estágio visualiza o grid geral e os filtros de pesquisa');
        $loginPage = new LoginPage($I);
        $estagioPage = new EstagioPage($I);

        $loginPage->loginAsCoordenadorEstagio();
        $estagioPage->openLista();

        $I->seeResponseCodeIs(200);
        $I->see(EstagioPage::$pageTitle);
        $I->seeElement(EstagioPage::$gridContainer);
        $I->seeElement(EstagioPage::$filtroAluno);
        $I->seeElement(EstagioPage::$filtroEmpresa);
        $I->seeElement(EstagioPage::$filtroSituacao);
    }

    /**
     * Valida a aplicação de filtro por nome do discente no grid de estágios.
     */
    public function testFiltroPorAlunoNoGrid(FunctionalTester $I): void
    {
        $I->wantTo('filtrar estágios pelo nome do discente no grid da coordenação');
        $loginPage = new LoginPage($I);
        $estagioPage = new EstagioPage($I);

        $loginPage->loginAsCoordenadorEstagio();
        $estagioPage->filtrarPorAluno('Gloria');

        $I->seeResponseCodeIs(200);
        $I->seeElement(EstagioPage::$gridContainer);
    }
}
