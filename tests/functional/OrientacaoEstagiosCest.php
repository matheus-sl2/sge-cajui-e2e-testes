<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\OrientacaoEstagiosPage;

/**
 * Testes funcionais da área de Acompanhamento e Orientações de Estágio do Docente.
 */
class OrientacaoEstagiosCest
{
    /**
     * Valida que visitantes sem autenticação não conseguem acessar o painel de orientações.
     */
    public function testAcessoBloqueadoParaVisitanteNaoAutenticado(FunctionalTester $I): void
    {
        $I->wantTo('garantir que visitante sem login seja redirecionado ao tentar acessar orientações');
        $orientacaoPage = new OrientacaoEstagiosPage($I);
        $orientacaoPage->open();

        $I->see('Cajuí');
        $I->seeElement('button[name="login-button"]');
    }

    /**
     * Valida que discente não possui permissão para acessar o painel do docente orientador (RBAC).
     */
    public function testAcessoBloqueadoParaDiscente(FunctionalTester $I): void
    {
        $I->wantTo('verificar que discente é impedido de acessar o painel de orientações do docente');
        $loginPage = new LoginPage($I);
        $orientacaoPage = new OrientacaoEstagiosPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');
        $orientacaoPage->open();

        $I->dontSeeElement(OrientacaoEstagiosPage::$gridContainer);
    }

    /**
     * Valida que o Professor Orientador acessa com sucesso seu painel e visualiza o grid de orientandos.
     */
    public function testOrientadorAcessaPainelOrientacao(FunctionalTester $I): void
    {
        $I->wantTo('verificar que o orientador visualiza a lista de estágios sob sua orientação');
        $loginPage = new LoginPage($I);
        $orientacaoPage = new OrientacaoEstagiosPage($I);

        $loginPage->loginAsOrientador();
        $orientacaoPage->open();

        $I->seeResponseCodeIs(200);
        $I->see(OrientacaoEstagiosPage::$pageTitle);
        $I->seeElement(OrientacaoEstagiosPage::$gridContainer);
        $I->seeElement(OrientacaoEstagiosPage::$filtroAluno);
    }
}
