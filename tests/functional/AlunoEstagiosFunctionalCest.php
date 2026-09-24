<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\AlunoEstagiosPage;

/**
 * Testes funcionais do painel de acompanhamento de estágios do discente (Meus Estágios).
 */
class AlunoEstagiosFunctionalCest
{
    /**
     * Valida que visitantes sem autenticação não conseguem acessar o painel de estágios.
     */
    public function testAcessoBloqueadoParaVisitanteNaoAutenticado(FunctionalTester $I): void
    {
        $I->wantTo('garantir que visitante sem login seja redirecionado ao tentar acessar painel do aluno');
        $alunoPage = new AlunoEstagiosPage($I);
        $alunoPage->open();

        $I->see('Cajuí');
        $I->seeElement('button[name="login-button"]');
    }

    /**
     * Valida que discente do nível superior (BSI) visualiza suas informações de estágio.
     */
    public function testAlunoBsiVisualizaPainelMeusEstagios(FunctionalTester $I): void
    {
        $I->wantTo('verificar que discente de graduação visualiza o painel de orientações de estágio');
        $loginPage = new LoginPage($I);
        $alunoPage = new AlunoEstagiosPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');
        $alunoPage->open();

        $I->seeResponseCodeIs(200);
        $I->see(AlunoEstagiosPage::$tituloInformativo);
        $I->see('Acompanhe com frequência a situação do seu estágio');
    }

    /**
     * Valida que discente do nível técnico visualiza suas orientações de estágio.
     */
    public function testAlunoTecnicoVisualizaPainelMeusEstagios(FunctionalTester $I): void
    {
        $I->wantTo('verificar que discente do nível técnico visualiza o painel de estágios');
        $loginPage = new LoginPage($I);
        $alunoPage = new AlunoEstagiosPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_TEC_LOGIN');
        $alunoPage->open();

        $I->seeResponseCodeIs(200);
        $I->see(AlunoEstagiosPage::$tituloInformativo);
        $I->see('A carga horária de cada estágio só é apresentada após a finalização');
    }
}
