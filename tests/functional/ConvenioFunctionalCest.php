<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\ConvenioPage;

/**
 * Testes funcionais do módulo de Convênios de Estágio do Cajuí.
 */
class ConvenioFunctionalCest
{
    /**
     * Valida que visitantes não autenticados são impedidos de acessar a lista de convênios.
     */
    public function testAcessoBloqueadoParaVisitanteNaoAutenticado(FunctionalTester $I): void
    {
        $I->wantTo('garantir que visitante sem login seja redirecionado para a tela de autenticação');
        $convenioPage = new ConvenioPage($I);
        $convenioPage->openIndex();

        // Deve redirecionar para a tela de login
        $I->see('Cajuí');
        $I->seeElement('button[name="login-button"]');
    }

    /**
     * Valida que discente não possui permissão de acesso à gestão de convênios (RBAC).
     */
    public function testAcessoBloqueadoParaDiscente(FunctionalTester $I): void
    {
        $I->wantTo('verificar que discente não tem permissão para gerenciar convênios');
        $loginPage = new LoginPage($I);
        $convenioPage = new ConvenioPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');
        $convenioPage->openIndex();

        // O RBAC do Cajuí deve barrar o discente (retorna 403 Forbidden ou mensagem de acesso negado)
        $I->dontSee('Novo Convênio');
        $I->dontSee(ConvenioPage::$btnNovo);
    }

    /**
     * Valida que o Coordenador de Estágios acessa com sucesso o grid de convênios.
     */
    public function testCoordenadorEstagioAcessaListagemConvenios(FunctionalTester $I): void
    {
        $I->wantTo('verificar que o coordenador de estágio visualiza a lista e o grid de convênios');
        $loginPage = new LoginPage($I);
        $convenioPage = new ConvenioPage($I);

        $loginPage->loginAsCoordenadorEstagio();
        $convenioPage->openIndex();

        $I->seeResponseCodeIs(200);
        $I->see(ConvenioPage::$pageTitle);
        $I->seeElement(ConvenioPage::$gridContainer);
        $I->seeElement(ConvenioPage::$btnNovo);
    }

    /**
     * Valida que o Coordenador de Estágios acessa a tela de cadastro de novo convênio.
     */
    public function testCoordenadorEstagioAcessaFormularioCriacao(FunctionalTester $I): void
    {
        $I->wantTo('verificar renderização do formulário de criação de convênio com campos essenciais');
        $loginPage = new LoginPage($I);
        $convenioPage = new ConvenioPage($I);

        $loginPage->loginAsCoordenadorEstagio();
        $convenioPage->openCreate();

        $I->seeResponseCodeIs(200);
        $I->seeElement(ConvenioPage::$formId);
        $I->seeElement(ConvenioPage::$campoNome);
        $I->seeElement(ConvenioPage::$campoEmpresa);
        $I->seeElement(ConvenioPage::$btnSalvar);
    }

    /**
     * Valida que submeter o formulário de convênio vazio aciona a validação dos campos.
     */
    public function testValidacaoCamposObrigatoriosFormularioConvenio(FunctionalTester $I): void
    {
        $I->wantTo('garantir que submissão de formulário de convênio em branco não cria o registro');
        $loginPage = new LoginPage($I);
        $convenioPage = new ConvenioPage($I);

        $loginPage->loginAsCoordenadorEstagio();
        $convenioPage->openCreate();

        // Submete formulário em branco
        $I->click(ConvenioPage::$btnSalvar);

        // Deve permanecer na mesma página do formulário
        $I->seeElement(ConvenioPage::$formId);
    }
}
