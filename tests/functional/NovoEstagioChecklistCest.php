<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\NovoEstagioChecklistPage;

/**
 * Testes funcionais da Etapa 1: Checklist de Novo Estágio pelo Aluno.
 */
class NovoEstagioChecklistCest
{
    /**
     * Valida que visitantes não autenticados não conseguem acessar o checklist
     */
    public function testAcessoBloqueadoParaVisitanteNaoAutenticado(FunctionalTester $I): void
    {
        $I->wantTo('garantir que visitante sem login seja redirecionado para a tela de autenticação');
        $I->amOnPage(NovoEstagioChecklistPage::$URL);
        
        // Deve redirecionar para a tela de login
        $I->see('Cajuí');
        $I->seeElement('button[name="login-button"]');
    }

    /**
     * Valida que o aluno logado consegue visualizar as orientações e itens do checklist
     */
    public function testAlunoVisualizaChecklistComSucesso(FunctionalTester $I): void
    {
        $I->wantTo('verificar se o discente visualiza o checklist obrigatório de novo estágio');
        $loginPage = new LoginPage($I);
        $checklistPage = new NovoEstagioChecklistPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');

        $checklistPage->open();
        $I->seeResponseCodeIs(200);
        $I->see('Novo Estágio');
        $I->see('Caro(a) discente');
        $I->see('Verifique se as etapas abaixo já foram realizadas antes de prosseguir');
        $I->seeElement('form');
    }

    /**
     * Valida que tentar submeter com checklist incompleto não avança para a próxima etapa
     */
    public function testSubmissaoChecklistIncompletoNaoAvanca(FunctionalTester $I): void
    {
        $I->wantTo('garantir que submissão com itens pendentes não permita prosseguir');
        $loginPage = new LoginPage($I);
        $checklistPage = new NovoEstagioChecklistPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');

        $checklistPage->open();
        // Submete apenas 2 das 6 opções
        $checklistPage->submeterChecklist([
            'opcao1' => '1',
            'opcao2' => '1',
        ]);

        // Permanece na mesma tela de checklist
        $I->see('Novo Estágio');
        $I->see('Caro(a) discente');
        $I->seeElement('#confirm-btn');
        $I->dontSee('Procure nos campos abaixo o nome da instituição concedente');
    }

    /**
     * Valida que ao marcar todas as 6 opções e submeter, avança com sucesso para a seleção de instituição
     */
    public function testSubmissaoChecklistCompletoAvancaParaInstituicao(FunctionalTester $I): void
    {
        $I->wantTo('verificar avanço para seleção de instituição ao completar todo o checklist');
        $loginPage = new LoginPage($I);
        $checklistPage = new NovoEstagioChecklistPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');

        $checklistPage->open();
        $checklistPage->submeterChecklistCompleto();

        // Deve redirecionar para a página de seleção de instituição
        $I->seeResponseCodeIs(200);
        $I->see('Instituição Concedente');
        $I->see('Procure nos campos abaixo o nome da instituição concedente do seu estágio');
    }
}
